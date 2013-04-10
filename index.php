<?php
require_once "_parts/functions.php";
require_once "_parts/db_settings.php";

// HTML parts
require_once "_parts/html_head.php";
require_once "_parts/header.php";
?>

<div class="container">
	<div class="row">
		<div class="span3">
			<?php include("_parts/sidebar.php"); ?>
		</div>
		

		<!-- Form to post data-->
		<div class="span9">
			<!-- index body -->
			<h1>Welcome to TFSC System</h1>
			<!-- index body end -->
		</div>
	</div>
</div>

<?php require_once "_parts/html_foot.php";
