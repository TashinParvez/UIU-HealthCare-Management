<!-- submit_booking.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-2xl font-bold text-blue-900 mb-4">Booking Confirmation</h1>
        <?php

        // // Retrieve form data
        // $specialist = isset($_POST['specialist']) ? htmlspecialchars($_POST['specialist']) : 'Not selected';
        // $doctor = isset($_POST['doctor']) ? htmlspecialchars($_POST['doctor']) : 'Not selected';
        // $day = isset($_POST['day']) ? htmlspecialchars($_POST['day']) : 'Not selected';
        // $time = isset($_POST['time']) ? htmlspecialchars($_POST['time']) : 'Not selected';
        // $payment_method = isset($_POST['payment_method']) ? htmlspecialchars($_POST['payment_method']) : 'Not selected';
        // $card_number = isset($_POST['card_number']) ? htmlspecialchars($_POST['card_number']) : 'Not provided';
        // $expiry = isset($_POST['expiry']) ? htmlspecialchars($_POST['expiry']) : 'Not provided';
        // $cvc = isset($_POST['cvc']) ? htmlspecialchars($_POST['cvc']) : 'Not provided';
        // $country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : 'Not provided';
        // $postal_code = isset($_POST['postal_code']) ? htmlspecialchars($_POST['postal_code']) : 'Not provided';

        // // Display the submitted data
        // echo "<p><strong>Specialist:</strong> $specialist</p>";
        // echo "<p><strong>Doctor:</strong> $doctor</p>";
        // echo "<p><strong>Day:</strong> $day</p>";
        // echo "<p><strong>Time:</strong> $time</p>";
        // echo "<p><strong>Payment Method:</strong> $payment_method</p>";
        // echo "<p><strong>Card Number:</strong> $card_number</p>";
        // echo "<p><strong>Expiry:</strong> $expiry</p>";
        // echo "<p><strong>CVC:</strong> $cvc</p>";
        // echo "<p><strong>Country:</strong> $country</p>";
        // echo "<p><strong>Postal Code:</strong> $postal_code</p>";
        echo "<p class='text-green-600 mt-4'>Your appointment has been booked successfully!</p>";

        ?>
        <a href="booking.php"
            class="mt-6 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Book Another
            Appointment</a>
    </div>
</body>

</html>