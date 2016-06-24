<?php include('../codify/pages/basepage.php') ?>

<?php 
	if (isset($_POST['user_name']) && isset($_POST['user_password'])) {
		$user = $_POST['user_name'];
		$authed = auth($user, $_POST['user_password']);

		if ($authed) {
			$_SESSION['user_name'] = $user;
			$_SESSION['user_id'] = get_id();
			header("Location: /codify/profile/" . $user);
		}
	}
?>

<?php startblock('title')?>
	log in
<?php endblock() ?>

<?php startblock('content')?>
	<div class="card">
		<header>
			<h1>loginpage</h1>
		</header>
		<footer>
			<form action="/codify/loginpage" method="post">
				<label><input name="user_name" type="text" placeholder="name" autofocus></label>
				<label><input name="user_password" type="password" placeholder="password"></label>
				<label><input type="submit" class="right" value="submit"></label>
				<label><button class="button right error">cancel</button></label>
			</fieldset>
		</footer>
	</div>
<?php endblock() ?>