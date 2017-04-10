var Controle = {
    rules: {
        crianca: {
            required: true,
            digits: true
        },
        vacina: {
            required: true,
            digits: true
        },
        data: {
            required: true,
            dateBR: true
        },
        horario: {
            required: true,
            time24h: true
        },
        dose: 'required'
    },
    url: function (method, params) {
        method = typeof method === 'string' ? '/' + method : '';
        params = typeof params !== 'undefined' ? '/' + params : '';
        return System.base_url('controle' + method + params);
    },
    init: function () {
        var self = this;
        $('#page-wrapper').load(self.url('index'), function () {
            System.initializeComponents({
                datatables: {
                    ajax: {
                        url: self.url('index'),
                        type: "POST"
                    },
                    columns: [
                        {data: "data"},
                        {data: "horario"},
                        {data: "crianca", visible: false},
                        {data: "vacina"},
                        {data: "dose"},
                        {data: "excluir"}
                    ],
                    order: [[2, "asc"], [0, "asc"]],
                    drawCallback: function (settings) {
                        var api = this.api();
                        var rows = api.rows({page: 'current'}).nodes();
                        var last = null;
                        api.column(2, {page: 'current'}).data().each(function (group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before(
                                    '<tr class="group">\n\
                                        <td role="button" class="no-collapse"><b>Criança:</b></td>\n\
                                        <td colspan="5">' + group + '</td>\n\
                                    </tr>'
                                );
                                last = group;
                            }
                        });
                    }
                }
            });
            $('.novo').click(function () {
                self.form();
            });
            $('table.table').on('click', '.excluir', function (e) {
                e.preventDefault();
                self.delete($(this).get_tr_data('id'));
            }).on('click', 'tr.group td:first-child', function () {
                var table = $(this).closest('table.table').DataTable(),
                    currentOrder = table.order()[0] || [2, 'asc'];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([[2, 'desc'], [0, 'asc']]).draw();
                } else {
                    table.order([[2, 'asc'], [0, 'asc']]).draw();
                }
            }).on('click', '.visualizar-crianca', function (e) {
                e.preventDefault();
                var id = $(this).data('id-crianca');
                $.post(System.base_url('crianca/form/' + id), function (html) {
                    var modal = self.modal('Visualizar Criança', $(html).find('.panel-body').html());
                    modal.find('form').find('input, select').prop('disabled', true);
                    modal.find('.form-buttons').hide();
                    System.initializeComponents({
                        content: modal
                    });
                    modal.modal('show').on('shown.bs.modal', function () {
                        $(this).find('form').submit(function () {
                            return false;
                        });
                    });
                });
            });
        });
    },
    form: function () {
        var self = this;
        $('#page-wrapper').load(self.url('form'), function () {
            System.initializeComponents();
            $('#crianca').select2({
                ajax: {
                    url: self.url('childs'),
                    dataType: 'json',
                    type: 'post',
                    delay: 250,
                    cache: true,
                    data: function (params) {
                        return params;
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.dados,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    }
                }
            }).focus();
            $('#vacina').select2({
                ajax: {
                    url: self.url('vaccines'),
                    dataType: 'json',
                    type: 'post',
                    delay: 250,
                    cache: true,
                    data: function (params) {
                        return params;
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.dados,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    }
                }
            });
            $('.form-horizontal').validate({
                submitHandler: function (form) {
                    self.save(form);
                },
                rules: self.rules
            });
        });
    },
    save: function (form) {
        var self = this;
        $.post(self.url('save'), $(form).getFormData(), function (json) {
            System.alert({
                msg: json.msg,
                msg_type: json.info === 1 ? 'info' : 'error'
            });
            if (json.info === 1) {
                self.init();
            }
        }, 'json');
    },
    delete: function (id) {
        var self = this;
        System.confirm({
            title: 'Excluir Controle de Vacina',
            msg: 'Deseja realmente excluir este registro?',
            onConfirm: function () {
                $.post(self.url('delete/' + id), function (json) {
                    if (json.info === 1) {
                        self.init();
                    } else {
                        System.alert({
                            msg: json.msg,
                            msg_type: 'error'
                        });
                    }
                }, 'json');
            }
        });
    },
    modal: function (title, html) {
        return $('<div class="modal fade" role="dialog" tabindex="-1">\n\
                    <div class="modal-dialog">\n\
                        <div class="modal-content">\n\
                            <div class="modal-header">\n\
                                <button type="button" class="close" data-dismiss="modal">&times;</button>\n\
                                <h4 class="modal-title">' + title + '</h4>\n\
                            </div>\n\
                            <div class="modal-body">' +
                                html + '\n\
                            </div>\n\
                            <div class="modal-footer">\n\
                                <button class="btn btn-outline btn-primary" data-dismiss="modal">Fechar</button>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </div>');
    }
};
