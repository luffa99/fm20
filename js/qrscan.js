// This method will trigger user permissions
const html5QrCode = new Html5Qrcode("reader");
const qrCodeSuccessCallback = (decodedText, decodedResult) => {
    /* handle success */
    html5QrCode.stop().then((ignore) => {
        // QR Code scanning is stopped.
        document.getElementById("spesa_totale").value = parseInt(decodedText.slice(-6,-2))+"."+decodedText.slice(-2);
        document.getElementById("spesa_totale").oninput();
        document.getElementById("nome").value = "Migros";
        romana();

        off();
    }).catch((err) => {
        // Stop failed, handle it.
    });

};
const config = { fps: 10, qrbox: 250 };

// If you want to prefer back camera
function startscan(){
    html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);
}

function on() {
    document.getElementById("overlay").style.display = "block";
    startscan();
}

function off() {
    document.getElementById("overlay").style.display = "none";
    html5QrCode.stop();
}