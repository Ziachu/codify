<?php require_once('../codify/core/ti.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php startblock('title') ?><?php endblock() ?> | codify</title>

	<script src="https://code.jquery.com/jquery-3.0.0.min.js" integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0=" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/picnicss/6.1.1/picnic.min.css">
	<link rel="stylesheet" href="/codify/css/style.css">
</head>
<body>
	<nav>
		<a href="/codify/" class="brand">
			<span>codify</span>
		</a>

		<!-- responsive-->
		<input id="bmenub" type="checkbox" class="show">
		<label for="bmenub" class="burger pseudo button">&#9776;</label>

		<div class="menu">
			<?php
				echo '<span class="button tooltop-top" data-tooltip="logged_in_users">' . $rd->get('logged_in_users') . '</span>';

				if (chck()) {
					echo '<a href="/codify/profile/' . $_SESSION['user_name'] . '" class="button success">' . strtolower($_SESSION['user_name']) . '</a>';
					echo '<a href="/codify/logoutpage" class="button warning">log out</a>';
				} else {
					echo '<a href="/codify/loginpage" class="button">log in</a>';
					echo '<a href="/codify/registerpage" class="button">sign up</a>';
				}
			?>
		</div>
	</nav>

	<main>
		<div class="flex one two-800 three-1200 center">
			<?php startblock('content'); endblock() ?>
			<label for="info_modal" class="button hidden">Show modal</label>
		</div>
	</main>
	
	<footer>
		© 2016 Michał Ziach
	</footer>

	<!-- modal start -->
	<div class="modal">
	  <input id="info_modal" type="checkbox" />
	  <label for="indo_modal" class="overlay"></label>
	  <article>
	    <header>
	      <h3 id="modal_title"></h3>
	      <label for="info_modal" class="close">&times;</label>
	    </header>
	    <section class="content" id="modal_content"></section>
	    <footer>
	      <label for="info_modal" class="button right">ok</label>
	    </footer>
	  </article>
	</div>
	<!-- modal end -->

	<script src="/codify/js/popup.js"></script>
	<script src="/codify/js/remove.js"></script>

</body>
</html>