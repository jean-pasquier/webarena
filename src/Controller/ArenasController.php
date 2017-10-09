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
    public function index()
    {
        $this->loadModel('fighters');
        $figterlist=$this->fighters->find('all');
        //pr($figterlist->toArray());
    }
    
    
    public function fighter(){
        $this->loadModel('Fighters');
        $best = $this->Fighters->getBestFighter();
        $this->set('best', $best);
    }
    
    
    public function login()
    {
        
    }
    
    
    public function sight()
    {
    }
    
    
    public function diary()
    {
        $this->set('mydiary', 'I love pizzas');
    }
       
}
