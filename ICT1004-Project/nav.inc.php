

<nav class="navbar sticky-top navbar-expand-sm navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php" style="font-size: 15px;">
        <img src="images/tab_icon.png" alt="" style="width: 30px ; height: 30px ; background-color: white; border-radius: 50%;">
        Master Food
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo" aria-controls="navbarTogglerDemo" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo" >
        <ul class="navbar-nav">
            
            
            
            <li class="nav-item">
                
                <?php 

                // if there is a session, check for its user type
                if (isset($_SESSION['login']) && $_SESSION['login'] != "")
                {
                    if ($_SESSION['user_type'] == "User")
                    {
                        // user_type == User
                        echo '<a class="nav-link" title="Home" href="index.php">Home</a>';
                    }
                    else if ($_SESSION['user_type'] == "Admin")
                    {
                        // user_type == Admin
                        echo '<a class="nav-link" title="Access" href="index_admin.php">Access</a>';
                        
                        echo '<li class="nav-item">
                                <a class="nav-link" title="Create Account" href="Admin_CreateAccount1.php">Create Account</a>
                            </li>';
                        
                        //echo '<a class="nav-link" title="Create Account" href="Admin_CreateAccount1.php">Create Account</a>';
                    }
                }
                else
                {
                    echo '<a class="nav-link" title="Home" href="index.php">Home</a>';
                }

                ?>
                
                
            </li>
            
            
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    About Us
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="mission_vision.php">Our Mission, Vision & Values</a></li>
                    <li><a class="dropdown-item" href="aboutus.php">Our Teams</a></li>
                </ul>
            </li>
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Food Blogs
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="my_food_posts.php">My Recipes</a></li>
                    <li><a class="dropdown-item" href="post_food.php">Post a Recipe</a></li>
                    <li><a class="dropdown-item" href="search_food_page.php">Search Recipe</a></li>
                    <li><a class="dropdown-item" href="search_profile.php">Search Profile</a></li>
                </ul>
            </li>
            
            <li class="nav-item dropdown">
                
                
                <?php
                //checks if login session variable exist? if it does, display Logout
                if (isset($_SESSION['login']) && $_SESSION['login'] != "") {
                    
                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">My Account (' . $_SESSION['login'] . ')</a>';
                    echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
                    echo '<li><a class="dropdown-item" href="member_profile.php">My Profile</a></li>';
                    echo '<li><a class="dropdown-item" href="User_ViewProfile.php">Edit Account</a></li>';
                    echo '<li><a class="dropdown-item" href="logout.php">Log Out</a></li>';
                    echo '</ul>';
                    
                } 
                else {
                    
                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Account</a>';
                    echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
                    echo '<li><a class="dropdown-item" href="register.php">Sign Up</a></li>';
                    echo '<li><a class="dropdown-item" href="login.php">Log In</a></li>';
                    echo '</ul>';
                    
                }
                ?>
                
                
            </li>
            
            
            
        </ul>
        
        
    </div>
    
    
    
</nav>




