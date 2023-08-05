<?php

    $userName = $_SESSION["getLogin"];

?>
<?php
        if($counter == 3){
            echo "<div class = 'col-12 mt-5 p-2 d-flex justify-content-center'>";
            echo "<h1 class = 'display-1 mt-5'>". "Combo already exists". "</h1>";
            echo "</div>";
            echo "<br><br>";
        }
        else{
            
            $comboQuery = "UPDATE food_combo SET comboName = '$newName', discount = '$discount', isActive = '$isActive' WHERE comboID = '$id'";
            $comboRes = mysqli_query($conn, $comboQuery);

            $mainUpdate = "UPDATE combo_content SET foodName = '$mainDish' WHERE contentid = '$mainID'";
            $mainRes = mysqli_query($conn, $mainUpdate);

            $sideUpdate = "UPDATE combo_content SET foodName = '$sideDish' WHERE contentid = '$sideID'";
            $sideRes = mysqli_query($conn, $sideUpdate);

            $drinkUpdate = "UPDATE combo_content SET foodName = '$drink' WHERE contentid = '$drinkID'";
            $drinkRes = mysqli_query($conn, $drinkUpdate);
        
            // Check if the update was successful
            if ($comboRes && $mainRes && $sideRes && $drinkRes) {
             ?>  
                    <h1 class="display-4 text-center mb-5">Update Successful!</h1>
                 <div class="container-lg mt-5">
                    <table class="table-responsive-lg table aligned-table">
                    <thead>
                        <tr class="table_title bg-dark"><td colspan="2"><h2 class=" text-light text-center fw-bold">Combo Meal Successfully Updated With The Following Values</h2></td></tr>
                    </thead>
                        <tr>
                            <td>Combo Name:</td>
                            <td ><?php echo $newName; ?></td>
                        </tr>
                        <tr>
                            <td>Main Dish:</td>
                            <td ><?php echo $mainDish; ?></td>
  
                        </tr>
                        <tr>
                            <td>Side Dish:</td>
                            <td ><?php echo $sideDish; ?></td>
                        </tr>
                        <tr>
                            <td>Drink:</td>
                            <td ><?php echo $drink; ?></td>
                        </tr>
                        <tr>
                            <td>Discount:</td>
                            <td ><?php echo $discount; ?></td>
                        </tr>
                        <tr>
                            <td>Is Active:</td>
                            <td ><?php echo $isActive; ?></td>
                        </tr>
            </table>    
            </div>
            <?php
                echo "<div class = 'row'>";
                echo "<div class = 'col-12 d-flex justify-content-center'>";
                    echo "<a href = 'updateComboMeal.php'";
                        echo "<button class ='btn btn-primary'>Return to Update Combo Meal</button>";
                    echo "</a>";
                    echo "&nbsp";
                    echo "&nbsp";
                    echo "&nbsp";
                    echo "<a href = 'main.php'";
                        echo "<button class ='btn btn-primary'>Back to Home</button>";
                    echo "</a>";
                echo "</div>";
            echo "</div>";
            } 
            else {
                echo "Error updating data: " . mysqli_error($conn);
            }
        }
    
?>