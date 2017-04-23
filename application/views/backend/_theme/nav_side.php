<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

					<ul class="nav flex-column">
						<li class="nav-item">
							<a class="nav-link" href="<?php echo site_url('backend/dashboard'); ?>"><?php echo lang('dashboard'); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo site_url('backend/users'); ?>"><?php echo lang('users'); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo site_url('backend/groups'); ?>"><?php echo lang('security_groups'); ?></a>
						</li>
					</ul>
