$.extend($.fn.dataTable.defaults, {
    "pagingType": "full_numbers",
//    "order": [],
    "responsive": true,
    "fixedHeader": true,
    "processing": true,
    "serverSide": true,
    "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>Brt<"row"<"col-sm-6"i><"col-sm-6"p>>',
    "buttons": [
        {
            extend: 'pdf',
            text: 'Exportar para PDF',
            exportOptions: {
                columns: ':not(.no-print)'
            },
            customize: function (win) {
                win.content[0].text = $('.breadcrumb span.active').text();
                win.content[1].table.widths = '*';
            }
        },
        {
            extend: 'excel',
            text: 'Exportar para XLSX',
            filename: function () {
                return $('.breadcrumb span.active').text();
            },
            exportOptions: {
                columns: ':not(.no-print)'
            }
        },
        {
            extend: 'print',
            autoPrint: false,
            text: 'Visualizar impressão',
            exportOptions: {
                columns: ':not(.no-print)'
            },
            customize: function (window) {
                $(window.document.body).find('h1').remove();
                $(window.document.body).prepend('<h3>' + $('.breadcrumb span.active').text() + '</h3>');
                $(window.document.body).find('table').css('font-size', '12pt');
                $(window.document.body).prepend('<button class="btn btn-outline btn-default" onclick="window.print();"><i class="fa fa-print"></i> <span>Imprimir</span></button>');
            }
        }
    ],
    "columnDefs": [{
        targets: "no-sort",
        orderable: false,
        searchable: false
    }],
    "language": {
        "emptyTable": "Nenhum registro encontrado",
        "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
        "infoEmpty": "Mostrando 0 até 0 de 0 registros",
        "infoFiltered": "(Filtrados de _MAX_ registros)",
        "infoPostFix": "",
        "thousands": ".",
        "lengthMenu": "_MENU_ resultados por página",
        "loadingRecords": "Carregando...",
        "processing": "Processando...",
        "zeroRecords": "Nenhum registro encontrado",
        "search": "Pesquisar",
        "paginate": {
            "next": "<i class=\"glyphicon glyphicon-step-forward\"></i>",
            "previous": "<i class=\"glyphicon glyphicon-step-backward\"></i>",
            "first": "<i class=\"glyphicon glyphicon-fast-backward\"></i>",
            "last": "<i class=\"glyphicon glyphicon-fast-forward\"></i>"
        },
        "aria": {
            "sortAscending": ": Ordenar colunas de forma ascendente",
            "sortDescending": ": Ordenar colunas de forma descendente"
        }
    }
});
$.fn.dataTable.ext.errMode = 'none';
