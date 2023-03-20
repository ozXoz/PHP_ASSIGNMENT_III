<?php
include 'element/header.php';
include 'element/menu.php';
include 'functions.inc.php';


if (isset($_POST["btn_submit"])) {
    $result = importCsv($_FILES['filename']['name']);
}
?>
    <div class="createProduct" style="margin-top: 20px; padding: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 bg-white" style="padding: 30px;">
                    <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <h3 class="text-center text-uppercase">Import csv file</h3>
                        <hr>
                        <?php
                        if (isset($result)) {
                            echo $result;
                        }
                        ?>
                        <div class="mb-3">
                            <input type="file" id="myFile" name="filename">
                        </div>

                        <button type="submit" name="btn_submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<?php
include 'element/footer.php';
?>