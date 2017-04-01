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
        <?php include 'bars_internal.php' ?>
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
                                    <td> <b> Recommending Authority Remark </b> </td>
                                    <td> <?php echo $rec['recommender_comments'] ?> </td>
                                    </tr>
                                    <tr class="odd gradeX">
                                    <td> <b> Approving Authority Remark </b> </td>
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
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <form role="form"  method="post">
                                    <div class="form-group">
                                        <label>Comments (Optional)</label>
                                        <textarea class="form-control" cols="10" rows="6" name="comment"></textarea>
                                    </div>

                            <!--a class="btn btn-default btn-md btn-block"  href="../recommend_app/<?php echo $rec['application_id']?>"><b>Recommend</b></a-->
                                <!--button type="submit" class="btn btn-default">Submit Button</button-->
                                <input type="submit" class="btn btn-default"  formaction="../recommend_app/<?php echo $rec['application_id']?>" value="Recommend" />
                                <input type="submit" class="btn btn-default"  formaction="../reject_app/<?php echo $rec['application_id']?>" value="Reject" />
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.panel -->
                </div>
                
            </div>
            <!-- /.row -->
                </div>
                </div>

    

    <!-- /#wrapper -->

   

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
