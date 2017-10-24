<?php $this->assign('title', 'Guilds');?>

<h1><?= $this->fetch('title') ?></h1>

<?php if($guild): ?>
	<ul class="list-unstyled col-md-6 col-md-offset-3">
		<li>
			<article class="panel panel-success">
				<h5 class="panel-heading"><?= $guild->name ?></h5>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<?php foreach($fighters as $fighter): ?>
						<dt>Fighter</dt>
						<dd><?= $fighter->name?></dd>
					<?php endforeach; ?>
					</dl>
				</div>
			</article>
		</li>
	</ul>
<?php endif; ?>

<p class="col-md-6 col-md-offset-3">
	<?= $this->Html->link('Create a new guild', ['action' => './addGuild']); ?>
 </p>

 <p class="col-md-6 col-md-offset-3">
 	<?= $this->Html->link('Find guilds', ['action' => './findGuilds']); ?>
  </p>
