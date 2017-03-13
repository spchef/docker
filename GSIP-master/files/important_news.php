<?php
  /*
         Provides Important News panel

         Author: C5212215 ( Nithin SM )
  */

  //This is not a standalone script. Cannot load it directly unless called from the standalone script
  if (!isset($direct))
  {
    header( "Location: /?error=Cannot Load Directly" ) ;
      exit ;
  }

  $cmd = 'news:-get_news' . "\n" ;
  $out = socket( $cmd , $title ) ;
  $out = json_decode($out , true) ; 
  $status = intval(array_shift($out)) ;
  $value = array_shift($out) ;
  if ( $status != 0 )
  {
    header( "Location: /admin_task.php?error=Received Status " . $status . '  Which is greater than 0. Contact Administrator' ) ;
      exit ;
  }
?>

<div class="col-md-6 col-lg-6">

        <img src="/img/sm4.jpg" title="GLDS Server Management" style="width: 100% ; height:  250px">
     
        <br><br>

        <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="row">
          <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" >
            <b>Important News </b>
          <?php
          if( isset($access_add_entry) and $access_add_entry == 1 ) {
            echo '<button class="btn btn-link btn-xs"   data-toggle="modal" data-target="#addnews" style="color: #00FFFF;">( Add News )</button>' ;
          }
          ?>


          <!-- Modal -->
          <div id="addnews" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header" style="color: black;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title" style="color: #0000CD;"><b>Add News: </b></h4>
                </div>
                <div class="modal-body">
                  <form name="add_news" action="/files/news.php?task=add_news" method="post" enctype="multipart/form-data">
                    <div class="form-group" id="onscreen_input" >
                        <label for="short_text" style="color: black;"><b>Enter Short Text: </b></label>
                        <input required id="onscreen" type="text" class="form-control disabled" name="short_text" placeholder="Add Short Text about the NEWS"  title="Enter the List of Servers" >                
                     </div>
                     <div class="form-group" id="onscreen_input" >
                        <label for="add_link" style="color: black;"><b>Enter Link (Optional): </b></label>
                        <input id="onscreen" type="text" class="form-control disabled" name="add_link" placeholder="Add the Link for the detailed info"  title="Enter the List of Servers" >                
                     </div>
                    <button id="add_news_btn" type="submit" class="btn btn-primary">Add News</button>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><b>Cancel</b></button>
                </div>
              </div>

            </div>
          </div>


          </div>
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <button id="imp_news_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide('imp_news') " style="float: right;" title="Hide or Display this field"><span id="imp_news_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
          </div>
          </div>
        </div>
        <div class="panel-body news_panel" id="imp_news" >
        <br>
        <ul class="list-unstyled nav nav-pills nav-stacked">

        <?php
        ksort($out) ;
        foreach ( $value as $x  )
        {
          if( isset($access_delete_entry) and $access_delete_entry == 1 ) 
          {
              echo '<li>                   
              <div class="row">
              <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">' ;
              if ( preg_match('/^\s*$/', $x["link"]) )
              {
                echo '<b style="color: black">' .  $x["news"] . '</b>' ;
              }else
              {
                echo '<a id="'. $x['id'] . '" href="' . $x["link"] . '" target="_blank" ><b style="color: #8B4513">' .  $x["news"] . '</b></a>' ;
              }
              

              echo '</div>
              <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="float: center;">
                <button class="btn btn-default btn-xs" type="button" style="border: none;"><a href="/files/news.php?task=delete_news&file=' . $x['id'] . '" style="color: black;" onclick="return check_confirm()"><span class="glyphicon glyphicon-remove"></span></a></button> 
              </div>
              </div>
               </li><br> ' ;  
          }else{
              if ( preg_match('/^\s*$/', $x["link"]) )
              {
                echo '<b style="color: black">' .  $x["news"] . '</b><br><br>' ;
              }else
              {
                echo '<a id="'. $x['id'] . '" href="' . $x["link"] . '" target="_blank" ><b style="color: #8B4513">' .  $x["news"] . '</b></a><br><br>' ;
              }
          }     

        }       

        ?>
        </ul>
        </div>
        </div>  
</div>
