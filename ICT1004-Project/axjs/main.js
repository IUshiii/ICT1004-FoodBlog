



function myFunction() {

    $('#pwd, #pwd_confirm').on('keyup', function () {

        if ($('#pwd').val() === "")
        {
            $('#message').html('Hint: Minimum 8 and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character').css('color', '#FF160C');  // red
        }

        if ($('#pwd').val() === $('#pwd_confirm').val())
        {
            $('#message').html('Matching').css('color', '#39FF14');  //green
        } else
            $('#message').html('Not Matching: Minimum 8 and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character').css('color', '#FF160C');  // red
    });

}


function myFunction_emptypassword() {

    $('#pwd').on('keyup', function () {

        if ($('#pwd').val() === "")
        {
            $('#message').html('Hint: Minimum 8 and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character').css('color', '#FF160C');  // red
            
        }

    });

}



// this is the function for verticle tab //

function openProfileInfo(evt, usertabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(usertabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();




// for profile image
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#defaultimage')
                    .attr('src', e.target.result)
                    .width(200)
                    .height(250);
        };

        reader.readAsDataURL(input.files[0]);
    }
}



// clear profile image picture
function clearppImage()
{
    var img = document.getElementById("defaultimage");
    img.src = "images/emptypp.jpg";
    return false;
}




// google translator
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}




// scroll to top button

//Get the button
var mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}



// only enable user to type numbers in textbox
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
