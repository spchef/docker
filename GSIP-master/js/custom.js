function displayHide(id,  attr ) 
{
	if ( id === undefined )
	{
		return 1;
	}
	var ele = document.getElementById(id) ;
	if ( ele.style.display === 'none' )
	{
		ele.style.display = 'block';
		if ( attr === undefined )
		{
			document.getElementById( id + '_btn_span' ).className = "glyphicon glyphicon-chevron-up" ;
		}		
	}else
	{
		ele.style.display = 'none';
		if ( attr === undefined )
		{
			document.getElementById( id + "_btn_span" ).className = 'glyphicon glyphicon-chevron-down' ;
		}	
	}
}


function addRowToProgress ( tableid )
{
	var table = document.getElementById(tableid);
	var rowCount = table.rows.length;
	var row = table.insertRow(-1);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	var cell5 = row.insertCell(4);
	var cell6 = row.insertCell(5);
	cell1.innerHTML = '<input style="width: 130px;" type="number" name="p_ticket[]" class="form-control input-sm" value="">';
    cell2.innerHTML = '<input style="width: 130px;" type="text" name="p_priority[]" class="form-control input-sm" value="">';
    cell3.innerHTML = '<input type="date" name="p_start_date[]" class="form-control input-sm" style="width: 130px;" value="">';
    cell4.innerHTML = '<input style="width: 250px;" type="text" name="p_desc[]" class="form-control input-sm" value="">';
    cell5.innerHTML = '<input style="width: 130px;" type="text" name="p_Action[]" class="form-control input-sm"  value="">';
    cell6.innerHTML = '<input style="width: 130px;" type="text" name="p_remark[]" class="form-control input-sm"  value="">';
}

function addRowToAA ( tableid )
{
	var table = document.getElementById(tableid);
	var rowCount = table.rows.length;
	var row = table.insertRow(-1);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	var cell5 = row.insertCell(4);
	var cell6 = row.insertCell(5);
	cell1.innerHTML = '<input style="width: 130px;" type="number" name="a_ticket[]" class="form-control input-sm" value="">';
    cell2.innerHTML = '<input style="width: 130px;" type="text" name="a_priority[]" class="form-control input-sm" value="">';
    cell3.innerHTML = '<input type="date" name="a_start_date[]" class="form-control input-sm" style="width: 130px;" value="">';
    cell4.innerHTML = '<input style="width: 250px;" type="text" name="a_desc[]" class="form-control input-sm" value="">';
    cell5.innerHTML = '<input style="width: 130px;" type="text" name="a_Action[]" class="form-control input-sm"  value="">';
    cell6.innerHTML = '<input style="width: 130px;" type="text" name="a_remark[]" class="form-control input-sm"  value="">';
}

function addRowToMonitor ( tableid )
{
	var table = document.getElementById(tableid);
	var rowCount = table.rows.length;
	var row = table.insertRow(-1);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	var cell5 = row.insertCell(4);
	cell1.innerHTML = '<input style="width: 130px;" type="number" name="m_ticket[]" class="form-control input-sm" value="">';
    cell2.innerHTML = '<input type="date" name="m_start_date[]" class="form-control input-sm" style="width: 130px;" value="">';
    cell3.innerHTML = '<input style="width: 250px;" type="text" name="m_status[]" class="form-control input-sm" value="">';
    cell4.innerHTML = '<input style="width: 130px;" type="text" name="m_movedto[]" class="form-control input-sm"  value="">';
    cell5.innerHTML = '<input style="width: 130px;" type="text" name="m_remark[]" class="form-control input-sm"  value="">';
}

function addRowToBas ( tableid )
{
	var table = document.getElementById(tableid);
	var rowCount = table.rows.length;
	var row = table.insertRow(-1);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	
	cell1.innerHTML = '<input style="width: 330px;" type="text" name="b_share[]" class="form-control input-sm" value="">';
    cell2.innerHTML = '<input type="text" name="b_status[]" class="form-control input-sm" style="width: 400px;" value="">';
    
}

function addRowToHandover ( tableid )
{
	var table = document.getElementById(tableid);
	var rowCount = table.rows.length;
	var row = table.insertRow(-1);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	cell1.innerHTML = '<input style="width: 130px;" type="number" name="ticket[]" class="form-control input-sm" id="shift_date">';
    cell2.innerHTML = '<input type="text" name="handover[]" class="form-control input-sm" id="shift_date" style="width: 360px;">';
    cell3.innerHTML = '<input style="width: 200px;" type="text" name="remark[]" class="form-control input-sm" id="shift_date">';
}

function deleteRowHandover ( tableid , rowNo = null  )
{
	var table = document.getElementById(tableid);
	var rowCount = table.rows.length;

	if ( rowCount <= 2 )
	{
		alert("Cannot Delete the Only Row") ;
		return ;
	}

	if ( rowNo == null )
	{		
		table.deleteRow ( rowCount - 1 );
	}else
	{
		if ( rowNo == 0 )
		{
			alert("Cannot Delete the Header") ;
			return ;
		}

		if ( rowNo >= rowCount )
		{
			alert("Invalid Row") ;
			return ;
		}
		table.deleteRow ( rowNo );
	}
	
}

function appendInput( divId , inpId , inpName , placeHolder , title , type = "text"  )
{
	var div = document.getElementById(divId );
	var i ; 

	for (i = 1 ; i < 101 ; i++) 
	{ 
    	var tmp = inpId + i.toString() ;

    	if ( document.getElementById(tmp ) === null )
    	{
    		inpId = tmp ;
    		break ;
    	}
	}


	div.innerHTML = div.innerHTML + '<br><input required  id="' + inpId + '" type="' + type + '" class="form-control" name="' + inpName + '[]" placeholder="' + placeHolder + '"  title="' + title + '">';
	
}

function removeInput ( parentId , childId )
{
	var element = document.getElementById(parentId);
    var child = document.getElementById(childId);
    element.removeChild(child);
}

function fileOnscreenToggle ( id , fileid , toggle )
{
	if ( toggle === 'file' )
	{
		input = document.getElementById( fileid ).value ;

		if ( input === "" )
		{
			document.getElementById( id ).removeAttribute( 'disabled' );
			document.getElementById( id ).setAttribute( 'required' , '1' ) ;
		}else
		{
			document.getElementById( fileid ).setAttribute( 'required' , '1' ) ;
			document.getElementById( id ).removeAttribute( 'required' );
			document.getElementById( id ).setAttribute( 'disabled' , '1' ) ;
		}
	}else
	{
		input = document.getElementById( id ).value ;

		if ( input === "" )
		{
			document.getElementById( fileid ).removeAttribute( 'disabled' );
			document.getElementById( fileid ).setAttribute( 'required' , '1' ) ;
		}else
		{
			document.getElementById( id ).setAttribute( 'required' , '1' ) ;
			document.getElementById( fileid ).removeAttribute( 'required' );
			document.getElementById( fileid ).setAttribute( 'disabled' , '1' ) ;
		}
	}
	
}

function addAttribute ( id , attribute , value  )
{
	document.getElementById( id ).setAttribute( attribute , value );
}

function removeAttribute ( id , attribute )
{
	document.getElementById( id ).removeAttribute( attribute );
}

function exportAndHide (tablename , id)
{
	$('#'.concat(tablename)).tableExport({formats: ["xls" , "csv", "txt"]});
	document.getElementById(id).style.display='none';
}

function defaultHidden( id ) {

	if ( id === undefined )
	{
		id = null ;
	}

	var ele = document.getElementById(id) ;
	ele.style.display = 'none';
}


function form_check( form_name , params , button ) {
	var form = document.forms[form_name].elements ;

	var temp = params.split(':') ;
	var canSubmit = true ; 

	for ( x = 0 ; x < temp.length ; x++  )
	{
		if ( form[temp[x]].value == null ||  form[temp[x]].value == "" )
		{
			canSubmit = false ;
			break ;
		}
	}

	if ( canSubmit )
	{
		document.getElementById(button).disabled = false ;
	}else
	{
		document.getElementById(button).disabled = true ;
	}
}


function check_match()
{
	var form = document.forms["password_form"].elements ;

	if ( form['confirm_pass_word'].value == form['new_pass_word'].value ) 
	{
		return true ;
	}else
	{	
		alert("Error! Passwords Donot Match Please Try Again") ;
		return false ;
	}
}

function check_match_variable( form_name , password , confirm_password , message )
{
	var form = document.forms[form_name].elements ;

	if ( form[password].value == form[confirm_password].value ) 
	{
		return true ;
	}else
	{	
		if ( message != undefined )
		{
			alert(message) ;
		}else
		{
			alert("Error! Passwords Donot Match Please Try Again") ;
		}
		
		return false ;
	}
}


function check_confirm()
{
	var r = confirm("Confirm Delete?") ;

	return r ;
}

function confirm_submit()
{
	var r = confirm("Confirm Submit?") ;

	return r ;
}

function disable(id)
{
	document.getElementById(id).disabled = true ;
}

function hide(id)
{
	document.getElementById(id).style.display = none ;
}

function enable(id)
{
	document.getElementById(id).disabled = false ;
}

function fnExcelReport( $id )
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById($id); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}
