<?php include '../db.php';

$id = $_GET['id'];

if(isset($_POST['update'])){
    $status = $_POST['status'];

    $sql = "UPDATE complaints SET status='$status' WHERE id=$id";

    if($conn->query($sql)){
        header("Location: admin.php");
    }
}
?>

<form method="POST">
    <h3>Update Status</h3>
    <select name="status">
        <option>Pending</option>
        <option>In Progress</option>
        <option>Resolved</option>
    </select>
    <button type="submit" name="update">Update</button>
</form>