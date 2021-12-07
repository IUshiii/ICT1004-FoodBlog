$(document).ready(function () {
    
    active_nav_link();
    
    $(".change-datetime").text(calcTime);
//    To set dynamic header for the heading     
//    if (document.getElementById("index_page")!== null){
//        create_header_title();
//    }
});

//function create_header_title(){
//    var main_heading = document.createElement("h1");
//    var sub_heading = document.createElement("h2");    
//    main_heading.setAttribute("class", "display-4");  
//    var main_heading_text = document.createTextNode("Welcome to Awesome Foodie!");
//    var sub_heading_text = document.createTextNode("Home of Awesome Food");
//    main_heading.append(main_heading_text);
//    sub_heading.append(sub_heading_text);
//    //$(".banner-overlay ").append(main_heading,sub_heading);
//    $(main_heading).insertBefore($("#search_form"));
//    $(sub_heading).insertBefore($("#search_form"));
//}

function active_nav_link()
{
    var current_page = location.href;
    $(".navbar-nav a").each(function () {
        var target_page = $(this).prop("href");
        if (target_page === current_page) {
            $('nav a').parents('li, ul').removeClass('active');
            $(this).parent('li').addClass('active');
            return false;
        }
    });
}

function href_link_replace() 
{
    console.log("replace link function");
    top_post_link = document.getElementById("top_post_href");
    recent_post_link = document.getElementById("recent_post_href");
    
    index_link_top_post = top_post_link.href="index.php#top_post";
    index_link_recent_post = recent_post_link.href="index.php#recently_added_post";
}

function validate_search_input()
{
    console.log("validate function");
    var search_value = document.getElementById("searchbar").value.length;
    if (search_value === 0) 
    {
        alert("Search bar is empty!");
        return false;
    }
    else 
    {
        search_bar = document.getElementById("search_form");
        redirect_search_page = search_bar.action="search_food_page.php";
    }
}

// calculate local time in a different city given the city's UTC offset
function calcTime(e) {
    // Singapore GMT is GMT+08:00
    var date = new Date($(this).text() + "  GMT+00:00");
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