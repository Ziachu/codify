<?php include('../codify/pages/basepage.php') ?>

<?php 
	if (isset($_POST['user_name']) 
			&& isset($_POST['user_password'])
			&& isset($_POST['user_password_confirmation'])) {
		
		if ($_POST['user_password'] == $_POST['user_password_confirmation']) {
			if (name_is_free($_POST['user_name'])) {
				echo '<script>success("user successfully registerd, you can log in now")</script>';
				$registerd = register($_POST['user_name'], $_POST['user_password']);
			} else {
				echo '<script>fail("username already in use");</script>';
			}
		} else {
			echo '<script>fail("passwords don\'t match");</script>';
		}

		// $authed = auth($_POST['user_name'], $_POST['user_password']);

		// if ($authed) {
		// 	$_SESSION['user_name'] = $_POST['user_name'];
		// 	$_SESSION['user_id'] = get_id();
		// }
	}
?>

<?php startblock('title')?>
	sign up
<?php endblock() ?>

<?php startblock('content')?>
	<div class="card">
		<header>
			<h1>registerpage</h1>
		</header>
		<footer>
			<form action="/codify/registerpage" method="post">
				<label><input name="user_name" type="text" placeholder="name" autofocus></label>
				<label><input name="user_password" type="password" placeholder="password"></label>
				<label><input name="user_password_confirmation" type="password" placeholder="confirm password"></label>
				<label><input type="submit" class="right" value="submit"></label>
				<label><a href="/codify/" class="button right error">cancel</a></label>
			</fieldset>
		</footer>
	</div>
<?php endblock() ?>