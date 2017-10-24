<?php $this->assign('title', 'Guilds');?>

<h1><?= $this->fetch('title') ?></h1>

<?php if($hasGuild): ?>

<h2>You are in the <?= $guild; ?> guild !</h2>
<ul class="list-unstyled">
	<?php foreach($guildFighters as $fighter) : ?>
	<li>
		<dl class="panel">
			<dt class="panel-title"><?= $fighter['name'] ?></dt>
			<dd class="panel-body">
				<dl class="dl-horizontal">
					<dt>Health</dt>
					<dd><?= $fighter['current_health'].'/'.$fighter['skill_health'] ?></dd>
					<dt>XP</dt>
					<dd><?= $fighter['xp'] ?></dd>
					<dt>Coord</dt>
					<dd><?= $fighter['coordinate_x'].','.$fighter['coordinate_y']  ?></dd>
				</dl>
				<?= $this->Html->Link('Send message', ['controller' => 'Arenas', 'action' => 'guild/'.$fighter['id']]); ?>
			</dd>
		</dl>
	</li>
	<?php endforeach; ?>
</ul>

<?php else: ?>

<ul class="list-unstryled">
	<?php foreach($guilds as $guild): ?>
	<li>
		<dl class="panel">
			<dt class="panel-title"><?= $guild['name'] ?></dt>
			
			<dd class="panel-body">
				<?= $this->Html->Link('Join guild', ['controller' => 'Arenas', 'action' => 'guild/'.$guild['id']]); ?>
			</dd>
		</dl>
	</li>
	<?php endforeach; ?>
</ul>

<?php endif; ?>