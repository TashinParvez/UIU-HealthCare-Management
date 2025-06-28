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

            <p>Headaches can disrupt your day. While medications help, natural remedies offer gentle relief. Here are
                five you can try when a headache strikes:</p>

            <p><strong>1. Stay Hydrated:</strong> Dehydration is a common cause. Aim for at least 8 glasses of water
                daily, more if active or in heat.</p>

            <p><strong>2. Apply a Cold Compress:</strong> Applying a cold pack to your forehead or neck for 15 minutes
                helps reduce inflammation and numb pain.</p>

            <p><strong>3. Take a Break and Rest:</strong> Stress-induced headaches can improve by resting in a dark,
                quiet room for 20–30 minutes with deep breathing.</p>

            <p><strong>4. Try Ginger Tea:</strong> Ginger’s anti-inflammatory properties can relieve headaches. Boil
                fresh slices, strain, and sip — honey optional!</p>

            <p><strong>5. Massage Your Temples:</strong> Light, circular massages on your temples or neck base improve
                blood flow and ease tension.</p>

            <p>If headaches persist or worsen, always consult a healthcare professional.</p>

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
            </div>

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