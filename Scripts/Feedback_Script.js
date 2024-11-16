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

function handleSubmit(event) {
    event.preventDefault();
    
    const name = document.getElementById('name').value;
    const date = document.getElementById('date').value;
    const ratings = {};
    
    document.querySelectorAll('.star-rating').forEach(rating => {
        const ratingName = rating.getAttribute('data-rating');
        const activeStars = rating.querySelectorAll('.fas.active');
        ratings[ratingName] = activeStars.length;
    });
    
    console.log('Feedback submitted:', {
        name: name,
        date: date,
        ratings: ratings
    });
    
    alert('Thank you for your feedback!');
    event.target.reset();
    document.querySelectorAll('.fas.active').forEach(star => star.classList.remove('active'));
}