function loadImages(itemId){
    //prepare the table that will display the result
    let table = document.getElementById("imagesTable");
    //validate data
    let invalidId = invalidData(itemId);
    if (invalidId){
        table.innerHTML = invalidId;
        return;
    }
    //initiate request
    let xhr = new XMLHttpRequest();
    xhr.onload = function(){
        table.innerHTML = this.responseText;
    }
    xhr.open("POST", "loadImages.php");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("itemId=" + itemId);
}

function removeImg(itemId, imageName, index){
    //prepare result span
    let result = document.getElementById("result" + index);
    //validate data
    let invalidId = invalidData(itemId);
    if (invalidId){
        result.innerHTML = invalidId;
        return;
    }
    //confirm
    if(!confirm("Are you sure you want to remove the image number " + (index + 1))){
        return;
    }
    //split image name to get its Id
    imageId = imageName.split(".")[0];
    
    //initiate request
    let xhr = new XMLHttpRequest();
    xhr.onload = function(){
        result.innerHTML = this.responseText;
        if(this.responseText == "success"){
            loadImages(itemId);
        }
    }
    xhr.open("POST", "removeImage.php");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("imageId=" + imageId);
}

function addImg(input, itemId, index){
    //prepare result span
    let result = document.getElementById("result" + index);
    //get image from the input
    let image = input.files[0];
    //validate data
    let invalidId = invalidData(itemId);
    if (invalidId){
        result.innerHTML = invalidId;
        return;
    }
    let invalidImg = invalidImage(image);
    if(invalidImg){
        result.innerHTML = invalidImg;
        return
    }
    
    //append data to a form to be sent
    let formData = new FormData();
    formData.append("itemId", itemId);
    formData.append("image", image);

    //initiate request
    let xhr = new XMLHttpRequest();
    xhr.onload = function(){
        result.innerHTML = this.responseText;
        if(this.responseText == "success"){
            loadImages(itemId);
        }
    }
    xhr.open("POST", "addImage.php");
    xhr.send(formData);
}

function displayImg(image){
    document.getElementById("imgDisplay").src = image;
    document.getElementById("displayImg").style.display  = "block";
}
function hideImg(){
    document.getElementById("displayImg").style.display  = "none";
}

//function to validate data
function invalidData(id){
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
function invalidImage(image){
    if (!image.type.startsWith('image/')){
        return "this is not an image";
    }
    if (image.size > 1048576){
        return "select image smaller than 1 MB";
    }
}