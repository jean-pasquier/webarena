<?php $this->assign('title', 'Your Fighters');?>

<h1><?= $this->fetch('title') ?></h1>



<?php if($hasAliveFighter): ?>


<?php if($skill_credits): ?>
<div class="panel panel-success col-sm-8 col-sm-offset-2">
	<div class="panel-heading">
		<h3 class="panel-title">Level up ! You can upgrade one of these skills for your fighter :</h3>
	</div>
	<p><?= 'Skills credits : '. $skill_credits; ?></p>
	<?= $this->Form->create(); ?>
	<div class="btn-group btn-group-justified" role="group">
		<?= $this->Form->submit('Sight', ['class' => 'btn btn-success col-xs-4 ', 'name' => 'skill']); ?>
		<?= $this->Form->submit('Strength', ['class' => 'btn btn-success col-xs-4', 'name' => 'skill']); ?>
		<?= $this->Form->submit('Health', ['class' => 'btn btn-success col-xs-4', 'name' => 'skill']); ?>
	</div>
	
	<?= $this->Form->end(); ?>
</div>
<?php endif; ?>


<ul class="list-unstyled col-sm-6 col-sm-offset-3">
	<?php foreach ($list as $fighter): ?>
		<li>
			<article class="panel <?=($fighter['current_health']==0)?'panel-danger':'panel-primary'; ?>">
				<div class="panel-heading">
					<h4 class="panel-title"><?= $fighter['name']; ?> <?=($fighter['current_health']==0)?'(dead)':'';?></h4>
				</div>
				<div class="panel-body">
					<?php if (file_exists(WWW_ROOT.'/img/avatars/'.$fighter->id.'.jpg')): ?>
					<?= $this->Html->image('avatars/'.$fighter->id.'.jpg', ['width' => '50px', 'height' => '50px', 'alt' => 'Avatar', 'class' => 'center-block']); ?>
					<?php else: ?>
					<?= $this->Html->image('avatars/default.jpg', ['width' => '50px', 'height' => '50px', 'alt' => 'Avatar', 'class' => 'center-block']); ?>
					<?php endif; ?>
					<dl class="dl-horizontal">
						<dt>Health</dt>
						<dd><?= $fighter['current_health'].'/'.$fighter['skill_health'] ?></dd>
						<dt>Strength</dt>
						<dd><?= $fighter['skill_strength'] ?></dd>
						<dt>Sight</dt>
						<dd><?= $fighter['skill_sight'] ?></dd>
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

<?php endif; ?>

<?php if (!$hasAliveFighter): ?>

<div>
	<p>	All your fighters are dead. You should create a new one !</p>
	<button class="button" id="create-fighter-btn">Create a fighter</button>
</div>


<div class="undisplayed col-md-6 col-md-offset-3" id="create-fighter-form">
	<?= $this->Form->create($entity, ['enctype' => 'multipart/form-data']) ?>
    <fieldset>
        <?= $this->Form->control('name'); ?>
        <?= $this->Form->file('submittedfile', ['accept' => 'image/*']); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit', ['class' => 'btn btn-default'])) ?>
    <?= $this->Form->end() ?>
</div>
<?php endif; ?>
