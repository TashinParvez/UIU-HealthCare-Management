<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer - UIU Medical Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    /* UIU Branding Colors */
    .uiu-blue {
        background-color: #003087;
        /* UIU primary blue */
    }

    .uiu-blue-text {
        color: #003087;
    }

    .uiu-accent {
        background-color: #F5A623;
        /* UIU accent gold */
    }

    /* Footer-specific styles */
    footer a {
        color: #ffffff;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    footer a:hover {
        color: #F5A623;
        /* UIU accent color on hover */
        text-decoration: underline;
    }

    .footer-logo img {
        height: 40px;
        margin-bottom: 10px;
    }

    .contact-icons img {
        width: 20px;
        margin-right: 10px;
    }

    .border-top {
        border-color: rgba(255, 255, 255, 0.2) !important;
    }
    </style>
</head>

<body>
    <footer class="bg-[rgb(0,48,135)] text-white py-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo and Tagline -->
                <div>
                    <div class="footer-logo">
                        <img src="/Includes/Images/logo/logo-blue.png" alt="UIU Medical Center" class="mb-4">
                        <p class="text-sm">Your trusted healthcare partner on campus.</p>
                        <p class="text-sm">United City, Madani Avenue, Dhaka 1212</p>
                        <div class="contact-icons flex mt-4">
                            <a href="tel:+8809966875892" aria-label="Phone">
                                <img src="/Includes/Images/footer/phone-outgoing-svgrepo-com.svg" alt="Phone">
                            </a>
                            <a href="https://www.facebook.com/uiu.ac" target="_blank" aria-label="Facebook">
                                <img src="/Includes/Images/footer/facebook-svgrepo-com.svg" alt="Facebook">
                            </a>
                            <a href="https://wa.me/+8809966875892" target="_blank" aria-label="WhatsApp">
                                <img src="/Includes/Images/footer/whatsapp-svgrepo-com.svg" alt="WhatsApp">
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Services -->
                <div>
                    <h5 class="text-lg font-semibold mb-4">Services</h5>
                    <ul class="list-none space-y-2">
                        <li><a href="/Hero/Booking.php">Appointment Booking</a></li>
                        <li><a href="/services/blood-bank">Blood Bank</a></li>
                        <li><a href="/services/emergency">Emergency Care</a></li>
                        <li><a href="/services/pharmacy">Pharmacy</a></li>
                    </ul>
                </div>
                <!-- Quick Links -->
                <div>
                    <h5 class="text-lg font-semibold mb-4">Quick Links</h5>
                    <ul class="list-none space-y-2">
                        <li><a href="https://www.uiu.ac.bd" target="_blank">UIU Official Website</a></li>
                        <li><a href="https://www.uiu.ac.bd/medical-center" target="_blank">UIU Medical Center</a></li>
                        <li><a href="/careers">Careers</a></li>
                    </ul>
                </div>
                <!-- Contact Us -->
                <div>
                    <h5 class="text-lg font-semibold mb-4">Contact Us</h5>
                    <p class="text-sm mb-2">📧 <a href="mailto:medical@uiu.ac.bd"
                            class="underline-hover">medical@uiu.ac.bd</a></p>
                    <p class="text-sm mb-2">📞 <a href="tel:+8809966875892">+880 996 687 5892</a></p>
                    <p class="text-sm">📍 United City LillCity, Madani Avenue, Dhaka 1212</p>
                </div>
            </div>
            <hr class="border-top my-6">
            <div class="text-center">
                <p class="text-sm">Copyright © UIU Medical Center 2025</p>
            </div>
        </div>
    </footer>
</body>

</html>