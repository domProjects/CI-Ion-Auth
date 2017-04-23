<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

						<div class="row">
							<div class="col-12">
								<p><?php echo lang('create_group_subheading');?></p>
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								<?php echo form_open(current_url()); ?>
									<div class="form-group">
										<?php
											echo form_label(lang('create_group_name_label'), 'group_name');
											echo form_input($group_name);
										?>
									</div>
									<div class="form-group">
										<?php
											echo form_label(lang('create_group_desc_label'), 'description');
											echo form_input($description);
										?>
									</div>
									<div class="form-group">
										<?php
											echo form_submit('submit', lang('create_group_submit_btn'), 'class="btn btn-primary"');
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
