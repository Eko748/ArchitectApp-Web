<script>
    $(function() {
        let url = "{{ route('kontraktor.profile.show', Auth::user()->id) }}"
        let path = " {{ asset('img/avatar/') }}"
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: url,
            dataType: "JSON",
            type: "POST",
            success: function(response) {
                $("#name-readonly").val(response.name);
                $("#inisial").html(response.name);
                $("#user-login").html(response.username);
                $("#email-readonly").val(response.email);
                $("#uname-readonly").val(response.username);
                $(".pp").attr("src", path + "/" + response.avatar);

            },
        });

        $("#editProfile").click(function() {
            let id = $(this).data("id");
            let url = "{{ route('kontraktor.profile.edit', Auth::user()->id) }}";
            let Showurl = "{{ route('kontraktor.profile.show', Auth::user()->id) }}";
            showAjax(Showurl, id, "formProfile");
            removeInvalid();
            $("#formProfile").trigger("reset");
            $("#formProfile").submit(function(e) {
                e.preventDefault();
                $(this).prepend('<input type="hidden" name="_method" value="PUT">');
                ajaxValidate(
                    url,
                    "PUT",
                    "modalProfile",
                    "Profil anda berhasil di ubah"
                );
                loadUser();
            });
        });

        $("#editAva").click(function() {
            var id = $(this).data("id");
            formfile();
            $("#simpan").addClass("disabled");
            $("#avatar").on("change", function() {
                $("#simpan").removeClass("disabled");
            });
            $("#formAva").submit(function(e) {
                e.preventDefault();
                SetupAjax();
                $.ajax({
                    url: "{{ route('kontraktor.profile.ava', Auth::user()->id) }}",
                    dataType: "JSON",
                    type: "POST",
                    data: new FormData(this),
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $(this).trigger("reset");
                        $("#modalAva").modal("hide");
                        alertSuccess("Avatar anda berhasil diubah");
                        loadUser();
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
        });

        // modal edit password
        $("#editPass").click(function() {
            var id = $(this).data("id");
            removeInvalid();
            blankInput();
            $("#save").prop("disabled",true);
            $("#oldpass").on("focusout", function() {
                SetupAjax();
                $.ajax({
                    url: "{{ route('kontraktor.profile.confirm', Auth::user()->id) }}",
                    dataType: "JSON",
                    type: "POST",
                    data: $("#oldpass").serialize(),
                    cache: false,
                    success: function(response) {
                        if (response.status != true) {
                            $("#oldpass").removeClass("is-valid");
                             $("#save").prop("disabled",true);
                            $("#oldpass").addClass("is-invalid");
                        } else {
                            $("#save").prop("disabled",false);
                            $("#oldpass").addClass("is-valid");
                            $("#oldpass").removeClass("is-invalid");
                        }
                    },
                });
            });

            $("#formPass").submit(function(e) {
                e.preventDefault();
                ajaxValidate(
                    "{{ route('kontraktor.profile.pass', Auth::user()->id) }}",
                    "PUT",
                    "modalPass",
                    "Password anda berhasil diubah"
                );
            });
        });

        // modal hapus akun

        $("#hpsAkun").click(function() {
            var url = "{{ route('kontraktor.profile.del', Auth::user()->id) }}"
            alertDelete(url, "Akun anda berhasil dihapus", "akun ini", {{Auth::user()->id}});
        });
    })
</script>
