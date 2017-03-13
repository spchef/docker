<?php

  /*
    PHP script to verify if the login credentials provided are valid. Uses socket to validate username and password
    through LDAP

    Author: c5212215 ( Nithin SM )
  */

  //Allow the site to be loaded directly
  $direct = 1 ; 

  //Provides access information to the page
  require 'files/manage_access.php' ; 

  //Provides socket functionality.
  require 'files/socket.php' ;

  //If already loggied in then redirected to the same requested page
  if( isset($_COOKIE['authentication-token']) ) {
      header( "Location: /" . $_GET['redirect_to'] . "?message=Already Logged in" ) ;
      exit ;
  }

  //Check if the necessary details are set
  if ( isset($_POST['username']) and isset($_POST['password']) )
  {
    var_dump($_REQUEST) ;
    $user_file = '/var/www/user_account.txt' ;
    $username = $_POST['username'] ;
    $password = $_POST['password'] ;
    $key = base64_encode( $password ) ;
    //use socket to verify the given information
    //Socket uses ldap to verify the authentication
    $cmd = 'check_login:-' . $username . ':-' . $key . "\n" ;
    $out = socket( $cmd , $_GET['redirect_to'] ) ;
    $out = json_decode($out) ;  
    $status = array_shift($out) ;
    $value = array_shift($out) ;

    //If success then provide access or else redirect to the requested page with error message
    if ( $status == 0 and preg_match('/success/', $value) )
    {
      $value = explode(':-', $value) ;
      $value =  array_pop($value) ;
      $crypt =  openssl_encrypt ($value ,'AES-256-CBC' , 'pass,123' , true ,  '3132333435363738'  );

      setcookie("authentication-token", $crypt, $time , "/");

      header( "Location: /" . $_GET['redirect_to'] . "?message=Successfully Logged in" ) ;
      exit ;
    }else
    {
      header( "Location: /" . $_GET['redirect_to'] . "?error=Invalid User or Password.. Try again") ;
      exit ;
    }
  }else
  {
    header( "Location: /" . $_GET['redirect_to'] . "?error=Cannot load directly. Use Login Page Instead") ;
      exit ;
  }

?>