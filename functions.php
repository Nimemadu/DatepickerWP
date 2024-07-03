 <?php


function custom_enqueue_scripts() {
    wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_script('custom-datepicker', get_template_directory_uri() . '/js/custom-datepicker.js', array('jquery', 'jquery-ui-datepicker'), null, true);
}

add_action('wp_enqueue_scripts', 'custom_enqueue_scripts');


function fetch_holidays_and_date_range() {
    global $wpdb;

    // Fetch holidays from the custom table
    $holidays_table = $wpdb->prefix . 'holidays';
    $holidays = $wpdb->get_col("SELECT holiday_date FROM $holidays_table");

    // Fetch date range from the custom table
    $date_range_table = $wpdb->prefix . 'date_range';
    $date_range = $wpdb->get_row("SELECT start_date, end_date FROM $date_range_table", ARRAY_A);

    // Prepare the response
    $response = [
        'holidays' => $holidays,
        'date_range' => $date_range
    ];

    wp_send_json($response);
}

add_action('wp_ajax_fetch_holidays_and_date_range', 'fetch_holidays_and_date_range');
add_action('wp_ajax_nopriv_fetch_holidays_and_date_range', 'fetch_holidays_and_date_range');
