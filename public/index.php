<?php 
    require_once '../private/initialize.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Basic CRUD App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>
    <body class='my-5'>
        <div class="container">
            <div class="card "> 
                <div class="card-header ">
                    <strong>Find an entry</strong>
                    <a href="pages/create.php" class="btn btn-success btn-sm float-right text-uppercase">Add New Entry</a>
                </div>
                <div class="card-body"> 
                    <div class="col-sm-12"> 
                        <form method="POST">
                            <div class="row"> 
                                <div class="col-sm-4" > 
                                    <div class="form-group">
                                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name='search'>
                                    </div>
                                <div> 
                                </div class="">
                                    <button class="btn btn-primary" type="submit" name='submit-search'>Search</button>
                                    <a href="index.php" class="btn btn-danger"> Clear</a>
                                </div>
                            </div>  
                        </form>
                    </div>
                </div>
            </div>

           
            <?php

            // Check if search button was pressed, adjust Query accordingly 

            if(isset($_POST['submit-search'])) {
                $search = $mysqli->escape_string($_POST['search']);
                $query = "SELECT * FROM employees WHERE name LIKE '%$search%' ";
            } else {
                $query = 'SELECT * FROM employees';
            }
            $stmt = $mysqli->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>

            <h3 class="text-center text-dark m-5">Records</h3>
            <table class="table table-striped table-bordered table-hover" id="data-table">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>#</th>
                        <th>Name</th> 
                        <th>Address</th>
                        <th>Salary</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr> 
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['address']; ?></td>
                            <td><?= "$" . $row['salary']; ?></td>
                            <td class="text-center">
                                <a href='pages/read.php?id=<?= $row['id'] ?>' class="badge badge-primary p-2"> View </a> 
                                <a href='pages/update.php?id=<?= $row['id'] ?>' class="badge badge-info p-2">Edit</a>
                                <a href='pages/delete.php?id=<?= $row['id'] ?>'  class="badge badge-danger p-2">Delete</a> 
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        
                        <?php
                        $searchResult = $mysqli->query($query);
                        $numSearchResult = $searchResult->num_rows;
    
                        if($numSearchResult == 0): 
                        ?> 
                            <tr><td colspan="6">No Record(s) Found!</td></tr> 
                        <?php endif; ?>
                       
                </tbody>
            </table>
        </div>
    </body>
    <footer>
    </footer>
</html>


