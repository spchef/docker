<?php
      /*
         Provides Report bug in the gsip site

         Author: C5212215 ( Nithin SM )
  */

      if ( isset($_REQUEST['name']) and isset($_REQUEST['email']) and isset($_REQUEST['short_info']) and isset($_REQUEST['detailed_info']) )
      {
          var_dump($_REQUEST) ;
          $_REQUEST['name'] = ucfirst($_REQUEST['name']) ;
          $emailid = 'nithin.sm@sap.com' ;
          $subject = 'New Bug: ' . ucfirst($_REQUEST['short_info']) ;
          $message = '<p>Hello,<p>' . '
          
    <p>' . $_REQUEST['name'] . ' with emailid ' . $_REQUEST['email'] . ' has reported a New Bug.<p>

    <h3>Message: </h3>' . '

    <p><b>' . ucfirst($_REQUEST['detailed_info']) . '</b></p>

    <p>Stay in Touch with the sender.<p>

    <pre style="color: blue;">
Regards,

GLDS SM Information Portal</pre>' ;

          $headers  = 'MIME-Version: 1.0' . "\r\n";
          $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
          $headers .= 'From: admin@gsip.mo.sap.corp' . "\r\n";
          $headers .= 'Cc: prajith.cr@sap.com' . "\r\n";

          $status = mail($emailid, $subject, $message, $headers);
      }

      if ( $status )
      {
        header( "Location: /?message=Thank You for reporting. We will take necessary actions to resolve it at the earliest" ) ;
        exit ;
      }else
      {
        header( "Location: /?error=Failed Contact Administrator" ) ;
        exit ;
      }

?>