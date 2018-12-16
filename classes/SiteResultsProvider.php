<?php
class SiteResultsProvider {
// display query search result
	private $con;
	// default constructor 
	public function __construct($con) {
		$this->con = $con;
	}

	public function getNumResults($term) {
		$query = $this->con->prepare("SELECT COUNT(*) as SearchResults 
										 FROM sites WHERE title LIKE :term 
										 OR url LIKE :term 
										 OR keywords LIKE :term 
										 OR description LIKE :term");
		//Wildcard searh for the term keywords
		$searchTerm = "%". $term . "%";
		$query->bindParam(":term", $searchTerm);
		$query->execute();

		$row = $query->fetch(PDO::FETCH_ASSOC);
		return $row["SearchResults"];
	}

	public function getResultsHtml($page, $pageSize, $term) {

		$query = $this->con->prepare("SELECT * 
										 FROM sites WHERE title LIKE :term 
										 OR url LIKE :term 
										 OR keywords LIKE :term 
										 OR description LIKE :term
										 ORDER BY click DESC");

		$searchTerm = "%". $term . "%";
		$query->bindParam(":term", $searchTerm);
		$query->execute();

		// display each result in div tag
		$resultsHtml = "<div class='siteResults'>";
		while($row = $query->fetch(PDO::FETCH_ASSOC)) {
			 
			$id = $row["id"];
			$url = $row["url"];
			$title = $row["title"];
			$description = $row["description"];
			$title = $this -> trimField($title,55);
			$description = $this -> trimField($description,55);

			$resultsHtml .= "<div class='resultContainer'>

								<h3 class='title'>
									<a class='result' href='$url'>
										$title
									</a>
								</h3>
								<span class='url'>$url</span>
								<span class='description'>$description</span>

							</div>";

		}
		$resultsHtml .= "</div>";

		return $resultsHtml;
	}
    private function trimField($string, $charlimit){
        $dots = strlen($string) > $charlimit ? "..." :"..";
        return substr($string,0,$charlimit).$dots;
    }
}



?>