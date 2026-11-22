@extends('backend.layouts.master')
@section('page-title', __('Dashboard'))
@push('css')
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .dark .glass-card {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
       .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        } 
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }
        .filter-nav .nav-link {
            color: #64748b;
            font-weight: 500;
            padding: 8px 20px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .filter-nav .nav-link.active {
            background-color: #3b82f6;
            color: white !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
    </style>
@endpush

@section('content')
    @php
        $userBranchId = auth()->user()->branch_id;
        $filterBranchId = session('branch_filter_id', null);
        $branchIdForQuery = ($userBranchId == 1 && $filterBranchId) ? $filterBranchId : ($userBranchId == 1 ? null : $userBranchId);

        $invoiceQuery = App\Models\Invoice::query();
        $total_return_query = App\Models\ReturnTbl::query();
        $total_purchase_query = App\Models\Purchase::query();
        $return_purchase_query = App\Models\ReturnPurchase::query();
        $baseQuery = App\Models\Invoice::where('sale_type', 'Online');
        $top_selling_query = App\Models\InvoiceItem::select('product_id', \DB::raw('SUM(main_qty) as total_qty'));

        if ($branchIdForQuery) {
            $invoiceQuery->where('branch_id', $branchIdForQuery);
            $total_return_query->where('branch_id', $branchIdForQuery);
            $total_purchase_query->where('branch_id', $branchIdForQuery);
            $return_purchase_query->where('branch_id', $branchIdForQuery);
            $baseQuery->where('branch_id', $branchIdForQuery);
            $top_selling_query->where('branch_id', $branchIdForQuery);
        }

        $total_invoice = App\Models\Invoice::getFakeSum($invoiceQuery, 'total_amount');
        $total_return = $total_return_query->sum('total_return');
        $total_purchase = $total_purchase_query->sum('total_amount');
        $return_purchase = $return_purchase_query->sum('total_return');
        $currency = '৳';

        // Online Sale Order Summary Counts matching Online Sale List statuses
        $online_order_counts = [
            'all'             => (clone $baseQuery)->count(),
            'processing'      => (clone $baseQuery)->where('order_status', 'processing')->count(),
            'rts'             => (clone $baseQuery)->where('order_status', 'rts')->count(),
            'in_review'       => (clone $baseQuery)->where('order_status', 'in_review')->count(),
            'pending_courier' => (clone $baseQuery)->whereIn('order_status', ['pending', 'pending_courier'])->count(),
            'in_transit'      => (clone $baseQuery)->where('order_status', 'in_transit')->count(),
            'all_in_courier'  => (clone $baseQuery)->whereNotNull('consignment_id')->where('consignment_id', '!=', '')->count(),
            'on_hold'         => (clone $baseQuery)->whereIn('order_status', ['on_hold', 'hold'])->count(),
            'delivered'       => (clone $baseQuery)->where('order_status', 'delivered')->count(),
            'partial'         => (clone $baseQuery)->whereIn('order_status', ['partial', 'partial_delivered'])->count(),
            'pending_return'  => (clone $baseQuery)->where('order_status', 'pending_return')->count(),
            'returned'        => (clone $baseQuery)->where(function($q) {
                $q->where('status', 2)->orWhereIn('order_status', ['returned']);
            })->count(),
            'cancelled'       => (clone $baseQuery)->whereIn('order_status', ['cancelled', 'cancelled_approval_pending'])->count(),
        ];

        // Top Selling Products Query
        $top_selling_products = $top_selling_query->groupBy('product_id')
            ->orderBy('total_qty', 'desc')
            ->limit(10)
            ->with('product')
            ->get();
    @endphp

    <div class="">
        <!-- Header & Filter -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                @php
                    $hour = date('H');
                    $greeting = '';
                    if ($hour >= 5 && $hour < 12) {
                        $greeting = 'Good Morning';
                    } elseif ($hour >= 12 && $hour < 17) {
                        $greeting = 'Good Afternoon';
                    } elseif ($hour >= 17 && $hour < 21) {
                        $greeting = 'Good Evening';
                    } else {
                        $greeting = 'Welcome back';
                    }
                @endphp
                <h1 class="text-lg font-extrabold text-slate-800 dark:text-white tracking-tight leading-tight">
                    {{ __($greeting) }}, <span class="text-blue-600 font-black">{{ Auth::user()->name ?? __('Admin') }}</span>
                </h1>
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-2 uppercase tracking-widest">
                    <i class="fa-solid fa-calendar-day text-xs text-slate-400"></i>
                    {{ date('l, d F Y') }}
                </p>
            </div>
            
            <!-- Responsive Filter Nav & Summary Report Controls -->
            <style>
                .hide-scroll::-webkit-scrollbar { display: none; }
                .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
            </style>
            <div class="flex flex-wrap items-center gap-2">
                <!-- Date Filter Input Box -->
                <div class="flex items-center gap-1.5 bg-white dark:bg-slate-800 p-1.5 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                    <input type="date" id="dashStartDate" value="{{ date('Y-m-d') }}" 
                        class="text-xs py-1 px-2 rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 text-slate-700 font-bold">
                    <span class="text-xs text-slate-400 font-black">-</span>
                    <input type="date" id="dashEndDate" value="{{ date('Y-m-d') }}" 
                        class="text-xs py-1 px-2 rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 text-slate-700 font-bold">
                    <button type="button" id="btnGenCustomSummary" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                        <i class="fas fa-file-invoice"></i> {{ __('Summary Report') }}
                    </button>
                </div>

                <form action="{{ route('dashboard') }}" method="GET" id="filterForm" class="bg-white dark:bg-slate-800 p-1 h-[46px] rounded-lg md:rounded-lg shadow-sm border border-slate-100 dark:border-slate-700 max-w-full">
                    <ul class="flex overflow-x-auto gap-1 filter-nav hide-scroll pb-1 md:pb-0" id="filterNav">
                        <li><a class="nav-link active whitespace-nowrap px-3.5 py-2 rounded-lg block text-sm font-semibold text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-blue-600 transition-colors" href="#" data-filter="Today">{{ __('Today') }}</a></li>
                        <li><a class="nav-link whitespace-nowrap px-3.5 py-2 rounded-lg block text-sm font-semibold text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-blue-600 transition-colors" href="#" data-filter="Yesterday">{{ __('Yesterday') }}</a></li>
                        <li><a class="nav-link whitespace-nowrap px-3.5 py-2 rounded-lg block text-sm font-semibold text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-blue-600 transition-colors" href="#" data-filter="This-week">{{ __('This Week') }}</a></li>
                        <li><a class="nav-link whitespace-nowrap px-3.5 py-2 rounded-lg block text-sm font-semibold text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-blue-600 transition-colors" href="#" data-filter="This-month">{{ __('This Month') }}</a></li>
                        <li><a class="nav-link whitespace-nowrap px-3.5 py-2 rounded-lg block text-sm font-semibold text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-blue-600 transition-colors" href="#" data-filter="This-year">{{ __('This Year') }}</a></li>
                    </ul>
                </form>
            </div>
        </div>

        <!-- Primary Filtered Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 mb-6">
            <!-- Total Sale Amount Card -->
            <a href="{{ route('invoice.index') }}" class="block group">
                <div class="stat-card bg-white dark:bg-slate-800 rounded-lg shadow-sm border-t-4 border-indigo-500 p-3 flex flex-col justify-between h-full">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-2xl font-bold text-slate-800 dark:text-white flex items-baseline">
                                <span class="text-base font-medium text-slate-400 mr-1">{{ $currency }}</span>
                                <span>{{ number_format($total_invoice, 0) }}</span>
                            </h4>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mt-1">{{ __('Total Sale') }}<br>{{ __('Amount') }}</p>
                        </div>
                        <div class="w-9 h-9 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500">
                            <i class="fas fa-sack-dollar text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-2 pt-1.5 border-t border-slate-50 dark:border-slate-700 flex justify-between items-center text-xs">
                        <span class="text-slate-400 dark:text-slate-500">{{ __('Lifetime Total') }}</span>
                    </div>
                </div>
            </a>

            <!-- Sale Card -->
            <a href="{{ route('invoice.index') }}" class="block group">
                <div class="stat-card bg-white dark:bg-slate-800 rounded-lg shadow-sm border-t-4 border-emerald-500 p-3 flex flex-col justify-between h-full">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-2xl font-bold text-slate-800 dark:text-white flex items-baseline">
                                <span class="text-base font-medium text-slate-400 mr-1">{{ $currency }}</span>
                                <span id="saleAmount">{{ number_format($data['sale'], 0) }}</span>
                            </h4>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mt-1"><span class="filterName">{{ __('Today') }}</span> {{ __('Sale') }}</p>
                        </div>
                        <div class="w-9 h-9 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500">
                            <i class="fas fa-shopping-cart text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-2 pt-1.5 border-t border-slate-50 dark:border-slate-700 flex justify-between items-center text-xs">
                        <span class="flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 font-semibold border dark:border-emerald-800/50">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> {{ __('Live') }}
                        </span>
                        <span class="text-slate-400 dark:text-slate-500">{{ __('Updated now') }}</span>
                    </div>
                </div>
            </a>

            <!-- Purchase Card -->
            @if (check_permission('dashboard.dashboard'))
            <a href="{{ route('purchase.index') }}" class="block group">
                <div class="stat-card bg-white dark:bg-slate-800 rounded-lg shadow-sm border-t-4 border-blue-500 p-3 flex flex-col justify-between h-full">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-2xl font-bold text-slate-800 dark:text-white flex items-baseline">
                                <span class="text-base font-medium text-slate-400 mr-1">{{ $currency }}</span>
                                <span id="purchaseAmount">{{ number_format($data['purchase'], 0) }}</span>
                            </h4>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mt-1"><span class="filterName">{{ __('Today') }}</span> {{ __('Purchase') }}</p>
                        </div>
                        <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500">
                            <i class="fas fa-bag-shopping text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-2 pt-1.5 border-t border-slate-50 dark:border-slate-700 flex justify-between items-center text-xs">
                        <span class="flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold border dark:border-blue-800/50">
                            <i class="fas fa-arrow-up text-[10px]"></i> {{ __('Synced') }}
                        </span>
                        <span class="text-slate-400 dark:text-slate-500">{{ __('Active') }}</span>
                    </div>
                </div>
            </a>
            @endif

            <!-- Expense Card -->
            <a href="{{ route('expense.index') }}" class="block group">
                <div class="stat-card bg-white dark:bg-slate-800 rounded-lg shadow-sm border-t-4 border-orange-500 p-3 flex flex-col justify-between h-full">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-2xl font-bold text-slate-800 dark:text-white flex items-baseline">
                                <span class="text-base font-medium text-slate-400 mr-1">{{ $currency }}</span>
                                <span id="expenseAmount">{{ number_format($data['expense'], 0) }}</span>
                            </h4>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mt-1"><span class="filterName">{{ __('Today') }}</span> {{ __('Expense') }}</p>
                        </div>
                        <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center text-orange-500">
                            <i class="fas fa-money-bill-transfer text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-2 pt-1.5 border-t border-slate-50 dark:border-slate-700 flex justify-between items-center text-xs">
                        <span class="flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 font-semibold border dark:border-orange-800/50">
                            <i class="fas fa-receipt text-[10px]"></i> {{ __('Pending') }}
                        </span>
                        <span class="text-slate-400 dark:text-slate-500">{{ __('Bills due') }}</span>
                    </div>
                </div>
            </a>

            <!-- Profit Card -->
            @if (check_permission('dashboard.dashboard'))
            <a href="{{ route('report.profit-loss') }}" class="block group">
                <div class="stat-card bg-white dark:bg-slate-800 rounded-lg shadow-sm border-t-4 border-purple-500 p-3 flex flex-col justify-between h-full">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-2xl font-bold text-slate-800 dark:text-white flex items-baseline">
                                <span class="text-base font-medium text-slate-400 mr-1">{{ $currency }}</span>
                                <span id="profitAmount">{{ number_format($data['profit'], 0) }}</span>
                            </h4>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mt-1"><span class="filterName">{{ __('Today') }}</span> {{ __('Profit') }}</p>
                        </div>
                        <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center text-purple-500">
                            <i class="fas fa-chart-line text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-2 pt-1.5 border-t border-slate-50 dark:border-slate-700 flex justify-between items-center text-xs">
                        <span class="flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 font-semibold border dark:border-purple-800/50">
                            <i class="fas fa-trending-up text-[10px]"></i> {{ __('Growth') }}
                        </span>
                        <span class="text-slate-400 dark:text-slate-500">{{ __('View report') }}</span>
                    </div>
                </div>
            </a>
            @endif
        </div>

        @if (env('APP_ONLINE') == 'yes')
        <!-- Order Summary Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden mb-6" style="background: #ffffff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; margin-bottom: 24px;">
            <div class="p-6" style="padding: 24px;">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2" style="font-size: 11px; font-weight: 900; color: #64748b; text-transform: uppercase; letter-spacing: 0.15em; margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-boxes-packing text-[10px]"></i> {{ __('Order Summary') }}
                    </h3>
                    <a href="{{ route('invoice.online.sale') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 flex items-center gap-1.5 transition" style="font-size: 12px; font-weight: 700; color: #2563eb; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                        <span>{{ __('View Online Sale List') }}</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
                
                @php
                    $online_summary_cards = [
                        [
                            'label'  => 'Total Order',
                            'count'  => $online_order_counts['all'],
                            'color'  => '#1e293b',
                            'bg'     => '#f8fafc',
                            'border' => '#e2e8f0',
                            'status' => 'all',
                        ],
                        [
                            'label'  => 'Processing',
                            'count'  => $online_order_counts['processing'],
                            'color'  => '#d97706',
                            'bg'     => '#fffbeb',
                            'border' => '#fef3c7',
                            'status' => 'processing',
                        ],
                        [
                            'label'  => 'RTS',
                            'count'  => $online_order_counts['rts'],
                            'color'  => '#0891b2',
                            'bg'     => '#ecfeff',
                            'border' => '#cffafe',
                            'status' => 'rts',
                        ],
                        [
                            'label'  => 'In Review',
                            'count'  => $online_order_counts['in_review'],
                            'color'  => '#2563eb',
                            'bg'     => '#eff6ff',
                            'border' => '#dbeafe',
                            'status' => 'in_review',
                        ],
                        [
                            'label'  => 'Pending (Courier)',
                            'count'  => $online_order_counts['pending_courier'],
                            'color'  => '#ea580c',
                            'bg'     => '#fff7ed',
                            'border' => '#ffedd5',
                            'status' => 'pending_courier',
                        ],
                        [
                            'label'  => 'In Transit',
                            'count'  => $online_order_counts['in_transit'],
                            'color'  => '#0284c7',
                            'bg'     => '#f0f9ff',
                            'border' => '#e0f2fe',
                            'status' => 'in_transit',
                        ],
                        [
                            'label'  => 'All in Courier',
                            'count'  => $online_order_counts['all_in_courier'],
                            'color'  => '#4f46e5',
                            'bg'     => '#eef2ff',
                            'border' => '#e0e7ff',
                            'status' => 'all_in_courier',
                        ],
                        [
                            'label'  => 'On Hold',
                            'count'  => $online_order_counts['on_hold'],
                            'color'  => '#475569',
                            'bg'     => '#f1f5f9',
                            'border' => '#e2e8f0',
                            'status' => 'on_hold',
                        ],
                        [
                            'label'  => 'Delivered',
                            'count'  => $online_order_counts['delivered'],
                            'color'  => '#059669',
                            'bg'     => '#ecfdf5',
                            'border' => '#d1fae5',
                            'status' => 'delivered',
                        ],
                        [
                            'label'  => 'Partial Delivered',
                            'count'  => $online_order_counts['partial'],
                            'color'  => '#0d9488',
                            'bg'     => '#f0fdfa',
                            'border' => '#ccfbf1',
                            'status' => 'partial',
                        ],
                        [
                            'label'  => 'Pending Return',
                            'count'  => $online_order_counts['pending_return'],
                            'color'  => '#b45309',
                            'bg'     => '#fffbeb',
                            'border' => '#fde68a',
                            'status' => 'pending_return',
                        ],
                        [
                            'label'  => 'Return',
                            'count'  => $online_order_counts['returned'],
                            'color'  => '#dc2626',
                            'bg'     => '#fef2f2',
                            'border' => '#fee2e2',
                            'status' => 'returned',
                        ],
                        [
                            'label'  => 'Cancelled',
                            'count'  => $online_order_counts['cancelled'],
                            'color'  => '#e11d48',
                            'bg'     => '#fff1f2',
                            'border' => '#ffe4e6',
                            'status' => 'cancelled',
                        ],
                    ];
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px;">
                    @foreach ($online_summary_cards as $card)
                        <a href="{{ route('invoice.online.sale', ['status' => $card['status']]) }}" class="block group transition-all duration-200 hover:-translate-y-0.5" style="text-decoration: none; display: block;">
                            <div class="p-4 rounded-lg flex flex-col justify-between h-full shadow-sm hover:shadow transition" style="background: {{ $card['bg'] }}; border: 1px solid {{ $card['border'] }}; border-radius: 10px; padding: 16px; min-height: 90px; display: flex; flex-direction: column; justify-content: space-between;">
                                <span class="text-xs font-bold uppercase tracking-wider" style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">{{ __($card['label']) }}</span>
                                <span class="text-2xl font-black mt-2" style="font-size: 26px; font-weight: 900; color: {{ $card['color'] }}; margin-top: 8px; line-height: 1;">{{ $card['count'] }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="p-6">
                <h3 class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                    <i class="fas fa-chart-pie text-[10px]"></i> {{ __('Summary & Operations') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    
                    <!-- Row 1: Purchase -->
                    <!-- Purchase Due -->
                    <a href="{{ route('report.supplier-due') }}" class="group flex items-center justify-start gap-4 p-3 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm hover:border-slate-500 dark:hover:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-all text-slate-900">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-red-50 dark:bg-red-900/30 flex items-center justify-center text-red-500 dark:text-red-400 text-xs shrink-0">
                                <i class="fas fa-clock-rotate-left"></i>
                            </div>
                            <span class="text-slate-800 dark:text-white font-semibold text-sm">{{ __('Total Purchase Due') }}</span>
                        </div>
                        <span class="text-slate-900 dark:text-white font-bold">{{ $currency }} {{ number_format($total_pur_due, 0) }}</span>
                    </a>

                    <!-- Overall Purchase -->
                  
  <!-- Sales Due -->
                    <a href="{{ route('report.customer-due') }}" class="group flex items-center justify-start gap-4 p-3 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm hover:border-slate-500 dark:hover:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-all text-slate-900">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center text-rose-500 dark:text-rose-400 text-xs shrink-0">
                                <i class="fas fa-hand-holding-dollar"></i>
                            </div>
                            <span class="text-slate-800 dark:text-white font-semibold text-sm">{{ __('Total Sales Due') }}</span>
                        </div>
                        <span class="text-slate-900 dark:text-white font-bold">{{ $currency }} {{ number_format($total_sale_due, 0) }}</span>
                    </a>
                    <!-- Row 2: Sales -->
                   <a href="{{ route('purchase.index') }}" class="group flex items-center justify-start gap-4 p-3 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm hover:border-slate-500 dark:hover:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-all text-slate-900">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-500 dark:text-blue-400 text-xs shrink-0">
                                <i class="fas fa-cart-shopping"></i>
                            </div>
                            <span class="text-slate-800 dark:text-white font-semibold text-sm">{{ __('Total Purchase Amount') }}</span>
                        </div>
                        <span class="text-slate-900 dark:text-white font-bold">{{ $currency }} {{ number_format($total_pur_amount, 0) }}</span>
                    </a>

                    <!-- Collective Sales -->
                    <a href="{{ route('invoice.index') }}" class="group flex items-center justify-start gap-4 p-3 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm hover:border-slate-500 dark:hover:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-all text-slate-900">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-500 dark:text-emerald-400 text-xs shrink-0">
                                <i class="fas fa-sack-dollar"></i>
                            </div>
                            <span class="text-slate-800 dark:text-white font-semibold text-sm">{{ __('Total Sale Amount') }}</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <span class="text-emerald-600 dark:text-emerald-400 font-bold">{{ $currency }} {{ number_format($total_sale, 0) }}</span>
                        </div>
                    </a>

                    <!-- Row 3: Stock -->
                    <!-- Stock Valuation (Purchase Rate) -->
                    <a href="{{ route('report.stock') }}" class="group flex items-center justify-start gap-4 p-3 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm hover:border-slate-500 dark:hover:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-all text-slate-900">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-violet-50 dark:bg-violet-900/30 flex items-center justify-center text-violet-500 dark:text-violet-400 text-xs shrink-0">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <span class="text-slate-800 dark:text-white font-semibold text-sm">{{ __('Available Stock Amount (Purchase Rate)') }}</span>
                        </div>
                        <span class="text-slate-900 dark:text-white font-bold">{{ $currency }} {{ number_format($totalPrice, 0) }}</span>
                    </a>

                    <!-- Stock Valuation (Sale Rate) -->
                    <a href="{{ route('report.stock') }}" class="group flex items-center justify-start gap-4 p-3 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm hover:border-slate-500 dark:hover:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-all text-slate-900">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-violet-50 dark:bg-violet-900/30 flex items-center justify-center text-violet-500 dark:text-violet-400 text-xs shrink-0">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <span class="text-slate-800 dark:text-white font-semibold text-sm">{{ __('Available Stock Amount (Sale Rate)') }}</span>
                        </div>
                        <span class="text-slate-900 dark:text-white font-bold">{{ $currency }} {{ number_format($available_stock_sale_val ?? 0, 0) }}</span>
                    </a>

                    <!-- Row 4: Returns and Qty -->
                    <!-- Sales Return -->
                    <a href="{{ route('return.sale') }}" class="group flex items-center justify-start gap-4 p-3 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm hover:border-slate-500 dark:hover:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-all text-slate-900">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-500 dark:text-indigo-400 text-xs shrink-0">
                                <i class="fas fa-arrow-rotate-left"></i>
                            </div>
                            <span class="text-slate-800 dark:text-white font-semibold text-sm">{{ __('Total Sales Return') }}</span>
                        </div>
                        <span class="text-slate-900 dark:text-white font-bold">{{ $currency }} {{ number_format($total_return_amount, 0) }}</span>
                    </a>

                    <!-- Total Invoices / Sale Qty -->
                    <a href="{{ route('invoice.index') }}" class="group flex items-center justify-start gap-4 p-3 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm hover:border-slate-500 dark:hover:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-all text-slate-900">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-fuchsia-50 dark:bg-fuchsia-900/30 flex items-center justify-center text-fuchsia-500 dark:text-fuchsia-400 text-xs shrink-0">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <span class="text-slate-800 dark:text-white font-semibold text-sm">{{ __('Total Sale Qty') }}</span>
                        </div>
                        <span class="text-slate-900 dark:text-white font-bold">{{ number_format($total_invoice_count, 0) }}</span>
                    </a>

                    <!-- Row 5: Others -->
                    <!-- Total Products -->
                    <a href="{{ route('product.index') }}" class="group flex items-center justify-start gap-4 p-3 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm hover:border-slate-500 dark:hover:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-all text-slate-900">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-500 dark:text-amber-400 text-xs shrink-0">
                                <i class="fas fa-boxes-stacked"></i>
                            </div>
                            <span class="text-slate-800 dark:text-white font-semibold text-sm">{{ __('Total Products') }}</span>
                        </div>
                        <span class="text-slate-900 dark:text-white font-bold">{{ number_format($total_product, 0) }}</span>
                    </a>

                    <!-- Active Customers -->
                    <a href="{{ route('customer.index') }}" class="group flex items-center justify-start gap-4 p-3 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm hover:border-slate-500 dark:hover:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-all text-slate-900">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-sky-50 dark:bg-sky-900/30 flex items-center justify-center text-sky-500 dark:text-sky-400 text-xs shrink-0">
                                <i class="fas fa-users"></i>
                            </div>
                            <span class="text-slate-800 dark:text-white font-semibold text-sm">{{ __('Total Active Customers') }}</span>
                        </div>
                        <span class="text-slate-900 dark:text-white font-bold">{{ number_format($total_customer, 0) }}</span>
                    </a>

                </div>

                <!-- Extra Subtle Note info -->
                <div class="p-2.5 mt-6 bg-slate-100 dark:bg-slate-900/80 rounded-lg border border-slate-200 dark:border-slate-700/50">
                    <p class="text-[11px] text-slate-600 dark:text-slate-300 leading-relaxed italic">
                        * {{ __('Data synchronized with real-time inventory and financial records. Last update:') }} {{ date('h:i A') }}
                    </p>
                </div>
            </div>
        </div>

        
        @if (env('APP_ONLINE') == 'yes')
        <!-- Top Selling Products Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden mt-6">
            <div class="p-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4 mb-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-800 dark:text-white tracking-tight">{{ __('Top Selling Products') }}</h3>
                        <p class="text-[12px] font-bold text-slate-400 dark:text-slate-400/80 mt-0.5 uppercase tracking-widest flex items-center gap-2">
                            <i class="fas fa-fire text-amber-500"></i> {{ __('Most Popular Items') }}
                        </p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle mb-0">
                        <thead class="bg-slate-50 dark:bg-slate-900/60 text-slate-700 dark:text-slate-300">
                            <tr>
                                <th class="py-3 px-4 text-center font-bold text-xs uppercase tracking-wider">#</th>
                                <th class="py-3 px-4 text-center font-bold text-xs uppercase tracking-wider">{{ __('Image') }}</th>
                                <th class="py-3 px-4 text-left font-bold text-xs uppercase tracking-wider">{{ __('Product Name') }}</th>
                                <th class="py-3 px-4 text-center font-bold text-xs uppercase tracking-wider">{{ __('Stock Qty') }}</th>
                                <th class="py-3 px-4 text-center font-bold text-xs uppercase tracking-wider">{{ __('Sale Qty') }}</th>
                                <th class="py-3 px-4 text-center font-bold text-xs uppercase tracking-wider">{{ __('Selling Price') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 text-slate-800 dark:text-slate-200">
                            @forelse ($top_selling_products as $item)
                                @php
                                    $product = $item->product;
                                    if ($product) {
                                        $purchase = (float) purchased_qty($product);
                                        $sale     = (float) invoiced_qty($product);
                                        $sale_ret = (float) returned_qty($product);
                                        $pur_ret  = (float) return_pur_qty($product);
                                        $damage   = (float) damaged_qty($product);
                                        $adjust_in_total = (float) adjust_in($product);
                                        $adjust_out_total = (float) adjust_out($product);

                                        $stock = $purchase - $sale + $adjust_in_total - $adjust_out_total - $pur_ret - $damage;
                                    } else {
                                        $stock = 0;
                                    }
                                @endphp
                                <tr>
                                    <td class="py-2.5 px-4 font-bold">{{ $loop->iteration }}</td>
                                    <td class="py-2.5 px-4">
                                        <div class="flex justify-center">
                                            @if ($product && !empty($product->images) && file_exists(public_path('uploads/products/' . $product->images)))
                                                <img src="{{ asset('uploads/products/' . $product->images) }}" class="w-10 h-10 object-contain rounded border border-slate-250 dark:border-slate-700 bg-white" alt="{{ $product->name }}">
                                            @else
                                                <div class="w-10 h-10 bg-slate-100 dark:bg-slate-700 rounded flex items-center justify-center border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500">
                                                    <i class="fas fa-image text-sm"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-4 text-left">
                                        <span class="font-extrabold text-slate-800 dark:text-white block text-sm">{{ $product?->name ?? __('Unknown Product') }}</span>
                                        <span class="text-[10px] font-extrabold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-0.5 rounded-md mt-1 inline-block uppercase tracking-wider">
                                            Code: {{ $product?->barcode ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-4 font-bold text-indigo-600 dark:text-indigo-400 text-sm">
                                        {{ number_format($stock, 0) }} pcs
                                    </td>
                                    <td class="py-2.5 px-4 font-bold text-emerald-600 dark:text-emerald-400 text-sm">
                                        {{ number_format($item->total_qty, 0) }} pcs
                                    </td>
                                    <td class="py-2.5 px-4 font-extrabold text-slate-800 dark:text-white text-sm">
                                        ৳{{ number_format($product?->selling_price ?? 0, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-slate-400 font-semibold">
                                        {{ __('No top selling products recorded yet.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Sales Analytics Chart Section -->
        <div class="animate-slide-up delay-200 mt-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-6 border-b border-slate-50 dark:border-slate-700 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-800 dark:text-white tracking-tight">{{ __('Revenue Statistics') }}</h3>
                        <p class="text-[12px] font-bold text-slate-400 dark:text-slate-400/80 mt-0.5 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                            {{ __('Live Sales Performance') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg uppercase tracking-tight">{{ __('Yearly Growth') }}: +12.5%</span>
                    </div>
                </div>
                <div class="p-6 bg-slate-50/30 dark:bg-slate-900/40">
                    <div class="h-[300px] w-full">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>



        <!-- Actionable Insights Grid (Bento Style) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10 animate-slide-up delay-400">            
        </div>
    </div>
    </div>
    </div>  </div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartElem = document.getElementById('revenueChart');
            if (chartElem) {
                const ctx = chartElem.getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(37, 99, 235, 0.15)');
                gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Sales Revenue',
                            data: [12000, 19000, 15000, 25000, 22000, 30000, 28000, 35000, 42000, 38000, 45000, 50000],
                            borderColor: '#2563eb',
                            borderWidth: 3,
                            fill: true,
                            backgroundColor: gradient,
                            tension: 0.4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#2563eb',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                padding: 12,
                                titleFont: { size: 14, weight: 'bold' },
                                bodyFont: { size: 13 },
                                displayColors: false,
                                cornerRadius: 8,
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: '#cbd5e1', font: { size: 10, weight: 'bold' } }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(148, 163, 184, 0.1)', drawBorder: false },
                                ticks: { 
                                    color: '#cbd5e1', 
                                    font: { size: 10, weight: 'bold' },
                                    padding: 10,
                                    callback: function(value) { return '৳' + value / 1000 + 'k'; }
                                }
                            }
                        }
                    }
                });
            }
        });

        $(document).ready(function() {
            // Handle filter link clicks
            $('#filterNav .nav-link').click(function(e) {
                e.preventDefault(); 
                $('#filterNav .nav-link').removeClass('active');
                $(this).addClass('active');

                const filterTranslations = {
                    'Today': "{{ __('Today') }}",
                    'Yesterday': "{{ __('Yesterday') }}",
                    'This-week': "{{ __('This Week') }}",
                    'This-month': "{{ __('This Month') }}",
                    'This-year': "{{ __('This Year') }}"
                };
                let selectedFilter = $(this).data('filter');
                $('.filterName').text(filterTranslations[selectedFilter] || selectedFilter);

                $.ajax({
                    url: "{{ route('dashboard.filter') }}", 
                    type: "GET",
                    data: {
                        filter: selectedFilter
                    },
                    success: function(response) {
                        $('#saleAmount').text(Number(response.sale || 0).toLocaleString());
                        $('#purchaseAmount').text(Number(response.purchase || 0).toLocaleString());
                        $('#expenseAmount').text(Number(response.expense || 0).toLocaleString());
                        $('#profitAmount').text(Number(response.profit || 0).toLocaleString());
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                    }
                });
            });

            // Open Sales Summary Report directly in a new page/tab
            $('#btnGenCustomSummary').click(function() {
                const sDate = $('#dashStartDate').val();
                const eDate = $('#dashEndDate').val();
                if(!sDate || !eDate) {
                    alert('দয়া করে তারিখ নির্বাচন করুন!');
                    return;
                }
                const printUrl = `{{ route('dashboard.product-sales-summary.print') }}?start_date=${encodeURIComponent(sDate)}&end_date=${encodeURIComponent(eDate)}`;
                window.open(printUrl, '_blank');
            });
        });
    </script>
@endpush
