<?php
/**
 * SEO & Schema Markup
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined( 'ABSPATH' ) || exit;

/**
 * Output JSON-LD Schema in <head>
 */
function hoplytics_json_ld() {
    $schema = array();

    // Global Organization Schema (on all pages, or specifically Home)
    if ( is_front_page() ) {
        $schema[] = array(
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => get_bloginfo( 'name' ),
            'url'      => home_url(),
            'logo'     => hoplytics_get_local_logo_url(),
            'description' => get_bloginfo( 'description' ),
            'contactPoint' => array(
                '@type' => 'ContactPoint',
                'telephone' => '+1-555-123-4567',
                'contactType' => 'sales'
            )
        );
    }

    // LocalBusiness Schema (Home or Contact)
    if ( is_front_page() || is_page('contact') ) {
        $schema[] = array(
            '@context' => 'https://schema.org',
            '@type'    => 'LocalBusiness',
            'name'     => get_bloginfo( 'name' ),
            'image'    => hoplytics_get_local_logo_url(),
            '@id'      => home_url() . '#localbusiness',
            'url'      => home_url(),
            'telephone' => '+1-555-123-4567',
            'address'  => array(
                '@type' => 'PostalAddress',
                'streetAddress' => '123 Growth St',
                'addressLocality' => 'New York',
                'addressRegion' => 'NY',
                'postalCode' => '10001',
                'addressCountry' => 'US'
            ),
            'openingHoursSpecification' => array(
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'),
                'opens' => '09:00',
                'closes' => '17:00'
            )
        );
    }

    // Service Schema (Single Service)
    if ( is_singular( 'service' ) ) {
        $schema[] = array(
            '@context' => 'https://schema.org',
            '@type'    => 'Service',
            'name'     => get_the_title(),
            'provider' => array(
                '@type' => 'Organization',
                'name'  => get_bloginfo( 'name' )
            ),
            'description' => get_the_excerpt(),
            'areaServed' => 'Worldwide',
            'url' => get_permalink()
        );
    }

    // Case Study / Article Schema (Single Project)
    if ( is_singular( 'project' ) ) {
        $schema[] = array(
            '@context' => 'https://schema.org',
            '@type'    => 'Article',
            'headline' => get_the_title(),
            'image'    => has_post_thumbnail() ? get_the_post_thumbnail_url() : '',
            'author'   => array(
                '@type' => 'Organization',
                'name'  => get_bloginfo( 'name' )
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name'  => get_bloginfo( 'name' ),
                'logo'  => array(
                    '@type' => 'ImageObject',
                    'url'   => hoplytics_get_local_logo_url()
                )
            ),
            'datePublished' => get_the_date( 'c' ),
            'description' => get_the_excerpt()
        );
    }

    // JobPosting Schema (Single Career)
    if ( is_singular( 'career' ) ) {
        $location = get_post_meta( get_the_ID(), 'location', true ) ?: 'Remote';
        $job_type = get_post_meta( get_the_ID(), 'job_type', true ) ?: 'FULL_TIME'; // Schema standard format

        $schema[] = array(
            '@context' => 'https://schema.org',
            '@type'    => 'JobPosting',
            'title'    => get_the_title(),
            'description' => get_the_content(),
            'datePosted' => get_the_date( 'c' ),
            'validThrough' => date('c', strtotime('+30 days')), // Example
            'employmentType' => $job_type,
            'hiringOrganization' => array(
                '@type' => 'Organization',
                'name'  => get_bloginfo( 'name' ),
                'sameAs' => home_url(),
                'logo'  => hoplytics_get_local_logo_url()
            ),
            'jobLocation' => array(
                '@type' => 'Place',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => $location,
                    'addressCountry' => 'US' // Defaulting
                )
            )
        );
    }

    // ItemList Schema for Archives (Projects/Services)
    if ( is_post_type_archive('project') || is_post_type_archive('service') ) {
        global $wp_query;
        $items = array();

        if ( ! empty( $wp_query->posts ) ) {
            foreach ( $wp_query->posts as $index => $post_item ) {
                $items[] = array(
                    '@type'    => 'ListItem',
                    'position' => $index + 1,
                    'url'      => get_permalink( $post_item )
                );
            }
        }

        if ( ! empty( $items ) ) {
            $schema[] = array(
                '@context'        => 'https://schema.org',
                '@type'           => 'ItemList',
                'itemListElement' => $items
            );
        }
    }

    // Output
    if ( ! empty( $schema ) ) {
        foreach ( $schema as $s ) {
            echo '<script type="application/ld+json">' . wp_json_encode( $s, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
        }
    }
}
add_action( 'wp_head', 'hoplytics_json_ld' );
