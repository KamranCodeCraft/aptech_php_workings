<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent') {
    header('Location: login.php');
    exit;
}
$parent_id = (int)$_SESSION['user_id'];
$children_query = "SELECT * FROM children WHERE parent_id = $parent_id";
$children_result = mysqli_query($conn, $children_query);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parent Dashboard - Child Vaccination System</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">    
        <h1 class="text-2xl font-bold mb-6">Parent Dashboard</h1>
        <div class="mb-6">
    <h2 class="text-xl font-semibold mb-4">Your Children</h2>
    <div class="space-y-4">
<?php if (mysqli_num_rows($children_result) > 0) { ?>
    <?php while ($child = mysqli_fetch_assoc($children_result)) { ?>
        <div class="border border-gray-200 p-4 rounded">
            <h3 class="text-lg font-medium"><?php echo htmlspecialchars($child['name']); ?></h3>
            <p class="text-gray-600">DOB: <?php echo $child['dob']; ?></p>
            <?php
            $child_id = (int)$child['id'];
            $records_query = "SELECT v.name, vr.vaccination_date FROM vaccination_records vr JOIN vaccines v ON vr.vaccine_id = v.id WHERE vr.child_id = $child_id";
            $records_result = mysqli_query($conn, $records_query);
            ?>
            <p class="font-semibold mt-2">Vaccination History:</p>
            <ul class="list-disc pl-5">
                <?php while ($record = mysqli_fetch_assoc($records_result)) { ?>
                    <li><?php echo htmlspecialchars($record['name']); ?> - <?php echo $record['vaccination_date']; ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="text-gray-500">No children found.</div>
<?php } ?>
    </div>
</div>
<a href="logout.php" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600">Logout</a>
</div>
</body>
</html>