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
    public function signup()
    {
        
    }
    
    
    public function fighter(){
        $this->loadModel('Fighters');
        $best = $this->Fighters->getBestFighter();
        $this->set('best', $best);
    }
    
    
    public function login()
    {
        
        $this->set('entity','');
        
    }
    
    
    public function sight()
    {
        $this->loadModel('Fighters');
        $dim = $this->Fighters->getDim();
        $this->set('width_x', $dim[0]);
        $this->set('lenght_y', $dim[1]);
    }
    
    
    public function diary()
    {
        $this->set('mydiary', 'I love pizzas');
    }
       
}
