<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.css" />

@php
    $created_by = App\Models\Client::where('id', $flat->auth_id)->value('name');

@endphp

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div id="modal_body">
    <form action="{{ route('flat.update') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $flat->id }}">
        <input type="hidden" name="client_id" value="{{ $flat->client_id }}">
        <div class="modal-body">
            <div class="mb-3 mt-3">
                <label for="tenant_name" class="form-label"> Flat Name</label>
                <input type="text" class="form-control" value="{{ $flat->flat_name }}" name="" readonly>
            </div>

            <div class="mb-3 mt-3">
                <label for="tenant_email" class="form-label"> Building</label>
                <input type="text" class="form-control" value="{{ $building->name }}" name="" readonly>
            </div>
            <div class="mb-3 mt-3">
                <label for="nid_no" class="form-label"> Flat Location</label>
                <input type="text" class="form-control" value="{{ $flat->flat_location }}" name="" readonly>
            </div>
            <div class="mb-3 mt-3">
                <h6> Status</h6>
                <input type="checkbox" name="status" value="1" @if ($flat->status == 1) checked @endif
                    data-bootstrap-switch data-off-color="danger" data-on-color="success">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.min.js"></script>
<script src="{{ asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

{{-- CHECKBOX  --}}
<script>
    $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
</script>
