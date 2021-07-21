<?php
require ("x_session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>FM20</title>
  <meta name="author" content="Lucas Falardi">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" href="images/icon.png">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-title" content="GE19">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">
  <link rel="stylesheet" href="css/index.css">
  <style>
      #overlay {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.5);
        z-index: 2;
        cursor: pointer;
        }
        #text{
        position: absolute;
        top: 50%;
        left: 50%;
        color: white;
        transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
        }
 </style>
  
  <!-- Javascript
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script-->
  <!--script src="js/index.php"></script-->
                                   
  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div style="margin-top: 10%">
        <h2>Flat Management 2020</h2>
        <p>Login come: <?echo $x_nu;?></p></div>
    </div>
     <!--div id="chart_div"></div-->
    <div class="row">

    <a class="button" href="#" onclick="on()"> 
        <img src="images/qrcode-solid.svg" width="15" height="15" style="vertical-align: sub;"/> 
        QR-SCAN
    </a>
    
    <div id="overlay" onclick="off()">
        <div id="reader"></div>
    </div>

    <button onclick="getLocation()">Try It</button>
    <p id="demo"></p>


    <div class="row" style="margin-top: 1em;">
        <h6>developed by Lucas Falardi -.- 2019</h6>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
<script src="https://unpkg.com/html5-qrcode@2.0.11/dist/html5-qrcode.min.js"></script>

<script>
    // This method will trigger user permissions
    const html5QrCode = new Html5Qrcode("reader");
    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        /* handle success */
        html5QrCode.stop().then((ignore) => {
            // QR Code scanning is stopped.
            off();
            alert(decodedText);
        }).catch((err) => {
            // Stop failed, handle it.
        });

    };
    const config = { fps: 10, qrbox: 250 };

    // If you want to prefer back camera
    function startscan(){
        html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);
    }
    //html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);

    function on() {
    document.getElementById("overlay").style.display = "block";
    startscan();
    }

    function off() {
    document.getElementById("overlay").style.display = "none";
    html5QrCode.stop();
    }


    // Geolocation
    var x = document.getElementById("demo");

    function getLocation() {
    if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(getPosition);
        } else { 
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        x.innerHTML = "Latitude: " + position.coords.latitude + 
        "<br>Longitude: " + position.coords.longitude;
    }

    function getPosition(position) {
        var xmlhttp = new XMLHttpRequest();
        var url = "https://nominatim.openstreetmap.org/reverse?lat="+position.coords.latitude+"&lon="+position.coords.longitude+"&format=json&accept-language=it&zoom=10";
        alert(url);

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                var myArr = JSON.parse(this.responseText);
                myFunction(myArr);
            }
        };
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    } 

    function myFunction(arr) {
        x.innerHTML =  arr["address"]["village"] + ", "+arr["address"]["state"]+", "+arr["address"]["country"];
    }
</script>