<?php
include 'config.php';
include 'functions.php';
?>
<!DOCTYPE html>
<http>
    <head>
        <link rel="stylesheet" href="css.css"/>
    </head>
    <body>
        <?php

            $old_id = $_GET['edit'];
            $isValid = true; 
		    $errors = ""; 
            $success = "";
            if(isset($_POST['submit'])&&isset($_GET['edit'])){

                $student_name = test_input($_POST["student_name"]);
                $student_id = test_input($_POST["student_id"]);
                $student_specialize = test_input($_POST["student_specialize"]);
                $student_email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

                if (empty($student_name)) { 
                    $isValid = false;
                    $errors = $errors . "<br />" . " You must enter a student name.";
                }else if(!preg_match("/^[a-zA-Z]/",$student_name)){
                    $isValid = false;
                    $errors = $errors . "<br />" . " Name should contain only letters.";
                }

                if (empty($student_id)) { 
                    $isValid = false;
                    $errors = $errors . "<br />" . " You must enter a student id.";
                }else if(!preg_match("/^[0-9]/",$student_id)){
                    $isValid = false;
                    $errors = $errors . "<br />" . " ID should contain only numbers.";
                }

                if (empty($student_specialize)) { 
                    $isValid = false;
                    $errors = $errors . "<br />" . "You must enter a specialize.";
                }
                
                if (empty($student_email)) { 
                    $isValid = false;
                    $errors = $errors . "<br />" . "You must enter an E-mail.";
                } else if(!filter_var($student_email, FILTER_VALIDATE_EMAIL)){
                    $isValid = false;
                    $errors = $errors . "<br />" . "You must enter a valid E-mail.";
                }
                
                if ($isValid) {                        
                    if ($conn->query("UPDATE student SET s_id= '".$student_id."',
                    s_name= '".$student_name."', s_specialize= '".$student_specialize."', s_email= '"
                    .$student_email."' WHERE s_id =".$old_id) === TRUE) {
                        $message="Updated successfuly!";
                        header('Location: index.php?message='.$message);
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }  
        ?>
        <div class="center">
            <p class="error"><?php echo $errors; ?></p>
        </div>
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
            <div>
                <label for="student_name">Student Name</label>
                <input type="text" name="student_name">
            </div>
            <div>
                <label for="student_id">Student ID</label>
                <input type="text" name="student_id">
            </div>
            <div>
                <label for="student_specialize">Student Specialize</label>
                <input type="text" name="student_specialize">
            </div>
            <div>
                <label for="email">Student E-mail</label>
                <input type="text" name="email">
            </div>
            <div>
                <input id="add" type="submit" name="submit" value="update">
            </div>
        </form>
    </body>
</html>