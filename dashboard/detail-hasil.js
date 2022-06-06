$(document).ready(function () {

    var myModal = new bootstrap.Modal(document.getElementById('modalDetailHasil'))

    $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';
    $.fn.dataTable.Buttons.defaults.className = 'my-2';

    $("#tgl_waktu").datetimepicker({
        format: "yyyy-mm-dd hh:ii:ss"
    });

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
                $("#labelModalDetailHasil").text("Tambah Data Detail Hasil")
                $("input[name=form-method]").val("POST")
                $("input#id_detail_hasil").val("")
                $("input#opsi_satu").val("")
                $("input#opsi_dua").val("")
                $("input#opsi_tiga").val("")
                $("input#opsi_empat").val("")
                $("input#opsi_dipilih").val("")
                $("select#benar option:first").prop('selected', true)
                $("input#tgl_waktu").val("")
                $("select#pertanyaan option:first").prop('selected', true)
                $("button#btn-submit").addClass("btn-success").removeClass("btn-warning").text("Tambah Data")
                myModal.toggle()
            },
            className: " btn-success"
        },
        {
            text: 'Edit',
            action: function () {
                var selectedRowData = table.rows({ selected: true }).data()[0]
                console.log(selectedRowData)
                if (selectedRowData != null) {
                    let idPertanyaan = selectedRowData[1]['@data-order']
                    console.log(idPertanyaan)
                    $("#labelModalDetailHasil").text("Perbaharui Data Detail Hasil")
                    $("input[name=form-method]").val("PUT")
                    $("input#id_detail_hasil").val(`${selectedRowData[0]}`)
                    $(`select#pertanyaan`).val(idPertanyaan)
                    $("input#opsi_satu").val(selectedRowData[3])
                    $("input#opsi_dua").val(selectedRowData[4])
                    $("input#opsi_tiga").val(selectedRowData[5])
                    $("input#opsi_empat").val(selectedRowData[6])
                    $("input#opsi_dipilih").val(selectedRowData[7])
                    $(`select#benar option:contains('${selectedRowData[8]}')`).attr('selected', true)
                    $("input#tgl_waktu").val(selectedRowData[9])
                    $("button#btn-submit").addClass("btn-warning").removeClass("btn-success").text("Perbaharui Data")
                    myModal.toggle()
                }

            },
            className: " btn-warning"
        },
        {
            text: 'Hapus',
            action: function () {
                var idDetailHasil = table.rows({ selected: true }).data()[0][0]
                $("input#id_detail_hasil").val(idDetailHasil)
                $("form#form-delete").submit()
            },
            className: " btn-danger"
        }
        ]
    });

});