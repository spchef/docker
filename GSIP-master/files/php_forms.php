<?php
  /*
         Provides Various admin task forms

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

function mcafee_form()
{
	echo <<<END

	<div class="panel panel-primary" id="mcafee_check">
      <div class="panel-heading"> <b>Provide Below Details To Check: </b> </div>
      <div class="panel-body" >

      <br>
      <button  type="button" class="btn btn-default" onclick="appendInput( 'mcafee_usernames' , 'mcafeeusername' , 'user_names' , 'Username to Login into Servers' , 'Enter the Username' , 'text' );appendInput( 'mcafee_passwords' , 'mcafeepassword' , 'pass_words' , 'Password to Login into Servers' , 'Enter the Password' , 'password' )" title="Add Username and Password Field"><img src="/img/add.png" alt="Add">&nbsp;&nbsp;Add Username and Password Field</button>
      <br><br>

      <form name="mcafee_check" autocomplete="off" action="/admin_task.php?task=mcafee_check" method="post" enctype="multipart/form-data">
      	<p><b> Note: Usernames and Passwords are not stored in the server </b></p>
      	<div class="form-group" id="mcafee_usernames" >
            <label for="user_names">Enter Usernames (Use "Add Username and Password Field" to provide Multiple Usernames): </label>
            <br>
            <input required  id="mcafeeusername" type="text" class="form-control" name="user_names[]" placeholder="Username to Login into Servers"  title="Enter the Username">
        </div>
        <div class="form-group" id="mcafee_passwords" >
            <label for="pass_words">Enter Passwords (Use "Add Username and Password Field" to provide Multiple Passwords): </label>
            <br>
            <input required  id="mcafeepassword" type="password" class="form-control" name="pass_words[]" placeholder="Password to Login into Servers"  title="Enter the Password">
        </div>
      	<div class="form-group" id="onscreen_input" >
            <label for="mcafee_server_list">Enter the List of Server (Comma Separated): </label>
            <br>
            <input oninput="fileOnscreenToggle('mcafee_server_list','mcafeefile','onscreen')"  required id="mcafee_server_list" type="text" class="form-control" name="mcafee_server_list" placeholder="Comma Separated List of Servers"  title="Enter the List of Servers" >                
         </div>
         <div ><b style="color: red;">(Or)</b></div>

        <br><label for="Upload Text File">Text File:</label><br>
		<div class="input-group">
        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
        	<div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
        	<span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Upload text file</span><span class="fileinput-exists">Change</span>&nbsp;&nbsp;<input type="file" name="mcafeefile" onchange="fileOnscreenToggle('mcafee_server_list','mcafeefile','file')" id="mcafeefile" accept=".txt"></span>
        	<span class="input-group-addon btn btn-success fileinput-exists"><button class="btn-success fileinput-exists" type="submit" id="submitBtn">Find Instances</button></span>
        </div>
        </div>
        <font size ="2">&nbsp;&nbsp;<b>Tip</b> : Upload file containing list of servers</font><br><br>

        <button id="mcafee_check_btn" type="submit" class="btn btn-primary">Get Details</button>
      </form>
      </div>
      </div>
END;

}

function run_ssh_command()
{
  echo <<<END

  <div class="panel panel-primary" id="sshrun_check">
      <div class="panel-heading"> <b>Provide Below Details To Check: </b> </div>
      <div class="panel-body" >

      <br>
      <button  type="button" class="btn btn-default" onclick="appendInput( 'sshrun_usernames' , 'sshrunusername' , 'user_names' , 'Username to Login into Servers' , 'Enter the Username' , 'text' );appendInput( 'sshrun_passwords' , 'sshrunpassword' , 'pass_words' , 'Password to Login into Servers' , 'Enter the Password' , 'password' )" title="Add Username and Password Field"><img src="/img/add.png" alt="Add">&nbsp;&nbsp;Add Username and Password Field</button>
      <br><br>

      <form name="sshrun_check" autocomplete="off" action="/admin_task.php?task=sshrun_check" method="post" enctype="multipart/form-data">
        <p><b> Note: Usernames and Passwords are not stored in the server </b></p>
        <div class="form-group" id="sshrun_usernames" >
            <label for="user_names">Enter Usernames (Use "Add Username and Password Field" to provide Multiple Usernames): </label>
            <br>
            <input required  id="sshrunusername" type="text" class="form-control" name="user_names[]" placeholder="Username to Login into Servers"  title="Enter the Username">
        </div>
        <div class="form-group" id="sshrun_passwords" >
            <label for="pass_words">Enter Passwords (Use "Add Username and Password Field" to provide Multiple Passwords): </label>
            <br>
            <input required  id="sshrunpassword" type="password" class="form-control" name="pass_words[]" placeholder="Password to Login into Servers"  title="Enter the Password">
        </div>
        <div class="form-group" id="onscreen_input" >
            <label for="sshrun_server_list">Enter the List of Server (Comma Separated): </label>
            <br>
            <input oninput="fileOnscreenToggle('sshrun_server_list','sshrunfile','onscreen')"  required id="sshrun_server_list" type="text" class="form-control" name="sshrun_server_list" placeholder="Comma Separated List of Servers"  title="Enter the List of Servers" >                
         </div>
         <div ><b style="color: red;">(Or)</b></div>

        <br><label for="Upload Text File">Text File:</label><br>
        <div class="input-group">
        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
          <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
          <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Upload text file</span><span class="fileinput-exists">Change</span>&nbsp;&nbsp;<input type="file" name="sshrunfile" onchange="fileOnscreenToggle('sshrun_server_list','sshrunfile','file')" id="sshrunfile" accept=".txt"></span>
          <span class="input-group-addon btn btn-success fileinput-exists"><button class="btn-success fileinput-exists" type="submit" id="submitBtn">Find Instances</button></span>
        </div>
        </div>
        <font size ="2">&nbsp;&nbsp;<b>Tip</b> : Upload file containing list of servers</font><br><br>


        <div class="form-group" id="run_command" >
          <label for="server_list">Enter the Command to Run on servers : </label>
          <br>
          <div class="input-group">
            <span class="input-group-addon">#</span>
            <input required id="ssh_command" type="text" class="form-control" name="ssh_command" placeholder="Enter the Command(s)"  title="Enter the commands separated by ;" >      
          </div>        
         </div>
         <font size ="2">&nbsp;&nbsp;<b>Note</b> : You can enter multiple commands with semicolon(;) separated</font><br><br>

        <button id="sshrun_check_btn" type="submit" class="btn btn-primary">Get Details</button>
      </form>
      </div>
      </div>
END;

}


function sid_check()
{
  echo <<<END

  <div class="panel panel-primary" id="sid_check">
      <div class="panel-heading"> <b>Provide Below Details To Check: </b> </div>
      <div class="panel-body" >

      <br>
      <button  type="button" class="btn btn-default" onclick="appendInput( 'sid_usernames' , 'sidusername' , 'user_names' , 'Username to Login into Servers' , 'Enter the Username' , 'text' );appendInput( 'sid_passwords' , 'sidpassword' , 'pass_words' , 'Password to Login into Servers' , 'Enter the Password' , 'password' )" title="Add Username and Password Field"><img src="/img/add.png" alt="Add">&nbsp;&nbsp;Add Username and Password Field</button>
      <br><br>

      <form name="sid_check" autocomplete="off" action="/admin_task.php?task=sid_check" method="post" enctype="multipart/form-data">
        <p><b> Note: Usernames and Passwords are not stored in the server </b></p>
        <div class="form-group" id ="sid_usernames">
            <label for="user_names">Enter Usernames (Use "Add Username and Password Field" to provide Multiple Usernames): </label>
            <br>
            <input required  id="sidusername" type="text" class="form-control" name="user_names[]" placeholder="Username to Login into Servers"  title="Enter the Usernames">
        </div>
        <div class="form-group" id="sid_passwords">
            <label for="pass_words">Enter Passwords (Use "Add Username and Password Field" to provide Multiple Passwords): </label>
            <br>
            <input required  id="sidpassword" type="password" class="form-control" name="pass_words[]" placeholder="Password to Login into Servers"  title="Enter the Passwords">
        </div>
        <div class="form-group" id="onscreen_input" >
            <label for="sid_server_list">Enter the List of Server (Comma Separated): </label>
            <br>
            <input oninput="fileOnscreenToggle('sid_server_list','sidfile','onscreen')"  required id="sid_server_list" type="text" class="form-control" name="sid_server_list" placeholder="Comma Separated List of Servers"  title="Enter the List of Servers" >                
         </div>
         <div ><b style="color: red;">(Or)</b></div>

        <br><label for="Upload Text File">Text File:</label><br>
    <div class="input-group">
        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
          <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
          <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Upload text file</span><span class="fileinput-exists">Change</span>&nbsp;&nbsp;<input type="file" name="sidfile" onchange="fileOnscreenToggle('sid_server_list','sidfile','file')" id="sidfile" accept=".txt"></span>
          <span class="input-group-addon btn btn-success fileinput-exists"><button class="btn-success fileinput-exists" type="submit" id="submitBtn">Find Instances</button></span>
        </div>
        </div>
        <font size ="2">&nbsp;&nbsp;<b>Tip</b> : Upload file containing list of servers</font><br><br>

        <button id="sid_check_btn" type="submit" class="btn btn-primary">Get Details</button>
      </form>
      </div>
      </div>
END;

}

function pihana_form()
{
	echo <<<END

	  <div class="panel panel-primary" id="pihana_check">
	  <div class="panel-heading"> <b>Provide Below Details To Check PI Hana Servers: </b> </div>
	  <div class="panel-body" >

    <br>
      <button  type="button" class="btn btn-default" onclick="appendInput( 'pihana_usernames' , 'pihanausername' , 'user_names' , 'Username to Login into Servers' , 'Enter the Username' , 'text' );appendInput( 'pihana_passwords' , 'pihanapassword' , 'pass_words' , 'Password to Login into Servers' , 'Enter the Password' , 'password' )" title="Add Username and Password Field"><img src="/img/add.png" alt="Add">&nbsp;&nbsp;Add Username and Password Field</button>
      <br><br>


	  <form name="pihana_check" autocomplete="off" action="/admin_task.php?task=pihana_check" method="post" enctype="multipart/form-data">
	  	<p><b> Note: Usernames and Passwords are not stored in the server. Output of the quality check will be mailed </b></p>
	  	<div class="form-group" id="pihana_usernames">
	        <label for="user_names">Enter Usernames (Use "Add Username and Password Field" to provide Multiple Usernames): </label>
	        <br>
	        <input required  id="pihanausername" type="text" class="form-control" name="user_names[]" placeholder="Username to Login into Servers"  title="Enter the Usernames">
	    </div>
	    <div class="form-group" id="pihana_passwords">
	        <label for="pass_words">Enter Passwords (Use "Add Username and Password Field" to provide Multiple Passwords): </label>
	        <br>
	        <input required  id="pihanapassword" type="password" class="form-control" name="pass_words[]" autocomplete="off" placeholder="Password to Login into Servers"  title="Enter the Passwords">
	    </div>
	  	<div class="form-group" id="onscreen_input" >
	        <label for="pihana_server_list">Enter the List of Server (Comma Separated): </label>
	        <br>
	        <input oninput="fileOnscreenToggle('pihana_server_list','pihanafile','onscreen')"  required id="pihana_server_list" type="text" class="form-control disabled" name="pihana_server_list" placeholder="Comma Separated List of Servers"  title="Enter the List of Servers" >                
	     </div>

	    <div ><b style="color: red;">(Or)</b></div>

        <br><label for="Upload Text File">Text File:</label><br>
		<div class="input-group">
        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
        	<div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
        	<span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Upload text file</span><span class="fileinput-exists">Change</span>&nbsp;&nbsp;<input type="file" name="pihanafile" onchange="fileOnscreenToggle('pihana_server_list','pihanafile','file')" id="pihanafile" accept=".txt"></span>
        	<span class="input-group-addon btn btn-success fileinput-exists"><button class="btn-success fileinput-exists" type="submit" id="submitBtn">Find Instances</button></span>
        </div>
        </div>
        <font size ="2">&nbsp;&nbsp;<b>Tip</b> : Upload file containing list of servers</font><br><br>



	     <div class="form-group" id="email_id" >
	        <label for="server_list">Enter the Email Id to send O/P (Comma Separated): </label>
	        <br>
          <div class="input-group">
            <span class="input-group-addon">@</span>
  	        <input required id="email" type="email" class="form-control disabled" name="email_id" placeholder="Email id to Mail the output"  title="Enter the Email id" >     
          </div>           
	     </div>
	    <button id="pihana_check_btn" type="submit" name="submit" class="btn btn-primary">Get Details</button>
	  </form>
	  <hr>
	  <div style="text-align: center"><b style="color: red;">(Or)</b></div><br> 
	  <p><b>Get the Details of non complaint servers for Specified Period ( Max 7  Days )</b></p>
	   <form name="pihana_days" autocomplete="off" action="/admin_task.php" method="get" >
	   		<input type="text" name="task" value="pihana_check_days" hidden="">
			<select required name="noOfDays" >
				<option value="0">Last than a Day</option>
				<option value="1">Last 1 Day</option>
				<option value="2">Last 2 Days</option>
				<option value="3">Last 3 Days</option>
				<option value="4">Last 4 Days</option>
				<option value="5">Last 5 Days</option>
				<option value="6">Last 6 Days</option>
				<option value="7">Last 7 Days</option>
			</select>&nbsp;&nbsp;
			<button class="btn btn-primary btn-sm" type="submit" >Submit</button>
	  </form>
	  </div>
	  </div>
	 
END;

}

function ping_form()
{
	echo <<<END

	<div class="panel panel-primary" id="ping_check">
      <div class="panel-heading"> <b>Provide Below Details To Check: </b> </div>
      <div class="panel-body" >
      <form name="ping_check" autocomplete="off" action="/admin_task.php?task=ping_check" method="post" enctype="multipart/form-data">
      	<div class="form-group" id="onscreen_input" >
            <label for="ping_server_list">Enter the List of Server (Comma Separated): </label>
            <br>
            <input oninput="fileOnscreenToggle('ping_server_list','pingfile','onscreen')" required id="ping_server_list" type="text" class="form-control disabled" name="ping_server_list" placeholder="Comma Separated List of Servers"  title="Enter the List of Servers" >                
         </div>

        <div ><b style="color: red;">(Or)</b></div>

        <br><label for="Upload Text File">Text File:</label><br>
		<div class="input-group">
        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
        	<div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
        	<span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Upload text file</span><span class="fileinput-exists">Change</span>&nbsp;&nbsp;<input type="file" name="pingfile" onchange="fileOnscreenToggle('ping_server_list','pingfile','file')" id="pingfile" accept=".txt"></span>
        	<span class="input-group-addon btn btn-success fileinput-exists"><button class="btn-success fileinput-exists" type="submit" id="submitBtn">Find Instances</button></span>
        </div>
        </div>
        <font size ="2">&nbsp;&nbsp;<b>Tip</b> : Upload file containing list of servers</font><br><br>


        <button id="ping_check_btn" type="submit" class="btn btn-primary">Get Details</button>
      </form>
      </div>
      </div>
END;

}


function ldap_form()
{
	echo <<<END

	<div class="panel panel-primary" id="ldap_check">
      <div class="panel-heading"> <b>Provide Below Details To Check: </b> </div>
      <div class="panel-body" >
      <form name="ldap_check" autocomplete="off" action="/admin_task.php?task=ldap_check" method="post" enctype="multipart/form-data">
      	<div class="form-group" id="onscreen_input" >
            <label for="ldap_server_list">Enter the List of Server (Comma Separated): </label>
            <br>
            <input required oninput="fileOnscreenToggle('ldap_server_list','ldapfile','onscreen')" id="ldap_server_list" type="text" class="form-control disabled" name="ldap_server_list" placeholder="Comma Separated List of Servers"  title="Enter the List of Servers" >                
         </div>

        <div ><b style="color: red;">(Or)</b></div>

        <br><label for="Upload Text File">Text File:</label><br>
		<div class="input-group">
        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
        	<div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
        	<span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Upload text file</span><span class="fileinput-exists">Change</span>&nbsp;&nbsp;<input type="file" name="ldapfile" onchange="fileOnscreenToggle('ldap_server_list','ldapfile','file')" id="ldapfile" accept=".txt"></span>
        	<span class="input-group-addon btn btn-success fileinput-exists"><button class="btn-success fileinput-exists" type="submit" id="submitBtn">Find Instances</button></span>
        </div>
        </div>
        <font size ="2">&nbsp;&nbsp;<b>Tip</b> : Upload file containing list of servers</font><br><br>


        <button id="ldap_check_btn" type="submit" class="btn btn-primary">Get Details</button>
      </form>
      </div>
      </div>
END;

}

?>


