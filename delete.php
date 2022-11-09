<?php
include 'config.php';
if(isset($_GET['deleteid'])){
    $id = $_GET['deleteid'];
    if ($conn->query('DELETE FROM student WHERE s_id = '.$id) === TRUE){
        $message="Deleted successfuly!";
        header('Location: index.php?message='.$message);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}    
?>