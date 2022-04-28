<script>
    $(function() {
        
        // add project
        $("body").on('click', '#postProposal', function() {
            blankInput();
            formfile('Pilih File Proposal')
            removeInvalid();
            $("#formTambahProposal").trigger("reset")
        });

        $("body").on("submit", "#formTambahProposal", function(e) {
            e.preventDefault();
            let url = "{{ route('konsultan.proposal.add') }}"
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
                    $("#modalProposal").modal("hide");
                    alertSuccess("Proposal anda berhasil ditambahkan");
                    $("#table-proposal").DataTable().ajax.reload();
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
        $('body').on('click', '#btnEditProposal', function() {

            const id = $(this).data("id");

            $("#table-proposal").DataTable().ajax.reload();
        })
        // Hpus project
        // $('body').on('click', '#hapusProject', function() {

        //     const id = $(this).data("id");
        //     const name = $(this).data("name");
        //     console.log(id);
        //     let url = baseUrl + "konsultan/project-del/" + id;
        //     alertDelete(url, "Project anda berhasil dihapus", name, id, "table-project");

        // })
    });
</script>
