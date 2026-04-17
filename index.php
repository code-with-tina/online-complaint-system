<?php
include 'connection.php';

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $complaint = $_POST['complaint'];

    $sql = "INSERT INTO complaints (name, email, complaint) 
            VALUES ('$name', '$email', '$complaint')";

    if(mysqli_query($conn, $sql)){
        $success = "Complaint Submitted Successfully!";
    } else {
        $error = "Error submitting complaint!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Complaint Management System</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 400px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-submit {
            width: 100%;
            background: #4facfe;
            color: white;
        }

        .btn-submit:hover {
            background: #00c6ff;
        }
    </style>
</head>

<body>

<div class="form-box">
    <h2><i class="fa fa-comments"></i> Submit Complaint</h2>

    <?php if(isset($success)) { ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php } ?>

    <?php if(isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST">
        <input type="text" name="name" class="form-control mb-3" placeholder="Enter your name" required>
        
        <input type="email" name="email" class="form-control mb-3" placeholder="Enter your email" required>
        
        <textarea name="complaint" class="form-control mb-3" placeholder="Enter your complaint" rows="4" required></textarea>
        
        <button type="submit" name="submit" class="btn btn-submit">
            <i class="fa fa-paper-plane"></i> Submit Complaint
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="login.php">Admin Login</a>
    </div>
</div>

</body>
</html>