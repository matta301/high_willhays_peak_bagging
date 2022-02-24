<?php

function display_historic_county_tops($page_id, $all_countries, $county_tops, $thumbnail_img ) { ?>

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
                                //echo '<pre>' , var_dump($county_top) , '</pre>';
                            ?>
                            <tr>
                                <td  class="py-3"><?php echo $counter_3; ?></td>
                                <td  class="py-3"><?php echo $county_top['county_top_name'] ?></td>
                                <td  class="py-3"><?php echo $county_top['post_title'] ?></td>
                                <td  class="py-3"><?php echo $county_top['elevation'] ?></td>
                                <td  class="py-3">
                                    <button type="button" 
                                            id="peak-<?php echo $county_top['ID'] ?>"
                                            class="btn btn-outline-<?php echo ($county_top['completed'] == 1) ? 'secondary' : 'primary'; ?> js-btn-complete" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#historic-modal"
                                            data-id="<?php echo $county_top['ID'] ?>"
                                            data-name="<?php echo $county_top['county_top_name'] ?>"
                                            data-country="<?php echo $county_top['country'] ?>"
                                            data-title="<?php echo $county_top['post_title'] ?>"
                                            data-date="<?php echo $county_top['summit_date'] ?>"
                                            data-fieldreport="<?php echo $county_top['comment_content'] ?>"
                                            data-guid="<?php echo $thumbnail_img->thumbnail_image( $county_top['guid'] ); ?>"
                                    >
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
        
        <?php include 'modal.php' ?>

        <div id="trophy-modal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Congratulations!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">                    
                    ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php } ?>
