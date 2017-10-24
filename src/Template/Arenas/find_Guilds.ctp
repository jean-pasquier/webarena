<?php $this->assign('title', 'List of guilds');?>

<h1><?= $this->fetch('title') ?></h1>

<ul class="list-unstyled col-md-6 col-md-offset-3">
	<?php foreach ($guilds as $guild): ?>
	<li>
		<article class="panel panel-success">
			<h5 class="panel-heading"><?= $guild['name'] ?></h5>
			<div class="panel-body">
				<dl class="dl-horizontal">
          		<?php if($guild['fighters_name']): ?>
					<?php foreach($guild['fighters_name'] as $fname): ?>
						<dt>Fighter name</dt>
						<dd><?= $fname['name']?></dd>
					<?php endforeach; ?>
        		<?php else: ?>
        			<dt>Guild empty</dt>
        			<dd> There is no fighters is this guild for the moment </dd>
      			<?php endif; ?>
      			</dl>
         <?= $this->form->create(); ?>
         <?= $this->form->checkbox('guild_id', [
           'value' => $guild->id,
            'required' => true]);?>
           <?= $this->Form->button(__('Join guild')) ?>
           <?= $this->Form->end() ?>
			</div>
		</article>
	</li>
	<?php endforeach; ?>
</ul>
