@extends('backend.layouts.master')
@section('section-title', 'Sales & Orders Report')
@section('page-title', 'E-Commerce Sales & Orders Report')

@push('css')
<style>
    .report-wrapper {
        font-family: inherit;
    }
    .report-header-bar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
        gap: 12px;
    }
    .report-header-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }
    .report-header-title i {
        color: #4f46e5;
        font-size: 20px;
    }
    .range-filter-btn-group {
        display: inline-flex;
        background: #f1f5f9;
        padding: 3px;
        border-radius: 24px;
        gap: 2px;
    }
    .range-filter-btn {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .range-filter-btn.active, .range-filter-btn:hover {
        background: #ffffff;
        color: #4f46e5;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    .stat-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 18px 20px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
    }
    .stat-card.primary::before { background: #4f46e5; }
    .stat-card.success::before { background: #10b981; }
    .stat-card.warning::before { background: #f59e0b; }
    .stat-card.danger::before { background: #ef4444; }
    .stat-card.info::before { background: #06b6d4; }

    .stat-card-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 6px;
    }
    .stat-card-value {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }
    .stat-card-sub {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 4px;
    }
    .stat-card-icon {
        position: absolute;
        right: 18px;
        top: 18px;
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .stat-card.primary .stat-card-icon { background: #eef2ff; color: #4f46e5; }
    .stat-card.success .stat-card-icon { background: #ecfdf5; color: #10b981; }
    .stat-card.warning .stat-card-icon { background: #fffbeb; color: #f59e0b; }
    .stat-card.danger .stat-card-icon { background: #fef2f2; color: #ef4444; }
    .stat-card.info .stat-card-icon { background: #ecfeff; color: #06b6d4; }

    .chart-box {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        padding: 20px;
        margin-bottom: 20px;
    }
    .chart-box-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }
    .chart-box-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .rank-badge {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
    }
    .rank-1 { background: #fef3c7; color: #d97706; }
    .rank-2 { background: #e2e8f0; color: #475569; }
    .rank-3 { background: #ffedd5; color: #c2410c; }
    .rank-other { background: #f1f5f9; color: #64748b; }
    
    .progress-bar-custom {
        height: 8px;
        border-radius: 4px;
        background: #f1f5f9;
        overflow: hidden;
        margin-top: 4px;
    }
    .progress-bar-fill {
        height: 100%;
        border-radius: 4px;
    }
</style>
@endpush

@section('content')
<div class="report-wrapper">
    <!-- Header Bar -->
    <div class="report-header-bar">
        <div class="report-header-title">
            <i class="fas fa-chart-line"></i>
            <span>E-Commerce Sales & Orders Analytics</span>
            <span class="badge bg-light text-dark border">
                @if($range === 'today') Today
                @elseif($range === '7_days') Last 7 Days
                @elseif($range === '30_days') Last 30 Days
                @elseif($range === 'this_month') This Month
                @else All Time @endif
            </span>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="range-filter-btn-group">
                <a href="{{ route('website-orders.report', ['range' => 'today']) }}" class="range-filter-btn {{ $range === 'today' ? 'active' : '' }}">Today</a>
                <a href="{{ route('website-orders.report', ['range' => '7_days']) }}" class="range-filter-btn {{ $range === '7_days' ? 'active' : '' }}">7 Days</a>
                <a href="{{ route('website-orders.report', ['range' => '30_days']) }}" class="range-filter-btn {{ $range === '30_days' ? 'active' : '' }}">30 Days</a>
                <a href="{{ route('website-orders.report', ['range' => 'this_month']) }}" class="range-filter-btn {{ $range === 'this_month' ? 'active' : '' }}">This Month</a>
            </div>
            <a href="{{ route('website-orders.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Order List
            </a>
            <button onclick="window.print()" class="btn btn-sm btn-primary rounded-pill">
                <i class="fas fa-print me-1"></i> Print Report
            </button>
        </div>
    </div>

    <!-- Stat Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card primary">
                <div class="stat-card-icon"><i class="fas fa-shopping-bag"></i></div>
                <div class="stat-card-label">Total Website Orders</div>
                <div class="stat-card-value">{{ number_format($totalOrders) }}</div>
                <div class="stat-card-sub"><i class="fas fa-calendar-alt me-1"></i> Selected Period</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card success">
                <div class="stat-card-icon"><i class="fas fa-money-bill-wave"></i></div>
                <div class="stat-card-label">Gross Revenue</div>
                <div class="stat-card-value">৳{{ number_format($totalRevenue, 2) }}</div>
                <div class="stat-card-sub"><i class="fas fa-check-circle me-1"></i> All placed orders</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card info">
                <div class="stat-card-icon"><i class="fas fa-box-check"></i></div>
                <div class="stat-card-label">Delivered Orders</div>
                <div class="stat-card-value">{{ number_format($deliveredCount) }}</div>
                <div class="stat-card-sub">Revenue: ৳{{ number_format($deliveredRevenue, 2) }}</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card warning">
                <div class="stat-card-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-card-label">Processing / Pending</div>
                <div class="stat-card-value">{{ number_format($processingCount) }}</div>
                <div class="stat-card-sub">Cancelled: {{ number_format($cancelledCount) }} orders</div>
            </div>
        </div>
    </div>

    <!-- Daily Orders & Sales Trend -->
    <div class="chart-box">
        <div class="chart-box-header">
            <div class="chart-box-title">
                <i class="fas fa-calendar-week text-primary"></i>
                <span>Daily Sales & Orders Trend (Recent 14 Days)</span>
            </div>
            <span class="text-muted small">Updated in real-time</span>
        </div>
        @if($dailyTrend->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 140px;">Date</th>
                        <th style="width: 140px;">Orders Placed</th>
                        <th>Relative Volume</th>
                        <th class="text-end" style="width: 180px;">Daily Revenue (৳)</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $maxDailyTotal = $dailyTrend->max('total') ?: 1;
                    @endphp
                    @foreach($dailyTrend as $day)
                    @php
                        $pct = min(100, round(($day->total / $maxDailyTotal) * 100));
                    @endphp
                    <tr>
                        <td class="fw-bold text-dark">
                            <i class="far fa-calendar text-muted me-1"></i> {{ \Carbon\Carbon::parse($day->date)->format('d M, Y') }}
                        </td>
                        <td>
                            <span class="badge bg-primary rounded-pill px-3">{{ $day->count }} orders</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress-bar-custom flex-grow-1">
                                    <div class="progress-bar-fill bg-indigo" style="width: {{ $pct }}%; background-color: #4f46e5;"></div>
                                </div>
                                <span class="small text-muted" style="width: 40px;">{{ $pct }}%</span>
                            </div>
                        </td>
                        <td class="text-end fw-bold text-success fs-6">
                            ৳{{ number_format($day->total, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-4 text-muted">
            <i class="fas fa-calendar-times fs-2 mb-2"></i>
            <p class="mb-0">No order data found for the recent 14-day window.</p>
        </div>
        @endif
    </div>

    <!-- Two Columns: Top Products & Status Breakdown -->
    <div class="row g-3">
        <!-- Top Products -->
        <div class="col-lg-7">
            <div class="chart-box h-100 mb-0">
                <div class="chart-box-header">
                    <div class="chart-box-title">
                        <i class="fas fa-trophy text-warning"></i>
                        <span>Top 10 Selling Products</span>
                    </div>
                    <span class="text-muted small">By Total Units Sold</span>
                </div>
                @if($topProducts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;">#</th>
                                <th>Product Details</th>
                                <th class="text-center" style="width: 90px;">Units Sold</th>
                                <th class="text-end" style="width: 130px;">Total (৳)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $idx => $prod)
                            <tr>
                                <td>
                                    <span class="rank-badge {{ $idx === 0 ? 'rank-1' : ($idx === 1 ? 'rank-2' : ($idx === 2 ? 'rank-3' : 'rank-other')) }}">
                                        {{ $idx + 1 }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark text-truncate" style="max-width: 280px;" title="{{ $prod->product_name }}">
                                        {{ $prod->product_name }}
                                    </div>
                                    @if($prod->product_code)
                                    <div class="small text-muted">SKU: <code>{{ $prod->product_code }}</code></div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border fw-bold">{{ $prod->total_qty }}</span>
                                </td>
                                <td class="text-end fw-bold text-primary">
                                    ৳{{ number_format($prod->total_amount, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-box-open fs-2 mb-2"></i>
                    <p class="mb-0">No product sales recorded yet.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Side: Status & Courier Breakdown -->
        <div class="col-lg-5">
            <!-- Status Breakdown -->
            <div class="chart-box mb-3">
                <div class="chart-box-header">
                    <div class="chart-box-title">
                        <i class="fas fa-tasks text-info"></i>
                        <span>Orders by Status</span>
                    </div>
                </div>
                @if($statusBreakdown->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($statusBreakdown as $sb)
                    @php
                        $statusPct = $totalOrders > 0 ? round(($sb->count / $totalOrders) * 100) : 0;
                        $colorClass = match($sb->status) {
                            'approved', 'delivered', 'completed' => 'success',
                            'processing' => 'primary',
                            'pending' => 'warning',
                            'cancelled', 'returned' => 'danger',
                            default => 'secondary'
                        };
                    @endphp
                    <div class="list-group-item px-0 py-2 border-0">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold text-capitalize">
                                <span class="badge bg-{{ $colorClass }} me-1">&bull;</span> {{ $sb->status ?: 'Unknown' }}
                            </span>
                            <span class="fw-bold text-dark">{{ $sb->count }} orders (৳{{ number_format($sb->total, 0) }})</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-bar-fill bg-{{ $colorClass }}" style="width: {{ $statusPct }}%;"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted small mb-0 text-center py-3">No status data available.</p>
                @endif
            </div>

            <!-- Courier Breakdown -->
            <div class="chart-box mb-0">
                <div class="chart-box-header">
                    <div class="chart-box-title">
                        <i class="fas fa-truck text-secondary"></i>
                        <span>Orders by Courier</span>
                    </div>
                </div>
                @if($courierBreakdown->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($courierBreakdown as $cb)
                    @php
                        $courierPct = $totalOrders > 0 ? round(($cb->count / $totalOrders) * 100) : 0;
                    @endphp
                    <div class="list-group-item px-0 py-2 border-0">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold text-capitalize">
                                <i class="fas fa-shipping-fast text-muted me-1"></i> {{ $cb->courier_service ?: 'Not Assigned' }}
                            </span>
                            <span class="badge bg-light text-dark border">{{ $cb->count }} orders</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-bar-fill bg-dark" style="width: {{ $courierPct }}%;"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted small mb-0 text-center py-3">No courier data available.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
