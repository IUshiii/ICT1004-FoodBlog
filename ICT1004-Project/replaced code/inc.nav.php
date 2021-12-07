<nav class="navbar navbar-expand-sm navbar-static-top fixed-top navbar-dark">

    <a class="navbar-brand" href="index.php">
        <img class=" navbar-img" src="./images/tab_icon.png" alt="logo"/>
    </a> <!-- changing of logo -->

    <!-- Creating of toggling button for collapse navbar and setting 
    where is the targeted items -->
    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="#navbarCollapseItems">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Setting of navbar item into div and stating that this portion 
    will be consisting of the collapsing of navbar items -->
    <div class="collapse navbar-collapse " id="navbarCollapseItems">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php" >Home</a>
            </li>   
            <li class="nav-item">
                <a class="nav-link" href="../project/post_food.php">Post Food</a>
            </li>        
            <li class="nav-item">
                <a class="nav-link" href="#cats">Category</a>  
            </li>
        </ul>       


        <ul class="navbar-nav  ml-auto"> <!-- margin left auto, which align 
                                        element to the right -->
            <li class="nav-item">
                <a id="account_display" class="nav-link " href="register.php">
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
                <!--                <a class="nav-link" href="login.php">
                                    <i class="bi-box-arrow-in-right login-icon"></i>
                                </a>-->
            </li>
        </ul>
    </div>        

</nav>

<!--       <form class="form-inline my-2 my-lg-0 justify-content-center">
      <input class="form-control" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-dark btn-md my-2 my-sm-0 ml-3" type="submit"><i class="bi bi-search"></i></button>
    </form>-->
