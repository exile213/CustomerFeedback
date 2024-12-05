<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
    <?php require "views/Partials/sidebar.php"?>

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navigation bar -->
            <header class="bg-indigo-500 border-b">
                <div class="flex justify-between items-center px-6 py-4">
                    <h1 class="text-xl font-semibold text-gray-800">Admin Dashboard</h1>
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="pl-8 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <form method="post" class="inline">
                            <button type="submit" name="logout" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Sign out</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                <div class="max-w-7xl mx-auto">
                    <!-- Overview Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h2 class="text-sm font-medium text-gray-500">Total Feedback</h2>
                                    <p class="text-2xl font-semibold mt-1"><?php echo number_format($totalFeedback); ?></p>
                                </div>
                                <div class="p-2 bg-indigo-100 rounded-lg">
                                    <i class="fas fa-comments text-indigo-600"></i>
                                </div>
                            </div>

                        </div>
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h2 class="text-sm font-medium text-gray-500">Average Rating</h2>
                                    <p class="text-2xl font-semibold mt-1"><?php echo number_format($overviewData['Overall Satisfaction'] ?? 0, 1); ?></p>
                                </div>
                                <div class="p-2 bg-yellow-100 rounded-lg">
                                    <i class="fas fa-star text-yellow-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h2 class="text-sm font-medium text-gray-500">Positive Rating</h2>
                                    <p class="text-2xl font-semibold mt-1"><?php echo number_format($feedbackPercentages['positive_percentage'], 1); ?>%</p>
                                </div>
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <i class="fas fa-thumbs-up text-green-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h2 class="text-sm font-medium text-gray-500">Negative Rating</h2>
                                    <p class="text-2xl font-semibold mt-1"><?php echo number_format($feedbackPercentages['negative_percentage'], 1); ?>%</p>
                                </div>
                                <div class="p-2 bg-red-100 rounded-lg">
                                    <i class="fas fa-thumbs-down text-red-600"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-semibold">Rating Overview</h2>
                                <p class="text-sm text-gray-500">Average Ratings</p>
                            </div>
                            <div id="barchart" class="h-64"></div>
                        </div>
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-semibold">Rating Distribution</h2>
                                <p class="text-sm text-gray-500">Current year statistics</p>
                            </div>
                            <div id="piechart" class="h-64"></div>
                        </div>
                    </div>

                    <!-- Recent Feedback -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                        <h2 class="text-lg font-semibold mb-4">Recent Feedback</h2>
                        <div id="recent-feedback-list">
                            <?php if (!empty($recentFeedback)): ?>
                                <?php foreach ($recentFeedback as $feedback): ?>
                                    <div class="border-b border-gray-200 py-4 last:border-b-0">
                                        <h3 class="font-semibold"><?php echo htmlspecialchars($feedback['Name']); ?></h3>
                                        <p class="text-sm text-gray-600">Date: <?php echo date('Y-m-d', strtotime($feedback['feedback_date'])); ?></p>
                                        <p class="mt-2">
                                            <?php echo htmlspecialchars($feedback['ratings']); ?>
                                        </p>
                                        <?php if (!empty($feedback['comments'])): ?>
                                            <p class="mt-2 text-gray-700"><?php echo htmlspecialchars($feedback['comments']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No recent feedback available.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Detailed Feedback -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold mb-4">Detailed Feedback</h2>
                        <div class="flex flex-wrap gap-4 mb-4">
                            <input type="text" id="search" placeholder="Search feedbacks..." class="border rounded-lg px-3 py-2 w-full sm:w-auto focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <select id="date-range" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="last7days">Last 7 days</option>
                                <option value="last30days">Last 30 days</option>
                                <option value="lastYear">Last year</option>
                            </select>
                            <button id="export-btn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Export</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table id="feedback-table" class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ratings</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comments</th>
                                    </tr>
                                </thead>
                                <tbody id="feedback-table-body"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <script>
    var chartData = <?php echo json_encode($chartData); ?>;
    var feedbackPercentages = <?php echo json_encode($feedbackPercentages); ?>;
    var recentFeedback = <?php echo json_encode($recentFeedback); ?>;
</script>
<script src="Scripts/dashboard_script.js"></script>

</body>
</html>