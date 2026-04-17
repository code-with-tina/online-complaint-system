<?php
include 'connection.php';

$id = $_GET['id'];
$status = $_GET['status'];

$query = "UPDATE complaints SET status='$status' WHERE id=$id";

if(mysqli_query($conn, $query)){
    header("Location: admin.php");
} else {
    echo "Error updating status";
}
?>