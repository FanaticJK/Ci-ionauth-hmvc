<?php
/**
 * Created by PhpStorm.
 * User: Ultrabyte
 * Date: 1/11/2018
 * Time: 10:00 AM
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Profile
            <small>Your Details</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <div class="content">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                    </thead>
                    <tbody>
					<?php foreach ( $userData as $user ): ?>
                        <tr>
                            <td>Name</td>
                            <td><?php echo $user['first_name'] . " " . $user['last_name']; ?></td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td><?php echo $user['username']; ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?php echo $user['email']; ?></td>
                        </tr>
                        <tr>
                            <td>Created On</td>
                            <td><?php echo $user['created_on']; ?></td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td><?php echo $user['phone']; ?></td>
                        </tr>
                        <tr>
                            <td>Action</td>
                            <td><a href="<?php echo base_url( 'auth/editProfile' ); ?>">Edit Details</a></td>
                        </tr>
					<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        </section>
    </div>
</div>
</div>
