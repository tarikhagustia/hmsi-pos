<div>
    <div class="card card-statistic-2">
        <div class="card-stats">
            <div class="card-stats-title">Statistik PoS
                <div class="dropdown d-inline float-right">
                    <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month">{{ $selectedBranchName }}</a>
                    <ul class="dropdown-menu dropdown-menu-sm">
                        <li class="dropdown-title">Pilih Cabang</li>
                        @foreach($branches as $b)
                            <li><a href="#" class="dropdown-item {{ $selectedBranchName == $b->name ? 'active' : null }}" wire:click="selectBranch({{ $b->id }}, '{{ $b->name }}')">{{ $b->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="card-chart" wire:ignore>
                <canvas id="balance-chart" height="50" style="width: 100%;"></canvas>
            </div>
        </div>
        <div class="card-icon shadow-primary bg-primary">
            <i class="fas fa-archive"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4>Total Pendapatan</h4>
            </div>
            <div class="card-body">
                {{ Currency::format($totalEarning) }}
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
    <script>
        var balance_chart = document.getElementById("balance-chart").getContext('2d');

        var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);
        balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
        balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

        var myChart = new Chart(balance_chart, {
            type: 'line',
            data: {
                labels: {!! json_encode($period) !!},
                datasets: [{
                    label: 'Earning',
                    data: {{ json_encode($total) }},
                    backgroundColor: balance_chart_bg_color,
                    borderWidth: 3,
                    borderColor: 'rgba(63,82,227,1)',
                    pointBorderWidth: 0,
                    pointBorderColor: 'transparent',
                    pointRadius: 3,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(63,82,227,1)',
                }]
            },
            options: {
                layout: {
                    padding: {
                        bottom: -1,
                        left: -1
                    }
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            beginAtZero: true,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            drawBorder: false,
                            display: false,
                        },
                        ticks: {
                            display: false
                        }
                    }]
                },
            }
        });
    </script>

</div>
