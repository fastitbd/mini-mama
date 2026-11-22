@extends('backend.layouts.master')
@section('section-title', __('Banner Setup'))
@section('page-title', __('Hero & Promotional Banners'))

@section('action-button')
    <a href="#" data-toggle="modal" data-target="#addModal" class="btn add_list_btn">
        <i class="mr-2 feather icon-plus"></i>
        {{ __('Add Banner') }}
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped text-center align-middle">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left">{{ __('#') }}</th>
                                    <th style="min-width: 200px;">{{ __('Banner Preview (Live Store Look)') }}</th>
                                    <th>{{ __('Format / Type') }}</th>
                                    <th>{{ __('Title & Subtitle') }}</th>
                                    <th>{{ __('Button & Target Link') }}</th>
                                    <th>{{ __('Order') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="header_style_right">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banners as $banner)
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->iteration }}</td>
                                        <td>
                                            @if($banner->banner_type == 'image' || (empty($banner->title) && empty($banner->subtitle) && $banner->image))
                                                {{-- Full Graphic Hero Banner Thumbnail --}}
                                                <div style="width: 190px; height: 56px; border-radius: 6px; overflow: hidden; border: 1px solid #cbd5e1; box-shadow: 0 1px 4px rgba(0,0,0,0.12); margin: 0 auto; background: #f8fafc; position: relative;">
                                                    @if($banner->image)
                                                        <img src="{{ $banner->image_url }}" alt="{{ $banner->title ?: 'Banner' }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <div style="display:flex; align-items:center; justify-content:center; height:100%; color:#94a3b8; font-size:11px;">
                                                            {{ __('No Image Uploaded') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                {{-- SHEIN Trend Frame Mini Mockup (Matches Frontend 1:1) --}}
                                                <div style="width: 190px; height: 56px; border-radius: 6px; overflow: hidden; border: 1px solid #cbd5e1; box-shadow: 0 1px 4px rgba(0,0,0,0.15); background: {{ $banner->bg_color ?: 'linear-gradient(135deg, #111111 0%, #2a0808 100%)' }}; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; padding: 4px 8px; position: relative;">
                                                    {{-- Left Text & Mini Action Button --}}
                                                    <div style="flex: 1; text-align: left; overflow: hidden; padding-right: 6px; z-index: 2;">
                                                        <div style="font-size: 10.5px; font-weight: 900; color: #FA2C19; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.1; text-transform: uppercase;">
                                                            {{ $banner->title ?: '#TREND' }}
                                                        </div>
                                                        @if($banner->subtitle)
                                                            <div style="font-size: 7.5px; font-weight: 700; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 1px; opacity: 0.95;">
                                                                {{ $banner->subtitle }}
                                                            </div>
                                                        @endif
                                                        @if($banner->btn_text)
                                                            <span style="display: inline-block; background: #FA2C19; color: #fff; font-size: 7px; font-weight: 800; padding: 1px 5px; border-radius: 2px; text-transform: uppercase; margin-top: 2px;">
                                                                {{ $banner->btn_text }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    {{-- Right 3 Mini Products Showcase Mockups --}}
                                                    <div style="display: flex; gap: 3px; align-items: center; flex-shrink: 0; z-index: 2;">
                                                        <div style="width: 22px; height: 38px; border-radius: 2px; overflow: hidden; background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,0.25);">
                                                            <img src="//img.ltwebstatic.com/v4/j/pi/2026/03/16/66/177362915988faee9b44a22773360a55cb6e92d2cb_thumbnail_336x.jpg" style="width: 100%; height: 100%; object-fit: cover;">
                                                        </div>
                                                        <div style="width: 22px; height: 38px; border-radius: 2px; overflow: hidden; background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,0.25);">
                                                            <img src="//img.ltwebstatic.com/v4/j/pi/2025/08/20/a7/175567516072f9ba261241443373b007e93789199a_thumbnail_336x.jpg" style="width: 100%; height: 100%; object-fit: cover;">
                                                        </div>
                                                        <div style="width: 22px; height: 38px; border-radius: 2px; overflow: hidden; background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,0.25);">
                                                            <img src="//img.ltwebstatic.com/v4/j/pi/2026/06/08/62/1780897060cce0e2fc86b00e703f06ad0a634a15ed_thumbnail_336x.jpg" style="width: 100%; height: 100%; object-fit: cover;">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($banner->banner_type == 'image')
                                                <span class="badge badge-primary px-2 py-1" style="font-size: 11px;">
                                                    <i class="feather icon-image mr-1"></i> {{ __('Graphic Banner') }}
                                                </span>
                                            @else
                                                <span class="badge badge-info px-2 py-1" style="font-size: 11px;">
                                                    <i class="feather icon-tag mr-1"></i> {{ __('Fashion Trend Card') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-left font-weight-bold">
                                            <div style="font-size: 14px; color: #1e293b;">{{ $banner->title ?: __('(Full Graphic Banner)') }}</div>
                                            @if($banner->subtitle)
                                                <div style="font-size: 12px; font-weight: 500; color: #64748b;">{{ $banner->subtitle }}</div>
                                            @endif
                                        </td>
                                        <td class="text-left">
                                            @if($banner->btn_text)
                                                <span class="badge badge-dark">{{ $banner->btn_text }}</span>
                                            @endif
                                            @if($banner->btn_url)
                                                <div class="mt-1">
                                                    <a href="{{ $banner->btn_url }}" target="_blank" style="font-size: 11px; color: #3b82f6; text-decoration: underline;">
                                                        {{ \Illuminate\Support\Str::limit($banner->btn_url, 28) }}
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary font-weight-bold" style="font-size: 12px;">{{ $banner->order_num }}</span>
                                        </td>
                                        <td>
                                            <form action="{{ route('banner.toggle-status', $banner->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $banner->status ? 'btn-success' : 'btn-danger' }}" style="border-radius: 20px; font-size: 11px; font-weight: 700; padding: 3px 12px;">
                                                    {{ $banner->status ? __('Active') : __('Inactive') }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                                    {{ __('Action') }}
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="#" data-toggle="modal" data-target="#editModal-{{ $banner->id }}" class="dropdown-item text-primary">
                                                        <i class="feather icon-edit mr-1"></i> {{ __('Edit') }}
                                                    </a>
                                                    <a href="#" data-toggle="modal" data-target="#deleteModal-{{ $banner->id }}" class="dropdown-item text-danger">
                                                        <i class="feather icon-trash mr-1"></i> {{ __('Delete') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center no_data_style text-danger py-4">
                                            <i class="feather icon-image mb-2" style="font-size: 24px; display: block;"></i>
                                            {{ __('No Banners Available') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($banners->hasPages())
                        <div class="mt-3">
                            {{ $banners->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Edit & Delete Modals --}}
    @foreach ($banners as $banner)
        <form action="{{ route('banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-edit-modal title="{{ __('Edit Banner') }}" id="{{ $banner->id }}">
                <div class="row px-3">
                    <div class="mb-3 col-md-6 text-left">
                        <label class="form-label font-weight-bold">{{ __('Banner Format') }}</label>
                        <select class="form-control" name="banner_type" id="edit_type_{{ $banner->id }}" onchange="toggleEditFields('{{ $banner->id }}')">
                            <option value="image" {{ $banner->banner_type == 'image' ? 'selected' : '' }}>{{ __('Full Graphic Hero Banner (Upload Image)') }}</option>
                            <option value="trend" {{ $banner->banner_type == 'trend' ? 'selected' : '' }}>{{ __('Fashion Trend Card (Title, Button & Products)') }}</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6 text-left">
                        <label class="form-label font-weight-bold">{{ __('Display Order') }}</label>
                        <input type="number" class="form-control" name="order_num" value="{{ $banner->order_num }}">
                    </div>
                </div>

                <div class="row px-3" id="edit_trend_row1_{{ $banner->id }}" style="{{ $banner->banner_type == 'image' ? 'display:none;' : '' }}">
                    <div class="mb-3 col-md-6 text-left">
                        <label class="form-label font-weight-bold">{{ __('Headline / Title') }}</label>
                        <input type="text" class="form-control" name="title" value="{{ $banner->title }}" placeholder="e.g. #SummerOutfit or 10.10 BIG SALE">
                    </div>
                    <div class="mb-3 col-md-6 text-left">
                        <label class="form-label font-weight-bold">{{ __('Subtitle / Tagline') }}</label>
                        <input type="text" class="form-control" name="subtitle" value="{{ $banner->subtitle }}" placeholder="e.g. TRENDING SUMMER COLLECTION">
                    </div>
                </div>

                <div class="row px-3">
                    <div class="mb-3 col-md-6 text-left" id="edit_btn_text_box_{{ $banner->id }}" style="{{ $banner->banner_type == 'image' ? 'display:none;' : '' }}">
                        <label class="form-label font-weight-bold">{{ __('Button Text') }}</label>
                        <input type="text" class="form-control" name="btn_text" value="{{ $banner->btn_text }}" placeholder="e.g. SHOP NOW">
                    </div>
                    <div class="mb-3 col-md-{{ $banner->banner_type == 'image' ? '12' : '6' }} text-left" id="edit_btn_url_col_{{ $banner->id }}">
                        <label class="form-label font-weight-bold">{{ __('Target Link / URL') }}</label>
                        <input type="text" class="form-control" name="btn_url" value="{{ $banner->btn_url }}" placeholder="e.g. /c/dresses, /sale or full URL">
                    </div>
                </div>

                <div class="mb-3 col-md-12 text-left" id="edit_bg_box_{{ $banner->id }}" style="{{ $banner->banner_type == 'image' ? 'display:none;' : '' }}">
                    <label class="form-label font-weight-bold">{{ __('Background Color / CSS Gradient') }}</label>
                    <input type="text" class="form-control mb-1" id="bg_color_{{ $banner->id }}" name="bg_color" value="{{ $banner->bg_color }}" placeholder="e.g. linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%)">
                    <small class="text-muted d-block mb-2">{{ __('Quick preset buttons:') }}</small>
                    <div class="d-flex gap-2 flex-wrap" style="gap: 6px;">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('bg_color_{{ $banner->id }}').value='linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%)'">Lavender Soft</button>
                        <button type="button" class="btn btn-sm btn-outline-dark" onclick="document.getElementById('bg_color_{{ $banner->id }}').value='linear-gradient(135deg, #111111 0%, #2a0808 100%)'">Dark Flame</button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="document.getElementById('bg_color_{{ $banner->id }}').value='linear-gradient(135deg, #f85032 0%, #e73827 100%)'">Red Sale</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('bg_color_{{ $banner->id }}').value='#f8fafc'">Light Slate</button>
                    </div>
                </div>

                <div class="mb-3 col-md-12 text-left" id="edit_img_box_{{ $banner->id }}">
                    <label class="form-label font-weight-bold">{{ __('Banner Image (1400x350 Recommended for full width, or any ratio with auto-fit)') }}</label>
                    @if($banner->image)
                        <div class="mb-2">
                            <img src="{{ $banner->image_url }}" alt="Preview" style="max-height: 85px; border-radius: 6px; border: 1px solid #ddd; object-fit: contain;">
                        </div>
                    @endif
                    <input type="file" class="form-control-file border p-1 rounded" name="image" accept="image/*">
                    <div class="mt-2">
                        <small class="text-muted d-block">{{ __('Or specify image URL:') }}</small>
                        <input type="text" class="form-control mt-1" name="image_url_input" value="{{ str_starts_with($banner->image, 'http') || str_starts_with($banner->image, '//') ? $banner->image : '' }}" placeholder="https://example.com/banner.jpg">
                    </div>
                </div>

                <div class="mb-3 col-md-12 text-left">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="editStatus-{{ $banner->id }}" name="status" value="1" {{ $banner->status ? 'checked' : '' }}>
                        <label class="custom-control-label font-weight-bold" for="editStatus-{{ $banner->id }}">{{ __('Active Status') }}</label>
                    </div>
                </div>
            </x-edit-modal>
        </form>

        <form action="{{ route('banner.destroy', $banner->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <x-delete-modal title="{{ __('Delete Banner') }}" id="{{ $banner->id }}">
                <p class="text-left">{{ __('Are you sure you want to delete this banner?') }}</p>
                <div class="alert alert-warning text-left mb-0">
                    <strong>{{ $banner->title ?: __('Banner #' . $banner->id) }}</strong>
                </div>
            </x-delete-modal>
        </form>
    @endforeach

    {{-- Add Modal --}}
    <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-add-modal title="{{ __('Add New Banner') }}">
            <div class="row px-3">
                <div class="mb-3 col-md-6 text-left">
                    <label class="form-label font-weight-bold">{{ __('Banner Format') }}</label>
                    <select class="form-control" name="banner_type" id="add_banner_type" onchange="toggleAddFields()">
                        <option value="image" selected>{{ __('Full Graphic Hero Banner (Upload Image)') }}</option>
                        <option value="trend">{{ __('Fashion Trend Card (Title, Button & Products)') }}</option>
                    </select>
                </div>
                <div class="mb-3 col-md-6 text-left">
                    <label class="form-label font-weight-bold">{{ __('Display Order') }}</label>
                    <input type="number" class="form-control" name="order_num" value="{{ $banners->count() + 1 }}">
                </div>
            </div>

            <div class="row px-3" id="add_trend_row1" style="display: none;">
                <div class="mb-3 col-md-6 text-left">
                    <label class="form-label font-weight-bold">{{ __('Headline / Title') }}</label>
                    <input type="text" class="form-control" name="title" placeholder="e.g. #SummerOutfit or 10.10 BIG SALE">
                </div>
                <div class="mb-3 col-md-6 text-left">
                    <label class="form-label font-weight-bold">{{ __('Subtitle / Tagline') }}</label>
                    <input type="text" class="form-control" name="subtitle" placeholder="e.g. TRENDING SUMMER COLLECTION">
                </div>
            </div>

            <div class="row px-3">
                <div class="mb-3 col-md-6 text-left" id="add_btn_text_box" style="display: none;">
                    <label class="form-label font-weight-bold">{{ __('Button Text') }}</label>
                    <input type="text" class="form-control" name="btn_text" placeholder="e.g. SHOP NOW">
                </div>
                <div class="mb-3 col-md-12 text-left" id="add_btn_url_col">
                    <label class="form-label font-weight-bold">{{ __('Target Link / URL') }}</label>
                    <input type="text" class="form-control" name="btn_url" placeholder="e.g. /c/dresses, /sale or full URL">
                </div>
            </div>

            <div class="mb-3 col-md-12 text-left" id="add_bg_box" style="display: none;">
                <label class="form-label font-weight-bold">{{ __('Background Color / CSS Gradient') }}</label>
                <input type="text" class="form-control mb-1" id="add_bg_color" name="bg_color" placeholder="e.g. linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%)">
                <small class="text-muted d-block mb-2">{{ __('Quick preset buttons:') }}</small>
                <div class="d-flex gap-2 flex-wrap" style="gap: 6px;">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('add_bg_color').value='linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%)'">Lavender Soft</button>
                    <button type="button" class="btn btn-sm btn-outline-dark" onclick="document.getElementById('add_bg_color').value='linear-gradient(135deg, #111111 0%, #2a0808 100%)'">Dark Flame</button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="document.getElementById('add_bg_color').value='linear-gradient(135deg, #f85032 0%, #e73827 100%)'">Red Sale</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('add_bg_color').value='#f8fafc'">Light Slate</button>
                </div>
            </div>

            <div class="mb-3 col-md-12 text-left" id="add_img_box">
                <label class="form-label font-weight-bold">{{ __('Banner Image (1400x350 Recommended for full width, or any ratio with auto-fit)') }}</label>
                <input type="file" class="form-control-file border p-1 rounded" name="image" accept="image/*">
                <div class="mt-2">
                    <small class="text-muted d-block">{{ __('Or specify external image URL:') }}</small>
                    <input type="text" class="form-control mt-1" name="image_url_input" placeholder="https://example.com/banner.jpg">
                </div>
            </div>

            <div class="mb-3 col-md-12 text-left">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="addStatus" name="status" value="1" checked>
                    <label class="custom-control-label font-weight-bold" for="addStatus">{{ __('Active Status') }}</label>
                </div>
            </div>
        </x-add-modal>
    </form>
@endsection

@push('scripts')
<script>
    function toggleAddFields() {
        const type = document.getElementById('add_banner_type').value;
        const trendRow1 = document.getElementById('add_trend_row1');
        const btnTextBox = document.getElementById('add_btn_text_box');
        const btnUrlCol = document.getElementById('add_btn_url_col');
        const bgBox = document.getElementById('add_bg_box');

        if (type === 'image') {
            trendRow1.style.display = 'none';
            btnTextBox.style.display = 'none';
            btnUrlCol.className = 'mb-3 col-md-12 text-left';
            bgBox.style.display = 'none';
        } else {
            trendRow1.style.display = 'flex';
            btnTextBox.style.display = 'block';
            btnUrlCol.className = 'mb-3 col-md-6 text-left';
            bgBox.style.display = 'block';
        }
    }

    function toggleEditFields(id) {
        const type = document.getElementById('edit_type_' + id).value;
        const trendRow1 = document.getElementById('edit_trend_row1_' + id);
        const btnTextBox = document.getElementById('edit_btn_text_box_' + id);
        const btnUrlCol = document.getElementById('edit_btn_url_col_' + id);
        const bgBox = document.getElementById('edit_bg_box_' + id);

        if (type === 'image') {
            trendRow1.style.display = 'none';
            btnTextBox.style.display = 'none';
            btnUrlCol.className = 'mb-3 col-md-12 text-left';
            bgBox.style.display = 'none';
        } else {
            trendRow1.style.display = 'flex';
            btnTextBox.style.display = 'block';
            btnUrlCol.className = 'mb-3 col-md-6 text-left';
            bgBox.style.display = 'block';
        }
    }
</script>
@endpush