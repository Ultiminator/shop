function editItem(){
    //get the data from the fields
    let itemId =document.getElementById("id").value;
    let itemName = document.getElementById('name').value;
    let describtion = document.getElementById('description').value;
    let price = document.getElementById('price').value;
    let discount = document.getElementById('discount').value;
    let amount = document.getElementById('stock').value;
    let brand = document.getElementById('brand').value;
    let category = document.getElementById('cat').value;
    //prepare the result span
    let resultSpan = document.getElementById('result');
    //validate the data
    let invalidResult = invalidData(itemName, describtion, price,
                                    discount, amount, brand, category);
    if(invalidResult){
        resultSpan.innerHTML = invalidResult;
        return;
    }
    //apend data to the a form to be sent
    let formData = new FormData();
    formData.append('id', itemId)
    formData.append('name', itemName);
    formData.append('describtion', describtion);
    formData.append('price', price);
    formData.append('discount', discount);
    formData.append('amount', amount);
    formData.append('brand', brand);
    formData.append('cat', category);
    //initiate the request
    const xhrequest = new XMLHttpRequest();
    xhrequest.onload = function(){
        //show the result
        resultSpan.innerHTML = this.responseText;
    }
    xhrequest.open('POST', 'editItem.php');
    xhrequest.send(formData);
}

//function to validate the data before it is sent to the server
function invalidData(name, descr, price, disc, amnt, brand, cat){
    if (name == "" || descr == "" || brand == "" || cat == "") {
        return "fill in empty feilds";
    }
    if (price <= 0){
        return "price can't be zero or negative";
    }
    if (disc >= 100){
        return "come on.. discount can't be 100% or more";
    }
    if (amnt < 0){
        return "amount can't be negative";
    }
}