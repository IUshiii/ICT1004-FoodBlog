/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function ()
{
//    $("#display-image").on('change', displayImage);
    $(".display-extra-image").change(function () { //set up a common class
        displayExtraImage(this);
    });
    $("#add-extra-image").click(addFileImageInput);
    lookForDeleteButtons();
    lookRecount();
});

function displayExtraImage(a) {
    if(isCorrectFileSize(a.files[0]))
    {
        if (isFileImage(a.files[0]))
        {
            var fileName = a.files[0].name;
            var reader = new FileReader();
            reader.onload = function (e) {
                //Initiate the JavaScript Image object.
                var image = new Image();
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;
                //Validate the File Height and Width.
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    if (height != width) {
                        $('#image-alerts').css("display", "block");
                        $("#image-alerts").text("Only squared pictures are allowed.");
                    } else
                    {
                        $('#image-alerts').css("display", "none");
                        $("#image-alerts").text("");
                        var fileId = a.id;
                        var extraImages = document.getElementsByClassName(fileId);
                        
                        //problem is extraImages[i].src.includes("UploadImage.png") will be useless after finding a picture!
                        //alert(extraImages.length);
                        for (var i = 0; i < extraImages.length; i++) 
                        {
                            //$("#e-f-" + i).attr("src", e.target.result);
                            extraImages[i].setAttribute("src", e.target.result);
                            break;
                        }
                        //$(".display-image").text(fileName);
                        $(a).next('.custom-file-label').html(fileName)
                    }
                };
            };
            reader.readAsDataURL(a.files[0]);
        } else
        {
            $('#image-alerts').css("display", "block");
            $("#image-alerts").text("Only jpg, jpeg and png images allowed!");
        }
        
    }
    else
    {
        $('#image-alerts').css("display", "block");
        $("#image-alerts").text("Only less than 10MB images allowed!");
    }
}

var count = 0;

function addFileImageInput()
{
    var divWhole = document.createElement("div");
    
    var divGroup = document.createElement("div");
    divGroup.classList.add("form-group");

    var label = document.createElement("label");
    label.setAttribute("for", "e-f-" + count);
    label.innerHTML = "Extra Image";
    divGroup.appendChild(label);

    var divFile = document.createElement("div");
    divFile.setAttribute("class", "custom-file");
    var inputFile = document.createElement("input");
    inputFile.setAttribute("type", "file");
    inputFile.setAttribute("id", "e-f-" + count);
    inputFile.setAttribute("class", "custom-file-input display-extra-image");
    inputFile.setAttribute("name", "extra-image[]");
    inputFile.setAttribute("aria-describedby", "upload-image");
    var labelElement = document.createElement("label");
    labelElement.setAttribute("class", "custom-file-label");
    labelElement.setAttribute("for", "display-image");
    labelElement.innerHTML = "Choose file";
    divFile.appendChild(inputFile);
    divFile.appendChild(labelElement);
    divGroup.appendChild(divFile);

    var divImage = document.createElement("div");
    divImage.setAttribute("class", "form-group append-here");
    var imageElement = document.createElement("img");
    imageElement.setAttribute("src", "foodimages/UploadImage.png");
    imageElement.setAttribute("class", "rounded border food-extra-image e-f-" + count);
    imageElement.setAttribute("alt", "Upload Image");
    divImage.appendChild(imageElement);
    
    //<button id="delete-extra-image" type="button" class="btn btn-secondary d-inline">Delete Image</button>
    var divBtn = document.createElement("div");
    divBtn.setAttribute("class", "form-group append-here");
    var delBtn = document.createElement("button");
    delBtn.setAttribute("id", "del-btn-" + count);
    delBtn.setAttribute("type", "button");
    delBtn.setAttribute("class", "btn btn-danger btn-sm delete-extra-image");
    delBtn.innerHTML = "Delete This Image";
    divBtn.appendChild(delBtn);
    
    
    divWhole.appendChild(divGroup);
    divWhole.appendChild(divImage);
    divWhole.appendChild(divBtn);
    
    var divAppendInto = document.getElementById("extra-pictures-here");
    divAppendInto.appendChild(divWhole);
    
    $("#e-f-" + count).change(function () { //set up a common class
        displayExtraImage(this);
    });
    delBtn.addEventListener("click", deleteExtraImage);

    count += 1;
}

function insertAfter(newNode, referenceNode) {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}

function deleteExtraImage(e)
{
    e.target.parentElement.parentElement.remove();
}

function lookForDeleteButtons()
{
    var delBtns = document.getElementsByClassName("delete-extra-image");
    for (var i = 0; i < delBtns.length; i++)
    {
        delBtns[i].addEventListener("click", deleteExtraImage);
    }
}

function lookRecount()
{
    var delBtns = document.getElementsByClassName("delete-extra-image");
    count = delBtns.length;
}
