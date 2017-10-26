<?php $this->assign('title', 'Sight');?>

<h1><?= $this->fetch('title') ?></h1>


<?php if ($hasAliveFighter): ?>

<ul>
    <li>X= <?php echo $x ?></li>
    <li>Y= <?php echo $y ?></li>
    <li>Trap detect = <?php echo $trap_detect ?></li>
    <li>Monster detect = <?php echo $monster_detect ?></li>

</ul>

  
  <button class="button default-button" id="scream-btn">Scream</button> 
<?= $this->Form->create(); ?>
<div class="table-responsive">
  <table class="table">
    <tr>
      <td> </td>
      <td> <?= $this->Form->submit('UP',['class' => 'button','name'=>'dir']); ?> </td>
      <td> <?= $this->Form->submit('Regenerate surrondings',['class' => 'button','name'=>'dir']); ?></td>
    </tr>

    <tr>
      <td><?= $this->Form->submit('LEFT', ['class' => 'button', 'name'=>'dir']);?></td>
        <td><?= 'Attack : ' ;?> <?= $this->Form->checkbox('attack');?></td>
        <td><?= $this->Form->submit('RIGHT', ['class' => 'button', 'name'=>'dir']);?></td>
    </tr>

    <tr>
      <td> </td>
      <td> <?= $this->Form->submit('DOWN',['class' => 'button','name'=>'dir']); ?> </td>
      <?= $this->Form->end() ?>
      <td> </td>
    </tr>

  </table>
</div>


<div class="undisplayed scream form columns content col-md-6 col-md-offset-3" id="scream-form">
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->control('description', ['class' => 'input text']); ?>
        <?= $this->Form->hidden('SCREAM', ['value' => 'SCREAM']); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit', ['class' => 'btn btn-default'])) ?>
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
