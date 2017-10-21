<?php $this->assign('title', 'Diary');?>

<h1>Diary</h1>

<ol class="list-unstyled">
	<?php foreach ($events as $event): ?>
	<li>
		<dl class="panel panel-default">
			<dt class="panel-title"><?= $event['date'] ?></dt>
			<dd class="panel-body"><?= $event['name'] ?></dd>
		</dl>
	</li>
	<?php endforeach; ?>
</ol>

