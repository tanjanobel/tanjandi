( function ( blocks, element ) {
    var el = element.createElement;

    blocks.registerBlockType( 'tanjandi/product-filter', {
        title: 'Product Filter',
        icon: 'filter',
        category: 'theme',
        edit: function () {
            return el( 'span', { className: 'product-filter' }, 'Alle · Kategorien' );
        },
        save: function () {
            return null; // Rendered via PHP
        },
    } );
} )( window.wp.blocks, window.wp.element );
