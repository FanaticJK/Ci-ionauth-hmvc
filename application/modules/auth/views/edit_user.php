<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo lang('edit_user_heading'); ?>
            <small><?php echo lang('edit_user_subheading'); ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Edit User</li>
        </ol>
    </section>

    <!-- Main content -->
    <div class="content">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                        <div id="infoMessage"><?php echo $message; ?></div>

                        <?php echo form_open_multipart(uri_string()); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo lang('edit_user_fname_label', 'first_name'); ?> <br/>
                                    <?php echo form_input($first_name); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo lang('edit_user_lname_label', 'last_name'); ?> <br/>
                                    <?php echo form_input($last_name); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <strong>Email:</strong><br/>
                            <?php echo form_input($email); ?>
                        </div>

                        <div class="form-group">
                            <?php echo lang('edit_user_company_label', 'company'); ?> <br/>
                            <?php echo form_input($company); ?>
                        </div>

                        <div class="form-group">
                            <?php echo lang('edit_user_phone_label', 'phone'); ?> <br/>
                            <?php echo form_input($phone); ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo lang('edit_user_password_label', 'password'); ?> <br/>
                                    <?php echo form_input($password); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo lang('edit_user_password_confirm_label', 'password_confirm'); ?><br/>
                                    <?php echo form_input($password_confirm); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php if ($this->ion_auth->is_admin()): ?>

                                <h3><?php echo lang('edit_user_groups_heading'); ?></h3>
                                <?php foreach ($groups as $group): ?>
                                    <div class="radio">
                                        <label>
                                            <?php
                                            $gID = $group['id'];
                                            $checked = null;
                                            $item = null;
                                            foreach ($currentGroups as $grp) {
                                                if ($gID == $grp->id) {
                                                    $checked = ' checked="checked"';
                                                    break;
                                                }
                                            }
                                            ?>
                                            <input type="radio" name="groups[]"
                                                   value="<?php echo $group['id']; ?>"<?php echo $checked; ?>>
                                            <?php echo ucfirst(htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8')); ?>
                                        </label>
                                    </div>
                                <?php endforeach ?>

                            <?php endif ?>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="">
                                    <label id="" class="">Profile Image</label>
                                    <input type="file" name="profileImage">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <img src="<?php echo base_url($user->profile_image_url); ?>" class="img-responsive">
                            </div>
                        </div>
                        <?php echo form_hidden('id', $user->id); ?>
                        <?php echo form_hidden($csrf); ?>

                        <div class="form-group"><?php echo form_submit('submit', lang('edit_user_submit_btn'), array('class' => 'btn btn-success')); ?></div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </div>
</div>