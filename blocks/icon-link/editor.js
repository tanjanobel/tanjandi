( function ( blocks, element, blockEditor, components ) {
    var el = element.createElement;
    var useState = element.useState;
    var useEffect = element.useEffect;
    var RichText = blockEditor.RichText;
    var InspectorControls = blockEditor.InspectorControls;
    var URLInput = blockEditor.URLInput;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var SelectControl = components.SelectControl;
    var ColorPalette = components.ColorPalette;
    var Popover = components.Popover;
    var Button = components.Button;
    var SearchControl = components.SearchControl;

    var SPRITE_URL = '/wp-content/themes/tanjandi/static/icons/symbol/icon-sprite.svg';
    var ICON_LIST_URL = '/wp-content/themes/tanjandi/static/icons/icon-list.json';

    // Fetched once per editor session and shared across every block
    // instance, instead of once per instance - there can be many of these
    // blocks on a page (e.g. the "Was wir erreicht haben" icons).
    var iconListPromise = null;
    function getIconList() {
        if ( ! iconListPromise ) {
            iconListPromise = window.fetch( ICON_LIST_URL )
                .then( function ( response ) { return response.json(); } )
                .catch( function () { return []; } );
        }
        return iconListPromise;
    }

    function IconPreview( props ) {
        var size = props.size || 20;
        return el( 'svg', {
            viewBox: '0 0 256 256',
            width: size,
            height: size,
            style: { flexShrink: 0 }
        },
            el( 'use', { xlinkHref: SPRITE_URL + '#' + props.symbol } )
        );
    }

    function IconPicker( props ) {
        var value = props.value;
        var onChange = props.onChange;
        var pickerState = useState( false );
        var isOpen = pickerState[ 0 ];
        var setIsOpen = pickerState[ 1 ];
        var searchState = useState( '' );
        var search = searchState[ 0 ];
        var setSearch = searchState[ 1 ];
        var listState = useState( [] );
        var iconList = listState[ 0 ];
        var setIconList = listState[ 1 ];

        useEffect( function () {
            getIconList().then( setIconList );
        }, [] );

        var term = search.trim().toLowerCase();
        var filtered = term
            ? iconList.filter( function ( name ) { return name.indexOf( term ) !== -1; } )
            : iconList;
        var visible = filtered.slice( 0, 240 );

        return el( 'div', { className: 'tanjandi-icon-picker' },
            el( 'p', { style: { marginBottom: '4px' } }, 'Icon' ),
            el( Button, {
                variant: 'secondary',
                onClick: function () { setIsOpen( true ); },
                style: {
                    display: 'flex',
                    alignItems: 'center',
                    gap: '8px',
                    width: '100%',
                    justifyContent: 'flex-start'
                }
            },
                value ? el( IconPreview, { symbol: value, size: 20 } ) : null,
                el( 'span', null, value || 'Icon wählen…' )
            ),
            isOpen && el( Popover, {
                onClose: function () { setIsOpen( false ); },
                position: 'bottom left',
                className: 'tanjandi-icon-picker__popover'
            },
                el( 'div', { style: { width: '320px', padding: '12px' } },
                    el( SearchControl, {
                        value: search,
                        onChange: setSearch,
                        placeholder: 'Icon suchen… (' + iconList.length + ' verfügbar)',
                        __nextHasNoMarginBottom: true
                    } ),
                    el( 'div', {
                        style: {
                            display: 'grid',
                            gridTemplateColumns: 'repeat(6, 1fr)',
                            gap: '4px',
                            maxHeight: '280px',
                            overflowY: 'auto',
                            marginTop: '10px'
                        }
                    },
                        visible.map( function ( name ) {
                            return el( Button, {
                                key: name,
                                label: name,
                                showTooltip: true,
                                isPressed: name === value,
                                onClick: function () {
                                    onChange( name );
                                    setIsOpen( false );
                                },
                                style: {
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    padding: '8px',
                                    height: '36px'
                                }
                            }, el( IconPreview, { symbol: name, size: 18 } ) );
                        } )
                    ),
                    filtered.length > visible.length && el( 'p', {
                        style: { fontSize: '11px', color: '#757575', marginTop: '8px', marginBottom: 0 }
                    }, filtered.length - visible.length + ' weitere - enger suchen, um sie zu sehen.' )
                )
            )
        );
    }

    blocks.registerBlockType( 'tanjandi/icon-link', {
        title: 'Icon Link',
        icon: 'format-image',
        category: 'theme',
        edit: function ( props ) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            // Farben aus Theme (vereinfacht aus theme.json bekannt)
            var colors = [
                { name: 'Primärfarbe', slug: 'primary', color: '#0a3e5c' },
                { name: 'Sekundärfarbe', slug: 'secondary', color: '#017abb' },
                { name: 'Tertiärfarbe', slug: 'tertiary', color: '#57b7ef' },
                { name: 'Hellgrau', slug: 'light-gray', color: '#f6f8fb' },
                { name: 'Hellblau', slug: 'light-blue', color: '#e6edf3' },
                { name: 'Schwarz', slug: 'black', color: '#000000' },
                { name: 'Weiss', slug: 'white', color: '#fcfcfd' },
                { name: 'Text Sekundär', slug: 'text-secondary', color: '#4f6f82' }
            ];

            return [
                el( InspectorControls, { key: 'inspector' },
                    el( PanelBody, { title: 'Icon Einstellungen', initialOpen: true },
                        el( IconPicker, {
                            value: attributes.icon_symbol,
                            onChange: function ( value ) {
                                setAttributes( { icon_symbol: value } );
                            }
                        } ),
                        el( TextControl, {
                            label: 'Breite Desktop (px)',
                            value: attributes.icon_width,
                            onChange: function ( value ) {
                                setAttributes( { icon_width: value } );
                            }
                        } ),
                        el( TextControl, {
                            label: 'Breite Mobile (px)',
                            value: attributes.icon_width_mobile,
                            onChange: function ( value ) {
                                setAttributes( { icon_width_mobile: value } );
                            }
                        } ),
                        el( 'p', null, 'Icon/Text Farbe' ),
                        el( ColorPalette, {
                            colors: colors,
                            value: colors.find( function( c ) { return c.slug === attributes.icon_color.slug; } )?.color,
                            onChange: function ( colorValue ) {
                                var color = colors.find( function( c ) { return c.color === colorValue; } );
                                if ( color ) {
                                    setAttributes( { icon_color: { slug: color.slug } } );
                                }
                            }
                        } )
                    ),
                    el( PanelBody, { title: 'Link Einstellungen', initialOpen: false },
                        el( 'div', { className: 'wp-block-tanjandi-icon-link-url-input' },
                            el( 'label', null, 'URL' ),
                            el( URLInput, {
                                value: attributes.icon_link,
                                onChange: function ( value ) {
                                    setAttributes( { icon_link: value } );
                                }
                            } )
                        ),
                        el( SelectControl, {
                            label: 'Link Ziel',
                            value: attributes.icon_target,
                            options: [
                                { label: 'Gleiches Fenster', value: '_self' },
                                { label: 'Neues Fenster', value: '_blank' }
                            ],
                            onChange: function ( value ) {
                                setAttributes( { icon_target: value } );
                            }
                        } ),
                        el( TextControl, {
                            label: 'Link Titel (Title-Attribut)',
                            value: attributes.icon_title,
                            onChange: function ( value ) {
                                setAttributes( { icon_title: value } );
                            }
                        } ),
                        el( TextControl, {
                            label: 'Zusätzliche CSS-Klassen (Wrapper)',
                            value: attributes.icon_class,
                            onChange: function ( value ) {
                                setAttributes( { icon_class: value } );
                            }
                        } )
                    )
                ),
                el( 'div', { className: 'icon-button ' + attributes.icon_class },
                    el( 'div', { className: 'icon-button__preview' },
                        el( 'div', {
                            className: 'icon-button__icon-mock',
                            style: {
                                width: attributes.icon_width + 'px',
                                height: attributes.icon_width + 'px',
                                display: 'flex',
                                alignItems: 'center',
                                justifyContent: 'center',
                                flexShrink: 0
                            }
                        }, attributes.icon_symbol
                            ? el( IconPreview, { symbol: attributes.icon_symbol, size: parseInt( attributes.icon_width, 10 ) || 20 } )
                            : null ),
                        // The placeholder text is only shown while the block is
                        // selected (or already has text) - left permanently on,
                        // its empty-state overlay sits on top of the icon and
                        // hides it, which is especially bad in icon-only
                        // contexts like the project-advantage badges.
                        ( attributes.icon_text || props.isSelected ) && el( RichText, {
                            tagName: 'span',
                            className: 'icon-button__text ' + attributes.icon_color.slug,
                            value: attributes.icon_text,
                            onChange: function ( value ) {
                                setAttributes( { icon_text: value } );
                            },
                            placeholder: 'Text (optional)…',
                            style: {
                                color: colors.find( function( c ) { return c.slug === attributes.icon_color.slug; } )?.color || 'inherit'
                            }
                        } )
                    )
                )
            ];
        },
        save: function () {
            return null; // Dynamisches Rendering via PHP
        },
    } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components );
