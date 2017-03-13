<?php
  /*
         Provides Banner

         Author: C5212215 ( Nithin SM )
  */

  //This is not a standalone script. Cannot load it directly unless called from the standalone script
  if (!isset($direct))
  {
    header( "Location: /?error=Cannot Load Directly" ) ;
      exit ;
  }
?>

<div class="page-header page-header-custom" >
    <br>
    <div class="row">
    <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1" >
		  <div class="navbar-brand"><img class="img-responsive2" src="/img/1428056198281.png"><h6><b style="font-family: \'Roboto Slab\', serif ;color: white;">PSD ECS</b></h6></div>
    </div>

    <?php
      echo '<div class="col-xs-8 col-sm-6 col-md-8 col-lg-9  pull-center">' ;
    ?>
	      <p class="lead"><h3 ><b style="font-family: 'Roboto Slab', serif ;color: white; text-align: center; font-size: 75%">
        GLDS Server Management</b><br><b style="font-family: 'Roboto Slab', serif ;color: #f2c644">Information Portal</b></h3></p>	   
    </div>


    <?php
      if ( isset($_COOKIE['authentication-token']) )
      {
        
        if ( ! isset($access_username) )
        {
          header( "Location: /files/logout.php" ) ;
          exit ;
        } 

         echo '<div class="col-xs-6 col-xs-offset-3  col-sm-3 col-sm-offset-0 col-md-2 col-md-offset-0 col-lg-2 col-lg-offset-0">
         <p><h4 style="color: white; font-family: goodfish">Welcome to GSIP !</h4></p>     
        <div class="dropdown"> ' ;

        
        echo '<button id="login_btn" data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle" type="button" style="font-family: \'Roboto Slab\', serif;float: left;" title="Show Login Menu"><i class="fa fa-user-circle-o" aria-hidden="true"></i>&nbsp;&nbsp;' . ucfirst($access_username) . '! <span id="login_btn_span" class="fa fa-cog"></span></button>
           <ul class="dropdown-menu" >
            <br>' ;
          if ( isset($access_uid))
          {
            echo '<li style="text-align: center"><img src="https://avatars.wdf.sap.corp/avatar/' . $access_uid . '" class="img-circle" alt="'. $access_uid . '" width="100" height="100"></li><br>
              <li>&nbsp;&nbsp;<b>SAP ID : </b> ' . $access_uid . ' </li>
              <li>&nbsp;&nbsp;<b>Name &nbsp;&nbsp;: </b> ' . $access_username . ' </li><br>
              <li class="divider"></li>' ;
          }
           echo '<li>&nbsp;&nbsp;<button class="btn btn-link btn-xs" data-toggle="modal" data-target="#report_bug"><b style="font-family: \'Roboto Slab\', serif ;color: black;"><i class="fa fa-bug" aria-hidden="true"></i>&nbsp;&nbsp;Report Bug</b></button></li>
            <br> ' ;
            
            echo ' <li>&nbsp;&nbsp;<button class="btn btn-link btn-xs" ><a href="/files/logout.php"><b style="font-family: \'Roboto Slab\', serif ;color: black;"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;&nbsp;Logout</b></a></button></li>
            <br>
           </ul>
          </div>
        </div>' ;
      }else
      {
          echo '<div class="col-xs-6 col-xs-offset-3  col-sm-3 col-sm-offset-0 col-md-2 col-md-offset-0 col-lg-2 col-lg-offset-0">
         <p><h4 style="color: white; font-family: goodfish">Welcome to GSIP !</h4></p>        
              <div class="dropdown">
                <button id="login_btn" data-toggle="dropdown" class="btn btn-default btn-md dropdown-toggle" type="button" style="float: left;" title="Show Login Menu"><span id="login_btn_span" class="fa fa-cog"></span></button>
                 <ul class="dropdown-menu"><br>
                  <li>&nbsp;&nbsp;<button class="btn btn-link btn-xs" data-toggle="modal" data-target="#login_toggle"><b style="font-family: \'Roboto Slab\', serif ;color: black;"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;&nbsp;Admin Login</b></button></li><br>
                  <li>&nbsp;&nbsp;<button class="btn btn-link btn-xs" data-toggle="modal" data-target="#report_bug"><b style="font-family: \'Roboto Slab\', serif ;color: black;"><i class="fa fa-bug" aria-hidden="true"></i>&nbsp;&nbsp;Report Bug</b></button></li><br>
                 </ul>
              </div>
          </div>' ;
      }
    ?>
    


    </div> 
    <br> 
</div>

<?php
    if (isset($_GET['message']))
    {
      echo '<div class="alert alert-success alert-dismissible">' ;
      echo ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' ;
      echo '<strong>' . $_GET['message'] . '</strong>' ;
      echo '</div>' ;
    }
    if (isset($_GET['error']))
    {
      echo '<div class="alert alert-danger alert-dismissible">' ;
       echo ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' ;
      echo ' <strong>' . $_GET['error'] . '</strong> ' ;
      echo '</div>' ;
    }
?>

<?php
if ( ! isset($_COOKIE['authentication-token']) )
{
echo '<div id="login_toggle" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="color: black;">
          <button type="button" class="close" data-dismiss="modal"><b style="color: black;"><i class="fa fa-times" aria-hidden="true"></i><b></button>
          <h4 class="modal-title" ><b>Login:</b></h4>
        </div>
        <div class="modal-body">
          <h5><b style="color: red;">Note: Use your C/D/I SAP User accounts to login</b></h5><br>
          <form role="form" name="login_form" action="/login.php?redirect_to=' . $title . '" method="post">
              <div class="form-group">
                <label for="GSIP Username"><i class="fa fa-user-plus" aria-hidden="true"></i><b> Username:</b></label>
                <input id="user_name" type="text" name="username" class="form-control" placeholder="D/I/C User Id" required title="Enter the Username">
              </div>
              <div class="form-group">
                <label for="GSIP Password"><i class="fa fa-key" aria-hidden="true"></i><b> Password:</b></label>
                <input id="pass_word" type="password" class="form-control" name="password" placeholder="D/I/C User Password" required title="Enter the Password">
              </div>
              <div class="form-group">
                <input type="checkbox" name="signedin" value="signedin" checked="checked" title="Stay Signed In"><b>&nbsp;Stay Signed In</b>
              </div>
              <button id="signed_in" class="btn btn-success btn-lg btn-full" name="login" value="1" type="submit" id="submitBtn"  title="Login"><b> Login </b></button>
          </form>

        </div>
        <div class="modal-footer" >
          <button type="button" class="btn btn-danger " data-dismiss="modal">Cancel</button>
        </div>
      </div>
</div>
</div>


';

}
?>



<div id="report_bug" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" ><b>Active Bug Reporting System</b></h4>
      </div>
      <div class="modal-body" >

        <form action="/files/report_bug.php" method="post" >
              <div class="form-group">
                <label for="fullname" >Name*</label>
                  <?php
                    if ( isset($access_username) )
                    {
                      echo '<input readonly required name="name" class="form-control" id="fullname" value="' . $access_username . '">' ;
                    }else
                    {
                      echo '<input required name="name" class="form-control" id="fullname" placeholder="Name">' ;
                    }
                  ?>
              </div>
              <div class="form-group">
                <label for="inputEmail3" >Email*</label>
                <?php
                  if ( isset($access_email))
                  {
                    echo '<input readonly required type="email" name="email" class="form-control" id="inputEmail3" value="' . $access_email . '">' ;
                  }else
                  {
                    echo '<input required type="email" name="email" class="form-control" id="inputEmail3" placeholder="Your SAP Email ID">' ;
                  }
                ?>
                  
              </div>
              <div class="form-group">
                <label for="short_info" >Provide Short Info about the bug*</label>
                  <input required name="short_info" class="form-control" id="short_info" placeholder="Short Info">
              </div>
              <div class="form-group">
                <label for="detailed_info" >Details about the Bug*</label>
                  <textarea required name="detailed_info" class="form-control" id="detailed_info" placeholder="Detailed Info" rows="4"></textarea>
              </div>
              <button type="submit" class="btn btn-success">Report Bug</button>
        </form>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>