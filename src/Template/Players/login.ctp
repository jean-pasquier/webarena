<h1>Please login</h1>

<div class="players form col-md-6 col-md-offset-3 columns content">
	<?= $this->Form->create(); ?>
	<?= $this->Form->control('email'); ?>
	<?= $this->Form->control('password'); ?>
	<?= $this->Form->button('Connexion'); ?>
	<?= $this->Form->end(); ?>
</div>
