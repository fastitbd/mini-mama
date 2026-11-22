@extends('backend.layouts.master')

@section('title', 'Customer Reviews & Feedback')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-orange-500 mb-1">
                <i class="feather icon-star"></i> Customer Feedback & Social Proof
            </div>
            <h1 class="text-2xl font-black text-slate-800">Customer Ratings & Reviews</h1>
            <p class="text-sm text-slate-500 mt-0.5">
                Manage, approve, and curate customer ratings and reviews shown across product pages and homepage.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" onclick="openAddReviewModal()" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-white bg-slate-900 rounded-lg shadow hover:bg-orange-600 transition">
                <i class="feather icon-plus"></i> Add Verified Review
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

    <!-- 4 Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <a href="{{ route('reviews.index') }}" class="p-4 rounded-xl border {{ !request('status') ? 'border-slate-800 bg-slate-900 text-white' : 'border-slate-200 bg-white text-slate-700' }} shadow-sm">
            <div class="text-xs uppercase font-bold tracking-wider opacity-80">All Reviews</div>
            <div class="text-2xl font-black mt-1">{{ $counts['all'] }}</div>
        </a>
        <a href="{{ route('reviews.index', ['status' => 'approved']) }}" class="p-4 rounded-xl border {{ request('status') === 'approved' ? 'border-emerald-600 bg-emerald-600 text-white' : 'border-emerald-200 bg-emerald-50 text-emerald-800' }} shadow-sm">
            <div class="text-xs uppercase font-bold tracking-wider opacity-80">Approved</div>
            <div class="text-2xl font-black mt-1">{{ $counts['approved'] }}</div>
        </a>
        <a href="{{ route('reviews.index', ['status' => 'pending']) }}" class="p-4 rounded-xl border {{ request('status') === 'pending' ? 'border-amber-600 bg-amber-600 text-white' : 'border-amber-200 bg-amber-50 text-amber-800' }} shadow-sm">
            <div class="text-xs uppercase font-bold tracking-wider opacity-80">Pending Approval</div>
            <div class="text-2xl font-black mt-1">{{ $counts['pending'] }}</div>
        </a>
        <a href="{{ route('reviews.index', ['status' => 'rejected']) }}" class="p-4 rounded-xl border {{ request('status') === 'rejected' ? 'border-red-600 bg-red-600 text-white' : 'border-red-200 bg-red-50 text-red-800' }} shadow-sm">
            <div class="text-xs uppercase font-bold tracking-wider opacity-80">Rejected / Hidden</div>
            <div class="text-2xl font-black mt-1">{{ $counts['rejected'] }}</div>
        </a>
    </div>

    <!-- Reviews Table -->
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider">
                        <th class="py-3 px-4">Customer</th>
                        <th class="py-3 px-4">Rating</th>
                        <th class="py-3 px-4">Review Content</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reviews as $rev)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800">{{ $rev->customer_name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $rev->customer_phone ?: $rev->customer_email ?: 'Verified Buyer' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="text-amber-500 font-bold flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="feather icon-star text-xs {{ $i <= $rev->rating ? 'text-amber-400 fill-amber-400' : 'text-slate-200' }}"></i>
                                    @endfor
                                    <span class="text-slate-700 ml-1 font-bold">({{ $rev->rating }}.0)</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 max-w-md">
                                @if($rev->review_title)
                                    <div class="font-bold text-slate-800 mb-0.5">{{ $rev->review_title }}</div>
                                @endif
                                <div class="text-slate-600 leading-relaxed">{{ $rev->comment }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">
                                {{ $rev->created_at ? $rev->created_at->format('d M Y') : 'Recent' }}
                            </td>
                            <td class="py-3.5 px-4">
                                @if($rev->status === 'approved')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800">Approved</span>
                                @elseif($rev->status === 'pending')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-amber-100 text-amber-800">Pending</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-800">Rejected</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    @if($rev->status !== 'approved')
                                        <form action="{{ route('reviews.status', $rev->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="px-2.5 py-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded transition" title="Approve">
                                                Approve
                                            </button>
                                        </form>
                                    @endif
                                    @if($rev->status !== 'rejected')
                                        <form action="{{ route('reviews.status', $rev->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="px-2.5 py-1 text-[11px] font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded transition" title="Hide">
                                                Hide
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('reviews.destroy', $rev->id) }}" method="POST" onsubmit="return confirm('Delete this review permanently?');" class="inline">
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
                            <td colspan="6" class="text-center py-10 text-slate-400">
                                <i class="feather icon-star text-3xl mb-2 block text-slate-300"></i>
                                No customer reviews found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>

<!-- ADD REVIEW MODAL -->
<div id="addReviewModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative border border-slate-100">
        <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
            <h3 class="text-base font-black text-slate-800 uppercase">Add Customer Review</h3>
            <button type="button" onclick="closeAddReviewModal()" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
        </div>

        <form method="POST" action="{{ route('reviews.store') }}">
            @csrf
            <div class="mb-3">
                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Customer Name *</label>
                <input type="text" name="customer_name" required placeholder="e.g. Jannatul Ferdous" class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500">
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Rating *</label>
                    <select name="rating" class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 bg-white font-bold text-amber-600">
                        <option value="5">⭐⭐⭐⭐⭐ (5 Stars)</option>
                        <option value="4">⭐⭐⭐⭐ (4 Stars)</option>
                        <option value="3">⭐⭐⭐ (3 Stars)</option>
                        <option value="2">⭐⭐ (2 Stars)</option>
                        <option value="1">⭐ (1 Star)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 bg-white font-semibold">
                        <option value="approved">Approved & Live</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Headline / Title</label>
                <input type="text" name="review_title" placeholder="e.g. Superb quality and quick delivery!" class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500">
            </div>

            <div class="mb-4">
                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Review Comments *</label>
                <textarea name="comment" rows="4" required placeholder="Customer's feedback on fabric, size, or delivery..." class="w-full p-3 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500"></textarea>
            </div>

            <div class="flex items-center gap-2 mb-5">
                <input type="checkbox" name="verified_purchase" id="verified_purchase" value="1" checked class="w-4 h-4 text-orange-600 rounded">
                <label for="verified_purchase" class="text-xs font-bold text-slate-700 cursor-pointer">Mark as Verified Purchase</label>
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeAddReviewModal()" class="px-4 py-2 text-xs font-bold text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200">Cancel</button>
                <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-slate-900 rounded-lg hover:bg-orange-600">Save Review</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddReviewModal() {
        document.getElementById('addReviewModal').classList.remove('hidden');
    }
    function closeAddReviewModal() {
        document.getElementById('addReviewModal').classList.add('hidden');
    }
</script>
@endsection
