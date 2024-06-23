function cancelOrder(id) {
    //prepare span result
    let resultSpan = document.getElementById(id);

    //confirm
    if(!confirm("are you sure to cancel this order?")) {
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
    xhr.send("orderId=" + id);
}