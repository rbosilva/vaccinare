<div class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo htmlentities($title) ?></h4>
            </div>
            <div class="modal-body">
                <div class="container row-fluid">
                    <label>
                        <?php echo htmlentities($msg) ?>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Sim</button>
                <button class="btn btn-danger" data-dismiss="modal">Não</button>
            </div>
        </div>
    </div>
</div>
