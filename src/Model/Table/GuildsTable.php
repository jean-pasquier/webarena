<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Guilds Model
 *
 * @property \App\Model\Table\FightersTable|\Cake\ORM\Association\HasMany $Fighters
 *
 * @method \App\Model\Entity\Guild get($primaryKey, $options = [])
 * @method \App\Model\Entity\Guild newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Guild[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Guild|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Guild patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Guild[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Guild findOrCreate($search, callable $callback = null, $options = [])
 */
class GuildsTable extends Table
{
    
    public function setFighterGuild($fid, $gid)
    {
        $fighter = TableRegistry::get('Fighters')->find()->where(['id' => $fid, 'current_health >' => 0])->first();
        $fighter->guild_id = $gid;
        return TableRegistry::get('Fighters')->save($fighter);    
    }
    public function getAllGuilds()
    {
        return $this->find()->toList();
    }
    
    public function getAllGuildFighters($fid, $gid)
    {
        return TableRegistry::get('Fighters')
            ->find()
            ->where([
                'guild_id' => $gid, 
                'id !=' => $fid,
                'current_health >' => 0
            ])
            ->toArray();
    }
    
    public function getAllGuildsFighters($gid)
    {
        return TableRegistry::get('Fighters')
            ->find()
            ->where([
                'guild_id' => $gid, 
                'current_health >' => 0
            ])
            ->toArray();
    }
    
    public function getGuildName($gid)
    {
        return $this->find()->select('name')->where(['id' => $gid])->first()['name'];
    }

    public function calculateGuildScores()
    {
        $guildScores = array();
        $guilds = $this->getAllGuilds();
        foreach($guilds as $guild)
        {            
            $guildScore = 0;
            $fighters = $this->getAllGuildsFighters($guild['id']);
            foreach($fighters as $fighter)
            {
                $guildScore += $fighter['xp'];
            }
            $guildScores[$guild['id']] = $guildScore;
        }
        return $guildScores;
    }
        
    public function sortGuilds()
    {
        $array = $this->calculateGuildScores();
        
        if(asort($array, SORT_DESC))
        {
            return array_reverse($array, true);
        }
    }
    
    public function getBestGuild()
    {
        $array = $this->sortGuilds();
        reset($array);
        return [key($array), current($array)];
    }
    
    public function getAllSortedGuilds()
    {
        $arr = $this->sortGuilds();
        $finalArray = array();
        foreach($arr as $gid => $score)
        {
            $guild = array();
            array_push($guild, $gid);
            array_push($guild, $this->getGuildName($gid));
            array_push($guild, $score);
            array_push($finalArray, $guild);
        }
        return $finalArray;
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

        $this->setTable('guilds');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Fighters', [
            'foreignKey' => 'guild_id'
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

        return $validator;
    }

    /**
     * Default validation rules.
     *
     * @param  array  $fighter_id.
     * @return list of guilds for each players
     */
}