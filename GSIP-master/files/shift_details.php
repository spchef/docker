<?php
  /*
         Provides Currect shift details

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
            $date = date('F j, Y');             
            echo '<div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                  <b>Shift Details for Today (' . $date . ')</b>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                  <button id="shift_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide(\'shift\') " style="float: right;" title="Hide or Display this field"><span id="shift_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
                </div>
                </div>
              </div>
              <div class="panel-body" id="shift">
              <div class="row">' ;

            
            $cmd = 'shift_check:-linux' . "\n" ;
            $out = socket( $cmd , $title ) ;
            $out = json_decode($out) ;  
            $status = array_shift($out) ;
            $value = array_shift($out) ;
            $out = json_decode($value,true) ;
            if ( $status == 0 )
            {
              echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">' ;
              echo '<div class="table-responsive">' ;
              echo '<table class="table table-hover">' ;
              echo '<caption><b style="color: #3300CC;"><i class="fa fa-linux" aria-hidden="true"></i> L2 Linux Team</b></caption>' ;
              echo '<tbody>' ;
              echo '<tr>';
              foreach ( $out as $x => $x_value )
              {
                echo '<td>' . $x . ' - ' . join( ', ' , $x_value ) . '</td>' ;
              }
              echo '</tr>' ;
              echo '</tbody>' ;
              echo '</table>' ;
              echo '</div>'; 
              echo '</div>';            
            }

            $cmd = 'shift_check:-windows' . "\n" ;
            $out = socket( $cmd , $title ) ;
            $out = json_decode($out) ;  
            $status = array_shift($out) ;
            $value = array_shift($out) ;
            $out = json_decode($value,true) ;
            if ( $status == 0 )
            {
              echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">' ;
              echo '<div class="table-responsive">' ;
              echo '<table class="table table-hover">' ;
              echo '<caption><b style="color: #3300CC;"><i class="fa fa-windows" aria-hidden="true"></i> L2 Windows Team</b></caption>' ;
              echo '<tbody>' ;
              echo '<tr>';
              foreach ( $out as $x => $x_value )
              {
                echo '<td>' . $x . ' - ' . join( ', ' , $x_value ) . '</td>' ;
              }
              echo '</tr>' ;
              echo '</tbody>' ;
              echo '</table>' ;
              echo '</div>';   
              echo '</div>';          
            }  

            $cmd = 'shift_check:-l1team' . "\n" ;
            $out = socket( $cmd , $title ) ;
            $out = json_decode($out) ;  
            $status = array_shift($out) ;
            $value = array_shift($out) ;
            $out = json_decode($value,true) ;
            if ( $status == 0 )
            {
              echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">' ;
              echo '<div class="table-responsive">' ;
              echo '<table class="table table-hover">' ;
              echo '<caption><b style="color: #3300CC;"><i class="fa fa-linux" aria-hidden="true"></i> L1 Linux Team</b></caption>' ;
              echo '<tbody>' ;
              echo '<tr>';
              foreach ( $out['Linux'] as $x => $x_value )
              {
                echo '<td>' . $x . ' - ' . join( ', ' , $x_value ) . '</td>' ;
              }
              echo '</tr>' ;
              echo '</tbody>' ;
              echo '</table>' ;
              echo '</div>';   
              echo '</div>';       

              echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">' ;
              echo '<div class="table-responsive">' ;
              echo '<table class="table table-hover">' ;
              echo '<caption><b style="color: #3300CC;"><i class="fa fa-windows" aria-hidden="true"></i> L1 Windows Team</b></caption>' ;
              echo '<tbody>' ;
              echo '<tr>';
              foreach ( $out['Windows'] as $x => $x_value )
              {
                echo '<td>' . $x . ' - ' . join( ', ' , $x_value ) . '</td>' ;
              }
              echo '</tr>' ;
              echo '</tbody>' ;
              echo '</table>' ;
              echo '</div>';   
              echo '</div>';       
            }


             echo '
              </div>
              </div>
              </div>' ;
          ?>