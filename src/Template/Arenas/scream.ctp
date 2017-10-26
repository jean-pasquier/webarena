<?php $this->assign('title', 'Scream');?>

<h1><?= $this->fetch('title') ?></h1>

<div class="scream form columns content col-md-6 col-md-offset-3">
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->control('description', ['class' => 'input text']); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit', ['class' => 'btn btn-default'])) ?>
    <?= $this->Form->end() ?>
</div>
