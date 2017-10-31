<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * Fighters Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Players
 * @property |\Cake\ORM\Association\BelongsTo $Guilds
 * @property |\Cake\ORM\Association\HasMany $Messages
 * @property |\Cake\ORM\Association\HasMany $Tools
 *
 * @method \App\Model\Entity\Fighter get($primaryKey, $options = [])
 * @method \App\Model\Entity\Fighter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Fighter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Fighter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Fighter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Fighter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Fighter findOrCreate($search, callable $callback = null, $options = [])
 */
class FightersTable extends Table
{

    public function getAllFighters($pid)
    {
		return $this->find()->where(['player_id' => $pid])->order(['current_health' => 'DESC', 'xp' => 'DESC'])->toList();
    }

    public function getEveryFighterAliveExecptOurs($pid, $select = array())
    {
      return $this->find()->select($select)->where(['player_id !=' => $pid, 'current_health >' => 0])->toList();
    }

    public function getFighter($fid, $select = array())
    {
      return $this->find()->select($select)->where(['id' => $fid])->toArray();
    }

    public function isFighterHere($x, $y)
    {
		return $this->find()
			->where(['current_health >' => 0, 'coordinate_x' => $x, 'coordinate_y' => $y])
			->count() > 0;
    }

    public function getSightArray($pid, $width, $heigth)
    {
		$array = array();

		for($i=0; $i<$heigth; $i++)
		{
			$cols = array();
			for($j=0; $j<$width; $j++)
			{
				array_push($cols, '');
			}
			array_push($array, $cols);
		}

		return $array;
    }


	//fill the array with datas : fighter, surrounding, ennemies
	public function fillSightArray($pid, $arr)
	{
		//fighter position
		$aFighter = $this->getAliveFighter($pid, ['player_id', 'coordinate_x', 'coordinate_y', 'skill_sight']);
		$arr[$aFighter['coordinate_y']][$aFighter['coordinate_x']] = 'M';

		//ennemies position
		$ennemies = $this->find()
			->select(['coordinate_x', 'coordinate_y'])
			->where([
				'player_id !=' => $aFighter['player_id'],
				'current_health >' => 0,
'abs(coordinate_x - ' . $aFighter['coordinate_x'] . ') + abs(coordinate_y - ' . $aFighter['coordinate_y'] . ') <=' => $aFighter['skill_sight'],
'abs(coordinate_x - ' . $aFighter['coordinate_x'] . ') + abs(coordinate_y - ' . $aFighter['coordinate_y'] . ') >=' => - $aFighter['skill_sight']
			]);

		foreach($ennemies as $ennemy)
			$arr[$ennemy['coordinate_y']][$ennemy['coordinate_x']]= 'E';

		//surroundings position
		$surr = TableRegistry::get('Surroundings')
			->find()
			->where([
				'type' => 'P',
'abs(coordinate_x - ' . $aFighter['coordinate_x'] . ') + abs(coordinate_y - ' . $aFighter['coordinate_y'] . ') <=' => $aFighter['skill_sight'],
'abs(coordinate_x - ' . $aFighter['coordinate_x'] . ') + abs(coordinate_y - ' . $aFighter['coordinate_y'] . ') >=' => - $aFighter['skill_sight']
			])
			->orWhere([
				'type' => 'H',
'abs(coordinate_x - ' . $aFighter['coordinate_x'] . ') + abs(coordinate_y - ' . $aFighter['coordinate_y'] . ') <=' => $aFighter['skill_sight'],
'abs(coordinate_x - ' . $aFighter['coordinate_x'] . ') + abs(coordinate_y - ' . $aFighter['coordinate_y'] . ') >=' => - $aFighter['skill_sight']
			]);

		foreach($surr as $sur)
			$arr[$sur['coordinate_y']][$sur['coordinate_x']] = $sur['type'];

		return $arr;
	}

	public function greyFarSquares($arr, $pos, $sight)
	{
		for($i=0; $i<count($arr); $i++)
		{
			for($j=0; $j<count($arr[$i]); $j++)
			{
				if(abs($j - $pos['coordinate_x']) + abs($i - $pos['coordinate_y']) > $sight['skill_sight'])
					$arr[$i][$j] = '.';
			}
		}

		return $arr;
	}


    //check if the player has remaining alive fighter
    public function hasAliveFighter($pid)
    {
		return $this->find()
			->where(['player_id' => $pid, 'current_health >' => 0])
			->count() > 0;
    }

	//return the selected data in argument
    public function getAliveFighter($pid, $select = array())
    {
        $pos = $this->find()
			->select($select)
			->where(['player_id' => $pid, 'current_health >' => 0])
			->first();
		if($pos == null)
			return $pos;
		return($pos->toArray());
    }

    //add guild id in the alive fighter of the player id
    public function addGuildintoFighter($pid, $gid)
    {
      $query = $this->find()
                    ->update()
                    ->set(['guild_id' => $gid])
                    ->where(['player_id' => $pid, 'current_health >' => 0])
                    ->execute();
    }

    public function getGuildintoFighter($pid)
    {
      $pos = $this->find()
      ->select('guild_id')
      ->where(['player_id' => $pid, 'current_health >' => 0])
      ->first();
    if($pos == null)
      return $pos;
    return($pos->toArray());
    }

    public function move($pid, $x, $y, $height, $width)
    {
        $Events = TableRegistry::get('Events');
        $Surroundings = TableRegistry::get('Surroundings');
        $fighter = $this->find()->where(['player_id' => $pid, 'current_health >' => 0])->first();
        $fighter_data = $fighter->toArray();
        $tempo_coord_x = $x + $fighter['coordinate_x'];
        $tempo_coord_y = $y + $fighter['coordinate_y'];




        if($tempo_coord_x >=0 && $tempo_coord_x < $width && $tempo_coord_y >=0 && $tempo_coord_y < $height )
        {
            //find surroundings
            $content = $Surroundings->find()
                     ->where(['coordinate_x'=>$tempo_coord_x,'coordinate_y'=>$tempo_coord_y]);

			//find ennemies
            $ennemies = $this->find()
                     ->where(['current_health >' => 0, 'coordinate_x' => $tempo_coord_x,'coordinate_y' => $tempo_coord_y]);

			//if there is neither surr and ennemy -> the fighter can move
            if ($content->count() == 0 && $ennemies->count() == 0)
            {
                $fighter->coordinate_x = $tempo_coord_x;
                $fighter->coordinate_y= $tempo_coord_y;
                $fighter_data['date'] = Time::now();
                $fighter_data['coordinate_x'] = $tempo_coord_x;
                $fighter_data['coordinate_y'] = $tempo_coord_y;
                $Events->hasMove($fighter_data);
                $this->save($fighter);
            }
			//else if the fighter encounters a trap or a monster -> he dies
            else if($content->count()>0 && ($content->first()->type =='W' or $content->first()->type =='T'))
            {
                $fighter->current_health = 0;
                $fighter_data['date'] = Time::now();
                $fighter_data['coordinate_x'] = $tempo_coord_x;
                $fighter_data['coordinate_y'] = $tempo_coord_y;
                $fighter_data['thing'] = $content->first()->type;
                $Events->MoveAndDie($fighter_data);
                $this->save($fighter);
            }
        }
    }

    public function attack($pid,$x,$y)
    {
        $Surroundings = TableRegistry::get('Surroundings');
        $Events = TableRegistry::get('Events');
        $fighter = $this->find()->where(['player_id' => $pid, 'current_health >' => 0])->first();
        $fighter_data = $fighter->toArray();
        $tempo_coord_x = $x + $fighter_data['coordinate_x'];
        $tempo_coord_y = $y + $fighter_data['coordinate_y'];
        $fighter_data['date'] = Time::now();
        $fighter_data['coordinate_x'] = $tempo_coord_x;
        $fighter_data['coordinate_y'] = $tempo_coord_y;
        $succes = 0;

        //  kill monsters
        $monster = $Surroundings->find()
                     ->where(['Type' => 'W','coordinate_x'=>$tempo_coord_x,'coordinate_y'=>$tempo_coord_y])
                     ->first();
        $potion = $Surroundings->find()
                ->where(['Type' => 'H','coordinate_x'=>$tempo_coord_x,'coordinate_y'=>$tempo_coord_y])
                ->first();
        if($monster)
        {
            $fighter_data['thing'] = 'a monster';
            $Events->attackKilled($fighter_data);
            $Surroundings->delete($monster);
            $succes=1;
        }
        if($potion)
        {
            $Surroundings->delete($potion);
            $succes=1;
            $fighter->current_health=$fighter['current_health']+3;
            if($fighter['current_health'] > $fighter['skill_health'])
            {
                $fighter->current_health = $fighter['skill_health'];
            }

            $this->save($fighter);
        }


        //fight with players
        $ennemy = $this->find()
                     ->where(['coordinate_x'=>$tempo_coord_x,'coordinate_y'=>$tempo_coord_y,'current_health >' => 0])
                     ->first();
        if($ennemy)
        {
            // on récupère le niveau de l'attaqué et le niveau de l'attaquant + calcul du seuil
            $seuil =10+$ennemy['level']-$fighter['level'];
            $fighter_data['thing'] = $ennemy->name;
            $dice = rand(0,20);

            if($dice > $seuil)
            {
                // on applique l'attaque à la vie de l'énemie
                $bonus_guild = $this
					->calcul_attack_bonus_guild($fighter['guild_id'], $fighter['id'], $tempo_coord_x, $tempo_coord_y);

				$ennemy->current_health = $ennemy['current_health']-$fighter['skill_strength']-$bonus_guild;
				$fighter_data['thing_life'] = $ennemy->current_health;

                if($ennemy->current_health <= 0)
                {
                  $Events->attackKilled($fighter_data);
                  $ennemy->current_health=0;
                  $fighter->xp=$fighter->xp+ $ennemy['level'];
                }
                else
                {
                   $fighter->xp=$fighter->xp+1;
                }
                $this->save($fighter);
                $this->save($ennemy);
                $succes=1;
                if($bonus_guild > 0)
                {
                    $succes=3;
                }
                $Events->attack($fighter_data, $succes);
            }
            else
            {
				$fighter_data['thing_life'] = $ennemy->current_health;
              $Events->attackFailed($fighter_data);
                //message d'échec`
                $succes=2;
            }
            // on détermine si l'attaque réussit
            // si elle fail on affiche un truc
        }
        return($succes); // 0 = rien 1 = succes 2 = parade
    }

    public function calcul_attack_bonus_guild($gid, $fid, $x, $y)
    {
      $res=$this->find('all')->where(['guild_id ='=>$gid,'id <>'=>$fid,'coordinate_x =' =>$x,'coordinate_y <>' => $y,'coordinate_y >=' =>($y-1),'coordinate_y <=' =>($y+1)])
                ->orWhere(['guild_id ='=>$gid,'id <>'=>$fid,'coordinate_y =' =>$y,'coordinate_x <>' => $x,'coordinate_x >=' =>($x-1),'coordinate_x <=' =>($x+1)]);
      return($res->count());

    }




    public function getBestFighter($where = array())
    {
		return $this->find()
			->order(['xp' => 'DESC'])
			->where($where)
			->first();
    }

    public function getFightersGuild($guild_id)
    {
      $query = $this->find()
                    ->select('name')
                    ->where(['guild_id' => $guild_id, 'current_health >' => 0])
                    ->toList();
      return $query;
    }


    public function gain_level($id,$sight,$strength,$health)
    {
        $fighter = $this->find()
                    ->select()
                    ->where(['id' => $id])->first();
        $fighter->skill_sight= $fighter['skill_sight']+$sight;
        $fighter->skill_strength= $fighter['skill_strength']+$strength;
        $fighter->skill_health= $fighter['skill_health']+$health;
        $fighter->current_health = $fighter['skill_health'];
        $fighter->level=$fighter['level']+1;
        $this->save($fighter);
    }


    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('fighters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Players', [
            'foreignKey' => 'player_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Guilds', [
            'foreignKey' => 'guild_id'
        ]);
        $this->hasMany('Messages', [
            'foreignKey' => 'fighter_id'
        ]);
        $this->hasMany('Tools', [
            'foreignKey' => 'fighter_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('coordinate_x')
            ->requirePresence('coordinate_x', 'create')
            ->notEmpty('coordinate_x');

        $validator
            ->integer('coordinate_y')
            ->requirePresence('coordinate_y', 'create')
            ->notEmpty('coordinate_y');

        $validator
            ->integer('level')
            ->requirePresence('level', 'create')
            ->notEmpty('level');

        $validator
            ->integer('xp')
            ->requirePresence('xp', 'create')
            ->notEmpty('xp');

        $validator
            ->integer('skill_sight')
            ->requirePresence('skill_sight', 'create')
            ->notEmpty('skill_sight');

        $validator
            ->integer('skill_strength')
            ->requirePresence('skill_strength', 'create')
            ->notEmpty('skill_strength');

        $validator
            ->integer('skill_health')
            ->requirePresence('skill_health', 'create')
            ->notEmpty('skill_health');

        $validator
            ->integer('current_health')
            ->requirePresence('current_health', 'create')
            ->notEmpty('current_health');

        $validator
            ->dateTime('next_action_time')
            ->allowEmpty('next_action_time');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['player_id'], 'Players'));
        $rules->add($rules->existsIn(['guild_id'], 'Guilds'));

        return $rules;
    }
}
