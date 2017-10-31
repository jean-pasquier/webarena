<?php $this->assign('title', 'Messages');?>

<h1><?= $this->fetch('title') ?></h1>

<?php if(!$hasAliveFighter): ?>

<div class="alert alert-danger col-md-6 col-md-offset-3">
	<h4>You do not have alive fighter or all of them are dead...</h4>
	<p><?= $this->Html->link('Create a new fighter', ['action' => 'fighter']); ?>
	</p>
</div>

<?php else: ?>

<div class="col-md-8">

	<ul class="list-unstyled">
		<?php foreach ($messages as $message): ?>
		<li>
			<article class="panel <?=($message['fighter_id_from']==$fid)?'panel-info':'panel-default'; ?>">
				<h3 class="undisplayed">Message</h3>
				<div class="panel-heading">
					<dl class="dl-horizontal">
						<dt>From: </dt><dd><?= $message['fighter_name_from'] ?></dd>
						<dt>To: </dt>
						<dd><?= $message['fighter_name']?></dd>
					</dl>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt><?= $message['title'] ?></dt>
						<dd><?= $message['message'] ?></dd>
					</dl>
					<p class="center-text"><?= $message['date']?></p>
				</div>
			</article>
		</li>
		<?php endforeach; ?>
	</ul>

	<div class="messages form col-md-6 col-md-offset-3 columns content">
	  <?= $this->Form->create($entity); ?>
	  <fieldset>
			<?php if($bool) : ?>
	    <?= $this->Form->control('fighters_name', ['options' => $fighters]); ?>
		  <?php endif;?>
	    <?= $this->Form->control('title'); ?>
	    <?= $this->Form->control('message'); ?>
	  </fieldset>
	  <?= $this->Form->button('Submit', ['class' => 'btn btn-primary']) ?>
	  <?= $this->Form->end() ?>
	</div>
</div>




<div class="table-responsive col-md-4">
	<table class="table">
    <thead>
      <tr>
        <th>Fighters in the Arena</th>
      </tr>
    </thead>
    <tbody>
		<th>
			<?php foreach ($fighters_id as $fighter): ?>
			<div>
				<?= $this->Html->link($fighter['name'], ['action' => './messages/'.$fighter['player_id']]); ?>
			</div>
			<?php endforeach; ?>
		</th>
    </tbody>
  </table>
</div>

<?php endif; ?>
