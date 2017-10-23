<?php $this->assign('title', 'Guilds');?>

<h1><?= $this->fetch('title') ?></h1>


<ul class="list-unstyled col-md-6 col-md-offset-3">
	<?php foreach ($guilds as $guild): if($guild):?>
	<li>
		<article class="panel panel-success">
			<h5 class="panel-heading"><?= $guild['fighter_name'] ?></h5>
			<div class="panel-body">
				<dl class="dl-horizontal">
					<dt>guild name</dt>
					<dd><?= $guild['name']?></dd>
				</dl>
			</div>
		</article>
	</li>
<?php endif; endforeach; ?>
</ul>

<p class="col-md-6 col-md-offset-3">
	<?= $this->Html->link('Create a new guild', ['action' => './addGuild']); ?>
 </p>

 <p class="col-md-6 col-md-offset-3">
 	<?= $this->Html->link('Find guilds', ['action' => './findGuilds']); ?>
  </p>
