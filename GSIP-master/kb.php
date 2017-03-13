<?php  
  
  /*
    This script provides the webpage for the Knowledge Base under GSIP.
    Author : c5212215 ( Nithin SM )
  */

  //Allow this site to be loaded directly
  $direct = 1;

  //Name of the page which is used while redirecting back to the same site after external execution
  $title = "kb.php" ;

  //Provides Access information
  require 'files/manage_access.php' ;

  //Provides socket functionality  
  require 'files/socket.php' ;

  //Logs the access to the page
  require 'files/log.php' ;

  // Do the task if the GET Parameter is passed 
  if (isset($_GET['kb_file']))
  {
    var_dump($_GET) ;
    //if no delete access then redirect with error
    if ( ! isset($access_delete_entry) or $access_delete_entry == 0 )
    {
      header( "Location: /kb.php?error=Unauthorised. Cannot delete the file" ) ;
      exit ;
    }

    if ( isset($_GET['kb_file']) )
    {
      $file = $_GET['kb_file'] ;
      if ( unlink('/var/www/cockpit/sop/' . $file) )
      {
        cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Deleted : " . $_GET['kb_file'] ) ;
        header( "Location: /kb.php?message=" . $file ." Successfully deleted" ) ;
        exit ;
      }else
      {
        header( "Location: /kb.php?error='" . $file ."' deletion failed.. Contact administrator" ) ;
        exit ;
      }

    }
  }
?>

<?php
  
  //Code to enable upload functionality
  if ( isset($_FILES) and isset($_REQUEST['confirm']) )
  {
    var_dump($_FILES) ;
    $target_dir = '/var/www/cockpit/sop/';
    $target_file = $target_dir . $_FILES['file']['name'] ;
    if ( $_FILES['file']['tmp_name'] == "error" )
    {
      header( "Location: /kb.php?error=Maximum file size Exceeded" ) ;
      exit ;
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) 
    {
      cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Uploaded : " . $target_file) ;
      header( "Location: /kb.php?message=Upload Successful" ) ;
      exit ;
    }else
    {
      header( "Location: /kb.php?error=Failed to upload file" ) ;
      exit ;
    }
  }
?>

<html>
	<head>
		<?php
      //Head part of html
			require 'files/head.php' ;
		?>
	</head>

	<body>
		<div class="container-fluid">

      <?php
        //Loads the banner part
        require 'files/header.php' ;
      ?>
      
  		<div class="row">

  			<?php
          //Loads the different category panel
  				require 'files/category.php'
  			?>

        <div class="col-md-6 col-lg-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                <b>Knowledge Base</b>
              </div>
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <button id="kb_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide('kb') " style="float: right;" title="Hide or Display this field"><span id="kb_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
              </div>
            </div>
          </div>
          <div class="panel-body fixed-panel" id="kb"> 
            <br>        

            <?php
             //Display functionalities based on authentication
             if( isset($_COOKIE['authentication-token']) ) {
              echo '<p><b>Note: Please upload files in PDF format. Size limit per file is 200MB</b></p>';
              echo '<form action="/kb.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="confirm" value="1">
                <div class="input-group">
                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                <span class="input-group-addon btn btn-primary btn-file"><span class="fileinput-new"><span class="fa fa-upload"></span> &nbsp;Upload a Document</span><span class="fileinput-exists"><span class="fa fa-exchange"></span> &nbsp;Change</span>&nbsp;&nbsp;<input type="file" name="file" accept=".pdf"></span>
                <span class="input-group-addon btn btn-success fileinput-exists"><button class="btn-primary fileinput-exists" type="submit" id="submitBtn"><span class="fa fa-upload"></span> &nbsp;Upload file</button></span>
                </div>
                </div>
              </form>' ;
              echo '<br>' ;
            }

            echo '<p><b>List of File(s) available for download: </b></p>';
            echo '<table class="table-responsive table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Filename</th>
                <th>Download</th>' ;
            //If user has delete access then allow kb to be deleted
            if( isset($access_delete_entry) and $access_delete_entry == 1 ) {
              echo '<th>Action</th>' ;
            }
            echo '</tr>
            </thead>
            <tbody>' ;

            $count = 0 ;
            $dir = '/var/www/cockpit/sop' ;

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
                echo '<td> <span class="fa fa-file-pdf-o"></span> &nbsp;' . ucwords($tmp[0]) . '</td>';
                echo '<td><a href="/sop/' . $x . '" title="' . ucwords($tmp[0]) . '" target="_blank"><span class="fa fa-download"></span> &nbsp;Click here to download</a></td>' ;
                if( isset($access_delete_entry) and $access_delete_entry == 1 ) 
                {
                  $gets_option = urlencode( $x ) ;
                  echo '<td><a href="/kb.php?kb_file=' . $gets_option .  '" title="' . ucwords($tmp[0]) . '"  onclick="return check_confirm()"><span class="fa fa-eraser"></span> &nbsp;Delete</a></td>' ;
                }
                echo '</tr>' ;
              }

            }

            ?>
            </tbody>
          </table>
          <br />

          </div>
          </div>
        </div>

    		<?php
    			require 'files/important_links.php'
    		?>

  		</div>
		</div>
	</body>
</html>
