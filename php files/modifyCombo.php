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
    <title>Update/Modify Combo Meal</title>
    <?php include 'connect.php'; ?>

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main>
        <div class="container-lg mt-5">
        <?php
            $id = $_POST['comboID'];
            $name = $_POST['comboName'];
            $discount = $_POST['discount'];
            $isActive = $_POST['isActive'];

            $contentQuery = mysqli_query($conn, "SELECT * FROM combo_content WHERE comboID=$id");

            $combo_contents = [];
            while ($content = mysqli_fetch_assoc($contentQuery)) {
			{
				$content_id = $content['contentid'];
                $foodName = $content['foodName'];

				$content = array(
					'contentid' => $content_id,
					'foodName' => $foodName
				);
							
				array_push($combo_contents, $content);	 	 
			}
        }
        ?>
        
            
            <div class="container-lg title p-2 ">
                <h1 class="display-4 text-center">Modify <?php echo $name?></h1>
            </div>

            <div class = "container-lg mt-5 d-flex justify-content-center">
                <form action="updateComboDB.php" method="POST">

                    <input type="hidden" name="comboID" value="<?php echo $id; ?>">
                    <input type="hidden" name="mainID" value="<?php echo $combo_contents[0]['contentid']; ?>">
                    <input type="hidden" name="sideID" value="<?php echo $combo_contents[1]['contentid']; ?>">
                    <input type="hidden" name="drinkID" value="<?php echo $combo_contents[2]['contentid']; ?>">

                    <label class="form-label fw-bold" for="dishName">Combo Name:</label>
                    <input class ="form-control" type='text' name='comboName' value='<?php echo $name; ?>'required><br><br>

                    <label class="form-label fw-bold" for="mainDish">Main Dish:</label>
                    <select class="form-control" name="mainDish" class="dishCategory" required>
                    <?php

                    $mainQuery = mysqli_query($DBConnect, "SELECT dishID, dishName, dishPrice FROM dish WHERE dishCategory = 'Mains'");
                    while($fetchMains = mysqli_fetch_assoc($mainQuery)){
                            $foodName = $fetchMains['dishName'];
                            if ($foodName === $combo_contents[0]['foodName']) {
                                echo '<option value="' . $foodName . '" selected>' . $foodName . '</option>';
                            } else {
                                echo '<option value="' . $foodName . '">' . $foodName . '</option>';
                            }
                        }
                    ?>
                    </select>

                    <br><br>

                    
                    <label class="form-label fw-bold" for="sideDish">Side Dish:</label>
                    <select class="form-control" name="sideDish" class="dishCategory" required>
                    <?php

                    $sideQuery = mysqli_query($DBConnect, "SELECT dishID, dishName, dishPrice FROM dish WHERE dishCategory = 'Sides'");
                    while($fetchSides = mysqli_fetch_assoc($sideQuery)){
                            $foodName = $fetchSides['dishName'];
                            if ($foodName === $combo_contents[1]['foodName']) {
                                echo '<option value="' . $foodName . '" selected>' . $foodName . '</option>';
                            } else {
                                echo '<option value="' . $foodName . '">' . $foodName . '</option>';
                            }
                        }
                    ?>
                    </select>

                    <br><br>

                    
                    <label class="form-label fw-bold" for="drink">Side Dish:</label>
                    <select class="form-control" name="drink" class="dishCategory" required>
                    <?php

                    $drinkQuery = mysqli_query($DBConnect, "SELECT dishID, dishName, dishPrice FROM dish WHERE dishCategory = 'Drinks'");
                    while($fetchDrink = mysqli_fetch_assoc($drinkQuery)){
                            $foodName = $fetchDrink['dishName'];
                            if ($foodName === $combo_contents[2]['foodName']) {
                                echo '<option value="' . $foodName . '" selected>' . $foodName . '</option>';
                            } else {
                                echo '<option value="' . $foodName . '">' . $foodName . '</option>';
                            }
                        }
                    ?>
                    </select>

                    <br><br>

                    <label class="form-label fw-bold" for="discount">Combo Meal Discount (input in decimal):</label>
                    <input class="form-control" type='text' name='discount' pattern="^\d+(\.\d{1,2})?$" value="<?php echo $discount; ?>" required>
                    <br><br>

                    <label class="form-label fw-bold" for="isActive">Active:</label>
                    <select class="form-control" name="isActive" class="dishCategory" required>
                            <option value='Yes'    <?php if($isActive == 'Yes'){echo"selected";}      echo">Yes</option>"; ?>
							<option value='No'     <?php if($isActive == 'No'){ echo"selected";}      echo">No</option>";  ?>
                    </select>

                    <br><br>
                    
                    <div class="container d-flex justify-content-center">
                        <input class="btn btn-primary" type="Submit" value="Update Combo">
                    </div>


                    <br>
                </form>
                
                    <br>
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