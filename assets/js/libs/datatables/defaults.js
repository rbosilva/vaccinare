$.extend($.fn.dataTable.defaults, {
    "pagingType": "full_numbers",
//    "order": [],
    "responsive": true,
    "fixedHeader": true,
    "processing": true,
    "serverSide": true,
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
