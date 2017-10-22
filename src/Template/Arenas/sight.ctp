<?php $this->assign('title', 'Sight');?>

<h1><?= $this->fetch('title') ?></h1>


<?php if ($hasAliveFighter): ?>

<ul>
    <li>X= <?php echo $x ?></li>
    <li>Y= <?php echo $y ?></li>
</ul>

<?php 
echo $this->Form->create();
echo $this->Form->submit('UP',['class' => 'btn btn-default','name'=>'dir']);
echo $this->Form->submit('DOWN',['class' => 'btn btn-default', 'name'=>'dir']);
echo $this->Form->submit('RIGHT', ['class' => 'btn btn-default', 'name'=>'dir']);
echo $this->Form->submit('LEFT', ['class' => 'btn btn-default', 'name'=>'dir']);
echo $this->Form->end();
?>

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
	<p><?= $this->Html->link('Create a new fighter', ['action' => './addFighter']); ?>
	</p>
</div>
<?php endif; ?>