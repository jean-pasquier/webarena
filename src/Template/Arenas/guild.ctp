<?php $this->assign('title', 'Guilds');?>

<h1><?= $this->fetch('title') ?></h1>

<?php if($hasGuild): ?>

<h2>You are in the <?= $guild; ?> guild !</h2>

<?= $this->Form->create() ?>
	<?= $this->Form->button(__('Quit the guild', ['class' => 'btn btn-default'])) ?>
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
					<button class="button default-button">Send a message</button>
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

<ul class="list-unstyled">
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
	
	<div>
		<button class="" id="create-guild-btn">Create a guild.</button>
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
