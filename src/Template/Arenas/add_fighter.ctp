<?php $this->assign('title', 'Add Fighter');?>

<h1><?= $this->fetch('title') ?></h1>

<div class="fighters form large-9 medium-8 columns content">
    <?= $this->Form->create($entity) ?>
    <fieldset>
        <?= $this->Form->control('name'); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
