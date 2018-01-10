<div class="wrapper">

    <?php include 'include/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="green">
                            <h4 class="title"><?php echo lang('create_user_heading'); ?></h4>
                            <p class="category"><?php echo lang('create_user_subheading'); ?></p>
                        </div>
                        <div class="card-content">
                            <?php echo form_open_multipart(uri_string()); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">First Name</label>
                                        <?php echo form_input($first_name); ?>
                                        <?php echo form_error('first_name') ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Last Name</label>
                                        <?php echo form_input($last_name); ?>
                                        <?php echo form_error('last_name') ?>
                                    </div>
                                </div>
                            </div>

                            <?php if ($identity_column !== 'email') { ?>
                                <div class="form-group label-floating">
                                    <?php
                                    echo '<p>';
                                    echo lang('create_user_identity_label', 'identity');
                                    echo '<br />';
                                    echo form_error('identity');
                                    echo form_input($identity);
                                    echo '</p>';
                                    ?>
                                </div>
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label id="" class="control-label">Email</label>
                                        <?php echo form_input($email); ?>

                                        <?php echo form_error('email') ?>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group label-floating">
                                        <label class="control-label">Password</label>
                                        <?php echo form_input($password); ?>

                                        <?php echo form_error('password') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group label-floating">
                                        <label class="control-label">Confirm Password</label>
                                        <?php echo form_input($password_confirm); ?>
                                        <?php echo form_error('password_confirm') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group label-floating">
                                        <label class="control-label">Role</label>
                                        <?php echo form_dropdown('accesstype', $userRole, (isset($_POST['accesstype']) ? $_POST['accesstype'] : ''), array('class' => 'form-control')); ?>
                                        <?php echo form_error('accesstype') ?>
                                    </div>
                                </div>
                            </div>
                            <?php ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="">
                                        <label id="" class="">Document 1</label>
                                        <input type="file" name="docs1">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <button type="submit" class="btn btn-success pull-left">Create User</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>