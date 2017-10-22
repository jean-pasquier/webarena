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

  public function alreadyHere($mySurr, $x, $y)
  {
    $temp=false;
    foreach ($mySurr as $row) {
      if ($row[1]==$x && $row[2]==$y)
        {$temp=true;}
    }
    $fighters = TableRegistry::get('Fighters');
    $res=$fighters->find()->where(['coordinate_x' => $x,  'coordinate_y' => $y])->count();
    if ($res!=0)
    {$temp=true;}
    return $temp;
  }

  public function generate(array $array, $width, $height)
  {
    //First we need to delete all the surroundings
    $this->deleteAll([]);
    //Then generate some new surroundings
    $mySurr=array();
    //Generate col
    for($i=0; $i<$width*$height/10; $i++)
    {
        $x=0;
        $y=0;
      do {
        $x=rand(0,9);
        $y=rand(0,14);
        //check is a element is already here
        $temp=$this->alreadyHere($mySurr, $x, $y);
        //temp will be false if nothing is here or true if something is here
      } while ($temp);
      $temparr=array();
      array_push($temparr, 'P');
      array_push($temparr, $x);
      array_push($temparr, $y);
      array_push($mySurr, $temparr);
    }
    //Generate piege
    for($i=0; $i<$width*$height/10; $i++)
    {
        $x=0;
        $y=0;
      do {
        $x=rand(0,9);
        $y=rand(0,14);
        //check is a element is already here
        $temp=$this->alreadyHere($mySurr, $x, $y);
        //temp will be false if nothing is here or true if something is here
      } while ($temp);
      $temparr=array();
      array_push($temparr, 'T');
      array_push($temparr, $x);
      array_push($temparr, $y);
      array_push($mySurr, $temparr);
    }
    //generate monster
    $x=0;
    $y=0;
    do {
      $x=rand(0,9);
      $y=rand(0,14);
      //check is a element is already here
      $temp=$this->alreadyHere($mySurr, $x, $y);
      //temp will be false if nothing is here or true if something is here
    } while ($temp);
    $temparr=array();
    array_push($temparr, 'W');
    array_push($temparr, $x);
    array_push($temparr, $y);
    array_push($mySurr, $temparr);
    //add all the surroundings in the table and in the array
    foreach($mySurr as $row)
    {
      $array[$row[1]][$row[2]]=$row[0];
      $new=$this->newEntity();
      $new->type=$row[0];
      $new->coordinate_x=$row[1];
      $new->coordinate_y=$row[2];
      $this->save($new);
    }
    return $array;
  }


  public function check(array $array, $width, $height)
  {
      $res=$this->find('all')->select(['type', 'coordinate_x', 'coordinate_y']);
      if($res->count()==0)
      {
        $array=$this->Generate($array,$width,$heights);
      }
      else {
                    foreach($res as $row)
                    {
                            $array[$row['coordinate_x']][$row['coordinate_y']]=$row['type'];
                    }
      }
      return $array;
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
