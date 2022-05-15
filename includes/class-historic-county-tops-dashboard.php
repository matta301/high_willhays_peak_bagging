<?php 

require_once WP_PLUGIN_DIR .'/high_willhays_peak_bagging/templates/historic-county-tops-dashboard-page.php';

class Historic_County_Tops_Dashboard
{
    public function __construct()
    {
        add_shortcode( 'county_tops_dashboard', [$this, 'display_historic_county_dashboard'] );
    }


    function chart_data()
    {
        global $wpdb;
        $userID = get_current_user_id();

        $data = $wpdb->get_results("CALL GetChartData({$userID})", ARRAY_A);
        $date_array = [];

        foreach( $data as $date ) {
            array_push( $date_array, $date['year'] );
        }

        $years = array_unique( $date_array );

        return array(
            'data' => $data,
            'years' => $years
        );
    }


    function totals( $data, $country_name ) 
    {
        $completed_total = [];

        foreach( $data as $country ) {
            if ( strtolower( $country["country"] ) == $country_name && $country["completed"] == '1' ) {
                array_push( $completed_total, $country );
            }
        }

        return count( $completed_total );
    }


    function combined_elevation( $data )
    {
        if ( isset( $data ) ) {
            $total_elevation = 0;
            foreach( $data as $peak ) {
                if( $peak['summit_date'] != null ) {
                    $str = explode('m', $peak["elevation"]);
                    $elevation = str_replace(',', '', trim( $str[0] ) );
                    $total_elevation += $elevation;
                }
            }
    
            return $total_elevation . ' m';

        }else {
            return 'N/A';
        }        
    }


    function days_since( $data )
    {
        if ( isset( $data[0]["summit_date"] ) ) {
            $summit_date = str_replace( '/', '-', $data[0]["summit_date"] );
            $diff = date_diff( new DateTime( date('Y-m-d', strtotime( $summit_date ) ) ), new DateTime( date('Y-m-d') ) );

            return $diff->days;
        }else {
            return 'N/A';
        }        
    }


    function country_totals( $data, $country_name )
    {
        $total = [];
        $completed_total = [];

        foreach( $data as $country ) {

            if ( strtolower( $country["country"] == $country_name ) ) {
                array_push( $total, $country);
            }

            if ( strtolower( $country["country"] ) == $country_name && $country["completed"] == '1' ) {
                array_push( $completed_total, $country );
            }
        }

        return count( $completed_total ) . ' / ' . count( $total );
    }


    function get_historic_peaks()
    {
        global $wpdb;
        $userID = get_current_user_id();
        $page_id = get_the_ID();

        // Returns list of all historic county tops along with completed peaks
        $data = $wpdb->get_results( "CALL GetHistoricCountyTops({$userID})", ARRAY_A );
        $chart_data = $this->chart_data();

        $all_countries = array(
            1 => array(
                'name' => 'scotland',
                'highest' => 'Ben Nevis - 1,345 m',
                'total' => $this->country_totals( $data, 'scotland' )
            ),
            2 => array(
                'name' => 'england',
                'highest' => 'Scafell Pike - 978 m',
                'total' => $this->country_totals( $data, 'england' )
            ),
            3 => array(
                'name' => 'wales',
                'highest' => 'Snowdon - 1,085 m',
                'total' => $this->country_totals( $data, 'wales' )
            ),
            4 => array(
                'name' => 'n-ireland',
                'highest' => 'Slieve Donard - 850 m',
                'total' => $this->country_totals( $data, 'northern ireland' )
            )
        );
        
        $all_totals = array(
            $this->totals( $data, 'scotland' ),
            $this->totals( $data, 'england' ),
            $this->totals( $data, 'wales' ),
            $this->totals( $data, 'northern ireland' )
        );

        return array( 
            'doughnut_chart' => json_encode( $all_totals ),
            'chart_data' => json_encode( $chart_data['data'] ),
            'chart_years' => $chart_data['years'],
            'all_countries' => $all_countries,
            'days_since' => $this->days_since( $data ),
            'combined_elevation' => $this->combined_elevation( $data )
        );
    }


    function display_historic_county_dashboard() 
    {
        ob_start();
        echo display_historic_county_tops_dashboard( $this->get_historic_peaks() );
        return ob_get_clean();
    }
}

?>