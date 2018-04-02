<?php
require("connect.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>1311521018</title>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE&sensor=true"></script>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    
    
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>
    

<script type="text/javascript">

var server = "http://localhost/industri_kecil/";
var map;
var markersDua = [];
var koordinat = 'null'
var infoposisi = [];
var markerposisi = [];
var centerLokasi;
var markerposisi = [];
var centerBaru;
var cekRadiusStatus = "off"; 
var circles = [];
var rad;
var fotosrc = 'image/';
var angkot = [];
var directionsDisplay;
var infoDua=[];
var rute = [];

function a()
{
  $("#filterik").hide();
  $('#hasilik').show();
  $('#hasilcari1').show();
  $('#hasilcari').empty();
  $("#nearbyik").hide();
  $("#nearbyik1").hide();
  hapusInfo();

}


//Membuat Fungsi Saat Onload
function init()
{
  basemap();
  viewdigit();
  viewdigitsou();
  viewdigitcul();
  viewdigitkec();
}


//Membuat Fungsi Lokasi Manual
function lokasimanual()
{
  $("#filterik").hide();
  alert('Click On The Map');
  hapusMarkerTerdekat();
  hapusRadius();
  cekRadius();    
  map.addListener('click', function(event) {

    icon: "assets/img/now.png",
    addMarker(event.latLng);

    });
  }


//Membuat Fungsi Menampilkan Digitasi Seluruh IK
function viewdigit()
{
  ik = new google.maps.Data();
  ik.loadGeoJson(server+'industrikecil.php');
  ik.setStyle(function(feature)
  {
    return({
            fillColor: '#edc236',
            strokeColor: '#331428 ',
            strokeWeight: 2,
            fillOpacity: 0.5
          });          
  }
  );
  ik.setMap(map);
}

function viewdigitsou()
{
  souvv = new google.maps.Data();
  souvv.loadGeoJson(server+'souvenir.php');
  souvv.setStyle(function(feature)
  {
    return({
            fillColor: '#40ef83',
            strokeColor: '#040677 ',
            strokeWeight: 2,
            fillOpacity: 0.5
          });          
  }
  );
  souvv.setMap(map);
}

function viewdigitcul()
{
  cull = new google.maps.Data();
  cull.loadGeoJson(server+'kuliner.php');
  cull.setStyle(function(feature)
  {
    return({
            fillColor: '#f75d5d',
            strokeColor: '#065b38 ',
            strokeWeight: 2,
            fillOpacity: 0.5
          });          
  }
  );
  cull.setMap(map);
}


//Membuat Fungsi Menampilkan Digitasi Kecamatan (Batas Kecamatan Bukittinggi)
function viewdigitkec()
{
  ik = new google.maps.Data();
  ik.loadGeoJson(server+'bataskecamatan.php');
  ik.setStyle(function(feature)
  {
    return({
            strokeColor: '#385aaf',
            strokeWeight: 4,
            fillOpacity: 0.0,
            clickable : false
          });          
  }
  );
  ik.setMap(map);
}


//Membuat Fungsi Memberikan Marker IK
function addMarker(location)
{
  for (var i = 0; i < markerposisi.length; i++) 
  {
    markerposisi[i].setMap(null);
    hapusMarkerTerdekat();
    hapusRadius();
    cekRadius();
  } 
  marker = new google.maps.Marker
  ({
    icon: "assets/img/now.png",
    position : location,
    map: map,
    animation: google.maps.Animation.DROP,
  });
  koordinat = 
  {
    lat: location.lat(),
    lng: location.lng(),
  }
  centerLokasi = new google.maps.LatLng(koordinat.lat, koordinat.lng);
  markerposisi.push(marker);
  infowindow = new google.maps.InfoWindow();
  infowindow.setContent("<center><a style='color:black;'>You're Here <br> lat : "+koordinat.lat+" <br> long : "+koordinat.lng+"</a></center>");
  infowindow.open(map, marker);
  usegeolocation=true;
  markerposisi.push(marker)
  infoposisi.push(infowindow);  
}


//Membuat Fungsi Menampilkan Posisi Saat Ini
function posisisekarang()
{
  $("#filterik").hide();
  hapusMarkerTerdekat();  
  google.maps.event.clearListeners(map, 'click');
  navigator.geolocation.getCurrentPosition(function(position)
  {
    koordinat = 
    {
      lat: position.coords.latitude,
      lng: position.coords.longitude
    };
    console.log(koordinat)

    marker = new google.maps.Marker
    ({
      icon:"assets/img/now.png",
      position: koordinat,
      map: map,
      animation: google.maps.Animation.DROP,
    });

    infowindow = new google.maps.InfoWindow
    ({
      position: koordinat,
      content: "<center><a style='color:black;'>You're Here <br> lat : "+koordinat.lat+" <br> long : "+koordinat.lng+"</a></center>"
    });
    infowindow.open(map, marker);
    markersDua.push(marker);
    infoposisi.push(infowindow);
     map.setCenter(koordinat);
     map.setZoom(20); 
  });
}


//Membuat Fungsi Menampilkan Peta Google Map
function basemap()
{
  map = new google.maps.Map(document.getElementById('map'), 
  {
    zoom: 13,
    center: new google.maps.LatLng(-0.297030581246098, 100.388439689506),
    mapTypeId: google.maps.MapTypeId.SATELLITE
  });
}


//Membuat Fungsi Menampilkan Seluruh IK 
function viewik()
{
  hapusMarkerTerdekat();
  hapusRadius();
  hapusInfo();
  viewdigit();
  a();
  
  $.ajax
  ({ 
    url: server+'viewik.php', data: "", dataType: 'json', success: function(rows) 
    { 
      if(rows==null)
      {
        alert('Data Did Not Exist!');
      }
      else
      {
        $('#hasilcari').append("<thead><th>Name of Industry</th><th colspan='3'>Action</th></thead>");
        console.log(rows);
        for (var i in rows) 
        { 
          var row = rows[i];
          var id = row.id;
          var nama_industri = row.nama_industri;
          var lat=row.lat;
          var lon = row.lng;
          console.log(nama_industri);
          centerBaru = new google.maps.LatLng(lat, lon);
          map.setCenter(centerBaru);
          map.setZoom(15);  
          var marker = new google.maps.Marker
          ({
            position: centerBaru,              
            icon:'assets/img/path.png',
            animation: google.maps.Animation.DROP,
            map: map
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
           $('#hasilcari').append("<tr><td>"+nama_industri+"</td><td><a role='button' class='btn btn-success' onclick='detailinfoik(\""+id+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='industriAngkot(\""+id+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>") ;
        }
      } 
    }
  });           
}


//Membuat Fungsi Hapus Market Terdekat
function hapusMarkerTerdekat() 
{
  for (var i = 0; i < markersDua.length; i++) 
  {
    markersDua[i].setMap(null);
  }
}


//Membuat Fungsi Cari IK Berdasarkan Kecamatan
function viewkecamatan()
{
  if (document.getElementById('kecamatan1').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
  hapusMarkerTerdekat();
  a();
    $('#hasilcari').append("<thead><th>Name of Industry</th><th colspan='3'>Action</th></thead>");
    var ikkec = document.getElementById('kecamatan1').value;    
    $.ajax({ 
    url: server+'find_kec.php?kecamatan='+ikkec, data: "", dataType: 'json', success: function(rows)
    { 
        
        console.log(ikkec);
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var nama_industri   = row.nama_industri;
          var nama_kecamatan   = row.nama_kecamatan;
          var latitude  = row.latitude ;
          var longitude = row.longitude ;
          centerBaru = new google.maps.LatLng(latitude, longitude);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/path.png",
          });
          console.log(nama_industri);
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          $('#hasilcari').append("<tr><td>"+nama_industri+"</td><td><a role='button' class='btn btn-success' onclick='detailinfoik(\""+id+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='industriAngkot(\""+id+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");
        }   
      }
    }); 
  }
}


//Membuat Fungsi Cari IK Berdasarkan Jenis IK
function carijenisik()
{
  a();
  
  var jenisindustri = document.getElementById('jenisindustri')
  if(jenisindustri.value=='')
  {
    alert("Data Did Not Exist  !");
  }
  else
  {
    $('#hasilcari').append("<thead><th>Name of Industry</th><th colspan='3'>Action</th></thead>");
    var ikjns = document.getElementById('jenisindustri').value;
    console.log(ikjns);
    hapusInfo();
    hapusRadius();
    hapusMarkerTerdekat();
    $.ajax
    ({ 
      url: server+'find_jns.php?cari_jenis='+ikjns, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var nama_industri   = row.nama_industri;
          var id_jenis_industri   = row.id_jenis_industri;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/path.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          console.log(id_jenis_industri);
          $('#hasilcari').append("<tr><td>"+nama_industri+"</td><td><a role='button' class='btn btn-success' onclick='detailinfoik(\""+id+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='industriAngkot(\""+id+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");
        }   
      }
    }); 
  }
}


//Membuat Fungsi Mencari IK
function find_ik() //industri kecil
{
 a();
  if(ik_nama.value=='')
  {
    alert("Isi kolom pencarian terlebih dahulu !");
  }
  else
  {
    $('#hasilcari').append("<thead><th>Name of Industry</th><th colspan='3'>Action</th></thead>");
    var iknama = document.getElementById('ik_nama').value;
    console.log(iknama);
    hapusInfo();
    hapusRadius();
    hapusMarkerTerdekat();
    $.ajax
    ({ 
      url: server+'find_ik.php?cari_nama='+iknama, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id  = row.id;
          var nama_industri   = row.nama_industri;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/path.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          console.log(nama_industri);
          $('#hasilcari').append("<tr><td>"+nama_industri+"</td><td><a role='button' class='btn btn-success' onclick='detailinfoik(\""+id+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='industriAngkot(\""+id+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");
        }   
      }
    }); 
  }
}


//Menampilkan Form FilterIK
function pilihwilayah()
{
  $("#filterik").show();
  $("#hasilik").hide();

}

//Menampilkan Form FilterIK
function pilihwilayahsou()
{
  $("#filtersou").show();
  $("#hasilik").hide();

}


//Menampilkan Detail Info IK
function detailinfoik(id1){  
  
  $('#info').empty();
  hapusInfo();
  hapusMarkerTerdekat();
       $.ajax({ 
      url: server+'detailinfoik.php?info='+id1, data: "", dataType: 'json', success: function(rows)
        { 
         for (var i in rows) 
          { 
            console.log('dd');
            var row = rows[i];
            var id = row.id;
            var foto = row.foto;
            var namaa = row.nama_industri;
            var alamat=row.alamat;
            var produk=row.produk;
            var harga_barang=row.harga_barang;
            var pemilik=row.pemilik;
            var cp = row.cp;
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/path.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(16); 
            if (alamat==null)
                    {
                      alamat="tidak ada";
                    } 
                    if (foto=='null' || foto=='' || foto==null){
            foto='eror.png';
          } 
             $('#info').append("");
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,

            content: "<center><span style=color:black><b>Information</b><br><image src="+fotosrc+foto+" style='width:200px;'><br><table><tr><td><i class='fa fa-home'></i>Nama</td><td>:</td><td> "+namaa+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Alamat</td><td>:</td><td> "+alamat+"</td></tr><tr><td><i class='fa fa-shopping-cart'></i>Produk</td><td>:</td><td> "+produk+"</td></tr><br><tr><td><i class='fa fa-money'></i>Harga</td><td>:</td><td> "+harga_barang+"</td></tr><br><tr><td><i class='fa fa-phone'></i>Telepon</td><td>:</td><td> "+cp+"</td></tr></table></span><br><input type='button' class='btn btn-success' value='Radius' onclick='tampil_sekitar(\""+latitude+"\",\""+longitude+"\",\""+namaa+"\")' />",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }  
           
            // ;ow();tampilsekitar()
        }
      }); 
}

function nearby(){
  
  $("#hasilik").hide();
  $("#nearbyik").show();
  $("#nearbyik1").show();
}



//Menghapus Info
function hapusInfo() {
        for (var i = 0; i < infoposisi.length; i++) {
              infoposisi[i].setMap(null);
              }
      }


//Fungsi Filter 3 Tabel
function tampilikwilayah()
{
  a();
  var c = document.getElementById('filterjenisindustri').value;
  var b = document.getElementById('filterkecamatan').value;
  var cari = document.getElementById('filterstatustempat').value;
  console.log(cari);
  hapusInfo();
  hapusRadius();
  hapusMarkerTerdekat();
  console.log(b);
  console.log(c);
  $.ajax
  ({ 
    url: server+'/filter.php?id11='+c+'&id22='+b+'&cari='+cari, data: "", dataType: 'json', success: function(rows) 
    { 
      if(rows==null)
      {
        alert('Data Did not Exist!');
      }
      else
      {
        $('#hasilcari').append("<thead><th>Name of Industry</th><th colspan='3'>Action</th></thead>");
        for (var i in rows) 
        { 
          var row = rows[i];
          var id   = row.id;
          var nama_industri   = row.nama_industri;
          var nama_jenis_industri   = row.nama_jenis_industri;
          var id_kecamatan = row.id_kecamatan;
          var status = row.status;
          var latitude  = row.lat ;
          var longitude = row.lon ;
          console.log(nama_industri);
          console.log(latitude,longitude);
          centerBaru = new google.maps.LatLng(latitude, longitude);
          marker = new google.maps.Marker
          ({
            position: centerBaru,              
            icon: "assets/img/path.png",
            animation: google.maps.Animation.DROP,
            map: map
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(18);
        
          $('#hasilcari').append("<tr><td>"+nama_industri+"</td><td><a role='button' class='btn btn-success' onclick='detailinfoik(\""+id+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='industriAngkot(\""+id+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");
        }
      }
    } 
  });
}


//Fungsi Filter 3 Tabel Souvenir
function tampilsouwilayah()
{
  a();
  var e = document.getElementById('filterjenissouvenir').value;
  var z = document.getElementById('filterkecamatansou').value;
  var carii = document.getElementById('filterstatustempatsou').value;
  console.log(carii);
  hapusInfo();
  hapusRadius();
  hapusMarkerTerdekat();
  console.log(z);
  console.log(e);
  $.ajax
  ({ 
    url: server+'/filtersou.php?id1111='+e+'&id2222='+z+'&carii='+carii, data: "", dataType: 'json', success: function(rows) 
    { 
      if(rows==null)
      {
        alert('Data Did not Exist!');
      }
      else
      {
        $('#hasilcari').append("<thead><th>Name</th><th colspan='3'>Action</th></thead>");
        for (var i in rows) 
        { 
          var row = rows[i];
          var id_oleh_oleh   = row.id_oleh_oleh;
          var nama_oleh_oleh   = row.nama_oleh_oleh;
          var jenis_oleh   = row.jenis_oleh;
          var id_kecamatan = row.id_kecamatan;
          var status = row.status;
          var latitude  = row.lat ;
          var longitude = row.lon ;
          console.log(nama_oleh_oleh);
          console.log(latitude,longitude);
          centerBaru = new google.maps.LatLng(latitude, longitude);
          marker = new google.maps.Marker
          ({
            position: centerBaru,              
            icon: "assets/img/path.png",
            animation: google.maps.Animation.DROP,
            map: map
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(15);
        
          $('#hasilcari').append("<tr><td>"+nama_oleh_oleh+"</td><td><a role='button' class='btn btn-success' onclick='detailinfoik(\""+id_oleh_oleh+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='souAngkot(\""+id_oleh_oleh+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");
        }
      }
    } 
  });
}



function masjidsekitar(a,b,c) { //menampilkan msj sekitar ik
      $('#hasilmosque').show();
      $('#hasilcarimosque1').show();
      $('#hasilcarimosque').empty();
      //hapusInfo();
      // clearroute2();
      // hapusInfo();
      // clearroute2();
      //    $('#info1').append("<thead><th>Nama</th><th>Harga</th><th colspan='2'>Aksi</th></thead>");
      //       hapusMarkerTerdekat1();
      //hapusMarkerTerdekat();
      
      $.ajax({ 
      url: server+'masjidradius.php?lat='+a+'&lng='+b+'&rad='+c, data: "", dataType: 'json', success: function(rows)
        { 
          if(rows==null)
          {
            alert('Data Masjid Tidak Ada');
          
            
          }
     else
     {
        for (var i in rows) 
          {   
           
              var row     = rows[i];
              var id_masjid   = row.id_masjid;
              var nama_masjid   = row.nama_masjid;
              var alamat = row.alamat;
              var latitude  = row.latitude ;
              var longitude = row.longitude ;
              centerBaru = new google.maps.LatLng(latitude, longitude);
              marker = new google.maps.Marker
              ({
          position: centerBaru,
          icon:'assets/img/msj.png',
          map: map,
          animation: google.maps.Animation.DROP,
        });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
              map.setCenter(centerBaru);
              map.setZoom(14);
              
             $('#hasilcarimosque').append("<tr><td>"+nama_masjid+"</td><td><a role='button' class='btn btn-success' onclick='detailinfomosque(\""+id_masjid+"\")'>Show</a></td></tr>"); 
                        }
         }
        }
      });
}


function detailinfomosque(id9){  
  
  $('#info').empty();
   hapusInfo();
      // clearroute2();
      hapusMarkerTerdekat();
       $.ajax({ 
      url: server+'detailinfomosque.php?info='+id9, data: "", dataType: 'json', success: function(rows)
        { 
         for (var i in rows) 
          { 
            console.log('dd');
            var row = rows[i];
            var id_masjid = row.id_masjid;
            //var foto = row.foto;
            var nama_masjid = row.nama_masjid;
            var alamat=row.alamat;
            var kapasitas = row.kapasitas;
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/msj.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(18); 
          //   if (alamat==null)
          //           {
          //             alamat="tidak ada";
          //           } 
          //           if (foto=='null' || foto=='' || foto==null){
          //   foto='eror.png';
          // } 
            // $('#info').append("Nama : "+nama+" <br> Alamat : "+alamat+" <br> Kapasitas : "+kapasitas+"");
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,
            content: "<center><span style=color:black><b>Information</b><br><table><tr><td><i class='fa fa-home'></i>Nama Masjid</td><td>:</td><td> "+nama_masjid+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Alamat</td><td>:</td><td> "+alamat+"</td></tr><br><tr><td><i class='fa fa-building'></i>Kapasitas</td><td>:</td><td> "+kapasitas+"</td></tr></table></span><br><input type='button' class='btn btn-success' value='Gallery' onclick='masjidsekitar("+latitude+","+longitude+",500)'/>",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }  
           
            // ;ow();tampilsekitar()
        }
      }); 
}


//menampilkan obj wisata sekitar ik
function objsekitar(d,e,f) { //menampilkan obj sekitar ik
    
      // $('#info1').empty();
      
      //$('#hasilcari').empty();
      //$('#hasilik').empty();

      $('#hasilobj').show();
      $('#hasilcariobj1').show();
      $('#hasilcariobj').empty();
      //hapusInfo();
      // clearroute2();
      // hapusInfo();
      // clearroute2();
      //    $('#info1').append("<thead><th>Nama</th><th>Harga</th><th colspan='2'>Aksi</th></thead>");
      //       hapusMarkerTerdekat1();
      //hapusMarkerTerdekat();
      
      $.ajax({ 
      url: server+'objradius.php?lat='+d+'&lng='+e+'&rad='+f, data: "", dataType: 'json', success: function(rows)
        { 
          if(rows==null)
          {
            alert('Data Objek Wisata Tidak Ada');
          
            
          }
     else
     {
        for (var i in rows) 
          {   
           
              var row     = rows[i];
              var id_tempat_wisata   = row.id_tempat_wisata;
              var nama_tempat_wisata   = row.nama_tempat_wisata;
              var lokasi = row.lokasi;
              var latitude  = row.latitude ;
              var longitude = row.longitude ;
              centerBaru = new google.maps.LatLng(latitude, longitude);
              marker = new google.maps.Marker
              ({
          position: centerBaru,
          icon:'assets/img/tours.png',
          map: map,
          animation: google.maps.Animation.DROP,
        });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
              map.setCenter(centerBaru);
              map.setZoom(14);
              
             $('#hasilcariobj').append("<tr><td>"+nama_tempat_wisata+"</td><td><a role='button' class='btn btn-success' onclick='detailinfoobj(\""+id_tempat_wisata+"\")'>Show</a></td></tr>"); 
                        }
         }
        }
      });
}

//Menampilkan Detail Info Obj Wisata
function detailinfoobj(id3){  
  
  $('#info').empty();
   hapusInfo();
      // clearroute2();
      hapusMarkerTerdekat();
       $.ajax({ 
      url: server+'detailinfoobj.php?info='+id3, data: "", dataType: 'json', success: function(rows)
        { 
         for (var i in rows) 
          { 
            console.log('dddd');
            var row = rows[i];
            var id_tempat_wisata = row.id_tempat_wisata;
            //var foto = row.foto;
            var nama_tempat_wisata = row.nama_tempat_wisata;
            var lokasi=row.lokasi;
            var jam_buka = row.jam_buka;
            var jam_tutup = row.jam_tutup;
            var biaya = row.biaya;
            var fasilitas = row.fasilitas;
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/tours.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(16); 
          //   if (alamat==null)
          //           {
          //             alamat="tidak ada";
          //           } 
          //           if (foto=='null' || foto=='' || foto==null){
          //   foto='eror.png';
          // } 
            // $('#info').append("Nama : "+nama+" <br> Alamat : "+alamat+" <br> Kapasitas : "+kapasitas+"");
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,
            content: "<center><span style=color:black><b>Information</b><br><table><tr><td><i class='fa fa-home'></i>Nama Objek</td><td>:</td><td> "+nama_tempat_wisata+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Alamat</td><td>:</td><td> "+lokasi+"</td></tr><br><tr><td><i class='fa fa-building'></i>Jam Buka</td><td>:</td><td> "+jam_buka+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Jam Tutup</td><td>:</td><td> "+jam_tutup+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Biaya</td><td>:</td><td> "+biaya+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Fasilitas</td><td>:</td><td> "+fasilitas+"</td></tr></table></span><br><input type='button' class='btn btn-success' value='Gallery' onclick='objsekitar("+latitude+","+longitude+",500)'/>",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }  
           
            // ;ow();tampilsekitar()
        }
      }); 
}


//Membuat Fungsi Mencari Souvenir
function find_sou() //industri kecil
{
  $("#filterik").hide();
  $('#hasilik').show();
  $('#hasilcari1').show();
  $('#hasilcari').empty();
  if(sou_nama.value=='')
  {
    alert("Isi kolom pencarian terlebih dahulu !");
  }
  else
  {
    //$('#hasilcari').empty();
    $('#hasilcari').append("<thead><th>Name</th><th colspan='3'>Action</th></thead>");
    var sounama = document.getElementById('sou_nama').value;
    console.log(sounama);
    hapusInfo();
    // clearangkot();
    hapusRadius();
    hapusMarkerTerdekat();
    $.ajax
    ({ 
      url: server+'find_sou.php?cari_nama='+sounama, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id_oleh_oleh  = row.id_oleh_oleh;
          var nama_oleh_oleh   = row.nama_oleh_oleh;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/path.png",
          });
          // console.log(lat);
          // console.log(lon);
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          console.log(nama_oleh_oleh);
          $('#hasilcari').append("<tr><td>"+nama_oleh_oleh+"</td><td><a role='button' class='btn btn-success' onclick='detailinfosou(\""+id_oleh_oleh+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='souAngkot(\""+id_oleh_oleh+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");
        }   
      }
    }); 
  }
}


//Menampilkan Detail Info Souvenir
function detailinfosou(id14){  
  
  $('#info').empty();
   hapusInfo();
      // clearroute2();
      hapusMarkerTerdekat();
       $.ajax({ 
      url: server+'detailinfosou.php?info='+id14, data: "", dataType: 'json', success: function(rows)
        { 
         for (var i in rows) 
          { 
            console.log('ddd');
            var row = rows[i];
            var id_oleh_oleh = row.id_oleh_oleh;
            var foto = row.foto;
            var namaa = row.nama_oleh_oleh;
            var alamat=row.alamat;
            var cp = row.cp;
            var pemilik = row.pemilik;
            var produk = row.produk;
            var harga_barang = row.harga_barang;

            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/path.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(18); 
            if (alamat==null)
                    {
                      alamat="tidak ada";
                    } 
                    if (foto=='null' || foto=='' || foto==null){
            foto='eror.png';
          } 
            // $('#info').append("Nama : "+nama+" <br> Alamat : "+alamat+" <br> Kapasitas : "+kapasitas+"");
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,
            content: "<center><span style=color:black><b>Information</b><br><image src="+fotosrc+foto+" style='width:200px;'><table><tr><td><i class='fa fa-home'></i>Nama</td><td>:</td><td> "+namaa+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Alamat</td><td>:</td><td> "+alamat+"</td></tr><br><tr><td><i class='fa fa-shopping-cart'></i>Produk</td><td>:</td><td> "+produk+"</td></tr><br><tr><td><i class='fa fa-money'></i>Harga</td><td>:</td><td> "+harga_barang+"</td></tr><br><tr><td><i class='fa fa-phone'></i>Telepon</td><td>:</td><td> "+cp+"</td></tr></table></span><br><input type='button' class='btn btn-success' value='Radius' onclick='tampil_sekitar(\""+latitude+"\",\""+longitude+"\",\""+namaa+"\")' />",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }  
           
            // ;ow();tampilsekitar()
        }
      }); 
}


//Membuat Fungsi Cari Souvenir Berdasarkan Kecamatan
function viewkecamatansou()
{
  if (document.getElementById('carikecamatansou').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
  hapusMarkerTerdekat();
  $("#filterik").hide();
  $('#hasilik').show();
  $('#hasilcari1').show();
  $('#hasilcari').empty();
  // var carikecamatansou = document.getElementById('carikecamatansou');
  // if(carikecamatansou.value=='')
  // {
  //   alert("Data Did Not Exist !");
  // }
  // else
  // {
    // $('#tampillistik').empty();
    $('#hasilcari').append("<thead><th>Name</th><th colspan='3'>Action</th></thead>");
    var soukec = document.getElementById('carikecamatansou').value;
    console.log(soukec);
    hapusInfo();
    // clearangkot();
    hapusRadius();
    hapusMarkerTerdekat();
    $.ajax
    ({ 
      url: server+'find_kec_sou.php?kecamatan='+soukec, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id_oleh_oleh  = row.id_oleh_oleh;
          var nama_oleh_oleh   = row.nama_oleh_oleh;
          var id_kecamatan   = row.id_kecamatan;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/path.png",
          });
          // console.log(lat);
          // console.log(lon);
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          console.log(id_kecamatan);
          $('#hasilcari').append("<tr><td>"+nama_oleh_oleh+"</td><td><a role='button' class='btn btn-success' onclick='detailinfosou(\""+id_oleh_oleh+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='souAngkot(\""+id_oleh_oleh+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");
        }   
      }
    }); 
  }
}


//Membuat Fungsi Cari Souvenir Berdasarkan Jenis Souvenir
function carijenissou()
{
  $("#filterik").hide();
  $('#hasilik').show();
  $('#hasilcari1').show();
  $('#hasilcari').empty();
  
  var jenissou = document.getElementById('jenissou')
  if(jenissou.value=='')
  {
    alert("Data Did Not Exist  !");
  }
  else
  {
    // $('#tampillistik').empty();
    $('#hasilcari').append("<thead><th>Name</th><th colspan='3'>Action</th></thead>");
    var soujns = document.getElementById('jenissou').value;
    console.log(soujns);
    hapusInfo();
    // clearangkot();
    hapusRadius();
    hapusMarkerTerdekat();
    $.ajax
    ({ 
      url: server+'find_jns_sou.php?cari_jenis='+soujns, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id_oleh_oleh  = row.id_oleh_oleh;
          var nama_oleh_oleh   = row.nama_oleh_oleh;
          var id_jenis_oleh   = row.id_jenis_oleh;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/path.png",
          });
          // console.log(lat);
          // console.log(lon);
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          console.log(id_jenis_oleh);
          $('#hasilcari').append("<tr><td>"+nama_oleh_oleh+"</td><td><a role='button' class='btn btn-success' onclick='detailinfosou(\""+id_oleh_oleh+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='souAngkot(\""+id_oleh_oleh+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");
        }   
      }
    }); 
  }
}


//Membuat Fungsi Menampilkan Seluruh Souvenirs 
function viewsou()
{
  hapusMarkerTerdekat();
  hapusRadius();
  hapusInfo();
  viewdigit();
  $("#filterik").hide();
  $('#hasilik').show();
  $('#hasilcari1').show();
  $('#hasilcari').empty();
  $.ajax
  ({ 
    url: server+'viewsou.php', data: "", dataType: 'json', success: function(rows) 
    { 
      if(rows==null)
      {
        alert('Data Did Not Exist!');
      }
      else
      {
        $('#hasilcari').append("<thead><th>Name</th><th colspan='3'>Action</th></thead>");
        console.log(rows);
        for (var i in rows) 
        { 
          var row = rows[i];
          var id_oleh_oleh = row.id_oleh_oleh;
          var nama_oleh_oleh = row.nama_oleh_oleh;
          // var alamat = row.alamat;
          // var telp = row.telp;
          var lat=row.lat;
          var lon = row.lng;
          //var ik_status = row.ik_status;
          console.log(nama_oleh_oleh);
          centerBaru = new google.maps.LatLng(lat, lon);
          map.setCenter(centerBaru);
          map.setZoom(15);  
          var marker = new google.maps.Marker
          ({
            position: centerBaru,              
            icon:'assets/img/path.png',
            animation: google.maps.Animation.DROP,
            map: map
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          // console.log(nama);
           $('#hasilcari').append("<tr><td>"+nama_oleh_oleh+"</td><td><a role='button' class='btn btn-success' onclick='detailinfosou(\""+id_oleh_oleh+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='souAngkot(\""+id_oleh_oleh+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");
        }
      } 
    }
  });           
}



// function angkotSekitar(lat, lon, nama, id_ik)
//         {
//             //$('#tampillistangkotik').empty();
//             //clearroute();
//             //tampil_angkotik();
//              $('#tampilangkotsekitarik ').show();
//               $('#tampillistangkotik1').show();
//               $('#tampillistangkotik').empty();
//             hapusInfo();
//             hapusRadius();
//             hapusMarkerTerdekat();
//             hapusInfo();
//             //clearangkot();
//             //clearsimpang();
//             //hapusmarkersimpang();
//             centerBaru = new google.maps.LatLng(lat, lon);
//               map.setCenter(centerBaru);
//               map.setZoom(15); 
//               var marker = new google.maps.Marker({
//                 position: centerBaru,              
//                 //icon:'icon/ik.png',
//                 animation: google.maps.Animation.DROP,
//                 map: map
//               }); 
//               console.log(nama);
//               markersDua.push(marker);
//               map.setCenter(centerBaru);
//               infowindow = new google.maps.InfoWindow({
//                   position: centerBaru,
//                   content: "<bold>"+nama+"",
//                   pixelOffset: new google.maps.Size(0, -1)
//                     });
//                 infoposisi.push(infowindow); 
//                 infowindow.open(map);
            
//             $('#tampillistangkotik').append("<tr align='center'><td>No Angkot</td><td colspan='2'>Aksi</td></tr>");
//             $.ajax({ 
//             url: server+'/tampilangkotSekitar.php?lat='+lat+'&lon='+lon, data: "", dataType: 'json', success: function(rows) 
//             { 
//               for (var i in rows) 
//                   { 
//                     var row = rows[i];
//                     console.log("sdzsc");
//                     var id_angkot = row.id_angkot;
//                     var no_angkot = row.no_angkot;
//                     var jurusan = row.jurusan;
//                     //var jalur_angkot = row.jalur_angkot;
//                     var warna_angkot = row.warna_angkot;
//                     //var warna = row.warna;
//                     console.log(id_angkot);
//                     var latitude=row.latitude;
//                     var longitude = row.longitude;
//                     console.log(latitude);
//                     console.log(longitude);
//                 $('#tampillistangkotik').append("<tr><td>"+no_angkot+"</td><td><a role='button' class='btn btn-success' onclick='detailangkot(\""+id_angkot+"\",\""+id_angkot+"\")'>Show</a></td><td><a role='button' class='btn btn-primary' onclick='galeriangkot(\""+id_angkot+"\")'>Gallery</a></td></tr>");

//                 }   

//             } 
//          });                  
//         }


  function detailangkot(id_angkot){
          //clearangkot();
          hapusRadius();
          hapusMarkerTerdekat();
          
            $.ajax({ 
            url: server+'/tampilkanrute.php?id_angkot='+id_angkot, data: "", dataType: 'json', success: function(rows) 
            { 
              for (var i in rows.features) 
                { 
                  var id_angkot=rows.features[i].properties.id_angkot;
                  //var warna=rows.features[i].properties.warna;
                  var latitude  = rows.features[i].properties.latitude; 
                  var longitude = rows.features[i].properties.longitude ;
                  var jalur_angkot=rows.features[i].properties.jalur_angkot;
                  var jurusan=rows.features[i].properties.jurusan;
                  var warna_angkot=rows.features[i].properties.warna_angkot;
                  console.log(id_angkot);

                  
                   
                 /* var infowindow = new google.maps.InfoWindow({
                    position: centerBaru,
                    content: "<bold>INFORMASI</bold><br>Kode Trayek: "+id_angkot+"<br>Jurusan: "+jurusan+"<br>Warna Angkot: "+warna_angkot+"<br>Jalur Angkot: "+jalur_angkot+"<br><input type='button' class='btn btn-primary' value='IK Sekitar'  onclick='industriAngkot(\""+id_angkot+"\");'/>",
                  });
                    infowindow.open(map);*/
                  //listgeom(id_angkot)
                  tampilrute(id_angkot,  latitude, longitude)  

                }  
                                     
            } 
         });           
        }

      function tampilrute(id_angkot,  latitude, longitude){
        //clearangkot();
        ja = new google.maps.Data();
        //console.log(warna);
        ja.loadGeoJson(server+'tampilkanrute.php?id_angkot='+id_angkot);
        ja.setStyle(function(feature){
          return({
              fillColor: 'yellow',
              //strokeColor: warna,
              strokeWeight: 2,
              fillOpacity: 0.5
              });          
        });
        ja.setMap(map);  
        angkot.push(ja);
        map.setZoom(18);
        }


//Membuat Fungsi Menampilkan Seluruh Kuliner 
function viewkul()
{
  hapusMarkerTerdekat();
  hapusRadius();
  hapusInfo();
  viewdigit();
  $("#filterik").hide();
  $('#hasilik').show();
  $('#hasilcari1').show();
  $('#hasilcari').empty();
  $.ajax
  ({ 
    url: server+'viewkul.php', data: "", dataType: 'json', success: function(rows) 
    { 
      if(rows==null)
      {
        alert('Data Did Not Exist!');
      }
      else
      {
        $('#hasilcari').append("<thead><th>Name</th><th colspan='3'>Action</th></thead>");
        console.log(rows);
        for (var i in rows) 
        { 
          var row = rows[i];
          var id_tempat_kuliner = row.id_tempat_kuliner;
          var nama_tempat_kuliner = row.nama_tempat_kuliner;
          var alamat=row.alamat;
          var cp=row.cp;
          var menu_spesial=row.menu_spesial;
          var jam_tutup=row.jam_tutup;
          var jam_buka=row.jam_buka;
          var kapasitas=row.kapasitas;
          var fasilitas=row.fasilitas;
          var harga=row.harga;
          var lat=row.lat;
          var lon = row.lng;
          //var ik_status = row.ik_status;
          console.log(nama_tempat_kuliner);
          centerBaru = new google.maps.LatLng(lat, lon);
          map.setCenter(centerBaru);
          map.setZoom(15);  
          var marker = new google.maps.Marker
          ({
            position: centerBaru,              
            icon:'assets/img/path.png',
            animation: google.maps.Animation.DROP,
            map: map
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          // console.log(nama);
           $('#hasilcari').append("<tr><td>"+nama_tempat_kuliner+"</td><td><a role='button' class='btn btn-success' onclick='detailinfokul(\""+id_tempat_kuliner+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='kulAngkot(\""+id_tempat_kuliner+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");
        }
      } 
    }
  });           
}


//Menampilkan Detail Info Kuliner
function detailinfokul(id144){  
  
  $('#info').empty();
   hapusInfo();
      // clearroute2();
      hapusMarkerTerdekat();
       $.ajax({ 
      url: server+'detailinfokul.php?info='+id144, data: "", dataType: 'json', success: function(rows)
        { 
         for (var i in rows) 
          { 
            console.log('ddd');
            var row = rows[i];
            var id_tempat_kuliner = row.id_tempat_kuliner;
            var namaa = row.nama_tempat_kuliner;
            var alamat=row.alamat;
            var cp=row.cp;
            var harga=row.harga;
            var menu_spesial=row.menu_spesial;
            var jam_buka = row.jam_buka;
            var jam_tutup = row.jam_tutup;
            var foto = row.foto;
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/path.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(18); 
            if (alamat==null)
                    {
                      alamat="tidak ada";
                    } 
                    if (foto=='null' || foto=='' || foto==null){
            foto='eror.png';
          } 
            // $('#info').append("Nama : "+nama+" <br> Alamat : "+alamat+" <br> Kapasitas : "+kapasitas+"");
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,
            content: "<center><span style=color:black><b>Information</b><br><image src="+fotosrc+foto+" style='width:200px;'><table><tr><td><i class='fa fa-home'></i>Nama</td><td>:</td><td> "+namaa+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Alamat</td><td>:</td><td> "+alamat+"</td></tr><br><tr><td><i class='fa fa-shopping-cart'></i>Menu Spesial</td><td>:</td><td> "+menu_spesial+"</td></tr><br><tr><td><i class='fa fa-money'></i>Harga</td><td>:</td><td> "+harga+"</td></tr><br><tr><td><i class='fa fa-phone'></i>Telepon</td><td>:</td><td> "+cp+"</td></tr></table></span><br><input type='button' class='btn btn-success' value='Radius' onclick='tampil_sekitar(\""+latitude+"\",\""+longitude+"\",\""+namaa+"\")' />",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }  
           
            // ;ow();tampilsekitar()
        }
      }); 
}


//Membuat Fungsi Mencari Kuliner
function find_kul() //industri kecil
{
  $("#filterik").hide();
  $('#hasilik').show();
  $('#hasilcari1').show();
  $('#hasilcari').empty();
  if(kul_nama.value=='')
  {
    alert("Isi kolom pencarian terlebih dahulu !");
  }
  else
  {
    //$('#hasilcari').empty();
    $('#hasilcari').append("<thead><th>Name</th><th colspan='3'>Action</th></thead>");
    var kulnama = document.getElementById('kul_nama').value;
    console.log(kulnama);
    hapusInfo();
    // clearangkot();
    hapusRadius();
    hapusMarkerTerdekat();
    $.ajax
    ({ 
      url: server+'find_kul.php?cari_nama='+kulnama, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id_tempat_kuliner  = row.id_tempat_kuliner;
          var nama_tempat_kuliner   = row.nama_tempat_kuliner;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/path.png",
          });
          // console.log(lat);
          // console.log(lon);
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(15);
          console.log(nama_tempat_kuliner);
          $('#hasilcari').append("<tr><td>"+nama_tempat_kuliner+"</td><td><a role='button' class='btn btn-success' onclick='detailinfokul(\""+id_kuliner+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='kulAngkot(\""+id_tempat_kuliner+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");
        }   
      }
    }); 
  }
}


function find_kul_menu() //menu kuliner
{
  $("#filterik").hide();
  $('#hasilik').show();
  $('#hasilcari1').show();
  $('#hasilcari').empty();
  if(kul_menu.value=='')
  {
    alert("Isi kolom pencarian terlebih dahulu !");
  }
  else
  {
    //$('#hasilcari').empty();
    $('#hasilcari').append("<thead><th>Name</th><th colspan='3'>Action</th></thead>");
    var kulmenu = document.getElementById('kul_menu').value;
    console.log(kulmenu);
    hapusInfo();
    // clearangkot();
    hapusRadius();
    hapusMarkerTerdekat();
    $.ajax
    ({ 
      url: server+'find_kul_menu.php?cari_nama='+kulmenu, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id_tempat_kuliner  = row.id_tempat_kuliner;
          var nama_tempat_kuliner   = row.nama_tempat_kuliner;
          var menu_spesial   = row.menu_spesial;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/path.png",
          });
          // console.log(lat);
          // console.log(lon);
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(15);
          console.log(nama_tempat_kuliner);
          $('#hasilcari').append("<tr><td>"+nama_tempat_kuliner+"</td><td><a role='button' class='btn btn-success' onclick='detailinfokul(\""+id_tempat_kuliner+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='kulAngkot(\""+id_tempat_kuliner+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");
        }   
      }
    }); 
  }
}






//Membuat Fungsi Cari Kuliner Berdasarkan Kecamatan
function viewkecamatankul()
{
  if (document.getElementById('carikecamatankul').value=="")
    {
      alert("Pilih Option Dahulu !");
    }
    else
    {
  hapusMarkerTerdekat();
  a();
    $('#hasilcari').append("<thead><th>Name</th><th colspan='3'>Action</th></thead>");
    var kulkec = document.getElementById('carikecamatankul').value;
    console.log(kulkec);
    hapusInfo();
    hapusRadius();
    hapusMarkerTerdekat();
    $.ajax
    ({ 
      url: server+'find_kec_kul.php?kecamatan='+kulkec, data: "", dataType: 'json', success: function(rows)
      { 
        if(rows==null)
        {
          alert('Data Did Not Exist !');
        }
        for (var i in rows)
        {   
          var row     = rows[i];
          var id_tempat_kuliner  = row.id_tempat_kuliner;
          var nama_tempat_kuliner   = row.nama_tempat_kuliner;
          var id_kecamatan   = row.id_kecamatan;
          var lat  = row.latitude ;
          var lon = row.longitude ;
          centerBaru = new google.maps.LatLng(lat, lon);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            map: map,
            icon: "assets/img/path.png",
          });
          markersDua.push(marker);
          map.setCenter(centerBaru);
          map.setZoom(14);
          console.log(id_kecamatan);
          $('#hasilcari').append("<tr><td>"+nama_tempat_kuliner+"</td><td><a role='button' class='btn btn-success' onclick='detailinfokul(\""+id_tempat_kuliner+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='kulAngkot(\""+id_tempat_kuliner+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");
        }   
      }
    }); 
  }
}

function hotelsekitar(m,n,o) { //menampilkan msj sekitar ik
    
      // $('#info1').empty();
      
      //$('#hasilcari').empty();
      //$('#hasilik').empty();
      //$('#hasilobj').empty();
      $('#hasilhotel').show();
      $('#hasilcarihotel1').show();
      $('#hasilcarihotel').empty();
      //hapusInfo();
      // clearroute2();
      // hapusInfo();
      // clearroute2();
      //    $('#info1').append("<thead><th>Nama</th><th>Harga</th><th colspan='2'>Aksi</th></thead>");
      //       hapusMarkerTerdekat1();
      //hapusMarkerTerdekat();
      
      $.ajax({ 
      url: server+'hotelradius.php?lat='+m+'&lng='+n+'&rad='+o, data: "", dataType: 'json', success: function(rows)
        { 
          if(rows==null)
          {
            alert('Data Hotel Tidak Ada');
          
            
          }
     else
     {
        for (var i in rows) 
          {   
           
              var row     = rows[i];
              var id_hotel   = row.id_hotel;
              var nama_hotel   = row.nama_hotel;
              var alamat = row.alamat;
              var latitude  = row.latitude ;
              var longitude = row.longitude ;
              centerBaru = new google.maps.LatLng(latitude, longitude);
              marker = new google.maps.Marker
              ({
          position: centerBaru,
          icon:'assets/img/hotels.png',
          map: map,
          animation: google.maps.Animation.DROP,
        });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
              map.setCenter(centerBaru);
              map.setZoom(14);
              
             $('#hasilcarihotel').append("<tr><td>"+nama_hotel+"</td><td><a role='button' class='btn btn-success' onclick='detailinfohotel(\""+id_hotel+"\")'>Show</a></td></tr>"); 
                        }
         }
        }
      });
}


function detailinfohotel(id90){  
  
  $('#info').empty();
   hapusInfo();
      // clearroute2();
      hapusMarkerTerdekat();
       $.ajax({ 
      url: server+'detailinfohotel.php?info='+id90, data: "", dataType: 'json', success: function(rows)
        { 
         for (var i in rows) 
          { 
            console.log('dd');
            var row = rows[i];
            var id_hotel = row.id_hotel
            //var foto = row.foto;
            var nama_hotel = row.nama_hotel;
            var alamat=row.alamat;
            var fasilitas = row.fasilitas;
            var tipe_kamar = row.tipe_kamar;
            var harga = row.harga;
            var latitude  = row.latitude; ;
            var longitude = row.longitude ;
            centerBaru = new google.maps.LatLng(row.latitude, row.longitude);
            marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/hotels.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
            map.setCenter(centerBaru);
            map.setZoom(18); 
          //   if (alamat==null)
          //           {
          //             alamat="tidak ada";
          //           } 
          //           if (foto=='null' || foto=='' || foto==null){
          //   foto='eror.png';
          // } 
            // $('#info').append("Nama : "+nama+" <br> Alamat : "+alamat+" <br> Kapasitas : "+kapasitas+"");
            infowindow = new google.maps.InfoWindow({
            position: centerBaru,
            content: "<center><span style=color:black><b>Information</b><br><table><tr><td><i class='fa fa-home'></i>Nama Hotel</td><td>:</td><td> "+nama_hotel+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Alamat</td><td>:</td><td> "+alamat+"</td></tr><br><tr><td><i class='fa fa-building'></i>Fasilitas</td><td>:</td><td> "+fasilitas+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Tipe Kamar</td><td>:</td><td> "+tipe_kamar+"</td></tr><br><tr><td><i class='fa fa-map-marker'></i>Harga</td><td>:</td><td> "+harga+"</td></tr></table></span><br><input type='button' class='btn btn-success' value='Gallery' onclick='masjidsekitar("+latitude+","+longitude+",500)'/>",   
            pixelOffset: new google.maps.Size(0, -33)
            });
          infoposisi.push(infowindow); 
          hapusInfo();
          infowindow.open(map);
            
          }  
        }
      }); 
}


//Menampilkan Angkot Sekitar Industri
function industriAngkot(id_angkot,nama_industri){
            //$('#listangkot').hide();
          //tampil_ikangkot();
          hapusMarkerTerdekat();
          hapusInfo();
          $('#tampilangkotsekitarik').show();
          $('#tampillistangkotik1').show();
          $('#tampillistangkotik').empty();

          // $('#tampilangkotsekitarik').empty();
          // $('#tampillistangkotik').append("<thead><th>Nama Industri</th><th>Aksi</th></thead>");
          $('#tampillistangkotik').append("<thead><th>No Angkot</th><th colspan='2'>Action</th></thead>");
          $.ajax({ 
          url: server+'/_angkot_industri.php?id='+id_angkot, data: "", dataType: 'json', success: function(rows) 
          { 
            if(rows==null)
            {
              alert('Data Did Not Exist!');
            }
            else
            {
            for (var i in rows) 
              { 
                var row = rows[i];
                var id = row.id;
                var no_angkot = row.no_angkot;
                var id_angkot = row.id_angkot;
                var nama_industri = row.nama_industri;
                
                var lat=row.latitude;
                var lon = row.longitude;
                console.log(no_angkot);
                centerBaru = new google.maps.LatLng(lat, lon);
                map.setCenter(centerBaru);
                map.setZoom(18);  
                var marker = new google.maps.Marker({
                  position: centerBaru,              
                  icon:'assets/img/path.png',
                  animation: google.maps.Animation.DROP,
                  map: map
                  });
                markersDua.push(marker);
                map.setCenter(centerBaru);
                marker.info = new google.maps.InfoWindow({
                  position: centerBaru,
                  content: "<bold>"+nama_industri+"",
                  pixelOffset: new google.maps.Size(0, -1)
                    });
                marker.info.open(map,marker);
                //infoposisi.push(infowindow); 
                //infowindow.open(map);
                console.log(no_angkot);
                $('#tampillistangkotik').append("<tr><td>"+no_angkot+"</td><td><a role='button' class='btn btn-success' onclick='detailangkot(\""+id_angkot+"\")'>Lihat</a></td></tr>");
              }
            }
           }
         });  
        }
      
//Menampilkan Angkot Sekitar Souvenir
function souAngkot(id_angkot11){
            //$('#listangkot').hide();
          //tampil_ikangkot();
          hapusMarkerTerdekat();
          hapusInfo();
          $('#tampilangkotsekitarik').show();
          $('#tampillistangkotik1').show();
          $('#tampillistangkotik').empty();

          // $('#tampilangkotsekitarik').empty();
          // $('#tampillistangkotik').append("<thead><th>Nama Industri</th><th>Aksi</th></thead>");
          $('#tampillistangkotik').append("<thead><th>No Angkot</th><th colspan='2'>Action</th></thead>");
          $.ajax({ 
          url: server+'/_angkot_souvenirs.php?id_oleh_oleh='+id_angkot11, data: "", dataType: 'json', success: function(rows) 
          { 
            if(rows==null)
            {
              alert('Data Did Not Exist!');
            }
            else
            {
            for (var i in rows) 
              { 
                var row = rows[i];
                var id_oleh_oleh = row.id_oleh_oleh;
                var no_angkot = row.no_angkot;
                var id_angkot = row.id_angkot;
                var nama_oleh_oleh = row.nama_oleh_oleh;
                
                var lat=row.latitude;
                var lon = row.longitude;
                console.log(no_angkot);
                centerBaru = new google.maps.LatLng(lat, lon);
                map.setCenter(centerBaru);
                map.setZoom(18);  
                var marker = new google.maps.Marker({
                  position: centerBaru,              
                  icon:'assets/img/path.png',
                  animation: google.maps.Animation.DROP,
                  map: map
                  });
                markersDua.push(marker);
                map.setCenter(centerBaru);
                infowindow = new google.maps.InfoWindow({
                  position: centerBaru,
                  content: "<bold>"+nama_oleh_oleh+"",
                  pixelOffset: new google.maps.Size(0, -1)
                    });
                infoposisi.push(infowindow); 
                infowindow.open(map);
                console.log(no_angkot);
                $('#tampillistangkotik').append("<tr><td>"+no_angkot+"</td><td><a role='button' class='btn btn-success' onclick='detailangkot(\""+id_angkot+"\")'>Lihat</a></td></tr>");
              }
            }
           }
         });  
        }



//Menampilkan Angkot Sekitar Kuliner
function kulAngkot(id_angkot1122){
            //$('#listangkot').hide();
          //tampil_ikangkot();
          hapusMarkerTerdekat();
          hapusInfo();
          $('#tampilangkotsekitarik').show();
          $('#tampillistangkotik1').show();
          $('#tampillistangkotik').empty();

          // $('#tampilangkotsekitarik').empty();
          // $('#tampillistangkotik').append("<thead><th>Nama Industri</th><th>Aksi</th></thead>");
          $('#tampillistangkotik').append("<thead><th>No Angkot</th><th colspan='2'>Action</th></thead>");
          $.ajax({ 
          url: server+'/_angkot_culinary.php?id_tempat_kuliner='+id_angkot1122, data: "", dataType: 'json', success: function(rows) 
          { 
            if(rows==null)
            {
              alert('Data Did Not Exist!');
            }
            else
            {
            for (var i in rows) 
              { 
                var row = rows[i];
                var id_tempat_kuliner = row.id_tempat_kuliner;
                var no_angkot = row.no_angkot;
                var id_angkot = row.id_angkot;
                var nama_tempat_kuliner = row.nama_tempat_kuliner;
                
                var lat=row.latitude;
                var lon = row.longitude;
                console.log(no_angkot);
                centerBaru = new google.maps.LatLng(lat, lon);
                map.setCenter(centerBaru);
                map.setZoom(18);  
                var marker = new google.maps.Marker({
                  position: centerBaru,              
                  icon:'assets/img/path.png',
                  animation: google.maps.Animation.DROP,
                  map: map
                  });
                markersDua.push(marker);
                map.setCenter(centerBaru);
                infowindow = new google.maps.InfoWindow({
                  position: centerBaru,
                  content: "<bold>"+nama_tempat_kuliner+"",
                  pixelOffset: new google.maps.Size(0, -1)
                    });
                infoposisi.push(infowindow); 
                infowindow.open(map);
                console.log(no_angkot);
                $('#tampillistangkotik').append("<tr><td>"+no_angkot+"</td><td><a role='button' class='btn btn-success' onclick='detailangkot(\""+id_angkot+"\")'>Lihat</a></td></tr>");
              }
            }
           }
         });  
        }


function callRoute(start, end)
{
  $('#hasilrute').show();
  $('#detailrute1').show();
  $('#detailrute').empty();
  hapusMarkerTerdekat();
  clearroute2();

  if (koordinat == 'null' || typeof(koordinat) == "undefined")
  {
    alert('Klik Tombol Posisi Saat ini Dulu');
  }
  else
  {
    directionsService = new google.maps.DirectionsService;
    directionsDisplay = new google.maps.DirectionsRenderer;
    directionsService.route
    (
    {
      origin:start,
      destination : end,
      travelMode:google.maps.TravelMode.DRIVING
    },
    function(response, status)
    {
      if (status === google.maps.DirectionsStatus.OK)
      {
        directionsDisplay.setDirections(response);
      }
      else
      {
        window.alert('Direction request failed due to' +status);
      }
    }
    );
    directionsDisplay.setMap(map);
    map.setZoom(16);

    directionsDisplay.setPanel(document.getElementById('detailrute1'));
  }
}




function clearroute2(){      
    if(typeof(directionsDisplay) != "undefined" && directionsDisplay.getMap() != undefined){
    directionsDisplay.setMap(null);
    $("#rute").remove();
    }     

}

//Menampilkan Form FilterIK
function selectkul()
{

  $("#selectkulll").show();
  $("#hasilik").hide();
  //$("#filterik").hide();
}

function viewkull()
{
  $("#hasilik").show();
 $('#hasilcari1').show();
  $('#hasilcari').empty();
//       hapusInfo();
//       clearroute2();
      hapusMarkerTerdekat();
  var fas=selectkul.value;
  var arrayLay=[];
  for(i=0;i<$("input[name=kuliner]:checked").length;i++){
    arrayLay.push($("input[name=kuliner]:checked")[i].value);
  }
  console.log('zz');
  if (arrayLay==''){
    alert('Pilih Kuliner');
  }else{
    $('#hasilcari').append("<thead><th>Name</th><th colspan='3'>Action</th></thead>");
    $.ajax({ url: server+'selectkul.php?lay='+arrayLay, data: "", dataType: 'json', success: function(rows){
      console.log("hai");
      if(rows==null)
            {
              alert('Data not found');
            }
        for (var i in rows) 
            {   
              var row     = rows[i];
              var id_tempat_kuliner   = row.id_tempat_kuliner;
              var nama_kuliner   = row.nama_kuliner;
              var nama_tempat_kuliner   = row.nama_tempat_kuliner;
              var latitude  = row.latitude ;
              var longitude = row.longitude ;
              centerBaru = new google.maps.LatLng(latitude, longitude);
              marker = new google.maps.Marker
            ({
              position: centerBaru,
              icon:'assets/img/path.png',
              map: map,
              animation: google.maps.Animation.DROP,
            });
              console.log(nama_tempat_kuliner);
              console.log(latitude);
              console.log(longitude);
              markersDua.push(marker);
              map.setCenter(centerBaru);
              map.setZoom(16);
              $('#hasilcari').append("<tr><td>"+nama_tempat_kuliner+"</td><td><a role='button' class='btn btn-success' onclick='detailinfokul(\""+id_tempat_kuliner+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='kulAngkot(\""+id_tempat_kuliner+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");
            }

    }});
  }
}


// function hapusMarkerInfoWindow (){
//   setMapOnAll(null);
//   hapusMarkerTerdekat();
//   centerBaru = 'null' ;
// }

// function setMapOnAll(map){
//   for (var i = 0; i < markers.length; i++) {
//     markers[i].setMap(map);
//   }
// }



// function viewkecamatan(){
// var carikecamatan = document.getElementById('carikecamatan')
// alert(carikecamatan.value)
//  }

 function hapus_Semua(){
          //set posisi
          basemap()

          //hapus semua data
          hapusRadius();
          //hapus_landmark();
          //hapus_kecuali_landmark();
          a();
          }

 function hapus_kecuali_landmark(){
            hapusRadius();
            hapusMarkerObject();
            hapusInfo();
            clearangkot();
            clearroute();
          }
 
 function hapusMarkerObject() {
            for (var i = 0; i < markersDua.length; i++) {
                  markersDua[i].setMap(null);
              }
          }

   function clearangkot(){
          for (i in angkot){
              angkot[i].setMap(null);
            } 
            angkot=[]; 
          }

  function clearroute(){
          for (i in rute){
            rute[i].setMap(null);
          } 
          rute=[]; 
        }
 /********************************************************************************************************************** RADIUS - OBJEK SEKITAR
 ************************************************************************************************************************/

var rad_lat=0;
var rad_lng=0;
 function tampil_sekitar(latitude,longitude,namaa){
        hapus_Semua();

        rad_lat = latitude;
        rad_lng = longitude;

        //Hilangkan Button Sekitar
        $('#view_sekitar').empty();
        document.getElementById("inputradius").style.display = "inline";

        // POSISI MARKER
        centerBaru = new google.maps.LatLng(latitude, longitude);
        map.setZoom(16);  
          var marker = new google.maps.Marker({map: map, position: centerBaru, 
         icon:'assets/img/path.png',
          animation: google.maps.Animation.DROP,
          clickable: true});

        //INFO WINDOW
        marker.info = new google.maps.InfoWindow({
          content: "<bold>"+namaa+"",
          pixelOffset: new google.maps.Size(0, -1)
            });
          marker.info.open(map, marker);

        $("#nearbyik").show();

        $("#hasilculi").hide();
        $("#hasilsouv").hide();
        $("#hasilindustry").hide();
        $("#hasilobj").hide();
        $("#hasilhotel").hide();
        $("#hasilmosque").hide();

        //$("#view_kanan_data").hide();
       // $("#view_galery").hide();                         
      }


function industri_sekitar(latitude,longitude,rad){ //INDUSTRI SEKITAR
        $('#hasilcariind').empty();
        $('#hasilcariind1').show();
        $('#hasilcariind').append("<thead><th class='centered'>Nama Industri</th><th class='centered'>Aksi</th></thead>");
        $.ajax({url: server+'_sekitar_industri.php?lat='+latitude+'&long='+longitude+'&rad='+rad, data: "", dataType: 'json', success: function(rows){ 
          for (var i in rows){ 
            var row = rows[i];
            var id = row.id;
            var nama_industri = row.nama_industri;
            var alamat = row.alamat;
            var cp = row.cp;
            var lat=row.latitude;
            var lon = row.longitude;
            console.log(nama_industri);

            //POSISI MAP
            centerBaru = new google.maps.LatLng(lat, lon);
            map.setCenter(centerBaru);
            map.setZoom(16);  
            var marker = new google.maps.Marker({
              position: centerBaru,              
              icon:'assets/img/ik.png',
              animation: google.maps.Animation.DROP,
              map: map
              });
            markersDua.push(marker);
            map.setCenter(centerBaru);
            $('#hasilcariind').append("<tr><td>"+nama_industri+"</td><td><a role='button' class='btn btn-success' onclick='set_center(\""+lat+"\",\""+lon+"\",\""+nama_industri+"\")'>Lihat</a></td></tr>");
          }//end for
        }});//end ajax  
      }


function kuliner_sekitar(latitude,longitude,rad){ //KULINER SEKITAR 

          $('#hasilcariculi').empty();
          $('#hasilcariculi1').show();
          $('#hasilcariculi').append("<thead><th class='centered'>Nama Kuliner</th><th class='centered'>Aksi</th></thead>");
          $.ajax({url: server+'_sekitar_kuliner.php?lat='+latitude+'&long='+longitude+'&rad='+rad, data: "", dataType: 'json', success: function(rows){ 
            for (var i in rows){ 
              var row = rows[i];
              var id_tempat_kuliner = row.id_tempat_kuliner;
              var nama_tempat_kuliner = row.nama_tempat_kuliner;
              var alamat = row.alamat;
              var cp = row.cp;
              var menu_spesial = row.menu_spesial;
              var jam_buka = row.jam_buka;
              var jam_tutup = row.jam_tutup;
              var kapasitas = row.kapasitas;
              var fasilitas = row.fasilitas;
              var harga = row.harga;
              var jumlah_karyawan = row.jumlah_karyawan;
              var lat=row.latitude;
              var lon = row.longitude;

              //POSISI MAP
              centerBaru = new google.maps.LatLng(lat, lon);
              map.setCenter(centerBaru);
              map.setZoom(16);  
              var marker = new google.maps.Marker({
                position: centerBaru,              
                icon:'assets/img/cul.png',
                animation: google.maps.Animation.DROP,
                map: map
                });
              markersDua.push(marker);
              map.setCenter(centerBaru);

              $('#hasilcariculi').append("<tr><td>"+nama_tempat_kuliner+"</td><td><a role='button' class='btn btn-success' onclick='set_center(\""+lat+"\",\""+lon+"\",\""+nama_tempat_kuliner+"\")'>Lihat</a></td></tr>");
            }//end for
          }});//end ajax  
        }


function masjid_sekitar(latitude,longitude,rad){ // MASJID SEKITAR 

        $('#hasilcarimosque').empty();
        $('#hasilcarimosque1').show();
        $('#hasilcarimosque').append("<thead><th class='centered'>Nama Masjid</th><th class='centered'>Aksi</th></thead>");
        $.ajax({url: server+'_sekitar_masjid.php?lat='+latitude+'&long='+longitude+'&rad='+rad, data: "", dataType: 'json', success: function(rows){ 
          for (var i in rows){ 
            var row = rows[i];
            var id_masjid = row.id_masjid;
            var nama_masjid = row.nama_masjid;
            var alamat = row.alamat;
            var kapasitas = row.kapasitas;
            var lat=row.latitude;
            var lon = row.longitude;
            
            //POSISI MAP
            centerBaru = new google.maps.LatLng(lat, lon);
            map.setCenter(centerBaru);
            map.setZoom(16);  
            var marker = new google.maps.Marker({
              position: centerBaru,              
              icon:'assets/img/msj.png',
              animation: google.maps.Animation.DROP,
              map: map
              });
            markersDua.push(marker);
            map.setCenter(centerBaru);

            $('#hasilcarimosque').append("<tr><td>"+nama_masjid+"</td><td><a role='button' class='btn btn-success' onclick='set_center(\""+lat+"\",\""+lon+"\",\""+nama_masjid+"\")'>Lihat</a></td></tr>");
          }//end for
        }});//end ajax  
      }

function oleholeh_sekitar(latitude,longitude,rad){ // OLEH-OLEH SEKITAR 

          $('#hasilcarisouv').empty();
           $('#hasilcarisouv1').show();
          $('#hasilcarisouv').append("<thead><th class='centered'>Nama Tempat Oleh Oleh</th><th class='centered'>Aksi</th></thead>");
          $.ajax({url: server+'_sekitar_oleholeh.php?lat='+latitude+'&long='+longitude+'&rad='+rad, data: "", dataType: 'json', success: function(rows){ 
            for (var i in rows){ 
              var row = rows[i];
              var id_oleh_oleh = row.id_oleh_oleh;
              var nama_oleh_oleh = row.nama_oleh_oleh;
              var pemilik = row.pemilik;
              var cp = row.cp;
              var alamat = row.alamat;
              var produk = row.produk;
              var harga_barang = row.harga_barang;
              var lat=row.latitude;
              var lon = row.longitude;
              
              //POSISI MAP
              centerBaru = new google.maps.LatLng(lat, lon);
              map.setCenter(centerBaru);
              map.setZoom(16);  
              var marker = new google.maps.Marker({
                position: centerBaru,              
                icon:'assets/img/souv.png',
                animation: google.maps.Animation.DROP,
                map: map
                });
              markersDua.push(marker);
              map.setCenter(centerBaru);

              $('#hasilcarisouv').append("<tr><td>"+nama_oleh_oleh+"</td><td><a role='button' class='btn btn-success' onclick='set_center(\""+lat+"\",\""+lon+"\",\""+nama_oleh_oleh+"\")'>Lihat</a></td></tr>");
            }//end for
          }});//end ajax  
        }

function tw_sekitar(latitude,longitude,rad){ // TEMPAT WISATA SEKITAR 

          $('#hasilcariobj').empty();
          $('#hasilcariobj1').show();
          $('#hasilcariobj').append("<thead><th class='centered'>Nama Tempat Wisata</th><th class='centered'>Aksi</th></thead>");
          $.ajax({url: server+'_sekitar_tw.php?lat='+latitude+'&long='+longitude+'&rad='+rad, data: "", dataType: 'json', success: function(rows){ 
            for (var i in rows){ 
              var row = rows[i];
              var id_tempat_wisata = row.id_tempat_wisata;
              var nama_tempat_wisata = row.nama_tempat_wisata;
              var lokasi = row.lokasi;
              var jam_buka = row.jam_buka;
              var jam_tutup = row.jam_tutup;
              var biaya = row.biaya;
              var fasilitas = row.fasilitas;
              var keterangan = row.keterangan;
              var lat=row.latitude;
              var lon = row.longitude;
              
              //POSISI MAP
              centerBaru = new google.maps.LatLng(lat, lon);
              map.setCenter(centerBaru);
              map.setZoom(16);  
              var marker = new google.maps.Marker({
                position: centerBaru,              
                icon:'assets/img/tours.png',
                animation: google.maps.Animation.DROP,
                map: map
                });
              markersDua.push(marker);
              map.setCenter(centerBaru);

              $('#hasilcariobj').append("<tr><td>"+nama_tempat_wisata+"</td><td><a role='button' class='btn btn-success' onclick='set_center(\""+lat+"\",\""+lon+"\",\""+nama_tempat_wisata+"\")'>Lihat</a></td></tr>");
            }//end for
          }});//end ajax  

        }



      function h_sekitar(latitude,longitude,rad){ // TEMPAT WISATA SEKITAR 

          $('#hasilcarihotel').empty();
          $('#hasilcarihotel1').show();
          cekRadius();
          $('#hasilcarihotel').append("<thead><th class='centered'>Nama Hotel</th><th class='centered'>Aksi</th></thead>");
          $.ajax({url: server+'_sekitar_hotel.php?lat='+latitude+'&long='+longitude+'&rad='+rad, data: "", dataType: 'json', success: function(rows){ 
            for (var i in rows){ 
              var row = rows[i];
              var id_hotel = row.id_hotel;
              var nama_hotel = row.nama_hotel;
              var alamat = row.alamat;
              var cp = row.cp;
              var fasilitas = row.fasilitas;
              var tipe_kamar = row.tipe_kamar;
              var harga = row.harga;
              var syarat_menginap = row.syarat_menginap;
              var keterangan = row.keterangan;
              var lat=row.latitude;
              var lon = row.longitude;
              
              //POSISI MAP
              centerBaru = new google.maps.LatLng(lat, lon);
              map.setCenter(centerBaru);
              map.setZoom(16);  
              var marker = new google.maps.Marker({
                position: centerBaru,              
                icon:'assets/img/hotels.png',
                animation: google.maps.Animation.DROP,
                map: map
                });
              markersDua.push(marker);
              map.setCenter(centerBaru);

              $('#hasilcarihotel').append("<tr><td>"+nama_hotel+"</td><td><a role='button' class='btn btn-success' onclick='set_center(\""+lat+"\",\""+lon+"\",\""+nama_hotel+"\")'>Lihat</a></td></tr>");
            }//end for
          }});//end ajax  
        }



//Fungsi Aktifkan Radius
function aktifkanRadius()
{
   var koordinat = new google.maps.LatLng(rad_lat, rad_lng);
          map.setCenter(koordinat);
          map.setZoom(16);  

          hapus_kecuali_landmark();
          hapusRadius();
          var inputradius=document.getElementById("inputradius").value;
          console.log(inputradius);
          var rad = parseFloat(inputradius*50);
          var circle = new google.maps.Circle({
            center: koordinat,
            radius: rad,      
            map: map,
            strokeColor: "blue",
            strokeOpacity: 0.5,
            strokeWeight: 1,
            fillColor: "blue",
            fillOpacity: 0.35
          });        
          circles.push(circle);     
          //TAMPILAN
          $("#hasilindustry").hide();
          $("#hasilculi").hide();
          $("#hasilmosque").hide();
          $("#hasilsouv").hide();
          $("#hasilobj").hide();
          $("#hasilhotel").hide();

          if (document.getElementById("check_i").checked) {
            industri_sekitar(rad_lat,rad_lng,rad);
            $("#hasilindustry").show();
          }        

          if (document.getElementById("check_k").checked) {
            kuliner_sekitar(rad_lat,rad_lng,rad);
            $("#hasilculi").show();
          }      

          if (document.getElementById("check_m").checked) {
            masjid_sekitar(rad_lat,rad_lng,rad);
            $("#hasilmosque").show();
          }        

          if (document.getElementById("check_oo").checked) {
            oleholeh_sekitar(rad_lat,rad_lng,rad);
            $("#hasilsouv").show();
          }        

          if (document.getElementById("check_tw").checked) {
            tw_sekitar(rad_lat,rad_lng,rad);
            $("#hasilobj").show();
          }        

          if (document.getElementById("check_h").checked) {
            h_sekitar(rad_lat,rad_lng,rad);
            $("#hasilhotel").show();
          }        
          
        }

 function set_center(lat,lon,nama){

        //Hapus Info Sebelumnya
        hapusInfo();
        
        //POSISI MAP
        var centerBaru      = new google.maps.LatLng(lat, lon);
        map.setCenter(centerBaru);

        //JENDELA INFO
        var infowindow = new google.maps.InfoWindow({
              position: centerBaru,
              content: "<bold>"+nama+"</bold>",
            });
        infoDua.push(infowindow); 
        infowindow.open(map);  

      }

//Menampilkan Data Radius yg dicari pada Hasil Pencarian
// function tampilradius()
// {
//   hapusInfo();
//   hapusMarkerTerdekat();
//   a();
//   cekRadius();
//   $('#hasilcari').append("<thead><th>Name of Industry</th><th colspan='3'>Action</th></thead>");
//   $.ajax
//   ({ 
//     url: server+'ikradius.php?lat='+koordinat.lat+'&lng='+koordinat.lng+'&rad='+rad, data: "", dataType: 'json', success: function(rows)
//     { 
//       for (var i in rows) 
//       {   
//         var row     = rows[i];
//         var id  = row.id;
//         var nama_industri   = row.nama_industri;
//         var latitude  = row.latitude; ;
//         var longitude = row.longitude ;
//         centerBaru      = new google.maps.LatLng(latitude, longitude);
//         centerBaru = new google.maps.LatLng(latitude, longitude);
//         marker = new google.maps.Marker
//         ({
//           position: centerBaru,
//           map: map,
//           icon: "assets/img/path.png",
//         });
//         markersDua.push(marker);
//         map.setCenter(centerBaru);
//         map.setZoom(14);
//         $('#hasilcari').append("<tr><td>"+nama_industri+"</td><td><a role='button' class='btn btn-success' onclick='detailinfoik(\""+id+"\")'>Show</a></td><td><a role='button' class='btn btn-danger fa fa-taxi' onclick='industriAngkot(\""+id+"\")'></a></td><td><a role='button' class='btn btn-danger fa fa-road' onclick='callRoute(centerLokasi,centerBaru);rutetampil();'></a></td></tr>");     
//        }
//     }
//   });   
// }


//Cek Radius
function cekRadius()
{
  rad = inputradius.value*50;
  console.log(rad);
}


//Fungsi Hapus Radius
function hapusRadius()
{
  for(var i=0;i<circles.length;i++)
  {
    circles[i].setMap(null);
  }
  circles=[];
  cekRadiusStatus = 'off';
}







        
</script>
</head>

  <body onload="init()"> 
 
  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
            <div class="sidebar-toggle-box">
              <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
           <a class="logo"><p><b>WEB</b><b style="font-size: 17px">GIS</b> - <b>C</b>ulinary, <b>S</b>mall <b>I</b>ndustry, <b>S</b>ouvenir </p></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
              <ul class="nav top-menu">
                    <!-- settings start -->
                   
                    <!-- inbox dropdown end -->
              </ul>
                <!--  notification end -->
            </div>
            <h4>
            <div class="top-menu">
              <ul class="nav pull-right" style="margin-top: 6px">
                   <a href="admin/" class="logo1" title="Login" ><img src="image/login.png">
                   <!-- <i class="fa fa-user"></i> -->
                   <span>Login</span></a>
              </ul>
            </div></h4>
      </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>

          <div id="sidebar"  class="nav-collapse " >
              <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
              
              <p class="centered"><a href="#"><img src="assets/img/jam.jpg" class="img-circle" width="150" height="120"></a></p>
              <h5 class="centered">Hi, Visitor!!</h5>

              <!-- <li class="mt">
                      <a class="active" href="gallery.html">
                          <i class="fa fa-dashboard"></i>
                          <span>Dashboard</span>
                      </a>
                  </li> -->
<br>
<h6 class="centered" style="color: #f7d976;"">Industri Kecil</h6>
        <li class="sub-menu">
               <a href="javascript:;" >
                  <i class="fa fa-chevron-circle-right"></i>
                  <span>Industri</span>
                </a>
            <ul class="sub">
              <li class="sub-menu">
                <a href="javascript:;" >
                  <i class="fa fa-search"></i>
                  <span>Searching</span>
                </a>
                <ul class="sub">
                  <div class=" form-group">
                    <li>
                      <div class="search">
                        <div class="col-md-15 padding-0 text-center">
                         <div class="form-group form-animate-text"><br>
                          <input type="text"  class="form-text" placeholder="...." id="ik_nama" required>
                            <span class="bar"></span> 
                        </div>         
                       <button type="submit" class="btn btn-info btn-block btn-flat" id="kecamatan" onclick='find_ik();'>Show</button>
                     </div> 
                     </div> <!-- tampiliknama(); -->
                    </li>
                  </div>         
                </ul>
              </li>
              <!-- </ul> -->

           <!--  <ul class="sub"> -->
                <li class="sub-menu">
                  <a href="javascript:;" >
                    <i class="fa fa-eye"></i>
                    <span>View Industries</span>
                  </a>
                  <ul class="sub">
                    <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-search"></i>
                        <span>Sub District</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group"> <br>
                          <label style="color: white;">Sub District</label>
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="kecamatan1">
                            <option value="">-Choose-</option>
                            <?php
                              include("connect.php"); 
                              $kecamatan=pg_query("select * from kecamatan order by nama_kecamatan ASC");
                              while($rowkecamatan = pg_fetch_assoc($kecamatan))
                              {
                                echo"<option value=".$rowkecamatan['id_kecamatan'].">".$rowkecamatan['nama_kecamatan']."</option>";
                              }
                            ?>
                          </select>
                                <!-- </label> -->              
                        </div>
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="viewkecamatan" onclick="viewkecamatan()">Search</button>
                        </div>
                      </ul>
                    </li>

                    <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-search"></i>
                        <span>Based On Type</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group"> <br>
                          <label style="color: white;">Type Of Industry</label>
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="jenisindustri">
                            <option value="">-Choose-</option>
                            <?php
                              include("connect.php"); 
                              $jenisindustri=pg_query("select * from jenis_industri order by nama_jenis_industri ASC");
                              while($rowjenisindustri = pg_fetch_assoc($jenisindustri))
                              {
                                echo"<option value=".$rowjenisindustri['id_jenis_industri'].">".$rowjenisindustri['nama_jenis_industri']."</option>";
                              }
                            ?>
                          </select>
                                <!-- </label> -->              
                        </div>
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="ik_jenis_industri" onclick='carijenisik();'>Search</button>
                        </div>
                      </ul>
                    </li>
                    
                    <li class="sub-menu">
                      <a href="javascript:;" onclick="pilihwilayah()">
                       <i class="fa fa-search"></i>
                       <span>Filter</span>
                       </a>
                    </li>

                    <!-- <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-search"></i>
                        <span>Radius</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group" style="color: white;"> <br>
                          <label>Based On Radius</label><br>
                          <label for="inputradius">Radius : </label>
                          <label  id="nilai">0</label> km
                          <script>
                            function cek()
                            {
                              document.getElementById('nilai').innerHTML=document.getElementById('inputradius').value
                            }
                          </script>
                          <input  type="range" onchange="cek();aktifkanRadius()" id="inputradius" 
                                  name="inputradius" data-highlight="true" min="0" max="20" value="0" >
                        </div>
                                    
                      </ul>
                    </li> -->
                    
                  </ul>
                </li>
                </ul>
            </li>
               


                
<h6 class="centered" style="color: #f7d976;"">Souvenirs</h6>
    <li class="sub-menu">
      <a href="javascript:;" >
                  <i class="fa fa-chevron-circle-right"></i>
                  <span>Souvenirs</span>
      </a>
      <ul class="sub">
              <li class="sub-menu">
                <a href="javascript:;" >
                  <i class="fa fa-search"></i>
                  <span>Searching</span>
                </a>
                <ul class="sub">
                  <div class=" form-group">
                    <li>
                      <div class="search">
                        <div class="col-md-15 padding-0 text-center">
                         <div class="form-group form-animate-text"><br>
                          <input type="text"  class="form-text" placeholder="...." id="sou_nama" required>
                            <span class="bar"></span> 
                        </div>         
                       <button type="submit" class="btn btn-info btn-block btn-flat" id="sou_button" onclick='find_sou();'>Show</button>
                     </div> 
                     </div> <!-- tampiliknama(); -->
                    </li>
                  </div>         
                </ul>
              </li>

                <li class="sub-menu">
                  <a href="javascript:;" >
                    <i class="fa fa-eye"></i>
                    <span>View Souvenirs</span>
                  </a>
                  <ul class="sub">
                    <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-search"></i>
                        <span>Sub District</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group"> <br>
                          <label style="color: white;">Sub District</label>
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="carikecamatansou">
                            <option value="">-Choose-</option>
                            <?php
                              include("connect.php"); 
                              $carikecamatansou=pg_query("select * from kecamatan order by nama_kecamatan ASC");
                              while($rowcarikecamatansou = pg_fetch_assoc($carikecamatansou))
                              {
                                echo"<option value=".$rowcarikecamatansou['id_kecamatan'].">".$rowcarikecamatansou['nama_kecamatan']."</option>";
                              }
                            ?>
                          </select>
                                <!-- </label> -->              
                        </div>
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="sou_kec" onclick='viewkecamatansou();'>Search</button>
                        </div>
                      </ul>
                    </li>

                    <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-search"></i>
                        <span>Based On Type</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group"> <br>
                          <label style="color: white;">Type Of Souvenirs</label>
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="jenissou">
                            <option value="">-Choose-</option>
                            <?php
                              include("connect.php"); 
                              $jenissou=pg_query("select * from jenis_oleh_oleh order by jenis_oleh ASC");
                              while($rowjenissou = pg_fetch_assoc($jenissou))
                              {
                                echo"<option value=".$rowjenissou['id_jenis_oleh'].">".$rowjenissou['jenis_oleh']."</option>";
                              }
                            ?>
                          </select>
                                <!-- </label> -->              
                        </div>
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="ik_jenis_sou" onclick='carijenissou();'>Search</button>
                        </div>
                      </ul>
                    </li>
                    
                    <li class="sub-menu">
                      <a href="javascript:;" onclick="pilihwilayahsou()">
                       <i class="fa fa-search"></i>
                       <span>Filter</span>
                       </a>
                    </li>

                    <!-- <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-search"></i>
                        <span>Radius</span>
                      </a>
                      <ul class="sub">                   
                      </ul>
                    </li> -->
                    
                  </ul>
                </li>
                </ul>
</li>

                
<h6 class="centered" style="color: #f7d976;"">Culinary</h6>
      
<li class="sub-menu">
  <a href="javascript:;" >
   <i class="fa fa-chevron-circle-right"></i>
     <span>Culinary</span>
  </a>
       <ul class="sub">

                <li class="sub-menu">
                  <a href="javascript:;" >
                    <i class="fa fa-eye"></i>
                    <span>View Culinary</span>
                  </a>
                  <ul class="sub">
                    <li class="sub-menu">
                      <a href="javascript:;" >
                        <i class="fa fa-search"></i>
                        <span>Sub District</span>
                      </a>
                      <ul class="sub">
                        <div class=" form-group"> <br>
                          <label style="color: white;">Sub District</label>
                          <select class="form-control select2" style="width: 100%; height: 70%;" id="carikecamatankul">
                            <option value="">-Choose-</option>
                            <?php
                              include("connect.php"); 
                              $carikecamatankul=pg_query("select * from kecamatan order by nama_kecamatan ASC");
                              while($rowcarikecamatankul = pg_fetch_assoc($carikecamatankul))
                              {
                                echo"<option value=".$rowcarikecamatankul['id_kecamatan'].">".$rowcarikecamatankul['nama_kecamatan']."</option>";
                              }
                            ?>
                          </select>
                                              
                        </div>
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="kul_kec" onclick='viewkecamatankul();'>Search</button>
                        </div>
                      </ul>
                    </li>


                    <li class="sub-menu">
                      <a href="javascript:;" onclick="selectkul()">
                       <i class="fa fa-search"></i>
                       <span>Select Culinary</span>
                       </a>
                    </li>
                    
                    </li>
                    
                  </ul>
                </li>

            </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start--> <!-- <br> -->
      <!-- <div class="col-lg-10 ds"> -->
      <section id="main-content">
        <section class="wrapper">
          <div class="col-lg-8 ds">
            <h3>The Tourism Map of Bukittinggi City</h3>
                <!-- First Action -->
              <div class="panel box-v3">
                <div class="panel-body">
                  <div class="col-md-12 padding-0 text-center">
                    <div class="row">
                      <button type="button" onclick="posisisekarang()" class="btn btn-primary btn-sm " data-toggle="tooltip" id="posisinow" title="Posisi Saya" 
                              style="margin: 15px" style="margin-right: 7px;"><i class="fa fa-map-marker" style="color:white;"> Current Position</i>
                      </button>
                      <button type="button" onclick="lokasimanual()" class="btn btn-primary btn-sm "  data-toggle="tooltip" id="posmanual" title="Posisi Manual" 
                              style="margin-right: 7px;"><i class="fa fa-map-marker" style="color:white;"> Manual Position</i>
                      </button>
                      <br>
                      <button type="button" onclick="viewik()" class="btn btn-primary btn-sm " data-toggle="tooltip" title="Melihat Semua Industri" 
                              style="margin: 7px" style="margin-right: 7px;"><i class="fa fa-eye">View All Industries</i>
                      </button>
                      <button type="button" onclick="viewsou()" class="btn btn-primary btn-sm " data-toggle="tooltip" title="Melihat Semua Oleh-Oleh" 
                              style="margin: 7px" style="margin-right: 7px;"><i class="fa fa-eye">View All Souvenirs</i>
                      </button>
                      <button type="button" onclick="viewkul()" class="btn btn-primary btn-sm " data-toggle="tooltip" title="Melihat Semua Kuliner" 
                              style="margin: 7px" style="margin-right: 7px;"><i class="fa fa-eye">View All Culinary</i>
                      </button>
                     
                      <div class="panel-body text-center" style="height:400px";>
                        <div id="map" style="width: 100%; height: 100%;"></div>
                      </div>
              
                      <!--custom chart end-->

                        <div class="col-lg-4 ds"  id="tampilangkotsekitarik" style="display:none;" >
                          
                          <h3 style="font-size:16px">Angkot Information</h3>
                              
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="tampillistangkotik1" style="display:none;">
                                  <table class="table table-bordered" id='tampillistangkotik'></table>
                                </div>
                              </div>         
                        </div> 
                        <div class="col-lg-4 ds"  id="hasilmosque" style="display:none;">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <h3 style="font-size:16px">Mosque Information</h3>
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcarimosque1" style="display:none;">
                                  <table class="table table-bordered" id='hasilcarimosque'></table>
                                </div>
                              </div>         
                        </div> 


                        <div class="col-lg-4 ds"  id="hasilhotel" style="display:none;">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <h3 style="font-size:16px">Hotel Information</h3>
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcarihotel1" style="display:none;">
                                  <table class="table table-bordered" id='hasilcarihotel'></table>
                                </div>
                              </div>         
                        </div> 

                        <div class="col-lg-4 ds"  id="hasilobj" style="display:none;">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <h3 style="font-size:16px">Tourism Information</h3>
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcariobj1" style="display:none;">
                                  <table class="table table-bordered" id='hasilcariobj'></table>
                                </div>
                              </div>         
                        </div> 

                        <div class="col-lg-4 ds"  id="hasilindustry" style="display:none;">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <h3 style="font-size:16px">Industry Information</h3>
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcariind1" style="display:none;">
                                  <table class="table table-bordered" id='hasilcariind'></table>
                                </div>
                              </div>         
                        </div> 

                        <div class="col-lg-4 ds"  id="hasilsouv" style="display:none;">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <h3 style="font-size:16px">Souvenir Information</h3>
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcarisouv1" style="display:none;">
                                  <table class="table table-bordered" id='hasilcarisouv'></table>
                                </div>
                              </div>         
                        </div> 

                        <div class="col-lg-4 ds"  id="hasilculi" style="display:none;">
                          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
                          <h3 style="font-size:16px">Culinary Information</h3>
                              <!-- First Action -->
                              <div class="box-body" style="max-height:450px;overflow:auto;">
                                <div class="form-group" id="hasilcariculi1" style="display:none;">
                                  <table class="table table-bordered" id='hasilcariculi'></table>
                                </div>
                              </div>         
                        </div> 


                    </div>
                  </div>
                </div>
              </div>
          </div>
				
					

      <!-- </div>/col-lg-9 END SECTION MIDDLE -->
                  
                  
                  
      <!-- **********************************************************************************************************************************************************
      RIGHT SIDEBAR CONTENT
      *********************************************************************************************************************************************************** -->                  
    
        <div class="col-lg-4 ds"  id="hasilik" >
          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
          <h3 style="font-size:16px">Information</h3>
              <!-- First Action -->
              <div class="box-body" style="max-height:557px;overflow:auto;">
                <div class="form-group" id="hasilcari1" style="display:none;">
                  <table class="table table-bordered" id='hasilcari'></table>
                </div>
              </div>         
        </div> 


      <div id="nearbyik" class="col-md-4 col-sm-4 mb" style="display:none">
                        <div class="white-panel pns" style="padding-bottom:5px">
                           <div class="white-header" style="height:40px;margin-bottom:0px;background:white;color:black">
                             <h4><u><b>Nearby</b></u></h4>
                           </div>
                           <div class="row">
                             <div class="col-sm-6 col-xs-6"></div>
                           </div>
                           <div style="text-align:left;margin:10px; color:black;">
                              <!--img src="assets/img/product.png" width="120"-->
                              <div class="checkbox">
                                <label>
                                  <input id="check_tw" type="checkbox">
                                  Tempat Wisata
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input id="check_i" type="checkbox" >
                                  Industri
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input id="check_m" type="checkbox" value="">
                                  Masjid
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input id="check_oo" type="checkbox" value="">
                                  Oleh - oleh
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input id="check_k" type="checkbox" value="">
                                  Kuliner
                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                  <input id="check_h" type="checkbox" value="">
                                  Hotel
                                </label>
                              </div>

                              <!--RADIUS-->
                              <input type="range" onchange="aktifkanRadius()" id="inputradius" name="inputradius" data-highlight="true" min="1" max="15" value="1">

                              <!--BUTTON CARI SEKITAR-->
                              <div id="view_sekitar" class="centered">
                              </div>


                           </div>
                        </div>
                      </div><!-- /col-md-12 -->    
        


        <div class="col-lg-4 ds"  id="hasilrute" style="display:none;">
          <!-- <div class="col-md-12 padding-0" style="display:none;"> -->
          <h3 style="font-size:16px">Rute</h3>
              <!-- First Action -->
              <div class="box-body" style="max-height:557px;overflow:auto;">
                <div class="form-group" id="detailrute1" >

                  <table class="table table-bordered" id='detailrute'></table>
                </div>
              </div>         
        </div> 

        <div class="col-lg-4 ds"  id="selectkulll" style="display:none;">
          <h3 style="font-size:16px">Select Culinary</h3>
        <div class="panel box-v3">
                  <ul class="sub">
                        <div id="forml">
                        <input type="text" class="form-control hidden" id="id_tempat_kuliner" name="id_tempat_kuliner" value="<?php echo $id_tempat_kuliner ?>">
                          <div class="form-group row col-xs-9" >
                            <?php
                              $sql2 = pg_query("select * from kuliner order by nama_kuliner");
                              while($dt = pg_fetch_array($sql2)){
                                  echo "<div class='checkbox'><label style='color:black'><input name='kuliner' value=\"$dt[id_kuliner]\" type='checkbox' style='width:25px'>$dt[nama_kuliner]</label></div>";
                                }
                              
                            ?>
            
                      </div>
                      </div>
                        <div class=" form-group">
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="kul_kec" onclick='viewkull();'>Search</button>
                        </div>
                      </ul>
                </div> 
                </div>
     


        
        <div class="col-lg-4 ds"  id="filterik" style="display:none;">
          <h3 style="font-size:16px">Industrial Filters</h3>
        <div class="panel box-v3">
                  <div class="panel-body">
                    <div class="col-md-12 padding-0 text-center">
                        <div class="form-group"> 
                          <label id="labelkecamatan">Sub District</label>
                          <select class="form-control kota" style="width: 100%;" id="filterkecamatan"> 
                          <option value="">-Choose-</option>
                                              <?php
                                              include("connect.php"); 
                                              $kecamatan=pg_query("select * from kecamatan order by nama_kecamatan ASC");
                                              while($rowkecamatan = pg_fetch_assoc($kecamatan))
                                              {
                                              echo"<option value=".$rowkecamatan['id_kecamatan'].">".$rowkecamatan['nama_kecamatan']."</option>";
                                              }
                                              ?>
                          </select><br><br>
                          <label id='labeljenisindustri'>Type Of Industry</label>
                          <select class="form-control" style="width: 100%;" id="filterjenisindustri" > 
                          <option value="">-Choose-</option>
                          
                                              <?php
                                              include("connect.php"); 
                                              $jenis_industri=pg_query("select * from jenis_industri order by nama_jenis_industri ASC");
                                              while($rowjenis_industri = pg_fetch_assoc($jenis_industri))
                                              {
                                              echo"<option value=".$rowjenis_industri['id_jenis_industri'].">".$rowjenis_industri['nama_jenis_industri']."</option>";
                                              }
                                              ?>  
                          </select><br><br>
                          <label id="labelstatustempat">Place Status</label>
                          <select class="form-control" style="width: 100%;" id="filterstatustempat">
                              <option value="">-Choose-</option>
                                              <?php
                                              include("connect.php"); 
                                              $status_tempat=pg_query("select * from status_tempat order by status ASC");
                                              while($rowstatus_tempat = pg_fetch_assoc($status_tempat))
                                              {
                                              echo"<option value=".$rowstatus_tempat['id_status_tempat'].">".$rowstatus_tempat['status']."</option>";
                                              }
                                              ?>
                              <br><br>
                          </select>
                          <br><br>
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="btnfilter" onclick='tampilikwilayah();'>Search</button>
                        </div>
                    </div>
                  </div>
                </div> 
                </div>



                <div class="col-lg-4 ds"  id="filtersou" style="display:none;">
          <h3 style="font-size:16px">Souvenirs Filters</h3>
        <div class="panel box-v3">
                  <div class="panel-body">
                    <div class="col-md-12 padding-0 text-center">
                        <div class="form-group"> 
                          <label id="labelkecamatan">Sub District</label>
                          <select class="form-control kota" style="width: 100%;" id="filterkecamatansou"> 
                          <option value="">-Choose-</option>
                                              <?php
                                              include("connect.php"); 
                                              $kecamatan=pg_query("select * from kecamatan order by nama_kecamatan ASC");
                                              while($rowkecamatan = pg_fetch_assoc($kecamatan))
                                              {
                                              echo"<option value=".$rowkecamatan['id_kecamatan'].">".$rowkecamatan['nama_kecamatan']."</option>";
                                              }
                                              ?>
                          </select><br><br>
                          <label id='labeljenisindustri'>Type Of Souvenirs</label>
                          <select class="form-control" style="width: 100%;" id="filterjenissouvenir" > 
                          <option value="">-Choose-</option>
                          
                                              <?php
                                              include("connect.php"); 
                                              $jenis_oleh_oleh=pg_query("select * from jenis_oleh_oleh order by jenis_oleh ASC");
                                              while($rowjenis_oleh_oleh = pg_fetch_assoc($jenis_oleh_oleh))
                                              {
                                              echo"<option value=".$rowjenis_oleh_oleh['id_jenis_oleh'].">".$rowjenis_oleh_oleh['jenis_oleh']."</option>";
                                              }
                                              ?>  
                          </select><br><br>
                          <label id="labelstatustempat">Place Status</label>
                          <select class="form-control" style="width: 100%;" id="filterstatustempatsou">
                              <option value="">-Choose-</option>
                                              <?php
                                              include("connect.php"); 
                                              $status_tempat=pg_query("select * from status_tempat order by status ASC");
                                              while($rowstatus_tempat = pg_fetch_assoc($status_tempat))
                                              {
                                              echo"<option value=".$rowstatus_tempat['id_status_tempat'].">".$rowstatus_tempat['status']."</option>";
                                              }
                                              ?>
                              <br><br>
                          </select>
                          <br><br>
                          <button type="submit" class="btn btn-info btn-block btn-flat" id="btnfilter" onclick='tampilsouwilayah();'>Search</button>
                        </div>
                    </div>
                  </div>
                </div> 
                </div>
      </section>
    </section>
  
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>    
  	<script src="assets/js/zabuto_calendar.js"></script>	
	
	   <script type="application/javascript">
        $(document).ready(function () 
        {
          $("#date-popover").popover({html: true, trigger: "manual"});
          $("#date-popover").hide();
          $("#date-popover").click(function (e) 
          {
           $(this).hide();
          });
        
          $("#my-calendar").zabuto_calendar
          ({
            action: function () 
            {
              return myDateFunction(this.id, false);
            },
            action_nav: function () 
            {
              return myNavFunction(this.id);
            },
            ajax: 
            {
              url: "show_data.php?action=1",
              modal: true
            },
            legend: 
            [
                    {type: "text", label: "Special event", badge: "00"},
                    {type: "block", label: "Regular event", }
            ]
          });
        });
        
        
        function myNavFunction(id) 
        {
          $("#date-popover").hide();
          var nav = $("#" + id).data("navigation");
          var to = $("#" + id).data("to");
          console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
    </script>
  </body>
</html>
