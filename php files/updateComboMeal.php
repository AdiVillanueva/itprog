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
    <title>Update Combo Meal</title>
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
        <div class = "container-lg text-center">

                
                <h1 class = "display-4 mb-5">Select a Combo Meal to Update/Modify</h1>

                <div class = "col">
                    <div style="width:50%" class = "mx-auto">
                        <table class="table table-responsive-lg aligned-table delete-table">
                                <?php
                                     $comboQuery = mysqli_query($DBConnect, "SELECT * FROM food_combo ORDER BY comboID");


                                    while ($combo = mysqli_fetch_assoc($comboQuery)) {
                                        $id = $combo['comboID'];
                                        $name = $combo['comboName'];
                                        $discount = $combo['discount'];
                                        $isActive = $combo['isActive'];
                                        echo '
                                            <form action="modifyCombo.php" method="POST">
                                                <input type="hidden" name="comboID" value="'.$id.'">
                                                <input type="hidden" name="comboName" value="'.$name.'">
                                                <input type="hidden" name="discount" value="'.$discount.'">
                                                <input type="hidden" name="isActive" value="'.$isActive.'">
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