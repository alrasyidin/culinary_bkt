<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='initial-scale=1.0, user-scalable=no' /><style type='text/css'> 
html { height: 100%;width: 100% } 
body { height: 100%; width: 100%; margin: 0px; padding: 0px }
#map { height: 100%; width: 100% }
</style>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBh7Xfdh42Ro9CNFPkvoZhFVhEpTeOP16g"></script>
<script src="../assets/js/GeoJSON.js"></script>
<script src='http://code.jquery.com/jquery-1.11.0.min.js' type='text/javascript'>
</script> 
<script src="../script.js"></script>
<? 
$lat = $_GET['lat']; $lng = $_GET['lng']; $warna=$_GET['warna'];$id_angkot=$_GET['id_angkot']; $latTujuan=$_GET['latTujuan'];
  $lngTujuan=$_GET['lngTujuan'];
  $bool=false;
if(isset($_GET['latsimpang'])){
  $latsimpang=$_GET['latsimpang'];
  $lngsimpang=$_GET['lngsimpang'];
  $bool=true;
}else{
  $latsimpang='0';
  $lngsimpang='0';
}
echo"
	<script>
	var server = 'http://192.168.1.44/t2/mobile';
			function init()
			{
				peta();
				kecamatanTampil();
				tempatibadah(); 
			}

			function peta()
			{
			  google.maps.visualRefresh = true;
			    map = new google.maps.Map(document.getElementById('map'), 
			    {
			      zoom: 12,
			      center: new google.maps.LatLng(-0.304820, 100.381421),
			      mapTypeId: google.maps.MapTypeId.ROADMAP
			    });
			}
		</script>"
?> 

</head>
<body onload='init()'> 
<div id='map'></div>
</body>
</html>