<html>
	<head>
		<?php
      /*
        Enable the support colleague to handover the updates in the shift and get the information from the previous shift
        Stil under developement

        Author: C5212215
      */

      //Load the site directly.. This is a standalone page
			$direct = 1 ;

      //title of the page used in redirection
      $title = "shift_update.php" ;

      //Provides access information
      require 'files/manage_access.php' ;

      //provides head part of html
			require 'files/head.php' ;

      //provides socket functionality
      require 'files/socket.php' ;
		?>

    <script type="text/javascript">
      function deleteSpecificRow ( tableid )
      {
        var row = prompt('Enter Row no to delete particular row:\n\nNote: -1 refers to the last row and you cannot delete row 0 which is the header\n', -1); 
       
        if ( row != null && row != '' ) 
        { 
           row = parseInt(row) ;
           if ( isNaN(row) )
           {
              alert("Invalid Row No.. Not a Number");
              return;
           }
          deleteRowHandover( tableid , row) ;
        }
      }
    </script>
	</head>
  <?php
      if ( isset($_GET['task']) and $_GET['task'] == "update_shift_details" ) 
      {
        var_dump($_REQUEST) ;
        exit ;
      }
  ?>
	<body>
		<div class="container-fluid">
      <?php
        require 'files/header.php' ;
      ?>
      
  		<div class="row">

  			<?php
  				require 'files/category.php'
  			?>

        <div class="col-md-6 col-lg-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                <b>Shift Update</b>
              </div>
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <button id="gen_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide('gen') " style="float: right;" title="Hide or Display this field"><span id="gen_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
              </div>
            </div>
          </div>
          <div class="panel-body fixed-panel" id="gen"> 

            <p><b> Get Details of the previous shifts: </b></p><br>
            <form class="form-inline" action="/shift_update.php?task=get_shift_details" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="shift_date" >Choose Date: </label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                    <input required type="date" name="shift_date" class="form-control input-sm" id="shift_date">
                  </div>
                </div> &nbsp;&nbsp;&nbsp;

                  <div class="form-group">
                    <label for="shift_name" >Choose Date: </label>
                    <select class="form-control" name="shift_name">
                      <option value="1" id="f_shift1">Shift 1</option>
                      <option value="2" id="f_shift2">Shift 2</option>
                      <option value="3" id="f_shift3">Shift 3</option>
                    </select>
                  </div>
                  <br><br>
                  <button class="btn btn-primary" type="submit"><b>Fetch Details</b></button>
              </form>
              
              <br>
              <p><b>Update Shift Handover: </b></p>
              <button class="btn btn-primary" data-toggle="modal" data-target="#shift_handover"><b>Shift Handover</b></button>

          </div>
        </div>
        </div>


    		<?php
    			require 'files/important_links.php'
    		?>

  		</div>
		</div>


<div id="shift_handover" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" ><b>Linux Shift Handover: </b></h4>
      </div>
      <div class="modal-body" >
        <form action="/shift_update.php?task=update_shift_details" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
              <label for="user_name" >Name: </label>
              <input style="width: 300px;" readonly required type="text" name="user_name" class="form-control input-sm" id="user_name" value="<?php echo $access_username ?>">
            </div>
            <div class="form-group">
              <label for="email_id" >Email: </label>
              <input style="width: 300px;" readonly required type="text" name="email_id" class="form-control input-sm" id="email_id" value="<?php echo $access_email ?>">
            </div>
            <div class="form-group">
              <label for="today_date" >Date: </label>
              <input style="width: 300px;" id="today_date" readonly required type="date" name="today_date" class="form-control input-sm">
            </div>

            <script type="text/javascript">
              var d = new Date();
              document.getElementById("today_date").value = d.getFullYear() + "-" + d.getMonth() + "-" + d.getDate()
            </script>

          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

            <div class="form-group">
              <label for="user_id" >SAP ID: </label>
              <input style="width: 300px;" readonly required type="text" name="user_id" class="form-control input-sm" id="user_id" value="<?php echo $access_uid ?>">
            </div>

            <div class="form-group">
              <label for="curr_shift" >Shift: </label>
              <input style="width: 300px;" id="curr_shift" readonly required type="text" name="curr_shift" class="form-control input-sm" >
            </div>

            <script type="text/javascript">
              if ( Number(d.getHours()) >= 12 && Number(d.getHours()) <= 19 )
              {
                document.getElementById("curr_shift").value = "Shift 1"
              }else if ( ( Number(d.getHours()) >= 20 && Number(d.getHours()) <= 23 ) || ( Number(d.getHours()) >= 0 &&   Number(d.getHours()) <= 4 ) )
              {
                document.getElementById("curr_shift").value = "Shift 2"
              }else if ( Number(d.getHours()) >= 5 && Number(d.getHours()) <= 11 )
              {
                document.getElementById("curr_shift").value = "Shift 3"
              }
            </script>


            <div class="form-group">
              <label for="full_date" >Full Date: </label>
              <input style="width: 300px;" id="full_date" readonly required type="text" name="full_date" class="form-control input-sm">
            </div>

            <script type="text/javascript">
              var d = new Date();
              document.getElementById("full_date").value = d.toString();
            </script>


          </div>

        </div>
            <hr>
            <p><b>Tickets Handled in Shift: </b></p>
            <button onclick="addRowToHandover('handover-table')" type="button" class="btn btn-primary btn-sm"><b>Add Rows</b></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button onclick="deleteRowHandover('handover-table')" type="button" class="btn btn-primary btn-sm"><b>Delete the Last Row</b></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button onclick="deleteSpecificRow('handover-table')" type="button" class="btn btn-primary btn-sm"><b>Delete Specific Row</b></button>
            <br><br>        
            <div class="table-responsive">
              <table class="table table-striped table-bordered" id="handover-table" align="center">
              <thead>
                <tr>
                  <th>Tickets Received</th>
                  <th>Ticket's Closed / Author action/Moved/Handover</th>
                  <th>Remark</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                      <input style="width: 130px;" type="number" name="h_ticket[]" class="form-control input-sm" value="">
                  </td><td >
                      <input type="text" name="h_handover[]" class="form-control input-sm" style="width: 360px;" value="">
                  </td><td >
                      <input style="width: 200px;" type="text" name="h_remark[]" class="form-control input-sm" value="">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <hr>

          <p><b>Ticket In Progress: </b></p>
          <button onclick="addRowToProgress('inprogress-table')" type="button" class="btn btn-primary btn-sm"><b>Add Rows</b>
          </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="deleteRowHandover('inprogress-table')" type="button" class="btn btn-primary btn-sm"><b>Delete the Last Row</b></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <button onclick="deleteSpecificRow('inprogress-table')" type="button" class="btn btn-primary btn-sm"><b>Delete Specific Row</b></button><br><br> 
          <div class="table-responsive">
            <table class="table table-striped table-bordered" id="inprogress-table" align="center">
            <thead>
              <tr>
                <th>Tickets No</th>
                <th>Priority</th>
                <th>Start Date</th>
                <th>Description</th>
                <th>Action Taken</th>
                <th>Remark</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                    <input style="width: 130px;" type="number" name="p_ticket[]" class="form-control input-sm" value="">
                </td>
                <td>
                    <input style="width: 130px;" type="text" name="p_priority[]" class="form-control input-sm" id="shift_date" value="">
                </td>
                <td >
                    <input type="date" name="p_start_date[]" class="form-control input-sm" style="width: 130px;" value="">
                </td>
                <td >
                    <input style="width: 250px;" type="text" name="p_desc[]" class="form-control input-sm" value="">
                </td>
                <td >
                    <input style="width: 130px;" type="text" name="p_Action[]" class="form-control input-sm" value="">
                </td>
                <td >
                    <input style="width: 130px;" type="text" name="p_remark[]" class="form-control input-sm" value="">
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <hr>

        <p><b>Author Action: </b></p>
          <button onclick="addRowToAA('authoraction-table')" type="button" class="btn btn-primary btn-sm"><b>Add Rows</b></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <button onclick="deleteRowHandover('authoraction-table')" type="button" class="btn btn-primary btn-sm"><b>Delete the Last Row</b></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <button onclick="deleteSpecificRow('authoraction-table')" type="button" class="btn btn-primary btn-sm"><b>Delete Specific Row</b></button>
          <br><br> 
          <div class="table-responsive">
            <table class="table table-striped table-bordered" id="authoraction-table" align="center">
            <thead>
              <tr>
                <th>Tickets No</th>
                <th>Priority</th>
                <th>Date Moved to AA</th>
                <th>Status</th>
                <th>Action Taken</th>
                <th>Remark</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                    <input style="width: 130px;" type="number" name="a_ticket[]" class="form-control input-sm" value="">
                </td>
                <td>
                    <input style="width: 130px;" type="text" name="a_priority[]" class="form-control input-sm" id="shift_date" value="">
                </td>
                <td >
                    <input type="date" name="a_start_date[]" class="form-control input-sm" style="width: 130px;" value="">
                </td>
                <td >
                    <input style="width: 250px;" type="text" name="a_desc[]" class="form-control input-sm" value="">
                </td>
                <td >
                    <input style="width: 130px;" type="text" name="a_Action[]" class="form-control input-sm" value="">
                </td>
                <td >
                    <input style="width: 130px;" type="text" name="a_remark[]" class="form-control input-sm" value="">
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <hr>

        <p><b>Tickets to Monitor: </b></p>
          <button onclick="addRowToMonitor('monitor-table')" type="button" class="btn btn-primary btn-sm"><b>Add Rows</b></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="deleteRowHandover('monitor-table')" type="button" class="btn btn-primary btn-sm"><b>Delete the Last Row</b></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <button onclick="deleteSpecificRow('monitor-table')" type="button" class="btn btn-primary btn-sm"><b>Delete Specific Row</b></button><br><br> 
          <div class="table-responsive">
            <table class="table table-striped table-bordered" id="monitor-table" align="center">
            <thead>
              <tr>
                <th>Tickets No</th>
                <th>Moved Date</th>      
                <th>Status</th>
                <th>Moved To</th>
                <th>Remark</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                    <input style="width: 130px;" type="number" name="m_ticket[]" class="form-control input-sm" value="">
                </td>
                <td >
                    <input type="date" name="m_start_date[]" class="form-control input-sm" style="width: 130px;" value="">
                </td>
                <td >
                    <input style="width: 250px;" type="text" name="m_status[]" class="form-control input-sm" value="">
                </td>
                <td >
                    <input style="width: 130px;" type="text" name="m_movedto[]" class="form-control input-sm" value="">
                </td>
                <td >
                    <input style="width: 130px;" type="text" name="m_remark[]" class="form-control input-sm" value="">
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <hr>

        <p><b>Bas Server Status: </b></p>
          <button onclick="addRowToBas('bas-table')" type="button" class="btn btn-primary btn-sm"><b>Add Rows</b></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="deleteRowHandover('bas-table')" type="button" class="btn btn-primary btn-sm"><b>Delete the Last Row</b></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <button onclick="deleteSpecificRow('bas-table')" type="button" class="btn btn-primary btn-sm"><b>Delete Specific Row</b></button><br><br> 
          <div class="table-responsive">
            <table class="table table-striped table-bordered" id="bas-table" align="center">
            <thead>
              <tr>
                <th>Share</th>
                <th>Status</th>     
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                    <input style="width: 330px;" type="text" name="b_share[]" class="form-control input-sm" value="">
                </td>
                <td >
                    <input type="text" name="b_status[]" class="form-control input-sm" style="width: 400px;" value="">
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <hr>

        <p><b>Aditional Comments:  </b></p>
        <textarea name="add_comments" rows="4" cols="90"></textarea><br>
        <hr>

        <button class="btn btn-primary" type="submit"><b>Submit Handover</b></button>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


	</body>
</html>
