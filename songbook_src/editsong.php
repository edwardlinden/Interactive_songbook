<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // connect using host, username, password and databasename
    $db = mysqli_connect('xml.csc.kth.se', 'adelinaa', 'adelinaa-xmlpub18', 'adelinaa');

    //check connection 
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }
    
    $song_id = $_GET["song_id"];
    $title = $_GET["title"];
    $melody = $_GET["melody"];
    $text = $_GET["text"];
    $date = $_GET["date"];
    $first_name = $_GET["first_name"];
    $last_name  = $_GET["last_name"];
    $category_id = $_GET["category"];
    $author_id = "";
    
    $authortestquery = "SELECT * FROM author " .
                       "WHERE first_name = '" . $first_name .
                       "' and last_name = '" . $last_name . "'";
    $authortestresult = mysqli_query($db, $authortestquery);
    if (mysqli_num_rows($authortestresult) == 0) {
        $authorinsertquery = "INSERT INTO author (first_name, last_name) " .
                             "VALUES ('" . $first_name . "', '" . $last_name . "')";
        mysqli_query($db, $authorinsertquery);
        $author_id = $db->insert_id;
    }
    else {
        $authorline = $authortestresult->fetch_object();
        $author_id = $authorline->author_id;
    }
    
    $query = "UPDATE song 
              SET title = '$title', melody = '$melody', author_id = '$author_id',
                  text = '$text', category_id = '$category_id', date_created = '$date',
                  datetime_lastmodified = CURRENT_TIMESTAMP 
              WHERE song_id = '$song_id'";
    print($query);
    $res = mysqli_query($db, $query);
    print($res);
    print '<script type="text/javascript">location.href = "index.php";</script>';
?>