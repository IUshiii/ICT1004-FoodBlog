/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $('#clear-extra-image').click(clearPictures);
    $('#post-food-form').submit(function (e)
    {
        $('#extra-image-cleared').val(extraImageCleared);
    });
    checkIfHaveExtraImage();
    //Backup
//    $('#summernote').summernote({
//        placeholder: 'Enter your recipe',
//        height: 500,
//        maxHeight: null,
//        codemirror: {// codemirror options
//            theme: 'paper'
//        },
//        toolbar: [
//            // [groupName, [list of button]]
//            ['style', ['bold', 'italic', 'underline', 'clear']],
//            ['fontname', ['fontname']],
//            ['fontsize', ['fontsize']],
//            ['color', ['color']],
//            ['para', ['ul', 'ol', 'paragraph']],
//            ['insert', ['video']]
//        ]
//    });
//    
//    $('#post-food-form').submit(function () {
//        //Content has already encoded! Prevent XSS!
//        var content = $('#summernote').summernote('code');
//        content = content.replace("frameborder=\"0\"","");
//        $('#food-content').val(content);
//        return true;
//    });
});

var extraImageCleared = "no";
function clearPictures()
{
    $('#extra-pictures-here').empty();
    $('#add-extra-image').css("display", "block");
    $('#clear-extra-image').css("display", "none");
    extraImageCleared = "yes";
}

function checkIfHaveExtraImage()
{
    var a = document.getElementById("extra-pictures-here");
    if (a.childNodes.length == 1) {
        $('#add-extra-image').css("display", "block");
        $('#clear-extra-image').css("display", "none");
    }
}