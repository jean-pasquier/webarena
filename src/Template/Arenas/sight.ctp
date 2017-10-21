<?php $this->assign('title', 'Sight');?>



<ul>
    <li>X= <?php echo $x ?></li>
    <li>Y= <?php echo $y ?></li>
</ul>


<?php
// echo($this->Form->postButton('move', ['controller' => 'Arenas', 'action' => 'move']));
echo $this->Form->create();
echo $this->Form->submit('up',['name'=>'dir']);
echo $this->Form->submit('down',['name'=>'dir']);
echo $this->Form->submit('right', ['name'=>'dir']);
echo $this->Form->submit('left', ['name'=>'dir']);
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
