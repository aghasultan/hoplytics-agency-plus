<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Agency_Plus
 */

get_header();
?>

    <div class="container">
        <div class="inner-wrapper">

            <div id="primary" class="content-area w-full">
                <main id="main" class="site-main">

                    <section class="error-404 not-found">
                        <header class="page-header">
                            <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'agency-plus' ); ?></h1>
                        </header><!-- .page-header -->

                        <div class="page-content error-404-content">
                            <p class="error-404-text"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links from the menu or return to the homepage.', 'agency-plus' ); ?></p>

                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">Go Back Home</a>
                        </div><!-- .page-content -->
                    </section><!-- .error-404 -->

                </main><!-- #main -->
            </div><!-- #primary -->

        </div>
    </div>

<?php
get_footer();
