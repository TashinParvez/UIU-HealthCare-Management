<?php

include "../Includes/Database_connection.php";


// --------------- FAQ ---------------------
$sql = "SELECT question, answer FROM faq ORDER BY faq_id ASC;";
$result = mysqli_query($conn, $sql);
$faqs = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 font-sans">

    <!-- Navigation Bar -->
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Hero/heroNav.php'); ?>



    <!-- Main Content -->
    <section class="pt-24 pb-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-sm">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">FAQ</h1>
                <p class="text-gray-600 mb-6">Problems trying to resolve the conflict between the two major realms of
                    Classical physics: Newtonian mechanics</p>

                <div class="space-y-4">
                    <?php
                    $count = 1;
                    foreach ($faqs as $faq):
                        $collapseId = "collapse" . $count;
                        $iconId = "icon" . $count;
                    ?>
                        <div class="border border-gray-200 rounded-lg">
                            <button
                                class="w-full p-4 text-left text-blue-500 font-medium hover:bg-blue-50 transition flex justify-between items-center"
                                onclick="toggleAccordion('<?php echo $collapseId; ?>', '<?php echo $iconId; ?>')">
                                <?php echo htmlspecialchars($faq['question']); ?>
                                <svg id="<?php echo $iconId; ?>" class="w-5 h-5 transform transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="<?php echo $collapseId; ?>" class="hidden px-4 pb-4 text-gray-600 text-sm">
                                <?php echo htmlspecialchars($faq['answer']); ?>
                            </div>
                        </div>
                    <?php
                        $count++;
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer Section -->
    <?php include '../Includes/footer.php'; ?>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        function toggleAccordion(id) {
            const content = document.getElementById(id);
            const icon = document.getElementById(`icon${id.replace('collapse', '')}`);
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    </script>
</body>

</html>