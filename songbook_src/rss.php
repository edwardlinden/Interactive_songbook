<?php header("Content-type:text/xml;charset=utf-8");
?>
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="rss.xsl" ?>
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
         xmlns="http://purl.org/rss/1.0/" 
         xmlns:dc="http://purl.org/dc/elements/1.1/" 
         xmlns:syn="http://purl.org/rss/1.0/modules/syndication/">

  <channel rdf:about="http://www.nada.kth.se/media/Theses/"> 
    <title>Sångbok</title>
    <link>https://course-dm2517-ht18.csc.kth.se/~almay/DM2517/Interactive_songbook/songbook_src/rss.php</link>
    <description>Nya sånger i sångboken</description>
    <dc:language>sv</dc:language>
    <dc:rights>Copyright Felix Almay &amp; Edward Lindén</dc:rights>
    <dc:date><?php echo date("Y-m-d\TH:i:sP"); ?></dc:date>

    <dc:publisher>Felix Almay &amp; Edward Lindén</dc:publisher>
    <dc:creator>almay@kth.se</dc:creator>
    <syn:updatePeriod>daily</syn:updatePeriod>
    <syn:updateFrequency>1</syn:updateFrequency>
    <syn:updateBase>2006-01-01T00:00+00:00</syn:updateBase>

    <items>
      <rdf:Seq>
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

   // Skapa rdf:Seq-elementet
   $seqstring = "";
   $query = "SELECT *
             FROM song
             ORDER BY datetime_lastmodified DESC";
   // Execute the query
	if (($result = mysqli_query($db, $query)) == FALSE) {
      printf("Query failed: %s\n",  $query);
   }
   while ($line = $result->fetch_object()) {
      $song_id = $line->song_id;
      $seqstring = $seqstring . "<rdf:li rdf:resource='song.php?songid=$song_id'/>\n";
   }
   
   // Skapa alla item-element i feeden
   $feedstring = "";
	if (($result = mysqli_query($db, $query)) == FALSE) {
      printf("Query failed: %s\n",  $query);
	}
   while ($line = $result->fetch_object()) {
      // Store results from each row in variables
      $title = str_replace('&', '&amp;', $line->title);
      $text = str_replace('&', '&amp;', $line->text);
      $author_id = str_replace('&', '&amp;', $line->author_id);
      $feeddate = date("Y-m-d\TH:i:sP", strtotime($line->datetime_lastmodified));
      
      
      $authorquery = "SELECT * FROM author WHERE author_id = " . $author_id;
      $authorresult = mysqli_query($db, $authorquery);
      $authorline = $authorresult->fetch_object();
      $author = $authorline->first_name . " " . $authorline->last_name;
      $author = str_replace('&', '&amp;', $author);

      $feedstring = $feedstring . "<item rdf:about='song.php?songid=$song_id'>\n";
      $feedstring = $feedstring . "<title>$title</title>\n";
      $feedstring = $feedstring . "<link>song.php?songid=$song_id</link>\n";
      $feedstring = $feedstring . "<description>$text</description>\n";
      $feedstring = $feedstring . "<dc:creator>$author</dc:creator>\n";
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

</rdf:RDF>