<header class="bg-banner">
    <div class="jumbotron text-center banner-overlay ">
<!--              Search bar        -->
        <form id="search_form" action=""
              onsubmit="validate_search_input()" method="post">
            <div class="input-group search_style">
                <input id="searchbar" name="search_value" type="text" class="form-control no-border" 
                required placeholder="Search for food..."  >
                <div class="input-group-append">
                    <button class="btn btn-secondary btn-light" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</header>