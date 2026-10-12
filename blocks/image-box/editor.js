( function ( blocks, element, blockEditor, components ) {
    var el = element.createElement;
    var RichText = blockEditor.RichText;
    var InspectorControls = blockEditor.InspectorControls;
    var MediaUpload = blockEditor.MediaUpload;
    var PanelBody = components.PanelBody;
    var Button = components.Button;
    var FocalPointPicker = components.FocalPointPicker;

    function imageField( props ) {
        var label = props.label;
        var attributeName = props.attributeName;
        var focalAttributeName = props.focalAttributeName;
        var attributes = props.attributes;
        var setAttributes = props.setAttributes;
        var image = attributes[ attributeName ];
        var focalPoint = attributes[ focalAttributeName ] || { x: 0.5, y: 0.5 };

        var onSelect = function ( media ) {
            var next = {};
            next[ attributeName ] = { url: media.url, id: media.id, alt: media.alt || '' };
            setAttributes( next );
        };

        var onRemove = function () {
            var next = {};
            next[ attributeName ] = null;
            setAttributes( next );
        };

        var onChangeFocalPoint = function ( value ) {
            var next = {};
            next[ focalAttributeName ] = value;
            setAttributes( next );
        };

        return el( 'div', { style: { marginBottom: '20px' } },
            el( 'label', { style: { display: 'block', marginBottom: '10px', fontWeight: 'bold' } }, label ),
            image && image.url ? el( FocalPointPicker, {
                url: image.url,
                value: focalPoint,
                onChange: onChangeFocalPoint,
                style: { marginBottom: '10px' }
            } ) : null,
            el( MediaUpload, {
                onSelect: onSelect,
                allowedTypes: [ 'image' ],
                value: image ? image.id : null,
                render: function ( obj ) {
                    return el( Button, {
                        variant: 'secondary',
                        className: 'button-large',
                        onClick: obj.open,
                        style: { width: '100%', justifyContent: 'center' }
                    },
                    ! image || ! image.url ? 'Bild auswählen' : 'Bild ändern'
                    );
                }
            } ),
            image && image.url && el( Button, {
                isDestructive: true,
                variant: 'link',
                onClick: onRemove,
                style: { marginTop: '10px', padding: '0' }
            }, 'Bild entfernen' )
        );
    }

    blocks.registerBlockType( 'tanjandi/image-box', {
        title: 'Bild-Box',
        icon: 'format-image',
        category: 'theme',
        edit: function ( props ) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var desktopImage = attributes.image_box_image_desktop;
            var previewImage = desktopImage || attributes.image_box_image_mobile;
            var previewFocalPoint = desktopImage
                ? attributes.image_box_focal_point_desktop
                : attributes.image_box_focal_point_mobile;
            previewFocalPoint = previewFocalPoint || { x: 0.5, y: 0.5 };

            return el(
                'div',
                { className: props.className },
                el( InspectorControls, { key: 'inspector' },
                    el( PanelBody, { title: 'Bilder', initialOpen: true },
                        imageField( {
                            label: 'Bild Desktop/Tablet',
                            attributeName: 'image_box_image_desktop',
                            focalAttributeName: 'image_box_focal_point_desktop',
                            attributes: attributes,
                            setAttributes: setAttributes
                        } ),
                        imageField( {
                            label: 'Bild Mobile',
                            attributeName: 'image_box_image_mobile',
                            focalAttributeName: 'image_box_focal_point_mobile',
                            attributes: attributes,
                            setAttributes: setAttributes
                        } ),
                        el( 'p', { style: { fontSize: '12px', color: '#757575' } },
                            'Tipp: Beim Mobile-Bild darauf achten, dass dort, wo der Titel-Text liegt, genug ruhige Bildfläche für Lesbarkeit bleibt.'
                        )
                    )
                ),
                el( 'div', {
                    className: 'image-box',
                    style: previewImage ? {
                        backgroundImage: 'url(' + previewImage.url + ')',
                        backgroundSize: 'cover',
                        backgroundPosition: ( previewFocalPoint.x * 100 ) + '% ' + ( previewFocalPoint.y * 100 ) + '%'
                    } : null
                },
                    el( RichText, {
                        tagName: 'h2',
                        className: 'image-box__heading',
                        value: attributes.image_box_heading,
                        onChange: function ( value ) {
                            setAttributes( { image_box_heading: value } );
                        },
                        placeholder: 'Titeltext eingeben...'
                    } )
                )
            );
        },
        save: function () {
            return null; // Rendered via PHP
        },
    } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components );
