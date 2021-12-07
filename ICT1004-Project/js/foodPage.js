/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    changeiFrameAttributes();
    $('.edit-post').click(editPage);
    $("#datetime").text(calcTime());
    $('.delete-post').click(deletePage);
    $('.report-post').click(reportPage);
    iframeResponsive();
    $(".popupimage").click(popupimage);
});

function editPage(e)
{
    //$.redirectPost("edit_food.php", {x: "postID", y: e.target.id});
    var url = "edit_food.php";
    var form = $('<form action="' + url + '" method="post">' +
            '<input type="text" name="postID" value="' + e.target.id + '" />' +
            '</form>');
    $('body').append(form);
    form.submit();
}

function deletePage(e)
{
    //$.redirectPost("edit_food.php", {x: "postID", y: e.target.id});
    var postID = document.getElementsByClassName("edit-post")[0].id;
    var url = "process_delete_post.php";
    var form = $('<form action="' + url + '" method="post">' +
            '<input type="text" name="postID" value="' + postID + '" />' +
            '</form>');
    $('body').append(form);
    form.submit();
}

function reportPage(e)
{
    if (checkReportPage())
    {
        var postID = document.getElementsByClassName("report-post")[0].id;
        var reportContent = document.getElementById("report-post-content").value;
        var url = "process_report_post.php";
        var form = $('<form action="' + url + '" method="post">' +
                '<input type="text" name="postID" value="' + postID + '" />' +
                '<textarea name="reportContent">' + reportContent + '</textarea>' +
                '</form>');
        $('body').append(form);
        form.submit();
    }
}

function checkReportPage()
{
    if ($("#report-post-content").val().length == 0)
    {
        $('#report-alerts').css("display", "block");
        $("#report-alerts").text("Please key in report content.");
        return false;
    }
    return true;
}

// jquery extend function
$.extend(
        {
            redirectPost: function (location, args)
            {
                var form = '';
                $.each(args, function (key, value) {
                    value = value.split('"').join('\"');
                    form += '<input type="hidden" name="' + key + '" value="' + value + '">';
                });
                $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo($(document.body)).submit();
            }
        });

//make all the iframe videos responsive
function iframeResponsive() {
    var elements = document.getElementsByClassName("note-video-clip");
    for (var i = 0; i < elements.length; i++) {
        elements[i].classList.add("embed-responsive-item");
        // `element` is the element you want to wrap
        var parent = elements[i];
        var wrapper = document.createElement('div');
        wrapper.className = "embed-responsive embed-responsive-16by9 col-md-6 mx-auto rounded";
        wrapper.appendChild(parent.cloneNode(true)); 
        parent.parentNode.replaceChild(wrapper, parent);
    }
}

function changeiFrameAttributes()
{
    $("iframe").attr("allowfullscreen","");
    $("iframe").removeAttr('frameborder');
    $("iframe").attr("title",$("#food-title").text());
}

// calculate local time in a different city given the city's UTC offset
function calcTime() {
    // Singapore GMT is GMT+08:00
    var date = new Date($("#datetime").text() + "  GMT+00:00");
    var utc = date.getTime() + (date.getTimezoneOffset() * 60000);
    var newDate = new Date(utc + (3600000 * getTimezone()));
    return changeDateFormat(newDate);
}

// get the timezone
function getTimezone() {
    var offset = new Date().getTimezoneOffset();
    var formatted = -(offset / 60);
    return formatted;
}

// Change the date format to e.g. 12 Nov 2021 11:28pm
function changeDateFormat(newDate)
{
    var month=new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
    var hours = newDate.getHours();
    var minutes = newDate.getMinutes();
    var ampm = "am";
    if (hours >= 12)
    {
        hours = hours % 12;
        ampm = "pm";
    }
    if(hours < 10)
    {
        hours = "0" + hours;
    }
    if (minutes < 10)
    {
        minutes = "0" + minutes;
    }
    var strTime = hours + ':' + minutes + ampm;
    return newDate.getDate() + " " + month[newDate.getMonth()] + " " + newDate.getFullYear() + ", "+ strTime;
}

function popupimage()
{
    var src = $(this).attr('src');
    var alt = $(this).attr('alt');
    $("#popup-image").attr('src', src);
    $("#popup-image").attr('alt', alt);
    $('#popup').modal('show');
    $("#popup-image").click( function()
    {
        $('#popup').modal('toggle');
    });
}