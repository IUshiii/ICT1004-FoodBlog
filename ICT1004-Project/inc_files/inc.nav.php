<nav class="navbar navbar-expand-sm sticky-top navbar-style">

    <a class="navbar-brand" aria-label="Back to home page" href="index.php">
        <img class=" navbar-img" src="images/logo.jpg" alt="logo"/>
    </a> <!-- changing of logo -->

    <!-- Creating of toggling button for collapse navbar and setting 
    where is the targeted items -->
    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="#navbarCollapseItems" aria-label="Menu button">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Setting of navbar item into div and stating that this portion 
    will be consisting of the collapsing of navbar items -->
    <div class="collapse navbar-collapse " id="navbarCollapseItems">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" aria-label="home page" href="index.php" >Home</a>
            </li>   
            <li class="nav-item">
                <a id="top_post_href" aria-label="top posts" class="nav-link top_post_href" href="#top_post">Top Post</a>
            </li>        
            <li class="nav-item">
                <a id="recent_post_href" aria-label="recently added posts" class="nav-link " href="#recently_added_post">Recently Added</a>  
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-label="about us page" href="about_us.php">About Us</a>  
            </li>
        </ul>   
        <ul class="navbar-nav  ml-auto"> <!-- margin left auto, which align 
                                        element to the right -->
<li class="nav-item">
                <a id="account_display" aria-label="account page" class="nav-link " href="register.php">
                    <span>
                        <i class="bi-person-circle register"></i>
                        <?php
                            include "session_data.php";
                            account_user();
                        ?>
                    </span>                   
                </a>
            </li>
            <li class="nav-item">
                <?php
                    check_user_session();
                ?>
            </li>
        </ul>
    </div>        

</nav>