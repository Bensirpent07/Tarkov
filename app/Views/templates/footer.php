</div>
<footer>
	<div class="container-fluid">
		<div class="row text-center">
			<div class="col-4">

			</div>
			<div class="col-4">
				<span id="copyright">Copyright <i class="far fa-copyright"></i> <?=date('Y')?> <a href="https://www.benkuhman.com">Ben Kuhman</a>, All rights reserved.</span>
			</div>
			<div class="col-4">
				<span id="version">Version <?=version?></span>
			</div>
		</div>
	</div>
</footer>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<?php if(isset($js)){foreach($js as $insert){echo '<script src="'.base_url()."/assets/javascript/".$insert.'"></script>';}}?>
</body>
</html>