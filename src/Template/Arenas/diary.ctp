<?php $this->assign('title', 'Diary');?>

<h1><?= $this->fetch('title') ?></h1>

<ol class="list-unstyled">
	<?php foreach ($events as $event): ?>
	<li>
		<dl class="panel panel-default col-sm-6 col-sm-offset-3">
			<dt class="panel-title"><?= $event['date'] ?></dt>
			<dd class="panel-body"><?= $event['name'] ?></dd>
		</dl>
	</li>
	<?php endforeach; ?>
</ol>

