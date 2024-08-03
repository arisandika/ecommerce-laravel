<div id="editStatus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true"
    wire:ignore.self>
    <form wire:submit.prevent="update">
        @csrf
        <div class="modal-dialog modal-dialog-scrollable modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalTitle" class="modal-title">Edit Status Order</h5>
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
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mb-0">
                                                    <label for="status_order" class="control-label">Status Order</label>
                                                    <select id="status_order" name="status_order" class="form-control"
                                                        wire:model.defer="status_order">
                                                        <option value="Being Packaged">Being Packaged</option>
                                                        <option value="To Ship">To Ship</option>
                                                        <option value="To Receive">To Receive</option>
                                                        <option value="Completed">Completed</option>
                                                        <option value="Cancelled">Cancelled</option>
                                                    </select>
                                                    @error('status_order')
                                                        <small class="text-danger ms-1">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light" wire:loading.attr="disabled"
                        wire:click="update">
                        <span wire:loading.remove>Update Changes</span>
                        <span wire:loading>
                            Loading...
                        </span>
                    </button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                        wire:click="closeModal">Close</button>
                </div>
            </div>
        </div>
    </form>
</div>
