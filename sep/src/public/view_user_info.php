<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>IITI LPS</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation and Side bars-->
        <?php include 'bars2.php' ?>
        <?php $res = mysqli_fetch_assoc($rec);
              $bal = mysqli_fetch_assoc($balance); 
              $type;
              if($res['type'] == 1) $type = 'General User';
              else if($res['type'] == 2) $type = 'Recommending Authority';
              else if($res['type'] == 3) $type = 'Approving Authority';
              else $type = 'LPS Administrator';
        ?>
        <div id="page-wrapper">
            <!-- add content here -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User Information</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            View/Edit Basic Information
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form role="form" action="../update_basics" method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" name="name" value = "<?php echo $res['name']?>" required>
                                        </div>
                                        
                                
                                </div>
                                <div class="col-rg-6">
                                <font color="red">Note: </font><br>
                                This will not change name on past record.
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Type of User</label>
                                            <select class="form-control" id="presuf3" name="type" >
                                                <option <?php if($res['type'] == 1)  echo 'selected'  ?>>General User </option>
                                                <option <?php if($res['type'] == 2)  echo 'selected'  ?>>Recommending Authority</option>
                                                <option <?php if($res['type'] == 3) echo 'selected'  ?>>Approving Authority</option>
                                                <option <?php if($res['type'] == 4) echo 'selected'  ?>>LPS Administrator</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="col-rg-6">
                                <font color="red">Note: </font><br>
                                    Changing may lead loss of content access to user.
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Email Notifications</label>
                                            <select class="form-control" id="presuf3" name="notifications" >
                                                <option <?php if($res['notifications'] == 1)  echo 'selected'  ?>>Enable </option>
                                                <option <?php if($res['notifications'] == 2)  echo 'selected'  ?>>Disable</option>
                                                
                                            </select>
                                        </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-default">Save</button>
                                </div>
                                <div class="col-rg-6">
                                    <font color="red">Note: </font><br>
                                        This will bring about all the above mentioned changes in the database.
                                    </div>
                                
                            </div>
                            </form>                       
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        
        <div class="row">
            <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Leave Balance
                        </div>
                        <div class="panel-body">
                            <form role="form" action="../leave_submit" method="post">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Casual Leaves</label>
                                            <input type="number" class="form-control" name="cl" value = "<?php echo $bal['CL'];?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Half Pay Leaves</label>
                                            <input type="number" class="form-control" name="hpl" value = "<?php echo $bal['HPL'];?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Earned Leaves</label>
                                            <input type="number" class="form-control" name="el" value = "<?php echo $bal['EL'];?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Vacation</label>
                                            <input type="number" class="form-control" name="vacation" value = "<?php echo $bal['Vacation'];?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-default">Save</button>
                                </div>
                                <div class="col-rg-6">
                                    <font color="red">Note: </font><br>
                                        This will bring about all the above mentioned changes in the database.
                                    </div>
                                </div>
                            
                            </form>                       
                        </div>
                    </div>

            </div>
        </div>
        </div>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

</body>

</html>
