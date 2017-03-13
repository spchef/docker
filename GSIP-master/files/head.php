<?php
	
  /*
         Provides Head part of html

         Author: C5212215 ( Nithin SM )
  */

  //This is not a standalone script. Cannot load it directly unless called from the standalone script
  if (!isset($direct))
  {
    header( "Location: /?error=Cannot Load Directly" ) ;
      exit ;
  }
  
?>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">	    
	    <meta name="description" content="Monsoon API Services">
	    <meta name="author" content="">

	    <link rel="icon" href="/img/sap.ico">
	    <title>GLDS SM Inhouse Information Portal</title>	    
	    
	    <link href="/css/bootstrap.min.css" rel="stylesheet">
	    <link rel="stylesheet" href="/css/jasny-bootstrap.min.css">
	    <link rel="stylesheet" href="/css/googleicons.css">
	    <link rel="stylesheet" href="/css/w3.css">
	    <link href='/css/font-awesome.min.css' rel='stylesheet'/>
	    
	    <style type="text/css">
	    	@font-face { font-family: goodfish; src: url('/fonts/goodfish.ttf'); } 
	    	.panel-primary > .panel-heading {
			  background-color: #00008B;
			}

			.border-right {
			    border-right: 1px solid black;
			}

			.btn-primary-custom {
				 background-color: #00008B;
				 border-color: #00008B;
			}

			.btn-primary-custom:hover{
				 background-color: #00008B;
				 border-color: #00008B;
			}

			.btn-primary-custom:active{
				 background-color:#00008B;
				 border-color: #00008B;	
			}

			.btn-primary-custom:focus{
				 background-color: #00008B;
				 border-color: #00008B;
			}

	    	.news_panel {
			  min-height: 230;
			  max-height: 230;
			  overflow-y: scroll;
			}

			.roster-panel{				
			  min-height: 300;
			  max-height: 300;
			  overflow-y: scroll;
			}

			.shift_panel {
			  min-height: 140;
			  max-height: 140;
			  overflow-y: scroll;
			}

			.fixed-panel {
			  min-height: 500;
			  max-height: 500;
			  overflow-y: scroll;
			}

			.category-panel {
			  min-height: 500;
			  max-height: 500;
			  overflow-y: scroll;
			}
			.login-panel {
			  min-height: 375;
			  max-height: 375;
			  overflow-y: scroll;
			}
			.il-panel {
			  min-height: 340;
			  max-height: 340;
			  overflow-y: scroll;
			}

			.at-panel-sm {
			  min-height: 300;
			  max-height: 350;
			  overflow-y: scroll;
			}

			.page-header-custom{
				margin-top: 0px ;
				background-image: url("/img/back11.jpg") ;
				background-size:cover
			}

			.search-panel {
			  min-height: 100;
			  max-height: 100;
			  overflow-y: scroll;
			}

			.href { color: black }

			.input_width{
			   text-align:center;
			   width:  800px;
			}

			.hidden {
				display: none ;
			}

			body{
				font-family: Arial, Helvetica, sans-serif;
			}

			.btn-full {
				width: 100% ;
			}


			.imp_links_brown {
				color: #800000 ;
			}

			.imp_links_blue {
				color: #4B0082
			}

			.imp_links_most_used {
				font-size: 24px
			}

			.imp_links_mid_used {
				font-size: 18px
			}

			.imp_links_less_used {
				font-size: 12px
			}

			.modal-footer {
				background-color: #E6E6FA;
			}

			.modal-title{
				color: 	#008080 ;
			}

			.modal-dialog-custom{
			    overflow-y: initial !important ;
			}
			
			.modal-body-custom{
			    height: 100%;
			    overflow-y: auto;
			}

	    </style>

	    <script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>	
	    <script type="text/javascript" src="/js/Blob.js"></script>	 	
	    <script type="text/javascript" src="/js/FileSaver.min.js"></script>	 
	    <script type="text/javascript" src="/js/tableexport.min.js"></script> 
	    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
	    <script src="/js/sorttable.js" type="text/javascript"></script>
	    <script type="text/javascript" src="/js/bootstrap-filestyle.min.js"></script>
	    <script type="text/javascript" src="/js/custom.js"></script>
	    <script type="text/javascript" src="/js/jasny-bootstrap.min.js"></script>
	    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	    <script type="text/javascript" > 
	    	google.charts.load('current', {packages: ['corechart', 'bar']});
	    </script> 
    	 
    