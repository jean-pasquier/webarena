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

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><a href=""><?= $this->fetch('title') ?></a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
                <li><?php echo $this->Html->link('Home', ['controller' => 'Arenas', 'action' => '/']);?></li>
                <li><?php echo $this->Html->link('Fighters', ['controller' => 'Arenas', 'action' => 'fighter']);?></li>
                <li><?php echo $this->Html->link('Sight', ['controller' => 'Arenas', 'action' => 'sight']);?></li>
                <li><?php echo $this->Html->link('Diary', ['controller' => 'Arenas', 'action' => 'diary']);?></li>
                <li><?php echo $this->Html->link('Deconnexion', ['controller' => 'Players', 'action' => 'logout']);?></li>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
        <section>
            <h3>Group information</h3>
            <dl>
                <dt>Group :</dt>
                <dd>SI05</dd>
                <dt>Author :</dt>
                <dd>
                    <ul>
                        <li>Benjamin Callonnec</li>
                        <li>Thomas Griseau</li>
                        <li>Etienne Meunier</li>
                        <li>Jean Pasquier</li>
                    </ul>
                </dd>
                <dt>Options :</dt>
                <dd>
                    <ol>
                        <li>D - Setting elements management</li>
                        <li>F - Responsive pages with Bootstrap</li>
                    </ol>
                </dd>

            </dl>
        </section>
    </footer>
</body>
</html>
