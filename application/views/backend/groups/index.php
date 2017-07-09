<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$i          = 1;
$nbr_groups = ($count_groups > 0) ? ' <span class="badge badge-info">' . $count_groups . '</span>' : NULL;

?>

						<div class="row">
							<div class="col-12">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#list" role="tab">{lang_list}<?php echo $nbr_groups; ?></a>
									</li>
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{lang_actions}</a>
										<div class="dropdown-menu">
											<?php echo anchor('backend/groups/add', '{lang_add_group}', array('class' => 'dropdown-item')); ?>
											<?php echo anchor('backend/groups/import', '{lang_import_list}', array('class' => 'dropdown-item')); ?>
											<div class="dropdown-divider"></div>
											<?php echo anchor('backend/groups/export', '{lang_export_list}', array('class' => 'dropdown-item')); ?>
										</div>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#help" role="tab">{lang_help}</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="list" role="tabpanel">
										<table class="table table-hover table-striped">
											<thead>
												<tr>
													<th>#</th>
													<th>{lang_name}</th>
													<th>{lang_color}</th>
													<th>{lang_description}</th>
													<th>{lang_actions}</th>
												</tr>
											</thead>
											<tbody>
<?php foreach ($groups as $group): ?>
												<tr>
													<th scope="row"><?php echo $i++; ?></th>
													<td><?php echo htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8'); ?></td>
													<td>-</td>
													<td><?php echo htmlspecialchars($group->description, ENT_QUOTES, 'UTF-8'); ?></td>
													<td>
														<?php echo anchor('backend/groups/edit/' . $group->id, '{lang_edit}', array('class' => 'btn btn-primary btn-sm', 'role' => 'button')); ?>
	<?php

	if ($group->id != 1)
	{
		echo anchor('#' . $group->id, '{lang_delete}', array('class' => 'btn btn-danger btn-sm', 'role' => 'button'));
	}

	?>
													</td>
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
