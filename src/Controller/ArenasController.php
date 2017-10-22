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
		
		//check if the player has an active fighter
		$hasAliveFighter = $this->Fighters->hasAliveFighter($this->Auth->user('id'));
		$this->set('hasAliveFighter', $hasAliveFighter);

		if($hasAliveFighter)
		{
			$fid = $this->Fighters->getAliveFighter($this->Auth->user('id'), ['id']);

			$sightArray = $this->Fighters->getSightArray($this->Auth->user('id'), $width, $heigth);

			$sightArray = $this->Fighters->fillSightArray($this->Auth->user('id'), $fid, $sightArray);

			//$sightArray = $this->Surroundings->check($sightArray, $width, $heigth);
			$pos = $this->Fighters->getAliveFighter($this->Auth->user('id'), ['coordinate_x', 'coordinate_y']);
			
			$this->set([
				'xmax' => $heigth,
				'ymax' => $width,
				'sightArray' => $sightArray,
				'x' => $pos['coordinate_x'],
				'y' => $pos['coordinate_y']
			]);
			
			
			if ($this->request->is('post'))
			{
				if($this->request->data['dir'] == 'UP')
				{
					$x=0;
					$y=(-1);
				}
				else if($this->request->data['dir'] == 'DOWN')
				{
					$x=0;
					$y=1;
				}
				else if($this->request->data['dir'] == 'RIGHT')
				{
					$x=1;
					$y=0;
				}
				else if($this->request->data['dir'] == 'LEFT')
				{
					$x=(-1);
					$y=0;
				}
				else
				{
					$this->Flash->error(__('Cannot move the fighter. Please, try again.'));
				}
				$this->Fighters->move($this->Auth->user('id'), $x, $y, $sightArray, $heigth, $width);
				$this->redirect(['action'=>'sight']);
			}
		}
    }






	public function fighter()
	{
	 	$this->loadModel('Fighters');

		$list = $this->Fighters->getAllFighters($this->Auth->user('id'));
	 	$this->set([
			'list' => $list,
			'hasAliveFighter' => $this->Fighters->hasAliveFighter($this->Auth->user('id'))
		]);
	}

    public function index()
    {

    }


    public function addFighter()
    {
            $width = 15;
            $heigth = 10;
            $this->loadModel('Fighters');
            $this->loadModel('Surroundings');
            $fighter = $this->Fighters->newEntity();
            $this->set('entity', $fighter);


        if ($this->request->is('post'))
		{
            $fighter = $this->Fighters->patchEntity($fighter, $this->request->getData());

			$fighter->player_id = $this->Auth->user('id');
			do
			{
				$x = rand(0, $width - 1);
				$y = rand(0, $heigth - 1);
				$busy = $this->Surroundings->isEmptySquare($x, $y);
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


}
