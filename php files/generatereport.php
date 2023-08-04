<?php
    require("connect.php");
    session_start();
    if(!isset($_SESSION["getLogin"])){
       header("location:login.php");
    } else {
        $userName = $_SESSION["getLogin"];

?>
<!DOCTYPE html>
<html>
    <?php include("navbar.php");?>
<head>
    <title>Generate Report</title>
        <!--bootstrap cdn-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
    <main>

    <div class="container-lg title mt-5 ">
        <h1 class="display-4 text-center">Generate Report</h1>
    </div>

    <div class = "container-lg mt-5 d-flex justify-content-center">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label  class = "form-label fw-bold" for="xmlfile">Select Date:</label>
        <input class="form-control" type="date"  name="date" value="<?php if(!isset($_POST['date'])){ echo date('Y-m-d');} else{ echo $_POST['date']; } ?>" required />

        <div class="col d-flex justify-content-center">
                <input type="Submit" value="Generate Report" class="btn btn-primary mt-3">
        </div>
    </form>
    </div>

    <?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){
			  $date = $_POST['date'];
			  date_default_timezone_set('Asia/Manila');
			  $timestamp = date("Y-m-d h:i:sa");

					$sql = "
                    SELECT
                    SUM(total_amount) AS total_amount,
                    SUM(total_dishes) AS total_dishes,
                    SUM(total_discount) AS total_discount
                    FROM
                    (
                        SELECT
                        o.orderID,
                        SUM(o.totalPrice) AS total_amount,
                        SUM(o.discountedPrice) AS total_discount,
                        (SELECT SUM(quantity) FROM order_item oi WHERE oi.orderID = o.orderID) AS total_dishes
                         FROM
                         orders o
                         WHERE
                         DATE(o.orderedAt) = '$date'
                         GROUP BY
                         o.orderID
                    ) AS subquery;";

					$records = mysqli_query($DBConnect, $sql) or die(mysqli_error($DBConnect));

                    while($results = mysqli_fetch_array($records))
					{
                        $total_amount = $results['total_amount']; 

                        if(isset($results['total_discount'])){
                            $total_discount = $results['total_discount'];
                        }
                        else{
                            $total_discount = 0;
                        }
                        
                        $total_dishes = $results['total_dishes'];
                    }
			
					
	?>

        <?php
            if (isset($total_amount)) {
        ?>
            <div class="container-lg mt-5">
                <table class="table-responsive-lg table aligned-table">
                <thead>
                    <tr class="table_title bg-dark"><td colspan="2"><h2 class=" text-light text-center fw-bold">Report for <?php echo "$date";?></h2></td></tr>
                </thead>

                    <tr>
                        <td>Total Amount</td>
                        <td ><?php echo $total_amount; ?></td>
                    </tr>
                    <tr>
                        <td>Total Discount</td>
                        <td ><?php echo $total_discount; ?></td>
                      
                    </tr>
                    <tr>
                        <td>Total Dishes Sold</td>
                        <td ><?php echo $total_dishes; ?></td>
                    </tr>
                   
				<?php
                
                $folderPath = "reports"; 

                // if reports folder does not yet exist
                if (!is_dir($folderPath)) {
                    mkdir($folderPath, 0777, true); 
                }
                        $filename = 'report_'.$date;
                        $path = $folderPath . "/" . $filename;
						$reports = new SimpleXMLElement('<report></report>');
                
                        $reports->addChild('total_amount', $total_amount);
                        $reports->addChild('total_discount', $total_discount);
                        $reports->addChild('total_dishes', $total_dishes);
                        $reports->asXML($path);
                
					

                    
            
				?>
                </table>
            </div>
            
            <div class = 'container-lg mt-5 text-center justify-content-center'>
            <?php
                echo "An XML file named ".$filename." has been generated for this report.";
                }
                else{
                    echo "<div class = 'container-lg mt-5 text-center justify-content-center'>";
                    echo "There are no orders on this date";
                    echo "</div>";

                }
            ?>
                <div class = 'container-lg mt-2 text-center justify-content-center'>
					<h5>*END OF REPORT*</h5>
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