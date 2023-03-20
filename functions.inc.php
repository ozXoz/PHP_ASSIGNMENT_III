<?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
//adding a record in csv
function addRecordToCsv($form_data) {
  $message = "";

  if ($form_data == "POST") {
    //getting form data
    $p_type = test_input($_REQUEST['type']);
    $p_model = test_input($_REQUEST['model']);
    $p_size = test_input($_REQUEST['size']);
    $p_price = test_input($_REQUEST['price']);

    // $p_sale = test_input($_REQUEST['sale']);
    // $p_description = test_input($_REQUEST['description']);

    if (isset($_REQUEST['brand'])) {
      $p_brand = test_input($_REQUEST['brand']);
    }

    //handling errors
    if ($p_type == "") {
      $message .= "<p><label class='text-danger'>Please select product type.</label></p>";
    } 
    if ($p_brand == "") {
      $message .= "<p><label class='text-danger'>Please select product brand.</label></p>";
    }
    if ($p_model == "") {
      $message .= "<p><label class='text-danger'>Product model field is required.</label></p>";
    }
    if ($p_size == "") {
      $message .= "<p><label class='text-danger'>Product size is required</label></p>";
    }
    if ($p_price == "") {
      $message .= "<p><label class='text-danger'>Product price is required</label></p>";
    }


    if ($message != "") {
      return $message;
    } else {
      //saving data into csv
      $file_open = fopen("product_sheet.csv", "a");
      $no_of_rows = count(file("product_sheet.csv"));

      if ($no_of_rows > 1) {
        $no_of_rows = ($no_of_rows-1)+1;
      }

      $five_digit_random_number = random_int(10000, 99999);

      $form_fields = array('#'=>$no_of_rows, 'Item_#'=>$five_digit_random_number, 'Type'=>$p_type, 'Brand'=>$p_brand, 'Model'=>$p_model, 'Size'=>$p_size, 'Price'=>$p_price );

      fputcsv($file_open, $form_fields);
      $message = '<div class="alert alert-success">
      <strong>Success!</strong> Product data is saved into csv file.
      </div>';

      $p_type = ''; $p_model = ''; $p_size = ''; $p_price = ''; 
      return $message;
    }
  }
}
//get CSV data
function RetrieveCsv() {

  $csv_file_handler = fopen("product_sheet.csv", "r");

  $skip_values = array('#','Item_#', 'Type', 'Brand', 'Model', 'Size', 'Price', 'Sale Price');

  while (($line = fgetcsv($csv_file_handler)) !== false) {
    $counter = 0;
    echo "<tr>";
    foreach ($line as $key => $cell) {

      $price_color = "";
      if (in_array($cell, $skip_values)) {
        continue;
      } 

      //replacing sales price with original price
      if ($line[7]>0) {
        $line[6] = $line[7];
        $price_color = "class='text-danger'";
      }

      $counter ++;

      //skiping sales price column
      if ($key == 7) {
        continue;
      }
      
      echo "<td ".$price_color." >" . htmlspecialchars($line[$key]) . "</td>";
    }

    // assigning item_number to update data
    if ($counter>0) {
      echo "<td><a href='update_record.php?item_number=".$line[1]."' class='btn btn-success'>Update</a></td>
      <td>
      <form id='del_form' action='index.php' method='GET'>
      <input type='hidden' name='item_number' id='del_id' value='".$line[1]."'>
      
      <button type='button' onclick='myFunction(".$line[1].")' class='btn btn-danger'>Delete</button>
      </td>
      </form>";
    }

    echo "</tr>\n";
  }
  fclose($csv_file_handler);
}
//search out the single record
function get_single_row($item_number) {
  $found_row = array();

  //retrieving single row data
  $fp = fopen('product_sheet.csv', 'r');
  while(false !== ($data = fgetcsv($fp, 0, ','))) {

    for ($i=0; $i <count($data) ; $i++) {
      if ($data[$i] == $item_number) {
        $found_row = ['#'=>$data[$i-1], 'Item_#'=>$data[$i], 'Type'=>$data[$i+1], 'Brand'=>$data[$i+2], 'Model'=>$data[$i+3], 'Size'=>$data[$i+4], 'Price'=>$data[$i+5]];
      }
    }
  }
  return $found_row;
  fclose($fp);
}
//update the single record
function updateRecord($form_data, $item_number) {

  //handling form data
  $message = "";

  if ($form_data == "POST") {
    //getting form data
    $p_type = test_input($_REQUEST['type']);
    $p_model = test_input($_REQUEST['model']);
    $p_size = test_input($_REQUEST['size']);
    $p_price = test_input($_REQUEST['price']);
    
    // $p_sale = test_input($_REQUEST['sale']);
    // $p_description = test_input($_REQUEST['description']);

    if (isset($_REQUEST['brand'])) {
      $p_brand = test_input($_REQUEST['brand']);
    }

    //handling errors
    if ($p_type == "") {
      $message .= "<p><label class='text-danger'>Please select product type.</label></p>";
    } 
    if ($p_brand == "") {
      $message .= "<p><label class='text-danger'>Please select product brand.</label></p>";
    }
    if ($p_model == "") {
      $message .= "<p><label class='text-danger'>Product model field is required.</label></p>";
    }
    if ($p_size == "") {
      $message .= "<p><label class='text-danger'>Product size is required</label></p>";
    }
    if ($p_price == "") {
      $message .= "<p><label class='text-danger'>Product price is required</label></p>";
    }

    if ($message != "") {
      return $message;
    } else {
      // reading and updating here
      $newdata = [];
      $single_array = array();

      //reading CSV
      $handle = fopen("product_sheet.csv", "r");
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

        $skip_values = array('#','Item_#', 'Type', 'Brand', 'Model', 'Size', 'Price');

        for ($i=0; $i <count($data) ; $i++) {

          //skiping first row containing headings
          if (in_array($data[$i], $skip_values)) {
            continue;
          }

          // will push all value in single array
          array_push($single_array, $data[$i]);

          if ($data[$i] == $item_number) {
            //picking up the row to update
            $id = $data[$i-1];
            $item_number = $data[$i];

            $type = $data[$i+1];
            $brand = $data[$i+2];
            $model = $data[$i+3];
            $size = $data[$i+4];
            $price = $data[$i+5];


            $type = $p_type;
            $brand = $p_brand;
            $model = $p_model;
            $size = $p_size;
            $price = $p_price;

            // to update record
            $single_array = array($id, $item_number, $type, $brand, $model, $size, $price);

            //to delete row
            //$single_array = array();
            break;
          }
        }
        //pussing single row to multi array.
        array_push($newdata ,$single_array);
        $single_array = array();  
      }

      $newdata = array_filter($newdata);

      //Writing CSV Again
      $fp = fopen('product_sheet.csv', 'w');    
      foreach ($newdata as $rows) {
        $udpate_status = fputcsv($fp, $rows);
      }
      fclose($fp);

      if ($udpate_status) {
        $message = "<div class='alert alert-success'>
        <strong>Success!</strong> Your record is updated.
        </div>";
      } else {
        $message = "<div class='alert alert-danger'>
        <strong>Sorry!</strong> Your record is not updated.
        </div>";
      }
      return $message;
    }
  }
}
//deleting a single record
function deleteRecord($item_number) {

  $message = '';
  $newdata = [];
  $single_array = array();

  // reading CSV
  $handle = fopen("product_sheet.csv", "r");
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

    $skip_values = array('#','Item_#', 'Type', 'Brand', 'Model', 'Size', 'Price');


    for ($i=0; $i <count($data) ; $i++) {

      //skiping first row containing headings
      if (in_array($data[$i], $skip_values)) {
        continue;
      }

      // will push all value in single array
      array_push($single_array, $data[$i]);

      //looking for this item number
      if ($data[$i] == $item_number) {
        //to delete row
        $single_array = array();
        break;
      }
    }
    // pussing single row to multi array.
    array_push($newdata ,$single_array);
    $single_array = array();  
  }

  $newdata = array_filter($newdata);

  // Writing CSV Again
  $fp = fopen('product_sheet.csv', 'w');    
  foreach ($newdata as $rows) {
    $delete_status = fputcsv($fp, $rows);
  }
  fclose($fp);

  if ($delete_status) {
    $message = "<div class='alert alert-success'>
    <strong>Success!</strong> Your record is deleted successfully.
    </div>";
  } else {
    $message = "<div class='alert alert-danger'>
    <strong>Error!</strong> Your record is not deleted.
    </div>";
  }
  return $message;
}
//searching a single record
function searchItem($item_number) {
  $found_array = array();

  // reading CSV
  $handle = fopen("product_sheet.csv", "r");
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

    $skip_values = array('#','Item_#', 'Type', 'Brand', 'Model', 'Size', 'Price');


    for ($i=0; $i <count($data) ; $i++) {

      //skiping first row containing headings
      if (in_array($data[$i], $skip_values)) {
        continue;
      }

      //looking for this item number
      if ($data[$i] == $item_number) {

        //picking up the row to display
        $id = $data[$i-1];
        $item_number = $data[$i];

        $type = $data[$i+1];
        $brand = $data[$i+2];
        $model = $data[$i+3];
        $size = $data[$i+4];
        $price = $data[$i+5];

        $found_array = array('id'=>$id, 'item_number'=>$item_number, 'item_type'=>$type, 'item_brand'=>$brand, 'item_model'=>$model, 'item_size'=>$size, 'item_price'=>$price);
        break;
      }
    }  
  }

  return $found_array;
}

function filterByBrand($brand_name) {

  $found_brands = [];
  $single_array = array();

  //reading CSV
  $handle = fopen("product_sheet.csv", "r");
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

    $skip_values = array('#','Item_#', 'Type', 'Brand', 'Model', 'Size', 'Price');

    for ($i=0; $i <count($data) ; $i++) {

      //skiping first row containing headings
      if (in_array($data[$i], $skip_values)) {
        continue;
      }

      //filtering brand here
      if ($data[$i] == $brand_name) {
        $id = $data[$i-3];
        $item_number = $data[$i-2];
        $type = $data[$i+1];

        $brand = $data[$i];

        $model = $data[$i+1];
        $size = $data[$i+2];
        $price = $data[$i+3];

        $single_array = array($id, $item_number, $type, $brand, $model, $size, $price);
        break;
      }
      continue;
    }
    //pussing single row to multi array.
    array_push($found_brands ,$single_array);
    $single_array = array();  
  }

  //array containing brand data
  $found_brands = array_filter($found_brands);
  return $found_brands;
}


function exportCsv() {

}

function importCsv($file) {

  $message = "";

  if ($_FILES['filename']['name']) {
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    if(in_array($_FILES['filename']['type'],$csvMimes)) {

        //deleting old file
      if (file_exists("product_sheet.csv")) {
        unlink('product_sheet.csv');
      }    

        // saving the new file
      $file_name = $_FILES['filename']['name'];
      $temp_loc = $_FILES['filename']['tmp_name'];
      $new_file_name = "product_sheet.csv";
      $file_destinatination = $new_file_name;
      $save_status = move_uploaded_file($temp_loc, $file_destinatination);  

      if ($save_status) {
        $message = "<div class='alert alert-success'>
        <strong>Success!</strong> Your file is being replaced;
        </div>";
      } 
    } else {
     echo "Invalid File";
     $message = "<div class='alert alert-danger'>
     <strong>Error!</strong> Invalid Format.
     </div>";
   }
 } else {
  $message = "<div class='alert alert-danger'>
  <strong>Error!</strong> No file is uploaded.
  </div>";

}  
return $message;  
}
?>