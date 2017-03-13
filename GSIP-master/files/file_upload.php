<?php
	
	/*
         Provides Upload feature

         Author: C5212215 ( Nithin SM )
  */

  //This is not a standalone script. Cannot load it directly unless called from the standalone script
    if (!isset($direct))
	{
		header( "Location: /admin_task.php?error=Cannot Load Directly" ) ;
		 	exit ;
	}

	function file_upload( $filename ) 
	{
		global $title ;
		$target_dir = '/var/www/cockpit/uploads/';
		$target_file = $target_dir . 'tmp-' . time() . '.txt';
		$array = array() ;
		if (move_uploaded_file( $filename, $target_file)) 
		{
		    if (  mime_content_type($target_file) != "text/plain" ) 
		    {
		        unlink ( $target_file ) ;
				header('Location: /' . $title . '?error=Unknown File format') ;
		    	exit ;
		    }

		    $myfile = fopen( $target_file , "r" ) or die("Unable to open file!");
		    $host = [] ;
		    while(!feof($myfile)) 
         	{
         		$line = trim(fgets($myfile)) ;
         		if ( array_key_exists( $line , $complete ) )
	            {
	              continue ; 
	            }
	            $complete[$line] = 1 ;
	            if ( $line == "" or preg_match( '/^  *$/' , $line ) )
	            {
	              continue ;
	            }
	            array_push($host, $line) ;     
         	}
         	if ( ! isset($host) )
         	{
         		header('Location: /' . $title . '?error=File is empty') ;
		    	exit ; 
         	}
         	unlink ( $target_file ) ;  
         	return join(',' , $host) ;
		}else
		{
			header('Location: /' . $title . '?error=Unknown Error. Contact System Administrator') ;
		    exit ; 
		}
	}
	
?>