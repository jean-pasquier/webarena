<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Messages Model
 *
 * @property \App\Model\Table\FightersTable|\Cake\ORM\Association\BelongsTo $Fighters
 *
 * @method \App\Model\Entity\Message get($primaryKey, $options = [])
 * @method \App\Model\Entity\Message newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Message[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Message|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Message patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Message[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Message findOrCreate($search, callable $callback = null, $options = [])
 */
class MessagesTable extends Table
{

    public function find_message($fighter_id, $fighter1_id = null)
    {
        if(!$fighter1_id):
            $query = $this->find()
                ->where(['fighter_id_from' => $fighter_id])
                ->orwhere(['fighter_id' => $fighter_id])
                ->order(['date' => 'DESC'])
                ->toList();
            return $query;
        else:
            $query = $this->find()
                ->where(['fighter_id_from' => $fighter_id, 'fighter_id' => $fighter1_id])
                ->orwhere(['fighter_id' => $fighter_id, 'fighter_id_from' => $fighter1_id])
                ->order(['date' => 'DESC'])
                ->toList();
            return $query;
        endif;
    }

    public function insert_message($data)
    {
      $query = $this->query()
                    ->insert(['date', 'title', 'message', 'fighter_id_from', 'fighter_id'])
                    ->values([
                      'date' => $data['date'],
                      'title' => $data['title'],
                      'message' => $data['message'],
                      'fighter_id_from' => $data['fighter_id_from'],
                      'fighter_id' => $data['fighter_id']
                    ])
                    ->execute();
      // <article class="panel <?=($fighter['current_health']==0)?'panel-danger':'panel-success';
      if($query):
        return true;
      else:
        return false;
      endif;
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

        $this->setTable('messages');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Fighters', [
            'foreignKey' => 'fighter_id',
            'joinType' => 'INNER'
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
            ->dateTime('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->scalar('title')
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmpty('message');

        $validator
            ->integer('fighter_id_from')
            ->requirePresence('fighter_id_from', 'create')
            ->notEmpty('fighter_id_from');

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
        $rules->add($rules->existsIn(['fighter_id'], 'Fighters'));

        return $rules;
    }
}
