<div class="modal-body">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" value="{{ $data_project->title }}" disabled>
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label for="images">Images</label>
        <div class="row">
            @foreach ($data_project->images as $image)
            <div class="col-lg-6 mb-3">
                <img src="/img/project/{{ $image->image }}" width='100%' alt="...">
            </div>
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <label for="desc">Deskripsi</label>
        <textarea name="desc" class="form-control w-100 h-100" rows="5" value="" disabled>{{ $data_project->description }}</textarea>
        <div class="invalid-feedback"></div>
    </div>
</div>
