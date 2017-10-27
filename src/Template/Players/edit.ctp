<h1>Set account</h1>

<div class="players form col-md-6 col-md-offset-3 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <p>You can change your password or email here</p>
        <?php
            echo $this->Form->control('email');
            echo $this->Form->control('password');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
