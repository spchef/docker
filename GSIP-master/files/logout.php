<?php
  /*
         Provides Logout Function
        
         Author: C5212215 ( Nithin SM )
  */

	$direct = 1 ;
?>
<?php
  if (!isset($direct))
  {
    header( "Location: /?error=Cannot Load Directly" ) ;
      exit ;
  }
?>
<?php
  if (setcookie('authentication-token' , "" , time() - 3600 , '/') )
  {
  	header('Location: /?message=Successfully Logged Out') ;
  	exit ;
  }else
  {
  	header('Location: /?error=Unable to Logout.. Get in touch with the administrator') ;
  	exit ;
  }
  
?>
