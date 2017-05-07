<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

						<div class="row">
							<div class="col-12">
								<?php echo form_open(current_url()); ?>
									<div class="form-group">
										<?php echo form_label('{lang_group_name}', 'group_name'); ?>
										<?php echo form_input($group_name); ?>
									</div>
									<div class="form-group">
										<?php echo form_label('{lang_description}', 'description'); ?>
										<?php echo form_input($description); ?>
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
