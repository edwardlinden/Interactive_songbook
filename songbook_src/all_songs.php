<!DOCTYPE html>
<?php header("Content-type:text/html;charset=utf-8"); ?>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Songbook - All Songs</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
      <li class="nav-item active">
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
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search song..."
                aria-label="Search" aria-describedby="basic-addon2">
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
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">All Songs</h1>
          <p class="mb-4">Here is every song displayed. You are able to search for anything you want, as much as it
            contains songs.</p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">All Songs</h6>
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
                      <th>Userscores</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Category</th>
                      <th>Title</th>
                      <th class="font-italic">Melody</th>
                      <th>Author</th>
                      <th>Date</th>
                      <th>Userscores</th>
                    </tr>
                  </tfoot>
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
                                 ORDER BY date_created DESC";
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

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>