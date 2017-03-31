<div class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $msg_type === 'info' ? 'Informação' : 'Erro'; ?></h4>
            </div>
            <div class="modal-body">
                <div class="container row-fluid">
                    <?php echo $msg ?>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-<?php echo $msg_type == 'info' ? 'primary' : 'danger'; ?>" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
