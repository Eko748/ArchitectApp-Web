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
    <div class="col col-lg-2">
        <label>Luas</label>
        <input type="text" class="form-control" value="{{ $data_lelang->luas }}" disabled>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-8">
        <label>Description</label>
        <textarea id="" cols="90" rows="10" disabled>{{ $data_lelang->description }}</textarea>
        {{-- <input type="text" class="form-control" value="{{ $data_lelang->description }}" disabled> --}}
    </div>
</div>
</div>
<div class="form-group">
    <label>Image Design</label>
    <div class="row">
        @foreach ($data_lelang->image as $image)
        <div class="col-lg-6 mb-3">
            <img src="/img/lelang/tkp/{{ $image->image }}" width='100%' alt="...">
        </div>
        @endforeach
    </div>
</div>
