<html>
	<head>
		<?php

      /*
          Main Home page of GSIP
          Author : c5212215 ( Nithin SM )
      */

      //Name of the script. This is useful incase of redirection to the same page
      $title = "index.php" ;

      // Allow the site to be loaded directly
			$direct = 1 ;

      //Gives access related information  
      require 'files/manage_access.php' ;

      //Head part of html
			require 'files/head.php' ;

      //Function that aids in socket communication
      require 'files/socket.php' ;
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
          //Load the left side panel
  				require 'files/category.php'
  			?>

        <?php
          //Load important news panel
          require 'files/important_news.php'
        ?>    		

    		<?php
          //load important links panel
    			require 'files/important_links.php'
    		?>

  		</div>
		</div>
	</body>
</html>
