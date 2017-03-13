<?php

  /*
         Provides graph functions

         Author: C5212215 ( Nithin SM )
  */

  //This is not a standalone script. Cannot load it directly unless called from the standalone script

  if (!isset($direct))
  {
    header( "Location: /admin_task.php?error=Cannot Load Directly" ) ;
      exit ;
  }

	function graph( $title , $id , $data )
	{
		echo "<script type=\"text/javascript\">
		    google.charts.setOnLoadCallback(drawChart);
	        function drawChart() 
	        {
		        var data = new google.visualization.DataTable();
	              data.addColumn('string', 'Topping');
	              data.addColumn('number', 'Slices');
	              data.addRows(" . $data . ");

		        // Set chart options
           		var options = {'title':'" . $title . "',
                           'height':600};

		        var chart = new google.visualization.PieChart(document.getElementById('" . $id . "'));

		        chart.draw(data, options);
        document.getElementById('btn_chart1_type').style.display='inline';
        document.getElementById('btn_chart2_type').style.display='inline';
	        }
      </script>" ;

	}

	function hist_chart( $title , $id , $data , $haxis , $vaxis , $height)
	{
    if ( ! isset($height) )
    {
      $height = 600 ;
    }
    
		echo "<script type=\"text/javascript\">
    google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(" . $data . ");

        var options = {
          title: '". $title ."',
          legend: { position: 'none' },
          hAxis: {title: '" . $haxis . "'},
          vAxis: {title: '" . $vaxis . "'},
          'height': " . $height . "
        };

        var chart = new google.visualization.Histogram(document.getElementById('" . $id . "'));
        chart.draw(data, options);
        document.getElementById('btn_chart1_type').style.display='inline';
        document.getElementById('btn_chart2_type').style.display='inline';
      }
  </script>" ;
	}

  function column_chart( $title , $id , $data , $width , $height )
  {
    if ( ! isset($width) )
    {
      $width = 900 ;
    }

    if ( ! isset($height) )
    {
      $height = 600 ;
    }

    echo "<script type=\"text/javascript\">
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(" . $data . ");

        var options = {
          chart: {
            title: '" . $title . "',
          } ,
          width: " . $width . ",
          height: " . $height . " ,
          hAxis: {
            allowContainerBoundaryTextCufoff: true ,
            maxTextLines: 10,
            format: 'short' },
          vAxis: {format: 'percent'},
          series: {
            0: { axis: 'Compliance' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'Non Compliance' } // Bind series 1 to an axis named 'brightness'.
          },

        };

        var chart = new google.charts.Bar(document.getElementById('" . $id . "'));

        chart.draw(data, options);
        document.getElementById('btn_chart1_type').style.display='inline';
        document.getElementById('btn_chart2_type').style.display='inline';
      }
    </script>" ;
  }

  function line_chart($title , $id , $data , $width , $height)
  {
    if ( ! isset($width) )
    {
      $width = 900 ;
    }

    if ( ! isset($height) )
    {
      $height = 600 ;
    }
    echo "<script type=\"text/javascript\">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(" . $data . ");

        var options = {
          title: '" . $title . "',
          curveType: 'none',
          width: " . $width . ",
          height: " . $height . " ,
          legend: { position: 'bottom' },
          chartArea: { left: 100 }
        };

        var chart = new google.visualization.LineChart(document.getElementById('" . $id . "'));

        chart.draw(data, options);
         document.getElementById('btn_chart1_type').style.display='inline';
        document.getElementById('btn_chart2_type').style.display='inline';
      }
    </script>" ;
  }
?>