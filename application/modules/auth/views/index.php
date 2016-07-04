<!-- Right side column. Contains the navbar and content of the page -->
	<div class="page-heading">
        <h3>
            <?php echo lang('index_heading');?>
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active"> <?php echo lang('index_heading');?> </li>
        </ul>
    </div>
	<!-- Main content -->
	<section class="wrapper">
        <?php if($message) { ?>
        <div class="alert alert-success fade in">
            <button type="button" class="close close-sm" data-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            <?php echo $message;?>
        </div>
        <?php 
            }
        ?>
		<!--<div id="infoMessage"><?php echo $message;?></div>-->
		<p><?php echo lang('index_subheading');?></p>
		<div class="row">
			<div class="col-xs-12">
				<div class="panel">
                    <header class="panel-heading">
                        Users
                    </header>
					<div class="box-body table-responsive">
						<table class="table">
							<tr>
                                <th>Users No</th>
								<th><?php echo lang('index_fname_th');?></th>
								<th><?php echo lang('index_lname_th');?></th>
								<th><?php echo lang('index_email_th');?></th>
								<th><?php echo lang('index_groups_th');?></th>
								<th><?php echo lang('index_status_th');?></th>
								<th><?php echo lang('index_action_th');?></th>
							</tr>
							<?php foreach ($users as $user):?>
								<tr>
                                    <td><?php echo htmlspecialchars($user->id,ENT_QUOTES,'UTF-8');?></td>
									<td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
									<td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
									<td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
									<td>
										<?php foreach ($user->groups as $group):?>
											<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
										<?php endforeach?>
									</td>
									<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
									<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
								</tr>
							<?php endforeach;?>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
		<p><?php echo anchor('auth/create_user', lang('index_create_user_link'),"class='btn btn-primary'")?>  <?php //echo anchor('auth/create_group', lang('index_create_group_link'),"class='btn btn-primary'")?> <a href="<?php echo base_url(); ?>" class="btn btn-danger" type="button">Dashboard</a></p>
	</section><!-- /.content -->
<!-- /.right-side -->