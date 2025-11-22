<?php
/**
 * Theme Health Check
 *
 * Adds a dashboard widget to check the theme's status and configuration.
 *
 * @package Agency_Plus
 */

function agency_plus_add_dashboard_widgets() {
	wp_add_dashboard_widget(
		'agency_plus_health_check',
		esc_html__( 'Theme Health Check', 'agency-plus' ),
		'agency_plus_dashboard_widget_render'
	);
}
add_action( 'wp_dashboard_setup', 'agency_plus_add_dashboard_widgets' );

function agency_plus_dashboard_widget_render() {
	$checks = array();

    // Check 1: PHP Version
    if ( version_compare( PHP_VERSION, '7.4', '>=' ) ) {
        $checks[] = array( 'status' => 'good', 'message' => 'PHP Version: ' . PHP_VERSION );
    } else {
        $checks[] = array( 'status' => 'warning', 'message' => 'PHP Version is old (' . PHP_VERSION . '). Recommend 7.4+.' );
    }

    // Check 2: WooCommerce
    if ( class_exists( 'WooCommerce' ) ) {
        $checks[] = array( 'status' => 'good', 'message' => 'WooCommerce is active.' );
    } else {
        $checks[] = array( 'status' => 'info', 'message' => 'WooCommerce is not active (optional).' );
    }

    // Check 3: Uploads Directory
    $upload_dir = wp_upload_dir();
    if ( wp_is_writable( $upload_dir['basedir'] ) ) {
         $checks[] = array( 'status' => 'good', 'message' => 'Uploads directory is writable.' );
    } else {
         $checks[] = array( 'status' => 'error', 'message' => 'Uploads directory is NOT writable.' );
    }

    // Check 4: Permalinks
    if ( get_option( 'permalink_structure' ) ) {
         $checks[] = array( 'status' => 'good', 'message' => 'Permalinks are enabled.' );
    } else {
         $checks[] = array( 'status' => 'warning', 'message' => 'Using default permalinks. Recommend changing settings.' );
    }

	// Render
	echo '<ul style="list-style: none; padding: 0;">';
	foreach ( $checks as $check ) {
        $color = '#10b981'; // Green
        $icon = '✓';
        if ( $check['status'] === 'warning' ) { $color = '#f59e0b'; $icon = '!'; }
        if ( $check['status'] === 'error' ) { $color = '#ef4444'; $icon = '✗'; }
        if ( $check['status'] === 'info' ) { $color = '#3b82f6'; $icon = 'i'; }

		echo '<li style="margin-bottom: 8px; color: ' . esc_attr( $color ) . ';">';
        echo '<span style="margin-right: 8px; font-weight: bold;">' . esc_html( $icon ) . '</span>';
		echo esc_html( $check['message'] );
		echo '</li>';
	}
	echo '</ul>';

    echo '<p><small>Running Agency Plus v' . esc_html( wp_get_theme()->get( 'Version' ) ) . '</small></p>';
}
