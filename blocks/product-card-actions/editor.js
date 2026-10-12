( function ( blocks, element ) {
    var el = element.createElement;

    blocks.registerBlockType( 'tanjandi/product-card-actions', {
        title: 'Product Card Actions',
        icon: 'cart',
        category: 'theme',
        edit: function () {
            return el( 'span', { className: 'product-card__actions' }, 'Farben · In den Warenkorb' );
        },
        save: function () {
            return null; // Rendered via PHP
        },
    } );
} )( window.wp.blocks, window.wp.element );
