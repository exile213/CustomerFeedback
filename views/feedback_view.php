<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="Styles/Feedback_styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <h1>Customer Feedback</h1>
        <form id="feedbackForm">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="date">Date of Feedback:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label>How satisfied were you with your overall experience today?</label>
                <div class="star-rating" data-rating="rating1">
                    <i class="fas fa-star" data-value="1"></i>
                    <i class="fas fa-star" data-value="2"></i>
                    <i class="fas fa-star" data-value="3"></i>
                    <i class="fas fa-star" data-value="4"></i>
                    <i class="fas fa-star" data-value="5"></i>
                </div>
            </div>
            <div class="form-group">
                <label>How would you rate the quality of the product you purchased?</label>
                <div class="star-rating" data-rating="rating2">
                    <i class="fas fa-star" data-value="1"></i>
                    <i class="fas fa-star" data-value="2"></i>
                    <i class="fas fa-star" data-value="3"></i>
                    <i class="fas fa-star" data-value="4"></i>
                    <i class="fas fa-star" data-value="5"></i>
                </div>
            </div>
            <div class="form-group">
                <label>How would you rate the service provided by our staff?</label>
                <div class="star-rating" data-rating="rating3">
                    <i class="fas fa-star" data-value="1"></i>
                    <i class="fas fa-star" data-value="2"></i>
                    <i class="fas fa-star" data-value="3"></i>
                    <i class="fas fa-star" data-value="4"></i>
                    <i class="fas fa-star" data-value="5"></i>
                </div>
            </div>
            <div class="form-group">
                <label>How easy was it to complete your purchase?</label>
                <div class="star-rating" data-rating="rating4">
                    <i class="fas fa-star" data-value="1"></i>
                    <i class="fas fa-star" data-value="2"></i>
                    <i class="fas fa-star" data-value="3"></i>
                    <i class="fas fa-star" data-value="4"></i>
                    <i class="fas fa-star" data-value="5"></i>
                </div>
            </div>
            <div class="form-group">
                <label>How likely are you to recommend us to a friend or family member?</label>
                <div class="star-rating" data-rating="rating5">
                    <i class="fas fa-star" data-value="1"></i>
                    <i class="fas fa-star" data-value="2"></i>
                    <i class="fas fa-star" data-value="3"></i>
                    <i class="fas fa-star" data-value="4"></i>
                    <i class="fas fa-star" data-value="5"></i>
                </div>
            </div>
            <button type="submit">Submit Feedback</button>
        </form>
    </div>
    <script src="Scripts/Feedback_Script.js"></script>
</body>
</html>