<?php $this->assign('title', 'Messages');?>

<div class="col-xs-2">
</div>

<div class="col-xs-8">
	<h1><?= $this->fetch('title') ?></h1>

	<ul class="list-unstyled">
		<?php foreach ($messages as $message): ?>
		<li>
			<article class="panel <?=($message['fighter_id_from']==$fid)?'panel-info':'panel-default'; ?>">
				<h5 class="panel-heading">From: <?= $message['fighter_name_from'] ?> <br>To: <?= $message['fighter_name']?></h5>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt><?= $message['title'] ?></dt>
						<dd><?= $message['message'] ?></dd>
	          <p> </p>
	          <p style="font-style:italic"> <?= $message['date']?> </p>
					</dl>
				</div>
			</article>
		</li>
		<?php endforeach; ?>
	</ul>

	<div class="messages form large-12 medium-8 columns content">
	  <?= $this->form->create($entity); ?>
	  <fieldset>
			<?php if($bool) : ?>
	    <?= $this->form->control('fighters_name', ['options' => $fighters]); endif;?>
	    <?= $this->form->control('title'); ?>
	    <?= $this->form->control('message'); ?>
	  </fieldset>
	  <?= $this->Form->button(__('Submit')) ?>
	  <?= $this->Form->end() ?>
	</div>
</div>




<div class="col-xs-2">
	<table class="table">
    <thead>
      <tr>
				<th> </th>
        <th>Fighters Alive</th>
      </tr>
    </thead>
    <tbody>
			<th>
				<?php foreach ($fighters_id as $fighter): ?>
					<?= $this->Html->link($fighter['name'], ['action' => './messages/'.$fighter['player_id']]); ?>
				<?php endforeach; ?>
			</th>

    </tbody>
  </table>
</div>
