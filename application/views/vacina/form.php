<nav class="breadcrumb">
    <a href="" title="Ir para o Início"><i class="fa fa-home"></i> Início</a>
    <a href="" title="Ir para Vacinas" data-object="vacina"> Vacinas</a>
    <span class="active">Novo</span>
</nav>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-plus"></i> Nova Vacina
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="nome" class="control-label col-lg-2">Nome</label>
                        <div class="col-lg-10">
                            <input type="text" id="nome" name="nome" class="form-control" value="<?php echo evaluate($nome); ?>">
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
