<?php
// echo plugin_dir_url( __DIR__ );
function display_historic_county_tops_honour_roll( $honour_roll ) { 
    // echo '<pre>' , var_dump( $honour_roll[0] ) , '</pre>';
    ?>
    <div class="honour-roll-page">
    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Scotland</th>
            <th scope="col">England</th>
            <th scope="col">Wales</th>
            <th scope="col">N. Ireland</th>
            <th scope="col">Total</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        <?php
            $count = 0;
            foreach( $honour_roll as $bagger ) { 
                $count++
            ?>
            <tr class="honour-roll-row place-<?php echo $bagger['total']; ?>" data-position="<?php echo $bagger['total']; ?>"">
                <th scope="row"><?php echo $count; ?></th>
                <td><?php echo $bagger['nicename']; ?></td>
                <td><?php echo $bagger['scotland']; ?></td>
                <td><?php echo $bagger['england']; ?></td>
                <td><?php echo $bagger['wales']; ?></td>
                <td><?php echo $bagger['n_ireland']; ?></td>
                <td class="total-peaks"><?php echo $bagger['total']; ?></td>
                <td class="award"></td>
            </tr>
        <?php 
            } 
        ?>
        </tbody>
    </table>
    <div>
<?php } ?>