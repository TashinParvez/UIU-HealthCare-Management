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
                    <div class="border border-gray-200 rounded-lg">
                        <button
                            class="w-full p-4 text-left text-blue-500 font-medium hover:bg-blue-50 transition flex justify-between items-center"
                            onclick="toggleAccordion('collapseOne')">
                            The quick fox jumps over the lazy dog
                            <svg id="iconOne" class="w-5 h-5 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="collapseOne" class="hidden px-4 pb-4 text-gray-600 text-sm">
                            Things on a very small scale behave like nothing you have any direct experience with.
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg">
                        <button
                            class="w-full p-4 text-left text-blue-500 font-medium hover:bg-blue-50 transition flex justify-between items-center"
                            onclick="toggleAccordion('collapseTwo')">
                            The quick fox jumps over the lazy dog
                            <svg id="iconTwo" class="w-5 h-5 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="collapseTwo" class="hidden px-4 pb-4 text-gray-600 text-sm">
                            Things on a very small scale behave like nothing you have any direct experience with.
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg">
                        <button
                            class="w-full p-4 text-left text-blue-500 font-medium hover:bg-blue-50 transition flex justify-between items-center"
                            onclick="toggleAccordion('collapseThree')">
                            The quick fox jumps over the lazy dog
                            <svg id="iconThree" class="w-5 h-5 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="collapseThree" class="hidden px-4 pb-4 text-gray-600 text-sm">
                            Things on a very small scale behave like nothing you have any direct experience with.
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg">
                        <button
                            class="w-full p-4 text-left text-blue-500 font-medium hover:bg-blue-50 transition flex justify-between items-center"
                            onclick="toggleAccordion('collapseFour')">
                            The quick fox jumps over the lazy dog
                            <svg id="iconFour" class="w-5 h-5 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="collapseFour" class="hidden px-4 pb-4 text-gray-600 text-sm">
                            Things on a very small scale behave like nothing you have any direct experience with.
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg">
                        <button
                            class="w-full p-4 text-left text-blue-500 font-medium hover:bg-blue-50 transition flex justify-between items-center"
                            onclick="toggleAccordion('collapseFive')">
                            The quick fox jumps over the lazy dog
                            <svg id="iconFive" class="w-5 h-5 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="collapseFive" class="hidden px-4 pb-4 text-gray-600 text-sm">
                            Things on a very small scale behave like nothing you have any direct experience with.
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg">
                        <button
                            class="w-full p-4 text-left text-blue-500 font-medium hover:bg-blue-50 transition flex justify-between items-center"
                            onclick="toggleAccordion('collapseSix')">
                            The quick fox jumps over the lazy dog
                            <svg id="iconSix" class="w-5 h-5 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="collapseSix" class="hidden px-4 pb-4 text-gray-600 text-sm">
                            Things on a very small scale behave like nothing you have any direct experience with.
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg">
                        <button
                            class="w-full p-4 text-left text-blue-500 font-medium hover:bg-blue-50 transition flex justify-between items-center"
                            onclick="toggleAccordion('collapseSeven')">
                            The quick fox jumps over the lazy dog
                            <svg id="iconSeven" class="w-5 h-5 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="collapseSeven" class="hidden px-4 pb-4 text-gray-600 text-sm">
                            Things on a very small scale behave like nothing you have any direct experience with.
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg">
                        <button
                            class="w-full p-4 text-left text-blue-500 font-medium hover:bg-blue-50 transition flex justify-between items-center"
                            onclick="toggleAccordion('collapseEight')">
                            The quick fox jumps over the lazy dog
                            <svg id="iconEight" class="w-5 h-5 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="collapseEight" class="hidden px-4 pb-4 text-gray-600 text-sm">
                            Things on a very small scale behave like nothing you have any direct experience with.
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg">
                        <button
                            class="w-full p-4 text-left text-blue-500 font-medium hover:bg-blue-50 transition flex justify-between items-center"
                            onclick="toggleAccordion('collapseNine')">
                            The quick fox jumps over the lazy dog
                            <svg id="iconNine" class="w-5 h-5 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="collapseNine" class="hidden px-4 pb-4 text-gray-600 text-sm">
                            Things on a very small scale behave like nothing you have any direct experience with.
                        </div>
                    </div>
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