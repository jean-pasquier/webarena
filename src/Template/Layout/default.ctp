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
				<button type="button" class="navbar-toggle collapsed mainnav-menu" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar icon1"></span>
					<span class="icon-bar icon2"></span>
					<span class="icon-bar icon3"></span>
				</button>
				<?= $this->Html->link('Home', '/', ['class' => 'navbar-brand']);?>
			</div>
			<div class="collapse navbar-collapse" id="collapse">
				<ul class="nav navbar-nav">
					<li><?php echo $this->Html->link('Home', ['controller' => 'Arenas', 'action' => '/']);?></li>
					<li><?php echo $this->Html->link('Fighters', ['controller' => 'Arenas', 'action' => 'fighter']);?></li>
					<li><?php echo $this->Html->link('Sight', ['controller' => 'Arenas', 'action' => 'sight']);?></li>
					<li><?php echo $this->Html->link('Diary', ['controller' => 'Arenas', 'action' => 'diary']);?></li>
					<li><?php echo $this->Html->link('Deconnexion', ['controller' => 'Players', 'action' => 'logout']);?></li>
				</ul>
			</div>
			
		
		</div>
    </nav>
	
	
    <?= $this->Flash->render() ?>
    <div class="container clearfix" style="padding-top: 60px;">
        <?= $this->fetch('content') ?>
    </div>
	
    <footer class="footer">
        <section>
            <h3>Group information</h3>
            <dl>
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
                        <li>D - Setting elements management</li>
                        <li>F - Responsive pages with Bootstrap</li>
                    </ol>
                </dd>

            </dl>
        </section>
    </footer>
	
</body>
</html>
