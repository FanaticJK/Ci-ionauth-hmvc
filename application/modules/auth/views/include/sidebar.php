<?php include 'head.php'; ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php if ($profileImage != ""):?>
                <?php if (getimagesize('./' . $profileImage) !== false):?>
                    <img src="<?php echo base_url().$profileImage; ?>" class="img-circle">
                <?php endif; ?>
                <?php else: ?>
                    <img src="<?php echo base_url('assets/dist/img/avatar.png'); ?>" class="img-circle">
                <?php endif; ?>
            </div>
            <div class="pull-left info">
                <p><?php echo $userFullName; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?php echo ($this->uri->segment(1) == '') ? 'active' : ''; ?> treeview">
                <a href="<?php echo base_url() ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li class="<?php echo ($this->uri->segment(1) == 'auth' && $this->uri->segment(1) != '' && ($this->uri->segment(2) == 'list_user' || $this->uri->segment(2) == 'create_user' || $this->uri->segment(2) == 'edit_user')) ? 'active' : ''; ?> treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Users</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'list_user' && $this->uri->segment(2) != '') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('auth/list_user'); ?>"><i class="fa fa-circle-o"></i> List User</a>
                    </li>
                    <li class="<?php echo ($this->uri->segment(2) == 'create_user' && $this->uri->segment(2) != '') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('auth/create_user'); ?>"><i class="fa fa-circle-o"></i> Create User</a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'create_group' || $this->uri->segment(2) == 'edit_group' || $this->uri->segment(2) == 'list_groups' ) ? 'active' : ''; ?> treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Groups</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'list_groups' && $this->uri->segment(2) != '') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('auth/list_groups'); ?>"><i class="fa fa-circle-o"></i> List Groups</a>
                    </li>
                    <li class="<?php echo ($this->uri->segment(2) == 'create_group' && $this->uri->segment(2) != '') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('auth/create_group'); ?>"><i class="fa fa-circle-o"></i> Create Group</a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>