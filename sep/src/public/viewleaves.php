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
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
        <?php include 'bars.php' ?>
        <div id="page-wrapper">
            <!-- add content here -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">My Applications</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Click on the Application ID to view full application.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Application ID </th>
                                        
                                        <th>Nature of Leave</th>
                                        <th>Recommending Authority</th>
                                        <th>Approving Authority</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php while($res = mysqli_fetch_assoc($rec)){ ?>
                                    <tr  class = <?php 
                                        if($res['status']=='Awaiting Recommendation') {
                                            echo "warning";
                                        }
                                        else if($res['status']=='Approved'){
                                            echo "success";
                                        }
                                        else if($res['status']=='Recommended'){
                                            echo "info";
                                        }
                                        else{
                                            echo "danger";
                                        }
                                    ?> >

                                        <td><a href = "./my_leaves/<?php echo $res['application_id']; ?>"><?php echo $res['application_id']?> </a></td>
                                        
                                        <td><?php echo $res['nature'] ?></td>
                                        <td><?php echo $res['recommending_auth'] ?></td>
                                        <td> <?php echo $res['approving_auth'] ?></td>
                                        <td class="center"><?php echo $res['cur_date'] ?></td>
                                        <td><?php echo $res['status'] ?></td>
                                        
                                    </tr>
                                    <?php } ?>
                                        
                                    
                                    
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

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
