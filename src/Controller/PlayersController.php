<?php
namespace App\Controller;

use App\Controller\AppController;

/**
* Players Controller
*
* @property \App\Model\Table\PlayersTable $Players
*
* @method \App\Model\Entity\Player[] paginate($object = null, array $settings = [])
*/
class PlayersController extends AppController
{

  /**
  * Index method
  *
  * @return \Cake\Http\Response|void
  */
  public function index()
  {
    $players = $this->paginate($this->Players);

    $this->set(compact('players'));
    $this->set('_serialize', ['players']);
  }

  public function login()
  {
    $this->loadModel('Players');
    if ($this->Auth->user('id')!= '')
    {
      return $this->redirect($this->Auth->redirectUrl());
    }
    $data=$this->request->getData();
    //Generae new password
    if ($this->request->is('post') && isset($data['newPassword']))
    {
      $email = $data['email'];
      if ($email) {
        $newPassword='';
        for ($i=0; $i<6; $i++)
        {
          $newPassword=$newPassword.chr(rand(97,122));
        }
        if ($this->Players->editPassword($newPassword, $email))
        {
          $this->Flash->success('Password: '. $newPassword);
        }
        else {
          $this->Flash->error('Your email is incorrect');
        }
      }

    }
    //login
    else if ($this->request->is('post')  && !isset($data['newPassword']))
    {
      $user = $this->Auth->identify();
      if ($user)
      {
        $this->Auth->setUser($user);
        return $this->redirect($this->Auth->redirectUrl());
      }
      $this->Flash->error('Your email or password is incorrect.');
    }
  }

  public function initialize()
  {
    parent::initialize();
    $this->Auth->allow(['logout', 'add']);
  }

  public function logout()
  {
    $this->Flash->success('You are disconnected.');
    return $this->redirect($this->Auth->logout());
  }

  /**
  * View method
  *
  * @param string|null $id Player id.
  * @return \Cake\Http\Response|void
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function view($id = null)
  {
    $player = $this->Players->get($id, [
      'contain' => ['Fighters']
    ]);

    $this->set('player', $player);
    $this->set('_serialize', ['player']);
  }



  /**
  * Add method
  *
  * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
  */
  public function add()
  {
    $player = $this->Players->newEntity();
    if ($this->request->is('post')) {
      $player = $this->Players->patchEntity($player, $this->request->getData());
      if ($this->Players->save($player)) {
        $this->Flash->success(__('The player has been saved.'));
        $this->Auth->setUser($player->toArray());
        return $this->redirect(['controller' => 'Arenas', 'action' => 'sight']);
      }
      $this->Flash->error(__('The player could not be saved. Please, try again.'));
    }
    $this->set(compact('player'));
    $this->set('_serialize', ['player']);
  }

  /**
  * Edit method
  *
  * @param string|null $id Player id.
  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null)
  {
    $player = $this->Players->get($id, [
      'contain' => []
    ]);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $player = $this->Players->patchEntity($player, $this->request->getData());
      if ($this->Players->save($player))
      {
        $this->Flash->success(__('The player has been saved.'));
        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The player could not be saved. Please, try again.'));
    }
    $this->set(compact('player'));
    $this->set('_serialize', ['player']);
  }

  /**
  * Delete method
  *
  * @param string|null $id Player id.
  * @return \Cake\Http\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null)
  {
    $this->loadModel('Fighters');
    $this->request->allowMethod(['post', 'delete']);
    $player = $this->Players->get($id);
    $this->Fighters->delete($Fighters->where(['player_id' => $player->id]));
    if ($this->Players->delete($player)) {
      $this->Flash->success(__('The player has been deleted.'));
    } else {
      $this->Flash->error(__('The player could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
  }
}
