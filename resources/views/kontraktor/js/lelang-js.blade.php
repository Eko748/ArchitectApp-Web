<script>
    $(function() {
        loadLelang()

        $('.list-group').on('click', '.list-lelang', function() {
            let id = $(this).data('id');
            window.location.href = baseUrl + 'konsultan/lelang/' + id
        });

    });

    function loadLelang() {
        SetupAjax();
        $.ajax({
            url: "{{ route('konsultan.lelang') }}",
            dataType: "JSON",
            type: "GET",
            success: function(response) {

                console.log(response)
                $.each(response, function(key, value) {

                    var a = moment(); //now
                    var b = moment(value.created_at);
                    let selisih = "";
                    if (a.diff(b, 'minutes') > 1440) {
                        selisih = a.diff(b, 'days') + " hari yang lalu"
                    } else if (a.diff(b, 'minutes') < 60) {
                        selisih = a.diff(b, 'minutes') + " menit yang lalu"
                    } else if (a.diff(b, 'minutes') > 60) {
                        selisih = a.diff(b, 'hours') + " jam yang lalu"
                    } else if (a.diff(b, 'days') > 6) {
                        selisih = a.diff(b, 'weeks') + " minggu yang lalu"
                    }



                    $('.list-group').prepend(` <li class="list-group-item flex-column list-group-item-action align-items-start list-lelang" data-id="${value.id}">

                              <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1 title">${value.title}</h5>
                                  <small class="date">${selisih}</small>
                                </div>
                                <small class="detil">Est.Biaya:${value.budget} - alamat</small>
                                <p class="mb-1" class="desc">${value.description}</p>
                                <div class="style">
                                    <a href="" class="badge badge-light">Jasa</a>
                                    <a href="" class="badge badge-light">Jasa</a>
                                    <a href="" class="badge badge-light">Jasa</a>
                                </div>
                                <p><span  class="text-muted">Proposals</span> : <span class="fw-bold prop-count">${value.proposal_count}</span></p>
                           
                    </li>`)
                });
            },
        });


    }

    
</script>
