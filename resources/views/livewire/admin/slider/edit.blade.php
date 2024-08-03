<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle" class="modal-title">Edit Slider</h5>
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
                        <div class="col-12">
                            <form wire:submit.prevent="update" enctype="multipart/form-data">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Basic Information</h4>
                                        <p class="card-title-desc">Edit all information below</p>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="name">Slider Name</label>
                                                    <input id="name" name="name" type="text"
                                                        class="form-control" placeholder="" autocomplete="name"
                                                        wire:model.defer="name">
                                                    @error('name')
                                                        <small class="text-danger ms-1">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="slug">Slider Slug</label>
                                                    <input id="slug" name="slug" type="text"
                                                        class="form-control" placeholder="" wire:model.defer="slug">
                                                    @error('slug')
                                                        <small class="text-danger ms-1">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description">Slider Description</label>
                                                    <textarea id="description" name="description" class="form-control" rows="3" placeholder=""
                                                        wire:model.defer="description"></textarea>
                                                    @error('description')
                                                        <small class="text-danger ms-1">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="mb-0">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">File Images</h4>
                                        <p class="card-title-desc">Edit for thumbnail</p>
                                        <div class="dropzones">
                                            <input id="image" name="image" type="file" class="form-control"
                                                wire:model.defer="newImage">
                                            @error('image')
                                                <small class="text-danger ms-1">{{ $message }}</small>
                                            @enderror
                                            <div wire:loading wire:target="newImage" class="w-100 text-center my-4">
                                                Uploading image ...
                                            </div>
                                        </div>
                                        <ul class="list-unstyled mb-0" id="dropzone-preview">
                                            <li class="mt-2" id="dropzone-preview-list">
                                                <div class="border rounded">
                                                    <div class="d-flex p-2 align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            <span class="font-size-10">Old Image</span>
                                                            <div class="avatar-sm bg-light rounded mt-1">
                                                                @if ($oldImage)
                                                                    <img src="{{ Storage::url($oldImage) }}"
                                                                        class="img-fluid rounded d-block">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="pt-1">
                                                                <h5 class="fs-md mb-1" data-dz-name>&nbsp;</h5>
                                                                <p class="fs-sm text-muted mb-0" data-dz-size></p>
                                                                <strong class="error text-danger"
                                                                    data-dz-errormessage></strong>
                                                            </div>
                                                        </div>
                                                        <div class="flex-shrink-0 ms-3">
                                                            <button data-dz-remove
                                                                class="btn btn-sm btn-danger">Delete</button>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex p-2 align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            <span class="font-size-10">New Image</span>
                                                            <div class="avatar-sm bg-light rounded mt-1">
                                                                @if ($newImage)
                                                                    <img src="{{ $newImage->temporaryUrl() }}"
                                                                        class="img-fluid rounded d-block">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="pt-1">
                                                                <h5 class="fs-md mb-1" data-dz-name>&nbsp;</h5>
                                                                <p class="fs-sm text-muted mb-0" data-dz-size></p>
                                                                <strong class="error text-danger"
                                                                    data-dz-errormessage></strong>
                                                            </div>
                                                        </div>
                                                        <div class="flex-shrink-0 ms-3">
                                                            <button data-dz-remove
                                                                class="btn btn-sm btn-danger">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light" wire:loading.attr="disabled"
                    wire:target="newImage" wire:click="update">
                    <span wire:loading.remove>Update Changes</span>
                    <span wire:loading>
                        Loading...
                    </span>
                </button>
                <button type="button" class="btn btn-light waves-effect waves-light" data-bs-dismiss="modal"
                    wire:click="closeModal">Close</button>
            </div>
        </div>
    </div>
</div>
