<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $fighter->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $fighter->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Fighters'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="fighters form large-9 medium-8 columns content">
    <?= $this->Form->create($fighter) ?>
    <fieldset>
        <legend><?= __('Edit Fighter') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('player_id');
            echo $this->Form->control('coordinate_x');
            echo $this->Form->control('coordinate_y');
            echo $this->Form->control('level');
            echo $this->Form->control('xp');
            echo $this->Form->control('skill_sight');
            echo $this->Form->control('skill_strength');
            echo $this->Form->control('skill_health');
            echo $this->Form->control('current_health');
            echo $this->Form->control('next_action_time', ['empty' => true]);
            echo $this->Form->control('guild_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
