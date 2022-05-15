<?php

function display_historic_county_tops($page_id, $all_countries, $county_tops, $thumbnail_img ) { 
    echo '<pre>' , var_dump($county_tops[0]) , '</pre>';
    ?>
    <div>
        <h1>Historic County Tops of the United Kingdom</h1>
    </div>
    <div class="peak-bagging-historic-county-tops">
        <!-- Tabs -->
        <ul class="county-tops nav nav-tabs mb-5" id="myTab" role="tablist">
            <?php 
                $counter_1 = 0;
                foreach ($all_countries as $one_country) { 
                    $counter_1++;
            ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php if($counter_1 == 1) { ?>active<?php } ?>" id="<?php echo $one_country; ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo $one_country; ?>" type="button" role="tab" aria-controls="<?php echo $one_country; ?>" aria-selected="true">
                        <?php 
                            if ( $one_country == 'n_ireland' ) {
                                echo substr_replace($one_country, 'N. Ireland', 0);
                            }else {
                                echo $one_country;
                            }                    
                        ?>
                    </button>
                </li>            
            <?php } ?>
        </ul>    
        <!-- Tab Container -->
        <div class="tab-content" id="county-tops-tabs" data-peak-error="">
            <?php
            $counter_2 = 0;
            foreach ($all_countries as $one_country) {
                $counter_2++;
            ?>
            <div class="tab-pane fade show <?php if($counter_2 == 1) { ?>active<?php } ?>" id="<?php echo $one_country; ?>" role="tabpanel" aria-labelledby="<?php echo $one_country; ?>-tab">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">County</th>
                            <th scope="col">Elevation</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $counter_3 = 0;
                            foreach ( $county_tops[$one_country] as $county_top) {
                                $counter_3++;
                                $guid = $county_top['guid'] != '' ? $thumbnail_img->thumbnail_image($county_top['guid']) : '';
                            ?>
                            <tr>
                                <td class="py-3"><?php echo $counter_3; ?></td>
                                <td class="py-3"><?php echo $county_top['county_top_name'] ?></td>
                                <td class="py-3"><?php echo $county_top['post_title'] ?></td>
                                <td class="py-3"><?php echo $county_top['elevation'] ?></td>
                                <td class="py-3">
                                    <button 
                                        id="peak-<?php echo $county_top['ID'] ?>"
                                        class="btn btn-outline-<?php echo ($county_top['completed'] == 1) ? 'secondary' : 'primary'; ?> js-btn-complete"
                                        type="button"
                                        data-bs-toggle="modal"
                                        href="#historicModal "
                                        data-id="<?php echo $county_top['ID'] ?>"
                                        data-name="<?php echo $county_top['county_top_name'] ?>"
                                        data-country="<?php echo $county_top['country'] ?>"
                                        data-posttitle="<?php echo $county_top['post_title'] ?>"
                                        data-date="<?php echo $county_top['summit_date'] ?>"
                                        data-fieldreport="<?php echo $county_top['comment_content'] ?>"
                                        data-guid="<?php echo $guid; ?>"                                        
                                        role="button"> 
                                        <?php echo ($county_top['completed'] == 1) ? 'Edit' : 'Complete'; ?>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } ?>
        </div>

        
        <!-- Modal -->
        <div class="peak-bagging-modal modal fade" id="historicModal" aria-hidden="true" aria-labelledby="historicModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title js-modal-title" id="historicModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="destroySession" value="1">
                            <input name='action' type="hidden" value='historic_modal_submission'>
                            <input type="hidden" class="form-control js-county-top-id" id="county-top-id" name="peak_id" value="">
                            <input type="hidden" class="form-control js-peak_county" id="peak_county" name="peak_county" value="">
                            <input type="hidden" class="form-control js-peak-country" id="peak-country" name="peak_country" value="">
                            <input type="hidden" class="form-control js-button-type" id="button-type" name="button_type" value="">
                            <?php wp_nonce_field('_wpnonce'); ?>
                            <div class="mb-3">
                                <label for="summit-date" class="form-label">Summit Date:</label>
                                <input  id="summit-date" class="form-control js-summit-date" name="peak_summit_date" data-toggle="datepicker" required>
                            </div>
                            <div class="mb-3">
                                <label for="summit-date" class="form-label">Field Report:</label>
                                <textarea class="form-control field-report js-field-report" name="peak_field_report" rows="5"></textarea>
                            </div>
                            <div class="mb-3">
                                <input id="peak_summit_image" type="file" class="form-control" name="peak_summit_image">
                                <?php if (isset( $_GET['file_size'] )) { ?><p class="form-error text-danger">File size is too big. (4 MB Max)</p><?php } ?>
                                <?php if (isset( $_GET['file_type'] )) { ?><p class="form-error text-danger">Wrong file format. (.png, .jpg)</p><?php } ?>
                                
                                <div class="js-preview-image d-none">
                                    <img id="peak_summit_image_preview" class="js-peak-summit-image-preview" src="" alt="Summit image preview" />
                                    <button type="submit" class="btn btn-outline-danger" name="submit" value="delete_image">delete</button>
                                </div>
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
                    </form>
                </div>
            </div>
        </div>

        <?php include 'trophy-modal.php' ?> 
    </div>
<?php } ?>
