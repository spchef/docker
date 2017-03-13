<?php

		/*
		     Has various admin tasks that are supported by GSIP

		     Author: C5212215 ( Nithin SM )
		*/

		//Provides logging ability to GSIP
		require 'files/log.php' ;

		//This is not a standalone script. Cannot load it directly unless called from the standalone script
		if (!isset($direct))
		{
			header( "Location: /admin_task.php?error=Cannot Load Directly" ) ;
     	 	exit ;
		}

		function mcafee_check( $usernames , $password , $server_list )
		{

			$direct = 1 ;

			global $access_username,$access_uid,$access_password,$access_create_account,$access_delete_entry, $access_add_entry,$access_admin_task,$access_shift_roster;

			cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Accessed Macfee Check for  " . $server_list . " With usernames " . $usernames ) ;

			$cmd = 'mcafee_check:-' . $usernames . ':-' . $password . ':-' . $server_list . "\n" ;
		    $out = socket( $cmd , $title ) ;
		    $out = json_decode($out) ;  
		    $status = array_shift($out) ;
		    $value = array_shift($out) ;
		    $out = json_decode($value) ;

			if ( ! isset($usernames) or ! isset($password) or ! isset($server_list) )
			{
				header( "Location: /admin_task.php?error=Cannot Load Directly" ) ;
     	 		exit ;
			}
			
			echo '<html>
			<head> ' ;
			
			require 'files/head.php' ;

			echo '</head>
			<body>
			<div class="container-fluid">' ;

			require 'files/header.php' ;

			echo '<br>
			<div class="panel panel-primary">' ;

		    if ( $status == 6 )
		    {
		    	header( "Location: /admin_task.php?error=No of Usernames and Passwords donot match " ) ;
		        exit ;
		    }

		    if ( $status != 0 )
		    {
		    	header( "Location: /admin_task.php?error=Received Status " . $status . '  Which is greater than 0. Contact Administrator' ) ;
		        exit ;
		    }

			echo '<div class="panel-heading">
            <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
              <b>Mcafee Agent Check </b>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              <button id="mcafee_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide(\'mcafee\')" style="float: right;" title="Hide or Display this field"><span id="mcafee_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
            </div>
            </div>
          	</div>
          	<div class="panel-body" id="mcafee">
            <br>' ;

            echo '<div id="btn_mcafee_table">
		    <button type="button" class="btn btn-default" onclick="exportAndHide(\'mcafee_table\' , \'btn_mcafee_table\')">Export the Table</button>
		    <br><br>
		    </div>' ;
            echo '<div class="table-responsive">
            <table class="table table-hover table-bordered " id="mcafee_table">
              <thead>
                <tr>
                <th>S.No</th>
                <th>Server Name</th>' ;

            $headings = array( 'VSE Version' , 'DAT Version' , 'Engine Version' , 'Onaccess Scan' , 'Agent Version' , 'HF Installed' , 'OS Version' , 'CustomProps1' , 'CustomProps2' , 'CustomProps4' ) ;

            foreach ( $headings as $x )
            {
            	echo '<th>'. $x . '</th>' ;
            }

            echo '</tr>
              </thead>
              <tbody>' ;
		    $count = 0 ;

		    foreach ( $out as $x ) 
		    {
		    	$value = json_decode($x , true) ;
		    	foreach ( $value as $y => $y_value )
		    	{	
	    		   $count++ ;
	    		   echo '<tr>' ;
	    		   echo '<td>' . $count . '</td>' ;
	    		   echo '<td>' . $y . '</td>' ;
	    		   if ( isset($y_value['ping']) )
	    		   {
	    		   	  echo '<td colspan="10">'. $y_value['ping'] . '</td>' ;
	    		   }elseif (isset($y_value['login'])) {
	    		   	  echo '<td colspan="10">'. $y_value['login'] . '</td>' ;
	    		   }else
	    		   {
	    		   	   foreach ( $headings as $z )
			           {			
			           		if ( ! isset($y_value[$z]))
			           		{
			           			$y_value[$z] = "Nil" ;
			           		}    

			            	echo '<td>'. $y_value[$z] . '</td>' ;
			           }		    		   	  
	    		   }		    		   
		           echo '</tr>' ;
		    	}		    
		    }

		    echo '
                </tbody>
              </table>
              </div>
              <br />' ;

            echo '<br>&nbsp;&nbsp;
            <a href="javascript:history.go(-1)"><button class="btn btn-primary">Back</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/"><button class="btn btn-primary">Go Home</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/admin_task.php"><button class="btn btn-primary">Go to Admin Page</button></a>
            </div>			
			</div>

			</div>
			</body>
			</html>' ;

		    exit ;
		}

		function run_ssh( $usernames , $password , $server_list , $command )
		{

			$direct = 1 ;

			global $access_username,$access_uid,$access_password,$access_create_account,$access_delete_entry, $access_add_entry,$access_admin_task,$access_shift_roster;

			cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Accessed run over ssh for  " . $server_list . " With usernames " . $usernames . " and command " . $command ) ;

			$cmd = 'run_ssh:-' . $usernames . ':-' . $password . ':-' . $server_list . ':-' . $command . "\n" ;
		    $out = socket( $cmd , $title ) ;
		    $out = json_decode($out) ;  
		    $status = array_shift($out) ;
		    $value = array_shift($out) ;
		    $out = json_decode($value) ;

			if ( ! isset($usernames) or ! isset($password) or ! isset($server_list) or ! isset($command) )
			{
				header( "Location: /admin_task.php?error=Cannot Load Directly" ) ;
     	 		exit ;
			}
			
			echo '<html>
			<head> ' ;
			
			require 'files/head.php' ;

			echo '</head>
			<body>
			<div class="container-fluid">' ;

			require 'files/header.php' ;

			echo '<br>
			<div class="panel panel-primary">' ;

		    if ( $status == 6 )
		    {
		    	header( "Location: /admin_task.php?error=No of Usernames and Passwords donot match " ) ;
		        exit ;
		    }

		    if ( $status != 0 )
		    {
		    	header( "Location: /admin_task.php?error=Received Status " . $status . '  Which is greater than 0. Contact Administrator' ) ;
		        exit ;
		    }

			echo '<div class="panel-heading">
            <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
              <b>Run over SSH </b>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              <button id="runssh_btn" class="btn btn-primarrunsshy  btn-xs btn-primary-custom" type="button" onclick="displayHide(\'runssh\')" style="float: right;" title="Hide or Display this field"><span id="runssh_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
            </div>
            </div>
          	</div>
          	<div class="panel-body" id="runssh">
            <br>' ;

            echo '<div id="btn_runssh_table">
		    <button type="button" class="btn btn-default" onclick="exportAndHide(\'runssh_table\' , \'btn_runssh_table\')">Export the Table</button>
		    <br><br>
		    </div>' ;
            echo '<div class="table-responsive">
            <table class="table table-hover table-bordered " id="runssh_table">
              <thead>
                <tr>
                <th>S.No</th>
                <th>Server Name</th>
                <th>STDOUT</th>
                <th>STDERR</th>
                </tr>
              </thead>
              <tbody>' ;
		    $count = 0 ;

		    foreach ( $out as $x ) 
		    {
		    	$value = json_decode($x , true) ;
		    	foreach ( $value as $y => $y_value )
		    	{	
	    		   $count++ ;
	    		   echo '<tr>' ;
	    		   echo '<td>' . $count . '</td>' ;
	    		   echo '<td>' . $y . '</td>' ;
	    		   if ( isset($y_value['ping']) )
	    		   {
	    		   	  echo '<td colspan="2">'. $y_value['ping'] . '</td>' ;
	    		   }elseif (isset($y_value['login'])) {
	    		   	  echo '<td colspan="2">'. $y_value['login'] . '</td>' ;
	    		   }else
	    		   {	
	    		   		if ( isset($y_value['stdout']) and $y_value['stdout'] != "" )
	    		   		{
	    		   			echo '<td><pre style="color: #008000;">' . $y_value['stdout'] . '</pre></td>' ;
	    		   		}else
	    		   		{
	    		   			echo '<td><pre style="color: #00008B;">Nil</pre></td>' ;
	    		   		}

	    		   	  	if ( isset($y_value['stderr']) and $y_value['stderr'] != "" )
	    		   	  	{
	    		   	  		echo '<td><pre style="color: red;">' . $y_value['stderr'] . '</pre></td>' ;
	    		   	  	}else
	    		   	  	{
	    		   	  		echo '<td><pre style="color: #00008B;">Nil</pre></td>' ;
	    		   	  	}
	    		   	  	   	  
	    		   }		    		   
		           echo '</tr>' ;
		    	}		    
		    }

		    echo '
                </tbody>
              </table>
              </div>
              <br />' ;

            echo '<br>&nbsp;&nbsp;
            <a href="javascript:history.go(-1)"><button class="btn btn-primary">Back</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/"><button class="btn btn-primary">Go Home</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/admin_task.php"><button class="btn btn-primary">Go to Admin Page</button></a>
            </div>			
			</div>

			</div>
			</body>
			</html>' ;

		    exit ;
		}

		function sid_check( $usernames , $password , $server_list )
		{

			$direct = 1 ;

			global $access_username,$access_uid,$access_password,$access_create_account,$access_delete_entry, $access_add_entry,$access_admin_task,$access_shift_roster;

			cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Accessed SID Check for  " . $server_list . " With usernames " . $usernames ) ;

			$cmd = 'sid_check:-' . $usernames . ':-' . $password . ':-' . $server_list . "\n" ;
		    $out = socket( $cmd , $title ) ;
		    $out = json_decode($out) ;  
		    $status = array_shift($out) ;
		    $value = array_shift($out) ;
		    $out = json_decode($value , true ) ;

			if ( ! isset($usernames) or ! isset($password) or ! isset($server_list) )
			{
				header( "Location: /admin_task.php?error=Cannot Load Directly" ) ;
     	 		exit ;
			}
			
			echo '<html>
			<head> ' ;
			
			require 'files/head.php' ;

			echo '</head>
			<body>
			<div class="container-fluid">' ;

			require 'files/header.php' ;

			echo '<br>
			<div class="panel panel-primary">' ;

			
		    if ( $status == 6 )
		    {
		    	header( "Location: /admin_task.php?error=No of Usernames and Passwords donot match " ) ;
		        exit ;
		    }

		    if ( $status != 0 )
		    {
		    	header( "Location: /admin_task.php?error=Received Status " . $status . '  Which is greater than 0. Contact Administrator' ) ;
		        exit ;
		    }

			echo '<div class="panel-heading">
            <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
              <b>SID Check </b>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              <button id="sid_check_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide(\'sid_check\')" style="float: right;" title="Hide or Display this field"><span id="id_check_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
            </div>
            </div>
          	</div>
          	<div class="panel-body" id="sid_check">
            <br>' ;

            echo '<div id="btn_sid_check_table">
		    <button type="button" class="btn btn-default" onclick="exportAndHide(\'sid_check_table\' , \'btn_sid_check_table\')">Export the Table</button>
		    <br><br>
		    </div>' ;
            echo '<div class="table-responsive">
            <table class="table table-hover table-bordered " id="sid_check_table">
              <thead>
                <tr>
                <th>S.No</th>
                <th>Server Name</th>
                <th>DB Type</th>
                <th>SID(s)</th>
                </tr>
              </thead>
              <tbody>' ;
		    $count = 0 ;

		    foreach ( $out as $x ) 
		    {
		    	$value = json_decode($x , true) ;
		    	foreach ( $value as $y => $y_value )
		    	{	
	    		   $count++ ;
	    		   echo '<tr>' ;
	    		   echo '<td>' . $count . '</td>' ;
	    		   echo '<td>' . $y . '</td>' ;
	    		   if ( isset($y_value['ping']) )
	    		   {
	    		   	  echo '<td colspan="2" class="danger">'. $y_value['ping'] . '</td>' ;
	    		   }elseif (isset($y_value['login'])) {
	    		   	  echo '<td colspan="2" class="danger">'. $y_value['login'] . '</td>' ;
	    		   }elseif (isset($y_value['os'])) {
	    		   	  echo '<td colspan="2" class="danger">'. $y_value['os'] . '</td>' ;
	    		   }else
	    		   {
	    		   	  echo '<td>' . ucwords($y_value['db type']) . '</td>' ;
	    		   	  echo '<td>' . strtoupper($y_value['sid']) . '</td>' ;      		  	 	  
	    		   }		    		   
		           echo '</tr>' ;
		    	}		    
		    }

		    echo '
                </tbody>
              </table>
              </div>
              <br />' ;

            echo '<br>&nbsp;&nbsp;
            <a href="javascript:history.go(-1)"><button class="btn btn-primary">Back</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/"><button class="btn btn-primary">Go Home</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/admin_task.php"><button class="btn btn-primary">Go to Admin Page</button></a>
            </div>			
			</div>

			</div>
			</body>
			</html>' ;

		    exit ;
		}


		function pihana_check( $usernames , $password , $server_list, $email_id )
		{
			$direct = 1 ;

			global $access_username,$access_uid,$access_password,$access_create_account,$access_delete_entry, $access_add_entry,$access_admin_task,$access_shift_roster;

			cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Accessed PIHANA Check for  " . $server_list . " With usernames " . $usernames ) ;

			$cmd = 'pihana_check:-' . $usernames . ':-' . $password . ':-' . $server_list . ':-' . $email_id . "\n" ;
		    $out = socket( $cmd , $title ) ;
		    $out = json_decode($out) ;  
		    $status = array_shift($out) ;
		    $value = array_shift($out) ;
		    $out = json_decode($value) ;

			if ( ! isset($usernames) or ! isset($password) or ! isset($server_list) or ! isset($email_id) )
			{
				header( "Location: /admin_task.php?error=Cannot Load Directly" ) ;
     	 		exit ;
			}

			echo '<html>
			<head> ' ;
			
			require 'files/head.php' ;

			echo '</head>
			<body>
			<div class="container-fluid">' ;

			require 'files/header.php' ;

			echo '<br>
			<div class="panel panel-primary">' ;


		    if ( $status != 0 )
		    {
		    	header( "Location: /admin_task.php?error=Received Status " . $status . '  Which is greater than 0. Contact Administrator' ) ;
		        exit ;
		    }

			echo '<div class="panel-heading">
            <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
              <b>PI Hana Quality Check </b>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              <button id="hana_qual_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide(\'hana_qual\')" style="float: right;" title="Hide or Display this field"><span id="hana_qual_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
            </div>
            </div>
          	</div>
          	<div class="panel-body" id="hana_qual">
            <br>' ;

            echo '<div id="btn_pi_hana_table">
		    <button type="button" class="btn btn-default" onclick="exportAndHide(\'pi_hana_table\' , \'btn_pi_hana_table\')">Export the Table</button>
		    <br><br>
		    </div>' ;

            echo '<div class="table-responsive">
            <table class="table table-hover table-bordered " id="pi_hana_table">
              <thead>
                <tr>
                <th>S.No</th>
                <th>Server Name</th>
                <th>Status</th>' ;

            echo '</tr>
              </thead>
              <tbody>' ;
		    $count = 0 ;

		    foreach ( $out as $x ) 
		    {
		    	$x = explode(':-', $x ) ;
		    	$server_name = array_shift($x) ;
		    	$exit_status = array_shift($x) ;
	    		   $count++ ;
	    		   echo '<tr>' ;
	    		   echo '<td>' . $count . '</td>' ;
	    		   echo '<td>' . $server_name . '</td>' ;
	    		   if ( intval($exit_status) == 0 )
	    		   {
	    		   	 echo '<td class="success">Mail Sent Successfully</td>' ;
	    		   }elseif (intval($exit_status) == 19) {
	    		   	 echo '<td class="danger">Ping Failure</td>' ;
	    		   }elseif (intval($exit_status) == 20) {
	    		   	 echo '<td class="danger">Unknown Error in Executing Script</td>' ;
	    		   }elseif (intval($exit_status) == 18) {
	    		   	 echo '<td class="danger">Password Failure</td>' ;
	    		   }else
	    		   {
	    		   	  echo '<td class="warning">Unknown error. Try Manually</td>' ;
	    		   }

		           echo '</tr>' ;		    			    
		    }

		    echo '
                </tbody>
              </table>
              </div>
              <br />' ;

            echo '<br>&nbsp;&nbsp;
			<a href="/"><button class="btn btn-primary">Go Home</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/admin_task.php"><button class="btn btn-primary">Go to Admin Page</button></a>
            </div>			
			</div>

			</div>
			</body>
			</html>' ;

		    exit ;
		}

		function pihana_check_days( $days )
		{
			$direct = 1 ;

			if ( ! isset($days) )
			{
				$days = 0 ;
			}

			global $access_username,$access_uid,$access_password,$access_create_account,$access_delete_entry, $access_add_entry,$access_admin_task,$access_shift_roster;

			cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Accessed PIHANA Output files for days " . $days ) ;

			$cmd = 'pihana_check_days:-' . $days . "\n" ;
		    $out = socket( $cmd , $title ) ;
		    $out = json_decode($out,true) ; 
		    $status = intval(array_shift($out)) ;
		    $value = array_shift($out) ;
		    $out = json_decode($value,true) ;

		    if ( $status == 1 )
		    {
		    	header( "Location: /admin_task.php?error=Not all the parameters are provided" ) ;
		        exit ;
		    }

		    if ( $status == 4 )
		    {
		    	header( "Location: /admin_task.php?error=Days cannot be greater than 7" ) ;
		        exit ;
		    }

		    if ( $status == 5 )
		    {
		    	header( "Location: /admin_task.php?error=Directory not found. Contact Administrator" ) ;
		        exit ;
		    }

		    if ( $status == 3 )
		    {
		    	header( "Location: /admin_task.php?message=No Non Complaint servers found for the given time" ) ;
		        exit ;
		    }

		    if ( $status != 0 )
		    {
		    	header( "Location: /admin_task.php?error=Received Status " . $status . '  Which is greater than 0. Contact Administrator' ) ;
		        exit ;
		    }
		    
			echo '<html>
			<head> ' ;
			
			require 'files/head.php' ;

			echo '</head>
			<body>
			<div class="container-fluid">' ;

			require 'files/header.php' ;

			echo '<br>
			<div class="panel panel-primary">' ;

			echo '<div class="panel-heading">
            <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
              <b>PI Hana Quality Check </b>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              <button id="hana_qual_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide(\'hana_qual\')" style="float: right;" title="Hide or Display this field"><span id="hana_qual_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
            </div>
            </div>
          	</div>
          	<div class="panel-body" id="hana_qual">
            <br>' ;

            echo '<div class="table-responsive">
            <table class="table table-hover table-bordered ">
              <thead>
                <tr>
                <th>S.No</th>
                <th>Server Name</th>
                <th>Time Period</th>
                <th>File</th>' ;

            echo '</tr>
              </thead>
              <tbody>' ;
		    $count = 0 ;
		    for ($y=0; $y <= $days ; $y++) 
		    {
		    	foreach ( $out[$y] as $x ) 
			    {
			    	if ( $y == 0 ){
			    		$time = "Less than a day Old" ;
			    	}else
			    	{
			    		$time = $y." Day(s) Old" ; 
			    	}
			    	trim($x) ;
			    	$x = preg_replace('/^.\//', '' , $x ) ;
			    	$temp = explode('_', $x);
			    	$server_name = array_shift($temp) ;
		    		$count++ ;
		    		echo '<tr>' ;
		    		echo '<td>' . $count . '</td>' ;
		    		echo '<td>' . $server_name . '</td>' ;
		    		echo '<td>' . $time . '</td>' ;
		    		$href = 'task=get_file&filename=' . $x ;
		    		echo '<td><a href="/admin_task.php?' . $href . '" title="' . $x . '">' . $x . '</a></td>' ;	
			        echo '</tr>' ;		    			    
			    }
			}

		    echo '
                </tbody>
              </table>
              </div>
              <br />' ;

            echo '<br>&nbsp;&nbsp;
            <a href="javascript:history.go(-1)"><button class="btn btn-primary">Back</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/"><button class="btn btn-primary">Go Home</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/admin_task.php"><button class="btn btn-primary">Go to Admin Page</button></a>
            </div>			
			</div>

			</div>
			</body>
			</html>' ;

		    exit ;
		}

		function get_qual_file ( $filename )
		{
			$direct = 1 ;

			global $access_username,$access_uid,$access_password,$access_create_account,$access_delete_entry, $access_add_entry,$access_admin_task,$access_shift_roster;

			cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Accessed PIHANA Output file for days /sapmnt/smlabsit/PIHANA/QA_Check_output/Non_Compliance/" . $filename ) ;

			$cmd = 'get_file:-' . $filename . ':-/sapmnt/smlabsit/PIHANA/QA_Check_output/Non_Compliance' . "\n" ;
		    $out = socket( $cmd , $title ) ;
		    $out = json_decode($out) ; 
		    $status = intval(array_shift($out)) ;
		    $value = array_shift($out) ;
		    $out = json_decode($value) ;

			if ( ! isset($filename) )
			{
				header( "Location: /admin_task.php?error=Cannot Load Directly" ) ;
     	 		exit ;
			}

			echo '<html>
			<head> ' ;
			
			require 'files/head.php' ;

			echo '</head>
			<body>
			<div class="container-fluid">' ;

			require 'files/header.php' ;

			echo '<br>
			<div class="panel panel-primary">' ;


		    if ( $status == 2 )
		    {
		    	header( "Location: /admin_task.php?error=Unable to open file " . $filename ) ;
		        exit ;
		    }
		    
		    if ( $status != 0 )
		    {
		    	header( "Location: /admin_task.php?error=Received Status " . $status . '  Which is greater than 0. Contact Administrator' ) ;
		        exit ;
		    }

			echo '<div class="panel-heading">
            <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
              <b>PI Hana Quality Check O/P ( ' . $filename . ' )</b>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              <button id="mcafee_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide(\'mcafee\')" style="float: right;" title="Hide or Display this field"><span id="mcafee_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
            </div>
            </div>
          	</div>
          	<div class="panel-body" id="mcafee">
            <br>' ;
            echo '<pre style="font-size: 130%;color: #000080;" >' ;
            foreach ( $out as $x ) 
		    {
		    	echo "$x" ;		    			    
		    }
		    echo '</pre>' ;
		    echo '<br />' ;

            echo '<br>&nbsp;&nbsp;
            <a href="javascript:history.go(-1)"><button class="btn btn-primary">Back</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/"><button class="btn btn-primary">Go Home</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/admin_task.php"><button class="btn btn-primary">Go to Admin Page</button></a>
            </div>			
			</div>

			</div>
			</body>
			</html>' ;

		    exit ;
		}

		function ping_check ( $server_list )
		{
			$direct = 1 ;

			global $access_username,$access_uid,$access_password,$access_create_account,$access_delete_entry, $access_add_entry,$access_admin_task,$access_shift_roster;

			cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Accessed Ping check for " . $server_list ) ;

			$cmd = 'ping_check:-' . $server_list . "\n" ;
		    $out = socket( $cmd , $title ) ;
		    $out = json_decode($out , true) ; 
		    $status = intval(array_shift($out)) ;
		    $out = array_shift($out) ;

			if ( ! isset($server_list) )
			{
				header( "Location: /admin_task.php?error=Cannot Load Directly" ) ;
     	 		exit ;
			}

			
			echo '<html>
			<head> ' ;
			
			require 'files/head.php' ;

			echo '</head>
			<body>
			<div class="container-fluid">' ;

			require 'files/header.php' ;

			echo '<br>
			<div class="panel panel-primary">' ;			

		    if ( $status != 0 )
		    {
		    	header( "Location: /admin_task.php?error=Received Status " . $status . '  Which is greater than 0. Contact Administrator' ) ;
		        exit ;
		    }

			echo '<div class="panel-heading">
            <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
              <b>Ping Check </b>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              <button id="ping_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide(\'ping\')" style="float: right;" title="Hide or Display this field"><span id="ping_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
            </div>
            </div>
          	</div>
          	<div class="panel-body" id="ping">
            <br>' ;

            echo '<div id="btn_ping_table">
		    <button type="button" class="btn btn-default" onclick="exportAndHide(\'ping_table\' , \'btn_ping_table\')">Export the Table</button>
		    <br><br>
		    </div>' ;

            $count = 0 ;
            echo '<div class="table-responsive">
            <table class="table table-hover table-bordered " id="ping_table">
              <thead>
                <tr>
                <th>S.No</th>
                <th>Server Name</th>
                <th>Ping Test</th>' ;

            echo '</tr>
              </thead>
              <tbody>' ;

            foreach ( $out as $x => $x_value )
            {
            	$count++ ;
            	echo '<tr>' ;
            	echo '<td>' . $count . '</td>' ;
            	echo '<td>' . $x . '</td>' ;
            	if ( $x_value == 1 )
            	{
            		echo '<td class="success">Ping Successful</td>' ;
            	}else
            	{
            		echo '<td class="danger">Ping Failure</td>' ;
            	}
            	echo '</tr>' ;
            }

            echo '
                </tbody>
              </table>
              </div>
              <br />' ;

            echo '<br>&nbsp;&nbsp;
            <a href="javascript:history.go(-1)"><button class="btn btn-primary">Back</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/"><button class="btn btn-primary">Go Home</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/admin_task.php"><button class="btn btn-primary">Go to Admin Page</button></a>
            </div>			
			</div>

			</div>
			</body>
			</html>' ;

		    exit ;
		}

		function ldap_check ( $server_list )
		{
			$direct = 1 ;

			global $access_username,$access_uid,$access_password,$access_create_account,$access_delete_entry, $access_add_entry,$access_admin_task,$access_shift_roster;
			
			cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Accessed LDAP check for " . $server_list ) ;

			$cmd = 'ldap_check:-' . $server_list . "\n" ;
		    $out = socket( $cmd , $title ) ;
		    $out = json_decode($out) ; 
		    $status = intval(array_shift($out)) ;
		    $value = array_shift($out) ;
		    $out = json_decode($value , true) ;

			if ( ! isset($server_list) )
			{
				header( "Location: /admin_task.php?error=Cannot Load Directly" ) ;
     	 		exit ;
			}

			echo '<html>
			<head> ' ;
			
			require 'files/head.php' ;

			echo '</head>
			<body>
			<div class="container-fluid">' ;

			require 'files/header.php' ;

			echo '<br>
			<div class="panel panel-primary">' ;

		    if ( $status != 0 )
		    {
		    	header( "Location: /admin_task.php?error=Received Status " . $status . '  Which is greater than 0. Contact Administrator' ) ;
		        exit ;
		    }		   

			echo '<div class="panel-heading">
            <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
              <b>LDAP Check </b>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              <button id="ldap_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide(\'ldap\')" style="float: right;" title="Hide or Display this field"><span id="ldap_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
            </div>
            </div>
          	</div>
          	<div class="panel-body" id="ldap">
            <br>' ;

            echo '<div id="btn_ldap_table">
		    <button type="button" class="btn btn-default" onclick="exportAndHide(\'ldap_table\' , \'btn_ldap_table\')">Export the Table</button>
		    <br><br>
		    </div>' ;
            $count = 0 ;
            echo '<div class="table-responsive">
            <table class="table table-hover table-bordered " id="ldap_table">
              <thead>
                <tr>
                <th>S.No</th>
                <th>Server Name</th>
                <th>LDAP Status</th>' ;

            echo '</tr>
              </thead>
              <tbody>' ;

            foreach ( $out as $y )
            {

            	$x = explode(':-', $y) ;
            	$servername = array_shift($x) ;
            	$status = array_shift($x) ;
            	$count++ ;
            	echo '<tr>' ;
            	echo '<td>' . $count . '</td>' ;
            	echo '<td>' . $servername . '</td>' ;
            	if ( preg_match('/not/i', $status) )
            	{
            		echo '<td class="danger">' . $status . '</td>' ;
            	}else
            	{
            		echo '<td class="success">' . $status . '</td>' ;
            	}
            	echo '</tr>' ;
            }

            echo '
                </tbody>
              </table>
              </div>
              <br />' ;

            echo '<br>&nbsp;&nbsp;
            <a href="javascript:history.go(-1)"><button class="btn btn-primary">Back</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/"><button class="btn btn-primary">Go Home</button></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/admin_task.php"><button class="btn btn-primary">Go to Admin Page</button></a>
            </div>			
			</div>

			</div>
			</body>
			</html>' ;

		    exit ;
		}
	?>
