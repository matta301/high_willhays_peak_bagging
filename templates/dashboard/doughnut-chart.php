<?php if ( $data["doughnut_chart"] != '[0,0,0,0]') { ?>
    <script>
            sessionStorage.setItem('totals', '<?php echo $data["doughnut_chart"]; ?>');
    </script>
    <canvas id="doughnut"></canvas>
<?php } else { ?>
    <blockquote class="blockquote">The best view comes after<br/>the hardest climb</blockquote>
<?php } ?>