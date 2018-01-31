<?php
/**
 * Created by PhpStorm.
 * User: Ultrabyte
 * Date: 1/10/2018
 * Time: 12:08 PM
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Group
            <small>List Group</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">List Groups</li>
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
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
									<?php
									$i = $pages + 1;
									foreach ( $listgroups as $group ): ?>
                                        <tr>
                                            <td><?php echo $i ++; ?></td>
                                            <td><?php echo ucfirst( $group['name'] ); ?></td>
                                            <td>
                                                <a href="<?php echo base_url( 'auth/edit_group/' . $group['id'] ); ?>"
                                                   title="Edit" rel="tooltip"><i class="fa fa-pencil-square-o"></i></a>
                                                | <a
                                                        href="javascript:void(0)" rel="tooltip"
                                                        onclick="deleteGroup('delete_group', '<?php echo $group['id']; ?>')"
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
<!--bootbox confirm-->
<script src="<?php echo base_url(); ?>assets/js/bootbox.js"></script>
<script>
    function deleteGroup(msg, id) {
        delurl = '<?php echo base_url();?>auth/' + msg + '/' + id;
        bootbox.confirm({
            size: "small",
            message: "Delete Group?",
            callback: function (result) {
                if (result) {
                    window.location.replace(delurl);
                }
            }
        });
    }
</script>