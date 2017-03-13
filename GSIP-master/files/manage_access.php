<?php
   /*
         Provides Access Information

         Author: C5212215 ( Nithin SM )
  */

  //This is not a standalone script. Cannot load it directly unless called from the standalone script
	  if ( ! isset($direct) )
	  {
	  	header( "Location: /?error=Cannot Load Directly" ) ;
        exit ;
	  } 

	  if ( isset($_COOKIE['authentication-token']) ) 
	  {
	  	 	 $_COOKIE['authentication-token'] = openssl_decrypt($_COOKIE['authentication-token'], 'AES-256-CBC' , 'pass,123' , true ,  '3132333435363738') ;
	         $tmp = array() ;
	         $tmp = json_decode($_COOKIE['authentication-token'] , true) ;
	         $access_username = $tmp['username'] ; 
	         $access_uid = $tmp['uid'] ; 
	         if ( isset($tmp['email']) ) ;
	         {
	         	$access_email = $tmp['email'] ;
	         }
	         if ( isset($tmp['costcenter']) ) 
	         {
	         	$access_costcenter = $tmp['costcenter'] ;
	         }
	         $access_delete_entry = $tmp['delete_entry'] ;
	         $access_add_entry = $tmp['add_entry'] ;
	         $access_admin_task = $tmp['admin_task'] ;
	         $access_shift_roster = $tmp['shift_roster_update'] ;
	  }
?>