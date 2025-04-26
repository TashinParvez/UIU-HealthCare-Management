<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Blog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .blog-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            height: 100%;
        }

        .blog-card h5 {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .blog-card p {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .blog-card a {
            color: #007bff;
            text-decoration: none;
        }

        .blog-card a:hover {
            text-decoration: underline;
        }

        .search-bar {
            position: relative;
        }

        .search-bar input {
            padding-left: 40px;
        }

        .search-bar svg {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #6c757d;
        }

        .more-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
        }

        .more-btn:hover {
            background-color: #0056b3;
        }

        .tag {
            font-size: 0.75rem;
            margin-right: 5px;
        }

        /* Sidebar and layout adjustments */
        .content {
            margin-left: 64px;
            /* Match the collapsed sidebar width */
            padding: 20px;
            transition: margin-left 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }

        .sidebar:hover+.content {
            margin-left: 256px;
            /* Match the expanded sidebar width */
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
        <div class="flex-grow-1 p-4 content">
            <div class="container">
                <!-- Search Bar -->
                <div class="search-bar mb-4">
                    <input type="text" class="form-control rounded-pill" placeholder="Search blog posts...">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <!-- Blog Posts -->
                <!-- Row 1 -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>5 Home Remedies for Headaches</h5>
                            <p>Learn simple at-home solutions to relieve mild headaches, including hydration and rest.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Headache</span>
                                <span class="badge bg-primary tag">Home Remedies</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Managing Period Cramps</h5>
                            <p>Tips for girls to ease menstrual discomfort naturally with heat therapy and diet.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Women Health</span>
                                <span class="badge bg-primary tag">Period Pain</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Dealing with Acne Naturally</h5>
                            <p>Skincare tips for all ages to manage acne without harsh chemicals.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Skincare</span>
                                <span class="badge bg-primary tag">Acne</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Stress Management for Students</h5>
                            <p>Practical advice to reduce stress with mindfulness and exercise.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Mental Health</span>
                                <span class="badge bg-primary tag">Students</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <!-- Row 2 -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Boosting Immunity in Winter</h5>
                            <p>Stay healthy with these tips to strengthen your immune system during cold months.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Immunity</span>
                                <span class="badge bg-primary tag">Winter Health</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Sleep Better Tonight</h5>
                            <p>Simple habits to improve your sleep quality and wake up refreshed.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Sleep</span>
                                <span class="badge bg-primary tag">Wellness</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Hydration Tips for All Ages</h5>
                            <p>Why staying hydrated matters and how to make it a daily habit.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Hydration</span>
                                <span class="badge bg-primary tag">Health Tips</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Healthy Snacks for Busy Days</h5>
                            <p>Quick and nutritious snack ideas for when you're on the go.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Nutrition</span>
                                <span class="badge bg-primary tag">Snacks</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <!-- Row 3 -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Post-Workout Recovery Tips</h5>
                            <p>How to recover faster after exercise with stretching and nutrition.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Fitness</span>
                                <span class="badge bg-primary tag">Recovery</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Dealing with Seasonal Allergies</h5>
                            <p>Manage allergies with these practical tips for all seasons.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Allergies</span>
                                <span class="badge bg-primary tag">Seasonal Health</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Mental Health Check-Ins</h5>
                            <p>Simple ways to check in with your mental health daily.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Mental Health</span>
                                <span class="badge bg-primary tag">Self-Care</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Nutrition for Better Skin</h5>
                            <p>Foods to eat for glowing, healthy skin at any age.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Skincare</span>
                                <span class="badge bg-primary tag">Nutrition</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <!-- Row 4 -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Improving Posture at Work</h5>
                            <p>Tips to maintain good posture and reduce back pain.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Posture</span>
                                <span class="badge bg-primary tag">Work Health</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Coping with Anxiety</h5>
                            <p>Practical strategies to manage anxiety in daily life.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Mental Health</span>
                                <span class="badge bg-primary tag">Anxiety</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Eye Health Tips</h5>
                            <p>Protect your eyes with these habits, especially if you use screens a lot.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Eye Health</span>
                                <span class="badge bg-primary tag">Screen Time</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Morning Routines for Energy</h5>
                            <p>Start your day with these habits to boost energy and focus.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Morning Routine</span>
                                <span class="badge bg-primary tag">Energy</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <!-- Row 5 -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Yoga for Beginners</h5>
                            <p>Easy yoga poses to start your wellness journey at home.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Yoga</span>
                                <span class="badge bg-primary tag">Beginners</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Hydrating Foods for Summer</h5>
                            <p>Stay cool and hydrated with these summer-friendly foods.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Hydration</span>
                                <span class="badge bg-primary tag">Summer</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Dealing with Sore Throat</h5>
                            <p>Soothe a sore throat with these simple home remedies.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Sore Throat</span>
                                <span class="badge bg-primary tag">Home Remedies</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="blog-card">
                            <h5>Benefits of Walking Daily</h5>
                            <p>How a daily walk can improve your physical and mental health.</p>
                            <div class="mb-2">
                                <span class="badge bg-primary tag">Walking</span>
                                <span class="badge bg-primary tag">Health Benefits</span>
                            </div>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>

                <!-- More to View Button -->
                <div class="text-center mt-4">
                    <a href="#" class="more-btn">More to View</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>