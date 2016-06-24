<?php include('../codify/pages/basepage.php') ?>

<?php startblock('title')?>
	Landingpage
<?php endblock() ?>

<?php startblock('content')?>
	<div class="flex one center full">
	<article class="half card">
		<header>
			<p class="center"><span class="brand" style="font-size: 26.4px; color: #000;">codify</span></p>
		</header>
		<footer>
			<p>Check whether Your friends are already here! And <strong>spam on</strong> theirs <strong>post-wall</strong>!</p>
			<p><a href="/codify/registerpage">Click here</a> to register or <a href="/codify/loginpage">here</a> to log in!</p>
		</footer>
	</article>
	</div>

	<?php	if (chck()) { ?>
		<div class="card">
			<header>
				<h1 class="center">registered users</h1>
			</header>
			<footer>
				<ul>
				<?php foreach ($users as $user) { ?>
					<li><a href="/codify/profile/<?php echo $user ?>"><?php echo $user ?></a></li>
				<?php } ?>
				</ul>
			</footer>
		</div>
	<?php	}	?>
<?php endblock() ?>