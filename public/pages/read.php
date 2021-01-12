<?php
    require_once '../../private/initialize.php'; 


// Check existence of id parameter before processing further

if(isValidId('id')) {
    $id = trim($_GET["id"]);

    // MySQLi Query

    $sql  = "SELECT * ";
    $sql .= "FROM employees ";
    $sql .= "WHERE id = ?";
   
    // Prepare statement and bind parameters

    if($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $id);
      
        if($stmt->execute()) {
            $result = $stmt->get_result();
            
            if($result->num_rows == 1) {
                $row = $result->fetch_assoc(); /* Fetch result row as an associative array */
               
                // Retrieve individual field value

                $name = $row["name"];
                $address = $row["address"];
                $salary = $row["salary"];

            } else {
                redirectTo('../error.php');
            }

        } else {
            echo Errors::$invalidURL;
        }
    }
    $stmt->close();
    $mysqli->close();

} else {

    // URL doesn't contain id parameter. Redirect to error page
    
    redirectTo('../error.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> <?php echo "View Entry: " . $name ?> </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>  
    <div class="container">
        <div class="col-md-12 my-5">
        <h1><?php echo "Details: " . escaped($name)  ?></h1>
            <hr>
            <div class="form-group">
                <label class="font-weight-bold">Name</label>
                <p class="form-control-static">  
                    <?php echo escaped($name); ?>     
                </p>
            </div>
            <div class="form-group">
            <label class="font-weight-bold">Address</label>
                <p class="form-control-static">        
                    <?php echo escaped($address); ?>         
                </p>
            </div>
            <div class="form-group">
            <label class="font-weight-bold">Salary</label>
                <p class="form-control-static">       
                    <?php echo escaped($salary); ?>     
                </p>
            </div>
            <p><a href="../index.php" class="btn btn-primary">Back</a></p>
        </div>
    </div>
</body>
</html>