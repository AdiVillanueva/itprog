<!DOCTYPE html>
<?php
    require("connect.php");
    session_start();
    if(!isset($_SESSION["getLogin"])){
       header("location:login.php");
    } else {
        $userName = $_SESSION["getLogin"];

?>
<html>
    <head>
        <title>Update Database</title>

            <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="admin.css">
    </head>
    <?php include("navbar.php");?>
    <body>
        <main>
        <div class="container-lg d-flex justify-content-center">
            <div class="row">
                <div class="col">
                    <div style = "width:100%" class ="mx-auto ">

                        <?php
                            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                                $id = $_POST['comboID'];
                                $name = $_POST['comboName'];

                                $mainDish = $_POST['mainDish'];
                                $mainID = $_POST['mainID'];

                                $sideDish = $_POST['sideDish'];
                                $sideID = $_POST['sideID'];

                                $drink = $_POST['drink'];
                                $drinkID = $_POST['drinkID'];

                                $discount = $_POST['discount'];
                                $isActive = $_POST['isActive'];

                                $maxIDQuery = "SELECT MAX(comboID) AS max_value FROM combo_content";
                                $result = mysqli_query($conn, $maxIDQuery);    
                                $row = mysqli_fetch_assoc($result);
                                $holder = $row['max_value'];

                                $combo = [];
                                array_push($combo, $mainDish, $sideDish, $drink);
                                
                                $comboLength = count($combo);

                                $counter = 0;
                                 // check if combo already exists
                                for ($i = 1; $i <= $holder; $i++) {
                                    if($counter < 3){
                                        $counter = 0;
                                        if($i != $id){
                                            $sql = "SELECT * FROM combo_content WHERE comboID=$i";
                                            $result = mysqli_query($conn, $sql); 
                        
                                            while ($res = mysqli_fetch_assoc($result)) {
                                                for ($j = 0; $j < $comboLength; $j++) {
                                                    if ($combo[$j] == $res['foodName']) {
                                                    $counter++;
                                                    }
                                                }
                                            }
    
                                        }
                                    }
                                }

                                if($counter == 3){
                                    echo "<div class = 'col-12 mt-5 p-2 d-flex justify-content-center'>";
                                    echo "<h1 class = 'display-1 mt-5'>". "Combo already exists". "</h1>";
                                    echo "</div>";
                                    echo "<br><br>";
                                }
                                else{
                                    
                                    $comboQuery = "UPDATE food_combo SET comboName = '$name', discount = '$discount', isActive = '$isActive' WHERE comboID = '$id'";
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
                                                    <td ><?php echo $name; ?></td>
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
                                    } else {
                                        echo "Error updating data: " . mysqli_error($conn);
                                    }
                                }
                                
                                echo "<div class = 'col-12 d-flex justify-content-center'>";
                                echo "<a href = 'updateComboMeal.php'";
                                    echo "<button class ='btn btn-primary'>". "Update Another Combo Meal". "</button>";
                                echo "</a>";
                                echo "&nbsp";
                                echo "<a href = 'main.php'";
                                    echo "<button class ='btn btn-primary'>". "Back to Home". "</button>";
                                echo "</a>";
                            echo "</div>";
            
                            }
                        ?>
                    </div>
                </div>
            </div>

        </div>

        </main>



    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
    </body>
    <?php
        }
    ?>
</html>

