<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <?php require "views/Partials/sidebar.php"?>
        
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navigation bar -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-lg font-semibold text-gray-900">Customer Feedback</h1>
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <!-- Feedback Summary -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h2 class="text-lg font-semibold mb-4">Feedback Summary</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div class="bg-blue-100 p-4 rounded-lg">
                                    <h3 class="text-blue-800 font-semibold">Total Feedback</h3>
                                    <p class="text-2xl font-bold text-blue-600"><?php echo number_format($feedbackSummary['total_feedback'] ?? 0); ?></p>
                                </div>
                                <div class="bg-green-100 p-4 rounded-lg">
                                    <h3 class="text-green-800 font-semibold">Average Rating</h3>
                                    <p class="text-2xl font-bold text-green-600"><?php echo number_format($feedbackSummary['average_rating'] ?? 0, 1); ?></p>
                                </div>
                                <div class="bg-yellow-100 p-4 rounded-lg">
                                    <h3 class="text-yellow-800 font-semibold">Positive Feedback</h3>
                                    <p class="text-2xl font-bold text-yellow-600"><?php echo number_format($feedbackSummary['positive_percentage'] ?? 0, 1); ?>%</p>
                                </div>
                                <div class="bg-red-100 p-4 rounded-lg">
                                    <h3 class="text-red-800 font-semibold">Negative Feedback</h3>
                                    <p class="text-2xl font-bold text-red-600"><?php echo number_format($feedbackSummary['negative_percentage'] ?? 0, 1); ?>%</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feedback Table -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-lg font-semibold mb-4">Customer Feedback</h2>
                            <div class="mb-4 flex justify-between items-center">
                                <input type="text" id="searchInput" placeholder="Search feedback..." class="border rounded-md p-2">
                                <button id="exportBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Export to CSV
                                </button>
                            </div>
                            <div class="overflow-x-auto">
                                <table id="feedbackTable" class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ratings</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <!-- Feedback rows will be inserted here by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
    var initialFeedback = <?php echo json_encode($recentFeedback ?? []); ?>;
    </script>
    <script src="Scripts/customer-feedback.js"></script>
</body>
</html>