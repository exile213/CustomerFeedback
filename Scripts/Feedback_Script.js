// Feedback_Script.js

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('feedbackForm');
    const starRatings = document.querySelectorAll('.star-rating');

    starRatings.forEach(rating => {
        rating.addEventListener('click', handleStarClick);
    });

    form.addEventListener('submit', handleSubmit);
});

function handleStarClick(event) {
    if (event.target.classList.contains('fas')) {
        const stars = event.currentTarget.querySelectorAll('.fas');
        const clickedValue = parseInt(event.target.getAttribute('data-value'));

        stars.forEach(star => {
            const starValue = parseInt(star.getAttribute('data-value'));
            if (starValue <= clickedValue) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
    }
}

async function handleSubmit(event) {
    event.preventDefault();
    
    const name = document.getElementById('name').value;
    const date = document.getElementById('date').value;
    const ratings = {};
    
    document.querySelectorAll('.star-rating').forEach(rating => {
        const ratingName = rating.getAttribute('data-rating');
        const activeStars = rating.querySelectorAll('.fas.active');
        ratings[ratingName] = activeStars.length;
    });
    
    // Validate input
    if (!name || !date || Object.values(ratings).some(rating => rating === 0)) {
        alert('Please fill in all fields and provide ratings.');
        return;
    }

    const feedbackData = {
        name: name,
        date: date,
        ratings: ratings
    };

    try {
        const response = await fetch('feedback.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(feedbackData),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();

        if (result.success) {
            alert('Thank you for your feedback!');
            form.reset();
            document.querySelectorAll('.fas.active').forEach(star => star.classList.remove('active'));
        } else {
            alert('Error submitting feedback: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while submitting your feedback. Please try again.');
    }
}