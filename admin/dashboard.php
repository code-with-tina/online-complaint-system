<?php
session_start();
include '../db.php';

// Protect page
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// Search & Filter
$search = $_GET['search'] ?? '';
$filter = $_GET['filter'] ?? '';

$query = "SELECT * FROM complaints WHERE 1";

if($search != ''){
    $query .= " AND (name LIKE '%$search%' 
                 OR email LIKE '%$search%' 
                 OR complaint LIKE '%$search%')";
}

if($filter != ''){
    $query .= " AND status='$filter'";
}

// Order by status priority
$query .= " ORDER BY 
            CASE 
                WHEN status='Resolved' THEN 1
                WHEN status='In Progress' THEN 2
                WHEN status='Pending' THEN 3
            END,
            id DESC";

$result = mysqli_query($conn, $query);

if(!$result){
    die("Query Failed: " . mysqli_error($conn));
}

// Counts
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM complaints"))['count'];
$pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM complaints WHERE status='Pending'"))['count'];
$resolved = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM complaints WHERE status='Resolved'"))['count'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" href="../css/style.css">>

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" href="../css/styl.css">>

    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { background-color: #f4f6f9; }
        .card { border-radius: 10px; }
        .navbar { background: #2c3e50; }
        .navbar-brand, .text-white { color: white !important; }
        .status-pending { color: orange; font-weight: bold; }
        .status-resolved { color: green; font-weight: bold; }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand">Admin Dashboard</a>
        <div class="ms-auto">
            <span class="text-white me-3">
                Welcome, <?php echo $_SESSION['admin']; ?>
            </span>
            <a href="../user/logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white p-3">
                <h5>Total Complaints</h5>
                <h3><?php echo $total; ?></h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-warning text-white p-3">
                <h5>Pending</h5>
                <h3><?php echo $pending; ?></h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-success text-white p-3">
                <h5>Resolved</h5>
                <h3><?php echo $resolved; ?></h3>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="card p-3 mb-4">
        <h5>Complaint Statistics</h5>
        <canvas id="complaintChart"></canvas>
    </div>

    <!-- Search -->
    <form method="GET" class="mb-3">
        <input type="text" name="search" class="form-control"
        placeholder="Search complaints..."
        value="<?php echo $search; ?>">
    </form>

    <!-- Filter -->
    <div class="mb-3">
        <a href="dashboard.php" class="btn btn-secondary btn-sm">All</a>
        <a href="dashboard.php?filter=Pending" class="btn btn-warning btn-sm">Pending</a>
        <a href="dashboard.php?filter=Resolved" class="btn btn-success btn-sm">Resolved</a>
    </div>

    <!-- Table -->
    <div class="card p-3">
        <h4>Complaint List</h4>

        <table class="table table-bordered table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Complaint</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['complaint']; ?></td>

                    <td>
                        <?php if($row['status']=='Pending'){ ?>
                            <span class="status-pending">Pending</span>
                        <?php } elseif($row['status']=='In Progress'){ ?>
                            <span style="color:blue;font-weight:bold;">In Progress</span>
                        <?php } else { ?>
                            <span class="status-resolved">Resolved</span>
                        <?php } ?>
                    </td>

                    <td><?php echo $row['created_at']; ?></td>

                    <td>
                        <!-- Update -->
                        <form method="GET" action="update_status.php">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                <option value="Pending" <?php if($row['status']=='Pending') echo 'selected'; ?>>Pending</option>
                                <option value="In Progress" <?php if($row['status']=='In Progress') echo 'selected'; ?>>In Progress</option>
                                <option value="Resolved" <?php if($row['status']=='Resolved') echo 'selected'; ?>>Resolved</option>
                            </select>
                        </form>

                        <!-- Delete -->
                        <a href="delete.php?id=<?php echo $row['id']; ?>"
                           onclick="return confirm('Delete this complaint?');"
                           class="btn btn-danger btn-sm mt-1">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>

</div>

<!-- Chart Script -->
<script>
new Chart(document.getElementById('complaintChart'), {
    type: 'bar',
    data: {
        labels: ['Total', 'Pending', 'Resolved'],
        datasets: [{
            label: 'Complaints',
            data: [<?php echo $total; ?>, <?php echo $pending; ?>, <?php echo $resolved; ?>],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

</body>
</html>