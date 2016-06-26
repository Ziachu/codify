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
	<div class="flex one center full">
		
		<div class="card third">
			<header>
				already registered users
			</header>
			<footer>
				<ul>
				<?php foreach ($users as $user) { ?>
					<li><a href="/codify/profile/<?php echo $user ?>"><?php echo $user ?></a></li>
				<?php } ?>
				</ul>
			</footer>
		</div>

		<div class="card off-sixth third">
			<header>
				add photo (only .jpeg, don't ask why...)
			</header>
			<footer>
				<form action="upload" method="post" enctype="multipart/form-data">
					<label class="dropimage">
					  <input title="Drop image or click me" type="file" name="fileToUpload">
					</label>
					<input type="submit" value="upload" name="submit" class="right">
				</form>
			</footer>
		</div>

		<div class="card four-fifth">
			<header>
				images already uploaded
			</header>
			<div>
				<?php
					if ($rd->smembers('volatile_images')) {
						foreach ($rd->smembers('volatile_images') as $volatile_image) {
							echo '<img src="' . $volatile_image . '">';
						}
					}
				?>
			</div>
		</div>

		<div class="card four-fifth">
			<header>
				images in queue
			</header>
			<div>
				<?php
					if ($rd->smembers('images_in_queue')) {
						foreach ($rd->smembers('images_in_queue') as $image_in_queue) {
							echo '<img class="image" src="/codify/' . $image_in_queue . '"></div>';
						}
					}
				?>
		</div>
	</div>
	<?php	}	?>
<?php endblock() ?>