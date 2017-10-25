<?php $this->assign('title', 'Fighters');?>

<h1><?= $this->fetch('title') ?></h1>



<?php if ($hasAliveFighter): ?>

<?php 
echo $this->Form->create();
echo 'Skills credits : ',$skill_credits;
echo $this->Form->submit('Sight',['class' => 'button','name'=>'skill']);
echo $this->Form->submit('Strength',['class' => 'button', 'name'=>'skill']);
echo $this->Form->submit('Health', ['class' => 'button', 'name'=>'skill']);
echo $this->Form->end();
?>


<ul class="list-unstyled col-md-6 col-md-offset-3">
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
                                        <dt>Sight</dt>
					<dd><?= $fighter['skill_sight']?></dd>
                                        <dt>Strength</dt>
					<dd><?= $fighter['skill_strength']?></dd>
                                        <dt>Health</dt>
					<dd><?= $fighter['skill_health']?></dd>                
				</dl>
			</div>
		</article>
	</li>
	<?php endforeach; ?>
</ul>

<?php endif; ?>

<?php if (!$hasAliveFighter): ?>
<p class="col-md-6 col-md-offset-3">All your fighters are dead...
	<?= $this->Html->link('Create a new fighter', ['action' => './addFighter']); ?>
 ?</p>
<?php endif; ?>