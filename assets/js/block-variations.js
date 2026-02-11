/**
 * Block Variations — pre-configured block combos for common agency patterns.
 *
 * These appear alongside the original block in the inserter,
 * pre-filled with the right attributes and inner blocks.
 */

wp.domReady(() => {

    // --- Service Card ---
    wp.blocks.registerBlockVariation('core/group', {
        name: 'hoplytics-service-card',
        title: 'Service Card',
        description: 'A card with icon, heading, and description for a service offering.',
        category: 'hoplytics',
        icon: 'admin-tools',
        scope: ['inserter', 'block'],
        attributes: {
            className: 'is-style-card service-card',
        },
        innerBlocks: [
            ['core/paragraph', { content: '🚀', className: 'service-icon text-4xl' }],
            ['core/heading', { level: 3, content: 'Service Name', placeholder: 'Service Name' }],
            ['core/paragraph', { content: 'Brief description of what this service delivers and why it matters.', className: 'text-muted' }],
            ['core/buttons', {}, [
                ['core/button', { text: 'Learn More', className: 'is-style-pill' }],
            ]],
        ],
    });

    // --- Team Member ---
    wp.blocks.registerBlockVariation('core/group', {
        name: 'hoplytics-team-member',
        title: 'Team Member',
        description: 'Profile card with photo, name, role, and bio.',
        category: 'hoplytics',
        icon: 'admin-users',
        scope: ['inserter', 'block'],
        attributes: {
            className: 'is-style-card team-member text-center',
        },
        innerBlocks: [
            ['core/image', { className: 'is-style-rounded-shadow', sizeSlug: 'thumbnail' }],
            ['core/heading', { level: 3, content: 'Team Member', placeholder: 'Full Name' }],
            ['core/paragraph', { content: 'Role / Title', className: 'text-accent font-medium text-sm' }],
            ['core/paragraph', { content: 'Short bio about this team member and their expertise.', className: 'text-muted text-sm' }],
        ],
    });

    // --- Stat Card ---
    wp.blocks.registerBlockVariation('core/group', {
        name: 'hoplytics-stat-card',
        title: 'Stat Card',
        description: 'Large number + label for showcasing KPIs and metrics.',
        category: 'hoplytics',
        icon: 'chart-bar',
        scope: ['inserter', 'block'],
        attributes: {
            className: 'is-style-glass stat-card text-center',
        },
        innerBlocks: [
            ['core/heading', { level: 2, content: '140+', className: 'text-4xl text-accent', placeholder: '0' }],
            ['core/paragraph', { content: 'Clients Served', className: 'text-muted text-sm uppercase tracking-widest' }],
        ],
    });

    // --- Testimonial Card ---
    wp.blocks.registerBlockVariation('core/quote', {
        name: 'hoplytics-testimonial',
        title: 'Testimonial',
        description: 'Client testimonial with avatar, quote, and attribution.',
        category: 'hoplytics',
        icon: 'format-quote',
        scope: ['inserter', 'block'],
        attributes: {
            className: 'is-style-testimonial',
        },
    });

    // --- CTA Section ---
    wp.blocks.registerBlockVariation('core/cover', {
        name: 'hoplytics-cta-section',
        title: 'CTA Section',
        description: 'Full-width call-to-action banner with heading and buttons.',
        category: 'hoplytics',
        icon: 'megaphone',
        scope: ['inserter', 'block'],
        attributes: {
            className: 'is-style-cta-banner',
            dimRatio: 80,
        },
        innerBlocks: [
            ['core/heading', { level: 2, content: 'Ready to Scale?', textAlign: 'center' }],
            ['core/paragraph', { content: 'Book your free strategy session today.', align: 'center', className: 'text-lg' }],
            ['core/buttons', { layout: { type: 'flex', justifyContent: 'center' } }, [
                ['core/button', { text: 'Get Started', className: 'is-style-glow' }],
                ['core/button', { text: 'Learn More', className: 'is-style-outline' }],
            ]],
        ],
    });

    // --- Feature Grid ---
    wp.blocks.registerBlockVariation('core/columns', {
        name: 'hoplytics-feature-grid',
        title: 'Feature Grid',
        description: 'Three-column grid of feature/benefit cards.',
        category: 'hoplytics',
        icon: 'grid-view',
        scope: ['inserter'],
        attributes: {
            className: 'is-style-card-grid',
        },
        innerBlocks: [
            ['core/column', {}, [
                ['core/paragraph', { content: '⚡', className: 'text-4xl' }],
                ['core/heading', { level: 3, content: 'Feature One' }],
                ['core/paragraph', { content: 'Description of this feature.', className: 'text-muted' }],
            ]],
            ['core/column', {}, [
                ['core/paragraph', { content: '🎯', className: 'text-4xl' }],
                ['core/heading', { level: 3, content: 'Feature Two' }],
                ['core/paragraph', { content: 'Description of this feature.', className: 'text-muted' }],
            ]],
            ['core/column', {}, [
                ['core/paragraph', { content: '📈', className: 'text-4xl' }],
                ['core/heading', { level: 3, content: 'Feature Three' }],
                ['core/paragraph', { content: 'Description of this feature.', className: 'text-muted' }],
            ]],
        ],
    });

});
