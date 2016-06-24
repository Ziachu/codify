<?php 
	include('../codify/pages/basepage.php');

	if (isset($_POST['post_content'])) {
		$author_id = $_SESSION['user_id'];
		$addressee_id = $user_id;
		$content = $_POST['post_content'];

		echo $author_id;

		$result = $db->set_new_post($author_id, $addressee_id, $content);
		
		$sql = 'SELECT * FROM posts
						WHERE post_addressee_id = ' . $addressee_id;
		$key = 'SQL:' . $addressee_id . ':' . crc32($sql);
		$mc->unset_key($key);

		header('Refresh:0');
		// var_dump($result);
	} else {
	}

?>

<?php startblock('title')?>
	<?php 
		if (isset($user) 
				&& isset($_SESSION['user_name'])
				&& $_SESSION['user_name'] == $user) 
			echo 'your';
		else if (isset($user))
			echo $user;
		else
			echo 'nobody\'s';
	?> 
	profile
<?php endblock() ?>

<?php startblock('content')?>
	<div class="flex one center full">
		<article class="third card">
			<header class="center no-margin">
				<h1 class="no-margin">
					<a href="/codify/profile/<?php echo $user ?>" class="button no-margin success"><?php echo $user ?></a>
				</h1>
			</header>

			<footer>
				<section class="stats">
					<div class="flex two stat">
						<label class="text-right">log_times:</label>
						<label><?php echo $rd->get($user . '_log_times') ?></label>
					</div>
				</section>
			</footer>
		</article>
	</div>

	<?php if ($user != $_SESSION['user_name']) { ?>
	<div class="flex one center full">
		<article class="two-third card">
			<header>new code</header>
			<footer>
				<form method="post" action="/codify/profile/<?php echo $user ?>">
					<label><textarea name="post_content"></textarea></label>
				  <label><input type="submit" class="right" value="submit"></label>
				</form>
			</footer>
		</article>
	</div>
	<?php } ?>

	<?php
		foreach ($posts as $post) {
			$author_name = $mc->get_user_name_by_id($post['post_author_id']);
			echo '
				<div class="flex one center full">
					<article class="two-third card">
						<header class="center no-margin">
							<h1 class="no-margin">
								<a href="/codify/profile/' . $author_name . '" class="button no-margin">' . $author_name . '</a>
							</h1>
						</header>
						<footer>' . $post['post_content'] . '</footer>';

			if ($author_name == $_SESSION['user_name'])
				echo '<footer><button id="remove" data-post-id="' . $post['post_id'] . '" class="button warning right">delete</button></footer>';

			echo '</article>
				</div>';
		}
	?>

<?php endblock() ?>