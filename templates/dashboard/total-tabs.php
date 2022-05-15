<?php
    $counter_1 = 0;
    foreach( $data['all_countries'] as $one_country )  { 
        $counter_1++;
?>
<div class="col-sm-6 col-lg-3">
    <div class="card bg-light mb-5">
        <div class="card-body">
            <div class="country-name">
                <?php echo $data['all_countries'][$counter_1]['name']; ?>
                <div>
                    <span class="completed-total"><?php echo $data['all_countries'][$counter_1]['total']; ?></span>
                </div>
            </div>
            <div class="flag-container flag flag-of-<?php echo $data['all_countries'][$counter_1]['name']; ?>">
            </div>
        </div>
        <div class="card-footer">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="m14 6-4.22 5.63 1.25 1.67L14 9.33 19 16h-8.46l-4.01-5.37L1 18h22L14 6zM5 16l1.52-2.03L8.04 16H5z"/></svg>
            <?php echo $data['all_countries'][$counter_1]['highest']; ?>
        </div>
    </div>
</div>
<?php } ?>