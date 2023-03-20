<?php
//adding required files
include 'element/header.php';
include 'element/menu.php';
include 'functions.inc.php';

//getting queryStrings parameters if user have any filter on displaying list
if (isset($_GET["item_number"])) {
  $item_number = $_GET["item_number"];
}
//getting queryStrings parameters if user have any filter on displaying list
if (isset($_POST['btn_update'])) {
  $update_status = updateRecord($_SERVER["REQUEST_METHOD"], $item_number);
}
?>
<div class="createProduct" style="margin-top: 20px; padding: 30px;">

  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3 bg-white" style="padding: 30px;">
        <form action="update_record.php?item_number=<?php echo $item_number; ?> " method="post">
          <h3 class="text-center text-uppercase">Insert a product</h3>
          <hr>
          <?php 
          $row = get_single_row($item_number);

          //var_dump($row);
          if(!$row) {  ?>
            <div class="alert alert-danger">
              <strong>Sorry!</strong> No record Found or being removed.
            </div>
          <?php }
//showing the update notification
          if (isset($update_status)) {
            echo $update_status;
          }
          ?>
          <div class="mb-3">
            <label for="type" class="form-label">Type <span style="color: red;">*</span></label>
            <select class="form-select" name="type" aria-label="Default select example" required>
              <option value="" selected>Select One</option>
              <option <?php if (isset($row) && $row['Type']=='LCD') { echo "selected"; } ?> value="LCD">LCD</option>
              <option <?php if (isset($row) && $row['Type']=='LED') { echo "selected"; } ?> value="LED">LED</option>
              <option <?php if (isset($row) && $row['Type']=='OLED') { echo "selected"; } ?> value="OLED">OLED</option>
              <option <?php if (isset($row) && $row['Type']=='QLED') { echo "selected"; } ?> value="QLED">QLED</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="brand" class="form-label">Brnad <span style="color: red;">*</span></label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="brand" id="inlineRadio1" value="LG" required <?php if (isset($row) && $row['Brand'] =='LG' ) { echo "checked"; } ?> >
              <label class="form-check-label" for="LG">LG</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="brand" id="inlineRadio2" value="samsung" <?php if (isset($row) && $row['Brand'] =='samsung' ) { echo "checked"; } ?> >
              <label class="form-check-label" for="samsung">Samsung</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="brand" id="inlineRadio1" value="Sony" <?php if (isset($row) && $row['Brand'] =='Sony' ) { echo "checked"; } ?> >
              <label class="form-check-label" for="Sony">Sony</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="brand" id="inlineRadio2" value="Toshiba" <?php if (isset($row) && $row['Brand'] =='Toshiba' ) { echo "checked"; } ?> >
              <label class="form-check-label" for="Toshiba">Toshiba</label>
            </div>
          </div>
          <div class="mb-3">
            <label for="Model" class="form-label">Model <span style="color: red;">*</span></label><br>
            <input type="text" class="form-control" name="model" id="model" aria-describedby="emailHelp" value="<?php if(isset($row)) echo $row['Model'] ; ?>" required>
          </div>

          <div class="mb-3">
            <label for="size" class="form-label">Size <span style="color: red;">*</span></label><br>
            <input type="number" class="form-control" name="size" id="size" aria-describedby="emailHelp" value="<?php if(isset($row)) echo $row['Size'] ; ?>" required>
          </div>

          <div class="mb-3">
            <label for="price" class="form-label">Price <span style="color: red;">*</span></label><br>
            <input type="number" class="form-control" name="price" id="price" aria-describedby="emailHelp" value="<?php if(isset($row)) echo $row['Price'] ; ?>" step="0.01" required>
          </div>

          <!-- <div class="mb-3">
            <label for="sale" class="form-label">Sale</label><br>
            <input type="text" class="form-control" name="sale" id="sale" aria-describedby="emailHelp" value="<?php if(isset($_REQUEST["sale"])) echo test_input($_REQUEST['sale']); ?>">
          </div> -->


          <!-- <div class="mb-3">
            <label for="description" class="form-label">Description</label><br>
            <textarea class="form-control" name="description" id="description" rows="3"><?php if(isset($_REQUEST["description"])) echo test_input($_REQUEST['description']); ?></textarea>
          </div> -->

          <button type="submit" name="btn_update" class="btn btn-success">Update</button>
        </form>
      </div>    
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>


<script type="text/javascript">
  myFunction() {
    alert("hello testing!");
  }  
</script>
<?php
include 'element/footer.php';
?>