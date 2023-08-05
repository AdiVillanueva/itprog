<?php

$added = [];
$not_added = [];

foreach ($xml->children() as $row) {
  $name = (string)$row->name;
  $category = $row->category;
  $price = $row->price; 

  $query = "SELECT * FROM dish WHERE LOWER(dishName) = LOWER('$name')";
  $result = mysqli_query($conn, $query);    

  $maxIDQuery = "SELECT MAX(dishID) AS max_value FROM dish";
  $res = mysqli_query($conn, $maxIDQuery);    
  $row = mysqli_fetch_assoc($res);
  $id = $row['max_value'] + 1;


  if (mysqli_num_rows($result) == 0) {
    $sql = "INSERT INTO dish(dishID, dishName, dishCategory, dishPrice, img) VALUES ('$id','$name','$category','$price','')";
    $result = mysqli_query($conn, $sql);

    $added[] = $name;

  }
  else{
    $not_added[] = $name;
  }

}
    //  if a dish is added
    if(!empty($added)){
      echo '
      <div class="container-lg title p-2 d-flex justify-content-center">
      <div class="row">
        <div class="col-12">
          <h1 class="display-4 text-center">Items Added Successfully!</h1>
        </div>
      </div>
      </div>
      ';
    }
    else{ //if none were added
      echo '
      <div class="container-lg title p-2 d-flex justify-content-center">
      <div class="row">
        <div class="col-12">
          <h1 class="display-4 text-center">Items already exist!</h1>
        </div>
      </div>
      </div>
      ';
    }

    // if some are added and some are not
    if(!empty($added) && !empty($not_added)){
?>      
        <script type="text/javascript">
        var notAddedArray = <?php echo json_encode($not_added); ?>;
        
        // Wait for the page to load before showing the alert
        window.onload = function() {
            alert("Dishes that already exists and not added: " + notAddedArray.join(", "));
        };
    </script>


<?php      
    }

?>