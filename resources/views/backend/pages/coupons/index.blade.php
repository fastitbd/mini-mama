@extends('backend.layouts.master')

@section('title', 'Manage Coupons & Offers')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-orange-500 mb-1">
                <i class="feather icon-tag"></i> Promotion & Discounts
            </div>
            <h1 class="text-2xl font-black text-slate-800">Coupons & Special Offers</h1>
            <p class="text-sm text-slate-500 mt-0.5">
                Create and manage customer discount vouchers, free shipping coupons, and promotional codes.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" onclick="openCreateCouponModal()" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-white bg-slate-900 rounded-lg shadow hover:bg-orange-600 transition">
                <i class="feather icon-plus"></i> Add New Coupon
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between text-emerald-800 text-sm font-semibold">
            <div class="flex items-center gap-2">
                <i class="feather icon-check-circle text-lg text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">&times;</button>
        </div>
    @endif

    <!-- Search & Filter Bar -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 mb-6 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <form method="GET" action="{{ route('coupons.index') }}" class="flex gap-2 w-full md:w-auto flex-1 max-w-md">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search coupon code or title..." class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
            <button type="submit" class="px-4 py-2 bg-slate-100 text-slate-700 font-bold text-xs rounded-lg hover:bg-slate-200">
                <i class="feather icon-search"></i>
            </button>
        </form>
        <div class="text-xs text-slate-500 font-medium">
            Total <strong>{{ $coupons->total() }}</strong> vouchers configured
        </div>
    </div>

    <!-- Coupons Table -->
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider">
                        <th class="py-3 px-4">Coupon Code</th>
                        <th class="py-3 px-4">Offer Title</th>
                        <th class="py-3 px-4">Discount</th>
                        <th class="py-3 px-4">Min Spend</th>
                        <th class="py-3 px-4">Valid Period</th>
                        <th class="py-3 px-4">Used Count</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($coupons as $coupon)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4">
                                <span class="font-mono font-black text-slate-900 bg-orange-50 text-orange-600 border border-orange-200 px-2.5 py-1 rounded">
                                    {{ $coupon->code }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">
                                {{ $coupon->title ?: 'Promotion' }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-emerald-600">
                                @if($coupon->discount_type === 'percentage')
                                    {{ (float)$coupon->discount_value }}% OFF
                                    @if($coupon->max_discount_amount)
                                        <span class="block text-[10px] text-slate-400 font-normal">Max: ৳ {{ number_format((float)$coupon->max_discount_amount, 2) }}</span>
                                    @endif
                                @else
                                    ৳ {{ number_format((float)$coupon->discount_value, 2) }} FLAT
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $coupon->min_order_amount > 0 ? ('৳ ' . number_format((float)$coupon->min_order_amount, 2)) : 'No Minimum' }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">
                                @if($coupon->start_date || $coupon->end_date)
                                    {{ $coupon->start_date ? $coupon->start_date->format('d M Y') : 'Start' }} &rarr; 
                                    {{ $coupon->end_date ? $coupon->end_date->format('d M Y') : 'Ongoing' }}
                                @else
                                    <span class="text-emerald-600 font-semibold">Always Active</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-bold">
                                {{ $coupon->used_count }} {{ $coupon->usage_limit ? ('/ ' . $coupon->usage_limit) : '' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $coupon->status ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $coupon->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <button type="button" onclick="openEditCouponModal({{ json_encode($coupon) }})" class="p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded transition" title="Edit">
                                        <i class="feather icon-edit text-sm"></i>
                                    </button>
                                    <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Delete this coupon code?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded transition" title="Delete">
                                            <i class="feather icon-trash-2 text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-10 text-slate-400">
                                <i class="feather icon-tag text-3xl mb-2 block text-slate-300"></i>
                                No coupon codes created yet. Click "Add New Coupon" above.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($coupons->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $coupons->links() }}
            </div>
        @endif
    </div>
</div>

<!-- CREATE / EDIT COUPON MODAL -->
<div id="couponModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative border border-slate-100">
        <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
            <h3 id="modalTitle" class="text-base font-black text-slate-800 uppercase">Create New Coupon</h3>
            <button type="button" onclick="closeCouponModal()" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
        </div>

        <form id="couponForm" method="POST" action="{{ route('coupons.store') }}">
            @csrf
            <div id="methodSpoof"></div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Coupon Code *</label>
                    <input type="text" name="code" id="couponCode" required placeholder="e.g. FLASH20" class="w-full px-3 py-2 text-xs font-mono font-bold uppercase border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Offer Title</label>
                    <input type="text" name="title" id="couponTitle" placeholder="e.g. 20% Off Weekend Sale" class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Discount Type *</label>
                    <select name="discount_type" id="couponType" class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none bg-white font-semibold">
                        <option value="percentage">Percentage (% OFF)</option>
                        <option value="fixed">Fixed Amount (৳ FLAT)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Discount Value *</label>
                    <input type="number" step="0.01" name="discount_value" id="couponVal" required placeholder="15.00" class="w-full px-3 py-2 text-xs font-bold border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Min Order Amount (৳)</label>
                    <input type="number" step="0.01" name="min_order_amount" id="couponMin" placeholder="0.00" class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Max Discount Cap (৳)</label>
                    <input type="number" step="0.01" name="max_discount_amount" id="couponMax" placeholder="Optional" class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Start Date</label>
                    <input type="date" name="start_date" id="couponStart" class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none bg-white">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">End Date</label>
                    <input type="date" name="end_date" id="couponEnd" class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none bg-white">
                </div>
            </div>

            <div class="flex items-center gap-2 mb-5">
                <input type="checkbox" name="status" id="couponStatus" value="1" checked class="w-4 h-4 text-orange-600 rounded">
                <label for="couponStatus" class="text-xs font-bold text-slate-700 cursor-pointer">Active and ready for customer checkout</label>
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeCouponModal()" class="px-4 py-2 text-xs font-bold text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200">Cancel</button>
                <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-slate-900 rounded-lg hover:bg-orange-600">Save Coupon</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateCouponModal() {
        document.getElementById('modalTitle').innerText = 'Create New Coupon';
        document.getElementById('couponForm').action = "{{ route('coupons.store') }}";
        document.getElementById('methodSpoof').innerHTML = '';
        document.getElementById('couponForm').reset();
        document.getElementById('couponModal').classList.remove('hidden');
    }

    function openEditCouponModal(coupon) {
        document.getElementById('modalTitle').innerText = 'Edit Coupon: ' + coupon.code;
        document.getElementById('couponForm').action = "/coupons/" + coupon.id;
        document.getElementById('methodSpoof').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        document.getElementById('couponCode').value = coupon.code;
        document.getElementById('couponTitle').value = coupon.title || '';
        document.getElementById('couponType').value = coupon.discount_type;
        document.getElementById('couponVal').value = coupon.discount_value;
        document.getElementById('couponMin').value = coupon.min_order_amount || '';
        document.getElementById('couponMax').value = coupon.max_discount_amount || '';
        document.getElementById('couponStart').value = coupon.start_date ? coupon.start_date.split('T')[0] : '';
        document.getElementById('couponEnd').value = coupon.end_date ? coupon.end_date.split('T')[0] : '';
        document.getElementById('couponStatus').checked = !!coupon.status;

        document.getElementById('couponModal').classList.remove('hidden');
    }

    function closeCouponModal() {
        document.getElementById('couponModal').classList.add('hidden');
    }
</script>
@endsection
