<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Surroundings'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="surroundings form large-9 medium-8 columns content">
    <?= $this->Form->create($surrounding) ?>
    <fieldset>
        <legend><?= __('Add Surrounding') ?></legend>
        <?php
            echo $this->Form->control('type');
            echo $this->Form->control('coordinate_x');
            echo $this->Form->control('coordinate_y');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
