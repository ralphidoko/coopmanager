<div class="modal fade modal-dialog-centered" id="allow-admin" xmlns:wire="http://www.w3.org/1999/xhtml" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">Exit</span></button>
                <h4 class="modal-title"><b>Enter your password to continue</b></h4>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="grantAdminAccess()">
                    @csrf
                    <div class="row">
                        <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="password">Enter Password</label>
                                <input type="text" class="form-control" name="middle_name" wire:model.debounce.500ms="password">
                                @error('password') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                <br />
                                <button type="submit" style="width:40%;" class="form-control btn btn-primary">Grant Access</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div>@include('generalFlash')</div>
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
