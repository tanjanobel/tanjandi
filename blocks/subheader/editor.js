( function ( blocks, element ) {
    var el = element.createElement;

    blocks.registerBlockType( 'tanjandi/subheader', {
        title: 'Subheader',
        icon: 'heading',
        category: 'theme',
        edit: function ( props ) {
            return el(
                'div',
                { className: props.className },
                el( 'div', { style: { border: '1px dashed #ccc', padding: '20px', textAlign: 'center' } }, 'Subheader (Preview)' )
            );
        },
        save: function () {
            return null; // Rendered via PHP
        },
    } );
} )( window.wp.blocks, window.wp.element );
