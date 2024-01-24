	<?php
	// Assuming you have a MySQL database connection
	$servername = "localhost";
	$username = "root";
	$password = "JCTWindows2024";
	$dbname = "search_db";

	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}


	// Function to tokenize and remove stopwords from a string
	function preprocessQuery($query) {
    global $conn;

    $query = strtolower($query);
    $query = preg_replace('/[^\p{L}\p{N}\s]/u', '', $query); // Remove non-alphanumeric characters
    $query = preg_replace('/\s+/', ' ', $query); // Remove extra spaces

    // Tokenize the query
    $tokens = explode(' ', $query);

    // Remove stopwords
    $stopwords = [];
    $stopwordsResult = $conn->query("SELECT stopword FROM stopwords");
    while ($row = $stopwordsResult->fetch_assoc()) {
        $stopwords[] = $row['stopword'];
    }

    $filteredTokens = array_diff($tokens, $stopwords);

    return implode(' ', $filteredTokens);
	}

	function jaccardSimilarity($set1, $set2) {
        $intersection = array_intersect($set1, $set2);
        $union = array_unique(array_merge($set1, $set2));

        $similarity = count($intersection) / count($union);

        return $similarity;
    }
 // 

	// Main search logic
	// $query = "What are your clinic hours?";
	$searchQuery = preprocessQuery($_POST['query']);
	// $searchQuery = preprocessQuery($query);

	// SQL query to compare with the keyword table
	// $sql = "SELECT * FROM sample_q&a WHERE MATCH(keywords) AGAINST ('$searchQuery') IN BOOLEAN MODE";
	$sql = "SELECT * FROM sample_q&a WHERE question LIKE '%$query%'";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // Output data in JSON format
	    $rows = array();
	    while($row = $result->fetch_assoc()) {
	        $rows[] = $row;
	    }
	    echo json_encode($rows);
	} else {
	    echo "No results found";
	}
