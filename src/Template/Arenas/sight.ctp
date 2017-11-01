<?php $this->assign('title', 'Sight');?>

<h1><?= $this->fetch('title') ?></h1>

<?php if ($hasAliveFighter): ?>

<article class='panel panel-primary col-md-4 col-md-offset-0 col-xs-8 col-xs-offset-2'>
	<h4> <?php if (file_exists(WWW_ROOT.'/img/avatars/'.$aliveFighter['id'].'.jpg')): ?>
											<?= $this->Html->image('avatars/'.$aliveFighter['id'].'.jpg', ['width' => '33px', 'height' => '33px', 'alt' => 'M', 'class' => 'center-block']); ?>
											<?php else: ?>
											<?= $this->Html->image('avatars/default.jpg', ['width' => '33px', 'height' => '33px', 'alt' => 'Avatar', 'class' => 'center-block']); ?>
											<?php endif; ?>		</h4>
		<dl class="dl-horizontal">
			<dt>Health</dt>
			<dd><?= $aliveFighter['current_health'].'/'.$aliveFighter['skill_health'] ?></dd>
			<dt>Strength</dt>
			<dd><?= $aliveFighter['skill_strength'] ?></dd>
			<dt>Sight</dt>
			<dd><?= $aliveFighter['skill_sight'] ?></dd>
			<dt>Level</dt>
			<dd><?= $aliveFighter['level'] ?></dd>
			<dt>XP</dt>
			<dd><?= $aliveFighter['xp'] ?></dd>
			<dt>Coord</dt>
			<dd><?= $aliveFighter['coordinate_x'].','.$aliveFighter['coordinate_y']  ?></dd>
		</dl>
</article>


<div class="col-md-8">
	<div class="row">
		<button class='btn btn-primary col-xs-2 col-xs-offset-2' id="scream-btn">Scream</button>
		<?= $this->Form->create(); ?>
		<?= $this->Form->submit('Edit Surrondings', ['class' => 'btn btn-primary col-xs-2 col-xs-offset-4','name'=>'dir']); ?>
	</div>
	<div class="row">
		<?= $this->Form->submit('UP', ['class' => 'btn btn-primary col-xs-2 col-xs-offset-5','name'=>'dir']); ?>
	</div>
	<div class="row">
		<?= $this->Form->submit('LEFT', ['class' => 'btn btn-primary col-xs-2 col-xs-offset-2', 'name'=>'dir']);?>
		<span class="col-xs-2 col-xs-offset-1 text-center"><?= 'Attack : ' ;?> <?= $this->Form->checkbox('attack');?></span>
		<?= $this->Form->submit('RIGHT', ['class' => 'btn btn-primary col-xs-2 col-xs-offset-1', 'name'=>'dir']);?>
	</div>
	<div class="row">
		<?= $this->Form->submit('DOWN',['class' => 'btn btn-primary col-xs-2 col-xs-offset-5','name'=>'dir']); ?>
	</div>

	<?= $this->Form->end() ?>

	<div class="row">
		<?php if($trap_detect) : ?>
		<div class="panel panel-danger col-md-8 col-md-offset-2">
		  <h5 class="panel-heading">Suspicious Break</h5>
		</div>
		<?php endif; ?>


		<?php if($monster_detect) : ?>
		<div class="panel panel-danger col-md-8 col-md-offset-2">
		  <h5 class="panel-heading">Stink</h5>
		</div>
		<?php endif; ?>
	</div>

</div>




<div class="undisplayed scream form columns content col-md-6 col-md-offset-3" id="scream-form">
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->control('description', ['class' => 'input text']); ?>
        <?= $this->Form->hidden('SCREAM', ['value' => 'SCREAM']); ?>
    </fieldset>
    <?= $this->Form->submit('Submit', ['class' => 'btn btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>


<table class="sight-table">
	<tbody>
		<?php foreach ($sightArray as $row): ?>
		<tr>
			<?php foreach ($row as $square): ?>
			<td <?= ($square == '.')?'class="enable-square"':''; ?>>
				<!--			FIGHTER IMG-->

                                <?php if ($square == 'M') : ?>
                                <?php if (file_exists(WWW_ROOT.'/img/avatars/'.$aliveFighter['id'].'.jpg')): ?>
				<?= $this->Html->image('avatars/'.$aliveFighter['id'].'.jpg', ['width' => '33px', 'height' => '33px', 'alt' => 'M', 'class' => 'center-block']); ?>
                                <?php else: ?>
				<?= $this->Html->image('avatars/default.jpg', ['width' => '33px', 'height' => '33px', 'alt' => 'Avatar', 'class' => 'center-block']); ?>
				<?php endif; ?>
<!--			WALL IMG-->
				<?php elseif($square == 'P'): ?>
				<?= $this->Html->image('wall.bmp', ['width' => '33px', 'height' => '33px', 'alt' => 'P', 'class' => 'center-block']); ?>
<!--			POTION IMG-->
				<?php elseif($square == 'H'): ?>
				<?= $this->Html->image('potion.png', ['width' => '33px', 'height' => '33px', 'alt' => 'H', 'class' => 'center-block']); ?>
<!--			ENNEMY IMG-->
				<?php elseif(strpos($square,'E') !== false ): ?>
                                <?php $fid=str_replace("E", "", $square) ?>
                                <?php if (file_exists(WWW_ROOT.'/img/avatars/'.$fid.'.jpg')): ?>
				<?= $this->Html->image('avatars/'.$fid.'.jpg', ['width' => '33px', 'height' => '33px', 'alt' => 'E', 'class' => 'center-block']); ?>
                                <?php else: ?>
				<?= $this->Html->image('ennemy.png', ['width' => '33px', 'height' => '33px', 'alt' => 'Avatar', 'class' => 'center-block']); ?>
				<?php endif; ?>
				<?php endif; ?>

			</td>
			<?php endforeach; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif;?>

<?php if (!$hasAliveFighter) : ?>
<div class="alert alert-danger col-md-6 col-md-offset-3">
	<h4>You do not have alive fighter or all of them are dead...</h4>
	<p><?= $this->Html->link('Create a new fighter', ['action' => 'fighter']); ?>
	</p>
</div>
<?php endif; ?>
