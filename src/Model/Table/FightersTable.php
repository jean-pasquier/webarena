<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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


	public function getSightArray()
	{
		$width = 15;
		$height = 10;
		$array = array();
		$pid='545f827c-576c-4dc5-ab6d-27c33186dc3e';
		for($i=0; $i < $height; $i++)
		{
			$cols = array();
			for($j=0; $j< $width; $j++)
			{
				array_push($cols, '.');
			}
			array_push($array, $cols);
		}
		$res = $this->find()
						->select(['coordinate_x', 'coordinate_y'])
						->where(['player_id' => $pid]);
		foreach($res as $row)
		{
			$array[$row['coordinate_x']][$row['coordinate_y']]= 'M';
		}

		$res = $this->find()
						->select(['coordinate_x', 'coordinate_y'])
						->where(['player_id !=' => $pid]);
		foreach($res as $row)
		{
			$array[$row['coordinate_x']][$row['coordinate_y']]= 'E';
		}
		return $array;
	}



	public function getFighters($id)
	{
		return $this->find()->where(['player_id' => $id])->toList();
	}

	public function isFighterHere($x, $y)
	{
		return $this->find()
			->where(['current_health >' => 0, 'coordinate_x' => $x, 'coordinate_y' => $y])
			->count() > 0;
	}

	public function getFighterCoords($id)
	{
//		$res = $this->find()
//            ->select(['coordinate_x', 'coordinate_y'])
//			->where(['id' => $id]);
	}

	public function getSightArray()
	{
		$width = 15;
		$height = 10;
		$array = array();
		$pid='545f827c-576c-4dc5-ab6d-27c33186dc3e';
		for($i=0; $i < $height; $i++)
		{
			$cols = array();
			for($j=0; $j< $width; $j++)
			{
				array_push($cols, '.');
			}
			array_push($array, $cols);
		}
		$res = $this->find()
						->select(['coordinate_x', 'coordinate_y'])
						->where(['player_id' => $pid]);
		foreach($res as $row)
		{
			$array[$row['coordinate_x']][$row['coordinate_y']]= 'M';
		}

		$res = $this->find()
						->select(['coordinate_x', 'coordinate_y'])
						->where(['player_id !=' => $pid]);
		foreach($res as $row)
		{
			$array[$row['coordinate_x']][$row['coordinate_y']]= 'E';
		}
		return $array;
	}


    public function getPosition()
    {
        $id = '1';
        $query = $this->get($id,['fields'=>['coordinate_x', 'coordinate_y']]);
        //debug($query->toArray());
        return($query->toArray());
    }

    public function move($x,$y)
    {
        $id = '1';
        $fighter = $this->get($id);
        $fighter_data = $fighter->toArray();
        $fighter->coordinate_x=$x+$fighter_data['coordinate_x'];
        $fighter->coordinate_y=$y+$fighter_data['coordinate_y'];
        $this->save($fighter);
    }


    public function getBestFighter()
    {
      $res = $this->find()
              ->select(['name', 'xp', 'level'])
              ->order(['level' => 'DESC'])
              ->first();
              //->groupBy('level');
      //pr($res);
      $best = array();
      array_push($best, $res['name']);
      array_push($best, $res['xp']);
      array_push($best, $res['level']);
      return $best;
    }

    public function getDim()
    {
        $width_x = 15;
        $lenght_y = 10;
        $dim = array($width_x, $lenght_y);
        return $dim;
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
