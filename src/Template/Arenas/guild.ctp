<?php $this->assign('title', 'Guilds');?>

<h1><?= $this->fetch('title') ?></h1>

<!--If the playe does not have alive fighter-->
<?php if(!$hasAliveFighter): ?>

<div class="alert alert-danger col-md-6 col-md-offset-3">
	<h4>You do not have alive fighter or all of them are dead...</h4>
	<p><?= $this->Html->link('Create a new fighter', ['action' => 'fighter']); ?>
	</p>
</div>


<?php else: ?>

<!--If the fighter belongs to a guild-->
	<?php if($hasGuild): ?>

	<h2>You are in the <?= $guild; ?> guild !</h2>

	<?= $this->Form->create() ?>
		<?= $this->Form->button('Quit the guild', ['class' => 'btn btn-primary']) ?>
	<?= $this->Form->end() ?>


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
					<div class="guild-msg-btn" id="<?= $fighter['id']; ?>"</div>
						<button class="btn btn-primary">Send a message</button>
					</div>
					<div class="undisplayed col-md-6 col-md-offset-3" id="guild-msg-form-<?= $fighter['id']; ?>">
						<?= $this->Form->create() ?>
						<fieldset>
							<?= $this->Form->control('title'); ?>
							<?= $this->Form->control('message', ['type'=>'textarea']); ?>
							<?= $this->Form->hidden('fighter_id', ['class' => 'undisplayed', 'value' => $fighter['id']]); ?>
						</fieldset>
						<?= $this->Form->button(__('Send message', ['class' => 'btn btn-default'])) ?>
						<?= $this->Form->end() ?>
					</div>
				</dd>
			</dl>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php else: ?>

	<ul class="list-unstyled col-md-6 col-md-offset-3">
		<?php foreach($guilds as $guild): ?>
		<li class="panel panel-default">
			<h4 class="panel-heading"><?= $guild[1] ?></h4>
			<dl class="panel-body dl-horizontal">
				<dt>Score</dt>
				<dd>
					<?= $guild[2] ?>
				</dd>
			</dl>
			<?= $this->Html->Link('Join guild', ['controller' => 'Arenas', 'action' => 'guild/'.$guild[0]]) ?>
		</li>
		<?php endforeach; ?>

		<div>
			<button class="button" id="create-guild-btn">Create a guild</button>
		</div>
		<div class="undisplayed col-md-6 col-md-offset-3" id="create-guild-form">
			<?= $this->Form->create() ?>
			<fieldset>
				<?= $this->Form->control('name'); ?>
			</fieldset>
			<?= $this->Form->button(__('Submit', ['class' => 'btn btn-default'])) ?>
			<?= $this->Form->end() ?>
		</div>

	</ul>

	<?php endif; ?>

<?php endif; ?>
