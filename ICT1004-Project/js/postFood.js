/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $('#summernote').summernote({
        placeholder: 'Enter your recipe',
        height: 500,
        maxHeight: null,
        codemirror: {// codemirror options
            theme: 'paper'
        },
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['video']]
        ]
    });

    $('#post-food-form').submit(function (e) {
        //Content has already encoded! Prevent XSS!
        var content = $('#summernote').summernote('code');
        content = content.replace("frameborder=\"0\"","");
        $('#food-content').val(content);
        var a = checkInputTitle();
        //var b = checkImage();
        var c = checkContent();
        var d = checkContainTags();
        var isFormValid = a && c && d;
        if (isFormValid)
        {
            return true;
        }
        else
        {
            return false;
        }
    });
});

function checkInputTitle()
{
    var content = $('#food-title').val();
    if (!content.replace(/\s/g, '').length) {
        $('#title-alerts').css("display", "block");
        $("#title-alerts").text("Please key in your title.");
        return false;
    } else
    {
        $('#title-alerts').css("display", "none");
        $("#title-alerts").text("");
        return true;
    }
}

function checkContent()
{
    var content = $('#food-content').val();
    if (!content.replace(/\s/g, '').length) {
        $('#content-alerts').css("display", "block");
        $("#content-alerts").text("Please key in your content/recipe.");
        return false;
    } else
    {
        $('#content-alerts').css("display", "none");
        $("#content-alerts").text("");
        return true;
    }
}

//function checkImage()
//{
//    if (!$("#display-image").val())
//    {
//        $('#image-alerts').css("display", "block");
//        $("#image-alerts").text("Please upload a photo.");
//        return false;
//    } else
//    {
//        $('#image-alerts').css("display", "none");
//        $("#image-alerts").text("");
//        return true;
//    }
//}

function checkContainTags()
{
    if ($("#all-tags").val().length != 0)
    {
        $('#tags-alerts').css("display", "none");
        $("#tags-alerts").text("");
        return true;
    } else
    {
        $('#tags-alerts').css("display", "block");
        $("#tags-alerts").text("Please key in at least one tag. Only letters, alphabets and spaces are allowed.");
        return false;
    }
}