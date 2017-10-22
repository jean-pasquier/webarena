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
            <?= $cakeDescription ?>
        </title>

        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->css('base.css') ?>
        <?= $this->Html->css('cake.css') ?>
        <?= $this->Html->css('home.css') ?>
    	<?= $this->Html->css('bootstrap.min.css') ?>
    	<?= $this->Html->css('webarena.css') ?>
        <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
    </head>
    <body>
		<nav class="navbar navbar-inverse navbar-fixed-top container-fluid" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<?= $this->Html->link('Home', '/', ['class' => 'navbar-brand']);?>
				</div>
				<div>
					<ul class="nav navbar-nav navbar-right">
                    <li><?php echo $this->Html->link('Login', ['controller' => 'Players', 'action' => 'login']);?></li>
                    <li><?php echo $this->Html->link('Signup', ['controller' => 'Players', 'action' => 'add']);?></li>
					</ul>
				</div>


			</div>
		</nav>



    </body>
</html>
