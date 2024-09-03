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

// function to loa items ha ha ha
function loadItems(){
    //first lets get our filter data and appen them into a form data
    let formData = new FormData();
    //get the rating
    //this gets all elements with the name of rating (supposed to be radio boxex)
    let ratings = document.getElementsByName("rating");
    for (x of ratings) {
        if (x.checked) {
            formData.append ("rating", x.value);
            //break as there is only one radio box suppose to be checked
            break;
        }
    }
    //get the brands
    //this gets all elements with the name of brand (supposed to be check boxex)
    let brands = document.getElementsByName("brand");
    for (x of brands) {
        if (x.checked) {
            formData.append("brands[]", x.value);
        }
    }
    //get the categories
    //this gets all elements with the name of cat (supposed to be check boxex)
    let cats = document.getElementsByName("cat");
    for (x of cats) {
        if (x.checked) {
            formData.append("cats[]", x.value);
        }
    }
    // get the min and max prices
    formData.append("max", document.getElementById("max").value);
    formData.append("min", document.getElementById("min").value);
    //get sort option
    formData.append("sort", document.getElementById("sort").value);
    // get special view exclusives
    formData.append("offer", document.getElementById("offer").checked);
    formData.append("stock", document.getElementById("stock").checked);

    //initiate request
    let xhr = new XMLHttpRequest();
    xhr.onload = function() {
        let div = document.getElementById("itemsContianer");
        div.innerHTML = "";
        let items = [];
        try {
            items = JSON.parse(this.responseText);
        } catch (error) {
            div.innerHTML = "No Items Found";
        }
        for (item of items) {
            div.appendChild(createItem (item['id'], item['name'], item['img'], 
                                        item['price'], item['discount']));
        }
    }
    xhr.open("POST", "loadItems.php");
    //xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(formData);

    //this is for testing and should be deleted once the function is complete
    
    
}

//function to create an item card
function createItem(id, name, img, price, discount) {
    //the whole card will be a link
    const card = document.createElement("a");
    card.className = "itemCard";
    card.href = "./item.php?id=" + id;

    //lets create the image tag the will show an image of the item
    const imgTag = document.createElement("img");
    imgTag.className = "itemImage";
    imgTag.src = "./items/" + id + "/" + img;
    //lets append it to the link
    card.appendChild(imgTag);

    // lets create the name span
    const nameSpan = document.createElement("span");
    nameSpan.className = "itemName";
    const nameText = document.createTextNode(name);
    nameSpan.appendChild(nameText);
    card.appendChild(nameSpan);

    // lets create the price span
    const priceSpan = document.createElement("span");
    priceSpan.className = "itemPrice";
    const priceText = document.createTextNode(price);
    priceSpan.appendChild(priceText);
    card.appendChild(priceSpan);

    //crete a discount badg if there is dicount
    if (discount > 0) {
        const discountBdge = document.createElement("span");
        discountBdge.className = "discountBadge";
        const discountText = document.createTextNode("-" + discount + "%");
        discountBdge.appendChild(discountText);
        card.appendChild(discountBdge);
    }

    return card;
}

// this function to search using search bar in menu bar
function searchItems(location) {
    //prepar result 
    let result = document.getElementById("searchResult");
    //get input
    let input = document.getElementById("searchInput").value.trim();
    if (input.length == 0) {
        result.innerHTML = "";
        return;
    }
    //initiate request
    let xhr = new XMLHttpRequest();
    xhr.onload = function() {
        result.innerHTML = this.responseText;
    }
    xhr.open("POST", location + "search.php");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("input=" + input + "&location=" + location);
}