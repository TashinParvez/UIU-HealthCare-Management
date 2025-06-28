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

</div>