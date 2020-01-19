<!DOCTYPE html>
<?php header("Content-type:text/html;charset=utf-8"); ?>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Songbook - Add New Song</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

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
      <li class="nav-item active">
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
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add new song</h1>
          </div>



          <!-- Content Row -->
          <div class="row">

            <div class="col-lg-12 mb-8">

              <!-- News -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Please fill all song info</h6>
                </div>
                <div class="card-body">
                  <form action="addsong.php" method="get">
                    <div class="form-row">
                      <div class="col-md-3 mb-3">
                        <label for="validationServer01">Song title</label>
                        <input type="text" class="form-control" id="validationServer01" name="title" placeholder="Song title"
                          required>

                      </div>
                      <div class="col-md-3 mb-3">
                        <label for="validationServer02">Song melody</label>
                        <input type="text" class="form-control" id="validationServer02" name="melody" placeholder="Song melody"
                          required>
                      </div>

                      <div class="col-md-3 mb-3">
                        <label for="validationServer02">Category</label>
                        <select class="custom-select mr-sm-2" name="category" id="inlineFormCustomSelect">
                        <option selected>Choose...</option>
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

                            $query = "SELECT *
                                      FROM category
                                      ORDER BY category_id ASC";
                            // Execute the query
                            if (($result = mysqli_query($db, $query)) == FALSE) {
                              printf("Query failed: %s\n",  $query);
                            }
                            while ($line = $result->fetch_object()) {
                                $category_id = $line->category_id;
                                $category_name = $line->category_name;
                                print '<option value="' . $category_id . '">' . $category_name . '</option>';
                            }
                            mysqli_free_result($result);
                        ?>
                      </select>
                    </div>

                      <div class="col-md-3 mb-3">
                        <label for="validationServer02">Date of song written</label>
                        <input type="date" class="form-control" id="validationServer02" name="date" placeholder="Date song written"
                          required>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="col-md-3 mb-3">
                        <label for="validationServer04">Author first name</label>
                        <input type="text" class="form-control" name="first_name" id="validationServer04" placeholder="Author first name"
                          required>

                      </div>
                      <div class="col-md-3 mb-3">
                        <label for="validationServer05">Author first name</label>
                        <input type="text" class="form-control" name="last_name" id="validationServer05" placeholder="Author last name"
                          required>

                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="validationTextarea">Lyrics</label>
                        <textarea class="form-control" id="validationTextarea" name="text"
                          placeholder="Please write the lyrics with a clear structure." required
                          style="margin-top: 0px; margin-bottom: 0px; height: 167px;"></textarea>

                      </div>

                    </div>
                    <div class="form-group">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck3" required>
                        <label class="form-check-label" for="invalidCheck3">
                          Agree to terms and conditions
                        </label>
                      </div>
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                      <button class="btn btn-success" type="submit">Submit</button>
                      <button class="btn btn-secondary" type="submit">Cancel</button>
                    </div>
                  </form>
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