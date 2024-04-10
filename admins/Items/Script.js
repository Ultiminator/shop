function loadItems(){
    //get variables
    let name = document.getElementById("name").value;
    let cat = document.getElementById("cat").value;
    let brand = document.getElementById("brand").value;
    let minPrice = document.getElementById("minPrice").value;
    let maxPrice = document.getElementById("maxPrice").value;
    let discount = document.getElementById('discount').checked;
    let inStock = document.getElementById('stock').checked;
    let sort = document.getElementById("sort").value;

    //todo validate data

    //append data to a form
    let formData = new FormData();
    formData.append("name", name);
    formData.append("cat", cat);
    formData.append("brand", brand);
    formData.append("minPrice", minPrice);
    formData.append("maxPrice", maxPrice);
    formData.append("discount", discount)
    formData.append("inStock", inStock)
    formData.append("sort", sort)

    //initaite request
    let xhr = new XMLHttpRequest();
    xhr.onload = function(){
        document.getElementById("result").innerHTML = this.responseText;
    }
    xhr.open("POST", "loadItems.php");
    xhr.send(formData);
    
}

function removeItem(itemId, index){
    //prepare the result td
    let result = document.getElementById(index);
    //validate data
    let invalidid = invalidId(itemId);
    if (invalidid){
        result.innerHTML = invalidid;
        return;
    }

    //confirm
    if(!confirm("Are you sure you want to remove this item? item Id: " + itemId)){
        return;
    }

    //initiate request
    let xhr = new XMLHttpRequest();
    xhr.onload = function() {
        result.innerHTML = this.responseText;
        if (this.responseText == "success") {
            loadItems();
        }
    }
    xhr.open("POST", "removeItem.php");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("itemId=" + itemId);
}

//function to validate data
function invalidId(id){
    if (id =="") {
        return "hmm where is item Id?";
    }
    if(/^ +/.test(id)){
        return "id can't start with spaces";
    }
    //added space to the regex to allow spaces
    if (!/^[0-9.]*$/.test(id)) {
        return "this must be invalid id";
    }
}