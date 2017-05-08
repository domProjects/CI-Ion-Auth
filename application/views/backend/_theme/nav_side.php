<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

					<ul class="nav flex-column">
						<li class="nav-item">
							<a class="nav-link" href="<?php echo site_url('backend/dashboard'); ?>">{lang_dashboard}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo site_url('backend/users'); ?>">{lang_users}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo site_url('backend/groups'); ?>">{lang_security_groups}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo site_url('backend/maintenance'); ?>">{lang_maintenance} (beta)</a>
						</li>
					</ul>
