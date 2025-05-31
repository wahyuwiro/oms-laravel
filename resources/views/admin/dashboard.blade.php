<x-app-layout>
    <div class="container p-10">
        <h1 class="h1">Admin Dashboard</h1>

        <form method="GET" class="mb-4 row g-3 align-items-end">
            <div class="col-md-3">
                <label for="filter" class="form-label">Filter By</label>
                <select id="filter" name="filter" class="form-select" onchange="toggleCustomDate(this.value)">
                    <option value="7days" {{ $filter === '7days' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30days" {{ $filter === '30days' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="custom" {{ $filter === 'custom' ? 'selected' : '' }}>Custom Range</option>
                </select>
            </div>

            <div class="col-md-3 custom-date" style="display: none;">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
            </div>

            <div class="col-md-3 custom-date" style="display: none;">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
            </div>

            <div class="col-md-3">
                <button class="btn btn-primary">Apply</button>
            </div>
        </form>


        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5>Total Orders</h5>
                        <h3>{{ $totalOrders }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5>Total Sales</h5>
                        <h3>${{ number_format($totalSales, 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5>Active Customers</h5>
                        <h3>{{ $activeCustomers }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body">
                        <h5>Inactive Customers</h5>
                        <h3>{{ $inactiveCustomers }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-8">
                <h3>Orders and Sales by Month (Last 12 Months)</h3>
                <div style="width: 100%;">
                    <canvas id="monthlyOrdersChart"></canvas>
                </div>
            </div>

            <div class="col-md-4 d-flex justify-content-center align-items-center" style="min-height: 300px;">
                <div class="text-center">
                    <h3>Order Status Breakdown</h3>
                    <div style="width: 100%; margin: auto;">
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
            </div>

        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('orderStatusChart').getContext('2d');
            const orderStatusChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: JSON.parse('{!! json_encode($orderStatusCounts->keys()) !!}'),
                    datasets: [{
                        label: 'Orders',
                        data: JSON.parse('{!! json_encode($orderStatusCounts->values()) !!}'),
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)'
                        ],
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        });
    </script>

    <script>
        function toggleCustomDate(value) {
            const customDateFields = document.querySelectorAll('.custom-date');
            customDateFields.forEach(field => {
                field.style.display = value === 'custom' ? 'block' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleCustomDate('{{ $filter }}');
        });
    </script>

<script>
    const monthlyLabels = JSON.parse('{!! json_encode($monthlyLabels) !!}');
    const orderCounts = JSON.parse('{!! json_encode($monthlyOrderCounts) !!}');
    const salesTotals = JSON.parse('{!! json_encode($monthlySalesTotals) !!}');
    console.log(monthlyLabels, orderCounts, salesTotals);

    new Chart(document.getElementById('monthlyOrdersChart'), {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [
                {
                    label: 'Order Count',
                    data: orderCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                },
                {
                    label: 'Total Sales ($)',
                    data: salesTotals,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Order Count'
                    }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false
                    },
                    title: {
                        display: true,
                        text: 'Sales Amount ($)'
                    }
                }
            }
        }
    });
</script>



</x-app-layout>
