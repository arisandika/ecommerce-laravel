@section('title', 'Products')

<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 d-flex gap-3">
                            <a href="{{ route('admin.products.add') }}" wire:navigate
                                class="btn btn-primary btn-rounded waves-effect waves-light"><i
                                    class="mdi mdi-plus me-1"></i>Create New</a>
                            <button type="submit" class="btn btn-outline-danger btn-rounded waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#selectedModal"><i
                                    class="dripicons-trash me-1 font-size-10"></i> Delete
                                ({{ count($checkedItems) }})
                            </button>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-xxl-4 col-lg-4">
                            <div class="search-box">
                                <div class="position-relative">
                                    <input id="search" name="search" type="text" class="form-control"
                                        autocomplete="off" id="searchTableList" placeholder="Search product..."
                                        wire:model="search" wire:keydown="updateFilter">
                                    <i class="bx bx-search-alt search-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-xxl-3 col-lg-3">
                            <select id="sortBy" name="sortBy" class="form-select rounded-pill" wire:model="sortBy"
                                wire:change="updateFilter" style="padding-left: 14px">
                                <option value="latest" selected="selected">Latest</option>
                                <option value="oldest">Oldest</option>
                                <option value="publish">Publish</option>
                                <option value="private">Private</option>
                                <option value="instock">In Stock</option>
                                <option value="outstock">Out Stock</option>
                                <option value="onsale">On Sale</option>
                                <option value="featured">Featured</option>
                                <option value="trending">Trending</option>
                            </select>
                        </div>
                        <div class="col-6 col-xxl-3 col-lg-3">
                            <select id="perPage" name="perPage" class="form-select rounded-pill" wire:model="perPage"
                                wire:change="updateFilter" style="padding-left: 14px">
                                <option value="10" selected="selected">Show 10</option>
                                <option value="20">Show 20</option>
                                <option value="40">Show 40</option>
                            </select>
                        </div>
                        <div class="col-2 col-xxl-2 col-lg-2">
                            <button type="button" class="btn btn-success btn-rounded w-100" onclick="filterData();"><i
                                    class="mdi mdi-filter-outline align-middle"></i> <span class="d-md-inline d-none">
                                    Filter</span></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap dt-responsive nowrap w-100 table-check"
                            id="order-list">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th colspan="2">Product</th>
                                    <th>Quantity</th>
                                    <th>Published</th>
                                    <th colspan="2">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($products->isEmpty())
                                    <tr>
                                        <td class="pt-4" colspan="6">
                                            <div class="d-flex justify-content-center w-100">
                                                <p>No product available</p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($products as $index => $product)
                                        <tr>
                                            <td>
                                                <input type="checkbox" id="checkedItems_{{ $index }}"
                                                    name="checkedItems" class="form-check-input" value="{{ $product->id }}"
                                                    wire:model="checkedItems" wire:change="updateFilter">
                                            </td>
                                            <td>
                                                @if ($product->productImages->isNotEmpty())
                                                    <img src="{{ Storage::url($product->productImages->first()->image) }}"
                                                        alt="img" title="{{ $product->name }}"
                                                        class="avatar-sm rounded" />
                                                @else
                                                    <span>No Img</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <h5 class="font-size-14 text-dark text-truncate mb-1">
                                                        {{ $product->name }}</h5>
                                                    <span class="mb-2">Category : <span
                                                            class="fw-medium">{{ $product->category->name }}</span></span>
                                                </div>
                                                <span type="button"
                                                    class="badge badge-pill font-size-11 badge-soft-primary"
                                                    data-bs-toggle="modal" data-bs-target="#detailModal" title="View Detail"
                                                    data-bs-placement="top"
                                                    x-on:click="$wire.getDetail('{{ $product->id }}')">
                                                    Detail<i class="mdi mdi-dots-horizontal ms-1"></i>
                                                </span>
                                                @if ($product->sale_price > 1)
                                                    <span class="badge badge-pill font-size-11 badge-soft-success">
                                                        On Sale
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-pill font-size-11 @if ($product->quantity < 1) badge-soft-danger @else badge-soft-success @endif">
                                                    {{ $product->quantity > 1 ? 'In Stock' : 'Out Stock' }}
                                                    ({{ $product->quantity }})
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-pill font-size-11 @if ($product->visibility == '1') badge-soft-danger @else badge-soft-success @endif">
                                                    {{ $product->visibility == '0' ? 'Publish' : 'Private' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span
                                                        class="@if ($product->sale_price > 1) text-line-through @endif">
                                                        Rp. {{ $product->regular_price }}
                                                    </span>
                                                    @if ($product->sale_price > 1)
                                                        <span>Rp. {{ $product->sale_price }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <a href="{{ route('admin.products.edit', ['id' => $product->id]) }}"
                                                        wire:navigate class="btn btn-sm text-success" title="Edit"
                                                        data-bs-placement="top">
                                                        <i class="far fa-edit font-size-15"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm text-danger"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        title="Remove" data-bs-placement="top"
                                                        x-on:click="$wire.getDataDelete('{{ $product->id }}')">
                                                        <i class="far fa-trash-alt font-size-15"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <!-- Pagination links -->
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.admin.product.details')
    @include('livewire.admin.product.delete')
    @include('livewire.admin.product.selected')
</section>