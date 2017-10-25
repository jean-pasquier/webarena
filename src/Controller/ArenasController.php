<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

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
        $this->loadModel('Events');
        $width = 15;
		$heigth = 10;
        $trap_detect = 0;
        $monster_detect = 0;

        //check if the player has an active fighter
        $hasAliveFighter = $this->Fighters->hasAliveFighter($this->Auth->user('id'));
        $this->set('hasAliveFighter', $hasAliveFighter);

        if($hasAliveFighter)
        {
			$this->Surroundings->checkToGenerate($width, $heigth);

           	$sightArray = $this->Fighters->getSightArray($this->Auth->user('id'), $width, $heigth);
			$sightArray = $this->Fighters->fillSightArray($this->Auth->user('id'), $sightArray);

	   		$pos = $this->Fighters->getAliveFighter($this->Auth->user('id'), ['coordinate_x', 'coordinate_y']);

            $trap_detect = $this->Surroundings->detect_trap($pos['coordinate_x'],$pos['coordinate_y'],'T');
            $monster_detect = $this->Surroundings->detect_trap($pos['coordinate_x'],$pos['coordinate_y'],'W');


            $this->set([
                    'xmax' => $heigth,
                    'ymax' => $width,
                    'hasAliveFighter' => $this->Fighters->hasAliveFighter($this->Auth->user('id')),
                    'sightArray' => $sightArray,
                    'x' => $pos['coordinate_x'],
                    'y' => $pos['coordinate_y'],
                    'trap_detect' =>$trap_detect,
                    'monster_detect' =>$monster_detect
                    ]);



            if ($this->request->is('post'))
            {
                $x=0;
                $y=0;
                if($this->request->data['dir'] == 'Regenerate surrondings')
                {
                    $this->Surroundings->generate($width, $heigth);
                }
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
                if($this->request->data['attack']==True)
                {
                    $succes_attack=$this->Fighters->attack($this->Auth->user('id'),$x,$y);
                    if($succes_attack == 0)
                    {
                       $this->Flash->success('Failure');//0 rien 1 succes 2 parade

                    }
                    if($succes_attack == 1)
                    {
                       $this->Flash->success('Succes ! ');//0 rien 1 succes 2 parade

                    }
                    if($succes_attack == 2)
                    {
                        $this->Flash->success('Parade !  Ahah ');//0 rien 1 succes 2 parade

                    }
                }
                else
                {
                    $this->Fighters->move($this->Auth->user('id'),$x,$y,$sightArray,$heigth,$width);
                }
                $this->redirect(['action'=>'sight']);
            }
        }
    }

	public function fighter()
	{
	 	$this->loadModel('Fighters');
                
                $skill_credits=0;
                $sight=0;
                $strength=0;
                $health=0;


                $hasAliveFighter= $this->Fighters->hasAliveFighter($this->Auth->user('id'));
                if($hasAliveFighter)
                {
                    $current_fighter= $this->Fighters->getAliveFighter($this->Auth->user('id'));
                    $skill_credits=(int)($current_fighter['xp']/4-$current_fighter['level']+1);
                    
                    if($this->request->is('post'))
                    {
                       if($skill_credits > 0)
                       {
                           if($this->request->data['skill'] == 'Sight')
                           {
                               $sight=1;
                               $this->Flash->success('Upgraded Sight ! ');//0 rien 1 succes 2 parade
                           }
                           if($this->request->data['skill'] == 'Strength')
                           {
                                $strength=1;
                                $this->Flash->success('Upgraded Strenght ! ');//0 rien 1 succes 2 parade
                           }
                           if($this->request->data['skill'] == 'Health')
                           {
                               $health=3;
                               $this->Flash->success('Upgraded Health ! ');//0 rien 1 succes 2 parade

                           }
                           $this->Fighters->gain_level($current_fighter['id'],$sight,$strength,$health);
                       }
                       else
                       {
                           $this->Flash->success('Not enough skill points  ! ');//0 rien 1 succes 2 parade                          
                           
                       }
                       $this->redirect(['action'=>'fighter']);


                       
                    }
                }
               

		$list = $this->Fighters->getAllFighters($this->Auth->user('id'));
	 	$this->set([
			'list' => $list,
			'hasAliveFighter' => $hasAliveFighter,
                        'skill_credits'=>$skill_credits
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
            $this->loadModel('Events');
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
      $fighter_data = $fighter->toArray();
      $fighter_data['date'] = Time::now();
      $this->Events->newFighter($fighter_data);

			if ($this->Fighters->save($fighter))
			{
                move_uploaded_file($this->request->data['submittedfile']['tmp_name'], WWW_ROOT.'/img/avatars/'.$fighter->id.'.jpg');
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

    public function guild($param = null)
    {
        $this->loadModel('Fighters');
        $this->loadModel('Guilds');
        $this->loadModel('Messages');

        $fid = $this->Fighters->getAliveFighter($this->Auth->user('id'), ['id'])['id'];
        $gid = $this->Fighters->getAliveFighter($this->Auth->user('id'), ['guild_id'])['guild_id'];

        //if the fighter has a guild
        if($gid != '')
        {
            $guild = $this->Guilds->getGuildName($gid);
            $fighters = $this->Guilds->getAllGuildFighters($fid, $gid);
            $this->set([
                'hasGuild' => true,
                'guildFighters' => $fighters,
                'guild' => $guild
            ]);

            if($this->request->is('post'))
            {
                $data = $this->request->getData();
                pr($data);

                if(isset($data['fighter_id']))
                {

                    $msg = $this->Messages->newEntity();
                    $msg->title = $data['title'];
                    $msg->message = $data['message'];
                    $msg->fighter_id_from = $fid;
                    $msg->fighter_id = $data['fighter_id'];

                    if($this->Messages->save($msg))
                    {
                        $this->Flash->success(__('Message sent.'));
                        return $this->redirect(['action' => 'guild']);
                    }

                    $this->Flash->error(__('Message not sent. Please, try again.'));
                }
                else
                {
                    if($this->Guilds->setFighterGuild($fid, NULL))
                    {
                        $this->Flash->success(__('Guild left'));
                        return $this->redirect(['action' => 'guild']);
                    }

                    $this->Flash->error(__('Could not leave the guild. Please, try again.'));
                }


            }
        }

        //else show all guilds
        else
        {
            $this->set([
                'hasGuild' => false,
                'guilds' => $this->Guilds->getAllGuilds()
            ]);

            if($param)
            {
                $entity = $this->Fighters->get($fid);
                $entity->guild_id = $param;

                if($this->Fighters->save($entity))
                {
                    $this->Flash->success(__('Your fighter joined the team.'));
                    return $this->redirect(['action' => 'guild']);
                }

                $this->Flash->error(__('The fighter could not join the guild. Please, try again.'));
            }

            if($this->request->is('post'))
            {
                $newGuild = $this->Guilds->newEntity();
                $newGuild->name = $this->request->getData()['name'];

                if ($this->Guilds->save($newGuild))
                {
                    $this->Flash->success(__('The guild has been saved.'));

                    $this->Guilds->setFighterGuild($fid, $newGuild->id);

                    return $this->redirect(['action' => 'guild']);
                }

                $this->Flash->error(__('The guild could not be saved. Please, try again.'));
            }
        }
    }


    public function messages($fighter_player_id = null)
    {
      $bool = true;
      $this->loadModel('Messages');
      $this->loadModel('Fighters');
      $entity = $this->Messages->newEntity();
      $fres = array();
      $fid = $this->Fighters->getAliveFighter($this->Auth->user('id'), 'id');
      $fid1 = $this->Fighters->getAliveFighter($fighter_player_id, 'id');
      if(!$fighter_player_id):
        $messages = $this->Messages->find_message($fid['id']);
        foreach($messages as $message):
          $temp =  $this->Fighters->getFighter($message['fighter_id_from'], 'name');
          $message['fighter_name_from'] = $temp[0]['name'];
          $temp = $this->Fighters->getFighter($message['fighter_id'], 'name');
          $message['fighter_name'] = $temp[0]['name'];
        endforeach;
      else:
        $bool = false;
        $messages = $this->Messages->find_message($fid['id'], $fid1['id']);
        foreach($messages as $message):
          $temp =  $this->Fighters->getFighter($message['fighter_id_from'], 'name');
          $message['fighter_name_from'] = $temp[0]['name'];
          $temp = $this->Fighters->getFighter($message['fighter_id'], 'name');
          $message['fighter_name'] = $temp[0]['name'];
        endforeach;
      endif;
      $fighters = $this->Fighters->getEveryFighterAliveExecptOurs($this->Auth->user('id'), ['id', 'name', 'player_id']);
      foreach($fighters as $fighter):
        array_push($fres, $fighter['name']);
      endforeach;
      if($this->request->is('post'))
      {
        if(!$fighter_player_id):
          $req = array();
          $data = $this->request->getData();
          $req['date'] =  Time::now();
          $req['title'] = $data['title'];
          $req['message'] = $data['message'];
          $req['fighter_id_from'] = $fid['id'];
          $req['fighter_id'] = $fighters[$data['fighters_name']]->id;
          if($this->Messages->insert_message($req)):
            $this->Flash->success(__('The message has been saved.'));
             return $this->redirect(['action' => 'messages']);
           else:
              $this->Flash->error(__('The message could not be saved. Please, try again.'));
          endif;

        else:
          $req = array();
          $data = $this->request->getData();
          $req['date'] =  Time::now();
          $req['title'] = $data['title'];
          $req['message'] = $data['message'];
          $req['fighter_id_from'] = $fid['id'];
          $req['fighter_id'] = $fid1['id'];
          if($this->Messages->insert_message($req)):
            $this->Flash->success(__('The message has been saved.'));
             return $this->redirect(['action' => 'messages/'.$fighter_player_id]);
           else:
              $this->Flash->error(__('The message could not be saved. Please, try again.'));
          endif;
        endif;
      }
      $this->set('bool', $bool);
      $this->set('fid', $fid['id']);
      $this->set('fighters', $fres);
      $this->set('fighters_id', $fighters);
      $this->set('messages', $messages);
      $this->set('entity', $entity);
    }


}
