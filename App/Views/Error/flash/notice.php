<div class='flash-messages wow fadeIn '>
    <?php
    foreach ($flash_message as $fm) :
    ?>
        <div class="alert alert-<?=  App\Utilities\FlashMessage::getCssClass($fm['type']) ?> alert-dismissible    show"data-wow-delay="0.5s" role="alert">
            <?= $fm['msg'] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endforeach; ?>
</div>