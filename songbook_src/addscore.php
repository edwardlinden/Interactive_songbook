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
    
    $score = $_GET["score"];
    $song_id = $_GET["song_id"];
  
    
    $query = "INSERT INTO score
                (score_datetime, score, song_id)
              VALUES 
                (CURRENT_TIMESTAMP, " . $score . ", " . $song_id . ")";
    $res = mysqli_query($db, $query);
    print($res);
    print '<script type="text/javascript">location.href = "index.php";</script>';
?>