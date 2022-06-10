<script>
    $(function() {
        loadUser()
        $("body").on('click', "#editProfile", function() {
            $('input[name=_method]').remove();
            let url = "{{ route('profileOwner', Auth::user()->id) }}";
            let Showurl = "{{ route('profileOwner', Auth::user()->id) }}";
            let id = {{ Auth::user()->id }}
            $.ajax({
                url: Showurl,
                dataType: "JSON",
                data: {
                    id: id
                },
                type: "POST",
                success: function(response) {
                    $("#name").val(response.name)
                    $("#email").val(response.email)
                    $("#username").val(response.username)
                },
            });
            removeInvalid();
            $("#formProfile").trigger("reset");
        });

        $("body").on("submit", "#formProfile", function(e) {
            e.preventDefault();
            let url = "{{ route('profileOwner', Auth::user()->id) }}";
            $(this).prepend('<input type="hidden" name="_method" value="PUT">');
            ajaxValidate(
                url,
                "PUT",
                "modalProfile",
                "Profil anda berhasil di ubah"
            );
            loadUser();
        });

        $("body").on('click', '#editAva', function() {
            formfile();
            $("#simpan").addClass("disabled");
            $("#avatar").on("change", function() {
                $("#simpan").removeClass("disabled");
            });
        });
        $("body").on("submit", '#formAva', function(e) {
            e.preventDefault();
            SetupAjax();
            $.ajax({
                url: "{{ route('gantiavaOwner', Auth::user()->id) }}",
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

        // modal edit password
        $("#editPass").click(function() {
            var id = $(this).data("id");
            removeInvalid();
            blankInput();
            $("#save").prop("disabled", true);
            $("#oldpass").on("focusout", function() {
                SetupAjax();
                $.ajax({
                    url: "{{ route('konsultan.profile.confirm', Auth::user()->id) }}",
                    dataType: "JSON",
                    type: "POST",
                    data: $("#oldpass").serialize(),
                    cache: false,
                    success: function(response) {
                        if (response.status != true) {
                            $("#oldpass").removeClass("is-valid");
                            $("#save").prop("disabled", true);
                            $("#oldpass").addClass("is-invalid");
                        } else {
                            $("#save").prop("disabled", false);
                            $("#oldpass").addClass("is-valid");
                            $("#oldpass").removeClass("is-invalid");
                        }
                    },
                });
            });

            $("#formPass").submit(function(e) {
                e.preventDefault();
                ajaxValidate(
                    "{{ route('konsultan.profile.pass', Auth::user()->id) }}",
                    "PUT",
                    "modalPass",
                    "Password anda berhasil diubah"
                );
            });
        });

        // modal hapus akun
        $("#hpsAkun").click(function() {
            var url = "{{ route('owner.profile.del', Auth::user()->id) }}"
            alertDelete(url, "Akun anda berhasil dihapus", "akun ini", {{ Auth::user()->id }});
        })
    })

    function loadUser() {
        let url = 'http://127.0.0.1:8000/owner/' + {{ Auth::user()->id }} + '/profile'
        let path = "http://127.0.0.1:8000/img/avatar/";
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
                $(".pp").attr("src", path + response.avatar);
            },
        });
    }
</script>
