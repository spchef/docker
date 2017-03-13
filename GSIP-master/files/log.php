<?php
	/*
         Provides Loggin Function

         Author: C5212215 ( Nithin SM )
  */

  	  //This is not a standalone script. Cannot load it directly unless called from the standalone script
   	  if (!isset($direct))
	  {
	    header( "Location: /?error=Cannot Load Directly" ) ;
	      exit ;
	  }

	function cockpit_log ( $username , $uid , $filename , $message )
	{
		$cmd = 'log:-' . $username . ":-" . $uid . ":-" . $filename . ":-" . $message . "\n" ;
		$out = socket( $cmd , $title ) ;
	}
?>