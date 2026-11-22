@extends('backend.layouts.master')
@section('section-title', __('Store Customization'))
@section('page-title', __('Store & Homepage Sections'))

@section('action-button')
    <form action="{{ route('store-section.seed-demo') }}" method="POST" onsubmit="return confirm('Do you want to load all demo products, categories, banners, and sections?');" style="display:inline-block;" class="mr-2">
        @csrf
        <button type="submit" class="btn btn-outline-info">
            <i class="feather icon-download-cloud mr-1"></i> {{ __('Install Demo Data') }}
        </button>
    </form>
    <a href="#" data-toggle="modal" data-target="#addSectionModal" class="btn add_list_btn">
        <i class="mr-2 feather icon-plus"></i>
        {{ __('Add New Section') }}
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 font-weight-bold text-dark"><i class="feather icon-grid mr-2 text-primary"></i>{{ __('Manage Store Sections') }}</h5>
                        <p class="text-muted mb-0 small">{{ __('Customize section names, homepage placements, icons, and default tags for products.') }}</p>
                    </div>
                    <a href="{{ route('product.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="feather icon-layers mr-1"></i> {{ __('Go to Products List') }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped text-center align-middle">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left">{{ __('#') }}</th>
                                    <th>{{ __('Icon') }}</th>
                                    <th class="text-left">{{ __('Section Name') }}</th>
                                    <th>{{ __('Placement / Subtitle') }}</th>
                                    <th>{{ __('Section Key') }}</th>
                                    <th>{{ __('Default Badge') }}</th>
                                    <th>{{ __('Assigned Products') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="header_style_right">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sections as $sec)
                                    @php
                                        $prodCount = \App\Models\Product::where('section', $sec->key)->count();
                                    @endphp
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->iteration }}</td>
                                        <td>
                                            <span style="font-size: 24px;">{{ $sec->icon ?: '🏷️' }}</span>
                                        </td>
                                        <td class="text-left font-weight-bold">
                                            <span class="badge px-2 py-1" style="background: {{ $sec->color ?: '#FA2C19' }}; color: #ffffff; font-size: 13px;">
                                                {{ $sec->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted font-weight-bold small">{{ $sec->subtitle ?: '-' }}</span>
                                        </td>
                                        <td>
                                            <code class="px-2 py-1 bg-light border rounded text-dark font-weight-bold">{{ $sec->key }}</code>
                                        </td>
                                        <td>
                                            @if($sec->badge_text)
                                                <span class="badge badge-light border text-danger font-weight-bold">{{ $sec->badge_text }}</span>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('product.index', ['section' => $sec->key]) }}" class="badge badge-primary px-2 py-1 font-weight-bold" title="{{ __('View Products') }}">
                                                {{ $prodCount }} {{ __('Products') }}
                                            </a>
                                        </td>
                                        <td>
                                            @if($sec->is_system)
                                                <span class="badge badge-warning px-2 py-1 small">{{ __('Home System Block') }}</span>
                                            @else
                                                <span class="badge badge-info px-2 py-1 small">{{ __('Custom Section') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($sec->status)
                                                <span class="badge badge-success px-2 py-1">{{ __('Active') }}</span>
                                            @else
                                                <span class="badge badge-secondary px-2 py-1">{{ __('Inactive') }}</span>
                                            @endif
                                        </td>
                                        <td class="table_data_style_right">
                                            <button type="button" class="btn btn-sm btn-info px-2 py-1 mr-1" 
                                                    data-toggle="modal" 
                                                    data-target="#editModal{{ $sec->id }}" 
                                                    title="{{ __('Edit Section') }}">
                                                <i class="feather icon-edit-2"></i> {{ __('Edit') }}
                                            </button>

                                            @if(!$sec->is_system)
                                                <form action="{{ route('store-section.destroy', $sec->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('{{ __('Are you sure you want to delete this section? Products assigned to it will be set to normal.') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger px-2 py-1" title="{{ __('Delete Section') }}">
                                                        <i class="feather icon-trash-2"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- Edit Modal for each section --}}
                                    <div class="modal fade" id="editModal{{ $sec->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('store-section.update', $sec->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header bg-light">
                                                        <h5 class="modal-title font-weight-bold">
                                                            <i class="feather icon-edit mr-1 text-primary"></i> {{ __('Edit Section:') }} {{ $sec->name }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        <div class="form-group mb-3">
                                                            <label class="font-weight-bold">{{ __('Section Display Name') }} <span class="text-danger">*</span></label>
                                                            <input type="text" name="name" class="form-control" value="{{ $sec->name }}" required placeholder="{{ __('e.g. Super Deals, Trending Now') }}">
                                                            <small class="text-muted">{{ __('This name is shown to customers on the homepage and in product cards.') }}</small>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="col-md-4 form-group mb-3">
                                                                <label class="font-weight-bold">{{ __('Icon / Emoji') }}</label>
                                                                <input type="text" name="icon" class="form-control text-center" value="{{ $sec->icon ?: '🔥' }}" placeholder="🔥, ✨, ⭐">
                                                            </div>
                                                            <div class="col-md-8 form-group mb-3">
                                                                <label class="font-weight-bold">{{ __('Placement / Subtitle') }}</label>
                                                                <input type="text" name="subtitle" class="form-control" value="{{ $sec->subtitle }}" placeholder="{{ __('e.g. Home Left Block') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="col-md-6 form-group mb-3">
                                                                <label class="font-weight-bold">{{ __('Default Badge Text') }}</label>
                                                                <input type="text" name="badge_text" class="form-control" value="{{ $sec->badge_text }}" placeholder="{{ __('e.g. Flash Sale, 50% OFF') }}">
                                                            </div>
                                                            <div class="col-md-6 form-group mb-3">
                                                                <label class="font-weight-bold">{{ __('Badge Color') }}</label>
                                                                <div class="d-flex align-items-center" style="gap: 8px;">
                                                                    <input type="color" name="color" class="form-control" value="{{ $sec->color ?: '#FA2C19' }}" style="width: 50px; height: 38px; padding: 2px;">
                                                                    <input type="text" class="form-control" value="{{ $sec->color ?: '#FA2C19' }}" readonly style="font-size: 13px;">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="col-md-6 form-group mb-3">
                                                                <label class="font-weight-bold">{{ __('Order Number') }}</label>
                                                                <input type="number" name="order_num" class="form-control" value="{{ $sec->order_num }}">
                                                            </div>
                                                            <div class="col-md-6 form-group mb-3">
                                                                <label class="font-weight-bold">{{ __('Status') }}</label>
                                                                <select name="status" class="form-control">
                                                                    <option value="1" {{ $sec->status ? 'selected' : '' }}>{{ __('Active') }}</option>
                                                                    <option value="0" {{ !$sec->status ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        @if($sec->is_system)
                                                            <div class="alert alert-info py-2 px-3 small mb-0">
                                                                <i class="feather icon-info mr-1"></i> {{ __('This is a core system section mapped to the homepage grid. You can freely rename it and customize its badge/colors.') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                        <button type="submit" class="btn btn-primary font-weight-bold">{{ __('Save Changes') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4 text-muted">{{ __('No sections found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Section Modal --}}
    <div class="modal fade" id="addSectionModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('store-section.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title font-weight-bold text-white">
                            <i class="feather icon-plus mr-1"></i> {{ __('Add New Store Section') }}
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">{{ __('Section Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="{{ __('e.g. Mega Clearance Sale, Top Picks') }}">
                        </div>

                        <div class="form-row">
                            <div class="col-md-4 form-group mb-3">
                                <label class="font-weight-bold">{{ __('Icon / Emoji') }}</label>
                                <input type="text" name="icon" class="form-control text-center" value="🔥" placeholder="🔥, ✨, ⚡, ⭐">
                            </div>
                            <div class="col-md-8 form-group mb-3">
                                <label class="font-weight-bold">{{ __('Placement / Subtitle') }}</label>
                                <input type="text" name="subtitle" class="form-control" placeholder="{{ __('e.g. Home Special Feed') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold">{{ __('Default Badge Text') }}</label>
                                <input type="text" name="badge_text" class="form-control" placeholder="{{ __('e.g. Special Deal, 20% OFF') }}">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold">{{ __('Badge Color') }}</label>
                                <input type="color" name="color" class="form-control" value="#FA2C19" style="height: 38px; padding: 2px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">{{ __('Create Section') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
