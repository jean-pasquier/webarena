<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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
    public function find_guild(array $fighters = null)
    {
      if($fighters)
      {
        $res = array();
        foreach($fighters as $fighter)
        {
          $query = $this->find()
                        ->join([
                          'table' => 'fighters',
                          'alias' => 'f',
                          'type' => 'LEFT',
                          'conditions' => 'f.guild_id = guilds.id',
                        ])
                        ->where(['f.id' => $fighter[0]])
                        ->toArray();

          if($query) $query['fighter_name'] = $fighter[1];
          array_push($res, $query);
        }
        return $res;
      }
      return false;

    }

    public function getAllGuilds()
    {
      $query = $this->find()
                    ->toList();
      return $query;
    }
}
