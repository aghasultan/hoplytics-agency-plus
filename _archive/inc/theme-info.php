<?php
declare(strict_types=1);

//add admin page
add_action( 'admin_menu', 'hoplytics_admin_menu' );

function hoplytics_admin_menu() {
	add_theme_page( 
        __( 'About Hoplytics', 'hoplytics' ),
        __( 'About Hoplytics', 'hoplytics' ),
        'edit_theme_options',
        'about-hoplytics',
        'hoplytics_theme_info_page'
    );

}

function hoplytics_theme_info_page(){

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'hoplytics' ) );
	}

	$theme_info = wp_get_theme(); ?>

	<div class="wrap about-wrap theme-info-wrap">
		<h1>
			<?php 
			/* translators: 1: Theme Name 2: Version of the theme */
			echo sprintf( esc_html__( 'Welcome to %1$s - %2$s', 'hoplytics' ), esc_html( $theme_info->get( 'Name' ) ), esc_html( $theme_info->get( 'Version' ) ) );
			?>
		</h1>

		<div class="about-text">
			<?php echo esc_html( $theme_info->get( 'Description' ) ); ?>
		</div>

		<p>
			<a href="https://hoplytics.com/" class="button" target="_blank"><?php echo esc_html__( ' View Demo', 'hoplytics' ); ?></a>
			<a href="https://hoplytics.com/" class="button button-primary" target="_blank"><?php echo esc_html__( 'Contact Support', 'hoplytics' ); ?></a>

		</p>

		<div class="feature-section has-2-columns alignleft">
			<div class="card">
				<h3><?php echo esc_html__( 'Customize Everything', 'hoplytics' ); ?></h3>
				<p><?php echo esc_html__( 'Start customizing every aspect of the website with customizer.', 'hoplytics' ); ?></p>
				<p><a target="_self" href="<?php echo esc_url( wp_customize_url() ); ?>" class="button button-primary"><?php echo esc_html__( 'Go to Customizer', 'hoplytics' ); ?></a></p>
			</div>

			<div class="card">
				<h3><?php echo esc_html__( 'Get Support', 'hoplytics' ); ?></h3>
				<p><?php echo esc_html__( 'Have any queries, feedback or suggestions?', 'hoplytics' ); ?></p>
			</div>

		</div>

	</div>
	<?php
}
