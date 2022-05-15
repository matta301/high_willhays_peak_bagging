<?php
// echo plugin_dir_url( __DIR__ );
function display_historic_county_tops_dashboard( $data ) { ?>
    <div>
        <h1>Your Progress</h1>
    </div>
    <div class="dashboard-page">

        <!-- Country Totals -->
        <div class="row">
            <?php include 'dashboard/total-tabs.php'; ?>
        </div>


        <!-- ROW 2 -->
        <div class="row my-4">

            <div class="col-4 col-sm-8 col-md-6 col-lg-4 offset-sm-2 offset-md-0 mb-4">
                <?php include 'dashboard/percentage-chart.php'; ?>
            </div>

            <div class="col-4 col-sm-8 col-md-6 col-lg-4 offset-sm-2 offset-md-0">
                <div class="card bg-light">
                    <div class="card-body">
                        <strong class="stats combined-elevation"><?php echo $data['combined_elevation']; ?></strong>
                    </div>
                    <div class="card-footer">
                        Combined Elevation
                    </div>
                </div> 
                <div class="card bg-light my-4">
                    <div class="card-body">
                        <strong class="stats days-since"><?php echo $data['days_since']; ?></strong>
                    </div>
                    <div class="card-footer">
                        Days Since Last Peak
                    </div>
                </div>
            </div>

            <div class="doughnut-chart col-sm-8 col-sm-8 col-lg-4 offset-sm-2 offset-md-0 mt-4">
                <?php include 'dashboard/doughnut-chart.php'; ?>
            </div>
        </div>

        <!-- Yearly Progress Bar Chart -->
        <div class="bar-chart row mb-5 bg-light">
            <?php include 'dashboard/bar-chart.php'; ?>
        </div>
    </div>
<?php } ?>