( function ( blocks, element ) {
    var el = element.createElement;

    blocks.registerBlockType( 'tanjandi/product-teaser', {
        title: 'Product Teaser',
        icon: 'products',
        category: 'theme',
        edit: function () {
            return el( 'div', { className: 'product-teaser' }, 'Im Shop · Produkt' );
        },
        save: function () {
            return null; // Rendered via PHP
        },
    } );
} )( window.wp.blocks, window.wp.element );
