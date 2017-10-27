<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace src/Template/Pages/home.ctp with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'WebArenas';
?>
<!DOCTYPE html>
<html>
    <head>
      <?= $this->Html->charset() ?>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>
          <?= $cakeDescription ?>:
          <?= $this->fetch('title') ?>
      </title>
      <?= $this->Html->meta('icon') ?>

      <?= $this->Html->css('base.css') ?>
      <?= $this->Html->css('cake.css') ?>
      <?= $this->Html->css('webarena.css') ?>
      <?= $this->Html->css('bootstrap.min.css') ?>
      <?= $this->Html->script(['jquery-3.2.1.min', 'bootstrap.min', 'script']) ?>

      <?= $this->fetch('meta') ?>
      <?= $this->fetch('css') ?>
      <?= $this->fetch('script') ?>
    </head>
    <body>
		<nav class="navbar navbar-inverse navbar-fixed-top container-fluid" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed mainnav-menu" data-toggle="collapse" data-target="#collapse-home" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar icon1"></span>
                        <span class="icon-bar icon2"></span>
                        <span class="icon-bar icon3"></span>
                    </button>
					<?= $this->Html->link('Home', '/', ['class' => 'navbar-brand']);?>
				</div>
                <ul class="nav navbar-nav  collapse navbar-collapse navbar-right" id="collapse-home">
                    <li><?php echo $this->Html->link('Login', ['controller' => 'Players', 'action' => 'login']);?></li>
                    <li><?php echo $this->Html->link('Signup', ['controller' => 'Players', 'action' => 'add']);?></li>
                </ul>
			</div>
		</nav>

        <div class="container">

            <?= $this->Html->image('arena-logo.png', ['class' => 'img-responsive center-block', 'alt' => 'arena-logo']); ?>

            <p class="text-justify font-size-large">
            In this game you will have to create a fighter by giving him a name and an avatar if you want.
            You will then control your fighter and fight the others fighters online or the monster you will meet in the arena (sight tab).
            The dimensions of the arena are 15x10 so you will have to fight if you want to survive!
            </p>

            <p class="text-justify font-size-large">
            Your fighter starts with the following characteristics: view = 2, force = 1, health = 5 and appears at a random position.
            </p>

            <p class="text-justify font-size-large">
            The view determines how far your fighter can see. Thus only the fighters and the elements of the scenery in range are displayed on the arena concerned.
            </p>

            <p class="text-justify">
            The force characteristic determines how much life loses your opponent when your fighter
            succeeds in its attack action.
            </p>

            <p class="text-justify">
            When your fighter sees his hit points reach 0, it is removed from the game. And your are invited to recreate a new one.
            </p>

            <p class="text-justify">
            Keep in mind that you have 50% of chance that your attack will succeed.
            </p>

            <p class="text-justify">
            Progression: with each successful attack your fighter gains 1 experience point. If the attack
            kills the opponent, your fighter gains as many points of experience as the level of the defeated
            opponent. All 4 points of experience, your fighter can change level and can choose to increase
            one of its characteristics: view +1 or force + 1 or health point +3. In case of progression of
            health, the maximum health points increase AND the current health points go up to
            maximum.
            </p>

            <p class="text-justify">
            Be careful, traps and monsters are invisible!
            You will see increase the counter of traps and monsters detectors when you will be one square away from them.
            </p>

            <p class="text-justify">
            You can join a guild as well and send message to all alive fighters. A guild permit you to gain +1 in force if you attak an ennemy within a guild teammate in your sight.
            </p>

            <p class="text-justify">
            Each action causes an event to be created with a clear description. For example: "jonh
            attacks bill and hits". All events are stored in the tab "Diary" but you can see only events that are in your sight.
            </p>


        </div>
        
        
        <footer class="footer">
            <section class="container-fluid">
                <h3 class="text-center">Group information</h3>
                <dl class="dl-horizontal">
                    <dt>Group :</dt>
                    <dd>SI05</dd>
                    <dt>Author :</dt>
                    <dd>
                        <ul class="list-unstyled">
                            <li>Benjamin Callonnec</li>
                            <li>Thomas Griseau</li>
                            <li>Etienne Meunier</li>
                            <li>Jean Pasquier</li>
                        </ul>
                    </dd>
                    <dt>Options :</dt>
                    <dd>
                        <ol class="list-unstyled">
                            <li>B - Communication &amp; guild options</li>
                            <li>D - Surroundings elements management</li>
                            <li>F - Responsive pages with Bootstrap</li>
                        </ol>
                    </dd>

                </dl>
            </section>
        </footer>

    </body>
</html>
