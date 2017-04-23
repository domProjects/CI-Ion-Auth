<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

				<button class="btn" type="button">XXX</button>

				<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" id="userInfo" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{user_fullname}
					</button>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userInfo">
						<a class="dropdown-item" href="<?php echo site_url('auth/logout'); ?>"><?php echo lang('logout'); ?></a>
					</div>
				</div>
