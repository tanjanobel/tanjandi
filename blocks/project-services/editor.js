( function ( blocks, element ) {
    var el = element.createElement;

    blocks.registerBlockType( 'tanjandi/project-services', {
        title: 'Project Services',
        icon: 'category',
        category: 'theme',
        edit: function ( props ) {
            return el(
                'div',
                { className: props.className },
                el( 'div', { style: { border: '1px dashed #ccc', padding: '20px', textAlign: 'center' } }, 'Project Services (Preview)' )
            );
        },
        save: function () {
            return null; // Rendered via PHP
        },
    } );
} )( window.wp.blocks, window.wp.element );
