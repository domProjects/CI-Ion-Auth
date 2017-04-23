<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nbr_groups = ($count_groups > 0) ? ' <span class="badge badge-info">' . $count_groups . '</span>' : NULL;

?>

						<div class="row">
							<div class="col-12">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#list" role="tab">List<?php echo $nbr_groups; ?></a>
									</li>
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Action</a>
										<div class="dropdown-menu">
											<?php echo anchor('backend/groups/add', 'Add group', array('class' => 'dropdown-item')); ?>
											<a class="dropdown-item" href="#">Import CSV</a>
										</div>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#help" role="tab">Aide</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="list" role="tabpanel">
										<table class="table table-hover table-striped">
											<thead>
												<tr>
													<th>#</th>
													<th>Nom</th>
													<th>Description</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
<?php foreach ($groups as $group): ?>
												<tr>
													<th scope="row">-</th>
													<td><?php echo htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8'); ?></td>
													<td><?php echo htmlspecialchars($group->description, ENT_QUOTES, 'UTF-8'); ?></td>
													<td><?php echo anchor('backend/groups/edit/' . $group->id, 'Edit', array('class' => 'btn btn-primary btn-sm', 'role' => 'button')); ?></td>
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
