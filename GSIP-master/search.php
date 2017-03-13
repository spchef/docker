<?php
	
	/*
		Search the external sap wiki. redirects the search parameter to the wiki
	*/

	//Encode the search parameter
	$search_parameter = urlencode($_POST['search']) ;

	//Redirect to wiki
	if (isset($search_parameter))
	{
		header('Location: https://wiki.wdf.sap.corp/wiki/dosearchsite.action?queryString=' . $search_parameter . '&startIndex=0' . '&where=ITLABS') ;
   		exit ;
	}
	
?>

