<?php if( !empty( $data['chart_years'] ) ) { ?>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <?php 
        $counter = 0;
        foreach ( $data['chart_years'] as $value ) { 
            $counter++;
        ?>
        <li class="nav-item" role="presentation">
            <button 
                class="nav-link <?php if($counter == 1) { ?>active<?php } ?>" 
                id="year-<?php echo $value; ?>" 
                data-bs-toggle="tab" 
                data-bs-target="#tab-year-<?php echo $value; ?>" 
                type="button" 
                role="tab"
                aria-controls="tab-year-<?php echo $value; ?>" 
                aria-selected="true"
            >
            <?php echo $value; ?>
            </button>
        </li>
        <?php } ?>
    </ul>

    <?php if( isset( $data["chart_data"] ) ) { ?>
    <script>
        sessionStorage.setItem('completed', '<?php echo $data["chart_data"]; ?>');
    </script>
    <?php } ?>
    <canvas id="myChart"></canvas>
<?php }else { ?>
    <script>
        sessionStorage.removeItem('completed');
    </script>

    <div class="empty-bar-chart-wrapper">
        <p>You haven't completed any peaks yet. </p>
        <a class="btn btn-primary" href="<?php bloginfo('url') ?>/peak-bagging-historic-county-tops/">Complete your first peak</a>
    </div>

<?php } ?>