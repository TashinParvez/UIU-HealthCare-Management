<?php

include "../Includes/Database_connection.php";

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));
    $accepted = isset($_POST['accept_terms']) ? 1 : 0;

    if ($accepted) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (first_name, last_name, email, phone, message, accepted_terms) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $firstName, $lastName, $email, $phone, $message, $accepted);

        if ($stmt->execute()) {
            $success = "✅ Thank you! Your message has been submitted.";
        } else {
            $error = "❌ Failed to submit your message. Please try again.";
        }

        $stmt->close();
    } else {
        $error = "❌ You must accept the terms to submit the form.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 font-sans">

    <!----------------------------- Navigation Bar ----------------------------->
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Hero/heroNav.php'); ?>


    <!----------------------------- Main Content ----------------------------->

    <section class="pt-24 pb-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm">
                <h6 class="text-blue-500 font-semibold mb-2">Get in Touch</h6>
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Contact Us</h1>
                <p class="text-gray-600 mb-6">Let us know your questions, suggestions, or feedback.</p>

                <!-- Success or Error Message -->
                <?php if ($success): ?>
                    <p class="text-green-600 font-semibold mb-4"><?= $success ?></p>
                <?php elseif ($error): ?>
                    <p class="text-red-600 font-semibold mb-4"><?= $error ?></p>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="text" name="first_name" required
                            class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400"
                            placeholder="First name">
                        <input type="text" name="last_name" required
                            class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400"
                            placeholder="Last name">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="email" name="email" required
                            class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400"
                            placeholder="Email">
                        <input type="tel" name="phone"
                            class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400"
                            placeholder="Phone number">
                    </div>
                    <!-- Removed "Topic" because it's not in your table -->
                    <div class="mb-4">
                        <textarea name="message" required rows="5"
                            class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400"
                            placeholder="Type your message..."></textarea>
                    </div>
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" name="accept_terms" id="acceptTerms" required
                            class="h-4 w-4 text-blue-500 focus:ring-blue-400 border-gray-200 rounded">
                        <label for="acceptTerms" class="ml-2 text-gray-600 text-sm">I accept the terms</label>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 transition">Submit</button>
                </form>
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
    </script>
</body>

</html>