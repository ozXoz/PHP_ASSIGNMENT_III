<nav class="navbar navbar-expand-lg ">
  <div class="container-fluid">
    <a class="navbar-brand text-white text-uppercase fw-bold" href="index.php"> inventory managment system</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars text-white"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link  " aria-current="page" href="create.php">Create</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">View</a>
        </li>
        <li>
          <div class="importExport mx-auto p-10">
            <!-- <button class="btn btn-success" type="submit">Import File</button> -->
            <a href="import_csv.php" class="btn btn-success">Import File</a>
            <a href="product_sheet.csv" class="btn btn-success ">Export File</a>
          </div>
        </li>
      </ul>

      <form action="index.php" method="GET" class="d-flex">
        <input class="form-control me-2" name="srched_item_number" value="" type="search" placeholder="Item Number" aria-label="Search">
        <button class="btn btn-danger" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>