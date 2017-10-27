<h1>Please login</h1>

<div class="players form col-md-6 col-md-offset-3 columns content">
	<?= $this->Form->create(); ?>
	<?= $this->Form->control('email'); ?>
	<?= $this->Form->control('password'); ?>
	<?= $this->Form->button('Connexion'); ?>
	<?= $this->Form->end(); ?>
	<button class="default-button" id="new-password-btn">Forgot password ?</button>
</div>
<div class="form col-md-6 col-md-offset-3 content undisplayed" id='new-password-form'>
	<?= $this->Form->create(); ?>
	<?= $this->Form->control('email'); ?>
	<?= $this->Form->hidden('newPassword', ['class' => 'undisplayed', 'value' => 'newPassword']); ?>
	<?= $this->Form->button('Generate new password', ['action' => 'login(); return false;']); ?>
	<?= $this->Form->end(); ?>
</div>
