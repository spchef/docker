<?php
	
	/*
         Provides News Addition and deletion

         Author: C5212215 ( Nithin SM )
  */
	$direct = 1 ;
	require 'socket.php' ;
	require 'manage_access.php' ;
	require 'log.php' ;
	if ( isset($_REQUEST['task']) and $_REQUEST['task'] == "add_news" )
	{
		  if( ! isset($_COOKIE['authentication-token']) or ! isset($access_add_entry) or $access_add_entry == 0 ) {
	  	      header( "Location: /login.php?error=Unable to Authenticate. Login below" ) ;
	  	      exit ;
	  	  } 

	  	  if ( ! isset($_REQUEST['short_text']) or ! isset($_REQUEST['add_link']) )
	      {
	          header( "Location: /sop.php?error=Cannot load directly" ) ;
	          exit ;
	      }

		  $news = $_REQUEST['short_text'] ;
		  $news = preg_replace('/:-/', ':', $news) ;
		  $link = $_REQUEST['add_link'] ;
		  $link = preg_replace('/:-/', ':', $link) ;
	      $cmd = 'news:-add_news:-' . $news . ':-' . $link . "\n" ;
	      $out = socket( $cmd , $title ) ;
	      $out = json_decode($out) ; 
	      $status = intval(array_shift($out)) ;

	      if ( $status != 0 )
	      {
	        header( "Location: /?error=Received Status " . $status . '  Which is greater than 0. Contact Administrator' ) ;
	        exit ;
	      }else
	      {
	      	cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Added news " . $news . "with link " . $link ) ;
	      	header( "Location: /?message=Added News Successfully") ;
	      }
	}elseif ( isset($_REQUEST['task']) and $_REQUEST['task'] == "delete_news" )
	{
		  if( ! isset($_COOKIE['authentication-token']) or ! isset($access_delete_entry) or $access_delete_entry == 0 ) {
	  	      header( "Location: /login.php?error=Unable to Authenticate. Login below" ) ;
	  	      exit ;
	  	  }

	  	  if ( ! isset($_REQUEST['file']) )
	      {
	          header( "Location: /sop.php?error=Cannot load directly" ) ;
	          exit ;
	      }

		  $file = $_REQUEST['file'] ;
	      $cmd = 'news:-delete_news:-' . $file . "\n" ;
	      $out = socket( $cmd , $title ) ;
	      $out = json_decode($out) ; 
	      $status = intval(array_shift($out)) ;

	      if ( $status != 0 )
	      {
	        header( "Location: /?error=Received Status " . $status . '  Which is greater than 0. Contact Administrator' ) ;
	          exit ;
	      }else
	      {
	      	cockpit_log( $access_username , $access_uid , "/var/log/cockpit_access.log" , "Deleted news with id  " . $file ) ;
	      	header( "Location: /?message=News Deleted Successfully") ;
	      }
	}else
	{
		header( "Location: /?message=Cannot Load Directly") ;
	}
?>