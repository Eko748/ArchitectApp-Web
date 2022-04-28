<form action="{{ url('/konsultan/project/'.$data_project->id) }}" method="post" id="formEditProject" enctype="multipart/form-data">
    <div class="modal-body">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $data_project->title }}">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label for="images">Images</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" multiple name="images[]">
                <label class="custom-file-label" for="images">Choose file</label>
            </div>
        </div>
        <div class="form-group">
            <label for="desc">Deskripsi</label>
            <textarea name="desc" class="form-control w-100 h-100" rows="5" value="">{{ $data_project->description }}</textarea>
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
