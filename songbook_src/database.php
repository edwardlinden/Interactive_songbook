<?php header("Content-type:text/html;charset=utf-8");
?>


 <?php  
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // connect using host, username, password and databasename
    $db = mysqli_connect('xml.csc.kth.se', 'rsslab', 'rsslab', 'rsslab');

	//check connection 
	if (mysqli_connect_errno()) {
    	printf("Connect failed: %s\n", mysqli_connect_error());
    	exit();
	}

   // Skapa rdf:Seq-elementet
   $seqstring = "";
   $query = "SELECT link
             FROM exjobbsfeed
             ORDER BY link ASC";
   // Execute the query
	if (($result = mysqli_query($db, $query)) == FALSE) {
      printf("Query failed: %s\n",  $query);
   }
   while ($line = $result->fetch_object()) {
      $link = preg_replace('/\s/', '%20', $line->link);
      $seqstring = $seqstring . "<rdf:li rdf:resource='$link'/>\n";
   }
   
   // Skapa alla item-element i feeden
   $feedstring = "";
   $query = "SELECT *
             FROM exjobbsfeed
             ORDER BY feeddate ASC";
	if (($result = mysqli_query($db, $query)) == FALSE) {
      printf("Query failed: %s\n",  $query);
	}
   while ($line = $result->fetch_object()) {
      // Store results from each row in variables
      $link = preg_replace('/\s/', '%20', $line->link);
      $title = str_replace('&', '&amp;', $line->title);
      $description = str_replace('&', '&amp;', $line->description);
      $creator = str_replace('&', '&amp;', $line->creator);
      $feeddate = date("Y-m-d\TH:i:sP", strtotime($line->feeddate));

      $feedstring = $feedstring . "<item rdf:about='$link'>\n";
      $feedstring = $feedstring . "<title>$title</title>\n";
      $feedstring = $feedstring . "<link>$link</link>\n";
      $feedstring = $feedstring . "<description>$description</description>\n";
      $feedstring = $feedstring . "<dc:creator>$creator</dc:creator>\n";
      $feedstring = $feedstring . "<dc:date>$feeddate</dc:date>\n";
      $feedstring = $feedstring . "</item>\n";
   }

   print utf8_encode($seqstring);
   print '</rdf:Seq></items>';
   print '<image rdf:resource="http://www.nada.kth.se/media/images/kth.png"/>';
	print '</channel>';
   print utf8_encode($feedstring);
   // Free result and just in case encode result to utf8 before returning
   mysqli_free_result($result);
?>

