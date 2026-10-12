( function ( blocks, element, blockEditor, components ) {
    var el = element.createElement;
    var RichText = blockEditor.RichText;
    var InnerBlocks = blockEditor.InnerBlocks;
    var InspectorControls = blockEditor.InspectorControls;
    var MediaUpload = blockEditor.MediaUpload;
    var PanelBody = components.PanelBody;
    var Button = components.Button;
    var TextControl = components.TextControl;
    var SelectControl = components.SelectControl;

    blocks.registerBlockType( 'tanjandi/hero', {
        title: 'Hero',
        icon: 'superhero',
        category: 'theme',
        edit: function ( props ) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var onSelectImage = function ( media ) {
                setAttributes( { hero_bg_image: { url: media.url, id: media.id } } );
            };

            var onSelectVideo = function ( media ) {
                setAttributes( { hero_bg_video_url: { url: media.url, id: media.id } } );
            };

            var onSelectPoster = function ( media ) {
                setAttributes( { hero_bg_video_poster: { url: media.url, id: media.id } } );
            };

            return [
                el( InspectorControls, { key: 'inspector' },
                    el( PanelBody, { title: 'Einstellungen', initialOpen: true },
                        el( TextControl, {
                            label: 'Anker (ID)',
                            value: attributes.hero_anchor,
                            onChange: function ( value ) {
                                setAttributes( { hero_anchor: value } );
                            }
                        } ),
                        el( SelectControl, {
                            label: 'Hintergrundfarbe',
                            value: attributes.hero_bg_color,
                            options: [
                                { label: 'Weiß', value: 'white' },
                                { label: 'Primär', value: 'primary' },
                                { label: 'Sekundär', value: 'secondary' },
                                { label: 'Schwarz', value: 'black' }
                            ],
                            onChange: function ( value ) {
                                setAttributes( { hero_bg_color: value } );
                            }
                        } ),
                        el( 'div', { className: 'hero-bg-selection', style: { marginBottom: '20px' } },
                            el( 'label', { style: { display: 'block', marginBottom: '10px', fontWeight: 'bold' } }, 'Hintergrundbild' ),
                            attributes.hero_bg_image ? el( 'div', { style: { marginBottom: '10px' } },
                                el( 'img', { src: attributes.hero_bg_image.url, style: { maxWidth: '100%', borderRadius: '4px', display: 'block' } } )
                            ) : null,
                            el( MediaUpload, {
                                onSelect: onSelectImage,
                                allowedTypes: [ 'image' ],
                                value: attributes.hero_bg_image ? attributes.hero_bg_image.id : null,
                                render: function ( obj ) {
                                    return el( Button, {
                                        variant: 'secondary',
                                        className: 'button-large',
                                        onClick: obj.open,
                                        style: { width: '100%', justifyContent: 'center' }
                                    },
                                    ! attributes.hero_bg_image ? 'Bild auswählen' : 'Bild ändern'
                                    );
                                }
                            } ),
                            attributes.hero_bg_image && el( Button, {
                                isDestructive: true,
                                variant: 'link',
                                onClick: function() { setAttributes({ hero_bg_image: null }); },
                                style: { marginTop: '10px', padding: '0' }
                            }, 'Bild entfernen' )
                        ),
                        el( 'div', { className: 'hero-video-selection', style: { marginBottom: '20px' } },
                            el( 'label', { style: { display: 'block', marginBottom: '10px', fontWeight: 'bold' } }, 'Hintergrundvideo' ),
                            attributes.hero_bg_video_url && attributes.hero_bg_video_url.url ? el( 'div', { style: { marginBottom: '10px' } },
                                el( 'video', { src: attributes.hero_bg_video_url.url, style: { maxWidth: '100%', borderRadius: '4px', display: 'block' }, muted: true } )
                            ) : null,
                            el( MediaUpload, {
                                onSelect: onSelectVideo,
                                allowedTypes: [ 'video' ],
                                value: attributes.hero_bg_video_url ? attributes.hero_bg_video_url.id : null,
                                render: function ( obj ) {
                                    return el( Button, {
                                        variant: 'secondary',
                                        className: 'button-large',
                                        onClick: obj.open,
                                        style: { width: '100%', justifyContent: 'center' }
                                    },
                                    ! attributes.hero_bg_video_url || ! attributes.hero_bg_video_url.url ? 'Video auswählen' : 'Video ändern'
                                    );
                                }
                            } ),
                            attributes.hero_bg_video_url && attributes.hero_bg_video_url.url && el( Button, {
                                isDestructive: true,
                                variant: 'link',
                                onClick: function() { setAttributes({ hero_bg_video_url: null }); },
                                style: { marginTop: '10px', padding: '0' }
                            }, 'Video entfernen' )
                        ),
                        el( 'div', { className: 'hero-video-poster-selection', style: { marginBottom: '20px' } },
                            el( 'label', { style: { display: 'block', marginBottom: '10px', fontWeight: 'bold' } }, 'Video Poster (Standbild)' ),
                            attributes.hero_bg_video_poster && attributes.hero_bg_video_poster.url ? el( 'div', { style: { marginBottom: '10px' } },
                                el( 'img', { src: attributes.hero_bg_video_poster.url, style: { maxWidth: '100%', borderRadius: '4px', display: 'block' } } )
                            ) : null,
                            el( MediaUpload, {
                                onSelect: onSelectPoster,
                                allowedTypes: [ 'image' ],
                                value: attributes.hero_bg_video_poster ? attributes.hero_bg_video_poster.id : null,
                                render: function ( obj ) {
                                    return el( Button, {
                                        variant: 'secondary',
                                        className: 'button-large',
                                        onClick: obj.open,
                                        style: { width: '100%', justifyContent: 'center' }
                                    },
                                    ! attributes.hero_bg_video_poster || ! attributes.hero_bg_video_poster.url ? 'Poster auswählen' : 'Poster ändern'
                                    );
                                }
                            } ),
                            attributes.hero_bg_video_poster && attributes.hero_bg_video_poster.url && el( Button, {
                                isDestructive: true,
                                variant: 'link',
                                onClick: function() { setAttributes({ hero_bg_video_poster: null }); },
                                style: { marginTop: '10px', padding: '0' }
                            }, 'Poster entfernen' )
                        )
                    )
                ),
                el( 'div', { className: 'hero bg-' + attributes.hero_bg_color + (props.className ? ' ' + props.className : '') },
                    attributes.hero_bg_video_url && attributes.hero_bg_video_url.url ? el( 'div', { className: 'hero__bg-wrapper' },
                        el( 'video', {
                            className: 'hero__video',
                            src: attributes.hero_bg_video_url.url,
                            poster: attributes.hero_bg_video_poster ? attributes.hero_bg_video_poster.url : null,
                            autoPlay: true,
                            muted: true,
                            loop: true
                        } )
                    ) : (attributes.hero_bg_image && el( 'div', { className: 'hero__bg-wrapper' },
                        el( 'div', {
                            className: 'hero__bg',
                            style: { backgroundImage: 'url(' + attributes.hero_bg_image.url + ')' }
                        } )
                    )),
                    el( 'div', { className: 'hero__content container large' },
                        el( 'div', { className: 'hero__body' },
                            el( RichText, {
                                tagName: 'p',
                                className: 'hero__intro',
                                value: attributes.hero_intro,
                                onChange: function ( value ) {
                                    setAttributes( { hero_intro: value } );
                                },
                                placeholder: 'Lead-Text eingeben...'
                            } ),
                            el( RichText, {
                                tagName: 'h1',
                                className: 'hero__heading',
                                value: attributes.hero_title,
                                onChange: function ( value ) {
                                    setAttributes( { hero_title: value } );
                                },
                                placeholder: 'Titel eingeben...'
                            } ),
                            el( InnerBlocks, {
                                allowedBlocks: [ 'core/paragraph', 'core/heading', 'core/list', 'tanjandi/button-pill', 'core/group' ],
                                template: [
                                    [ 'core/paragraph', { placeholder: 'Text eingeben...', className: 'hero__text' } ]
                                ]
                            } )
                        )
                    ),
                    el( 'div', { className: 'hero__cut-out' },
                        el( 'svg', { viewBox: '0 0 10 10', className: 'hero__corner hero__corner--top' },
                            el( 'path', { d: 'M 10,0 A 10,10,0,0,1,0,10 L 10,10' } )
                        ),
                        el( 'div', { className: 'hero__avatar' },
                            el( 'img', { src: '/wp-content/uploads/2026/03/avatar_tanja-nobel.webp' } ),
                            el( 'img', { src: '/wp-content/uploads/2026/03/avatar_philipp-nobel.webp' } )
                        ),
                        el( 'div', { className: 'hero__contact' },
                            el( 'h3', null, 'Persönlich & direkt' ),
                            el( 'p', null, 'Ihre Ansprechpartner für Ihr Projekt.' )
                        ),
                        el( 'svg', { viewBox: '0 0 10 10', className: 'hero__corner hero__corner--bottom' },
                            el( 'path', { d: 'M 10,0 A 10,10,0,0,1,0,10 L 10,10' } )
                        )
                    )
                )
            ];
        },
        save: function ( props ) {
            return el( InnerBlocks.Content );
        },
    } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components );
