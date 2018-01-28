<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
		
        $name_err = "Upišite Ime i Prezime.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zšđčćžA-ZŠĐČĆŽ'-.\s ]+$/")))){
		
        $name_err = 'Upišite ispravno Ime i Prezime.';
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = 'Upišite adresu.';     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Molim, upišite iznos plaće.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = 'Molim, upišite ispravan iznos plaće.';
    } else{
        $salary = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <title>Kreiranje zapisa</title>
</head>
<body>
    <div>
        <h2>Kreiranje zapisa</h2>
    </div>
    <p>Molim popunite obrazac i potvrdite dodavanje novog zaposlenika u bazu.</p>
    <form method="post">
        <div>
            <label>Ime i Prezime</label>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <span><?php echo $name_err;?></span>
        </div>
        <div>
            <label>Adresa</label>
            <textarea name="address"><?php echo $address; ?></textarea>
            <span><?php echo $address_err;?></span>
        </div>
        <div>
            <label>Visina plaće</label>
            <input type="text" name="salary" value="<?php echo $salary; ?>">
            <span><?php echo $salary_err;?></span>
        </div><br>
        <input type="Submit"  value="Potvrdi">
        <a id="button" href="index.php" >Odustani</a>
    </form>

</body>
</html>
