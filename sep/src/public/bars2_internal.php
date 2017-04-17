 <?php
    session_start();
    if(!isset($_SESSION['username'])) http_get("../");
    else $myname = $_SESSION['myname'];
?>

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../admin.php">Hi! <?php echo $myname; ?></a>
            </div>
            <!-- /.navbar-header -->
            <!-- template hai sab -->
            <ul class="nav navbar-top-links navbar-right">
                
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="../admin"><i class="fa fa-user fa-fw"></i> Site News</a>
                        </li>
                        <!--li><a href="../settings"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li-->
                        <li class="divider"></li>
                        <li><a href="../"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            <!-- default template khatam -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                         <li>
                            <a href="../admin"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="../add_news"><i class="fa fa-dashboard fa-fw"></i> Add Site News</a>
                        </li>
                        <li>
                            <a href="../view_all_apps"><i class="fa fa-edit fa-fw"></i> All Applications</a>
                        </li>
                        <li>
                            <a href="../view_all_users"><i class="fa fa-edit fa-fw"></i> All Users</a>
                        </li>
                        <li>
                          <a href="../settings"><i class="fa fa-wrench fa-fw"></i> Account Settings</a>
                        </li>
                        <li>
                          <a href="../add_new_account_holder"><i class="fa fa-wrench fa-fw"></i> Add new acount holder</a>
                        </li>
                         <li>
                            <a href="../view-all-joining"><i class="fa fa-edit fa-fw"></i> All Joining Reports</a>
                        </li>
                       
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
