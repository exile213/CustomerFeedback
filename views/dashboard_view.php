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
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white p-4">
            <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
            <nav>
                <ul>
                    <li class="mb-2"><a href="#" class="block p-2 hover:bg-gray-700 rounded">Overview</a></li>
                    <li class="mb-2"><a href="#" class="block p-2 hover:bg-gray-700 rounded">Feedback</a></li>
                    <li class="mb-2"><a href="#" class="block p-2 hover:bg-gray-700 rounded">Reports</a></li>
                    <li class="mb-2"><a href="#" class="block p-2 hover:bg-gray-700 rounded">Settings</a></li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navigation bar -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
                    <div>
                        <form method="post" class="inline">
                            <button type="submit" name="logout" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">Logout</button>
                        </form>
                    </div>
                </div>
            </header>


            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    <!-- Overview Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-xl font-semibold mb-2">Total Feedback</h2>
                            <p class="text-3xl font-bold"><?php echo number_format($totalFeedback); ?></p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-xl font-semibold mb-2">Average Rating</h2>
                            <p class="text-3xl font-bold"><?php echo number_format($overviewData['overall'], 1); ?></p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-xl font-semibold mb-2">Positive Feedback</h2>
                            <p class="text-3xl font-bold"><?php echo number_format($feedbackPercentages['positive_percentage'], 1); ?>%</p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-xl font-semibold mb-2">Negative Feedback</h2>
                            <p class="text-3xl font-bold"><?php echo number_format($feedbackPercentages['negative_percentage'], 1); ?>%</p>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-xl font-semibold mb-4">Feedback Overview</h2>
                            <div id="barchart" class="h-64"></div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-xl font-semibold mb-4">Feedback Distribution</h2>
                            <div id="piechart" class="h-64"></div>
                        </div>
                    </div>

                    <!-- Recent Feedback -->
                    <div class="bg-white rounded-lg shadow p-6 mb-8">
                        <h2 class="text-xl font-semibold mb-4">Recent Feedback</h2>
                        <div id="recent-feedback-list">
                            <?php if (!empty($recentFeedback)): ?>
                                <?php foreach ($recentFeedback as $feedback): ?>
                                    <div class="border-b border-gray-200 py-4 last:border-b-0">
                                        <h3 class="font-semibold"><?php echo htmlspecialchars($feedback['name']); ?></h3>
                                        <p class="text-sm text-gray-600">Date: <?php echo date('Y-m-d', strtotime($feedback['created_at'])); ?></p>
                                        <p class="mt-2">
                                            Overall: <?php echo $feedback['overall_rating']; ?>, 
                                            Product: <?php echo $feedback['product_rating']; ?>, 
                                            Service: <?php echo $feedback['service_rating']; ?>,
                                            Purchase: <?php echo $feedback['purchase_rating']; ?>,
                                            Recommend: <?php echo $feedback['recommend_rating']; ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No recent feedback available.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Detailed Feedback -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold mb-4">Detailed Feedback</h2>
                        <div class="flex flex-wrap gap-4 mb-4">
                            <input type="text" id="search" placeholder="Search feedbacks..." class="border rounded px-3 py-2 w-full sm:w-auto">
                            <select id="date-range" class="border rounded px-3 py-2">
                                <option value="last7days">Last 7 days</option>
                                <option value="last30days">Last 30 days</option>
                                <option value="lastYear">Last year</option>
                            </select>
                            <button id="export-btn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Export</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table id="feedback-table" class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-left">Name</th>
                                        <th class="px-4 py-2 text-left">Overall</th>
                                        <th class="px-4 py-2 text-left">Product</th>
                                        <th class="px-4 py-2 text-left">Service</th>
                                        <th class="px-4 py-2 text-left">Purchase</th>
                                        <th class="px-4 py-2 text-left">Recommend</th>
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
        var initialChartData = <?php echo json_encode($chartData); ?>;
        var initialRecentFeedback = <?php echo json_encode($recentFeedback); ?>;
    </script>
        <script src="Scripts/dashboard_script.js"></script>
</body>
</html>