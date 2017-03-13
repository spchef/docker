<?php
  
  /*
    Page to display when the user requests a page thats not available
    Author : c5212215 ( Nithin SM )
  */

  // Allow the site to be loaded directly
  $direct = 1;

  //Name of the script. This is useful incase of redirection to the same page
  $title = "index.php" ;

  //Gives access related information
  require 'files/manage_access.php' ;
  
?>

<html>
	<head>
		<?php
			require 'files/head.php' ;
		?>
	</head>

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
                <b>Page not Found</b>
              </div>
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <button id="gen_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide('gen') " style="float: right;" title="Hide or Display this field"><span id="gen_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
              </div>
            </div>
          </div>
          <div class="panel-body fixed-panel" id="gen" style="text-align: center">  
            <br>
            <img src="/img/page_not_found.jpg" alt="Page Not Found">
            <br>              
              <h3 style="color:  #8B0000"><b>Error:</h3></b><br>
              <h4 style="color:  #8B0000"><b>Requested Page Cannot be found....</b></h4>    
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
