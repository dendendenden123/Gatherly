<!-- 

 $chartData should be structured like this:
$chartData = [
  'labels' => [], // array of labels (e.g. ['Jan', 'Feb', 'Mar'])
  'datasets' => [
      [
          'label' => 'Dataset 1',
          'data'  => [...], // array of values for dataset 1
      ],
      [
          'label' => 'Dataset 2',
          'data'  => [...], // array of values for dataset 2
      ],
      [
          'label' => 'Dataset 3',
          'data'  => [...], // array of values for dataset 3
      ],
  ],
   'chartType' => 'line',
];

-->
<canvas id="chart"></canvas>
<script>
    $(document).ready(() => {
        let chartInstance = null;
        function renderChart() {
            const chartData = @json($chartData);
            const chart = document.getElementById('chart').getContext('2d');
            const labels = chartData['labels']
            const colors = [
                { bg: 'rgba(54, 162, 235, 0.1)', border: 'rgba(54, 162, 235, 1)' },   // blue
                { bg: 'rgba(255, 99, 132, 0.1)', border: 'rgba(255, 99, 132, 1)' },   // red
                { bg: 'rgba(75, 192, 192, 0.1)', border: 'rgba(75, 192, 192, 1)' },   // green
                { bg: 'rgba(255, 206, 86, 0.1)', border: 'rgba(255, 206, 86, 1)' },   // yellow
                { bg: 'rgba(153, 102, 255, 0.1)', border: 'rgba(153, 102, 255, 1)' }, // purple
                { bg: 'rgba(255, 159, 64, 0.1)', border: 'rgba(255, 159, 64, 1)' },   // orange
            ];
            const flatten = chartData.datasets.map((dataset, index) => {
                const color = colors[index % colors.length];
                return {
                    label: dataset.label,
                    data: dataset.data,
                    backgroundColor: color.bg,
                    borderColor: color.border,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: color.border,
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    tension: 0.4,
                    fill: true
                }
            });

            console.log('flatten', flatten)

            if (chartInstance !== null) {
                chartInstance.destroy();
            }

            chartInstance = new Chart(chart, {
                type: chartData.chartType,
                data: {
                    labels: labels,
                    datasets: flatten
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

        renderChart()
    })

</script>