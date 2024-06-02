function confirmOrder(){
    //get adress info
    let name = document.getElementById("name").value;
    let adress = document.getElementById("adress").value;
    let phone = document.getElementById("phone").value;
    //prepare result span 
    let resultSpan = document.getElementById("result");

    //todo validata data

    //initiate request
    let xhr = new XMLHttpRequest();
    xhr.onload = function() {
        if (this.responseText == "success"){
            window.location.href = "./congrats.php";
        }else {
            resultSpan.innerHTML = this.responseText;
        }
    }
    xhr.open("POST", "confirm.php");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("name=" + name + "&adress=" + adress + "&phone=" + phone);
}