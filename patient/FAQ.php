<?php

include "../Includes/Database_connection.php";


// --------------- BLOG INFO ---------------------
$sql = "SELECT 
            b.blog_id,
            b.blog_name,
            b.blog_tags,
            b.blog_description,
            b.likes_count,
            b.created_at,
            CONCAT(u.first_name, ' ', u.last_name) AS doctor_name
        FROM 
            blogs b
        JOIN 
            doctors d ON b.doctor_id = d.doctor_id
        JOIN 
            users u ON d.doctor_id = u.user_id
        ORDER BY 
            b.created_at ASC;
";

$all_blogs = mysqli_query($conn, $sql);
$all_blogs = mysqli_fetch_all($all_blogs, MYSQLI_ASSOC);  // returns associative array


// print_r($all_blogs);
// echo $all_blogs['blog_name'] . "<br>";

// ===========================================================


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex font-sans">

    <!-- Sidebar Include -->
    <?php include '../Includes/Sidebar.php'; ?>


    <!-- Main Content -->
    <div class="flex-grow p-8 ml-16">
        <div class="container mx-auto max-w-6xl">


            <!-- Search Bar -->
            <div class="relative mb-8">
                <input type="text" placeholder="Search blog posts..."
                    class="w-full rounded-lg pl-10 pr-4 py-3 bg-white border border-gray-200 focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:outline-none text-gray-700 placeholder-gray-400 transition">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>


            <!-- Blog Posts -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">


                <?php
                foreach ($all_blogs as $row) { ?>

                    <div
                        class="bg-white p-6 rounded-lg border border-gray-100 hover:border-gray-200 hover:shadow-lg transition">
                        <h5 class="text-xl font-semibold text-gray-800 mb-3"> <?php echo $row['blog_name']; ?></h5>
                        <p class="text-gray-600 text-sm mb-4">

                            <?php
                            $Short_description = substr($row['blog_description'], 0, 70);
                            echo $Short_description;
                            ?>
                        </p>

                        <!-- TAGS -->

                        <div class="tags mb-4">
                            <?php

                            $tags = explode(',', $row['blog_tags']);

                            foreach ($tags as $tag) {
                                $cleanTag = trim($tag);
                            ?>
                                <span
                                    class="bg-blue-100 text-blue-600 text-xs font-medium rounded-full px-2.5 py-1">
                                    <?php echo $cleanTag; ?>
                                </span>

                            <?php
                            }
                            ?>
                        </div>


                        <a href="read_blog.php?blog_id=<?php echo $row['blog_id']; ?>"
                            class="text-blue-500 text-sm font-medium hover:text-blue-600 transition">Read More →</a>

                    </div>

                <?php
                }
                ?>


                <!--    <?php
                        // echo $row['specialization']; 
                        ?>
                    $cleanTag = trim($tag); // remove extra space
                    echo '<span class="badge">' . htmlspecialchars($cleanTag) . '</span> ';
                }
                ?>
-->



                <!-- Single Blog Card -->






            </div>

            <!-- More to View Button -->
            <div class="text-center mt-10">
                <a href="#"
                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2.5 px-6 rounded-lg transition">
                    More to View
                </a>
            </div>

        </div>
    </div>

</body>

</html>