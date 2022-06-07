$(document).ready(function () {

    var myModal = new bootstrap.Modal(document.getElementById('modalHasil'))

    $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';
    $.fn.dataTable.Buttons.defaults.className = 'my-2';

    $("#tgl_waktu").datetimepicker({
        format: "yyyy-mm-dd hh:ii:ss"
    });

    var table = $('#tbl-data').DataTable({
        order: [[3, 'desc']],
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
            text: 'Detail',
            action: function () {
                var idHasil = table.rows({ selected: true }).data()[0][0]
                if(idHasil) return window.open(`http://localhost/admin/dashboard/detail-hasil.php?id=${idHasil}`, "_self")
            },
            className: " btn-primary text-white"
        },
        {
            text: 'Edit',
            action: function () {
                var selectedRowData = table.rows({ selected: true }).data()[0]
                if (selectedRowData != null) {
                    $("input#id-hasil").val(parseInt(selectedRowData[0]))
                    $(`select#id-kategori option:contains('${selectedRowData[1]}')`).attr('selected', true)
                    $("input#skor").val(parseInt(selectedRowData[2]))
                    $("input#tgl_waktu").val(selectedRowData[3])
                    myModal.toggle()
                }

            },
            className: " btn-warning"
        },
        {
            text: 'Hapus',
            action: function () {
                var idHasil = table.rows({ selected: true }).data()[0][0]
                $("input#id-hasil").val(idHasil)
                $("form#form-delete").submit()
            },
            className: " btn-danger"
        }
        ]
    });

});