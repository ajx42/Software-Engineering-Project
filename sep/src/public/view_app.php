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
    <link href="/sep-2/src/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/sep-2/src/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="/sep-2/src/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="/sep-2/src/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/sep-2/src/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/sep-2/src/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                    <h1 class="page-header">View Application Details</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Application: <?php echo $rec['application_id'] ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Field </th>
                                        <th>Value</th>
                                        
                                    </tr>

                                </thead>
                                <tbody>
                                    
                                    <tr class="odd gradeX">
                                    <td> <b> Name </b> </td>
                                    <td> <?php echo $rec['name'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> Nature of Leave </b> </td>
                                    <td> <?php echo $rec['nature'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> Designation </b> </td>
                                    <td> <?php echo $rec['designation'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> Department </b> </td>
                                    <td> <?php echo $rec['department'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> From </b> </td>
                                    <td> <?php echo $rec['period_from'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> To </b> </td>
                                    <td> <?php echo $rec['period_to'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> Prefix Holidays </b> </td>
                                    <td> <?php echo $rec['prefix_holidays'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> Suffix Holidays </b> </td>
                                    <td> <?php echo $rec['sufix_holidays'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> Nature of Leave </b> </td>
                                    <td> <?php echo $rec['nature'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> Apply for LTC </b> </td>
                                    <td> <?php echo $rec['LTC'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> Address</b> </td>
                                    <td> <?php echo $rec['address'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> Contact </b> </td>
                                    <td> <?php echo $rec['contact'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> Recommending Authority </b> </td>
                                    <td> <?php echo $rec['recommending_auth'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> Approving Authority </b> </td>
                                    <td> <?php echo $rec['approving_auth'] ?> </td>
                                    </tr>

                                    <tr class="odd gradeX">
                                    <td> <b> Status </b> </td>
                                    <td> <?php echo $rec['status'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> Date </b> </td>
                                    <td> <?php echo $rec['cur_date'] ?> </td>
                                    </tr>

                                    <tr class="odd gradeX">
                                    <td> <b> Remarks - Recommending Authority </b> </td>
                                    <td> <?php echo $rec['recommender_comments'] ?></td>
                                    
                                    </tr>

                                     <tr class="odd gradeX">
                                    <td> <b> Remarks - Approving Authority </b> </td>
                                    <td> <?php echo $rec['approver_comments'] ?> </td>
                                    </tr>

                                    
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
        
        
        <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a class="btn btn-default btn-md btn-block"  href="../my_leaves"><b>Back</b></a>
                        </div>
                        
                    </div>
                    <!-- /.panel -->
                </div>
                
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
                </div>
                </div>

            <!--
            <table>
                <tr>
                    <th> Field </th>
                    <th> Data </th>
                </tr>
                <tr>
                    <td> <b> Application </b> </td>
                    <td>  </td>
                </tr>
            </table>
            <!--
            <b> Applicati
        -->

    

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
