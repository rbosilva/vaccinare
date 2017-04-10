var Vacina = {
    rules: {
        nome: {
            required: true,
            maxlength: 100
        }
    },
    url: function (method, params) {
        method = typeof method === 'string' ? '/' + method : '';
        params = typeof params !== 'undefined' ? '/' + params : '';
        return System.base_url('vacina' + method + params);
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
                        {data: "excluir"}
                    ]
                }
            });
            $('.novo').click(function () {
                self.form();
            });
            $('table.table').on('click', '.excluir', function (e) {
                e.preventDefault();
                self.delete($(this).get_tr_data('id'));
            });
        });
    },
    form: function () {
        var self = this;
        $('#page-wrapper').load(self.url('form'), function () {
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
            title: 'Excluir Vacina',
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
