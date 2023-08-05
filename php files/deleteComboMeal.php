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
    <title>Delete Dish</title>
    <?php include 'connect.php'; ?>

    <!--bootstrap cdn-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="admin.css">

    <script>
    function cancelFormSubmission() {
        event.preventDefault();
        window.location.href = "main.php";
    }
</script>

</head>
<body>
    <?php include 'navbar.php'; ?>

    <main>
        <div class="container-lg text-center">

                
                <?php
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        $id = $_POST['comboID'];
                        $name = $_POST['comboName'];

                        $contentQuery = "SELECT * FROM combo_content WHERE comboID = '$id'";
                        $contentResult = mysqli_query($conn, $contentQuery);

                        $combo = [];
                        while ($content = mysqli_fetch_assoc($contentResult)) {
                            $combo[] = $content['foodName'];
                        }
                        $comboLength = count($combo);
                        echo "<p class='fw-bold'>". "Delete  ".$name." ? </p>";

                        echo '
                            <form action="deleteComboDB.php" method="POST">
                                <input type="hidden" name="comboID" value="'.$id.'">
                                <input type="hidden" name="comboName" value="'.$name.'">';

                                echo "<div class = 'container-lg col-12 col-md-3  p-2 d-flex justify-content-center'>";
                        
                                echo "<table class = 'table table-respnosive-xl table-sm aligned-table table-light'>";
                                echo "<th>". "Combo Details". "</th>";
                                    for($i = 0; $i < $comboLength; $i++){
                                    echo "<tr>";
                                    echo "<td class ='fw-bold'>". "Dish: ". $combo[$i]. "</td>";
                                    echo "</tr>";
     
                                    }   
                        echo "</table>";
                        echo "</div>";
                        echo '        
                                <input style="width: 5%;" class="btn btn-primary m-2 p-2" type="submit" value="Yes">
                                <button type="button" style="width: 5%;" class="btn btn-primary m-2 p-2" onclick="cancelFormSubmission()">No</button>
                                <br>
                            </form>
                        ';

                        
                    }
                    else {
                ?>
                    
                    
                <h1 class="display-4 mb-5">Select a Combo Meal to Delete</h1>

                <div class="col">
                    <div style="width:50%" class="mx-auto">
                        <table class="table table-responsive-lg aligned-table delete-table">
                                <?php
                                     $comboQuery = mysqli_query($DBConnect, "SELECT * FROM food_combo ORDER BY comboID");

                                    while ($combo = mysqli_fetch_assoc($comboQuery)) {
                                        $id = $combo['comboID'];
                                        $name = $combo['comboName'];
                                        echo '
                                            <form action="deleteComboMeal.php" method="POST">
                                                <input type="hidden" name="comboID" value="'.$id.'">
                                                <input type="hidden" name="comboName" value="'.$name.'">
                                                <tr>
                                                    <td><input type="submit" value="' . $name . '" style="font-size: 16px; background-color: transparent; border: none;"></td>
                                                </tr>
                                            </form>
                                        ';
                                    }
                                ?>
                        </table>
                    </div>
                </div>
                                    <?php
                    }
                                    ?>
        </div>
    </main>

    <!--bootstrap cdn-->
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
