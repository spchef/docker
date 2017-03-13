<?php
	/*
         Provides Socket Function

         Author: C5212215 ( Nithin SM )
  */

  //This is not a standalone script. Cannot load it directly unless called from the standalone script

	if (!isset($direct))
	{
		header( "Location: /admin_task.php?error=Cannot Load Directly" ) ;
 	 	exit ;
	}
	function socket( $cmd , $title )
	{
		$socket_addr = "unix://\0cockpit_socket" ;
	    $socket = stream_socket_client($socket_addr , $errno , $errstr ) ;
	    if ( ! $socket ) 
	    {
			header( "Location: /" . $title . "?error=Unable to process the request at the moment. Contact the administrator  " . $errstr . '-' . $errno ) ;
	        exit ;
		}

		fwrite( $socket,$cmd );
		stream_set_timeout( $socket , 200 ) ;
	    $out = fgets($socket , 8388608 ) ;
	    return $out ;
	}
?>
