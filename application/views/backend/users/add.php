<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

						<div class="row">
							<div class="col-12">
								<?php echo form_open(current_url()); ?>
									<div class="form-group row">
										<div class="col-12 col-md-6">
											<?php echo form_label('{lang_first_name}', 'first_name'); ?>
											<?php echo form_input($first_name); ?>
										</div>
										<div class="col-12 col-md-6">
											<?php echo form_label('{lang_last_name}', 'last_name'); ?>
											<?php echo form_input($last_name); ?>
										</div>
									</div>
<?php
if ($identity_column !== 'email')
{
	echo '<p>';
	echo lang('create_user_identity_label', 'identity');
	echo '<br />';
	echo form_error('identity');
	echo form_input($identity);
	echo '</p>';
}
?>
									<div class="form-group">
										<?php echo form_label('{lang_company_name}', 'company'); ?>
										<?php echo form_input($company); ?>
									</div>
									<div class="form-group row">
										<div class="col-12 col-md-6">
											<?php echo form_label('{lang_email}', 'email'); ?>
											<?php echo form_input($email); ?>
										</div>
										<div class="col-12 col-md-6">
											<?php echo form_label('{lang_phone}', 'phone'); ?>
											<?php echo form_input($phone); ?>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-12 col-md-6">
											<?php echo form_label('{lang_password}', 'password'); ?>
											<?php echo form_input($password); ?>
										</div>
										<div class="col-12 col-md-6">
											<?php echo form_label('{lang_password_confirm}', 'password_confirm'); ?>
											<?php echo form_input($password_confirm); ?>
										</div>
									</div>
									<div class="form-group">
										<?php echo form_submit('submit', '{lang_create}', array('class' => 'btn btn-primary')); ?>
										<?php echo anchor('backend/users', '{lang_cancel}', array('class' => 'btn btn-primary')); ?>
									</div>
								<?php echo form_close(); ?>
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								{message}
							</div>
						</div>
