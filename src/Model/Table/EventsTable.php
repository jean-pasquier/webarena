<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Events Model
 *
 * @method \App\Model\Entity\Event get($primaryKey, $options = [])
 * @method \App\Model\Entity\Event newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Event[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Event|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Event patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Event[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Event findOrCreate($search, callable $callback = null, $options = [])
 */
class EventsTable extends Table
{

	public function getDayEvents($fighter)
	{

		if($fighter) :
			return $this->find()->where(['dateDiff(NOW(), date) <' => 1,
			'abs(coordinate_x - ' . $fighter['coordinate_x'] . ') + abs(coordinate_y - ' . $fighter['coordinate_y'] . ') <=' => $fighter['skill_sight'],
			'abs(coordinate_x - ' . $fighter['coordinate_x'] . ') + abs(coordinate_y - ' . $fighter['coordinate_y'] . ') >=' => - $fighter['skill_sight']
			])->order(['date' => 'Desc'])->toList();
		else: return array();
		endif;
	}

	public function hasMove($fighter)
	{
		$fighter['name'] = $fighter['name'].' has move';

		$query = $this->query()
									->insert(['name', 'date', 'coordinate_x', 'coordinate_y'])
									->values($fighter)
									->execute();
	}

	public function MoveAndDie($fighter)
	{
		if($fighter['thing'] == 'W'):
			 $fighter['thing'] = 'monster';
	 	elseif($fighter['thing'] == 'T'):
			$fighter['thing'] = 'trap';
		endif;
		$fighter['name'] = $fighter['name'].' has move on a '. $fighter['thing']. ' and died';

		$query = $this->query()
									->insert(['name', 'date', 'coordinate_x', 'coordinate_y'])
									->values($fighter)
									->execute();
	}

	public function attackKilled($fighter)
	{
		$fighter['name'] = $fighter['name']. ' attacked '. $fighter['thing']. ' and killed it';
		$query = $this->query()
									->insert(['name', 'date', 'coordinate_x', 'coordinate_y'])
									->values($fighter)
									->execute();
	}

	public function attackFailed($fighter)
	{
		$fighter['name'] = $fighter['name']. ' failed his attack on '. $fighter['thing'] . '. ' . $fighter['thing'] . ' still have ' . $fighter['thing_life'] . ' life point.';
		$query = $this->query()
									->insert(['name', 'date', 'coordinate_x', 'coordinate_y'])
									->values($fighter)
									->execute();
	}

	public function attack($fighter, $succes = 1)
	{
		if($succes == 1)$fighter['name'] = $fighter['name']. ' attacked '. $fighter['thing'];
		if($succes == 3)$fighter['name'] = $fighter['name']. ' attacked '. $fighter['thing'] . ' with the help of his guild';
		
		$fighter['name'] = $fighter['name']  . '. ' . $fighter['thing'] . ' have now ' . $fighter['thing_life'] . ' life point.';
		$query = $this->query()
									->insert(['name', 'date', 'coordinate_x', 'coordinate_y'])
									->values($fighter)
									->execute();
	}

	public function newFighter($fighter)
	{
		$fighter['name'] = $fighter['name']. ' entered in the arena';
		$query = $this->query()
									->insert(['name', 'date', 'coordinate_x', 'coordinate_y'])
									->values($fighter)
									->execute();
	}

	public function leftGuild($fighter)
	{
		$fighter['name'] = $fighter['name']. ' left the guild : '. $fighter['guild'];
		$query = $this->query()
									->insert(['name', 'date', 'coordinate_x', 'coordinate_y'])
									->values($fighter)
									->execute();
	}

	public function joinGuild($fighter)
	{
		$fighter['name'] = $fighter['name']. ' join the guild : '. $fighter['guild'];
		$query = $this->query()
									->insert(['name', 'date', 'coordinate_x', 'coordinate_y'])
									->values($fighter)
									->execute();
	}

	public function createGuild($fighter)
	{
		$fighter['name'] = $fighter['name']. ' create the guild : '. $fighter['guild'];
		$query = $this->query()
									->insert(['name', 'date', 'coordinate_x', 'coordinate_y'])
									->values($fighter)
									->execute();
	}

	public function addScream($fighter)
	{
		$query = $this->query()
									->insert(['name', 'date', 'coordinate_x', 'coordinate_y'])
									->values($fighter)
									->execute();
		if($fighter) return true;
		else return false;
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

        $this->setTable('events');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->dateTime('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->integer('coordinate_x')
            ->requirePresence('coordinate_x', 'create')
            ->notEmpty('coordinate_x');

        $validator
            ->integer('coordinate_y')
            ->requirePresence('coordinate_y', 'create')
            ->notEmpty('coordinate_y');

        return $validator;
    }
}
