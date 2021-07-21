// Geolocation
var x = document.getElementById("luogo");

function getLocation() {
if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(getPosition);
    } else { 
        x.innerHTML = "n/a";
    }
}

function getPosition(position) {
    var xmlhttp = new XMLHttpRequest();
    var url = "https://nominatim.openstreetmap.org/reverse?lat="+position.coords.latitude+"&lon="+position.coords.longitude+"&format=json&accept-language=it&zoom=10";
    console.log(url);
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myArr = JSON.parse(this.responseText);
            myFunction(myArr);
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
} 

function myFunction(arr) {
    if (arr["address"]["village"] && arr["address"]["state"] && arr["address"]["country"]) {
        x.value =  arr["address"]["village"] + ", "+arr["address"]["state"]+", "+arr["address"]["country"];
    } else if (arr["address"]["town"] && arr["address"]["state"] && arr["address"]["country"]) {
        x.value =  arr["address"]["town"] + ", "+arr["address"]["state"]+", "+arr["address"]["country"];
    } else if (arr["address"]["city"] && arr["address"]["state"] && arr["address"]["country"]) {
        x.value =  arr["address"]["city"] + ", "+arr["address"]["state"]+", "+arr["address"]["country"];
    } else if (arr["address"]["state"] && arr["address"]["country"]){
        x.value =  arr["address"]["state"]+", "+arr["address"]["country"];
    } else if (arr["address"]["country"]) {
        x.value =  arr["address"]["country"];
    }
    
    // Detect nation and change currency
    var xmlhttp = new XMLHttpRequest();
    var url = "js/countrytocurrency.php?country="+arr["address"]["country_code"];
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var ans = this.responseText;
            if (ans != "NULL") {
                document.getElementById("valuta").value = this.responseText;
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

getLocation();