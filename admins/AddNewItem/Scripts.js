//function to be called when the form is submitted
function sendTheData(){
    //get the data from the fields
    let itemName = document.getElementById('itemName').value;
    let describtion = document.getElementById('describtion').value;
    let price = document.getElementById('price').value;
    let discount = document.getElementById('discount').value;
    let amount = document.getElementById('amount').value;
    let brand = document.getElementById('brand').value;
    let category = document.getElementById('category').value;
    // get the images
    let images = document.getElementById("files").files;
    //prepare the result span
    let resultSpan = document.getElementById('result');
    //validate the data
    let invalidResult = invalidData(itemName, describtion, price,
                                    discount, amount, brand, category, images);
    if(invalidResult){
        resultSpan.innerHTML = invalidResult;
        return;
    }
    //apend data to the a form to be sent
    let formData = new FormData();
    formData.append('name', itemName);
    formData.append('describtion', describtion);
    formData.append('price', price);
    formData.append('discount', discount);
    formData.append('amount', amount);
    formData.append('brand', brand);
    formData.append('category', category);
    //apend images
    for (let i = 0; i < images.length; i++) {
        formData.append('images[]', images[i]);
    }

    //initiate the request
    const xhrequest = new XMLHttpRequest();
    xhrequest.onload = function(){
        //show the result
        resultSpan.innerHTML = this.responseText;
    }
    xhrequest.open('POST', 'addItem.php');
    /*disabling the line below as it broke the request for some reason
      apparently, doesn't need it while sending the data in a form data*/
    //xhrequest.setRequestHeader('Content-type', 'multipart/form-data');
    xhrequest.send(formData);
}

//function to validate the data before it is sent to the server
function invalidData(name, descr, price, disc, amnt, brand, categ, images){
    if (name == "" || descr == "" || brand == "" || categ == "") {
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
    if (!images.length || images.length > 5){
        return "please select up to 5 images";
    }
    for (let i = 0; i < images.length; i++) {
        //check if the file is an image
        if (!images[i].type.startsWith('image/')){
            return "please select images only";
        }
        //check the image size
        if (images[i].size > 1048576){
            return "please select only images smaller than 1 MB";
        }
    }
}