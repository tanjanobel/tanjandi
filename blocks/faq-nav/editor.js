( function ( blocks, element ) {
    var el = element.createElement;

    blocks.registerBlockType( 'tanjandi/faq-nav', {
        title: 'FAQ Navigation',
        icon: 'list-view',
        category: 'theme',
        edit: function () {
            return el( 'div', { className: 'side-nav' }, 'Navigation: FAQ-Gruppen dieser Seite' );
        },
        save: function () {
            return null; // Rendered via PHP
        },
    } );
} )( window.wp.blocks, window.wp.element );
