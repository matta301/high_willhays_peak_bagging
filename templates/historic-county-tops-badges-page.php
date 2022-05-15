<?php
// echo plugin_dir_url( __DIR__ );
function display_historic_county_tops_trophys($badges) { ?>
    <div>
        <h1>Trophy Cabinet</h1>
    </div>
    <div class="peakbagging-trophy-cabinet">
        <div class="row">
            <?php foreach($badges as $one_badge) { ?>
            <div class="col-sm-6 col-lg-3 col-xxl-2">
                <div class="card">
                    <div class="card-body">
                        <?php if( $one_badge["completed"] == '1' ) { ?>
                            <img class="county-top-badge" src="<?php echo plugin_dir_url( __DIR__ ); ?>/assets/images/badges/<?php echo strtolower($one_badge["post_title"]); ?>-historic-county-top.png" alt= "" />
                        <?php }else { ?>
                            <img class="placeholder county-top-badge" src="<?php echo plugin_dir_url( __DIR__ ); ?>/assets/images/badges/placeholder-county-top.png" alt= "" />
                        <?php } ?>
                        <p><?php echo $one_badge["county_top_name"]; ?><br/>
                            <?php echo $one_badge["post_title"]; ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>