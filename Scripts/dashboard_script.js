// Create and update charts
function createCharts(chartData, feedbackPercentages) {
    const barctx  = document.createElement('canvas');
    const piectx  = document.createElement('canvas');
    document.getElementById('barchart').appendChild(barctx);
    document.getElementById('piechart').appendChild(piectx);
    
    // Bar Chart
    new Chart(barctx, {
        type: 'bar',
        data: {
            labels: chartData.map(item => item.name),
            datasets: [{
                label: 'Average Rating',
                data: chartData.map(item => item.value),
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Pie Chart
    new Chart(piectx, {
        type: 'pie',
        data: {
            labels: ['Positive', 'Negative'],
            datasets: [{
                data: [
                    feedbackPercentages.positive_percentage,
                    feedbackPercentages.negative_percentage
                ],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 99, 132, 0.6)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
}

// Populate detailed feedback table
function populateTable(recentFeedback) {
    const tableBody = document.getElementById('feedback-table-body');
    tableBody.innerHTML = ''; // Clear existing content

    recentFeedback.forEach(feedback => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-4 py-2">${new Date(feedback.feedback_date).toLocaleDateString()}</td>
            <td class="px-4 py-2">${feedback.Name}</td>
            <td class="px-4 py-2">${feedback.ratings}</td>
            <td class="px-4 py-2">${feedback.comments || ''}</td>
        `;
        tableBody.appendChild(row);
    });
}

// Search functionality
document.getElementById('search').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#feedback-table-body tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Export functionality
document.getElementById('export-btn').addEventListener('click', function() {
    const table = document.getElementById('feedback-table');
    const rows = Array.from(table.querySelectorAll('tr'));
    
    let csvContent = "data:text/csv;charset=utf-8,";
    
    // Add headers
    const headers = Array.from(rows[0].querySelectorAll('th'))
        .map(header => header.textContent);
    csvContent += headers.join(',') + '\n';
    
    // Add data rows
    rows.slice(1).forEach(row => {
        const cells = Array.from(row.querySelectorAll('td'))
            .map(cell => cell.textContent);
        csvContent += cells.join(',') + '\n';
    });
    
    // Create download link
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement('a');
    link.setAttribute('href', encodedUri);
    link.setAttribute('download', 'Feedback-Report.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    createCharts(chartData, feedbackPercentages);
    populateTable(recentFeedback);
});