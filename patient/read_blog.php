<?php

// header('Content-Type: application/json'); // For JSON response

include "../Includes/Database_connection.php";

if (isset($_GET['blog_id'])) {
    $blog_id = intval($_GET['blog_id']); // Use intval to sanitize input
} else {
    // Handle the case where blog_id is not set, e.g., redirect or show error
    die('Blog ID not specified.');
}

// $blog_id = 2;


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



// ========================  FOR Suggestions  =================================

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


// =========================== FOR LIKE ================================

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['blog_id'])) {
    $blog_id = intval($_POST['blog_id']);

    // Check if the blog exists first (optional but good for safety)
    $check = mysqli_query($conn, "SELECT blog_id FROM blogs WHERE blog_id = $blog_id");
    if (mysqli_num_rows($check) === 0) {
        echo json_encode(['success' => false, 'error' => 'Blog not found']);
        exit;
    }

    // Update the likes count
    $update_sql = "UPDATE blogs SET likes_count = likes_count + 1 WHERE blog_id = $blog_id";

    if (mysqli_query($conn, $update_sql)) {
        $result = mysqli_query($conn, "SELECT likes_count FROM blogs WHERE blog_id = $blog_id");
        $row = mysqli_fetch_assoc($result);
        echo json_encode(['success' => true, 'new_likes' => $row['likes_count']]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Update failed']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid Request']);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>5 Home Remedies for Headaches - UIU Health Care</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        background-color: #f5f7fa;
        margin: 0;
        min-height: 100vh;
        display: flex;
    }

    .main-content {
        flex: 1;
        margin-left: 80px;
        /* Collapsed sidebar (64px) + 16px gap */
        padding: 2rem 3rem;
        width: calc(100% - 80px);
        /* Full width minus sidebar and gap */
        transition: margin-left 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55), width 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    }

    .sidebar:hover+.main-content {
        margin-left: 272px;
        /* Expanded sidebar (256px) + 16px gap */
        width: calc(100% - 272px);
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
        color: #111827;
    }

    p {
        font-size: 1.05rem;
        line-height: 1.7;
        color: #374151;
        margin-bottom: 1.2rem;
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
        color: #111827;
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
    </style>
</head>

<body>
    <!-- Sidebar Include -->
    <?php include '../Includes/Sidebar.php'; ?>


    <!-- Main Content -->
    <div class="main-content">
        <!-- Blog Section -->
        <div class="blog-section">
            <h1 class="text-3xl font-bold mb-6">5 Home Remedies for Headaches</h1>

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

            <!----------------------- TASHIN : this working but backend not added  ----------------------->
            <!-- <button class="like-btn"
                onclick="this.classList.toggle('liked'); let span = this.querySelector('span'); span.textContent = parseInt(span.textContent) + (this.classList.contains('liked') ? 1 : -1);">
                ❤️ <span> <?php
                            // echo $blog_info['likes_count'];
                            ?> </span> Likes
            </button> <br> -->




            <button id="likeBtn" class="like-btn">
                <i class="bi bi-heart"></i> <span>10</span> Likes
            </button>

            <!-- Comment Section -->
            <div class="comment-section mt-5">
                <h4 class="text-xl font-semibold mb-3">Comments</h4>


                <div class="mb-3">
                    <form action="/patient/post_comment.php" method="POST">
                        <input type="hidden" name="blog_id" value="1"> <!-- Assuming blog ID for this post -->
                        <textarea class="form-control mb-2" rows="3" name="comment" placeholder="Write your comment..."
                            required></textarea>
                        <button type="submit"
                            class="btn bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Post
                            Comment</button>
                    </form>
                </div>

                <div class="comments-list">
                    <div class="comment mb-3">
                        <p><strong>Alice Smith:</strong> This was really helpful! The cold compress worked wonders for
                            me.</p>
                        <small class="text-gray-500">Posted on April 25, 2025</small>
                    </div>

                    <div class="comment">
                        <p><strong>John Doe:</strong> I tried the ginger tea and it helped so much. Thanks for sharing!
                        </p>
                        <small class="text-gray-500">Posted on April 24, 2025</small>
                    </div>
                </div>
            </div> -->


            <a href="/patient/health_blog.php" class="back-link">← Back to Blog</a>
        </div>
        <br>
        <!-- Suggested Section -->

        <div class="suggested-section">
            <h4 class="text-xl font-semibold mb-4">You Might Also Like</h4>


            <div class="suggested-blog-card">
                <h5>Managing Period Cramps</h5>
                <p>Ease menstrual discomfort naturally with heat therapy and diet tips.</p>
                <a href="/patient/read_blog.php?blog_id=2" class="back-link">Read More →</a>
            </div>

            <div class="suggested-blog-card">
                <h5>Dealing with Acne Naturally</h5>
                <p>Gentle skincare tips for tackling acne without harsh chemicals.</p>
                <a href="/patient/read_blog.php?blog_id=3" class="back-link">Read More →</a>
            </div>

            <div class="suggested-blog-card">
                <h5>Stress Management for Students</h5>
                <p>Mindfulness and exercise techniques to reduce student stress.</p>
                <a href="/patient/read_blog.php?blog_id=4" class="back-link">Read More →</a>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS Bundle -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const likeBtn = document.getElementById('likeBtn');
        if (likeBtn) {
            likeBtn.addEventListener('click', function() {
                this.classList.toggle('liked');
                const span = this.querySelector('span');
                const currentLikes = parseInt(span.textContent);
                span.textContent = this.classList.contains('liked') ? currentLikes + 1 : currentLikes -
                    1;
            });
        }
    });
    </script>

</body>

</html>