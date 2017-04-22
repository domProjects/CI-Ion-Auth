<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

					<?php
						echo form_open('auth/forgot_password');
						echo form_fieldset(lang('forgot_password_heading'));
					?>

							<div class="form_group">
								<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?></p>
							</div>
							<div class="form_group">
								<?php
									echo form_label((($type == 'email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label)), 'identity');
									echo form_input($identity);
								?>
							</div>
							<div class="form_group">
								<?php echo form_submit('submit', lang('forgot_password_submit_btn')); ?>
							</div>
						<?php echo form_fieldset_close(); ?>
					</form>

					<div class="block block--error">{message}</div>
