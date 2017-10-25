<?php $this->assign('title', 'Add Fighter');?>

<h1><?= $this->fetch('title') ?></h1>

<div class="fighters form columns content col-md-6 col-md-offset-3">
    <?= $this->Form->create($entity, ['enctype' => 'multipart/form-data']) ?>
    <fieldset>
        <?= $this->Form->control('name'); ?>
        <?= $this->Form->file('submittedfile', ['accept' => 'image/*']); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit', ['class' => 'btn btn-default'])) ?>
    <?= $this->Form->end() ?>
</div>
