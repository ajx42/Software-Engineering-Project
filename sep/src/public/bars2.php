 <?php
    session_start();
    if(!isset($_SESSION['username'])) http_get("./");
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
                <a class="navbar-brand" href="./admin.php">Hi! <?php echo $myname; ?></a>
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
                        <li><a href="./admin"><i class="fa fa-user fa-fw"></i> Site News</a>
                        </li>
                        <!--li><a href="./settings"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li-->
                        <li class="divider"></li>
                        <li><a href="./"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                        <!--li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            
                        </li-->
                        <br>
                        <br>
                        <li>
                            <center><img src="iiti_logo.png" alt="IIT Indore" style="width:100px;height:100px;"></center>
                        
                        <br>
                        <br>
                        </li>
                         <li>
                            <a href="./admin"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="./add_news"><i class="fa fa-dashboard fa-fw"></i> Add Site News</a>
                        </li>
                        <li>
                            <a href="./view_all_apps"><i class="fa fa-edit fa-fw"></i> All Applications</a>
                        </li>
                        <li>
                            <a href="./view_all_users"><i class="fa fa-edit fa-fw"></i> All Users</a>
                        </li>
                        <li>
                          <a href="./settings"><i class="fa fa-wrench fa-fw"></i> Account Settings</a>
                        </li>
                        <li>
                          <a href="./add_new_account_holder"><i class="fa fa-wrench fa-fw"></i> Create New Account</a>
                        </li>
                         <li>
                            <a href="./view-all-joining"><i class="fa fa-edit fa-fw"></i> All Joining Reports</a>
                        </li>
                        <li>
                            <a href="./departments"><i class="fa fa-edit fa-fw"></i> Departments</a>
                        </li>
                        <!--li>
                            <a href="./balance"><i class="fa fa-dashboard fa-fw"></i> Leave Balance</a>
                        </li>
                         <li>
                            <a href="./my_leaves"><i class="fa fa-dashboard fa-fw"></i> Leave History</a>
                        </li>
                        <li>
                            <a href="./settings"><i class="fa fa-wrench fa-fw"></i> Account Settings</a>
                        </li-->


                        <!--li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>Charts<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">Flot Charts</a>
                                </li>
                                <li>
                                    <a href="morris.html">Morris.js Charts</a>
                                </li>
                            </ul>
                            
                        </li-->
                        
                        
                        
                        
                       
                        <!--li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                   
                                </li>
                            </ul>
                           
                        </li-->
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
