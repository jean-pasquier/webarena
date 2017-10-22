<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
* Personal Controller
* User personal interface
*
*/
class ArenasController  extends AppController
{

    public function sight()
    {
        $this->loadModel('Fighters');
        $this->loadModel('Surroundings');
		
		$width = 15;
		$heigth = 10;

		$sightArray = $this->Fighters->getSightArray('545f827c-576c-4dc5-ab6d-27c33186dc3e', $width, $heigth);
        $sightArray = $this->Surroundings->check($sightArray, $width, $heigth);
        $pos = $this->Fighters->getPosition('545f827c-576c-4dc5-ab6d-27c33186dc3e');
		
		$this->set([
			'xmax' => $heigth,
			'ymax' => $width,
			'hasAliveFighter' => $this->Fighters->hasAliveFighter('545f827c-576c-4dc5-ab6d-27c33186dc3e'),
			'sightArray' => $sightArray,
			'x' => $pos['coordinate_x'],
			'y' => $pos['coordinate_y']
		]);
		

       
        if ($this->request->is('post'))
        {
            $x=0;
            $y=0;
            if($this->request->data['dir'] == 'UP')
            {
                $x=0;
                $y=(-1);
            }
            if($this->request->data['dir'] == 'DOWN')
            {
                $x=0;
                $y=1;
            }
             if($this->request->data['dir'] == 'RIGHT')
            {
                $x=1;
                $y=0;
            }
            if($this->request->data['dir'] == 'LEFT')
            {
              $x=(-1);
              $y=0;
            }
            $this->Fighters->move('545f827c-576c-4dc5-ab6d-27c33186dc3e',$x,$y,$sightArray,$heigth,$width);
            $this->redirect(['action'=>'sight']);
        }
    }






	public function fighter()
	{
	 	$this->loadModel('Fighters');
		
		$list = $this->Fighters->getFighters('545f827c-576c-4dc5-ab6d-27c33186dc3e');
	 	$this->set([
			'list' => $list,
			'hasAliveFighter' => $this->Fighters->hasAliveFighter('545f827c-576c-4dc5-ab6d-27c33186dc3e')
		]);
	}

    public function index()
    {
		
    }


    public function login()
    {


    }

    public function addFighter()
    {
            $width = 15;
            $heigth = 10;
            $this->loadModel('Fighters');
            $fighter = $this->Fighters->newEntity();
            $this->set('entity', $fighter);

            
        if ($this->request->is('post'))
		{
            $fighter = $this->Fighters->patchEntity($fighter, $this->request->getData());
			
			$fighter->player_id = '545f827c-576c-4dc5-ab6d-27c33186dc3e';
			do
			{
				$x = rand(0, $width);
				$y = rand(0, $heigth);
				$busy = $this->Fighters->isFighterHere($x, $y);
			}
			while($busy);

			$fighter->coordinate_x = $x;
			$fighter->coordinate_y = $y;
			$fighter->skill_health = 5;
			$fighter->current_health = 5;
			$fighter->skill_sight = 2;
			$fighter->skill_strength = 1;
			$fighter->level = 1;
			$fighter->xp = 0;

			
			if ($this->Fighters->save($fighter)) {
                $this->Flash->success(__('The fighter has been saved.'));
				
                return $this->redirect(['action' => 'fighter']);
            }
            $this->Flash->error(__('The fighter could not be saved. Please, try again.'));
            }

    }


    public function diary()
    {
		$this->loadModel('Events');
		$events = $this->Events->getDayEvents();
        $this->set('events', $events);
    }


    public function signup()
    {

    }

}
