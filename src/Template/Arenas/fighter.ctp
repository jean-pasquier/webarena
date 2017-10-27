<?php $this->assign('title', 'Fighters');?>

<h1><?= $this->fetch('title') ?></h1>



<?php if($hasAliveFighter): ?>

<?php
echo $this->Form->create();
echo 'Skills credits : '.$skill_credits;
echo $this->Form->submit('Sight', ['class' => 'button', 'name' => 'skill']);
echo $this->Form->submit('Strength', ['class' => 'button', 'name' => 'skill']);
echo $this->Form->submit('Health', ['class' => 'button', 'name' => 'skill']);
echo $this->Form->end();
?>


<ul class="list-unstyled col-md-6 col-md-offset-3">
	<?php foreach ($list as $fighter): ?>
		<li>
			<article class="panel <?=($fighter['current_health']==0)?'panel-danger':'panel-success'; ?>">
				<h5 class="panel-heading"><?= $fighter['name'] ?></h5>
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
