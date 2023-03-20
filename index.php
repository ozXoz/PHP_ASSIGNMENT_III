<?php
//adding required files
include 'element/header.php';
include 'element/menu.php';
include 'functions.inc.php';



if (isset($_GET['item_number'])) {
    $item_number = $_GET['item_number'];
    $delete_status = deleteRecord($item_number);
}


if (isset($_GET['brand'])) {
    $brand_name = $_GET['brand'];
}

?>
    <div class="createProduct" style="margin-top: 20px; padding: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 bg-white" style="padding: 30px;">
                    <h3 class="text-center text-uppercase">Display products</h3>
                    <div class="mb-3">
                        <form method="GET">
                            <label for="brand" class="form-label">View TVs by brand:</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="brand" id="inlineRadio1" value="LG"
                                       required <?php if (isset($brand_name) && $brand_name == 'LG') {
                                    echo "checked";
                                } ?> >
                                <label class="form-check-label" for="LG">LG</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="brand" id="inlineRadio2"
                                       value="samsung" <?php if (isset($brand_name) && $brand_name == 'samsung') {
                                    echo "checked";
                                } ?> >
                                <label class="form-check-label" for="samsung">Samsung</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="brand" id="inlineRadio1"
                                       value="Sony" <?php if (isset($brand_name) && $brand_name == 'Sony') {
                                    echo "checked";
                                } ?> >
                                <label class="form-check-label" for="Sony">Sony</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="brand" id="inlineRadio2"
                                       value="Toshiba" <?php if (isset($brand_name) && $brand_name == 'Toshiba') {
                                    echo "checked";
                                } ?> >
                                <label class="form-check-label" for="Toshiba">Toshiba</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <button type="submit" class="btn btn-primary">View</button>
                            </div>
                        </form>
                    </div>

                    <hr>
                    <div class="table-responsive">
                        <!--                it will show the notification of delete-->
                        <?php
                        if (isset($delete_status)) {
                            echo $delete_status;
                        }
                        ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Item</th>
                                <th scope="col">Type</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Model</th>
                                <th scope="col">Size</th>
                                <th scope="col">Price</th>
                                <th scope="col" colspan="2" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            if (isset($_GET['srched_item_number'])) {
                                $srch_item_number = $_GET['srched_item_number'];
                                $found_array = searchItem($srch_item_number);

                                if (count($found_array) > 0) { ?>
                                    <tr>
                                        <td><?php echo $found_array['id']; ?></td>
                                        <td><?php echo $found_array['item_number']; ?></td>
                                        <td><?php echo $found_array['item_type']; ?></td>
                                        <td><?php echo $found_array['item_brand']; ?></td>
                                        <td><?php echo $found_array['item_model']; ?></td>
                                        <td><?php echo $found_array['item_size']; ?></td>
                                        <td><?php echo $found_array['item_price']; ?></td>
                                        <td>
                                            <a href='update_record.php?item_number=<?php echo $found_array['item_number']; ?>'
                                               class='btn btn-success'>Update</a></td>
                                        <td>
                                            <form action='index.php' method='GET'>
                                                <input type='hidden' name='item_number'
                                                       value='<?php echo $found_array['item_number']; ?>'>

                                                <button type='submit' onclick='myFunction()' class='btn btn-danger'>
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <th colspan="8" class="text-danger text-center">No Record found behind this item
                                            number
                                        </th>
                                    </tr>
                                <?php }
//to show only brand filter items
                            } else {
                                if (isset($_GET['brand'])) {
                                    $brand_name = $_GET['brand'];
                                    $found_brands_items = filterByBrand($brand_name);
                                    $found_brands_items = array_values($found_brands_items);
                                    if (count($found_brands_items) > 0) {
                                        for ($i = 0; $i < count($found_brands_items); $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $found_brands_items[$i][0]; ?></td>
                                                <td><?php echo $found_brands_items[$i][1]; ?></td>
                                                <td><?php echo $found_brands_items[$i][2]; ?></td>
                                                <td><?php echo $found_brands_items[$i][3]; ?></td>
                                                <td><?php echo $found_brands_items[$i][4]; ?></td>
                                                <td><?php echo $found_brands_items[$i][5]; ?></td>
                                                <td><?php echo $found_brands_items[$i][6]; ?></td>
                                                <td>
                                                    <a href='update_record.php?item_number=<?php echo $found_brands_items[$i][1]; ?>'
                                                       class='btn btn-success'>Update</a></td>
                                                <td>
                                                    <form action='index.php' method='GET'>
                                                        <input type='hidden' name='item_number'
                                                               value='<?php echo $found_brands_items[$i][1]; ?>'>

                                                        <button type='submit' onclick='myFunction()'
                                                                class='btn btn-danger'>Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <th colspan="8" class="text-danger text-center">No TVs found under this
                                                brand
                                            </th>
                                        </tr>
                                    <?php }
                                } else {
                                    RetrieveCsv();
                                }
                            }
                            ?>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<!--JS function to execute delete a record -->
    <script type="text/javascript">
        function myFunction(item_number) {
            if (confirm('Are you sure want to delete this record')) {
                document.getElementById('del_id').value = item_number;
                document.getElementById("del_form").submit();
            } else {
                console.log('No delete');
            }
        }
    </script>
<?php
include 'element/footer.php';
?>
<?php show_source(__file__)?>
<script src=https://my.gblearn.com/js/loadscript.js></script>

