//function to display the image of selected thumbnail into the main img
function displayImage(imagePath){
    let img = document.getElementById("imgDisplay");
    img.src = imagePath;
}

//function to add the item to the cart
function addToCart(itemId){
    let qnty = document.getElementById("amount").value;
    let resultSpan = document.getElementById("result");

    let xhr = new XMLHttpRequest();
    xhr.onload = function() {
        resultSpan.innerHTML = this.responseText;
        if(this.responseText == "success"){
            if(confirm("item added successfuly, do you want to go to the chart?")){
                window.location.href = "./Accounts/chart/";
            }
        }
    }
    xhr.open("POST", "./Accounts/chart/addItem.php");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("itemId=" + itemId + "&qnty=" + qnty);
}

//function to buy the item now
function buyNow(itemId){
    //todo
}