<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

						<div class="row">
							<div class="col-12">

								<p>Platform: {db_platform}</p>
								<p>Version: {db_version}</p>

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

<pre><code>
<?php

$query = $this->db->query("SELECT * FROM dp_auth_groups");

$delimiter = ",";
$newline = "\r\n";
$enclosure = '"';

echo $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);

?>
</code></pre>

								<?php echo anchor('backend/maintenance/backup', '{lang_backup}', array('class' => 'btn btn-primary')); ?>
								<?php echo anchor('backend/maintenance/backup_table', '{lang_backup_table}', array('class' => 'btn btn-primary')); ?>

 							</div>
 						</div>
