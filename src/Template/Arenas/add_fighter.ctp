
<div class="fighters form large-9 medium-8 columns content">
    <?= $this->Form->create($entity) ?>
    <fieldset>
        <legend><?= __('Add Fighter') ?></legend>
        <?php
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
