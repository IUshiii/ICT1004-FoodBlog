/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var tags = [];

$(document).ready(function () 
{
    checkTags();
    $('#food-tags').keypress(createTags);
});

function checkTags()
{
    if ($("#all-tags").val().length != 0)
    {
        var tagsTemp = $("#all-tags").val().split(",")
        for (var i = 0; i < tagsTemp.length; i++) {
            createTagBtn(tagsTemp[i]);
        }
        tags = tagsTemp;
    }
    ;
}

function createTags(e) {
    if (e.which == 13 || e.which == 44) {
        // Check and only allow alphabets, numbers and spaces
        var input = $("#food-tags").val().replace(/[^a-zA-Z1-9 ]/g, "");
        //<a class="btn btn-primary" href="#" role="button">Link</a>
        if (input != "")
        {
            createTagBtn(input);
        }
        $("#food-tags").val("");
    }
}

function createTagBtn(input)
{
    btn = document.createElement('a');
    btn.setAttribute('class', 'btn btn-secondary btn-sm tag-close');
    btn.setAttribute('alt', input);
    btn.setAttribute('style', 'color: white;');
    btn.setAttribute('role', 'button');
    btn.setAttribute('title', 'Delete this tag');
    btn.innerText = input;
    $("#food-tags").val("");
    btn.addEventListener("click", function () {
        var index = tags.indexOf(input);
        if (index > -1) {
            tags.splice(index, 1);
        }
        $(this).remove();
        $("#all-tags").val(tags);
    });
    document.getElementById("display-tags").appendChild(btn);
    tags.push(input);
    $("#all-tags").val(tags);
}