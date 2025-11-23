<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="social-proof-bar section bg-alt">
    <div class="container">
        <p class="text-center text-sm uppercase tracking-wide text-muted mb-4"><?php echo esc_html( get_theme_mod( 'trusted_by_title', 'Trusted by High-Growth Companies' ) ); ?></p>
        <div class="flex flex-wrap justify-center gap-8 items-center opacity-50">
            <?php
            $has_logos = false;
            for ( $i = 1; $i <= 5; $i++ ) {
                $logo_id = get_theme_mod( "trusted_by_logo_$i" );
                if ( $logo_id ) {
                    $has_logos = true;
                    echo wp_get_attachment_image( $logo_id, 'full', false, array( 'class' => 'trusted-logo', 'style' => 'max-height: 40px; width: auto;' ) );
                }
            }

            if ( ! $has_logos ) {
                // Default placeholders if no logos uploaded
                ?>
                <span class="text-xl font-bold">ACME Corp</span>
                <span class="text-xl font-bold">GlobalTech</span>
                <span class="text-xl font-bold">Nebula.io</span>
                <span class="text-xl font-bold">FoxRun</span>
                <span class="text-xl font-bold">Vertex</span>
                <?php
            }
            ?>
        </div>
    </div>
</div>
