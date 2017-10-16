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
    }
    
    
    public function diary()
    {
        $this->set('mydiary', 'I love pizzas');
    }
       
}
