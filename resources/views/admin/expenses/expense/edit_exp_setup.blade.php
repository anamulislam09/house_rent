<style>
    .text {
        font-size: 14px !important;
    }
</style>

<form action="{{ route('exp_setup.update') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $data->id }}">
    <div class="modal-body" style="padding: 0px 15px !important">
        <div class="mb-3 mt-3">
            <label for="category_name" class="form-label text"> Expense Category:</label>
            <select name="cat_id" class="form-control text" id="" required>
                <option value="" selected disabled>Select Once</option>
                @foreach ($exp_cat as $item)
                    <option value="{{ $item->id }}" @if ($item->id == $data->cat_id) selected @endif>
                        {{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 mt-3">
            <label for="" class="form-label text"> Expense Nane:</label>
            <input type="text" class="form-control text" value="{{ $data->exp_name }}" name="exp_name">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger text" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary text">Update</button>
    </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
