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
        $this->loadModel('Surroundings');
		    $width = 15;
		    $height = 10;
        $sightArray = $this->Fighters->getSightArray();
        $sightArray=$this->Surroundings->check($sightArray, $width, $height);
		    $this->set('xmax', $height);
        $this->set('ymax', $width);
		    $this->set('sightArray', $sightArray);

//		pr($this->Fighters->getFighterCoord(0));
    }



    public function fighter(){
        $this->loadModel('Fighters');
        $best = $this->Fighters->getBestFighter();
        $this->set('best', $best);
    }

	public function index()
	{
        $this->set('hello','Hello Mamene');
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
