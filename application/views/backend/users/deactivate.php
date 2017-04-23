<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

						<div class="row">
							<div class="col-12">
								<p><?php echo sprintf(lang('deactivate_subheading'), $username); ?></p>
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								<?php echo form_open('backend/users/deactivate/' . $id); ?>
									<div class="form-group">
										<label class="custom-control custom-radio">
											<input type="radio" name="confirm" value="yes" class="custom-control-input" checked>
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description"><?php echo lang('deactivate_confirm_y_label', 'confirm'); ?></span>
										</label>
										<label class="custom-control custom-radio">
											<input type="radio" name="confirm" value="no" class="custom-control-input">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description"><?php echo lang('deactivate_confirm_n_label', 'confirm'); ?></span>
										</label>
									</div>
									<div class="form-group">
										<?php
											echo form_hidden($csrf);
											echo form_hidden(array('id' => $id));
											echo form_submit('submit', lang('deactivate_submit_btn'), 'class="btn btn-primary"');
											echo anchor('backend/users', 'cancel', 'class="btn btn-primary"');
										?>
									</div>
								<?php echo form_close(); ?>
							</div>
						</div>
