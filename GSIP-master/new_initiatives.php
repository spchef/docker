<?php

  /*
    PHP script that renders new initiative page for the gsip site.
    Users can give new ideas to improve the day to day operations or improve the gsip site

    Author: C5212215 (Nithin SM)
  */

  //Allow the site to directly load. This is a standalone page
  $direct = 1;

  //Name of the page so that the helper scripts can redirect to the same page when required
  $title = "new_initiatives.php" ;

  //Provides access information to the page
  require 'files/manage_access.php' ;  

  //Provides socket information to the page
  require 'files/socket.php' ;

  //If form is filled and submitted. Send mail about the new information
  if ( isset($_REQUEST['name']) and isset($_REQUEST['email']) and isset($_REQUEST['short_info']) and isset($_REQUEST['detailed_info']) )
  {
      var_dump($_REQUEST) ;
      $_REQUEST['name'] = ucfirst($_REQUEST['name']) ;
      $emailid = 'nithin.sm@sap.com' ;
      $subject = 'New Initiative: ' . ucfirst($_REQUEST['short_info']) ;
      $message = '<p>Hello,<p>' . '
      
<p>' . $_REQUEST['name'] . ' with emailid ' . $_REQUEST['email'] . ' has proposed a new initiative.<p>

<h3>Message: </h3>' . '

<p><b>' . ucfirst($_REQUEST['detailed_info']) . '</b></p>

<p>Stay in Touch with the sender.<p>

<pre style="color: blue;">
Regards,

GSIP</pre>' ;

    $headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: gsip@gsip.mo.sap.corp' . "\r\n";
$headers .= 'Cc: gurushiddappa.adarakatti@sap.com,prajith.cr@sap.com' . "\r\n";

    $status = mail($emailid, $subject, $message, $headers );

    if ( $status )
    {
      header( "Location: /new_initiatives.php?message=New Initiative Proposed Successfully" ) ;
      exit ;
    }else
    {
      header( "Location: /new_initiatives.php?message=Failed Contact Administrator" ) ;
      exit ;
    }

  }
?>

<html>
	<head>
		<?php
      //Head part of HTML
			require 'files/head.php' ;
		?>
	</head>

	<body>
		<div class="container-fluid">

      <?php
        //Provides banner to the page
        require 'files/header.php' ;
      ?>
      
  		<div class="row">

  			<?php
          //provides the left side category panel to the page
  				require 'files/category.php'
  			?>

        <div class="col-md-6 col-lg-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                <b>Propose a New Initiative / Improvement</b>
              </div>
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <button id="gen_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide('gen') " style="float: right;" title="Hide or Display this field"><span id="gen_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
              </div>
            </div>
          </div>
          <div class="panel-body fixed-panel" id="gen">  
            <br>                 
            <form action="/new_initiatives.php" method="post" enctype="multipart/form-data" >
              <div class="form-group">
                <label for="fullname" >Name*</label>
                  <?php
                    //If there is access information then load the values from them
                    if ( isset($access_username))
                    {
                      echo '<input readonly required name="name" class="form-control" id="fullname" value="' . $access_username . '">' ;
                    }else
                    {
                      echo '<input required name="name" class="form-control" id="fullname" placeholder="Full Name">' ;
                    }
                  ?>
                  
              </div>
              <div class="form-group">
                <label for="inputEmail3" >Email*</label>
                <?php
                    //If there is access information then load the values from them
                    if ( isset($access_email))
                    {
                      echo '<input readonly required  type="email" name="email" class="form-control" id="inputEmail3" value="' . $access_email . '">' ;
                    }else
                    {
                      echo '<input required type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">' ;
                    }
                  ?>
                  
              </div>
              <div class="form-group">
                <label for="short_info" >Provide Short Info about the Initiative*</label>
                  <input required name="short_info" class="form-control" id="short_info" placeholder="Short Info">
              </div>
              <div class="form-group">
                <label for="detailed_info" >Details about the Inititatives*</label>
                  <textarea required name="detailed_info" class="form-control" id="detailed_info" placeholder="Detailed Info" rows="4"></textarea>
              </div>
              <button type="submit" onclick="return confirm_submit()" class="btn btn-primary">Submit the Initiative</button>
            </form>   
            <br>        
          </div>
          </div>
        </div>

    		<?php
          //Provides the important links panel to the page
    			require 'files/important_links.php'
    		?>

  		</div>
		</div>
	</body>
</html>

