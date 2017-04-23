<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user_active   = array('class' => 'btn btn-success btn-sm', 'role' => 'button');
$user_inactive = array('class' => 'btn btn-secondary btn-sm', 'role' => 'button');

$nbr_users = ($count_users > 0) ? ' <span class="badge badge-info">' . $count_users . '</span>' : NULL;

?>

						<div class="row">
							<div class="col-12">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#list" role="tab">List<?php echo $nbr_users; ?></a>
									</li>
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Action</a>
										<div class="dropdown-menu">
											<?php echo anchor('backend/users/add', 'Add user', array('class' => 'dropdown-item')); ?>
											<a class="dropdown-item" href="#">Import CSV</a>
										</div>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#help" role="tab">Help</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="list" role="tabpanel">
										<table class="table table-hover table-striped">
											<thead>
												<tr>
													<th>#</th>
													<th>Prénom</th>
													<th>Nom</th>
													<th>Email</th>
													<th>Groupe</th>
													<th>Status</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
<?php foreach ($users as $user): ?>
												<tr>
													<th scope="row">-</th>
													<td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
													<td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
													<td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
													<td>
<?php foreach ($user->groups as $group): ?>
														<span class="badge badge-default"><?php echo htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8'); ?></span>
<?php endforeach; ?>
													</td>
													<td><?php echo ($user->active) ? anchor('backend/users/deactivate/' . $user->id, 'Active', $user_active) : anchor('backend/users/activate/'. $user->id, 'Inactive', $user_inactive); ?></td>
													<td><?php echo anchor('backend/users/edit/' . $user->id, 'Edit', array('class' => 'btn btn-primary btn-sm', 'role' => 'button')); ?></td>
												</tr>
<?php endforeach; ?>
											</tbody>
										</table>
									</div>
									<div class="tab-pane" id="help" role="tabpanel">
										coming soon
									</div>
								</div>
 							</div>
						</div>
