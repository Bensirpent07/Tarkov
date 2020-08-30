<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Tarkov Tools</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="<?=base_url()?>/assets/css/global.css">
	<?php foreach($css as $insert){echo '<link rel="stylesheet" href="'.base_url().'/assets/css/'.$insert.'">';} ?>
	<script src="https://kit.fontawesome.com/f8ae5a2bad.js" crossorigin="anonymous"></script>
	<script type="text/javascript">
		var base_url = '<?=base_url()?>/';
	</script>
</head>
<body>
	<nav id="mainNav">
		<ul>
			<li class="dropdown">
				<a href="#">Tools <i class="fas fa-sort-down dropdown"></i></a>
				<div class="dropdown-content">
					<a href="<?=base_url()?>/ammo">Ammo</a>
					<a href="#">Armor (Future Development)</a>
                    <a href="#">Maps (Future Development)</a>
				</div>
			</li>
			<li><a href="<?=base_url()?>/about">About</a></li>
			<li><a href="<?=base_url()?>/contact">Contact</a></li>
			<li><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=F6MBRM3CHMQRG&currency_code=USD&source=url">Donate</a></li>
		</ul>
	</nav>
	<div id="overlay">