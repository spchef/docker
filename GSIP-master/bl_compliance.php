<?php
	/*
		Used to load BL Compliance check under GSIP
		Author : c5212215 ( Nithin SM )
	*/

	// Allow the site to be loaded directly
 	$direct = 1 ;
 	
 	//Name of the script. This is useful incase of redirection to the same page
 	$title = "bl_compliance.php" ;

 	//Gives access related information  
 	require 'files/manage_access.php' ;

 	//Module for drawing graph. Function uses Google graph API
 	require 'files/graph.php' ;

 	//Function that aids in socket communication
 	require 'files/socket.php' ;

 	//Logs the information related to access. 
 	require 'files/log.php' ;

 	//Redirect if user doesnt have access to the page. Only admin users can load the page
 	if( ! isset($access_admin_task) or  $access_admin_task != 1 ) 
 	{
 		header( "Location: /?error=You dont have access to this page. Contact Administrator") ;
        exit ;
    }

    //Default os to be selected
 	if ( ! isset($_GET['os']) )
 	{
 		$_GET['os'] = 'windows' ;
 	}

 	//Default chart type
 	if ( ! isset($_GET['chart_type']) )
 	{
 		$_GET['chart_type'] = 'line' ;
 	}

 	//If os is linux then assume suse is the flavor
 	if ( $_GET['os'] == 'linux' )
 	{
 		$_GET['os'] = 'suse' ;
 	}

 	//if anything else then exit
 	if ( ! ( $_GET['os'] == 'windows' or $_GET['os'] == 'redhat' or $_GET['os'] == 'suse') )
 	{
 		header( "Location: /?error=Not a valid os") ;
        exit ;
 	}


 	//Log the access to the bl report for reference
 	cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Accessed : BL_Compliance Report for " . $_GET['os'] ) ;

 	//Initiate socket to read the logfile and get the log output
	$cmd = 'read_bl_log:-' . $_GET['os'] . ':-check_based' ;
    $out = socket( $cmd , $title ) ;
    $out = json_decode($out , true ) ;  
    $status = array_shift($out) ;
    $out = array_shift($out) ;
    if ( $status == 1 )
    {
    	header( "Location: /?error=No Log Files found" ) ;
        exit ;
    }

    if ( $status != 0 )
    {
    	header( "Location: /?error=unable to process the request. Contact Administrator" ) ;
        exit ;
    }	

?>

<html>
	<head> 
	
	<?php require 'files/head.php' ?>

	</head>
	<body>
	<div class="container-fluid">

	<?php require 'files/header.php' ; ?> 

	<div class="panel panel-primary">
	<div class="panel-heading">
    <div class="row">
    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
      <b>Blade Logic Compliance Report - <?php 
      echo ucfirst($_GET['os']) ;
       ?> </b>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
      <button id="bl_comp_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide('bl_comp')" style="float: right;" title="Hide or Display this field"><span id="bl_comp_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
    </div>
    </div >
  	</div>

  	
  	<div class="panel-body" id="bl_comp">
    <br>       
    
    
    <?php
    	//Show option for different types of charts supported
    	if ( $_GET['chart_type'] == 'hist' )
    	{
    		echo '<a style="color: black" href="/bl_compliance.php?os=' . $_GET['os'] . '&chart_type=line"  title="line Chart"><button style="display: none" id="btn_chart1_type"  class="btn btn-default" type="button" ><img src="/img/line.png" alt="Line">&nbsp;&nbsp;Line Chart</button></a>&nbsp;&nbsp;&nbsp;' ;
    		echo '<a style="color: black" href="/bl_compliance.php?os=' . $_GET['os'] . '&chart_type=column" title="Bar Chart"><button style="display: none" id="btn_chart2_type" class="btn btn-default" type="button" ><img src="/img/bar.png" alt="Column">&nbsp;&nbsp;Column Chart</button></a>' ;

    	}elseif ( $_GET['chart_type'] == 'line' )
    	{
    		echo '<a style="color: black" href="/bl_compliance.php?os=' . $_GET['os'] . '&chart_type=hist" title="Bar Chart"><button style="display: none" id="btn_chart1_type" class="btn btn-default" type="button" ><img src="/img/hist.png" alt="Histogram">&nbsp;&nbsp;Histogram</button></a>&nbsp;&nbsp;&nbsp;' ;
    		echo '<a style="color: black" href="/bl_compliance.php?os=' . $_GET['os'] . '&chart_type=column" title="Bar Chart"><button style="display: none" id="btn_chart2_type" class="btn btn-default" type="button" ><img src="/img/bar.png" alt="Column">&nbsp;&nbsp;Column Chart</button></a>' ;
    	}else
    	{
    		echo '<a style="color: black" href="/bl_compliance.php?os=' . $_GET['os'] . '&chart_type=hist" title="Bar Chart"><button style="display: none" id="btn_chart1_type" class="btn btn-default" type="button" ><img src="/img/hist.png" alt="Histogram">&nbsp;&nbsp;Histogram</button></a>&nbsp;&nbsp;&nbsp;' ;
    	    echo '<a style="color: black" href="/bl_compliance.php?os=' . $_GET['os'] . '&chart_type=line"  title="line Chart"><button style="display: none" id="btn_chart2_type"  class="btn btn-default" type="button" ><img src="/img/line.png" alt="Line">&nbsp;&nbsp;Line Chart</button></a>' ;
    	}
    ?>   
     <br>
     <h4><b>Referred Files : </b></h4>
    <pre>    <?php
    	foreach ( $out['date'] as $x => $x_value )
    	{
    		echo '<p><b>' . ucfirst($x) . ' - ' . $x_value . '</b></p>' ;
    	}
    ?></pre><br> 
	<div class="table-responsive" style=" overflow-y: hidden " id="comp_graph"  style="width: 100%"></div> 
	<div class="table-responsive" style=" overflow-y: hidden " id="non_comp_grph"  style="width: 100%"></div> 
    <br>
    <div id="btn_compliance_table">
    <button type="button" class="btn btn-default" onclick="exportAndHide('compliance_table' , 'btn_compliance_table')"><img src="/img/export.png" title="Export">&nbsp;&nbsp;Export the Table</button>
    <br><br>
    </div>
	<b style="color: blue ; font-size: 16px">Note: Click on the Status to get the detailed list</b>
    <br>
    <div class="table-responsive" style="font-family: Arial, Helvetica, sans-serif">
    <table class="table table-hover sortable table-bordered " id="compliance_table">
      <thead>
        <tr>
        <th>S.No</th>
        <th>Check</th>
        <th>Compliant</th>
        <th>Non - Compliant</th>
        <th>Total</th>
        <th>% Compliant</th>
        <th>% Non - Compliant</th>
        </tr>
      </thead>
      <tbody>   
      	<?php
      		//Display the log information that is read.
      		//Displays the information obtained from the socket
      		$count = 0 ;
      		$pass_graph = [] ;
      		$fail_graph = [] ;
      		if ( $_GET['chart_type'] == 'hist' )
    		{
	      		array_push($pass_graph, "[ 'Check' , 'Value' ]") ;
	      		array_push($fail_graph, "[ 'Check' , 'Value' ]") ;
	      	}elseif ( $_GET['chart_type'] == 'column' or $_GET['chart_type'] == 'line' )
	      	{
	      		array_push($pass_graph, "[ 'Check' , 'Compliance' , 'Non Compliance' ]") ;
	      	}
      		foreach ( $out as $x => $x_value ) 
		    {
		    	if ( $x == 'date' )
		    	{
		    		continue ;
		    	}
		    	$count++ ;	
		    	$id = preg_replace( '/  */' , '_' , $x) ;
		    	$row_span = 0 ;
		    	echo '<tr>' ;

		    	if ( isset($x_value['Pass']) )
		    	{
		    		$pass = count($x_value['Pass']) ;		    		
		    	}else
		    	{
		    		$pass = 0 ; 
		    	}

		    	if ( isset($x_value['Fail']) )
		    	{
		    		$fail = count($x_value['Fail']) ;		    		
		    	}else
		    	{
		    		$fail = 0 ; 
		    	}

		    	$total = $pass + $fail ;

		    	$perct_pass = $pass / $total * 100 ;

		    	$perct_fail = $fail / $total * 100 ;

		    	$perct_pass = round( $perct_pass , 2 );
		    	$perct_fail = round( $perct_fail , 2 );

				echo '<td >' . $count . '</td>' ;
				echo '<td >' . $x . '</td>' ;
				echo '<td><button class="btn btn-link btn-xs" data-toggle="modal" data-target="#'. $id . '_Pass_modal"><h5>' . $pass . '</h5></button></td>' ;
				echo '<td><button class="btn btn-link btn-xs" data-toggle="modal" data-target="#'. $id . '_Fail_modal"><h5>' . $fail . '</h5></button></td>' ;
				echo '<td >' . $total . '</td>' ;
				echo '<td >' . $perct_pass . '</td>' ;
				echo '<td >' . $perct_fail . '</td>' ;
				echo '</tr>' ;	

				if ( $_GET['chart_type'] == 'hist' )
				{
					array_push($pass_graph, "[ '" . $x . "' , " . intval($pass) . " ]") ;
					array_push($fail_graph, "[ '" . $x . "' , " . intval($fail) . " ]") ;	
				}else
				{
					array_push($pass_graph, "[ '" . $x . "' , " . round($perct_pass) . " , " . round($perct_fail) . " ] ") ;
				}
		    }
		 ?>
      </tbody>
      </table>
      </div>



	<?php
		   //Draw graph for the data obtained. Type of graph depends on what user wants
      	   $comp_graph_data = "[ " . join(',' , $pass_graph) . " ]" ;
      	   if ( $_GET['chart_type'] == 'hist' )
    	   {
      	   	hist_chart( "Compliance by Check" , "comp_graph" , $comp_graph_data , "Count" , "No of Checks" ) ;
      	   }elseif ( $_GET['chart_type'] == 'line' )
      	   {
      	   	line_chart("Compliance Percentage by check" , "comp_graph" , $comp_graph_data , 1500, 500) ;
      	   }else
      	   {
      	   	 column_chart("Compliance Percentage by check" , "comp_graph" , $comp_graph_data , 3000) ;
      	   }
      	   $comp_graph_data = "[ " . join(',' , $fail_graph) . " ]" ;
      	   if ( $_GET['chart_type'] == 'hist' )
    	   {
      	    hist_chart( "Non Compliance by Check" , "non_comp_grph" , $comp_graph_data , "Count" , "No of Checks" ) ;
      	   }
	       
    ?>
      

    <br>&nbsp;&nbsp;
    <a href="javascript:history.go(-1)"><button class="btn btn-default"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;Back</button></a>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="/"><button class="btn btn-default"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;&nbsp;Go Home</button></a>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<?php 
		//Buttons to redirect user to different other flavours of OS
		if ( $_GET['os'] == 'windows' )
		{
			echo '<a href="/bl_compliance.php?os=redhat&chart_type=' . $_GET['chart_type'] . '"><button class="btn btn-default"><img src="/img/redhat.png" alt="Redhat">&nbsp;&nbsp;Redhat BL Compliance Report</button></a>
				&nbsp;&nbsp;&nbsp;&nbsp;' ;
			echo '<a href="/bl_compliance.php?os=suse&chart_type=' . $_GET['chart_type'] . '"><button class="btn btn-default"><img src="/img/suse.png" alt="Suse">&nbsp;&nbsp;Suse BL Compliance Report</button></a>
				&nbsp;&nbsp;&nbsp;&nbsp;' ;
		}elseif ( $_GET['os'] == 'redhat' )
		{
			echo '<a href="/bl_compliance.php?os=windows&chart_type=' . $_GET['chart_type'] . '"><button class="btn btn-default"><img src="/img/windows.png" alt="Windows">&nbsp;&nbsp;Windows BL Compliance Report</button></a>
				&nbsp;&nbsp;&nbsp;&nbsp;' ;
			echo '<a href="/bl_compliance.php?os=suse&chart_type=' . $_GET['chart_type'] . '"><button class="btn btn-default"><img src="/img/suse.png" alt="Suse">&nbsp;&nbsp;Suse BL Compliance Report</button></a>
				&nbsp;&nbsp;&nbsp;&nbsp;' ;
		}else
		{
			echo '<a href="/bl_compliance.php?os=windows&chart_type=' . $_GET['chart_type'] . '"><button class="btn btn-default"><img src="/img/windows.png" alt="Windows">&nbsp;&nbsp;Windows BL Compliance Report</button></a>
				&nbsp;&nbsp;&nbsp;&nbsp;' ;
			echo '<a href="/bl_compliance.php?os=redhat&chart_type=' . $_GET['chart_type'] . '"><button class="btn btn-default"><img src="/img/redhat.png" alt="Redhat">&nbsp;&nbsp;Redhat BL Compliance Report</button></a>
				&nbsp;&nbsp;&nbsp;&nbsp;' ;
		}
	?>
    </div>			
	</div>

	<?php
		
		//Modal to display diffent servers under compliance or non compliance check of different Checks
		foreach ( $out as $x => $x_value ) 
		{
		     foreach ( $x_value as $y => $y_value )
		     {   	

		     	$count = 0 ;
		     	$id = preg_replace( '/  */' , '_' , $x) ;
		     	echo '<div id="'. $id . '_' . $y . '_modal" class="modal fade" role="dialog">
		     	<div class="modal-dialog modal-dialog-custom">
		     	<!-- Modal content-->
	              <div class="modal-content">
	                <div class="modal-header" style="color: black;">
	                  <button type="button" class="close" data-dismiss="modal">&times;</button>
	                  <h4 class="modal-title" >' . $x . ' - ' . $y . ' - List: </h4>
	                </div>
	                <div class="modal-body modal-body-custom"> ' ;
	                 	
	                echo '<div id="btn_'. $id . '_' . $y . '_table">
				    <button type="button" class="btn btn-default" onclick="exportAndHide(\''. $id . '_' . $y . '_table\' , \'btn_'. $id . '_' . $y . '_table\')"><img src="/img/export.png" title="Export">&nbsp;&nbsp;Export the Table</button>
				    <br><br>
				    </div>' ;
					echo '<div class="table-responsive">
					    <table class="table table-hover table-bordered " id="'. $id . '_' . $y . '_table">
					      <thead>
					        <tr>
					        <th>S.No</th>
					        <th>Server Name</th>
					        </tr>
					      </thead>
					      <tbody>' ;
		     	 foreach ( $y_value as $z )
			     {
			     		$count++ ;
						echo '<tr>' ;
						echo '<td >' . $count . '</td>' ;
						echo '<td >' . $z . '</td>' ;
						echo '</tr>' ;	
			     }
			     echo '</tbody>
				      </table>
				      </div>
				      </div>
		                <div class="modal-footer">
		                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		                </div>
		              </div>

		            </div>
		          </div>' ;
		     }
		}
	?>

	</div>	

	</body>
	</html>

	
