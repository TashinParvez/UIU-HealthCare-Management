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
    </style>
</head>

<body>

    <?php include '..\Includes\Sidebar.php'; ?>

    <div class="main-content container-fluid">

        <!-- Blog Section -->
        <div class="blog-section">
            <h1>5 Home Remedies for Headaches</h1>

            <div class="tags mb-4">
                <span class="badge">Headache</span>
                <span class="badge">Home Remedies</span>
            </div>

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

            <button class="like-btn"
                onclick="this.classList.toggle('liked'); let span = this.querySelector('span'); span.textContent = parseInt(span.textContent) + (this.classList.contains('liked') ? 1 : -1);">
                ❤️ <span>10</span> Likes
            </button>

            <!-- Comment Section -->
            <div class="comment-section mt-5">
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
            </div>

            <a href="blog.html" class="back-link">← Back to Blog</a>

        </div>

        <!-- Suggested Section -->
        <div class="suggested-section">
            <h4 class="mb-4">You Might Also Like</h4>

            <div class="suggested-blog-card">
                <h5>Managing Period Cramps</h5>
                <p>Ease menstrual discomfort naturally with heat therapy and diet tips.</p>
                <a href="#" class="back-link">Read More →</a>
            </div>

            <div class="suggested-blog-card">
                <h5>Dealing with Acne Naturally</h5>
                <p>Gentle skincare tips for tackling acne without harsh chemicals.</p>
                <a href="#" class="back-link">Read More →</a>
            </div>

            <div class="suggested-blog-card">
                <h5>Stress Management for Students</h5>
                <p>Mindfulness and exercise techniques to reduce student stress.</p>
                <a href="#" class="back-link">Read More →</a>
            </div>

        </div>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>