<?php  

  /*
      Provides SOP Page for GSIP
      Used in adding sop details used in day to day operations

      Author: C5212215 ( Nithin SM )
  */

  //Allow the site to be loaded directly
  $direct = 1;

  //Name of the script used in redirection
  $title = "sop.php" ;

  //Provides access information to the script
  require 'files/manage_access.php' ;  

  //Provides Socket functionality to the script
  require 'files/socket.php' ;

  //Provides ability to log
  require 'files/log.php' ; 

  //Code for adding SOP   
  if ( isset($_REQUEST['task']) and $_REQUEST['task'] == "add_sop" )
  {
      if( ! isset($_COOKIE['authentication-token']) or ! isset($access_add_entry) or $access_add_entry == 0 ) {
            header( "Location: /sop.php?error=Not Authorized" ) ;
            exit ;
      } 

      if ( ! isset($_REQUEST['short_text']) or ! isset($_REQUEST['add_link']) )
      {
        header( "Location: /sop.php?error=Cannot load directly" ) ;
        exit ;
      }

      if ( ! isset($access_add_entry) or $access_add_entry != 1 )
      {
        header( "Location: /sop.php?error=Not Authorised to Add SOP" ) ;
        exit ;
      }


      //Use Socket to add SOP into the database
      $sop = $_REQUEST['short_text'] ;
      $sop = preg_replace('/:-/', ':', $sop) ;
      $link = $_REQUEST['add_link'] ;
      $link = preg_replace('/:-/', ':', $link) ;
      $cmd = 'sop:-add_sop:-' . $sop . ':-' . $link . "\n" ;
      $out = socket( $cmd , $title ) ;
      $out = json_decode($out) ; 
      $status = intval(array_shift($out)) ;

      if ( $status != 0 )
      {
        header( "Location: /sop.php?error=Received Status " . $status . '  Which is greater than 0. Contact Administrator' ) ;
        exit ;
      }else
      {
        cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Added SOP " . $sop . "with link " . $link ) ;
        header( "Location: /sop.php?message=Added SOP Successfully") ;
      }
  //Code for deleting the SOP
  }elseif ( isset($_REQUEST['task']) and $_REQUEST['task'] == "delete_sop" )
  {
        if( ! isset($_COOKIE['authentication-token']) or ! isset($access_delete_entry) or $access_delete_entry == 0 ) {
            header( "Location: /login.php?error=Unable to Authenticate. Login below" ) ;
            exit ;
        }

        if ( ! isset($_REQUEST['id']) )
        {
          header( "Location: /sop.php?error=Cannot load directly" ) ;
          exit ;
        }

        $id = $_REQUEST['id'] ;
        $cmd = 'sop:-delete_sop:-' . $id . "\n" ;
        $out = socket( $cmd , $title ) ;
        $out = json_decode($out) ; 
        $status = intval(array_shift($out)) ;

        if ( $status != 0 )
        {
          header( "Location: /sop.php?error=Received Status " . $status . '  Which is greater than 0. Contact Administrator' ) ;
            exit ;
        }else
        {
          cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Deleted SOP with id  " . $id ) ;
          header( "Location: /sop.php?message=SOP Deleted Successfully") ;
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
        //Provides banner part to the page
        require 'files/header.php' ;
      ?>
      
  		<div class="row">

  			<?php
          //Provides category panel to php
  				require 'files/category.php'
  			?>

        <div class="col-md-6 col-lg-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                <b>Sequence of Procedures</b>
              </div>
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <button id="sop_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide('sop') " style="float: right;" title="Hide or Display this field"><span id="sop_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
              </div>
            </div>
          </div> 
          <div class="panel-body fixed-panel" id="sop"> 
            <br>   
            <?php
              //Provide add access only when access right is available
              if( isset($access_add_entry) and $access_add_entry == 1 ) {
                echo '<button class="btn btn-default "   data-toggle="modal" data-target="#addsop" ><img src="/img/add_doc.png" alt="Add SOP">&nbsp;&nbsp;Add SOP</button><br> <br> ' ;
              }
              ?>
               
            <div style="text-align: center">
            <table class="table-responsive table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Sequence of Procedure</th>
                <?php
                 //Provide delete access only when access right is available
                  if( isset($access_delete_entry) and $access_delete_entry == 1 ) 
                  {
                    echo '<th>Action</th>';
                  }
                ?>
              </tr>
            </thead>
            <tbody>
              <?php
                //Read the list of SOP's from the database
                $cmd = 'sop:-get_sop' . "\n" ;
                $out = socket( $cmd , $title ) ;
                $out = json_decode($out , true) ; 
                $status = intval(array_shift($out)) ;
                $value = array_shift($out) ;
                if ( $status != 0 )
                {
                  header( "Location: /admin_task.php?error=Received Status " . $status . '  Which is greater than 0. Contact Administrator' ) ;
                    exit ;
                }
                $count = 0 ;
                foreach ( $value as $x  )
                {
                    echo '<tr>' ;
                    $count++ ;
                    echo '<td>' . $count . '</td>' ;
                    echo '<td><a id="'. $x['id'] . '" href="' . $x["link"] . '" target="_blank" ><b style="color: #8B4513">' .  $x["sop"] . '</b></a></td>' ;
                    if( isset($access_delete_entry) and $access_delete_entry == 1 ) 
                    {
                      echo '<td><button class="btn btn-link btn-xs" type="button" style="border: none;"><a href="/sop.php?task=delete_sop&id=' . $x['id'] . '" style="color: red;" onclick="return check_confirm()"><img src="/img/delete.png" alt="Delete">&nbsp;&nbsp;<b>Delete</b></a></button></td>' ;
                    }
                    echo '</tr>' ;
                }
              ?>
            </tbody> 
          </table>
          </div>
          <br />

          </div>
          </div>
        </div>

    		<?php
          //Provides the important link panel to the page
    			require 'files/important_links.php'
    		?>

  		</div>
		</div>


    <!-- Modal for adding sop-->
          <div id="addsop" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header" style="color: black;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title" style="color: #0000CD;"><b>Add Sequence of Procedure (SOP): </b></h4>
                </div>
                <div class="modal-body">
                  <form name="add_sop" action="/sop.php?task=add_sop" method="post" enctype="multipart/form-data">
                    <div class="form-group" id="onscreen_input" >
                        <label for="short_text" style="color: black;"><b>Enter Short Text: </b></label>
                        <input required id="onscreen" type="text" class="form-control disabled" name="short_text" placeholder="Add Short Text about the sop"  title="Enter the List of Servers" >                
                     </div>
                     <div class="form-group" id="onscreen_input" >
                        <label for="add_link" style="color: black;"><b>Enter Link: </b></label>
                        <input required id="onscreen" type="text" class="form-control disabled" name="add_link" placeholder="Add the Link for the detailed info"  title="Enter the List of Servers" >                
                     </div>
                    <button id="add_sop_btn" type="submit" class="btn btn-primary">Add SOP</button>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><b>Cancel</b></button>
                </div>
              </div>

            </div>
          </div>

	</body>
</html>
