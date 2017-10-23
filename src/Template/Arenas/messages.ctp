<?php $this->assign('title', 'Messages');?>

<h1><?= $this->fetch('title') ?></h1>


<ul class="list-unstyled col-md-6 col-md-offset-3">
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

<div class="messages form large-9 medium-8 columns content">
  <?= $this->form->create($entity); ?>
  <fieldset>
    <?= $this->form->control('fighters_name', ['options' => $fighters]); ?>
    <?= $this->form->control('title'); ?>
    <?= $this->form->control('message'); ?>
  </fieldset>
  <?= $this->Form->button(__('Submit')) ?>
  <?= $this->Form->end() ?>
</div>
