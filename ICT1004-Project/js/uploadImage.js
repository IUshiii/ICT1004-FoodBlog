/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function ()
{
    $("#display-image").on('change', displayImage);
});

function displayImage(e) {
    if(isCorrectFileSize(e.target.files[0]))
    {
        if (isFileImage(e.target.files[0]))
        {
            var fileName = e.target.files[0].name;
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
                        $('#food-image').attr('src', e.target.result);
                        $('#food-image').attr('alt', fileName);
                        //$(".display-image").text(fileName);
                        $("#display-image").next('.custom-file-label').html(fileName)
                    }
                };
            };
            reader.readAsDataURL($('#display-image').prop('files')[0]);
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

function isFileImage(file) {
    const acceptedImageTypes = ['image/jpg', 'image/jpeg', 'image/png'];
    return file && acceptedImageTypes.includes(file['type']);
}

function isCorrectFileSize(file)
{
    // Allow image less than 10MB only
    if(file.size/1024/1024 < 10)
    {
        return true;
    }
    else
    {
        return false;
    }
}