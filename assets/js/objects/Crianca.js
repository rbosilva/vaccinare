var Crianca = {
    rules: {
        nome: 'required',
        idade: {
            required: true,
            digits: true
        },
        sexo: 'required',
        mae: 'required',
        cor_etnia: 'required'
    },
    url: function (method, params) {
        method = typeof method === 'string' ? '/' + method : '';
        params = typeof params !== 'undefined' ? '/' + params : '';
        return System.base_url('crianca' + method + params);
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
                        {data: "nome"},
                        {data: "idade"},
                        {data: "sexo"},
                        {data: "parto_natural"},
                        {data: "mae"},
                        {data: "cor_etnia"},
                        {data: "editar"},
                        {data: "excluir"}
                    ]
                }
            });
            $('.novo').click(function () {
                self.form();
            });
            $('table.table').on('click', '.editar', function (e) {
                e.preventDefault();
                self.form($(this).get_tr_data('id'));
            }).on('click', '.excluir', function (e) {
                e.preventDefault();
                self.delete($(this).get_tr_data('id'));
            });
        });
    },
    form: function (id) {
        var self = this;
        if (typeof id === 'undefined') {
            id = 0;
        }
        $('#page-wrapper').load(self.url('form', id), function () {
            System.initializeComponents();
            $('#nome').focus();
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
            title: 'Excluir Lote',
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
    }
};
