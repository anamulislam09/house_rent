<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.css" />
<div id="modal_body">
    <form action="{{ route('building.update') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $data->id }}">
        <div class="modal-body">
            <div class="form-group ">
                <label for="tenant_email" class="form-label text"> Building Name</label>
                <input type="text" class="form-control text" value="{{ $data->name }}" name="name">
            </div>
            <div class="form-group ">
                <label for="Building" class="label text">Amount of Building Rent
                </label>
                <input type="text" class="form-control text" value="{{ $data->building_rent }}" name="building_rent"
                    required>
            </div>
            <div class="form-group ">
                <label for="unit" class="label text">Amount of Service Charge
                </label>
                <input type="text" class="form-control text" value="{{ $data->service_charge }}"
                    name="service_charge" required>
            </div>
            <div class="form-group ">
                <label for="unit" class="label text">Amount of Utility Bill
                </label>
                <input type="text" class="form-control text" name="utility_bill" value="{{ $data->utility_bill }}"
                    required>
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
