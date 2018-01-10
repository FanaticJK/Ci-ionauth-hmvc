<?php
/**
 * Created by PhpStorm.
 * User: Ultrabyte
 * Date: 1/10/2018
 * Time: 12:08 PM
 */
?>
<div class="wrapper">

    <?php include 'include/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Users
                <small>List User</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">List Users</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content table-responsive">
                                    <table class="table">
                                        <thead class="text-primary">
                                        <th>S No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = $pages + 1;
                                        foreach ($listUsers as $userDetail): ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $userDetail['first_name'] . " " . $userDetail['last_name']; ?></td>
                                                <td><?php echo $userDetail['email']; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url('auth/edit_user/' . $userDetail['id']); ?>"
                                                       title="Edit" rel="tooltip"><i class="fa fa-pencil-square-o"></i></a>
                                                    | <a
                                                            href="javascript:void(0)" rel="tooltip"
                                                            onclick="deleteUser('delete_user', '<?php echo $userDetail['id']; ?>')"
                                                            title="Delete"><i
                                                                class="fa fa-trash text-danger"></i></a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <div class="clear pagination">
                                        <ul>
                                            <?php echo $this->pagination->create_links(); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!--bootbox confirm-->
<script src="<?php echo base_url(); ?>assets/js/bootbox.js"></script>
<script>
    function deleteUser(msg, id) {
        delurl = '<?php echo base_url();?>auth/' + msg + '/' + id;
        bootbox.confirm({
            size: "small",
            message: "Delete User?",
            callback: function (result) {
                if (result) {
                    window.location.replace(delurl);
                } else {

                }
            }
        });
    }

    function toggleActivation(msg, id) {
        delurl = '<?php echo base_url();?>auth/' + msg + '/' + id;
        bootbox.confirm({
            size: "small",
            message: msg + " User?",
            callback: function (result) {
                if (result) {
                    window.location.replace(delurl);
                } else {

                }
            }
        });
    }
</script>