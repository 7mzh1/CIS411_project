<!DOCTYPE html>
<html>
    <head>
        <title>home page</title>
        <link rel="stylesheet" href="css.css"/>
    </head>
    <body>
        <?php

            include 'config.php';
            include 'functions.php';

            $isValid = true; 
		    $errors = ""; 
            $success = "";
            $message = "";
            if(isset($_GET['message'])){
                $message=$_GET['message'];
            }
            if ($_SERVER["REQUEST_METHOD"] == 'POST') {

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
                    if ($conn->query("INSERT INTO `student` (`s_id`, `s_name`, `s_specialize`, `s_email`)
                    VALUES ('". $student_id ."', '" . $student_name  . "',  '" . $student_specialize  . "'
                    , '" . $student_email  . "')") === TRUE) {
                        $success = "Added successfuly!";
                        header("Refresh: 4; url=index.php");
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }    
        ?>
        <div id="main">
            <div id="left">
                <div id="side-nav">
                    <div id="head">
                        <h1>Admin</h1>
                        <p class="error"><?php echo $errors; ?></p>
                        <p class="success" id="message"><?php echo $success; echo $message; ?></p>
                    </div>
                    <form action="index.php" method="post">
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
                            <input id="add" type="submit" name="submet" value="Add">
                        </div>
                    </form>
                </div>
            </div>
            <div id="right">
                <div>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Specialize</th>
                            <th>E-mail</th>
                            <th>Operations</th>
                            <th>Add to google sheet</th>
                        </tr>
                            <?php
                                $sql = 'SELECT * FROM student ';
                                $result = $conn->query($sql);
                                if($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row["s_id"] . "</td><td>" 
                                        . $row["s_name"] . "</td><td>" . $row["s_specialize"] . "</td><td>" . $row["s_email"] . "</td>
                                        <td><button id='update'><a href='update.php?edit=".$row["s_id"]."'>Update</a></button>
                                        <button id='delete'><a href='delete.php?deleteid=".$row["s_id"]."'>Delete</a></button></td>
                                        <td><button id='update'><a href='sheet.php?sid=".$row["s_id"]."&name=".$row["s_name"]."&sp=".$row["s_specialize"]."&email=".$row["s_email"]."'>Add</a></button></td></tr>";
                                    }
                                }
                            ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
                    