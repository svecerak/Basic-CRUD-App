<?php
    require_once '../../private/initialize.php'; 


if(isPostRequest()) {

    // Sanitize and validate input data

    $name = $entry->validateName(sanitizedString('name'));
    $address = $entry->validateAddress(sanitizedString('address'));
    $salary = $entry->validateSalary(sanitizedString('salary'));
    
 // Check for input errors before inserting in database

    if($name && $address && $salary) {    

        // MySQLi Query

        $sql  = "INSERT INTO employees ";
        $sql .= "(name, address, salary) ";
        $sql .= "VALUES (?, ?, ?)";

        // Prepare statement and bind paramaters

        if($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sss", $name, $address, $salary);

            if($stmt->execute()) {
                $new_id = $stmt->insert_id; // Retrieve id of latest insert statement 
                redirectTo('read.php?id=' . $new_id);
            } else {
                echo Errors::$invalidURL;
            }
        }
        $stmt->close();
    } 
    $mysqli->close();
} 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <hr>
                    <form action="create.php" method="POST">
                        <p>
                            <label>Name</label>
                            <input name="name" type="text" placeholder="Your name" class="form-control" value="<?php getInputValue('name')?>" required>
                            <p style="color:red;"><?php echo $entry->getError(Errors::$invalidName); ?></p>
                            <p style="color:red;"><?php echo $entry->getError(Errors::$emptyName); ?></p>
                        </p>
                        
                        <p>
                            <label>Address</label>
                            <input name="address" placeholder="Your address" class="form-control" value="<?php getInputValue('address') ?>" required>
                            <p style="color:red;"><?php echo $entry->getError(Errors::$invalidAddress); ?></p>
                            <p style="color:red;"><?php echo $entry->getError(Errors::$emptyAddress); ?></p>
                        </p>           

                        <p>
                            <label>Salary</label>
                            <input name="salary" type="text" placeholder="Salary" class="form-control" value="<?php getInputValue('salary') ?>" required>
                            <p style="color:red;"><?php echo $entry->getError(Errors::$invalidSalary); ?></p>      
                            <p style="color:red;"><?php echo $entry->getError(Errors::$emptySalary); ?></p>      
                        </p>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
