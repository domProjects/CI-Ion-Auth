<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

						<div class="row">
							<div class="col-12">
								
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								<?php echo form_open(current_url()); ?>
									<div class="form-group">
										<?php
											echo form_label(lang('edit_group_name_label'), 'group_name');
											echo form_input($group_name);
										?>
									</div>
									<div class="form-group">
										<?php
											echo form_label(lang('edit_group_desc_label'), 'description');
											echo form_input($group_description);
										?>
									</div>
									<div class="form-group">
										<?php
											echo form_submit('submit', lang('edit_group_submit_btn'), 'class="btn btn-primary"');
											echo anchor('backend/groups', 'cancel', 'class="btn btn-primary"');
										?>
									</div>
								<?php echo form_close(); ?>
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								<?php echo $message;?>
							</div>
						</div>
