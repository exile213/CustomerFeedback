<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="../Scripts/staff_script.js"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation Bar -->
        <nav class="bg-gray-500 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-xl font-semibold text-white">Staff Portal</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="bg-black text-white hover:bg-grey px-4 py-2 rounded-md text-sm font-medium">
                            <i class="ri-logout-box-r-line mr-2"></i>Logout
                        </button>
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
                        <button class="tab-button text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-6 border-b-2 font-medium" data-tab="recent">
                            Recent Feedback
                        </button>
                        <button class="tab-button text-gray-800 border-gray-800 py-4 px-6 border-b-2 font-medium active" data-tab="customers">
                            Customers
                        </button>
                        <button class="tab-button text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-6 border-b-2 font-medium" data-tab="reports">
                            Basic Reports
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <div id="recent" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Recent Feedback</h3>
                        <p class="text-sm text-gray-600 mb-4">View and respond to customer feedback</p>
                        <p class="text-sm text-gray-500">No recent feedback available.</p>
                    </div>

                    <div id="customers" class="tab-content">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Customer List</h3>
                        <p class="text-sm text-gray-600 mb-4">View customer contact information</p>
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

                    <div id="reports" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Basic Reports</h3>
                        <p class="text-sm text-gray-600 mb-4">View system statistics and reports</p>
                        <p class="text-sm text-gray-500">No reports available.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>