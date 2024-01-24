<?php
    function jaccardSimilarity($set1, $set2) {
        $intersection = array_intersect($set1, $set2);
        $union = array_unique(array_merge($set1, $set2));

        $similarity = count($intersection) / count($union);

        return $similarity;
    }

    // Assuming you already have a MySQL database connection
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


    // Main search logic
    $query = "What are your clinic hours?";
    $searchQuery = preprocessQuery($query);


    // Fetch questions from the database
    $sql = "SELECT * FROM sample_qa";
    $result = $conn->query($sql);

    // Filter results based on Jaccard similarity
    $filteredResults = [];
    while ($row = $result->fetch_assoc()) {
        $rowQuestion = preprocessQuery($row['question']);
        $similarity = jaccardSimilarity($searchQuery, $rowQuestion);

        // Adjust the threshold as needed
        if ($similarity > 0.5) {
            $filteredResults[] = $row;
        }
    }

    // Output filtered results
    if (!empty($filteredResults)) {
        echo json_encode($filteredResults);
    } else {
        echo "No results found";
    }

    $conn->close();
?>
