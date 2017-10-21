<?php $this->assign('title', 'Fighters');?>

<h1>Fighters</h1>

<ul class="list-unstyled">
	<?php foreach ($list as $fighter): ?>
	<li>
		<article class="panel <?=($fighter['current_health']==0)?'panel-danger':'panel-success'; ?>">
			<h5 class="panel-heading"><?= $fighter['name'] ?></h5>
			<div class="panel-body">
				<dl class="dl-horizontal">
					<dt>Health</dt>
					<dd><?= $fighter['current_health'].'/'.$fighter['skill_health'] ?></dd>
					<dt>XP</dt>
					<dd><?= $fighter['xp'] ?></dd>
					<dt>Coord</dt>
					<dd><?= $fighter['coordinate_x'].','.$fighter['coordinate_y']  ?></dd>
				</dl>
			</div>
		</article>
	</li>
	<?php endforeach; ?>
</ul>

<?= $this->Html->link('New Fighter', ['action' => './addFighter']);

