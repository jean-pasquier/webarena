<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Tools'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Fighters'), ['controller' => 'Fighters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Fighter'), ['controller' => 'Fighters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tools form large-9 medium-8 columns content">
    <?= $this->Form->create($tool) ?>
    <fieldset>
        <legend><?= __('Add Tool') ?></legend>
        <?php
            echo $this->Form->control('type');
            echo $this->Form->control('bonus');
            echo $this->Form->control('coordinate_x');
            echo $this->Form->control('coordinate_y');
            echo $this->Form->control('fighter_id', ['options' => $fighters, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
