<?php $this->assign('title', 'Diary');?>

<h1><?= $this->fetch('title') ?></h1>

<?php if ($hasAliveFighter): ?>
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

<?php endif;?>

<?php if (!$hasAliveFighter) : ?>
<div class="alert alert-danger col-md-6 col-md-offset-3">
	<h4>You do not have alive fighter or all of them are dead...</h4>
	<p><?= $this->Html->link('Create a new fighter', ['action' => 'fighter']); ?>
	</p>
</div>
<?php endif; ?>
