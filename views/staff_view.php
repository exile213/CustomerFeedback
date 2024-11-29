<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation Bar -->
        <nav class="bg-gray-800 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-3 lg:px-1">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <span class="text-xl font-semibold text-white">Staff Portal</span>
                    </div>
                    <div class="flex items-center space-x-4 mt-5">
                        <form method="post" class="inline">
                            <button type="submit" name="logout" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-500">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-lg shadow-md">
                <!-- Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px" aria-label="Tabs">
                        <button class="tab-button text-gray-800 border-gray-800 py-4 px-6 border-b-2 font-medium active" data-tab="feedback">
                            Customer Feedback
                        </button>
                        <button class="tab-button text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-6 border-b-2 font-medium" data-tab="customers">
                            Customer List
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <div id="feedback" class="tab-content">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Customer Feedback</h3>
                        <p class="text-sm text-gray-600 mb-4">View all feedback</p>
                        <div class="mb-4">
                            <div class="relative">
                                <input type="text" id="feedbackSearch" placeholder="Search feedback..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-200">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ri-search-line text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <div id="feedbackList" class="space-y-4">
                            <!-- Feedback items will be populated by JavaScript -->
                        </div>
                    </div>

                    <div id="customers" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Customer List</h3>
                        <p class="text-sm text-gray-600 mb-4">View customer names</p>
                        <div class="mb-4">
                            <div class="relative">
                                <input type="text" id="customerSearch" placeholder="Search customers..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-200">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ri-search-line text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <div id="customerList" class="space-y-4">
                            <!-- Customer items will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Pass PHP data to JavaScript
        const feedback = <?php echo json_encode($feedback); ?>;
        const customers = <?php echo json_encode($customers); ?>;
    </script>
    <script src="Scripts/staff_script.js"></script>
</body>
</html>

