<?php
include("config.php");
include("classes/SiteResultsProvider.php");

    if ($_GET['term']== ""){
        header("Location: index.php");
    }

	if(isset($_GET["term"])) {
		$term = $_GET["term"];
	}
	else {
		exit("Please prompt the search query");
	}

	$type = isset($_GET["type"]) ? $_GET["type"] : "sites";
	
?>

<!-- exit("Please prompt the search query"); -->
<!DOCTYPE html>
<html>
<head>
    <title>MyGoodle</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="headerContent">
                <div class = "logoContainer">
                    <a href ="index.php">
                        <img src = "assets/images/google_logo.png">
                    </a>
                </div>

            <div class="searchContainer">
                <form action="search.php" method="GET">
                    <div class="searchBarContainer">
                        <input class="searchBox" type="text" name="term" value="<?php echo $term ?>"> 
                        <!-- <input class="searchButton" type="submit" value="Search"> -->
                        <button class ="searchButton">
                            <img src="assets/images/search_icon.png">
                        </button>
                    </div>
                </form>
            </div> 
        </div>    
 
            <div class="tabsContainer">
                <ul class="tabList">
                    <li class="<?php echo $type == 'sites' ? 'active' : '' ?>">
                        <a href='<?php echo "search .php?term=$term&type=sites"; ?>'>Sites</a></li>
                    <li class="<?php echo $type == 'images' ? 'active' : '' ?>">
                        <a href='<?php echo "search.php?term=$term&type=images"; ?>'>Images</a></li>
                </ul>
            </div>
        </div>
    
        <!-- dispalay search result section -->
        <div class="mainResultsSection">
                <?php
                $resultsProvider = new SiteResultsProvider($con);
                $numResults = $resultsProvider->getNumResults($term);
                echo "<p class='resultsCount'>$numResults results found</p>";
                echo $resultsProvider->getResultsHtml(1, 20, $term);
                ?>
        </div>
    </div>
</body>
</html>