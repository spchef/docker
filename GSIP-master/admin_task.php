<?php

	/*
		This script provides the webpage for the admin task under GSIP.
		Author : c5212215 ( Nithin SM )
	*/

	// Allow the site to be loaded directly
  	$direct = 1 ;

  	//Name of the script. This is useful incase of redirection to the same page
  	$title = "admin_task.php" ;

  	//Gives access related information  	
  	require 'files/manage_access.php' ;

  	//Has function that helps in uploading filefrom the client
  	require 'files/file_upload.php' ;

  	//Function that aids in socket communication
	require 'files/socket.php' ;

	//Redirect if user doesnt have access to the admin page
	if( !  isset($access_admin_task)  or $access_admin_task == 0  ) {
      header( "Location: /?error=Invalid Access. You dont have permission to access this link" ) ;
      exit ;
  	}

  	//Perform function based on the task
	if ( isset($_GET['task']) )
	{
		//Admin libraries has the functions for different admin tasks
		require 'files/admin_libraries.php' ;
		$usernames = $_REQUEST['user_names']  ;
		$password = $_REQUEST['pass_words'] ;
		$server_list = $_REQUEST['server_list'] ;

		//Load mcafee check
		if ( $_GET['task'] == "mcafee_check" )
		{		
			$usernames = join('::' , $usernames) ;
			$password = join('::' , $password) ;
			if ( isset($_FILES['mcafeefile']['tmp_name']) )
			{
				$server_list = file_upload($_FILES['mcafeefile']['tmp_name']) ;
			}else
			{
				$server_list = $_REQUEST['mcafee_server_list'] ;
			}
			mcafee_check( $usernames , $password , $server_list ) ;
			exit ;
		}

		//Load pihana quality check
		if ( $_GET['task'] == "pihana_check" )
		{
			$usernames = join('::' , $usernames) ;
			$password = join('::' , $password) ;
			if ( isset($_FILES['pihanafile']['tmp_name']) and $_FILES['pihanafile']['tmp_name'] != "" )
			{
				$server_list = file_upload($_FILES['pihanafile']['tmp_name']) ;
			}else
			{
				$server_list = $_REQUEST['pihana_server_list'] ;
			}
			$email_id = $_REQUEST['email_id'] ;
			pihana_check( $usernames , $password , $server_list, $email_id) ;
			exit ;
		}

		//Load sid check
		if ( $_GET['task'] == "sid_check" )
		{
			$usernames = join('::' , $usernames) ;
			$password = join('::' , $password) ;
			if ( isset($_FILES['sidfile']['tmp_name']) and $_FILES['sidfile']['tmp_name'] != "" )
			{
				$server_list = file_upload($_FILES['sidfile']['tmp_name']) ;
			}else
			{
				$server_list = $_REQUEST['sid_server_list'] ;
			}
			sid_check( $usernames , $password , $server_list ) ;
			exit ;
		}

		//load sshrun
		if ( $_GET['task'] == "sshrun_check" )
		{
			$command = $_REQUEST['ssh_command'] ;
			$usernames = join('::' , $usernames) ;
			$password = join('::' , $password) ;
			if ( isset($_FILES['sshrunfile']['tmp_name']) and $_FILES['sshrunfile']['tmp_name'] != "" )
			{
				$server_list = file_upload($_FILES['sshrunfile']['tmp_name']) ;
			}else
			{
				$server_list = $_REQUEST['sshrun_server_list'] ;
			}
			run_ssh( $usernames , $password , $server_list , $command ) ;
			exit ;
		}

		//helps in getting the pihana quality file
		if ( $_GET['task'] == "get_file" )
		{
			$file_name = $_GET['filename'] ;
			get_qual_file($file_name);
			exit ;
		}

		//get pihana quality files that are non compliant
		if ( $_GET['task'] == "pihana_check_days" )
		{
			
			$days = intval($_GET['noOfDays']) ;
			pihana_check_days( $days ) ;
			exit ;
		}

		//run ping check
		if ( $_GET['task'] == "ping_check" )
		{
			if ( isset($_FILES['pingfile']['tmp_name']) and $_FILES['pingfile']['tmp_name'] != "" )
			{
				$server_list = file_upload($_FILES['pingfile']['tmp_name']) ;
			}else
			{
				$server_list = $_REQUEST['ping_server_list'] ;
			}
			ping_check( $server_list ) ;
			exit ;
		}

		//run ldap check
		if ( $_GET['task'] == "ldap_check" )
		{
			if ( isset($_FILES['ldapfile']['tmp_name']) and $_FILES['ldapfile']['tmp_name'] != "" )
			{
				$server_list = file_upload($_FILES['ldapfile']['tmp_name']) ;
			}else
			{
				$server_list = $_REQUEST['ldap_server_list'] ;
			}
			ldap_check( $server_list ) ;
			exit ;
		}
	}
?>

<html>
	<head>
		<?php
			//Head part of html
			require 'files/head.php' ;

			//Has forms related to different administrative tasks
			require 'files/php_forms.php' ;
		?>
	</head>
	<body>
		<div class="container-fluid">
      	<?php
      	 //Load banner part
       	 require 'files/header.php' ;
      	?>
	    
  		<div class="row">
  			<?php
  				//load the side panel
  				require 'files/category.php'
  			?>
        
        <!-- Admin task main panel -->
        <div class="col-md-6 col-lg-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
              <b>Administrator Related Tasks </b>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              <button id="admin_task_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide('admin_task') " style="float: right;" title="Hide or Display this field"><span id="admin_task_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
            </div>
            </div>
          </div>
          <div class="panel-body fixed-panel " id="admin_task">
            <br>           		
    		<ol class="list-unstyled nav nav-pills nav-stacked" >
	          
	          <li title="Check Mcafee Status and version on group of servers"><button class="btn btn-link"  data-toggle="modal" data-target="#mcafee_check_toggle" ><h5 ><b style="color: brown;">Mcafee status Check</b></h5></button>


	          	<div id="mcafee_check_toggle" class="modal fade" role="dialog">
		            <div class="modal-dialog">

		              <!-- Modal content-->
		              <div class="modal-content">
		                <div class="modal-header" style="color: black;">
		                  <button type="button" class="close" data-dismiss="modal">&times;</button>
		                  <h4 class="modal-title">Mcafee Check: </h4>
		                </div>
		                <div class="modal-body">
		                  <?php 
						  	mcafee_form() ;
						  ?>	
		                </div>
		                <div class="modal-footer">
		                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		                </div>
		              </div>

		            </div>
		          </div>				  
	           </li>

	           <li title="Run Command over ssh on a group of servers"><button class="btn btn-link"  data-toggle="modal" data-target="#sshrun_check_toggle" ><h5 ><b style="color: brown;">Run Command Over SSH <sup><b style="color: red">(new)</b></sup></b></h5></button>


	          	<div id="sshrun_check_toggle" class="modal fade" role="dialog">
		            <div class="modal-dialog">

		              <!-- Modal content-->
		              <div class="modal-content">
		                <div class="modal-header" style="color: black;">
		                  <button type="button" class="close" data-dismiss="modal">&times;</button>
		                  <h4 class="modal-title">Run Command Over SSH: </h4>
		                </div>
		                <div class="modal-body">
		                  <?php 
						  	run_ssh_command() ;
						  ?>	
		                </div>
		                <div class="modal-footer">
		                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		                </div>
		              </div>

		            </div>
		          </div>				  
	           </li>


	          <li title="Inititate PI Hana Quality check on a group of servers"><button class="btn btn-link"  data-toggle="modal" data-target="#pihana_check_toggle"  ><h5 ><b style="color: brown;">PI Hana Quality Check</b></h5></button>
	          	<div id="pihana_check_toggle" class="modal fade" role="dialog">
		            <div class="modal-dialog modal-lg">

		              <!-- Modal content-->
		              <div class="modal-content">
		                <div class="modal-header" style="color: black;">
		                  <button type="button" class="close" data-dismiss="modal">&times;</button>
		                  <h4 class="modal-title">PIHANA Check: </h4>
		                </div>
		                <div class="modal-body">
		                  <?php 
						  	pihana_form() ;
						  ?>	
		                </div>
		                <div class="modal-footer">
		                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		                </div>
		              </div>

		            </div>
		          </div>
	          </li>

	          <li title="Check if the list of servers are reachable"><button class="btn btn-link" data-toggle="modal" data-target="#ping_check_toggle"   ><h5 ><b style="color: brown;">Ping Check</b></h5></button>
	          	  <div id="ping_check_toggle" class="modal fade" role="dialog">
		            <div class="modal-dialog">

		              <!-- Modal content-->
		              <div class="modal-content">
		                <div class="modal-header" style="color: black;">
		                  <button type="button" class="close" data-dismiss="modal">&times;</button>
		                  <h4 class="modal-title" >Ping Check: </h4>
		                </div>
		                <div class="modal-body">
		                  <?php 
						  	ping_form() ;
						  ?>	
		                </div>
		                <div class="modal-footer">
		                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		                </div>
		              </div>

		            </div>
		          </div>
	          </li>

	          <li title="Get Sid on group of servers"><button class="btn btn-link" data-toggle="modal" data-target="#sid_check_toggle"   ><h5 ><b style="color: brown;">SID Check</b></h5></button>
	          	  <div id="sid_check_toggle" class="modal fade" role="dialog">
		            <div class="modal-dialog">

		              <!-- Modal content-->
		              <div class="modal-content">
		                <div class="modal-header" style="color: black;">
		                  <button type="button" class="close" data-dismiss="modal">&times;</button>
		                  <h4 class="modal-title" >SID Check: </h4>
		                </div>
		                <div class="modal-body">
		                  <?php 
						  	sid_check() ;
						  ?>	
		                </div>
		                <div class="modal-footer">
		                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		                </div>
		              </div>

		            </div>
		          </div>
	          </li>

	          <li title="Check if the list of servers are configured with LDAP"><button class="btn btn-link" data-toggle="modal" data-target="#ldap_check_toggle" ><h5 ><b style="color: brown;">LDAP Check</b></h5></button>
		          <div id="ldap_check_toggle" class="modal fade" role="dialog">
		            <div class="modal-dialog">

		              <!-- Modal content-->
		              <div class="modal-content">
		                <div class="modal-header" style="color: black;">
		                  <button type="button" class="close" data-dismiss="modal">&times;</button>
		                  <h4 class="modal-title" >LDAP Check: </h4>
		                </div>
		                <div class="modal-body">
		                  <?php 
						  	ldap_form() ;
						  ?>	
		                </div>
		                <div class="modal-footer">
		                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		                </div>
		              </div>

		            </div>
		          </div>
	          </li>

	        </ol>
          </div>
        </div>
        </div>

		<?php
			//Important links panel
			require 'files/important_links.php'
		?>
  		</div>
		</div>
	</body>
</html>