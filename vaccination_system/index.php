<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Child Vaccination System</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen relative overflow-hidden">
    <!-- Background Video -->
    <video autoplay muted loop playsinline class="fixed top-0 left-0 w-full h-full object-cover opacity-20 -z-10">
        <source src="./asset/8460053-hd_1920_1080_24fps.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <!-- Logo Placeholder at Top Right -->
    <div class="absolute top-4 right-6 z-20">
        <div class="w-20 h-20 bg-white bg-opacity-80 flex items-center justify-center shadow">
            <img src="./asset/Image_fx.jpg" alt="Logo" class="w-20 h-20 object-cover" />
        </div>
    </div>
    <div class="flex flex-col justify-center items-center min-h-screen relative z-10">
        <h1 class="text-3xl font-bold mb-5 text-center">Child Vaccination System</h1>
        <div class="flex gap-4">
            <a href="login.php" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Login</a>
            <a href="register.php" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">Register</a>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 w-full z-20">
        <?php include 'includes/footer.php'; ?>
    </div>
</body>
</html>