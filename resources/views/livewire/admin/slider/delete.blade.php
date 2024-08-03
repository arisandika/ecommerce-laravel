<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true"
    wire:ignore.self>
    <form wire:submit.prevent="delete">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalTitle" class="modal-title">Delete Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <h4 class="card-title">Information</h4>
                    <p class="card-title-desc">Are you sure want to delete this data?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">
                        <span wire:loading.remove>Delete</span>
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
