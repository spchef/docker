<?php
  /*
         Provides Delete ability for SOP panel

         Author: C5212215 ( Nithin SM )
  */

  //This is not a standalone script. Cannot load it directly unless called from the standalone script
  if (!isset($direct))
  {
    header( "Location: /?error=Cannot Load Directly" ) ;
      exit ;
  }
?>
<?php
	var_dump($_GET) ;

	if ( ! isset($_COOKIE['authentication-token']))
	{
		header( "Location: /login.php?error=Unauthorised. Login with Administrator to Delete" ) ;
		exit ;
	}
	if ( isset($_GET['sop_file']) )
	{
		$file = $_GET['sop_file'] ;
		if ( unlink('/var/www/html/sop/' . $file) )
		{
			header( "Location: /sop.php?message=" . $file ." Successfully deleted" ) ;
			exit ;
		}else
		{
			header( "Location: /sop.php?error='" . $file ."' failed.. Contact administrator" ) ;
			exit ;
		}

	}
?>
