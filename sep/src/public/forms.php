
<?php
session_start();
?>

<head>
<script>
    function disabling()
    {
        if(document.getElementById("type_of_leave").value==="CL"){
            document.getElementById("presuf1").value = 0;
            document.getElementById("presuf2").value = 0;
            document.getElementById("presuf3").value = "No";
            document.getElementById("presuf1").disabled='false';
            document.getElementById("presuf2").disabled='false';
            document.getElementById("presuf3").disabled='false';
            
        }
        else{
            
            document.getElementById("presuf1").removeAttribute('disabled');
            document.getElementById("presuf2").removeAttribute('disabled');
            document.getElementById("presuf3").removeAttribute('disabled');
        }
        
    }
    function availing()
    {
        if(document.getElementById("presuf3").value === "Yes")
        {
            document.getElementById("encash").removeAttribute('disabled');
        }
        else
        {
            document.getElementById("encash").disabled='false';
        }
    }

    function onLoad() {
        
        var today = new Date();
        var day = today.getDate();
      // Set month to string to add leading 0
        var mon = new String(today.getMonth()+1); //January is 0!
        var yr = today.getFullYear();
      
        if(mon.length < 2) { mon = "0" + mon; }
      
        var date = new String( yr + '-' + mon + '-' + day );
        var input = document.getElementById("dateField");
        input.removeAttribute('disabled');
        input.setAttribute('value', date);
        input.setAttribute('readonly', true);
        input.setAttribute('min', date);
        var input = document.getElementById("dateField1");
        input.removeAttribute('disabled');
        input.setAttribute('min', date);
        var input = document.getElementById("dateField2");
        input.removeAttribute('disabled');
        input.setAttribute('min', date);    
    }
      window.onload = onLoad;
    //document.addEventListener('load', onLoad, false);

</script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Apply for Leave</title>
    <link href="../combox/js/bootstrap-combobox.js" rel="stylesheet">
    <link href="../combox/css/bootstrap-combobox.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

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
        <?php include 'bars.php' ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Apply for Leave</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Leave Application Form
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" action="./submit" method="post">
                                        <div class="form-group">
                                            <label>Name of Applicant</label>
                                            <input class="form-control" name="name" value = "<?php echo $_SESSION['myname']?>" readonly required>
                                        </div>

                                        <div class="form-group">
                                            <label>Designation</label>
                                            <input class="form-control" name="designation" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Department</label>
                                            <input class="form-control" name="department" value = "<?php echo $dep ?>" readonly required>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label>Nature of Leave</label>


                                            <select id="type_of_leave" class="form-control" name="nature" onClick="disabling();"   required>
                                                <option>CL</option>
                                                <option>HPL</option>
                                                <option>Vacation</option>
                                                <option>EL </option>
                                                <option>Special Casual Leave </option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Period of Leave</label>
                                            <br><label>From: </label>
                                            <input type="date" id="dateField1" class="form-control" name="period_from" required>
                                            <label>To: </label>
                                            <input type="date" id="dateField2" class="form-control" name="period_to" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Recommending Authority</label>
                                            <select class="combobox input-large form-control" name = "recommending_auth" required>
                                                <option></option>
                                                <?php while($ret = mysqli_fetch_assoc($rec)){ ?> 
                                                    <option value = "<?php echo $ret['username']; ?>"><?php echo $ret['name']; ?> </option>
                                                <?php } ?>
                                            </select>
                                            <script type="text/javascript">
                                                $(document).ready(function(){
                                                    $('.combobox').combobox();
                                                });
                                            </script>
                                        </div>
                                        <div class="form-group">
                                            <label>Approving Authority</label>
                                            <input class="form-control" name="approving_auth" value = "<?php echo $appr?>" readonly required>
                                        </div>
                                        
                                        
                                    
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                    
                                    
                                            <div class="form-group">
                                                <label>Prefix Holidays</label>
                                                <input type="number" class="form-control" id="presuf1" name="prefix_holidays" disabled="false" value=0 >
                                            </div>
                                            <div class="form-group">
                                                <label>Sufix Holidays</label>
                                                <input type="number" class="form-control" id="presuf2" name="sufix_holidays" disabled="false" value=0 >
                                            </div>
                                            <div class="form-group">
                                            <label>Proposes to avail for LTC</label>
                                            <select class="form-control" id="presuf3" name="LTC" disabled="false" value="No" onClick="availing();">
                                                <option>No</option>
                                                <option>Yes</option>
                                            </select>
                                            </div>
                                            <div class="form-group">
                                            <label>Want to encash EL?</label>
                                            <select class="form-control" id="encash" name="EL" disabled="false" value="No">
                                                <option>No</option>
                                                <option>Yes</option>
                                            </select>
                                            </div>                  
                                                                       
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input id="dateField" type="date" class="form-control" name="cur_date" min="2014-01-01" disabled required />
                                               
                                            </div>
                                            <div class="form-group">
                                                <label>Contact No. during Leave</label>
                                                <input type="number" class="form-control" name="contact">
                                            </div>
                                            <div class="form-group">
                                                <label>Address during Leave</label>
                                                <textarea class="form-control" cols="10" rows="6" name="address"></textarea>
                                            </div>
                                       <button type="submit" class="btn btn-default">Submit Button</button>
                                        <button type="reset" class="btn btn-default">Reset Button</button>
                                    </form>
                                    
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
