<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

						<div class="row">
							<div class="col-12">
								<p>{lang_deactivate_user_confirm} <code>{username}</code></p>
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								<?php echo form_open('backend/users/deactivate/' . $id); ?>
									<div class="form-group">
										<label class="custom-control custom-radio">
											<?php echo form_radio('confirm', 'yes', FALSE, array('class' => 'custom-control-input')); ?>
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description">{lang_yes}</span>
										</label>
										<label class="custom-control custom-radio">
											<?php echo form_radio('confirm', 'no', TRUE, array('class' => 'custom-control-input')); ?>
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description">{lang_no}</span>
										</label>
									</div>
									<div class="form-group">
										<?php echo form_hidden($csrf); ?>
										<?php echo form_hidden(array('id' => $id)); ?>
										<?php echo form_submit('submit', '{lang_save}', array('class' => 'btn btn-primary')); ?>
										<?php echo anchor('backend/users', '{lang_cancel}', array('class' => 'btn btn-primary')); ?>
									</div>
								<?php echo form_close(); ?>
							</div>
						</div>
