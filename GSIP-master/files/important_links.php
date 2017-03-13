<?php
  /*
         Provides Important Links panel

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
          <b>Helpful Links </b>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
          <button id="imp_links_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide('imp_links') " style="float: right;" title="Hide or Display this field"><span id="imp_links_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>          
        </div>
      </div>
      </div>
      <div class="panel-body il-panel" id="imp_links" style="text-align: center; vertical-align: middle;"> 
          <a href="https://itdirect.wdf.sap.corp/" target="_blank" class="href imp_links_brown imp_links_most_used" title="IT Direct "> IT Direct</a>&nbsp;&nbsp;

          <a href="https://metadata.mo.sap.corp" target="_blank" class="href imp_links_blue imp_links_mid_used" title="Monsoon API Services"> GLDS Monsoon Portal</a>&nbsp;&nbsp;


          <a href="https://bridge.mo.sap.corp" target="_blank" class="href imp_links_brown imp_links_most_used" title="Monsoon Dashboard">Bridge</a>&nbsp;&nbsp;


          <a href="https://nagios-labs.mo.sap.corp/thruk/frame.html?link=https://nagios-labs.mo.sap.corp/thruk/startup.html" target="_blank" class="href imp_links_blue imp_links_mid_used" title="Nagios"> GLDS Nagios</a>&nbsp;&nbsp;

          <a href="http://labs-mon:8085/ganglia/" target="_blank" class="href imp_links_brown imp_links_less_used" title="Ganglia">Ganglia</a>&nbsp;&nbsp;

          <a href="https://cmp.wdf.sap.corp/sism" target="_blank" class="href imp_links_blue imp_links_mid_used" title="SISM"> SISM</a>&nbsp;&nbsp;

          <a href="https://controlcenter.mo.sap.corp/" target="_blank" class="href imp_links_brown imp_links_less_used" title="Monsoon Control Center"> Monsoon Control Center</a>&nbsp;&nbsp;

          <a href="https://flpsandbox-xedac3f1e.dispatcher.neo.ondemand.com/sites?siteId=1fee004d-3b8c-4870-9832-5af202aa3f2a#Shell-home" target="_blank" class="href imp_links_blue imp_links_less_used" title="DevCloud UI"> DevCloud UI</a>&nbsp;&nbsp;

          <a href="https://dpso-chefserver.wdf.sap.corp/login" target="_blank" class="href imp_links_brown imp_links_mid_used" title="GLDS Chef Server"> GLDS Chef Server</a>&nbsp;&nbsp;

          <a href="https://wiki.wdf.sap.corp/wiki/display/ITLABS/Global+Lab+DEV+Systems+-+TLO+Assignment" target="_blank" class="href imp_links_blue imp_links_most_used" title="TLO Wiki"> TLO Wiki</a>&nbsp;&nbsp;

          <a href="https://cmp.wdf.sap.corp/sap(bD1lbiZjPTAwMSZkPW1pbg==)/bc/bsp/sap/crm_ui_start/default.htm?crm-object-type=CRM_SRQM_INCIDENT&crm-object-action=B&crm-object-value=C8DD9A4FF199C929E10000000A431468" target="_blank" class="href imp_links_brown imp_links_less_used" title="CRM"> CRM</a>&nbsp;&nbsp;

          <a href="https://ldcimpd.mo.sap.corp:44370/vmpricing(bD1lbiZjPTAwMQ==)/default.htm" target="_blank" class="href imp_links_blue imp_links_less_used" title="VM Price Calculator"> VM Price Calculator</a>&nbsp;&nbsp;

          <a href="https://chefserver-cm-us.pal.sap.corp/login" target="_blank" class="href imp_links_brown imp_links_mid_used" title="US Chef Server">US Chef Server</a>&nbsp;&nbsp;

          <a href="https://jam4.sapjam.com/auth/status/2HSE0JMumzngdYXblA1J73" target="_blank" class="href imp_links_blue" title="Jam Page">Jam Page</a>&nbsp;&nbsp;

          <a href="https://mdocs.sap.com/mcm" target="_blank" class="href imp_links_brown imp_links_less_used" title="MDoc Share"> MDoc Share</a>&nbsp;&nbsp;

          <a href="https://monsoon.mo.sap.corp/organizations/sandbox" target="_blank" class="href imp_links_blue imp_links_most_used" title="Monsoon Dashboard">Monsoon Dashboard</a>&nbsp;&nbsp;

          <a href="https://ldcimpa.wdf.sap.corp:44370/labsitreport" target="_blank" class="href imp_links_brown imp_links_mid_used" title="Monsoon Dashboard">Utilization Report</a>&nbsp;&nbsp;

          <a href="https://itisbwprod.wdf.sap.corp/irj/portal/backuprep/fs" target="_blank" class="href imp_links_blue imp_links_less_used" title="Monsoon Dashboard">BW Reports</a>&nbsp;&nbsp;
          <br>

          <a href="https://cmp.wdf.sap.corp/passvault(bD1lbiZjPTAwMQ==)/default.do" target="_blank" class="href imp_links_brown imp_links_most_used" title="Monsoon Dashboard">Passvault</a>&nbsp;&nbsp;

          <a href="https://cmp.wdf.sap.corp/sap/bc/ui5_ui5/ui2/ushell/shells/abap/Fiorilaunchpad.html#zcwp_linkui-display" target="_blank" class="href imp_links_blue imp_links_less_used" title="Monsoon Dashboard">Backup Monitor</a>&nbsp;&nbsp;

          <a href="https://accessor.wdf.sap.corp/usergui " target="_blank" class="href imp_links_brown imp_links_less_used" title="Monsoon Dashboard">Accessor</a>&nbsp;&nbsp;

          <a href="https://aclng.wdf.sap.corp/iptool/" target="_blank" class="href imp_links_blue imp_links_most_used" title="Monsoon Dashboard">Iptool</a>&nbsp;&nbsp;

          <a href="https://ipam.wdf.sap.corp/app" target="_blank" class="href imp_links_brown imp_links_most_used" title="Monsoon Dashboard">DNS Tool</a>&nbsp;&nbsp;
      </div>
      </div>


  


  <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
          <b>GLDS Wiki Search</b>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
          <button id="search_btn" class="btn btn-primary  btn-xs btn-primary-custom" type="button" onclick="displayHide('search') " style="float: right;" title="Hide or Display this field"><span id="search_btn_span" class="glyphicon glyphicon-chevron-up"></span></button>  
      </div>
      </div>
      </div>
     <div class="panel-body search-panel" id="search">
      <br>
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
         <form class="form-inline" name="search_form" role="form" action="/search.php" target="_blank" method="post"> 
        <div class="form-group"> 
        <div class="input-group" >
            <input type="text" name="search" placeholder="Search LabsIT Wiki" class="form-control" oninput="form_check('search_form' , 'search' , 'search_button' )"  />
          <div class="input-group-btn">
            <button id="search_button" type="submit" class="btn btn-primary" disabled="disable"><span class="glyphicon glyphicon-search"></span>&nbsp; Search</button>
          </div><!-- /btn-group -->
        </div><!-- /input-group -->
        </div>
         </form>
        </div>
        </div>
    </div>
  </div>

      


</div>
