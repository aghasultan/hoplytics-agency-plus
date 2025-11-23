<?php
/**
 * Custom Post Types and Taxonomies Registration
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined( 'ABSPATH' ) || exit;

/**
 * Register Custom Post Types
 */
function hoplytics_register_cpts() {

    // 1. Projects (Portfolio)
    register_post_type( 'project', array(
        'labels' => array(
            'name' => __( 'Projects', 'hoplytics' ),
            'singular_name' => __( 'Project', 'hoplytics' ),
            'add_new_item' => __( 'Add New Project', 'hoplytics' ),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'rewrite' => array( 'slug' => 'case-studies' ),
        'show_in_rest' => true,
    ));

    // 2. Services
    register_post_type( 'service', array(
        'labels' => array(
            'name' => __( 'Services', 'hoplytics' ),
            'singular_name' => __( 'Service', 'hoplytics' ),
            'add_new_item' => __( 'Add New Service', 'hoplytics' ),
        ),
        'public' => true,
        'hierarchical' => true, // Parent/Child support
        'has_archive' => true,
        'menu_icon' => 'dashicons-grid-view',
        'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
        'show_in_rest' => true,
    ));

    // 3. Team Members
    register_post_type( 'team_member', array(
        'labels' => array(
            'name' => __( 'Team', 'hoplytics' ),
            'singular_name' => __( 'Team Member', 'hoplytics' ),
            'add_new_item' => __( 'Add Team Member', 'hoplytics' ),
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-groups',
        'supports' => array( 'title', 'thumbnail', 'excerpt' ), // Excerpt = Bio
        'show_in_rest' => true,
    ));

    // 4. Testimonials
    register_post_type( 'testimonial', array(
        'labels' => array(
            'name' => __( 'Testimonials', 'hoplytics' ),
            'singular_name' => __( 'Testimonial', 'hoplytics' ),
            'add_new_item' => __( 'Add Testimonial', 'hoplytics' ),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => array( 'title', 'editor', 'thumbnail' ), // Title = Client Name, Editor = Quote
        'show_in_rest' => true,
    ));

    // 5. Careers
    register_post_type( 'career', array(
        'labels' => array(
            'name' => __( 'Careers', 'hoplytics' ),
            'singular_name' => __( 'Job Opening', 'hoplytics' ),
            'add_new_item' => __( 'Add Job Opening', 'hoplytics' ),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-businessman',
        'supports' => array( 'title', 'editor' ),
        'rewrite' => array( 'slug' => 'careers' ),
        'show_in_rest' => true,
    ));
}
add_action( 'init', 'hoplytics_register_cpts' );

/**
 * Register Taxonomies
 */
function hoplytics_register_taxonomies() {

    // Industry (Projects)
    register_taxonomy( 'industry', 'project', array(
        'labels' => array( 'name' => __( 'Project Industries', 'hoplytics' ) ),
        'hierarchical' => true,
        'show_in_rest' => true,
    ));

    // Tech Stack (Projects)
    register_taxonomy( 'tech_stack', 'project', array(
        'labels' => array( 'name' => __( 'Tech Stack', 'hoplytics' ) ),
        'hierarchical' => false, // Like tags
        'show_in_rest' => true,
    ));

    // Service Type (Services)
    register_taxonomy( 'service_type', 'service', array(
        'labels' => array( 'name' => __( 'Service Types', 'hoplytics' ) ),
        'hierarchical' => true,
        'show_in_rest' => true,
    ));

    // Department (Team & Careers)
    register_taxonomy( 'department', array('team_member', 'career'), array(
        'labels' => array( 'name' => __( 'Departments', 'hoplytics' ) ),
        'hierarchical' => true,
        'show_in_rest' => true,
    ));
}
add_action( 'init', 'hoplytics_register_taxonomies' );

/**
 * Add Custom Meta Boxes for Relationships
 */
function hoplytics_add_meta_boxes() {
    // Service <-> Project Relationship
    add_meta_box(
        'project_service_relation',
        __( 'Related Service', 'hoplytics' ),
        'hoplytics_render_service_meta_box',
        'project',
        'side',
        'default'
    );

    // Testimonial <-> Service Relationship
    add_meta_box(
        'testimonial_service_relation',
        __( 'Related Service', 'hoplytics' ),
        'hoplytics_render_service_meta_box', // Reuse same callback
        'testimonial',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'hoplytics_add_meta_boxes' );

/**
 * Render Service Selection Meta Box
 */
function hoplytics_render_service_meta_box( $post ) {
    $selected = get_post_meta( $post->ID, '_related_service_id', true );
    $services = get_posts( array( 'post_type' => 'service', 'numberposts' => -1 ) );

    wp_nonce_field( 'hoplytics_save_meta', 'hoplytics_meta_nonce' );
    ?>
    <label for="related_service_id"><?php _e( 'Select a Service:', 'hoplytics' ); ?></label>
    <select name="related_service_id" id="related_service_id" style="width:100%">
        <option value=""><?php _e( '-- None --', 'hoplytics' ); ?></option>
        <?php foreach ( $services as $service ) : ?>
            <option value="<?php echo esc_attr( $service->ID ); ?>" <?php selected( $selected, $service->ID ); ?>>
                <?php echo esc_html( $service->post_title ); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
}

/**
 * Save Meta Data
 */
function hoplytics_save_meta( $post_id ) {
    if ( ! isset( $_POST['hoplytics_meta_nonce'] ) || ! wp_verify_nonce( $_POST['hoplytics_meta_nonce'], 'hoplytics_save_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['related_service_id'] ) ) {
        update_post_meta( $post_id, '_related_service_id', absint( wp_unslash( $_POST['related_service_id'] ) ) );
    }
}
add_action( 'save_post', 'hoplytics_save_meta' );

/**
 * Exclude CPTs from Main Blog Query
 */
function hoplytics_exclude_cpts_from_blog( $query ) {
    if ( ! is_admin() && $query->is_home() && $query->is_main_query() ) {
        $query->set( 'post_type', 'post' );
    }
}
add_action( 'pre_get_posts', 'hoplytics_exclude_cpts_from_blog' );
