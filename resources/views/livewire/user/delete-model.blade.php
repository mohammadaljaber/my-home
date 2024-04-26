<div wire:ignore.self class="modal fade text-start" id="default" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Delete User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="reset_id"></button>
            </div>
            <div class="modal-body">
                
                <p>
                    Are you sure about deleting this user ?
                </p>
            </div>
            <form wire:submit.prevent="delete"><div class="modal-footer">
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" >Accept</button>
            </div>
        </form>
            
        </div>
    </div>
</div>