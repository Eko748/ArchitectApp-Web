<div class="form-group row">
    <div class="col-lg-6">
        <label>Title</label>
        <input type="text" class="form-control" value="{{ $data_lelang->title }}" disabled>
    </div>
    <div class="col-lg-6">
            <label>Gaya Desain</label>
            <input type="text" class="form-control" value="{{ $data_lelang->gayaDesain }}" disabled>
        </div>
</div>
<div class="form-group row">
    <div class="col col-lg-4">
        <label>Budget From</label>
        <input type="text" class="form-control" value="{{ $data_lelang->budgetFrom }}" disabled>
    </div>
    <div class="col col-lg-4">
        <label>Budget To</label>
        <input type="text" class="form-control" value="{{ $data_lelang->budgetTo }}" disabled>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-8">
        <label>Description</label>
        <input type="text" class="form-control" value="{{ $data_lelang->description }}" disabled>
        </div>
    </div>
</div>
<div class="form-group row">
    <div class="col">
        <label>Image Design</label>
        <input type="text" class="form-control" value="{{ $data_lelang->image }}" disabled>
    </div>
    {{-- <div class="col">
        2 of 2
    </div> --}}
</div>
