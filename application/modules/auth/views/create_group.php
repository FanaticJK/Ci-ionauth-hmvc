<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo lang('create_group_heading');?>
            <small><?php echo lang('create_group_subheading'); ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Create Group</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content">

							<?php echo form_open("auth/create_group");?>

							      <div class="form-group">
							            <?php echo lang('create_group_name_label', 'group_name');?> <br />
							            <?php echo form_input($group_name);?>
							      </div>

							      <div class="form-group">
							            <?php echo lang('create_group_desc_label', 'description');?> <br />
							            <?php echo form_input($description);?>
							      </div>

							      <div class="form-group"><?php echo form_submit('submit', lang('create_group_submit_btn'), array('class' => 'btn btn-success'));?></div>

							<?php echo form_close();?>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>