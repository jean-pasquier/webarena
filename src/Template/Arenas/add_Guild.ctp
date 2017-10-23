<?php $this->assign('title', 'Create Guild');?>

<h1><?= $this->fetch('title') ?></h1>

<div class="guilds form large-9 medium-8 columns content">
    <?= $this->Form->create($entity) ?>
    <fieldset>
        <?= $this->Form->control('name'); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
