<?php
//adding required files
include 'element/header.php';
include 'element/menu.php';
include 'functions.inc.php';
//adding the record only if user submit the form
if (isset($_POST["btn_submit"])) {
    $result = addRecordToCsv($_SERVER["REQUEST_METHOD"]);
}
?>
    <div class="createProduct" style="margin-top: 20px; padding: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 bg-white" style="padding: 30px;">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <h3 class="text-center text-uppercase">Insert a product</h3>
                        <hr>
                        <?php if (isset($result)) {
                            echo $result;
                        } ?>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type <span style="color: red;">*</span></label>
                            <select class="form-select" name="type" aria-label="Default select example" required>
                                <option value="" selected>Select One</option>
                                <option value="LCD">LCD</option>
                                <option value="LED">LED</option>
                                <option value="OLED">OLED</option>
                                <option value="QLED">QLED</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="brand" class="form-label">Brnad <span style="color: red;">*</span></label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="brand" id="inlineRadio1" value="LG"
                                       required>
                                <label class="form-check-label" for="LG">LG</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="brand" id="inlineRadio2"
                                       value="samsung">
                                <label class="form-check-label" for="samsung">Samsung</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="brand" id="inlineRadio1"
                                       value="Sony">
                                <label class="form-check-label" for="Sony">Sony</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="brand" id="inlineRadio2"
                                       value="Toshiba">
                                <label class="form-check-label" for="Toshiba">Toshiba</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Model" class="form-label">Model <span style="color: red;">*</span></label><br>
                            <input type="text" class="form-control" name="model" id="model" aria-describedby="emailHelp"
                                   value="<?php if (isset($_REQUEST["model"])) {
                                       echo test_input($_REQUEST['model']);
                                   } ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="size" class="form-label">Size <span style="color: red;">*</span></label><br>
                            <input type="number" class="form-control" name="size" id="size" aria-describedby="emailHelp"
                                   value="<?php if (isset($_REQUEST["size"])) {
                                       echo test_input($_REQUEST['size']);
                                   } ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price <span style="color: red;">*</span></label><br>
                            <input type="number" class="form-control" name="price" id="price"
                                   aria-describedby="emailHelp" value="<?php if (isset($_REQUEST["price"])) {
                                echo test_input($_REQUEST['price']);
                            } ?>" step="0.01" required>
                        </div>

                        <!-- <div class="mb-3">
                            <label for="sale" class="form-label">Sale</label><br>
                            <input type="text" class="form-control" name="sale" id="sale" aria-describedby="emailHelp" value="<?php if (isset($_REQUEST["sale"])) {
                            echo test_input($_REQUEST['sale']);
                        } ?>">
                          </div> -->


                        <!-- <div class="mb-3">
                            <label for="description" class="form-label">Description</label><br>
                            <textarea class="form-control" name="description" id="description" rows="3"><?php if (isset($_REQUEST["description"])) {
                            echo test_input($_REQUEST['description']);
                        } ?></textarea>
                          </div> -->

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