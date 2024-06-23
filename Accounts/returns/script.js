function confirmReturn() {
    //get item id
    let itemId = document.getElementById("item").value;
    // get the cuase
    let cause = document.getElementById("cause").value;
    //prepare result span
    let result = document.getElementById("result");

    //initiate request
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
        if (this.responseText == "success"){
            window.location.href = "index.php";
        }else {
            result.innerHTML = this.responseText;
        }
    }
    xhr.open('POST', 'confirm.php');
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("itemId=" + itemId + "&cause=" + cause);
}