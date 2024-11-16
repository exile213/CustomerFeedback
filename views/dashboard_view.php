<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Feedback Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Styles/dashboard_styles.css">
</head>
<body>
    <div class="container">
        <h1>Employee Feedback Dashboard</h1>
        <div class="overview-cards">
            <div class="card">
                <h2>Total Feedback</h2>
                <p class="big-number">1,234</p>
                <p class="small-text">+20.1% from last month</p>
            </div>
            <div class="card">
                <h2>Average Rating</h2>
                <p class="big-number">4.2</p>
                <p class="small-text">+0.2 from last month</p>
            </div>
            <div class="card">
                <h2>Positive Feedback</h2>
                <p class="big-number">85%</p>
                <p class="small-text">+2% from last month</p>
            </div>
            <div class="card">
                <h2>Negative Feedback</h2>
                <p class="big-number">15%</p>
                <p class="small-text">-2% from last month</p>
            </div>
        </div>

        <div class="chart-section">
            <h2>Feedback Overview</h2>
            <div id="chart"></div>
        </div>

        <div class="recent-feedback">
            <h2>Recent Feedback</h2>
            <div id="recent-feedback-list"></div>
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
    <script src="../Scripts/dashboard_script.js"></script>
</body>
</html>