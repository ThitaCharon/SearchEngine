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
   $fromLimit =($page -1 ) * $pageSize;


		$query = $this->con->prepare("SELECT * 
										 FROM sites WHERE title LIKE :term 
										 OR url LIKE :term 
										 OR keywords LIKE :term 
										 OR description LIKE :term
										 ORDER BY click DESC
                                          LIMIT :fromLimit, :pageSize");

		$searchTerm = "%". $term . "%";
		$query->bindParam(":term", $searchTerm);
		$query->bindParam(":fromLimit", $fromLimit,PDO::PARAM_INT);
		$query->bindParam(":pageSize", $pageSize,PDO::PARAM_INT);
		$query->execute();

		// display each result in div tag
		$resultsHtml = "<div class='siteResults'>";
		while($row = $query->fetch(PDO::FETCH_ASSOC)) {
			 
			$id = $row["id"];
			$url = $row["url"];
			$title = $row["title"];
			$description = $row["description"];
			$title = $this -> trimField($title,70);
			$description = $this -> trimField($description,70);

			$resultsHtml .= "<div class='resultContainer'>

								<h3 class='title'>
									<a class='result' href='$url' data-linkId ='$id'>
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
        $dots = strlen($string) > $charlimit ? "..." :" ";
        return substr($string,0,$charlimit) . $dots;
    }
}



?>