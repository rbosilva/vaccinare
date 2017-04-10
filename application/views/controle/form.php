<nav class="breadcrumb">
    <a href="" title="Ir para o Início"><i class="fa fa-home"></i> Início</a>
    <a href="" title="Ir para Controle de Vacinas" data-object="controle"> Controle de Vacinas</a>
    <span class="active">Novo</span>
</nav>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-plus"></i> Novo Controle de Vacina
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="crianca" class="control-label col-lg-2">Criança</label>
                        <div class="col-lg-10">
                            <select id="crianca" name="crianca" class="no-select2" style="width: 100%;"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vacina" class="control-label col-lg-2">Vacina</label>
                        <div class="col-lg-10">
                            <select id="vacina" name="vacina" class="no-select2" style="width: 100%;"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="data" class="control-label col-lg-2">Data</label>
                        <div class="col-lg-10">
                            <input type="text" id="data" name="data" data-mask="00/00/0000" class="form-control"
                                data-date-format="dd/mm/yyyy" value="<?php echo evaluate($dados['data'], date('d/m/Y')); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="horario" class="control-label col-lg-2">Horário</label>
                        <div class="col-lg-10">
                            <input type="text" id="horario" name="horario" class="form-control clockpicker" data-mask="00:00"
                                value="<?php echo evaluate($dados['horario'], date('H:i')); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dose" class="control-label col-lg-2">Dose</label>
                        <div class="col-lg-10">
                            <select id="dose" name="dose" style="width: 100%;">
                                <?php
                                foreach (array('Primeira', 'Segunda', 'Terceira', 'Única') as $dose) {
                                    $selected = evaluate($dados['dose'], 'Primeira') == $dose ? 'selected' : '';
                                ?>
                                <option value="<?php echo $dose; ?>" <?php echo $selected; ?>><?php echo $dose; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-offset-2 col-lg-10 form-buttons">
                        <button type="submit" class="btn btn-outline btn-primary"><i class="fa fa-save"></i> <span>Salvar</span></button>
                        <button type="button" class="btn btn-outline btn-danger cancelar"><i class="fa fa-ban"></i> <span>Cancelar</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
