<!DOCTYPE html>

<?php header("Content-type:text/html;charset=utf-8"); ?>

<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Songbook - Song</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-music"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Songbook<sup>2</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-home"></i>
          <span>Home</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Songs
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="all_songs.php">
          <i class="fas fa-fw fa-table"></i>
          <span>All songs</span></a>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="add_new_song.php">
          <i class="fas fa-fw fa-edit"></i>
          <span>Add New Song</span></a>
      </li>



      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search song..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
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

            $query = "SELECT * FROM song WHERE song_id = " . $_GET['songid'];;
            // Execute the query
            if (($result = mysqli_query($db, $query)) == FALSE) {
              printf("Query failed: %s\n",  $query);
            }

            // Skapa alla item-element i feeden
            while ($line = $result->fetch_object()) {
              $title = $line->title;
              $melody = $line->melody;
              $author_id = $line->author_id;
              $creationdate = $line->date_created;
              $text = $line->text;
              $song_id = $line->song_id;


              $authorquery = "SELECT * FROM author WHERE author_id = " . $author_id;
              $authorresult = mysqli_query($db, $authorquery);
              $authorline = $authorresult->fetch_object();
              $author = $authorline->first_name . " " . $authorline->last_name;

              $scorequery = "SELECT AVG(score) as avgscore FROM score GROUP BY song_id HAVING song_id = " . $song_id;
              $scoreresult = mysqli_query($db, $scorequery);
              $score = 0;
              if ($scoreresult->num_rows > 0) {
                $scoreline = $scoreresult->fetch_object();
                $score = $scoreline->avgscore;
              }
             


              $rating = '<p style="display:inline"> Current rating: <strong>' . round($score) . '</strong> out of 5</p>';

              print utf8_encode('<h1 class="h3 mb-0 text-gray-800">' . $title . '</h1>');
              print utf8_encode('<a href="edit_song.php?songid=' . $_GET['songid'] . '" class="d-none d-sm-inline-block ');
              print utf8_encode('btn btn-sm btn-primary shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i>');
              print utf8_encode('Edit Song</a></div><div class="row"><div class="col-lg-12 mb-8"><div class="card shadow mb-4">');
              print utf8_encode('<div class="card-header py-3">');
              print utf8_encode('<h6 class="m-0 font-weight-bold text-primary">');
              print utf8_encode($author . ", " . $creationdate);
              print utf8_encode('</h6></div><div class="card-body"><div class="col-lg-8"><div><p class="font-italic">');
              print utf8_encode('Melody:  <span class="text-nowrap font-weight-bold">');
              print utf8_encode($melody . '</span></p></div><p>');
              print utf8_encode($text . '</p>');
              print utf8_encode('<div">');
              print utf8_encode('<div>');
              print utf8_encode($rating);
              print utf8_encode('</div>');
              print utf8_encode('<form action="addscore.php" method="get">
              <input type="hidden" class="form-control" id="validationServer00" name="song_id" value="' . $song_id . '" required>
                <div>
                        <label for="validationServer02">Your rating</label>
                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="score">
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                        
                      </div>
                    
                      <div style="margin-top: 2%">
                    <button class="btn btn-success" type="submit">Submit your rating</button>
                  </div>
            </form>');

            }
            
            mysqli_free_result($result);
            ?>
            
              
           

          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->

  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright &copy; Edward Lindén & Felix Almay</span>
      </div>
    </div>
  </footer>
  <!-- End of Footer -->

  </div>
  <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>



</body>

</html>