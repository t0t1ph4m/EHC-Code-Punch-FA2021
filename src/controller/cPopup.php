<?php class Popup
{
    public static function oneButton($title, $msg) { ?>
        
        <div id="uploadNotification" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $title ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p style="align:center; word-wrap: break-word;"><?= $msg ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $("#uploadNotification").modal('show');
            });
        </script>
    <?php }
} ?>
