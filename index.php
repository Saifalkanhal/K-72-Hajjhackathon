
<!DOCTYPE html>
<head>
 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="../../css/editor.css" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Custom styles for this template -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link href="offcanvas.css" rel="stylesheet">
	<style>
		#map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
	</style>
  </head>
<html>

    <header style='text-align:center;background-color:#13683f;'>
        <img src="header.png"  />
    </header
</html>
  <body class="bg-light" >

    <main role="main" class="container">


      <div class="my-3 p-3 bg-white rounded box-shadow">
        
		<div id="chartContainer" style="float:right;height: 300px; width: 300PX;"></div>
		<form method="post" class="form-horizontal">
		<fieldset>

<!-- Form Name -->
<legend>Select Area</legend>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic"></label>
  <div class="col-md-4">
    
	 <?php
		echo '<select id="selectbasic" name="select_btn" class="form-control">';
	 
            $db = mysqli_connect('localhost', 'root', '123', 'systemdb');
          $check_query = "SELECT * FROM area";
		$result = mysqli_query($db, $check_query);
			
        
		echo "<option value=  0 > Select </option>";
		while ($row = mysqli_fetch_assoc($result)) {
			if( $_POST['select_btn'] == $row['Name'] ){
				echo "<option value= '" . $row['Name'] . "'selected >" . $row['Name'] . "</option>";
			}else
      echo "<option value= '" . $row['Name'] . "'>" . $row['Name'] . "</option>";
	  
		}

		echo '</select>';
		 
		 
		
		//$area = $_POST['select_btn'];
		//echo $area;
	  ?>
	
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <div class="col-md-4">
    <button id="singlebutton" name="area_btn" class="btn btn-primary">Search</button>
  </div>
</div>
</fieldset>
</form>
        
        
         <?php 
		 
		 
		 if (!empty($_POST['select_btn'])) {
			 $area = $_POST['select_btn'];
		 $db = mysqli_connect('localhost', 'root', '123', 'systemdb');
        $check_query = "SELECT * FROM tank WHERE Area='$area'  ORDER BY Used DESC";
		$result = mysqli_query($db, $check_query);
		 }
		?>
        
      <table class="table" style="">		  <thead>			<tr>			 			  <th> ID </th>			  <th>Location</th>			  <th>Capacity <img src="capacity.png" width='20px' height='25px;'/> </th>          <th>Used <img src="usage.png" width="20px" height='25px' /></th>    	  <th>out of box <img src="usage.png" width="20px" height='25px' /></th>        <th>temperature <img src="Temp.png" width='8px'/></th>		    <th>humidity<img src="hum.png" alt=""width='15px' style="" /></th>                </tr>		  </thead>		  <tbody>			<?php while ($row = mysqli_fetch_assoc($result)) { echo "<tr>";  echo "<td>".$row['ID']."</td>";  echo "<td>".$row['Area']."</td>";  echo "<td>".$row['percentage']."</td>"; echo "<td>".$row['Used']."</td>";echo "<td>".$row['outofbox']."</td>"; echo "<td>".$row['Temp']."</td>"; echo "<td>".$row['humidity']."</td>"; echo "</tr>";} ?>		  </tbody>		</table></div>
	 
        
      </div>

	  
      <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Result</h6>
       
	
	<div id="map"></div>
	
	 <!--
	  	  <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?> -->
    <script>
// Initialize and add the map
function initMap() {
  // The location of Uluru
  <?php
  
     $db = mysqli_connect('localhost', 'root', '123', 'systemdb');
        $check_query = "SELECT * FROM tank WHERE Area='$area'";
		$result = mysqli_query($db, $check_query);
		 $i = 0;
  while ($row = mysqli_fetch_assoc($result)) {
	  if($i == 0){
		  echo" var uluru = {lat:".$row['longitude'].", lng:".$row['latitude']."};";
	  }
	  else
  echo" var uluru".$row['ID']."= {lat:".$row['longitude'].", lng:".$row['latitude']."};";
   $i++;
  
  }
  //var uluru2 = {lat: 21.416576	, lng: 39.888002}; 
  ?>
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 15, center: uluru});
  // location
  <?php
  $db = mysqli_connect('localhost', 'root', '123', 'systemdb');
        $check_query = "SELECT * FROM tank WHERE Area='$area'";
		$result = mysqli_query($db, $check_query);
		$i = 0;
  while ($row = mysqli_fetch_assoc($result)) {
	   if($i == 0){
  echo "var marker = new google.maps.Marker({position: uluru, map: map});";
	   }else
   echo "var marker = new google.maps.Marker({position: uluru".$row['ID'].", map: map});";
  $i++;
  }
  //var marker = new google.maps.Marker({position: uluru2, map: map});
  ?>
  

}
    </script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4WocNf_2el4f-HgmuaUzR2aL77Pb8mrE&callback=initMap">
    </script>
	
	
	<?php
		$db = mysqli_connect('localhost', 'root', '123', 'systemdb');
        $check_query = "SELECT sum(percentage) AS 	Capacity,sum(Used) AS Used FROM tank WHERE Area='$area' GROUP BY Area";
		$result = mysqli_query($db, $check_query);
		while ($row = mysqli_fetch_assoc($result)) {
	  
		  $dataPoints = array( 
	//array("label"=>"Used", "y"=>),
		//array("label"=>"Temp", "y"=>),
	//array("label"=>"humidity", "y"=>),
	array("label"=>"Remaining Capacity", "y"=>$row['Capacity']-$row['Used']),
	//array("label"=>"Safari", "y"=>6.08),
	//array("label"=>"Temp", "y"=>$row['Temp']),
	array("label"=>"Used", "y"=>$row['Used'])
	);
		}


?>
	
	<script>
window.onload = function() {
 
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title: {
		text: "Status"
	},

	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"\"",
		indexLabel: "{label} ({y})",

		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
	
	
    </main>  
	  
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="../../js/vendor/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/holderjs@2.9.4/holder.js"></script>
    <script src="offcanvas.js"></script>
  
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" preserveAspectRatio="none" style="display: none; visibility: hidden; position: absolute; top: -100%; left: -100%;"><defs><style type="text/css"></style></defs><text x="0" y="2" style="font-weight:bold;font-size:2pt;font-family:Arial, Helvetica, Open Sans, sans-serif">32x32</text></svg><div class="card" style="">		  		  		</div></body>
</html>