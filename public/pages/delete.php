<?php
    require_once '../../private/initialize.php'; 


// Process delete operation after confirmation

if(isset($_POST["id"]) && !empty($_POST["id"])){
    
    $id = trim($_POST["id"]);

    // SQL query

    $sql  = "DELETE FROM employees ";
    $sql .= "WHERE id = ? ";
    $sql .= "LIMIT 1";
    
    if($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $id);
        
        if($stmt->execute()) {
            redirectTo('../index.php');
        } else {
            echo Errors::$invalidURL;
        }
    }
    $stmt->close();
    $mysqli->close();

} else {

    // Check existence of ID parameter
    
    if(empty(trim($_GET["id"]))){
        redirectTo('../error.php');
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class='text-center'>
        <h1>Delete Record</h1>
        </div>
        <form method="POST">
            <div class="alert alert-danger text-center" role="alert">  
            <input type="hidden" name="id" value="<?php echo htmlspecialchars(trim($_GET["id"])); ?>"/>
                <p>Are you sure you want to delete this record?</p><br>
                <p>
                    <input type="submit" value="Yes" class="btn btn-danger">
                    <a href="../index.php" class="btn btn-default">No</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>