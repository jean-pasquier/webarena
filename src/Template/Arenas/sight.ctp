<?php $this->assign('title', 'Sight');?>

<h1><?= $this->fetch('title') ?></h1>

<?php if ($hasAliveFighter): ?>

<?php if($trap_detect) : ?>
<div class="panel panel-danger col-md-4 col-md-offset-4">
  <h5 class="panel-heading">Suspicious Break</h5>
</div>
<?php endif; ?>


<?php if($monster_detect) : ?>
<div class="panel panel-danger col-md-4 col-md-offset-4">
  <h5 class="panel-heading">Stink</h5>
</div>
<?php endif; ?>


<div class="col-xs-12 col-xs-offset-0">
	<div class="row">
		<button class='btn btn-primary col-xs-2 col-xs-offset-2' id="scream-btn">Scream</button>
		<?= $this->Form->create(); ?>
		<?= $this->Form->submit('Edit Surrondings', ['class' => 'btn btn-primary col-xs-2 col-xs-offset-4','name'=>'dir']); ?>
	</div>
	<div class="row">
		<?= $this->Form->submit('UP', ['class' => 'btn btn-primary col-xs-2 col-xs-offset-5','name'=>'dir']); ?> 
	</div>
	<div class="row">
		<?= $this->Form->submit('LEFT', ['class' => 'btn btn-primary col-xs-2 col-xs-offset-2', 'name'=>'dir']);?>
		<span class="col-xs-2 col-xs-offset-1 text-center"><?= 'Attack : ' ;?> <?= $this->Form->checkbox('attack');?></span>
		<?= $this->Form->submit('RIGHT', ['class' => 'btn btn-primary col-xs-2 col-xs-offset-1', 'name'=>'dir']);?>
	</div>
	<div class="row">
		<?= $this->Form->submit('DOWN',['class' => 'btn btn-primary col-xs-2 col-xs-offset-5','name'=>'dir']); ?> 
	</div>
	
	<?= $this->Form->end() ?>

</div>


<div class="undisplayed scream form columns content col-md-6 col-md-offset-3" id="scream-form">
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->control('description', ['class' => 'input text']); ?>
        <?= $this->Form->hidden('SCREAM', ['value' => 'SCREAM']); ?>
    </fieldset>
    <?= $this->Form->submit('Submit', ['class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>

<table class="table table-bordered table-responsive">
	<tbody>
		<?php foreach ($sightArray as $row): ?>
		<tr>
			<?php foreach ($row as $square): ?>
			<td><?= $square ?></td>
			<?php endforeach; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif;?>

<?php if (!$hasAliveFighter) : ?>
<div class="alert alert-danger col-md-6 col-md-offset-3">
	<h4>You do not have alive fighter or all of them are dead...</h4>
	<p><?= $this->Html->link('Create a new fighter', ['action' => 'fighter']); ?>
	</p>
</div>
<?php endif; ?>
