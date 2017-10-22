<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Surroundings Model
 *
 * @method \App\Model\Entity\Surrounding get($primaryKey, $options = [])
 * @method \App\Model\Entity\Surrounding newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Surrounding[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Surrounding|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Surrounding patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Surrounding[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Surrounding findOrCreate($search, callable $callback = null, $options = [])
 */
class SurroundingsTable extends Table
{
	//check if there is something at ($x, $y) neather fighter or existing surrounding in db
	public function isEmptySquare($x, $y)
	{
		return $this->find()
			->where(['coordinate_x' => $x, 'coordinate_y' => $y])
			->count() > 0 || TableRegistry::get('Fighters')->find()
			->where(['current_health >' => 0, 'coordinate_x' => $x, 'coordinate_y' => $y])
			->count() > 0;
	}

	//check if there is something at ($x, $y) neather fighter or local existing surrounding
	public function alreadyHere($mySurr, $x, $y)
	{
		foreach ($mySurr as $row)
		{
			if($row[1] == $x && $row[2] == $y)
				return true;
		}
		
		$Fighters = TableRegistry::get('Fighters');
//		$this->loadModel('Fighters');
		if ($Fighters->isFighterHere($x, $y))
			return true;
			
		return false;
	}

	//regenerate a surrounding array : [type, x, y]
	public function generate(array $array, $width, $heigth)
	{		
		//delete all the surroundings
		$this->deleteAll([]);
		
		$pnbr = $width * $heigth / 10;
		$tnbr = $width * $heigth / 10;
		$mnbr = 1;

		$mySurr = array();
		
		//Generate P
		for($i=0; $i < $pnbr; $i++)
		{
			$coord = $this->calculateRandomCoord($mySurr, $width - 1, $heigth - 1);		
			
			$temparr = array();
			array_push($temparr, 'P');
			array_push($temparr, $coord[0]);
			array_push($temparr, $coord[1]);
			
			array_push($mySurr, $temparr);
		}
		
		//Generate T
		for($i = 0; $i < $tnbr; $i++)
		{		
			$coord = $this->calculateRandomCoord($mySurr, $width - 1, $heigth - 1);		

			$temparr = array();
			array_push($temparr, 'T');
			array_push($temparr, $coord[0]);
			array_push($temparr, $coord[1]);
			
			array_push($mySurr, $temparr);
		}
		
		//generate M
		for($i = 0; $i < $mnbr; $i++)
		{
			$coord = $this->calculateRandomCoord($mySurr, $width - 1, $heigth - 1);		

			$temparr = array();
			array_push($temparr, 'W');
			array_push($temparr, $coord[0]);
			array_push($temparr, $coord[1]);

			array_push($mySurr, $temparr);
		}

		//add all the surroundings in the table and in the array
		foreach($mySurr as $row)
		{
			$array[$row[2]][$row[1]] = $row[0];
			$new = $this->newEntity();
			$new->type = $row[0];
			$new->coordinate_x = $row[1];
			$new->coordinate_y = $row[2];
			$this->save($new);
		}
		return $array;
	}

	//check if surrounding exists
	public function check(array $array, $width, $heigth)
	{
		$res = $this->find('all')->select(['type', 'coordinate_x', 'coordinate_y']);
		
		//if no surrounding
		if($res->count() == 0)
		{
			$array = $this->generate($array, $width, $heigth);
		}
		else
		{
			foreach($res as $row)
			{
				$array[$row['coordinate_y']][$row['coordinate_x']] = $row['type'];
			}
		}
		return $array;
	}
        
        //detect if there is a trap around the position x and y 
        public function detect_trap($x,$y,$type)
        {
          /*$res=$this->find('all')->where(['coordinate_x >=' =>($x-1),
               'coordinate_x <=' =>($x+1),'coordinate_y >=' =>($y-1),'coordinate_y <=' =>($y+1),'type ='=>'T'])->count();
          */
           $res=$this->find('all')->where(['type ='=>$type,'coordinate_x =' =>$x,'coordinate_y >=' =>($y-1),'coordinate_y <=' =>($y+1)])
                                  ->orWhere(['type ='=>$type,'coordinate_y =' =>$y,'coordinate_x >=' =>($x-1),'coordinate_x <=' =>($x+1)]);
           return($res->count());
        }
	
        // allows to one element of the surronding to receive an attack
        public function get_attack($id,$x,$y)
        {
            
        }
        
	//calculate random coordinates checking if the square is empty
	public function calculateRandomCoord($arr, $xmax, $ymax)
	{
		do
		{
			$x = rand(0, $xmax);
			$y = rand(0, $ymax);
			
			//check is a element is already here
			$busy = $this->alreadyHere($arr, $x, $y);
		}
		while ($busy);
				
		return [$x, $y];		
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

        $this->setTable('surroundings');
        $this->setDisplayField('id');
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
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->notEmpty('type');

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
