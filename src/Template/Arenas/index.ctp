
<h1>Welcome to Arenas</h1>

<section class="col-md-4 col-md-offset-1">

	<h3>Best Fighter of all time</h3>
	<article class="panel panel-success">
		<h4 class="panel-heading">
			<?= $bestAllTimeFighter['name'] ?>
		</h4>
		<div class="panel-body">
			<dl class="dl-horizontal">
				<dt>XP</dt>
				<dd><?= $bestAllTimeFighter['xp'] ?></dd>
				<dt>Level</dt>
				<dd><?= $bestAllTimeFighter['level'] ?></dd>
			</dl>
		</div>
	</article>
</section>

<section class="col-md-4 col-md-offset-1">

	<h3>Best Alive Fighter</h3>
	<article class="panel panel-success">
		<h4 class="panel-heading">
			<?= $bestAliveFighter['name'] ?>
		</h4>
		<div class="panel-body">
			<dl class="dl-horizontal">
				<dt>XP</dt>
				<dd><?= $bestAliveFighter['xp'] ?></dd>
				<dt>Level</dt>
				<dd><?= $bestAliveFighter['level'] ?></dd>
			</dl>
		</div>
	</article>

</section>

<section class="col-md-4 col-md-offset-4">

	<h3>Best Guild</h3>
	<article class="panel panel-success">
		<h4 class="panel-heading">
			<?= $bestGuildName ?>
		</h4>
		<div class="panel-body">
			<dl class="dl-horizontal">
				<dt>Score</dt>
				<dd><?= $bestGuildScore ?></dd>
			</dl>
		</div>
	</article>

</section>
