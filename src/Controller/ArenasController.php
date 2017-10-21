<?php
namespace App\Controller;
use App\Controller\AppController;
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
		$width = 15;
		$heigh = 15;
		$sightArray = $this->Fighters->getSightArray();

	$this->set('xmax', $heigh);
        $this->set('ymax', $width);
	$this->set('sightArray', $sightArray);
        
        
        // get position 
        $pos= $this->Fighters->getPosition();
        $this->set('x',$pos['coordinate_x']);
        $this->set('y',$pos['coordinate_y']);   
        
       
        if ($this->request->is('post'))
        {
            if($this->request->data['dir'] == 'up')
            {
                $this->Fighters->move(0,1);
                $this->redirect(['action'=>'sight']);
            } 
            if($this->request->data['dir'] == 'down')
            {
                $this->Fighters->move(0,(-1));
                $this->redirect(['action'=>'sight']);


            }   
             if($this->request->data['dir'] == 'right')
            {
                $this->Fighters->move(1,0);
                $this->redirect(['action'=>'sight']);

            } 
            if($this->request->data['dir'] == 'left')
            {
              $this->Fighters->move((-1),0);
              $this->redirect(['action'=>'sight']);
            }   
        }


    }
    
    public function move()
    {
       $this->loadModel('Fighters');
       $this->Fighters->move_up();   
    } 
      
    public function fighter()
    {
        $this->loadModel('Fighters');
        $best = $this->Fighters->getBestFighter();
        $this->set('best', $best);
    }
    
    public function index()
    {
    }

    
    public function login()
    {
        
        
    }
    
    
	
    public function diary()
    {
        $this->set('mydiary', 'I love pizzas');
    }
	
		
    public function signup()
    {
        
    }
    
}
