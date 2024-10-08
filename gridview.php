<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="./javascript/searchTable.js"></script> 
<title>Assignment 6</title>

<div class="center">

<h1>Music Selection</h1>

<div class = "button">

<button class = "button" onclick="window.print()">Print Records On Screen </button>

</div>

    <?php
    $API_URL = "http://localhost:8006/api/v1/selection";
    //$API_URL = "http://localhost:8050/api/v1/collection";

    //Adding CSS
    

    //Fetching Data
    $response = file_get_contents($API_URL);

    //Decode JSON
    $data = json_decode($response, true);


    //Validating that Data Exists
    if ($data && is_array($data)) {
        //Building Table
    
        //Pagination
        $limit = 10;
        $totalRecords = count($data);
        $totalPages = ceil($totalRecords / $limit); //Calculation to Set Number of Pages Per Record
    
        //Capture Current Page. Also sets default page
    
        //Could be causing issues
    
        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1; //P instead of p
    
        //Calculate Starting Index of the Current Page
        if ($currentPage < 1) {
            $currentPage = 1;
        } elseif ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }


        //Sort Logic
        $sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'id'; // Default sort by 'id'
       // $sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'video_game_id'; // Default sort by 'video_game_id'
        $sortMusic = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'desc' : 'asc'; // Default order is 'asc'
    
        // Sort the data based on column and music
        usort($data, function ($a, $b) use ($sortColumn, $sortMusic) {
            if ($sortMusic == 'asc') {
                return strcmp($a[$sortColumn], $b[$sortColumn]);
            } else {
                return strcmp($b[$sortColumn], $a[$sortColumn]);
            }
        });

        $starIndex = ($currentPage - 1) * $limit;
        $pageData = array_slice($data, $starIndex, $limit);

        function toggleMusic($selectMusic)
        {
            return $selectMusic == 'asc' ? 'desc' : 'asc';
        }

        //Search Box
        echo "<div class = 'search-container'>";
        echo "<label for='searchInput'>Search: </label>";
        echo "<input type='text' id='searchInput' onkeyup='searchTable()' placeholder='Something to Search For'>";
        echo "</div>";

        // <thead> not <thread>
        //echo "<thread>";
    
        // Function to toggle sort order
    


        //Basic HTML GridVieww
        echo "<table id='dataGrid'>";
        //echo "<table border='1' cellpadding='10'>";
        echo "<thead>";

        echo "<tr>";

    echo "<th><a href='?page=$currentPage&sort=id&order=" . toggleMusic($sortMusic) . "'>id</a></th>";
    echo "<th><a href='?page=$currentPage&sort=artist&order=" . toggleMusic($sortMusic) . "'>artist</a></th>";
    echo "<th><a href='?page=$currentPage&sort=album&order=" . toggleMusic($sortMusic) . "'>album</a></th>";

        //echo "<th><a href='?page=$currentPage&sort=video_game_id&order=" . toggleMusic($sortMusic) . "'>video_game_id</a></th>";
        //echo "<th><a href='?page=$currentPage&sort=title&order=" . toggleMusic($sortMusic) . "'>title</a></th>";
        //echo "<th><a href='?page=$currentPage&sort=system_name&order=" . toggleMusic($sortMusic) . "'>system_name</a></th>";
        //echo "<th><a href='?page=$currentPage&sort=publisher&order=" . toggleMusic($sortMusic) . "'>publisher</a></th>";

        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";


        //Loop Through The Data
        foreach ($pageData as $post) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($post['id']) . "</td>";
            echo "<td>" . htmlspecialchars($post['artist']) . "</td>";
            echo "<td>" . htmlspecialchars($post['album']) . "</td>";

            //echo "<td>" . htmlspecialchars($post['video_game_id']) . "</td>";
            //echo "<td>" . htmlspecialchars($post['title']) . "</td>";
            //echo "<td>" . htmlspecialchars($post['system_name']) . "</td>";
            //echo "<td>" . htmlspecialchars($post['publisher']) . "</td>";

            echo "</tr>"; // Missing Line of Code
        }

        echo "</tbody>";
        echo "</table>";

        echo "<div style='margin-top: 20px;'>";

        //Display Previous link if not on first page
        if ($currentPage > 1) {
            echo '<a href=?page=' . ($currentPage - 1) . '&sort=' . $sortColumn . '&order=' . $sortMusic . '">Previous</a> ';
        }

        //Displaying Page Numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                echo "<strong> $i </strong";
            } else {
                echo '<a href=?page' . $i . '&sort=' . $sortColumn . '&order=' . $sortMusic . '">' . $i . '</a> ';
            }
        }
            //Next Page
            if ($currentPage < $totalPages) {
                //$currentPage + 1 not $currentPage - 1
            echo '<a href=?page=' . ($currentPage + 1) . '&sort=' . $sortColumn . '&order=' . $sortMusic . '">Next</a> ';
            }

            if ($currentPage < $totalPages) {
                echo '<a href="?page=' . $i . '&sort=' . $sortColumn . '&order=' . $sortMusic . '">Next</a>';
            }

            echo "</div>";
        //}
            // Display total number of records at the bottom
            echo "<div style='margin-top: 20px;'>";
            echo "<strong>Total Records: $totalRecords</strong>";
            echo "</div>";

    } else {
        echo "Data isn't available or an error is occuring ";
    }
    ?>
</div>

</html>