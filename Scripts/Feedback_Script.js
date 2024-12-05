document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('feedbackForm');
    const starRatings = document.querySelectorAll('.star-rating');

    starRatings.forEach(rating => {
        rating.addEventListener('click', handleStarClick);
        rating.addEventListener('mouseover', handleStarHover);
        rating.addEventListener('mouseout', handleStarOut);
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
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400', 'active');
            } else {
                star.classList.remove('text-yellow-400', 'active');
                star.classList.add('text-gray-300');
            }
        });
    }
}

function handleStarHover(event) {
    if (event.target.classList.contains('fas')) {
        const stars = event.currentTarget.querySelectorAll('.fas');
        const hoverValue = parseInt(event.target.getAttribute('data-value'));
        
        stars.forEach(star => {
            const starValue = parseInt(star.getAttribute('data-value'));
            if (starValue <= hoverValue) {
                star.classList.add('text-yellow-400');
                star.classList.remove('text-gray-300');
            }
        });
    }
}

function handleStarOut(event) {
    const stars = event.currentTarget.querySelectorAll('.fas');
    stars.forEach(star => {
        if (!star.classList.contains('active')) {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    });
}

async function handleSubmit(event) {
    event.preventDefault();
    
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const date = document.getElementById('date').value;
    const comments = document.getElementById('comments').value;
    const ratings = {};
    
    document.querySelectorAll('.star-rating').forEach(rating => {
        const ratingName = rating.getAttribute('data-rating');
        const activeStars = rating.querySelectorAll('.active');
        ratings[ratingName] = activeStars.length;
    });
    
    if (!name || !email || !phone || !date || Object.values(ratings).some(rating => rating === 0)) {
        alert('Please fill in all fields and provide ratings.');
        return;
    }

    const feedbackData = {
        name: name,
        email: email,
        phone: phone,
        date: date,
        comments: comments,
        ratings: ratings
    };

    try {
        const response = await fetch('controllers/feedback.php', {
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
        console.log(result); // Log 

        if (result.success) {
            alert('Thank you for your feedback!');
            document.getElementById('feedbackForm').reset();
            document.querySelectorAll('.fas').forEach(star => {
                star.classList.remove('text-yellow-400', 'active');
                star.classList.add('text-gray-300');
            });
        } else {
            throw new Error(result.message || 'An error occurred while submitting your feedback.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while submitting your feedback. Please try again.');
    }
}

