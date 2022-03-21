<div class="modal fade modal-dialog-centered" id="change_pwd" xmlns:wire="http://www.w3.org/1999/xhtml" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">Exit</span></button>
                <h4 class="modal-title">Change Password</h4>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="changePassword()">
                    <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                        <div class="form-group col-md-10 col-lg-10">
                            <label for="old_password">Old Password</label>
                            <input type="text" class="form-control" wire:model.debounce.500ms="old_password" value="">
                            @error('old_password') <span class="text-red-400 text-md">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-10 col-lg-10">
                            <label for="new_password">New Password</label>
                            <input type="text" class="form-control" name="middle_name" wire:model.debounce.500ms="new_password">
                            @error('new_password') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-10 col-lg-10">
                            <label for="last_name">Confirm password</label>
                            <input type="text" class="form-control" name="c_password" wire:model.debounce.500ms="c_password">
                            @error('c_password') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @csrf
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                    <div>@include('generalFlash')</div>
                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
{{--<style>--}}
{{--    .modal {--}}
{{--        position: absolute;--}}
{{--        top: 50%;--}}
{{--        left: 50%;--}}
{{--        transform: translate(-50%, -50%);--}}
{{--    }--}}
{{--</style>--}}
