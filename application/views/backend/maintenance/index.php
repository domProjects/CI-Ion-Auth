<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

						<div class="row">
							<div class="col-md-3">
								<div class="card text-center">
									<div class="card-block">
										<h2 class="card-title">{db_version}</h2>
										<p class="card-text text-uppercase">{lang_db_version}</p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card text-center">
									<div class="card-block">
										<h2 class="card-title">{apache_version}</h2>
										<p class="card-text text-uppercase">{lang_apache_version}</p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card text-center">
									<div class="card-block">
										<h2 class="card-title">{php_version}</h2>
										<p class="card-text text-uppercase">{lang_php_version}</p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card text-center">
									<div class="card-block">
										<h2 class="card-title">{zend_version}</h2>
										<p class="card-text text-uppercase">{lang_zend_version}</p>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3">
								<div class="card text-center">
									<div class="card-block">
										<h2 class="card-title">{db_platform}</h2>
										<p class="card-text text-uppercase">{lang_db_platform}</p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card text-center">
									<div class="card-block">
										<h2 class="card-title">{disk_freespace}</h2>
										<p class="card-text text-uppercase">{lang_disk_freespace}</p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card text-center">
									<div class="card-block">
										<h2 class="card-title">{memory_free}</h2>
										<p class="card-text text-uppercase">{lang_memory_free}</p>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								<table class="table table-hover table-striped">
									<thead>
										<tr>
											<th>Table</th>
											<th>CHK Msg_type</th>
											<th>CHK Msg_text</th>
											<th>ANL Msg_type</th>
											<th>ANL Msg_text</th>
										</tr>
									</thead>
									<tbody>
										{control_table}
									</tbody>
								</table>

								<?php echo anchor('backend/maintenance/backup', '{lang_backup}', array('class' => 'btn btn-primary')); ?>
								<?php echo anchor('backend/maintenance/backup_table', '{lang_backup_table}', array('class' => 'btn btn-primary')); ?>

 							</div>
 						</div>
