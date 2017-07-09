<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

						<div class="row">
							<div class="col-12">
								<?php echo form_open(current_url()); ?>

									<div class="col-12 col-md-6">
										<?php echo form_label('{lang_first_name}', 'first_name'); ?>
										<input type="text" value="backup_<?php echo date('Ymd_His'); ?>" name="name" id="name">
									</div>


									<div class="form-group">
										<p>{lang_export_format}</p>
										<div class="form-check form-check-inline">
											<label class="custom-control custom-checkbox">
												<input type="checkbox" name="groups[]" value="gzip" class="custom-control-input">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description">GZIP</span>
											</label>
										</div>
										<div class="form-check form-check-inline">
											<label class="custom-control custom-checkbox">
												<input type="checkbox" name="groups[]" value="zip" class="custom-control-input">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description">ZIP</span>
											</label>
										</div>
										<div class="form-check form-check-inline">
											<label class="custom-control custom-checkbox">
												<input type="checkbox" name="groups[]" value="txt" class="custom-control-input" checked>
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description">TXT</span>
											</label>
										</div>
									</div>


									<div class="form-group">
										<?php echo form_submit('submit', '{lang_create}', array('class' => 'btn btn-primary')); ?>
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
