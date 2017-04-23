<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

						<div class="row">
							<div class="col-12">
								<p><?php echo lang('create_user_subheading');?></p>
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								<?php echo form_open(current_url()); ?>
									<div class="form-group row">
										<div class="col-12 col-md-6">
											<?php
												echo form_label(lang('create_user_fname_label'), 'first_name');
												echo form_input($first_name);
											?>
										</div>
										<div class="col-12 col-md-6">
											<?php
												echo form_label(lang('create_user_lname_label'), 'last_name');
												echo form_input($last_name);
											?>
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
										<?php
											echo form_label(lang('create_user_company_label'), 'company');
											echo form_input($company);
										?>
									</div>
									<div class="form-group row">
										<div class="col-12 col-md-6">
											<?php
												echo form_label(lang('create_user_email_label'), 'email');
												echo form_input($email);
											?>
										</div>
										<div class="col-12 col-md-6">
											<?php
												echo form_label(lang('create_user_phone_label'), 'phone');
												echo form_input($phone);
											?>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-12 col-md-6">
											<?php
												echo form_label(lang('create_user_password_label'), 'password');
												echo form_input($password);
											?>
										</div>
										<div class="col-12 col-md-6">
											<?php
												echo form_label(lang('create_user_password_confirm_label'), 'password_confirm');
												echo form_input($password_confirm);
											?>
										</div>
									</div>
									<div class="form-group">
										<?php
											echo form_submit('submit', lang('create_user_submit_btn'), 'class="btn btn-primary"');
											echo anchor('backend/users', 'cancel', 'class="btn btn-primary"');
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
