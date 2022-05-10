<script>
    $(function() {

        // add lelang
        $("body").on('click', '#tambahLelang', function() {
            blankInput();
            formfile('Pilih File')
            removeInvalid();
            $("#formTambahLelang").trigger("reset")
        });

        $("body").on("submit", "#formTambahLelang", function(e) {
            e.preventDefault();
            let url = "{{ route('konsultan.lelang-konsultan') }}"
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
                    $("#modalLelang").modal("hide");
                    alertSuccess("Lelang anda berhasil ditambahkan");
                    $("#table-lelang").DataTable().ajax.reload();
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

        // edit Lelang
        $('body').on('click', '#btnEditProject', function() {

            const id = $(this).data("id");

            $("#table-project").DataTable().ajax.reload();
        })
        // Hapus lelang
        $('body').on('click', '#hapusLelang', function() {

            const id = $(this).data("id");
            const name = $(this).data("name");
            console.log(id);
            let url = baseUrl + "konsultan/lelang-del/" + id;
            alertDelete(url, "Lelang anda berhasil dihapus", name, id, "table-lelang");

        })
    });
</script>
