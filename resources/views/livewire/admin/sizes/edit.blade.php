<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle" class="modal-title">Edit Size</h5>
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
                                                    <label for="name">Size Name</label>
                                                    <input id="name" name="name" type="text"
                                                        class="form-control" placeholder="" autocomplete="name"
                                                        wire:model.defer="name">
                                                    @error('name')
                                                        <small class="text-danger ms-1">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="code">Size Code</label>
                                                    <input id="code" name="code" type="text"
                                                        class="form-control" placeholder="" wire:model.defer="code">
                                                    @error('code')
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
