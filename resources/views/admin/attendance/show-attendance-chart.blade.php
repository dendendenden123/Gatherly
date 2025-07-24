<div id='aggregatedChartData' data-present='@json($aggregatedChartDataForAttended)'
    data-absent='@json($aggregatedChartDataForAbsent)'>
</div>
<canvas id="attendanceChart"></canvas>

<script>
    let attendanceChartInstance = null;
    // Get chart data from PHP
    // Render the attendance chart
    function renderAttendanceChart() {
        if (attendanceChartInstance !== null) {
            attendanceChartInstance.destroy();
        }

        // Read updated chart data from hidden element
        const absentData = document.getElementById('aggregatedChartData').dataset.absent;
        const presentData = document.getElementById('aggregatedChartData').dataset.present;
        const aggregatedChartDataForAbsent = JSON.parse(absentData);
        const aggregatedChartDataForPresent = JSON.parse(presentData);

        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const presentlabels = aggregatedChartDataForPresent.map(item => item.label);
        const presentdataValues = aggregatedChartDataForPresent.map(item => item.value);

        const absentlabels = aggregatedChartDataForAbsent.map(item => item.label);
        const absentdataValues = aggregatedChartDataForAbsent.map(item => item.value);

        attendanceChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: presentlabels,
                datasets: [{
                    label: 'Present',
                    data: presentdataValues,
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: 'rgba(99, 102, 241, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Absent',
                    data: absentdataValues,
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderColor: 'rgba(235, 21, 60, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: 'gba(235, 21, 60, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12,
                                weight: '500'
                            },
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            family: "'Inter', sans-serif",
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            family: "'Inter', sans-serif",
                            size: 12
                        },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function (context) {
                                return context.parsed.y + '';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12
                            },
                            callback: value => value + ''
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12
                            }
                        }
                    }
                },
                elements: {
                    line: {
                        borderJoinStyle: 'round',
                        borderCapStyle: 'round'
                    }
                }
            }
        });
    }
</script>