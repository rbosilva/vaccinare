<nav class="breadcrumb">
    <a href="" title="Ir para o Início"><i class="fa fa-home"></i> Início</a>
    <a href="" title="Ir para Vacinas" data-object="vacina"> Vacinas</a>
    <span class="active"><?php echo !isset($id) ? 'Novo' : 'Editar'; ?></span>
</nav>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo !isset($id) ? '<i class="fa fa-plus"></i> Nova Vacina' : '<i class="fa fa-pencil"></i> Editar Vacina'; ?>
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <input type="hidden" name="id" value="<?php echo evaluate($id); ?>">
                    <div class="form-group">
                        <label for="lote" class="control-label col-lg-2">Lote</label>
                        <div class="col-lg-10">
                            <input type="text" id="lote" name="lote" class="form-control" <?php echo isset($id) ? 'disabled' : ''; ?>
                                value="<?php echo evaluate($lote); ?>" data-mask="0000000">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nome" class="control-label col-lg-2">Nome</label>
                        <div class="col-lg-10">
                            <input type="text" id="nome" name="nome" class="form-control" value="<?php echo evaluate($nome); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="data-validade" class="control-label col-lg-2">Validade</label>
                        <div class="col-lg-10">
                            <input type="text" id="data-validade" name="data_validade" data-mask="00/00/0000" class="form-control"
                                data-date-format="dd/mm/yyyy" value="<?php echo evaluate($data_validade, date('d/m/Y')); ?>"
                                <?php echo isset($id) ? 'disabled' : ''; ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fornecedor" class="control-label col-lg-2">Fornecedor</label>
                        <div class="col-lg-10">
                            <input type="text" id="fornecedor" name="fornecedor"
                                class="form-control" value="<?php echo evaluate($fornecedor); ?>">
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
