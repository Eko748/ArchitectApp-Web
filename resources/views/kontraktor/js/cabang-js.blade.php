<script>
    $(function() {

        // add project
        $("body").on('click', '#tambahCabang', function() {
            blankInput();
            formfile('Pilih gambar')
            removeInvalid();
            $("#formTambahCabang").trigger("reset")
        });

        $("body").on("submit", "#formTambahCabang", function(e) {
            e.preventDefault();
            let url = "{{ route('kontraktor.cabang') }}"
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
                    $("#modalCabang").modal("hide");
                    alertSuccess("Cabang anda berhasil ditambahkan");
                    $("#table-cabang").DataTable().ajax.reload();
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

        // edit Cabang
        $('body').on('click', '#btnEditCabang', function() {

            const id = $(this).data("id");

            $("#table-cabang").DataTable().ajax.reload();
        })
        // Hpus Cabang
        // $('body').on('click', '#hapusCabang', function() {

        //     const id = $(this).data("id");
        //     const name = $(this).data("name");
        //     console.log(id);
        //     let url = baseUrl + "kontraktor/cabang-del/" + id;
        //     alertDelete(url, "Data Cabang anda berhasil dihapus", name, id, "table-cabang");

        // })
    });
</script>
