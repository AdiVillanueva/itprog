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
                                $origName = $_POST['origName'];
                                $newName = $_POST['comboName'];

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

                                if (strcasecmp($origName, $newName) === 0) {
                                    include 'updateCombo.php';
                                } 
                                else {
                                    $comboQuery = "SELECT * FROM food_combo WHERE comboName='$newName'";
                                    $comboRes = mysqli_query($conn, $comboQuery);
                                    if (mysqli_num_rows($comboRes) == 0) {
    
                                        include 'updateCombo.php';
                                    }
                                    else{
                                        echo "<div class = 'row'>";
                                        echo "<div class = 'col-12 d-flex justify-content-center mb-5'>";
                                            echo "<h1 class = 'display-1 text-center mt-5'>". "Combo Name Already Exists!". "</h1>";
                                        echo "</div>";
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
                                }
                    
                                
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

