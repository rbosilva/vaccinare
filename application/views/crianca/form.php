<nav class="breadcrumb">
    <a href="" title="Ir para o Início"><i class="fa fa-home"></i> Início</a>
    <a href="" title="Ir para Crianças" data-object="crianca"> Crianças</a>
    <span class="active"><?php echo !isset($id) ? 'Novo' : 'Editar'; ?></span>
</nav>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo !isset($id) ? '<i class="fa fa-plus"></i> Nova Criança' : '<i class="fa fa-pencil"></i> Editar Criança'; ?>
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <input type="hidden" name="id" value="<?php echo evaluate($id); ?>">
                    <div class="form-group">
                        <label for="nome" class="control-label col-lg-2">Nome</label>
                        <div class="col-lg-10">
                            <input type="text" id="nome" name="nome" class="form-control" value="<?php echo evaluate($nome); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="idade" class="control-label col-lg-2">Idade</label>
                        <div class="col-lg-10">
                            <input type="text" id="idade" name="idade" class="form-control" value="<?php echo evaluate($idade); ?>" data-mask="00">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sexo" class="control-label col-lg-2">Sexo</label>
                        <div class="col-lg-10">
                            <select id="sexo" name="sexo" style="width: 100%;">
                                <option value="M" <?php echo evaluate($sexo) == 'M' ? 'selected' : '' ?>>Masculino</option>
                                <option value="F" <?php echo evaluate($sexo) == 'F' ? 'selected' : '' ?>>Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="parto-natural" class="control-label col-lg-2">Parto</label>
                        <div class="col-lg-10">
                            <label class="checkbox">
                                <input type="checkbox" id="parto-natural" name="parto_natural"
                                    <?php echo evaluate($parto_natural) == 1 ? 'checked' : ''; ?>>
                                Natural
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mae" class="control-label col-lg-2">Mãe</label>
                        <div class="col-lg-10">
                            <input type="text" id="mae" name="mae" class="form-control" value="<?php echo evaluate($mae); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cor_etnia" class="control-label col-lg-2">Cor/Etnia</label>
                        <div class="col-lg-10">
                            <select id="cor_etnia" name="cor_etnia" style="width: 100%;">
                                <?php
                                foreach (array('Branca', 'Negra', 'Parda', 'Indígena', 'Amarela') as $cor) {
                                    $selected = evaluate($cor_etnia, 'Branca') == $cor ? 'selected' : '';
                                ?>
                                    <option value="<?php echo $cor; ?>" <?php echo $selected; ?>><?php echo $cor; ?></option>
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
