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

                
                $.each(response, function(key, value) {

                    let selisih = selisihWaktu(value.created_at);
                    let badge = "";
                   



                    $('.list-group').prepend(` <li class="list-group-item flex-column list-group-item-action align-items-start list-lelang" data-id="${value.id}">

                              <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1 title">${value.title}</h5>
                                  <small class="date">${selisih}</small>
                                </div>
                                <small class="mr-2">Est.Biaya: Rp${value.budgetFrom} - Rp${value.budgetTo} - <span
                                class="mr-2 text-capitalize "> Style Desain: ${value.gayaDesain} </span><span><i
                                    class="fas fa-map-marker-alt"></i> ${value.owner.alamat}</span></small>
                                <div class="mb-1" class="desc text-justify">${value.description}</div>
                                <div class="style">
                                    ${badge}
                                </div>
                                <p><span  class="text-muted">Proposals</span> : <span class="font-weight-bolder ">${value.proposal_count}</span></p>
                           
                    </li>`)
                });
            },
        });


    }

    
</script>
