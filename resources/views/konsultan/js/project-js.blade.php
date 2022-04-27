<script>
    $(function() {

        // add project
        $("body").on('click', '#tambahProject', function() {
            blankInput();
            formfile('Pilih gambar')
            removeInvalid();
            $("#formTambahProject").trigger("reset")
        });

        $("body").on("submit", "#formTambahProject", function(e) {
            e.preventDefault();
            let url = "{{ route('konsultan.project') }}"
            SetupAjax();
            $.ajax({
                url: url,
                dataType: "JSON",
                type: "POST",
                data: new FormData(this),
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    $(this).trigger("reset");
                    $("#modalProject").modal("hide");
                    alertSuccess("Project anda berhasil ditambahkan");
                    $("#table-project").DataTable().ajax.reload();
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(key, value) {
                            $("input[name=" + key + "]").addClass(
                                "is-invalid");
                            $("input[name=" + key + "]")
                                .next()
                                .html(value);
                        });
                    }
                },
            });
        });

        // edit Project
        $('body').on('click', '#btnEditProject', function() {

            const id = $(this).data("id");

            $("#table-project").DataTable().ajax.reload();
        })
        // Hpus project
        $('body').on('click', '#hapusProject', function() {

            const id = $(this).data("id");
            const name = $(this).data("name");
            console.log(id);
            let url = baseUrl + "konsultan/project-del/" + id;
            alertDelete(url, "Project anda berhasil dihapus", name, id, "table-project");

        })
    });
</script>
