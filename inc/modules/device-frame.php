<?php
/**
 * Module: Device Frames
 *
 * Provides a shortcode to wrap images in CSS-based device mockups.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined( 'ABSPATH' ) || exit;

/**
 * Shortcode: [device_frame id="123" type="laptop|mobile"]
 */
function hoplytics_device_frame_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'id'   => '',
        'type' => 'laptop', // 'laptop' or 'mobile'
    ), $atts, 'device_frame' );

    if ( empty( $atts['id'] ) ) {
        return '';
    }

    $image_html = wp_get_attachment_image( (int) $atts['id'], 'large', false, array( 'class' => 'device-screen-img' ) );

    if ( ! $image_html ) {
        return '';
    }

    $wrapper_class = 'device-frame device-' . esc_attr( $atts['type'] );

    ob_start();
    ?>
    <div class="<?php echo esc_attr( $wrapper_class ); ?>">
        <div class="device-bezel">
            <div class="device-screen">
                <?php echo $image_html; ?>
            </div>
        </div>
        <?php if ( 'laptop' === $atts['type'] ) : ?>
            <div class="device-base"></div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'device_frame', 'hoplytics_device_frame_shortcode' );

/**
 * Enqueue styles for device frames
 */
function hoplytics_enqueue_device_styles() {
    // Inline CSS for device frames to avoid another http request for a small module
    $css = "
    .device-frame {
        position: relative;
        margin: 2rem auto;
        box-sizing: border-box;
    }

    /* Laptop Styles */
    .device-laptop {
        max-width: 800px;
    }
    .device-laptop .device-bezel {
        background: #1f2937;
        padding: 3%; /* Bezel width */
        border-radius: 12px 12px 0 0;
        position: relative;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }
    .device-laptop .device-screen {
        background: #000;
        overflow: hidden;
        position: relative;
    }
    .device-laptop .device-base {
        background: #374151;
        height: 20px;
        width: 120%;
        margin-left: -10%;
        border-radius: 0 0 12px 12px;
        position: relative;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    .device-laptop .device-base::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 15%;
        height: 6px;
        background: #4b5563;
        border-radius: 0 0 6px 6px;
    }

    /* Mobile Styles */
    .device-mobile {
        max-width: 300px;
    }
    .device-mobile .device-bezel {
        background: #1f2937;
        padding: 12px;
        border-radius: 36px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        border: 4px solid #374151;
    }
    .device-mobile .device-screen {
        background: #000;
        border-radius: 24px;
        overflow: hidden;
    }

    .device-screen-img {
        width: 100%;
        height: auto;
        display: block;
    }
    ";
    wp_add_inline_style( 'hoplytics-style', $css );
}
add_action( 'wp_enqueue_scripts', 'hoplytics_enqueue_device_styles' );
