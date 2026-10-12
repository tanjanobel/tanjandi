( function ( blocks, element ) {
    var el = element.createElement;

    blocks.registerBlockType( 'tanjandi/cart-link', {
        title: 'Cart Link',
        icon: 'cart',
        category: 'theme',
        edit: function () {
            return el(
                'span',
                { className: 'header__actions' },
                'Konto · Warenkorb'
            );
        },
        save: function () {
            return null; // Rendered via PHP
        },
    } );
} )( window.wp.blocks, window.wp.element );
