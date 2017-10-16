<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tools Model
 *
 * @property \App\Model\Table\FightersTable|\Cake\ORM\Association\BelongsTo $Fighters
 *
 * @method \App\Model\Entity\Tool get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tool newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tool[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tool|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tool patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tool[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tool findOrCreate($search, callable $callback = null, $options = [])
 */
class ToolsTable extends Table
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

        $this->setTable('tools');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Fighters', [
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
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->integer('bonus')
            ->requirePresence('bonus', 'create')
            ->notEmpty('bonus');

        $validator
            ->integer('coordinate_x')
            ->allowEmpty('coordinate_x');

        $validator
            ->integer('coordinate_y')
            ->allowEmpty('coordinate_y');

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
