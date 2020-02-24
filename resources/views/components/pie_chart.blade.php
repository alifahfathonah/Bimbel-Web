<!-- Pie Chart -->
<div class="col-xl-3 col-lg-5">
    <div class="card shadow">
        <!-- Card Header - Dropdown -->
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-pie">
                <canvas id="myPieChart"></canvas>
            </div>
            <div class="text-center small">
                @foreach ($labels as $label)
                <span class="mr-2 d-block">
                    <i class="fas fa-circle" style="color: {{ $colors[$loop->index] }}"></i>
                    {{ $label }}
                </span>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="{{ asset('js/chart.min.js') }}"></script>

<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontColor = '#858796';

    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($labels),
            datasets: [{
                data: @json($chart_data),
                backgroundColor: @json($colors),
                hoverBackgroundColor: ['#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
</script>
@endpush
