@section('title', 'Categories')

<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 d-flex gap-3">
                            <button type="submit" data-bs-toggle="modal" data-bs-target="#addModal"
                                class="btn btn-primary btn-rounded waves-effect waves-light"><i
                                    class="mdi mdi-plus me-1"></i>Create New</button>
                            <button type="submit" class="btn btn-outline-danger btn-rounded waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#selectedModal"><i
                                    class="dripicons-trash me-1 font-size-10"></i>
                                Delete
                                ({{ count($checkedItems) }})</button>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-xxl-4 col-lg-4">
                            <div class="search-box">
                                <div class="position-relative">
                                    <input id="search" name="search" type="text" class="form-control"
                                        autocomplete="off" id="searchTableList" placeholder="Search category..."
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
                                    <th colspan="2">Category</th>
                                    <th colspan="2">Visibility</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($categories->isEmpty())
                                    <tr>
                                        <td class="pt-4" colspan="6">
                                            <div class="d-flex justify-content-center w-100">
                                                <p>No category available</p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($categories as $index => $category)
                                        <tr>
                                            <td>
                                                <input type="checkbox" id="checkedItems_{{ $index }}"
                                                    name="checkedItems" class="form-check-input"
                                                    value="{{ $category->id }}" wire:model="checkedItems"
                                                    wire:change="updateFilter">
                                            </td>
                                            <td>
                                                @if ($category->image)
                                                    <img src="{{ Storage::url($category->image) }}" alt="img"
                                                        title="{{ $category->name }}" class="avatar-sm rounded" />
                                                @else
                                                    <span>No Img</span>
                                                @endif
                                            </td>
                                            <td>
                                                <h5 class="font-size-14 text-dark text-truncate mb-1">
                                                    {{ $category->name }}</h5>
                                                <span>Slug : <span class="fw-medium">{{ $category->slug }}</span></span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-pill font-size-11 @if ($category->visibility == '1') badge-soft-danger @else badge-soft-success @endif">
                                                    {{ $category->visibility == '0' ? 'Publish' : 'Private' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button type="button" class="btn btn-sm text-success"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        title="Edit" data-bs-placement="top"
                                                        x-on:click="$wire.getDataEdit('{{ $category->id }}')">
                                                        <i class="far fa-edit font-size-15"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm text-danger"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        title="Remove" data-bs-placement="top"
                                                        x-on:click="$wire.getDataDelete('{{ $category->id }}')">
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
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.admin.category.add')
    @include('livewire.admin.category.edit')
    @include('livewire.admin.category.delete')
    @include('livewire.admin.category.selected')
</section>

@push('script')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addModal').modal('hide');
            $('#editModal').modal('hide');
            $('#deleteModal').modal('hide');
        });
    </script>
@endpush
