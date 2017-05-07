<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

						<div class="row">
							<div class="col-12">
								<?php echo form_open_multipart('backend/groups/import_process'); ?>
									<div class="form-group">
										<?php echo form_label('{lang_file}', 'file'); ?>
										<input type="file" name="file" id="file" class="form-control">
										<div class="alert alert-info" role="alert">
											<strong>Accepted file format</strong>
											<ul>
												<li>CSV and TXT</li>
											</ul>
											<strong>Contents of the file to be imported</strong>
											<ul>
												<li>The fields must be separated by a semicolon <kbd>;</kbd></li>
												<li>The first line must include the name of the fields as follows: <code>name;description</code></li>
												<li>The following lines must be in this form: <code>betatest;beta tester group</code></li>
											</ul>
											Which gives us:
<pre class="mb-0"><code>name;description
betatest;beta tester group
superviseur;superviseur group
... <i>and more</i> ...</code></pre>
										</div>
									</div>
									<div class="form-group">
										<?php echo form_submit('submit', '{lang_import}', array('class' => 'btn btn-primary')); ?>
										<?php echo anchor('backend/groups', '{lang_cancel}', array('class' => 'btn btn-primary')); ?>
									</div>
								<?php echo form_close(); ?>
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								{message}
							</div>
						</div>
