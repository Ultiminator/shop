function removeItem(itemId){
    //get item name
    let itemName = "";
    let resultSpan = document.getElementById("result");
    if (itemId != 0){
        itemName = document.getElementById(itemId).innerHTML;
    }else {
        itemName = "all items";
    }
    //confirm
    if (!confirm("are you sure to delete " + itemName + " from chart?")){
        return;
    }

    let xhr = new XMLHttpRequest();
    //show the result when available
    xhr.onload = function(){
        if (this.responseText == "success"){
            window.location.reload(true);
        }else {
            resultSpan.innerHTML = this.responseText;
        }
    }
    xhr.open('POST', 'remove.php');
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("itemId=" + itemId);
}
function checkout(){
    location.href = "../../checkout";
}