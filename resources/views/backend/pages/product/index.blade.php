@extends('backend.layouts.master')
@section('section-title', __('Product'))
@section('page-title', __('Product List'))
@if (check_permission('product.create'))
    @section('action-button')
        <a href="{{ route('product.create') }}" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            {{ __('Add Product') }}
        </a>
    @endsection
@endif
@push('css')
    <style>
        @media print {
            @page {
                size: auto;
            }

            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                font-family: Roboto, sans-serif;
            }

            .print_area {
                position: absolute;
                top: 0;
                width: 100%;
            }

            .print_area * {
                visibility: visible !important;
            }
        }
        #barcode-page svg, .print_area svg {
            max-width: 100% !important;
            height: 26px !important;
            display: block !important;
            margin: 0 auto !important;
            color-adjust: exact !important;
            -webkit-print-color-adjust: exact !important;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-body pt-1">
                    <form action="{{ route('product.index') }}" method="GET">
                        @php
                            $categories = App\Models\Category::get();
                            $produc = App\Models\Product::get();
                        @endphp
                        <div class="row">

                            <div class="col-md-3 mt-1">
                                <input type="text" class="form-control barcode-filter-input" data-barcode-input name="barcode" placeholder="{{ __('Scan Barcode / Product') }}"
                                    value="{{ $barcode ?? '' }}" />
                            </div>

                            <div class="col-md-3 mt-1">
                                <select name="product_id" id="" class="select2">
                                    <option value="">{{ __('All Product') }}</option>
                                    @foreach ($produc as $item)
                                        <option value="{{ $item->id }}"{{ ($product_id ?? '') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mt-1">
                                <select name="category_id" id="" class="select2">
                                    <option value="">{{ __('All Category') }}</option>
                                    @foreach ($categories as $item)
                                        <option
                                            value="{{ $item->id }}"{{ ($category_id ?? '') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if (env('APP_SUB_CATEGORY') == 'yes')
                                <div class="col-md-2 mt-1">
                                    <select name="sub_category_id" id="" class="select2">
                                        <option value="">{{ __('All Sub Category') }}</option>
                                        @foreach ($subCategories ?? [] as $subItem)
                                            <option
                                                value="{{ $subItem->id }}"{{ ($sub_category_id ?? '') == $subItem->id ? 'selected' : '' }}>
                                                {{ $subItem->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="col-md-2 mt-1">
                                <select name="section" class="form-control select2">
                                    <option value="">{{ __('All Sections') }}</option>
                                    @foreach($storeSections ?? [] as $sItem)
                                        <option value="{{ $sItem->key }}" {{ ($section ?? '') == $sItem->key ? 'selected' : '' }}>
                                            {{ $sItem->icon ? $sItem->icon . ' ' : '' }}{{ $sItem->name }} ({{ $sItem->subtitle ?: $sItem->key }})
                                        </option>
                                    @endforeach
                                    <option value="none" {{ ($section ?? '') == 'none' ? 'selected' : '' }}>{{ __('Regular / No Section') }}</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-1">
                                <button type="submit" class="btn add_list_btn">{{ __('Filter') }}</button>
                                <a href="{{ route('product.index') }}" class="btn add_list_btn_reset">{{ __('Reset') }}</a>
                                <a href="" class="btn add_list_btn float-right" onclick="window.print()">{{ __('Print') }}</a>
                            </div>
                        </div>
                    </form>

                    {{-- Bulk Section Assignment Bar --}}
                    <div id="bulkActionBar" class="card p-2 mt-3 mb-2 bg-light border" style="border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
                            <div class="d-flex align-items-center" style="gap: 8px;">
                                <span class="font-weight-bold text-dark"><i class="feather icon-layers mr-1"></i> {{ __('Bulk Section Assignment:') }}</span>
                                <span id="selectedCountBadge" class="badge badge-primary px-2 py-1 font-weight-bold" style="font-size: 12px;">0 {{ __('Selected') }}</span>
                            </div>
                            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                                <select id="bulkSectionSelect" class="form-control form-control-sm" style="width: 240px; height: 34px; font-weight: 600;">
                                    <option value="">-- {{ __('Select Store Section') }} --</option>
                                    @foreach($storeSections ?? [] as $sec)
                                        <option value="{{ $sec->key }}" data-badge="{{ $sec->badge_text }}">
                                            {{ $sec->icon ? $sec->icon . ' ' : '' }}{{ $sec->name }} ({{ $sec->subtitle ?: $sec->key }})
                                        </option>
                                    @endforeach
                                    <option value="none">❌ {{ __('Remove from Section (Normal)') }}</option>
                                </select>
                                <input type="text" id="bulkBadgeInput" class="form-control form-control-sm" placeholder="{{ __('Badge/Tag (e.g. Flash Sale, #SummerOutfit)') }}" style="width: 220px; height: 34px;">
                                <button type="button" id="btnApplyBulkSection" class="btn btn-sm btn-success px-3" style="height: 34px; font-weight: 700;">
                                    <i class="feather icon-check mr-1"></i> {{ __('Apply to Selected') }}
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary px-2.5" id="btnOpenManageSectionsModal" data-toggle="modal" data-target="#manageSectionsModal" style="height: 34px; font-weight: 700; white-space: nowrap;" title="{{ __('Edit Section Names & Add New Sections') }}">
                                    <i class="feather icon-settings mr-1"></i> {{ __('Edit / Manage Sections') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-2">
                        <table id="datatable-buttons" class="table table-striped align-middle">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left" style="width: 36px; text-align: center;">
                                        <input type="checkbox" id="selectAllProducts" style="cursor: pointer; width: 16px; height: 16px;">
                                    </th>
                                    <th>{{ __('#SL') }}</th>
                                    <th style="width: 50px;">{{ __('Image') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Store Section') }}</th>
                                    <th>{{ __('Barcode') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th></th>
                                    <th class="header_style_right">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $data)
                                    @php
                                        $count_inv = App\Models\InvoiceItem::where('product_id', $data->id)->count();
                                        $count_pur = App\Models\PurchaseItem::where('product_id', $data->id)->count();

                                        $userBranchId = auth()->user()->branch_id;
                                        $filterBranchId = session('branch_filter_id', auth()->user()->branch_id);

                                        if ($userBranchId == 1) {
                                            if ($filterBranchId) {
                                                $branch_product = App\Models\BranchProduct::where(
                                                    'branch_id',
                                                    $filterBranchId,
                                                )
                                                    ->where('product_id', $data->id)
                                                    ->get();
                                            } else {
                                                $branch_product = App\Models\BranchProduct::where(
                                                    'product_id',
                                                    $data->id,
                                                )->get();
                                            }
                                        } else {
                                            $branch_product = App\Models\BranchProduct::where('product_id', $data->id)
                                                ->where('branch_id', $userBranchId)
                                                ->get();
                                        }
                                    @endphp
                                    <tr>
                                        <td class="table_data_style_left" style="text-align: center;">
                                            <input type="checkbox" class="product-select-chk" value="{{ $data->id }}" style="cursor: pointer; width: 16px; height: 16px;">
                                        </td>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            <div style="width: 40px; height: 52px; border-radius: 4px; overflow: hidden; border: 1px solid #cbd5e1; background: #fff; margin: 0 auto;">
                                                <img src="{{ $data->image_url }}" alt="{{ $data->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            <div class="font-weight-bold text-dark" style="max-width: 250px; font-size: 13.5px; line-height: 1.3;">{{ $data->name }}</div>
                                            @if (env('APP_SC') == 'yes')
                                                @if (count($data->product_variations) > 0)
                                                    <div class="mt-2">
                                                        <select name="variation[]" class="form-control variation_select"
                                                            data-product-id="{{ $data->id }}" style="padding-right: 30px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; min-width: 120px; font-size: 13px; height: 32px; padding-top: 4px; padding-bottom: 4px;">
                                                            <option value="">{{ __('Select Variation') }}</option>
                                                            @foreach ($data->product_variations as $variation)
                                                                @if ($data->id == $variation->product_id)
                                                                    <option data-variation_id="{{ $variation->id }}"
                                                                        value="{{ $variation->size?->size }}-{{ $variation->color?->color }}">
                                                                        {{ $variation->size?->size }}-{{ $variation->color?->color }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $currSec = $storeSectionsMap[$data->section] ?? null;
                                            @endphp
                                            @if($currSec)
                                                <span class="badge px-2 py-1" style="background: {{ $currSec->color ?: '#FA2C19' }}; color: #ffffff; font-size: 11px;">
                                                    {{ $currSec->icon ? $currSec->icon . ' ' : '' }}{{ $currSec->name }}
                                                </span>
                                            @elseif($data->section == 'super_deals')
                                                <span class="badge badge-danger px-2 py-1" style="font-size: 11px;"><i class="fa fa-bolt mr-1"></i> {{ __('Super Deals') }}</span>
                                            @elseif($data->section == 'trends')
                                                <span class="badge px-2 py-1" style="background: #9462FF; color: #fff; font-size: 11px;"><i class="fa fa-fire mr-1"></i> {{ __('Trends') }}</span>
                                            @elseif($data->section == 'featured')
                                                <span class="badge badge-info px-2 py-1" style="font-size: 11px;"><i class="fa fa-star mr-1"></i> {{ __('Featured') }}</span>
                                            @elseif($data->section)
                                                <span class="badge badge-primary px-2 py-1" style="font-size: 11px;">{{ ucfirst(str_replace('_', ' ', $data->section)) }}</span>
                                            @else
                                                <span class="badge badge-light text-muted border px-2 py-1" style="font-size: 11px;">{{ __('Regular') }}</span>
                                            @endif
                                            @if($data->badge)
                                                <div style="font-size: 10px; font-weight: 700; color: #e11d48; margin-top: 2px;">{{ $data->badge }}</div>
                                            @endif
                                        </td>
                                        <td><code class="font-weight-bold">{{ $data->barcode }}</code></td>
                                        <td>
                                            <span class="badge badge-secondary px-2 py-1">{{ $data->category?->name ?? 'General' }}</span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-dark">RM {{ number_format($data->selling_price, 2) }}</span>
                                            @if($data->discount > 0)
                                                <small class="text-danger d-block font-weight-bold">-{{ number_format($data->discount, 2) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-primary-rgba btn-sm generated_barcode"
                                                data-name="{{ $data->name }}" data-category="{{ $data->category?->name }}" data-code="{{ $data->barcode }}"
                                                data-id="{{ $data->id }}" data-dis_price="{{ $data->dis_selling_price }}" data-discount="{{ $data->discount }}" data-price="{{ $data->selling_price }}">
                                                <i class="fa fa-barcode"></i>
                                            </a>
                                        </td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle" type="button"
                                                    data-toggle="dropdown">
                                                    {{ __('Action') }}
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if (check_permission('product.edit'))
                                                        <a href="{{ route('product.edit', $data->id) }}"
                                                            class="dropdown-item text-primary">
                                                            <i class="feather icon-edit"></i> {{ __('Edit') }}
                                                        </a>
                                                    @endif

                                                    @if (check_permission('product.destroy'))
                                                        @if ($count_inv < 1 && $count_pur < 1)
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#deleteModal-{{ $data->id }}"
                                                                class="dropdown-item text-danger">
                                                                <i class="feather icon-trash"></i> {{ __('Delete') }}
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <form action="{{ route('product.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        <x-delete-modal title="{{ __('Product') }}" id="{{ $data->id }}" />
                                    </form>

                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center no_data_style text-danger">{{ __('No Data Available') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                        {{ $products->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="bar_code_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Barcode Settings') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 text-center" style="padding-bottom: 15px; border-bottom: 1px solid #eee;">
                        <label class="mr-3"><input type="checkbox" class="barcode_setting" data-target=".b_company" checked> {{ __('Company') }}</label>
                        <label class="mr-3"><input type="checkbox" class="barcode_setting" data-target=".b_category"> {{ __('Category') }}</label>
                        <label class="mr-3"><input type="checkbox" class="barcode_setting" data-target=".b_name" checked> {{ __('Name') }}</label>
                        <label class="mr-3"><input type="checkbox" class="barcode_setting" data-target=".b_variation" checked> {{ __('Variation') }}</label>
                        <label class="mr-3"><input type="checkbox" class="barcode_setting" data-target=".b_price" checked> {{ __('Price') }}</label>
                        <label><input type="checkbox" class="barcode_setting" data-target=".b_vat"> {{ __('Include VAT') }}</label>
                    </div>
                    <div id="barcode-page">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn cancel_btn" id="modal_cancel">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn save_btn delete" onclick="print_barcode()"><i
                            class="fa fa-print mr-1"></i>
                        {{ __('Print') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Manage Sections Modal --}}
    <div class="modal fade" id="manageSectionsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 8px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                <div class="modal-header bg-dark text-white py-3">
                    <div class="d-flex align-items-center" style="gap: 10px;">
                        <span style="font-size: 22px;">🏪</span>
                        <div>
                            <h5 class="modal-title font-weight-bold text-white mb-0">{{ __('Manage Store Sections') }}</h5>
                            <small class="text-light" style="opacity: 0.85;">{{ __('Edit section display names or add new custom sections') }}</small>
                        </div>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3" style="background: #f8fafc;">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-pills mb-3" id="sectionsModalTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active font-weight-bold" id="tab-existing-sections" data-toggle="pill" href="#pane-existing-sections" role="tab">
                                <i class="feather icon-list mr-1"></i> {{ __('Edit Current Sections') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="tab-add-section" data-toggle="pill" href="#pane-add-section" role="tab">
                                <i class="feather icon-plus mr-1"></i> {{ __('Add New Section') }}
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="sectionsTabContent">
                        <!-- Tab 1: Existing Sections with Inline Edit -->
                        <div class="tab-pane fade show active" id="pane-existing-sections" role="tabpanel">
                            <div id="sectionAlertPlaceholder"></div>
                            <div class="table-responsive bg-white rounded border shadow-sm p-2">
                                <table class="table table-hover align-middle mb-0" id="sectionsModalTable">
                                    <thead class="thead-light">
                                        <tr style="font-size: 11px; text-transform: uppercase;">
                                            <th style="width: 44px; text-align: center;">{{ __('Icon') }}</th>
                                            <th>{{ __('Section Name') }}</th>
                                            <th>{{ __('Placement / Subtitle') }}</th>
                                            <th style="width: 140px;">{{ __('Default Badge') }}</th>
                                            <th style="width: 75px; text-align: center;">{{ __('Color') }}</th>
                                            <th style="width: 90px; text-align: right;">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sectionsModalTbody">
                                        {{-- Populated via AJAX --}}
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2 text-muted small">
                                <i class="feather icon-info mr-1"></i> {{ __('Tip: You can change "Super Deals" or "Trends" names to whatever you want, click the green checkmark to save instantly.') }}
                            </div>
                        </div>

                        <!-- Tab 2: Add New Section Form -->
                        <div class="tab-pane fade" id="pane-add-section" role="tabpanel">
                            <div class="bg-white p-3 rounded border shadow-sm">
                                <form id="formAddNewSection">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold text-dark">{{ __('Section Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" id="newSecName" name="name" class="form-control" required placeholder="{{ __('e.g. Mega Clearance Sale, Top Picks') }}">
                                        <small class="text-muted">{{ __('This name will appear on the homepage and in the bulk section dropdown.') }}</small>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-3 form-group mb-3">
                                            <label class="font-weight-bold text-dark">{{ __('Icon / Emoji') }}</label>
                                            <input type="text" id="newSecIcon" name="icon" class="form-control text-center" value="🔥" placeholder="🔥, ✨, ⚡, ⭐">
                                        </div>
                                        <div class="col-md-9 form-group mb-3">
                                            <label class="font-weight-bold text-dark">{{ __('Placement / Subtitle') }}</label>
                                            <input type="text" id="newSecSubtitle" name="subtitle" class="form-control" placeholder="{{ __('e.g. Special Promo Feed') }}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="font-weight-bold text-dark">{{ __('Default Badge Text') }}</label>
                                            <input type="text" id="newSecBadge" name="badge_text" class="form-control" placeholder="{{ __('e.g. Flash Sale, 50% OFF') }}">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="font-weight-bold text-dark">{{ __('Badge Color') }}</label>
                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                <input type="color" id="newSecColor" name="color" class="form-control" value="#FA2C19" style="width: 48px; height: 38px; padding: 2px;">
                                                <input type="text" id="newSecColorCode" class="form-control" value="#FA2C19" readonly style="font-size: 13px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right mt-2">
                                        <button type="submit" id="btnSubmitNewSec" class="btn btn-primary px-4 font-weight-bold">
                                            <i class="feather icon-plus mr-1"></i> {{ __('Create Section') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Update barcode variation for the correct row
            function getVariationForRow(button) {
                const row = $(button).closest('tr');
                const select = row.find('.variation_select');
                const variation = select.val() || '';
                const variation_id = select.find('option:selected').data('variation_id') || '';
                return {
                    variation,
                    variation_id
                };
            }

            // Barcode button click
            $(document).on('click', '.generated_barcode', function() {
                const name = $(this).data('name');
                const category = $(this).data('category');
                const discount = $(this).data('discount');
                const dis_price = $(this).data('dis_price');
                const price = $(this).data('price');
                const code = $(this).data('code');
                const {
                    variation,
                    variation_id
                } = getVariationForRow(this);
                const full_code = code + "" + variation_id;
                const pro_barcode = "{{ get_setting('pro_barcode') }}" || 'single';
                const company = "{{ $com?->value ?? get_setting('com_name') }}";

                const formattedPrice = new Intl.NumberFormat('en-US', {
                    useGrouping: true,
                    minimumFractionDigits: 2
                }).format(price);
                const formattedDisPrice = new Intl.NumberFormat('en-US', {
                    useGrouping: true,
                    minimumFractionDigits: 2
                }).format(dis_price);
                
                let priceHtml = '';

                if (discount > 0) {
                
                    priceHtml = `
                    <p style="margin-bottom:2px; line-height:9px; margin-top:5px; font-size: 12px; color:black;">
                        <strong>{{ __('Price') }}: <del> ${formattedDisPrice} {{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}</del></strong>
                    </p>
                    <p style="margin-bottom:2px; line-height:9px; margin-top:5px; font-size: 12px; color:black;">
                        <strong>{{ __('Discount Price') }}: ${formattedPrice} {{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}</strong>
                    </p>
                    `;
                
                } else {
                
                    priceHtml = `
                    <p style="margin-bottom:2px; line-height:9px; margin-top:5px; font-size: 12px; color:black;">
                        <strong>{{ __('Price') }}: ${formattedPrice} {{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}</strong>
                    </p>
                    `;
                
                }

                $("#barcode-page").html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
                $("#bar_code_modal").modal('show');

                const url = "{{ route('product-barcode', 'value') }}".replace('value', full_code);

                $.get(url, (data) => {
                    let barcode = '';

                    if (pro_barcode === 'a4') {
                        barcode +=
                            `<div class="text-center p-4 print_area" id="barcode"><table class="table table-bordered">`;
                        for (let i = 0; i < 10; i++) {
                            barcode += `<tr>`;
                            for (let j = 0; j < 3; j++) {
                                barcode += `<td>
                            <p class="b_company" style="margin-bottom:1px; line-height:9px; margin-top:5px; font-size: 11px; color:black;"><strong>${company}</strong></p>
                            <p class="b_category" style="margin-bottom:2px; line-height:9px; margin-top:0px; font-size: 9px; color:black;"><strong>${category}</strong></p>
                            <div style="text-align: center; margin: 0;">${data}</div>
                            <p class="b_code" style="margin-bottom:2px; line-height:9px; margin-top:3px; font-size: 9px; color:black;"><strong>${full_code}</strong></p>
                            <p class="b_name" style="margin-bottom:2px; line-height:9px; margin-top:3px; font-size: 9px; color:black;"><strong>${name}</strong></p>
                            <p class="b_variation" style="margin-bottom:2px; line-height:9px; margin-top:3px; font-size: 9px; color:black;"><strong>${variation}</strong></p>
                            <div class="b_price">${priceHtml}</div>
                            <p class="b_vat" style="margin-bottom:2px; line-height:9px; margin-top:2px; font-size: 8px; color:black;"><strong>(including VAT)</strong></p>
                        </td>`;
                            }
                            barcode += `</tr>`;
                        }
                        barcode += `</table></div>`;
                    } else {
                        barcode += `<div class="text-center p-4 print_area" id="barcode" style="padding:0 !important">
                    <table class="table" style="margin-bottom:0 !important;">
                        <tr>
                            <td style="border-top:0 !important;padding:0;">
                                <p class="b_company" style="font-family: Arial, sans-serif;line-height:9px;margin-bottom:1px; font-size: 13px;margin-top:5px; font-weight: 500; text-transform: uppercase; color: black;"><strong>${company}</strong></p>
                                 <p class="b_category" style="margin-bottom:2px; line-height:9px; margin-top:0px; font-size: 9px; color:black;"><strong>${category}</strong></p>
                                <div style="text-align: center; margin: 0;">${data}</div>
                                <p class="b_code" style="margin-bottom:0px; line-height:9px; margin-top:2px; font-size: 10px; color:black;"><strong>${full_code.split('').join(' ')}</strong></p>
                                <p class="b_name" style="margin-bottom:2px; line-height:9px; margin-top:0px; font-size: 9px; color:black;"><strong>${name}</strong></p>
                                <p class="b_variation" style="margin-bottom:2px; line-height:9px; margin-top:-2px; font-size: 9px; color:black;"><strong>${variation}</strong></p>
                                <div class="b_price">${priceHtml}</div>
                                <p class="b_vat" style="margin-bottom:2px; line-height:9px; margin-top:2px; font-size: 8px; color:black;"><strong>(including VAT)</strong></p>
                            </td>
                        </tr>
                    </table>
                </div>`;
                    }

                    $("#barcode-page").html(barcode);
                    $('.barcode_setting').trigger('change');
                }).fail(() => {
                    $("#barcode-page").html('<div class="text-center text-danger p-4">{{ __("Failed to generate barcode.") }}</div>');
                });
            });
            
            $(document).on('change', '.barcode_setting', function() {
                var target = $(this).data('target');
                if ($(this).is(':checked')) {
                    $(target).show();
                } else {
                    $(target).hide();
                }
            });

            // Reset barcode modal on cancel
            $(document).on('click', '#modal_cancel', function() {
                $("#bar_code_modal").modal('hide');
                $('.variation_select').val('');
            });

        });
    </script>

    <script>
        //  Print Barcode
        function print_barcode(id) {
            $("#bar_code_modal").modal('hide');
            $(".modal-backdrop").remove();
            $(".modal").css('display', 'none');

            let printContent = $("#barcode-page").html();
            let printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Barcode Print</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 0px;
                            text-align: center;
                        }
                        .print_area {
                            width: 100%;
                            text-align: center;
                        }
                        svg {
                            max-width: 100% !important;
                            height: 26px !important;
                            display: block !important;
                            margin: 0 auto !important;
                            color-adjust: exact !important;
                            -webkit-print-color-adjust: exact !important;
                        }
                        table {
                            width: 100%;
                            text-align: center;
                        }
                        table td, table th {
                            text-align: center !important;
                        }
                    </style>
                </head>
                <body>
                    ${printContent}
                </body>
                </html>
            `);
                printWindow.document.close();
                printWindow.focus();
                printWindow.onload = function() {
                    printWindow.print();
                    printWindow.close();
                };
        }

        // ================= BULK SECTION ASSIGNMENT =================
        $(document).ready(function() {
            function updateSelectedCount() {
                const count = $('.product-select-chk:checked').length;
                $('#selectedCountBadge').text(count + ' Selected');
                if (count > 0) {
                    $('#bulkActionBar').addClass('border-primary').css('background', '#eff6ff');
                } else {
                    $('#bulkActionBar').removeClass('border-primary').css('background', '#f8fafc');
                }
            }

            $('#selectAllProducts').on('change', function() {
                $('.product-select-chk').prop('checked', $(this).prop('checked'));
                updateSelectedCount();
            });

            $(document).on('change', '.product-select-chk', function() {
                if (!$(this).prop('checked')) {
                    $('#selectAllProducts').prop('checked', false);
                } else if ($('.product-select-chk:checked').length === $('.product-select-chk').length) {
                    $('#selectAllProducts').prop('checked', true);
                }
                updateSelectedCount();
            });

            $('#btnApplyBulkSection').on('click', function() {
                const selectedIds = [];
                $('.product-select-chk:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length === 0) {
                    alert('Please select at least one product using checkboxes!');
                    return;
                }

                const section = $('#bulkSectionSelect').val();
                if (!section) {
                    alert('Please choose a Store Section from the dropdown!');
                    return;
                }

                const badge = $('#bulkBadgeInput').val();

                const btn = $(this);
                const originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Saving...');

                $.ajax({
                    url: "{{ route('product.bulk-section') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_ids: selectedIds,
                        section: section,
                        badge: badge
                    },
                    success: function(res) {
                        alert(res.message || 'Products updated successfully!');
                        window.location.reload();
                    },
                    error: function(xhr) {
                        alert('Error: ' + (xhr.responseJSON?.message || 'Could not update products.'));
                        btn.prop('disabled', false).html(originalHtml);
                    }
                });
            });
            // Auto-fill Badge input when section with default badge is selected
            $('#bulkSectionSelect').on('change', function() {
                const defaultBadge = $(this).find('option:selected').data('badge');
                if (defaultBadge && !$('#bulkBadgeInput').val()) {
                    $('#bulkBadgeInput').val(defaultBadge);
                }
            });

            // Color picker text sync
            $('#newSecColor').on('input change', function() {
                $('#newSecColorCode').val($(this).val());
            });

            // Function to render sections in modal
            function renderSectionsTable(sections) {
                let html = '';
                sections.forEach(function(s) {
                    const isSystem = s.is_system ? 1 : 0;
                    html += `
                        <tr data-id="${s.id}" data-key="${s.key}">
                            <td class="text-center">
                                <input type="text" class="form-control form-control-sm text-center sec-icon" value="${s.icon || '🏷️'}" style="width: 44px; padding: 2px;" title="Icon / Emoji">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm font-weight-bold sec-name" value="${s.name}" placeholder="Section Name" required>
                                <small class="text-muted" style="font-size: 10px;">Key: <code>${s.key}</code></small>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm sec-subtitle" value="${s.subtitle || ''}" placeholder="e.g. Home Left Block">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm sec-badge" value="${s.badge_text || ''}" placeholder="e.g. Flash Sale">
                            </td>
                            <td class="text-center">
                                <input type="color" class="form-control form-control-sm sec-color" value="${s.color || '#FA2C19'}" style="width: 36px; height: 31px; padding: 1px; margin: 0 auto;">
                            </td>
                            <td class="text-right" style="white-space: nowrap;">
                                <button type="button" class="btn btn-sm btn-success px-2 py-1 btn-save-sec" data-id="${s.id}" title="Save Changes">
                                    <i class="feather icon-check"></i>
                                </button>
                                ${!isSystem ? `
                                    <button type="button" class="btn btn-sm btn-outline-danger px-2 py-1 btn-del-sec ml-1" data-id="${s.id}" data-name="${s.name}" title="Delete Section">
                                        <i class="feather icon-trash-2"></i>
                                    </button>
                                ` : ''}
                            </td>
                        </tr>
                    `;
                });
                $('#sectionsModalTbody').html(html);
            }

            // Sync the #bulkSectionSelect dropdown with latest sections
            function updateBulkSectionDropdown(sections) {
                const currentVal = $('#bulkSectionSelect').val();
                let optionsHtml = '<option value="">-- {{ __("Select Store Section") }} --</option>';
                sections.forEach(function(s) {
                    const icon = s.icon ? s.icon + ' ' : '';
                    const subtitle = s.subtitle ? ` (${s.subtitle})` : ` (${s.key})`;
                    optionsHtml += `<option value="${s.key}" data-badge="${s.badge_text || ''}">${icon}${s.name}${subtitle}</option>`;
                });
                optionsHtml += '<option value="none">❌ {{ __("Remove from Section (Normal)") }}</option>';
                $('#bulkSectionSelect').html(optionsHtml);
                if (currentVal) {
                    $('#bulkSectionSelect').val(currentVal);
                }
            }

            // Load sections on modal open
            $('#manageSectionsModal').on('show.bs.modal', function() {
                $('#sectionAlertPlaceholder').empty();
                loadSections();
            });

            function loadSections() {
                $('#sectionsModalTbody').html('<tr><td colspan="6" class="text-center py-3 text-muted"><i class="fa fa-spinner fa-spin mr-1"></i> Loading sections...</td></tr>');
                $.ajax({
                    url: "{{ route('store-section.index') }}",
                    method: "GET",
                    headers: { 'Accept': 'application/json' },
                    success: function(res) {
                        if (res.sections) {
                            renderSectionsTable(res.sections);
                            updateBulkSectionDropdown(res.sections);
                        }
                    },
                    error: function() {
                        $('#sectionsModalTbody').html('<tr><td colspan="6" class="text-center text-danger py-3">Failed to load sections.</td></tr>');
                    }
                });
            }

            // Save individual section changes
            $(document).on('click', '.btn-save-sec', function() {
                const btn = $(this);
                const id = btn.data('id');
                const row = btn.closest('tr');
                const name = row.find('.sec-name').val();
                const icon = row.find('.sec-icon').val();
                const subtitle = row.find('.sec-subtitle').val();
                const badge = row.find('.sec-badge').val();
                const color = row.find('.sec-color').val();

                if (!name.trim()) {
                    alert('Section Name cannot be empty!');
                    return;
                }

                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

                $.ajax({
                    url: "{{ url('/store-section') }}/" + id,
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "PUT",
                        name: name,
                        icon: icon,
                        subtitle: subtitle,
                        badge_text: badge,
                        color: color
                    },
                    success: function(res) {
                        btn.prop('disabled', false).html('<i class="feather icon-check"></i>');
                        $('#sectionAlertPlaceholder').html(`
                            <div class="alert alert-success alert-dismissible fade show py-2 px-3 small" role="alert">
                                <i class="feather icon-check-circle mr-1"></i> ${res.message || 'Section updated successfully!'}
                                <button type="button" class="close py-2" data-dismiss="alert">&times;</button>
                            </div>
                        `);
                        if (res.sections) {
                            updateBulkSectionDropdown(res.sections);
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html('<i class="feather icon-check"></i>');
                        alert('Error: ' + (xhr.responseJSON?.message || 'Could not update section.'));
                    }
                });
            });

            // Add new section submit
            $('#formAddNewSection').on('submit', function(e) {
                e.preventDefault();
                const btn = $('#btnSubmitNewSec');
                const origHtml = btn.html();
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Creating...');

                $.ajax({
                    url: "{{ route('store-section.store') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: $('#newSecName').val(),
                        icon: $('#newSecIcon').val(),
                        subtitle: $('#newSecSubtitle').val(),
                        badge_text: $('#newSecBadge').val(),
                        color: $('#newSecColor').val()
                    },
                    success: function(res) {
                        btn.prop('disabled', false).html(origHtml);
                        $('#formAddNewSection')[0].reset();
                        $('#tab-existing-sections').tab('show');
                        if (res.sections) {
                            renderSectionsTable(res.sections);
                            updateBulkSectionDropdown(res.sections);
                        } else {
                            loadSections();
                        }
                        $('#sectionAlertPlaceholder').html(`
                            <div class="alert alert-success alert-dismissible fade show py-2 px-3 small" role="alert">
                                <i class="feather icon-check-circle mr-1"></i> ${res.message || 'Section created successfully!'}
                                <button type="button" class="close py-2" data-dismiss="alert">&times;</button>
                            </div>
                        `);
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(origHtml);
                        alert('Error: ' + (xhr.responseJSON?.message || 'Could not create section.'));
                    }
                });
            });

            // Delete section
            $(document).on('click', '.btn-del-sec', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                if (!confirm(`Are you sure you want to delete section "${name}"? Products in this section will be reset to normal.`)) {
                    return;
                }

                $.ajax({
                    url: "{{ url('/store-section') }}/" + id,
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "DELETE"
                    },
                    success: function(res) {
                        if (res.sections) {
                            renderSectionsTable(res.sections);
                            updateBulkSectionDropdown(res.sections);
                        } else {
                            loadSections();
                        }
                        $('#sectionAlertPlaceholder').html(`
                            <div class="alert alert-warning alert-dismissible fade show py-2 px-3 small" role="alert">
                                <i class="feather icon-trash-2 mr-1"></i> ${res.message || 'Section deleted.'}
                                <button type="button" class="close py-2" data-dismiss="alert">&times;</button>
                            </div>
                        `);
                    },
                    error: function(xhr) {
                        alert('Error: ' + (xhr.responseJSON?.message || 'Could not delete section.'));
                    }
                });
            });
        });
    </script>
@endpush
