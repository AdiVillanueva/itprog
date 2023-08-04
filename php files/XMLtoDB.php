<?php

foreach ($xml->children() as $row) {
  $name = $row->name;
  $category = $row->category;
  $price = $row->price; 
  $img = $row->img; 

  $query = "SELECT * FROM dish WHERE LOWER(dishName) = LOWER('$name')";
  $result = mysqli_query($conn, $query);    

  $maxIDQuery = "SELECT MAX(dishID) AS max_value FROM dish";
  $res = mysqli_query($conn, $maxIDQuery);    
  $row = mysqli_fetch_assoc($res);
  $id = $row['max_value'] + 1;

  $added = array();
  $not_added = array();
  

  if (mysqli_num_rows($result) == 0) {
    $sql = "INSERT INTO dish(dishID, dishName, dishCategory, dishPrice, img) VALUES ('" . $id . "','" . $name . "','" . $category . "','" . $price . "','" . $img . "')";
    $result = mysqli_query($conn, $sql);

  }
  else{
    
  }

}
echo '
<div class="container-lg title p-2 d-flex justify-content-center">
<div class="row">
  <div class="col-12">
    <h1 class="display-4 text-center">Item Added Successfully!</h1>
  </div>
</div>
</div>
';

echo "<div class = 'col-12 d-flex justify-content-center'>";
          echo "<a href = 'addDish.php'";
              echo "<button class ='btn btn-primary'>". "Add Another Dish". "</button>";
          echo "</a>";
          echo "&nbsp";
          echo "<a href = 'main.php'";
              echo "<button class ='btn btn-primary'>". "Back to Home". "</button>";
          echo "</a>";
      echo "</div>";
  echo "</div>";
?>