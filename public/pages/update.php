<?php
    require_once '../../private/initialize.php'; 

 
// Processing form data when form is submitted

if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    
    // Sanitize input, validate data before inserting into DB

    $name = $entry->validateName(sanitizedString('name'));
    $address = $entry->validateAddress(sanitizedString('address'));
    $salary = $entry->validateSalary(sanitizedString('salary'));
    
    // Check for input errors

    if ($name && $address && $salary) {

        // MySQLi Query

        $sql  = "UPDATE employees ";
        $sql .= "SET name=?, address=?, salary=? ";
        $sql .= "WHERE id=?";

        // Prepare statement, bind parameters

        if($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sssi", $name, $address, $salary, $id);

            if($stmt->execute()){
                redirectTo('../index.php');
            } else {
                echo Errors::$invalidURL;
            }
        }
        $stmt->close();
    }
    $mysqli->close();

} else {

    // Check existence of id parameter before processing further

    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

        // Get URL parameter

        $id =  trim($_GET["id"]);
        
        // Prepare a select statement

        $sql  = "SELECT * ";
        $sql .= "FROM employees ";
        $sql .= "WHERE id = ? ";
        $sql .= "LIMIT 1";

        // Prepare statement, bind parameters

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters

            $stmt->bind_param("i", $id);
            
            // Attempt to execute the prepared statement

            if($stmt->execute()) {
                $result = $stmt->get_result();
                
                if($result->num_rows == 1) {

                    // Fetch result row as an associative array.

                    $row = $result->fetch_assoc();
                    
                    // Retrieve individual field value from associative array

                    $name = $row["name"];
                    $address = $row["address"];
                    $salary = $row["salary"];

                } else { 
                    redirectTo('../error.php'); // URL doesn't contain valid ID
                }
            } else {
                echo Errors::$invalidURL;
            }
        }
        $stmt->close();
        $mysqli->close();

    }  else {
        redirectTo('../error.php'); // URL doesn't contain ID
    }
}
?>
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-5">
                <h2>Update Record</h2>
                <hr>
                <form method="POST">
                        <p>
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <?php echo $entry->getError(Errors::$invalidName); ?>
                        </p>
                        <p>
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <?php echo $entry->getError(Errors::$invalidAddress); ?>
                        </p>
                        <p>
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <?php echo $entry->getError(Errors::$invalidSalary); ?>      
                        </p>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>        
    </div>
</body>
</html>