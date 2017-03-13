<?php  
  /*
         Provides side/Category panel

         Author: C5212215 ( Nithin SM )
  */

  //This is not a standalone script. Cannot load it directly unless called from the standalone script
  if (!isset($direct))
  {
    header( "Location: /?error=Cannot Load Directly" ) ;
      exit ;
  }
?>

<div class="col-md-3 col-lg-3">
        
        <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
              <b>Select a Category </b>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              <button id="category_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide('category') " style="float: right;" title="Hide or Display this field"><span id="category_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
            </div>
            </div>
        </div>
        <div class="panel-body category-panel" id="category">
        <ul class="list-unstyled nav nav-pills nav-stacked">
          <li ><a href="/" class="href" ><h5 ><b><img src="/img/home.png" alt="Home">&nbsp;&nbsp;Home</b></h5></a></li>
          <br> 
                  
          <?php
            if( isset($access_admin_task) and $access_admin_task == 1 ) {
                    echo '<li><a  href="#"  data-toggle="modal" data-target="#bl_choice" style="color: black;"><h5><b><span class="fa fa-file"></span> &nbsp;&nbsp;Blade Logic Compliance Report</b></h5></a></li>
          <br>  
          <li ><a href="/admin_task.php" class="href" ><h5 ><b><img src="/img/admin.png"> &nbsp;&nbsp;Admin Task</b></h5></a></li>
          <br>';
            }
          ?>
          <li><a href="/shift_roster.php"  class="href" ><h5><b><img src="/img/shift_roster.png">&nbsp;&nbsp;Shift Roster</b></h5></a></li>
          <br>  
          <li><a href="/sop.php"  class="href" ><h5><b><img src="/img/doc.png"> &nbsp;&nbsp;Sequence of Procedures&nbsp;<sup style="color: red"><b>(new)</b></sup></b></h5></a></li>
          <br>        
          <li><a href="/kb.php"  class="href" ><h5><b><img src="/img/kb.png" alt="Knowledge Base">&nbsp;&nbsp;Knowledge Base</b></h5></a></li>
          <br>
          <li><a href="/new_initiatives.php"  class="href" ><h5><b><img src="/img/ideas.png"> &nbsp;&nbsp;New Initiatives</b></h5></a></li>
          <br>
        </ul>
        </div>
        </div>
      </div>

<?php
if( isset($access_admin_task) and $access_admin_task == 1 ) 
{
echo '<div id="bl_choice" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" ><b>Blade Logic Compliance Report - Choose the OS Type</b></h4>
      </div>
      <div class="modal-body" style="text-align: center;">

      <div class="table-responsive">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td style="text-align: center ; "><a href="/bl_compliance.php" title="BL Report for Windows" style="color: #000080 ;" ><img src="/img/windows.png" alt="Windows">&nbsp;&nbsp;Windows</a></td>
              <td style="text-align: center"><a href="/bl_compliance.php?os=redhat" title="BL Report for Linux" style="color: #000080 ;"><img src="/img/redhat.png" alt="Redhat">&nbsp;&nbsp;Redhat</a></td>
              <td style="text-align: center"><a href="/bl_compliance.php?os=suse" title="BL Report for Linux" style="color: #000080 ;"><img src="/img/suse.png" alt="Suse">&nbsp;&nbsp;Suse</a></td>
            </tr>
          </tbody>
        </table>
      </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>' ;
}
?>
