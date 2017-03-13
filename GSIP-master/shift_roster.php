<?php  
  
  /*
    Provides shift roster page of the GSIP
    Author : C5212215 ( Nithin SM )
  */

  //Allow the page to load directly. This is a standalone page
  $direct = 1;

  //Name of the page used in redirection
  $title = "shift_roster.php" ;

  //Provides access information to the page
  require 'files/manage_access.php' ;  

  //provides socket information to the page
  require 'files/socket.php' ;

  //Provides logging ability to the page
  require 'files/log.php' ;

  //Code to delete the shift roster of a specific domain. Only authourised ID can delete the shift roster or download them
  if (isset($_GET['shift_roster']) and isset($_GET['domain']))
  {
    var_dump($_GET) ;

    if ( ! isset($_COOKIE['authentication-token']))
    {
      header( "Location: /login.php?error=Unauthorised. Login with Administrator to Delete" ) ;
      exit ;
    }
    if ( isset($_GET['shift_roster']) and isset($_GET['domain']) )
    {
      $file = $_GET['shift_roster'] ;
      if ( unlink('/var/www/cockpit/shiftroster/' . $_GET['domain'] . '/'. $file) )
      {
        cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Deleted : " . '/var/www/cockpit/shiftroster/' . $_GET['domain'] . '/'. $file ) ;
        header( "Location: /shift_roster.php?message=" . $file ." Successfully deleted&domain=" . $_GET['domain'] ) ;
        exit ;
      }else
      {
        header( "Location: /shift_roster.php?error='" . $file ."' deletion failed.. Contact administrator&domain=" . $_GET['domain'] ) ;
        exit ;
      }

    }
  }
?>

<?php

  //Code to upload the shift roster to the gsip site. Only authourised ID can add the shift roster or download them
  if ( isset($_FILES) and isset($_REQUEST['type']) )
  {
    var_dump($_FILES) ;
    $_FILES['file']['name'] = preg_replace("/ /", '_' , $_FILES['file']['name'] ) ;
    $_FILES['file']['name'] = preg_replace("/&/", '_' , $_FILES['file']['name'] ) ;
    $target_dir = '/var/www/cockpit/shiftroster/' . $_REQUEST['type'] . '/' ;
    $target_file = $target_dir . $_FILES['file']['name'] ;
    if ( $_FILES['file']['tmp_name'] == "error" )
    {
      header( "Location: /sop.php?error=Maximum file size Exceeded" ) ;
      exit ;
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) 
    {
      cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Uploaded : " .  $target_file)  ;
      header( "Location: /shift_roster.php?message=Upload Successful" ) ;
      exit ;
    }else
    {
      header( "Location: /shift_roster.php?error=failed to upload file" ) ;
      exit ;
    }
  }
?>

<html>
	<head>
		<?php
      //Loads head part of html
			require 'files/head.php' ;
		?>
	</head>

	<body>
		<div class="container-fluid">

      <?php
        //Loads the banner part of the page
        require 'files/header.php' ;
      ?>
      
      <?php
          //Get the shift details and display them
          require 'files/shift_details.php'
      ?>

  		<div class="row">

  			<?php
          //Renders the category panel of the page
  				require 'files/category.php'
  			?>

        <div class="col-md-6 col-lg-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                <b>Shift Roster</b>
              </div>
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <button id="sop_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide('sop') " style="float: right;" title="Hide or Display this field"><span id="sop_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
              </div>
            </div>
          </div>
          <div class="panel-body fixed-panel" id="sop"> 
            <br>        

            <?php

              //Allow upload only when necessary access is available
             if( isset($access_shift_roster) and $access_shift_roster == 1 ) {
              echo '<p><b>Note: Please upload files in Excel format. Be sure to specify the month and year in the name of the Excel. Select appropriate domain before uploading. Size limit per file is 40MB</b></p>';
              echo '<form action="/shift_roster.php" class="form-inline" method="post" enctype="multipart/form-data">  
                <select name="type" class="form-control" id="sel1"> ' ;

              //Display shift rosters for a particular domain
              $dir = '/var/www/cockpit/shiftroster' ;
              $files = scandir($dir) ;
              foreach ($files as $x) {
                if ( preg_match("/^\./", $x) )
                {
                  continue ;
                }else
                {
                  echo '<option value="' . $x . '" >' . $x . '</option>' ;
                }
              }

              echo '</select>
                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                <span class="input-group-addon btn btn-primary btn-file"><span class="fileinput-new"><span class="fa fa-upload"></span> &nbsp;Upload Roster</span><span class="fileinput-exists"><span class="fa fa-exchange"></span> &nbsp;Change</span>&nbsp;&nbsp;<input type="file" name="file" accept=".xlsx"></span>
                <span class="input-group-addon btn btn-success fileinput-exists"><button class="btn-primary fileinput-exists" type="submit" id="submitBtn"><span class="fa fa-upload"></span> &nbsp;Upload file</button></span>
                </div>
                 ' ;
                
                echo '</form>' ;

                echo '<br>' ;
            }

            echo '<p><b>Select The Domain to display the shift rosters: </b></p>';
            
            echo '<form class="form-inline" action="/shift_roster.php" method="post" enctype="multipart/form-data">
            <select name="domain" class="form-control" id="select1"> ' ;
            $dir = '/var/www/cockpit/shiftroster' ;
            $files = scandir($dir) ;
            foreach ($files as $x) {
              if ( preg_match("/^\./", $x) )
              {
                continue ;
              }else
              {
                echo '<option value="' . $x . '" >' . $x . '</option>' ;
              }
            }
            echo '</select>
            <button type="submit" class="btn btn-default">Submit</button>
            </form>' ;

            if ( isset($_REQUEST['domain']))
            {
              echo '<table class="table-responsive table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Filename</th>
                  <th>Download</th>' ;

              if( isset($access_delete_entry) and $access_delete_entry == 1  ) {
                echo '<th>Action</th>' ;
              }
              echo '</tr>
              </thead>
              <tbody>' ;

              $count = 0 ;
              $dir = '/var/www/cockpit/shiftroster/' . $_REQUEST['domain'] ;

              $files = scandir($dir) ;
              foreach ($files as $x) {
                if ( preg_match("/^\./", $x) )
                {
                  continue ;
                }else
                {
                  $count++ ;
                  $tmp = explode('.', $x) ;
                  echo '<tr>' ;
                  echo '<td>' . $count . '</td>' ;
                  echo '<td> <span class="fa fa-file-excel-o"></span> &nbsp;' . ucwords($tmp[0]) . '</td>';
                  echo '<td><a href="/shiftroster/' . $_REQUEST['domain'] . '/' . $x . '" title="' . ucwords($tmp[0]) . '"><span class="fa fa-download"></span> &nbsp;Click here to download</a></td>' ;
                  if( isset($access_delete_entry) and $access_delete_entry == 1 ) 
                  {
                    $gets_option = urlencode( $x ) ;
                    echo '<td><a href="/shift_roster.php?shift_roster=' . $gets_option .  '&domain=' . $_REQUEST['domain'] . '" title="' . ucwords($tmp[0]) . '"  onclick="return check_confirm()"><span class="fa fa-eraser"></span> &nbsp;Delete</a></td>' ;
                  }
                  echo '</tr>' ;
                }
                
              }
              echo '
                </tbody>
              </table>
              <br />' ;
            }

          ?>
          </div>
          </div>          
        </div>

    		<?php
          //Load the important links panel
    			require 'files/important_links.php'
    		?>

  		</div>
		</div>
	</body>
</html>
