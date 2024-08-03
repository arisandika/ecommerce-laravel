@section('title', 'Add Product')

@push('style')
    <!-- Select2 CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/css/select2.min.css') }}" />

    <!-- Dropzone CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropzone/dropzone.css') }}" />
@endpush

@section('back-link')
    <div class="col-4 col-md-6 text-end">
        <a href="{{ url('/admin/products') }}" wire:navigate class="text-primary font-16">Back <i
                class="mdi mdi-chevron-right"></i></a>
    </div>
@endsection

<section>
    <form wire:submit.prevent="store" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Basic Information</h4>
                        <p class="card-title-desc">Fill all information below</p>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="name">Product Name</label>
                                    <input id="name" name="name" type="text" class="form-control"
                                        placeholder="" autocomplete="name" wire:model.defer="name">
                                    @error('name')
                                        <small class="text-danger ms-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="slug">Product Slug</label>
                                    <input id="slug" name="slug" type="text" class="form-control"
                                        placeholder="" wire:model.defer="slug">
                                    @error('slug')
                                        <small class="text-danger ms-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="short_description">Short Description</label>
                                    <textarea id="short_description" name="short_description" class="form-control" rows="3" placeholder=""
                                        wire:model.defer="short_description"></textarea>
                                </div>
                                <div class="mb-0">
                                    <label for="description">Long Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="6" placeholder=""
                                        wire:model.defer="description"></textarea>
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
                                    <input id="regular_price" name="regular_price" type="number" class="form-control"
                                        placeholder="" wire:model.defer="regular_price">
                                    @error('regular_price')
                                        <small class="text-danger ms-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="sale_price">Sale price (Rp)</label>
                                    <input id="sale_price" name="sale_price" type="number" class="form-control"
                                        placeholder="" wire:model.defer="sale_price">
                                    @error('sale_price')
                                        <small class="text-danger ms-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="quantity">Quantity</label>
                                    <input id="quantity" name="quantity" type="number" class="form-control"
                                        wire:model.defer="quantity">
                                    @error('quantity')
                                        <small class="text-danger ms-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="size_id" class="control-label">Size</label>
                                    <div class="row">
                                        @forelse ($sizesOption as $size)
                                            <div class="col-4">
                                                <div class="border rounded p-2 mb-2">
                                                    <input id="size_{{ $size->id }}" name="sizeTypes"
                                                        wire:model.defer="sizeTypes.{{ $size->id }}" type="checkbox"
                                                        class="form-check-input me-2" value="{{ $size->id }}">
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
                                    @error('size')
                                        <small class="text-danger ms-1">{{ $message }}</small>
                                    @enderror
                                    <br>
                                    <a href="{{ route('admin.size.index') }}" wire:navigate><small
                                            class="text-primary ms-1"><i class="mdi mdi-plus me-1"></i>Create
                                            New Size</small></a>
                                </div>
                                <div class="mb-0">
                                    <label for="weight">Weight (Kg)</label>
                                    <input id="weight" name="weight" type="number" class="form-control"
                                        placeholder="" wire:model.defer="weight">
                                    @error('weight')
                                        <small class="text-danger ms-1">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Meta Data</h4>
                        <p class="card-title-desc">Fill all information below</p>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="meta_title">Meta Title</label>
                                    <input id="meta_title" name="meta_title" type="text" class="form-control"
                                        placeholder="" wire:model.defer="meta_title">
                                </div>
                                <div class="mb-3">
                                    <label for="meta_keyword">Meta Keywords</label>
                                    <input id="meta_keyword" name="meta_keyword" type="text" class="form-control"
                                        placeholder="" wire:model.defer="meta_keyword">
                                </div>
                                <div class="mb-0">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder=""
                                        wire:model.defer="meta_description"></textarea>
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
                                        wire:model.defer="visibility">
                                        <option value="0" selected>Publish</option>
                                        <option value="1">Private</option>
                                    </select>
                                    @error('visibility')
                                        <small class="text-danger ms-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="trending" class="control-label">Trending</label>
                                    <select id="trending" name="trending" class="form-control"
                                        wire:model.defer="trending">
                                        <option value="0" selected>Non Trending</option>
                                        <option value="1">Trending</option>
                                    </select>
                                    @error('trending')
                                        <small class="text-danger ms-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-0">
                                    <label for="featured" class="control-label">Featured</label>
                                    <select id="featured" name="featured" class="form-control"
                                        wire:model.defer="featured">
                                        <option value="0" selected>Not Featured</option>
                                        <option value="1">Featured</option>
                                    </select>
                                    @error('featured')
                                        <small class="text-danger ms-1">{{ $message }}</small>
                                    @enderror
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
                                    <input id="brand" name="brand" type="text" class="form-control"
                                        placeholder="" wire:model.defer="brand">
                                    @error('brand')
                                        <small class="text-danger ms-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-0">
                                    <label for="category_id" class="control-label">Category</label>
                                    <select id="category_id" name="category_id" class="form-control"
                                        wire:model.defer="category_id">
                                        <option>Choose Category</option>
                                        @if (count($categories) > 0)
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option disabled>Category Unavailable</option>
                                        @endif
                                    </select>
                                    @error('category_id')
                                        <small class="text-danger ms-1">{{ $message }}</small>
                                    @enderror
                                    <br>
                                    <a href="{{ route('admin.categories.index') }}" wire:navigate><small
                                            class="text-primary ms-1"><i class="mdi mdi-plus me-1"></i>Create
                                            New Category</small></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Media Upload</h4>
                        <p class="card-title-desc">Add thumbnail or product gallery</p>
                        <div class="dropzones">
                            <input id="image" type="file" multiple class="form-control"
                                wire:model.defer="images">
                            @error('image')
                                <small class="text-danger ms-1">{{ $message }}</small>
                            @enderror
                            <div wire:loading wire:target="image" class="w-100 text-center my-4">
                                Uploading image...
                            </div>
                        </div>
                        <ul class="list-unstyled mb-0" id="dropzone-preview">
                            <li class="mt-2" id="dropzone-preview-list">
                                <div class="border rounded">
                                    <div class="d-flex p-2 align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-sm bg-light rounded">
                                                {{-- @if ($newImage)
                                                <img data-dz-thumbnail class="img-fluid rounded d-block"
                                                    src="{{ $newImage->temporaryUrl() }}" alt="tmp-img">
                                            @endif --}}
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="pt-1">
                                                <h5 class="fs-md mb-1" data-dz-name>&nbsp;</h5>
                                                <p class="fs-sm text-muted mb-0" data-dz-size></p>
                                                <strong class="error text-danger" data-dz-errormessage></strong>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 my-3">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"
                        wire:loading.attr="disabled" wire:target="newImage">
                        <span wire:loading.remove>Save Changes</span>
                        <span wire:loading>
                            Loading...
                        </span>
                    </button>
                    <a href="{{ route('admin.products.index') }}" wire:navigate
                        class="btn btn-outline-secondary waves-effect waves-light">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</section>

@push('script')
    <!-- Select 2 plugin -->
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

    <!-- Dropzone plugin -->
    <script src="{{ asset('assets/libs/dropzone/dropzone-min.js') }}"></script>

    <!-- Init script -->
    <script src="{{ asset('assets/js/pages/ecommerce-select2.init.js') }}"></script>
@endpush
