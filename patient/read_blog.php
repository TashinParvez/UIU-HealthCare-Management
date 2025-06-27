<?php

include "../Includes/Database_connection.php";


$blog_id = 2;

// --------------- DOCTOR INFO ---------------------
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
        WHERE 
            b.blog_id = '$blog_id';";

$blog_info = mysqli_query($conn, $sql);
$blog_info = mysqli_fetch_all($blog_info, MYSQLI_ASSOC);  // returns associative array

$blog_info = $blog_info[0];

// print_r($blog_info);
// echo $blog_info['blog_name'] . "<br>";



// ========================  TASHIN  =================================

$current_blog_id = $blog_info['blog_id'];
$tags = explode(',', $blog_info['blog_tags']);

// Clean & format tags for SQL LIKE search
$tag_conditions = [];
foreach ($tags as $tag) {
    $tag = trim($tag);
    $tag_conditions[] = "blog_tags LIKE '%" . mysqli_real_escape_string($conn, $tag) . "%'";
}

$tag_query = implode(' OR ', $tag_conditions);

$sql = "
    SELECT * FROM blogs 
    WHERE blog_id != $current_blog_id AND ($tag_query)
    ORDER BY RAND()
    LIMIT 3
";

$result = mysqli_query($conn, $sql);
$related_blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (count($related_blogs) < 1) {
    $sql_fallback = "
        SELECT * FROM blogs 
        WHERE blog_id != $current_blog_id
        ORDER BY RAND()
        LIMIT 3
    ";
    $result = mysqli_query($conn, $sql_fallback);
    $related_blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// print_r($related_blogs);


// ===========================================================


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>5 Home Remedies for Headaches</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }


        .main-content {
            flex: 1;
            display: flex;
            flex-wrap: wrap;
            padding: 2rem;
            gap: 2rem;
        }

        .blog-section,
        .suggested-section {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
        }

        .blog-section {
            flex: 2;
            min-width: 0;
        }

        .suggested-section {
            flex: 1;
            min-width: 300px;
            height: fit-content;
            position: sticky;
            top: 2rem;
        }

        h1,
        h4 {
            color: #111;
        }

        p {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #333;
            margin-bottom: 1.2rem;
        }

        .tags .badge {
            background: #e8f0fe;
            color: #3b82f6;
            font-size: 0.75rem;
            padding: 0.4rem 0.7rem;
            border-radius: 50px;
            margin-right: 0.5rem;
        }

        strong {
            color: #111;
        }

        .like-btn {
            background: #f0f0f0;
            border: none;
            border-radius: 30px;
            padding: 0.6rem 1.2rem;
            font-size: 0.95rem;
            color: #555;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: 1.5rem;
            transition: background 0.3s, color 0.3s;
        }

        .like-btn:hover {
            background: #e2e8f0;
        }

        .like-btn.liked {
            background: #fee2e2;
            color: #dc2626;
        }

        textarea {
            border-radius: 8px;
            resize: none;
        }

        .btn-primary {
            background: #3b82f6;
            border: none;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .suggested-blog-card {
            background: #fafafa;
            padding: 1rem;
            border-radius: 1rem;
            margin-bottom: 1rem;
            transition: box-shadow 0.3s;
        }

        .suggested-blog-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .suggested-blog-card h5 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
        }

        .suggested-blog-card p {
            font-size: 0.9rem;
            color: #666;
        }

        .back-link {
            display: inline-block;
            margin-top: 2rem;
            font-size: 0.95rem;
            color: #3b82f6;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        /* Sidebar and layout adjustments */
        .content {
            margin-left: 64px;
            /* Match the collapsed sidebar width */
            padding: 20px;
            transition: margin-left 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            width: calc(100% - 64px);
            /* Full width minus collapsed sidebar */
        }

        .sidebar:hover+.content {
            margin-left: 256px;
            /* Match the expanded sidebar width */
            width: calc(100% - 256px);
            /* Full width minus expanded sidebar */
        }

        .sidebar {
            transition: width 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            transform: translateZ(0);
            will-change: width;
        }

        .sidebar:not(:hover) .sidebar-text {
            display: none;
        }

        .sidebar:not(:hover) .search-input {
            display: none;
        }

        .sidebar-item {
            position: relative;
            overflow: hidden;
        }

        .sidebar-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(147, 51, 234, 0.3), transparent);
            transition: all 0.5s ease;
        }

        .sidebar-item:hover::before {
            left: 100%;
        }

        .sidebar-item:hover {
            background-color: #f3f4f6;
            color: #9333ea;
            transform: scale(1.05);
            transition: transform 0.2s ease;
        }
    </style>
</head>

<body>


    <?php
    include '..\Includes\Sidebar.php';
    ?>

    <div class="main-content container-fluid">

        <!--------------------- Blog Section --------------------->
        <div class="blog-section">


            <h1> <?php echo $blog_info['blog_name']; ?> </h1>

            <div class="tags mb-4">
                <?php

                $tags = explode(',', $blog_info['blog_tags']);

                foreach ($tags as $tag) {
                    $cleanTag = trim($tag); // remove extra space
                    echo '<span class="badge">' . htmlspecialchars($cleanTag) . '</span> ';
                }
                ?>
            </div>

            <p><?php echo $blog_info['blog_description']; ?></p>

            <button class="like-btn"
                onclick="this.classList.toggle('liked'); let span = this.querySelector('span'); span.textContent = parseInt(span.textContent) + (this.classList.contains('liked') ? 1 : -1);">
                ❤️ <span> <?php echo $blog_info['likes_count']; ?> </span> Likes
            </button> <br>

            <!-- Comment Section -->
            <!-- <div class="comment-section mt-5">
                <h4 class="mb-3">Comments</h4>

                <div class="mb-3">
                    <textarea class="form-control mb-2" rows="3" placeholder="Write your comment..."></textarea>
                    <button class="btn btn-primary">Post Comment</button>
                </div>

                <div class="comments-list">
                    <div class="comment mb-3">
                        <p><strong>Alice Smith:</strong> This was really helpful! The cold compress worked wonders for
                            me.</p>
                        <small>Posted on April 25, 2025</small>
                    </div>

                    <div class="comment">
                        <p><strong>John Doe:</strong> I tried the ginger tea and it helped so much. Thanks for sharing!
                        </p>
                        <small>Posted on April 24, 2025</small>
                    </div>
                </div>
            </div> -->

            <a href="/patient/FAQ.php" class="back-link">← Back to Blog</a>

        </div>

        <!-------------------------- Suggested Section -------------------------->
        <div class="suggested-section">
            <h4 class="mb-4">You Might Also Like</h4>

            <?php
            foreach ($related_blogs as $row) {
            ?>

                <div class="suggested-blog-card">
                    <h5><?php echo $row['blog_name']; ?></h5>

                    <p><?PHP
                        $shortName = substr($row['blog_description'], 0, 70);
                        echo $shortName;
                        ?>
                    </p>

                    <!-- $row[blog_id] -->
                    <a href="#" class="back-link">Read More →</a>

                </div>

            <?php
            }
            ?>

        </div>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>