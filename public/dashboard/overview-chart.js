function initializeOverviewChart() {
    const chartCanvas = document.querySelector('#overview-visitors-chart');
    const chartDataElement = document.querySelector('#overview-visitors-data');

    if (!chartCanvas || !chartDataElement || typeof Chart === "undefined") {
        return;
    }

    const visitorsByDay = JSON.parse(chartDataElement.textContent);
    //przechodzimy po każdym kluczu (w tym wypadku dacie)
    const labels = Object.keys(visitorsByDay).map((date) => {
        //roździelamy klucz na osobne elementy np. 2026-02-01 => ['2026', '02', '01']
        const dateParts = date.split('-');

        // zwracamy date z pominieciem roku i roździelamy kropką
        return `${dateParts[2]}.${dateParts[1]}`;
    });

    const visitorCounts = Object.values(visitorsByDay);

    new Chart(chartCanvas, {
        type: 'line',
        data: {
            labels, // labelki na dole wykresu
            datasets: [
                {
                    label: 'Unikalni odwiedzający',
                    data: visitorCounts,
                    borderColor: '#FF3366',
                    backgroundColor: 'rgba(255, 51, 102, 0.12)',
                    borderWidth: 2,
                    tension: 0.35,
                    fill: true,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    displayColors: false,
                    callbacks: {
                        label: (context) => `Unikalni odwiedzający: ${context.parsed.y}`
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        color: '#6c7583',
                        maxTicksLimit: 10
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(23, 29, 41, 0.08)',
                    },
                    ticks: {
                        color: '#6c7583',
                        precision: 0,
                    },
                },
            },
        },
    });
}

initializeOverviewChart();
