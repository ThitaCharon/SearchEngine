<?php
include("config.php");
include("classes/SiteResultsProvider.php");

if ($_GET['term'] == "") {
    header("Location: index.php");
}

if (isset($_GET["term"])) {
    $term = $_GET["term"];
} else {
    exit("Please prompt the search query");
}

$type = isset($_GET["type"]) ? $_GET["type"] : "sites";
$page = isset($_GET["page"]) ? $_GET["page"] : 1;

?>

<!-- exit("Please prompt the search query"); -->
<!DOCTYPE html>
<html>
<head>
    <title>MyGoodle</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="headerContent">
            <div class="logoContainer">
                <a href="index.php">
                    <img src="assets/images/google_logo.png">
                </a>
            </div>

            <div class="searchContainer">
                <form action="search.php" method="GET">
                    <div class="searchBarContainer">
                        <input class="searchBox" type="text" name="term" value="<?php echo $term ?>">
                        <!-- <input class="searchButton" type="submit" value="Search"> -->
                        <button class="searchButton">
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
        $pageSize = 20;
        echo $resultsProvider->getResultsHtml($page, $pageSize, $term);
        ?>
    </div>
</div>
<div class="paginationContainer">
    <div class="pageButtons">


            <div class="pageNumberContainer">
                <img src="assets/images/page-start.png" alt="start">
            </div>

        <?php
            $pageToShow = 10;
            $numPage = ceil($numResults / $pageSize);
            $pageLeft = min($pageToShow,$numPage);
        $current = $page - floor($pageToShow/2);
        if ($current < 1) $current = 1;
        if ($current +$pageLeft >$numPage+1){
            $current =$numPage+1 - $pageLeft;
        }

            while ($pageLeft != 0){
                if ($current == $page){
                    echo "<div class='pageNumberContainer'>
                            <img src='assets/images/page.png'>
                            <span class='pageNumber'> $current </span>
                       </div>";
                }
                else {
                     echo "<div class='pageNumberContainer'>
                               <a href='search.php?term=$term&type=$type&page=$current'>
                                    <img src='assets/images/pageSelected.png'>
                                    <span class='pageNumber'> $current </span>
                            </a>
                       </div>";
                }
                   $current++;
                $pageLeft--;
                }




        ?>







            <div class="pageNumberContainer">
                <img src="assets/images/pageEnd.png" alt="end">
            </div>
    </div>

</div>
<script src="assets/js/script.js"></script>
</body>
</html>