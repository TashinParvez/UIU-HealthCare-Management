<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Post - 5 Home Remedies for Headaches</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .blog-content {
            width: 100%;
            /* Stretch to full width of parent */
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .blog-content h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .blog-content .tags {
            margin-bottom: 20px;
        }

        .blog-content .tags .badge {
            font-size: 0.8rem;
            margin-right: 5px;
        }

        .blog-content p {
            font-size: 1rem;
            line-height: 1.6;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .suggested-blog-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            height: 100%;
        }

        .suggested-blog-card h5 {
            font-size: 1rem;
            font-weight: bold;
        }

        .suggested-blog-card p {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .suggested-blog-card a {
            color: #007bff;
            text-decoration: none;
        }

        .suggested-blog-card a:hover {
            text-decoration: underline;
        }

        .like-btn {
            background: none;
            border: none;
            color: #007bff;
            font-size: 1rem;
        }

        .like-btn:hover {
            color: #0056b3;
        }

        .like-btn.liked {
            color: #dc3545;
        }

        .comment-section {
            margin-top: 30px;
        }

        .comment {
            border-bottom: 1px solid #e0e0e0;
            padding: 10px 0;
        }

        .comment p {
            margin: 0;
        }

        .comment small {
            color: #6c757d;
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
    <div class="d-flex min-vh-100">
        <!------------------------------ Include Sidebar ------------------------------>
        <?php include '../Includes/Sidebar.php'; ?>

        <!------------------------------ Main Content ------------------------------>
        <div class="p-4 content">
            <div class="blog-content">
                <h1>5 Home Remedies for Headaches</h1>
                <div class="tags">
                    <span class="badge bg-primary">Headache</span>
                    <span class="badge bg-primary">Home Remedies</span>
                </div>
                <p>Headaches can be a common nuisance, often disrupting your daily routine. While over-the-counter medications can help, many people prefer natural remedies to alleviate the pain. Here are five effective home remedies to try when you feel a headache coming on.</p>
                <p><strong>1. Stay Hydrated:</strong> Dehydration is a common cause of headaches. Drinking a glass of water can often provide quick relief. Aim to drink at least 8 glasses of water a day, and increase your intake if you’re active or in a hot climate.</p>
                <p><strong>2. Apply a Cold Compress:</strong> A cold compress on your forehead or the back of your neck can help reduce inflammation and numb the pain. Wrap a few ice cubes in a towel or use a cold pack and apply it for 15 minutes.</p>
                <p><strong>3. Take a Break and Rest:</strong> Sometimes, headaches are triggered by stress or overstimulation. Find a quiet, dark room to rest in for 20-30 minutes. Closing your eyes and focusing on deep breathing can help ease the tension.</p>
                <p><strong>4. Try Ginger Tea:</strong> Ginger has anti-inflammatory properties that can help with headache relief. Boil a few slices of fresh ginger in water, strain, and sip the tea slowly. You can add a bit of honey for taste.</p>
                <p><strong>5. Massage Your Temples:</strong> Gently massaging your temples or the base of your skull can improve blood flow and reduce tension. Use your fingers to apply light pressure in circular motions for a few minutes.</p>
                <p>These remedies can be effective for mild headaches. However, if your headache persists, worsens, or is accompanied by other symptoms like dizziness or vision changes, consult a healthcare professional immediately.</p>

                <!-- Like/Reaction Section -->
                <div class="mt-4">
                    <button class="like-btn" onclick="this.classList.toggle('liked'); this.querySelector('span').textContent = this.classList.contains('liked') ? parseInt(this.querySelector('span').textContent) + 1 : parseInt(this.querySelector('span').textContent) - 1;">
                        <svg width="20" height="20" fill="currentColor" class="me-1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                        <span>10</span> Likes
                    </button>
                </div>

                <!-- Comments Section -->
                <div class="comment-section">
                    <h4 class="mt-5 mb-3">Comments</h4>
                    <!-- Add Comment Form -->
                    <div class="mb-4">
                        <textarea class="form-control mb-2" rows="3" placeholder="Write your comment..."></textarea>
                        <button class="btn btn-primary">Post Comment</button>
                    </div>
                    <!-- Existing Comments -->
                    <div class="comments-list">
                        <div class="comment">
                            <p><strong>Alice Smith:</strong> This was really helpful! The cold compress worked wonders for me.</p>
                            <small>Posted on April 25, 2025</small>
                        </div>
                        <div class="comment">
                            <p><strong>John Doe:</strong> I tried the ginger tea, and it really helped reduce my headache. Thanks for sharing!</p>
                            <small>Posted on April 24, 2025</small>
                        </div>
                    </div>
                </div>

                <!-- Suggested Blogs Section -->
                <h4 class="mt-5 mb-3">You Might Also Like</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="suggested-blog-card">
                            <h5>Managing Period Cramps</h5>
                            <p>Tips for girls to ease menstrual discomfort naturally with heat therapy and diet.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary">Women Health</span>
                                <span class="badge bg-primary">Period Pain</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="suggested-blog-card">
                            <h5>Dealing with Acne Naturally</h5>
                            <p>Skincare tips for all ages to manage acne without harsh chemicals.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary">Skincare</span>
                                <span class="badge bg-primary">Acne</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="suggested-blog-card">
                            <h5>Stress Management for Students</h5>
                            <p>Practical advice to reduce stress with mindfulness and exercise.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary">Mental Health</span>
                                <span class="badge bg-primary">Students</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>

                <a href="blog.html" class="back-link">← Back to Blog</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>