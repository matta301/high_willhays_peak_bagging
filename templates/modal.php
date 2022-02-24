<div class="modal fade historic-modal" id="historic-modal" tabindex="-1" aria-labelledby="historic-modal" aria-hidden="true" role="dialog">
    <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="destroySession" value="1">
        <input name='action' type="hidden" value='historic_modal_submission'>
        <input type="hidden" class="form-control js-county-top-id" id="county-top-id" name="peak_id" value="">
        <input type="hidden" class="form-control js-peak-country" id="peak-country" name="peak_country" value="">
        <input type="hidden" class="form-control js-button-type" id="button-type" name="button_type" value="">
        <?php wp_nonce_field('_wpnonce'); ?>
        
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title js-modal-title" id="historic-modal"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="summit-date" class="form-label">Summit Date:</label>
                        <input  id="summit-date" class="form-control js-summit-date" name="peak_summit_date" data-toggle="datepicker" required>
                    </div>
                    <div class="mb-3">
                        <label for="summit-date" class="form-label">Field Report:</label>
                        <textarea class="form-control field-report js-field-report" name="peak_field_report"></textarea>
                    </div>
                    <div class="mb-3">
                        <input id="peak_summit_image" type="file" class="form-control" name="peak_summit_image">
                        <?php if (isset( $_GET['file_size'] )) { ?><p class="form-error text-danger">File size is too big. (2MB Max)</p><?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button type="submit" class="btn btn-primary btn-complete" name="submit" value="complete">Complete</button>
                    <button type="submit" class="btn btn-primary btn-edit d-none" name="submit" value="edit">Update</button>

                    <button type="submit" class="btn btn-outline-danger btn-trash d-none" name="submit" value="delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

