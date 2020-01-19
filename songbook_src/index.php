<!DOCTYPE html>

<?php header("Content-type:text/html;charset=utf-8"); ?>

<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Songbook</title>

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
      <li class="nav-item active">
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
            <h1 class="h3 mb-0 text-gray-800">Welcome to the Songbook</h1>
            <a href="rss.php" target="blank"><i class="fas fa-rss-square fa-3x"></i></a>
          </div>



          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-9 mb-4">

              <!-- DataTales Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Editor's choice</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Category</th>
                          <th>Title</th>
                          <th class="font-italic">Melody</th>
                          <th>Author</th>
                          <th>Date</th>
                          <th>Score</th>
                        </tr>
                      </thead>
                      <tbody>
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

                        $seqstring = "";
                        $query = "SELECT *
                                 FROM song
                                 ORDER BY date_created DESC LIMIT 5";
                        // Execute the query
                        if (($result = mysqli_query($db, $query)) == FALSE) {
                          printf("Query failed: %s\n",  $query);
                        }

                        // Skapa alla item-element i feeden
                        while ($line = $result->fetch_object()) {
                          $tablerow = "<tr>";
                          $category_id = $line->category_id;
                          $song_id = $line->song_id;
                          $title = $line->title;
                          $melody = $line->melody;
                          $author_id = $line->author_id;
                          $creationdate = $line->date_created;

                          $catquery = "SELECT * FROM category WHERE category_id = " . $category_id;
                          $catresult = mysqli_query($db, $catquery);
                          $catline = $catresult->fetch_object();
                          $category = $catline->category_name;
                          
                          $authorquery = "SELECT * FROM author WHERE author_id = " . $author_id;
                          $authorresult = mysqli_query($db, $authorquery);
                          $authorline = $authorresult->fetch_object();
                          $authorname = $authorline->first_name . " " . $authorline->last_name;

                          $scorequery = "SELECT AVG(score) as avgscore FROM score GROUP BY song_id HAVING song_id = " . $song_id;
                          $scoreresult = mysqli_query($db, $scorequery);
                          $score = 0;
                          if ($scoreresult->num_rows > 0) {
                            $scoreline = $scoreresult->fetch_object();
                            $score = $scoreline->avgscore;
                          }

                          $tablerow = $tablerow . "<td>$category</td>";
                          $tablerow = $tablerow . "<td><a href='song.php?songid=$song_id'>$title</td>";
                          $tablerow = $tablerow . "<td class='font-italic'>$melody</td>";
                          $tablerow = $tablerow . "<td>$authorname</td>";
                          $tablerow = $tablerow . "<td>$creationdate</td>";
                          $tablerow = $tablerow . "<td>";
                          for ($x = 0; $x < intval($score); $x++) {
                            $tablerow = $tablerow . "<i class='fas fa-star'/>";
                          }
                          if (floatval($score) - intval($score) >= 0.5) {
                            $tablerow = $tablerow . "<i class='fas fa-star-half'/>";
                          }
                          $tablerow = $tablerow . "</td>";
                          $tablerow = $tablerow . "</tr>";
                          print utf8_encode($tablerow);
                        }
                        mysqli_free_result($result);
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 mb-4">

              <!-- News -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">News</h6>
                </div>
                <div class="card-body">
                  <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_compose_music_ovo2.svg" alt="">
                  </div>
                  <p>The newest songs will be shown here! Have a good time browsing this page while you are singing at a
                    Gasque.</p>
                  <p>To edit or delete an existing song, find it and press the button "Edit Song" at the right of the
                    lyrics. To add a new song you simply press "Add New Song" at the left sidebar.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Categories</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Categories Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="category.php">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Category</div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-wine-glass-alt fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Categories Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="category.php">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Category</div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-wine-glass-alt fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Categories Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="category.php">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Category</div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-wine-glass-alt fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Categories Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="category.php">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Category</div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-wine-glass-alt fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
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