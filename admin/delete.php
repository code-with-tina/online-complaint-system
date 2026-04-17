<?php
include 'connection.php';

$id = $_GET['id'];

$query = "DELETE FROM complaints WHERE id=$id";

if(mysqli_query($conn, $query)){
    header("Location: admin.php");
} else {
    echo "Error deleting record";
}
?>