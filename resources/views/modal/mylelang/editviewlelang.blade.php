<form action="{{ url('/owner/mylelang/updatelelang/'.$data_lelang->id) }}" method="POST">
    @method('PUT')
    @csrf
    <div class="form-group row">
        <div class="col-lg-6">
            <label>Title</label>
            <input type="text" class="form-control" value="{{ $data_lelang->title }}" name="title">
        </div>
        <div class="col-lg-6">
            <label>Gaya Desain</label>
            <input type="text" class="form-control" value="{{ $data_lelang->gayaDesain }}" name="gayaDesain">
        </div>
    </div>
    <div class="form-group row">
        <div class="col col-lg-4">
            <label>Budget From</label>
            <input type="text" class="form-control" value="{{ $data_lelang->budgetFrom }}" name="budgetFrom">
        </div>
        <div class="col col-lg-4">
            <label>Budget To</label>
            <input type="text" class="form-control" value="{{ $data_lelang->budgetTo }}" name="budgetTo">
        </div>
        <div class="col col-lg-2">
            <label>Luas</label>
            <input type="text" class="form-control" value="{{ $data_lelang->luas }}" name="luas">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-8">
            <label>Description</label>
            <textarea id="" cols="90" rows="10" name="description">{{ $data_lelang->description }}</textarea>
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
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
