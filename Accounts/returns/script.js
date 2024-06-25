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
function cancelReturn(id) {
    //prepare span result
    let resultSpan = document.getElementById(id);

    //confirm
    if(!confirm("are you sure to cancel this return request?")) {
        return;
    }

    //initiate request
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
        if (this.responseText == "success"){
            window.location.reload(true);
        }else {
            resultSpan.innerHTML = this.responseText;
        }
    }
    xhr.open('POST', 'cancel.php');
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("returnId=" + id);
}