/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

// let baseUrl = "http://192.168.42.231:8000/";
let baseUrl = "http://127.0.0.1:8000/";

// let baseUrl = "http://192.168.100.75:8000/";

$(document).ready(function () {
    $(".preloader").fadeOut();
});

$(document).ajaxComplete(function () {
    $(".preloader").fadeOut();
});
function startLoad(modal = false) {
    if (modal) {
        $(document).ajaxStart(function () {
            modal.hide();
            $(".preloader").show();
        });
    } else {
        $(document).ajaxStart(function () {
            $(".preloader").show();
        });
    }
}
// logout
$(".logout").click(function () {
    $("#formLogout").submit();
});

// get Time login

$("#timelogin").click(function () {
    SetupAjax();
    $.ajax({
        url: "/gettimelogin",
        type: "POST",
        dataType: "JSON",
        cache: false,
        success: function (response) {
            if (response.time > 60) {
                $(".dropdown-title").html(
                    "Logged in " + Math.floor(response.time / 60) + " hour ago"
                );
            } else {
                $(".dropdown-title").html(
                    "Logged in " + response.time + " min ago"
                );
            }
        },
    });
});

$("body").on("click", "#viewUser", function () {
    let id = $(this).data("id");
    let url = baseUrl + "user/" + id;
    let path = baseUrl + "img/avatar/";
    SetupAjax();
    $.ajax({
        url: url,
        dataType: "JSON",
        type: "POST",
        success: function (response) {
            $(".td-name").val(response.name);
            $(".td-uname").val(response.username);
            $(".td-email").val(response.email);
            $(".pp").attr("src", path + response.avatar);
        },
    });
});

function removeInvalid() {
    $("input,textarea.is-invalid").on("keyup", function () {
        $(this).removeClass("is-invalid");
    });
    $("select.is-invalid").on("change", function () {
        $(this).removeClass("is-invalid");
    });
    $("input:checkbox").on("change", function () {
        $(this).removeClass("is-invalid");
    });
}
function blankInput() {
    $(".modal-body input,textarea").val("");
    $(".modal-body input,textarea.is-invalid").removeClass("is-invalid");
    // $(".custom-file-label").removeClass("selected").html("Pilih Gambar");
}
function ajaxValidate(url, method, modal, text) {
    var form = $(".modal-body form");
    SetupAjax();
    $.ajax({
        url: url,
        dataType: "JSON",
        type: method,
        data: form.serialize(),
        cache: false,
        success: function (response) {
            form.trigger("reset");
            $("#" + modal).modal("hide");
            alertSuccess(text);
        },
        error: function (xhr) {
            var res = xhr.responseJSON;
            if ($.isEmptyObject(res) == false) {
                $.each(res.errors, function (key, val) {
                    $("input[name=" + key + "]").addClass("is-invalid");
                    $("input[name=" + key + "]")
                        .next()
                        .html(val);
                });
            }
        },
    });
}
function showAjax(url, id, idForm) {
    var form = $("#" + idForm);
    SetupAjax();
    $.ajax({
        url: url,
        dataType: "JSON",
        data: { id: id },
        type: "POST",
        data: form.serialize(),
        success: function (response) {
            $.each(response.data, function (key, value) {
                $("input[name=" + key + "]").val(value);
            });
        },
    });
}

function alertSuccess(text) {
    Swal.fire({
        icon: "success",
        title: "Berhasil",
        text: text,
        footer: "",
        showCancelButton: false,
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 500,
    });
}

function alertDelete(url, text, detail, id, table) {
    Swal.fire({
        title: "Yakin?",
        text: "Anda akan menghapus " + detail,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Hapus",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
            $.ajax({
                url: url,
                method: "DELETE",
                data: { id: id },
                dataType: "JSON",
                success: function () {
                    alertSuccess(text);
                    $("#" + table)
                        .DataTable()
                        .ajax.reload();
                },
            });
        }
    });
}
function formfile(text = "Pilih avatar") {
    $(".custom-file-label").removeClass("selected").html(text);
    $(".custom-file-input").on("change", function () {
        if (this.files.length > 1) {
            return $(this)
                .next(".custom-file-label")
                .addClass("selected")
                .html(this.files.length + " files");
        }
        let fileName = $(this).val().split("\\").pop();
        return $(this)
            .next(".custom-file-label")
            .addClass("selected")
            .html(fileName);
    });
}
function SetupAjax() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
}

function selisihWaktu(waktu) {
    var a = moment(); //now
    var b = moment(waktu);
    let selisih = "";
    if (a.diff(b, "minutes") > 1440) {
        selisih = a.diff(b, "days") + " hari yang lalu";
    } else if (a.diff(b, "minutes") < 60) {
        selisih = a.diff(b, "minutes") + " menit yang lalu";
    } else if (a.diff(b, "minutes") == 0) {
        selisih = a.diff(b, "seconds") + " detik yang lalu";
    } else if (a.diff(b, "minutes") > 60) {
        selisih = a.diff(b, "hours") + " jam yang lalu";
    } else if (a.diff(b, "days") > 6) {
        selisih = a.diff(b, "weeks") + " minggu yang lalu";
    }
    return selisih;
}

function rupiahFormat(angka) {
    const format = angka.toString().split("").reverse().join("");
    const convert = format.match(/\d{1,3}/g);
    const rupiah = "Rp" + convert.join(".").split("").reverse().join("");

    return rupiah;
}

function maskingInput(input) {
    $(`${input}`).mask("000.000.000.000.000", { reverse: true });
}
