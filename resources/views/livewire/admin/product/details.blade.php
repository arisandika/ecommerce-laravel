<div id="detailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle" class="modal-title">Detail Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click="closeModal"></button>
            </div>
            <div wire:loading>
                <div class="text-center mt-5 mb-2">
                    <div class="spinner-grow text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div wire:loading.remove>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Basic Information</h4>
                                    <p class="card-title-desc">Product details</p>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="name">Product Name</label>
                                                <input id="name" name="name" type="text" class="form-control"
                                                    autocomplete="name" wire:model.defer="name" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="product_id">Product ID</label>
                                                <input id="product_id" name="product_id" type="text"
                                                    class="form-control" wire:model.defer="product_id" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="slug">Product Slug</label>
                                                <input id="slug" name="slug" type="text" class="form-control"
                                                    wire:model.defer="slug" disabled>
                                            </div>
                                            <div class="mb-0">
                                                <label for="description">Product Description</label>
                                                <textarea id="description" name="description" class="form-control" rows="3" wire:model.defer="description"
                                                    disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Advance & Inventory Details</h4>
                                    <p class="card-title-desc">Additional details about the products</p>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="regular_price">Regular price (Rp)</label>
                                                <input id="regular_price" name="regular_price" type="number"
                                                    class="form-control" wire:model.defer="regular_price" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="sale_price">Sale price (Rp)</label>
                                                <input id="sale_price" name="sale_price" type="number"
                                                    class="form-control" wire:model.defer="sale_price" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="quantity">Quantity</label>
                                                <input id="quantity" name="quantity" type="number"
                                                    class="form-control" wire:model.defer="quantity" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="size_id" class="control-label">Size</label>
                                                <div class="row">
                                                    @forelse ($sizesOption as $size)
                                                        <div class="col-4">
                                                            <div class="border rounded p-2 mb-2">
                                                                <input id="size_{{ $size->id }}" name="sizeTypes"
                                                                    wire:model.defer="sizeTypes.{{ $size->id }}"
                                                                    type="checkbox" class="form-check-input me-2"
                                                                    value="{{ $size->id }}" disabled>
                                                                <span>{{ $size->name }}</span>
                                                                <br>
                                                                <p class="mt-3">Quantity : </p>
                                                                <input id="quantity_{{ $size->id }}"
                                                                    name="sizeQuantity[{{ $size->id }}]"
                                                                    wire:model.defer="sizeQuantity.{{ $size->id }}"
                                                                    type="number" class="form-control" />
                                                                <p class="mt-3">Price : </p>
                                                                <input id="price_{{ $size->id }}"
                                                                    name="sizePrice[{{ $size->id }}]"
                                                                    wire:model.defer="sizePrice.{{ $size->id }}"
                                                                    type="number" class="form-control" />
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p>Size Unavailable</p>
                                                    @endforelse
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <label for="weight">Weight (Kg)</label>
                                                <input id="weight" name="weight" type="number"
                                                    class="form-control" wire:model.defer="weight" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Meta Data</h4>
                                    <p class="card-title-desc">All meta data information</p>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="meta_title">Meta Title</label>
                                                <input id="meta_title" name="meta_title" type="text"
                                                    class="form-control" wire:model.defer="meta_title" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="meta_keyword">Meta Keywords</label>
                                                <input id="meta_keyword" name="meta_keyword" type="text"
                                                    class="form-control" wire:model.defer="meta_keyword" disabled>
                                            </div>
                                            <div class="mb-0">
                                                <label for="meta_description">Meta Description</label>
                                                <textarea class="form-control" id="meta_description" name="meta_description" rows="3"
                                                    wire:model.defer="meta_description" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Publishing Details</h4>
                                    <p class="card-title-desc">Additional publish information</p>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="visibility" class="control-label">Visibility</label>
                                                <select id="visibility" name="visibility" class="form-control"
                                                    wire:model.defer="visibility" disabled>
                                                    <option>
                                                        @if (isset($product) && $product->visibility == 0)
                                                            Public
                                                        @else
                                                            Private
                                                        @endif
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="trending" class="control-label">Trending</label>
                                                <select id="trending" name="trending" class="form-control"
                                                    wire:model.defer="trending" disabled>
                                                    <option>
                                                        @if (isset($product) && $product->trending == 0)
                                                            Non Trending
                                                        @else
                                                            Trending
                                                        @endif
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-0">
                                                <label for="featured" class="control-label">Featured</label>
                                                <select id="featured" name="featured" class="form-control"
                                                    wire:model.defer="featured" disabled>
                                                    <option>
                                                        @if (isset($product) && $product->featured == 0)
                                                            Not Featured
                                                        @else
                                                            Featured
                                                        @endif
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Brand & Category</h4>
                                    <p class="card-title-desc">Details about brand & product categories</p>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="brand">Brand</label>
                                                <input id="brand" name="brand" type="text"
                                                    class="form-control" wire:model.defer="brand" disabled>
                                            </div>
                                            <div class="mb-0">
                                                <label for="category_id" class="control-label">Category</label>
                                                <select id="category_id" name="category_id" class="form-control"
                                                    wire:model.defer="category_id" disabled>
                                                    <option>
                                                        @if (isset($product) && isset($product->category))
                                                            {{ $product->category->name }}
                                                        @else
                                                            No Category
                                                        @endif
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Media Upload</h4>
                                    <p class="card-title-desc">Thumbnail or product gallery</p>
                                    <ul class="list-unstyled mb-0" id="dropzone-preview">
                                        <li class="mt-2" id="dropzone-preview-list">
                                            <div class="border rounded">
                                                <div
                                                    class="d-flex flex-wrap justify-content-between align-items-center p-2 gap-2">
                                                    @if ($productImages && $productImages->isNotEmpty())
                                                        @foreach ($productImages as $pimage)
                                                            <div class="avatar-sm bg-light rounded">
                                                                <img class="img-fluid rounded"
                                                                    src="{{ Storage::url($pimage->image) }}"
                                                                    alt="{{ $pimage->name }}">
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p>This product doesn't have images.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect waves-light" data-bs-dismiss="modal"
                    wire:click="closeModal">Close</button>
            </div>
        </div>
    </div>
</div>
