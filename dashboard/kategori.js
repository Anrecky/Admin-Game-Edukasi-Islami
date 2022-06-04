$(document).ready(function () {
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'))

    $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';
    $.fn.dataTable.Buttons.defaults.className = 'my-2';


    var table = $('#tbl-data').DataTable({
        initComplete: function () {
            $(".dt-buttons").addClass("my-2")
        },
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/id.json'
        },
        dom: '<"d-flex justify-content-between my-3 align-items-center"<Bl>f>rti<"my-3"p>',
        select: {
            info: false,
            style: 'single'
        },

        buttons: [{
            text: 'Tambah',
            action: function () {
                $("input[name=form-method]").val("POST")
                $("input#id-kategori").val("")
                $("input#jenis-kategori").val("")
                $("button#btn-submit").addClass("btn-success").removeClass("btn-warning").text("Tambah Data")
                myModal.toggle()
            },
            className: " btn-success"
        },
        {
            text: 'Edit',
            action: function () {
                var selectedRowData = table.rows({ selected: true }).data()[0]
                if (selectedRowData != null) {
                    $("#exampleModalLabel").text("Perbaharui Data Kategori")
                    $("input[name=form-method]").val("PUT")
                    $("input#id-kategori").val(parseInt(selectedRowData[0]))
                    $("input#jenis-kategori").val(selectedRowData[1])
                    $("button#btn-submit").addClass("btn-warning").removeClass("btn-success").text("Perbaharui Data")
                    myModal.toggle()
                }

            },
            className: " btn-warning"
        },
        {
            text: 'Hapus',
            action: function () {
                var idKategori = table.rows({ selected: true }).data()[0][0]
                $("input#id-kategori").val(idKategori)
                $("form#form-delete").submit()
            },
            className: " btn-danger"
        }
        ]
    });

});