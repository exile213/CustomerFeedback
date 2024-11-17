<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Styles/dashboard_styles.css">
</head>
<body>
    <div class="container">
        <h1>Customer Feedback Dashboard</h1>
        <div class="overview-cards">
            <div class="card">
                <h2>Total Feedback</h2>
                <p class="big-number"><?php echo number_format($totalFeedback); ?></p>
            </div>
            <div class="card">
                <h2>Average Rating</h2>
                <p class="big-number"><?php echo number_format($overviewData['overall'], 1); ?></p>
            </div>
            <div class="card">
                <h2>Positive Feedback</h2>
                <p class="big-number"><?php echo number_format($feedbackPercentages['positive_percentage'], 1); ?>%</p>
            </div>
            <div class="card">
                <h2>Negative Feedback</h2>
                <p class="big-number"><?php echo number_format($feedbackPercentages['negative_percentage'], 1); ?>%</p>
            </div>
        </div>

        <div class="chart-section">
            <h2 class="chartTitle">Feedback Overview</h2>
            <div id="barchart"></div>
            <div id="piechart"></div>
        </div>

        <div class="recent-feedback">
            <h2>Recent Feedback</h2>
            <div id="recent-feedback-list">
                <?php if (!empty($recentFeedback)): ?>
                    <?php foreach ($recentFeedback as $feedback): ?>
                        <div class="feedback-item">
                            <h3><?php echo htmlspecialchars($feedback['name']); ?></h3>
                            <p>Date: <?php echo date('Y-m-d', strtotime($feedback['created_at'])); ?></p>
                            <p>Overall: <?php echo $feedback['overall_rating']; ?>, 
                            Product: <?php echo $feedback['product_rating']; ?>, 
                            Service: <?php echo $feedback['service_rating']; ?>,
                            Purchase: <?php echo $feedback['purchase_rating']; ?>,
                            Recommend: <?php echo $feedback['recommend_rating']; ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No recent feedback available.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="detailed-feedback">
            <h2>Detailed Feedback</h2>
            <div class="controls">
                <input type="text" id="search" placeholder="Search feedbacks...">
                <select id="date-range">
                    <option value="last7days">Last 7 days</option>
                    <option value="last30days">Last 30 days</option>
                    <option value="lastYear">Last year</option>
                </select>
                <button id="export-btn">Export</button>
            </div>
            <table id="feedback-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Overall</th>
                        <th>Product</th>
                        <th>Service</th>
                        <th>Purchase</th>
                        <th>Recommend</th>
                    </tr>
                </thead>
                <tbody id="feedback-table-body"></tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Pass PHP data to JavaScript
        var initialChartData = <?php echo json_encode($chartData); ?>;
        var initialRecentFeedback = <?php echo json_encode($recentFeedback); ?>;
    </script>
    <script src="../Scripts/dashboard_script.js"></script>
</body>
</html>