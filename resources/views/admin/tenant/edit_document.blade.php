<div class="card">
    <div class="card-body">
        <form action="{{ route('tenant-document.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $data->id }}">
            <div class="form-group text">
                <label for="tenant_id" class="text">Tenant</label>
                <select name="tenant_id" class="form-control" id="tenant_id">
                    <option value="" selected disabled>Select Once</option>
                    @foreach ($tenants as $tenant)
                        <option value="{{ $tenant->id }}" @if ($data->tenant_id == $tenant->id) selected @endif>
                            {{ $tenant->name }}</option>
                    @endforeach
                </select>
                @error('tenant_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group text">
                <div class="row">
                    <div class="col-lg-8 col-md-6 col-sm-12">
                        <label for="nid" class="text">NID/NRC</label>
                        <input type="file" name="nid" class="form-control dropify" data-height="100">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <img src="{{ asset('storage/' . $data->nid) }}" style="width: 50px" alt="nid Image">
                    </div>
                </div>
                @error('nid')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group text">
                <div class="row">
                    <div class="col-lg-8 col-md-6 col-sm-12">
                        <label for="tin" class="text">TIN</label>
                        <input type="file" name="tin" class="form-control dropify" data-height="100">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <img src="{{ asset('storage/' . $data->tin) }}" style="width: 50px" alt="tin Image">
                    </div>
                </div>

                @error('tin')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group text">
                <div class="row">
                    <div class="col-lg-8 col-md-6 col-sm-12">
                        <label for="photo" class="text">Tenant Photo</label>
                        <input type="file" name="photo" class="form-control dropify" data-height="100">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <img src="{{ asset('storage/' . $data->photo) }}" style="width: 50px" alt="photo Image">
                    </div>
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group text">
                    <div class="row">
                        <div class="col-lg-8 col-md-6 col-sm-12">
                            <label for="deed" class="text">Deed</label>
                            <input type="file" name="deed" class="form-control dropify">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <img src="{{ asset('storage/' . $data->deed) }}" style="width: 50px" alt="deed Image">
                        </div>
                    </div>
                    @error('deed')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group text">
                    <div class="row">
                        <div class="col-lg-8 col-md-6 col-sm-12">
                            <label for="police_form" class="text">Police Form</label>
                            <input type="file" name="police_form" class="form-control dropify" data-height="100">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 " style="border:1px solid #f2f0f0">
                            <img src="{{ asset('storage/' . $data->police_form) }}" style="width: 60px"
                                alt="police_form Image">
                        </div>
                    </div>
                    @error('police_form')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <input type="submit" class="btn btn-primary" value="Submit">
        </form>
    </div>
</div>
