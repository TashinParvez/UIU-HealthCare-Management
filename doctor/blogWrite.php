<?php
include "../Includes/Database_connection.php";
session_start();

if (!isset($_SESSION['doctor_id'])) {
    $_SESSION['doctor_id'] = 1; // Remove this line once session works properly
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctor_id = $_SESSION['doctor_id']; // Get doctor ID from session

    $blog_name = htmlspecialchars(trim($_POST['blog_name']));
    $blog_tags = htmlspecialchars(trim($_POST['blog_tags']));
    $blog_description = htmlspecialchars(trim($_POST['blog_desc']));

    if (!empty($blog_name) && !empty($blog_tags) && !empty($blog_description)) {
        $sql = "INSERT INTO blogs (doctor_id, blog_name, blog_tags, blog_description, likes_count)
                VALUES ('$doctor_id', '$blog_name', '$blog_tags', '$blog_description', 0)";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Blog published successfully!'); window.location.href='blog_list.php';</script>";
        } else {
            echo "<script>alert('Error publishing blog: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Please fill out all fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Write Blog | Doctor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex min-h-screen bg-gray-100">
    <!-- Include the remembered sidebar -->
    <?php include '../Includes/Sidebar_Doctor.php'; ?>

    <!-- Main Content -->
    <div class="ml-16 hover:ml-64 transition-all duration-300 flex-grow p-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Write a Blog</h2>
            <form action="" method="post">
                <!-- Blog Name -->
                <div class="mb-4">
                    <label for="blog_name" class="block text-gray-700 font-semibold mb-2">Blog Title</label>
                    <input type="text" id="blog_name" name="blog_name" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <!-- Blog Tags -->
                <div class="mb-4">
                    <label for="blog_tags" class="block text-gray-700 font-semibold mb-2">
                        Tags <span class="text-sm text-gray-500">(Separate with commas)</span>
                    </label>
                    <input type="text" id="blog_tags" name="blog_tags" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <!-- Blog Description -->
                <div class="mb-4">
                    <label for="blog_desc" class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea id="blog_desc" name="blog_desc" rows="8" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 resize-none"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="bg-purple-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                        Publish Blog
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>