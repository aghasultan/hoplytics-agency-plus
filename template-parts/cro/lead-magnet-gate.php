<?php
defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
    $args,
    array(
        'title'       => __( 'Download Our Playbook', 'hoplytics' ),
        'file_url'    => '#',
        'button_text' => __( 'Download PDF', 'hoplytics' ),
    )
);
?>
<div class="lead-magnet-gate card bg-primary text-white text-center p-8">
    <div class="icon-box mx-auto mb-4 bg-accent text-white rounded-full w-16 h-16 flex items-center justify-center" aria-hidden="true">
        <span class="dashicons dashicons-download" style="font-size: 2rem; width: auto; height: auto;"></span>
    </div>
    <h3 class="text-white mb-2"><?php echo esc_html( $args['title'] ); ?></h3>
    <p class="mb-4 text-gray-300"><?php esc_html_e( 'Unlock the full strategy we use to scale clients to $1M+ ARR.', 'hoplytics' ); ?></p>

    <form class="flex flex-col gap-2 max-w-xs mx-auto">
        <label class="screen-reader-text" for="lead-magnet-email"><?php esc_html_e( 'Business Email', 'hoplytics' ); ?></label>
        <input id="lead-magnet-email" type="email" placeholder="<?php echo esc_attr__( 'Business Email', 'hoplytics' ); ?>" class="text-black border-0" required>
        <button class="btn btn-accent w-100" type="submit"><?php echo esc_html( $args['button_text'] ); ?></button>
    </form>
</div>
