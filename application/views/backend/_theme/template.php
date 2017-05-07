<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="{charset}">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{pagetitle}</title>
		<link rel="stylesheet" href="{theme_url}main.min.css">
	</head>
	<body>
		<div class="adm_container">
			<div class="adm_header">
				<div class="adm_header-brand">
					<h1>{title}</h1>
				</div>
				<div class="adm_header-nav">
					{nav_header}
				</div>
			</div>
			<div class="adm_main">
				<div class="adm_sidebar">
					{nav_side}
				</div>
				<div class="adm_section">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								{result_flashdata}
							</div>
						</div>
						{content}
					</div>
				</div>
			</div>
			<div class="adm_footer">
				<div class="adm_footer-info">

				</div>
				<div class="adm_footer-copyright">
					{footer}
				</div>
			</div>
		</div>

		<script src="{theme_url}main.min.js"></script>
	</body>
</html>