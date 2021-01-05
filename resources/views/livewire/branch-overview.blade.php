<div>
    <div class="card card-statistic-2">
        <div class="card-stats">
            <div class="card-stats-title">Statistik Cabang
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
            <div class="card-stats-items mb-4">
                <div class="card-stats-item">
                    <div class="card-stats-item-count">{{ $totalStudent }}</div>
                    <div class="card-stats-item-label">Kategori</div>
                </div>
                <div class="card-stats-item">
                    <div class="card-stats-item-count">{{ number_format($totalTeacher) }}</div>
                    <div class="card-stats-item-label">Produk</div>
                </div>

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

</div>
