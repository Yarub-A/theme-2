( function ( wp ) {
    const { registerBlockType } = wp.blocks;
    const { __ } = wp.i18n;
    const { Fragment } = wp.element;
    const { InspectorControls, useBlockProps, URLInputButton } = wp.blockEditor;
    const { PanelBody, RangeControl, TextControl, Button, ButtonGroup } = wp.components;
    const ServerSideRender = wp.serverSideRender;

    registerBlockType( 'renita/news-grid', {
        edit: ( props ) => {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();
            const postsToShow = attributes.postsToShow || 6;

            return (
                <Fragment>
                    <InspectorControls>
                        <PanelBody title={ __( 'إعدادات الشبكة', 'renita' ) }>
                            <RangeControl
                                label={ __( 'عدد الأخبار المعروضة', 'renita' ) }
                                value={ postsToShow }
                                onChange={ ( value ) => setAttributes( { postsToShow: value } ) }
                                min={ 3 }
                                max={ 12 }
                            />
                        </PanelBody>
                    </InspectorControls>
                    <div { ...blockProps }>
                        <ServerSideRender block="renita/news-grid" attributes={ attributes } />
                    </div>
                </Fragment>
            );
        },
        save: () => null,
    } );

    registerBlockType( 'renita/stats-strip', {
        edit: ( props ) => {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();
            const items = attributes.items || [];

            const updateItem = ( index, field, value ) => {
                const nextItems = items.slice();
                nextItems[ index ] = { ...nextItems[ index ], [ field ]: value };
                setAttributes( { items: nextItems } );
            };

            const addItem = () => {
                setAttributes( { items: [ ...items, { value: '', label: '' } ] } );
            };

            const removeItem = ( index ) => {
                const nextItems = items.filter( ( _, i ) => i !== index );
                setAttributes( { items: nextItems } );
            };

            return (
                <Fragment>
                    <InspectorControls>
                        <PanelBody title={ __( 'العناصر', 'renita' ) }>
                            { items.map( ( item, index ) => (
                                <div className="renita-stat-control" key={ index }>
                                    <TextControl
                                        label={ __( 'القيمة', 'renita' ) }
                                        value={ item.value }
                                        onChange={ ( value ) => updateItem( index, 'value', value ) }
                                    />
                                    <TextControl
                                        label={ __( 'الوصف', 'renita' ) }
                                        value={ item.label }
                                        onChange={ ( value ) => updateItem( index, 'label', value ) }
                                    />
                                    <ButtonGroup>
                                        <Button variant="secondary" onClick={ () => removeItem( index ) }>
                                            { __( 'حذف', 'renita' ) }
                                        </Button>
                                    </ButtonGroup>
                                </div>
                            ) ) }
                            <Button variant="primary" onClick={ addItem }>
                                { __( 'إضافة عنصر', 'renita' ) }
                            </Button>
                        </PanelBody>
                    </InspectorControls>
                    <div { ...blockProps }>
                        <ServerSideRender block="renita/stats-strip" attributes={ attributes } />
                    </div>
                </Fragment>
            );
        },
        save: () => null,
    } );

    registerBlockType( 'renita/quick-links', {
        edit: ( props ) => {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();
            const links = attributes.links || [];

            const updateLink = ( index, field, value ) => {
                const nextLinks = links.slice();
                nextLinks[ index ] = { ...nextLinks[ index ], [ field ]: value };
                setAttributes( { links: nextLinks } );
            };

            const addLink = () => {
                setAttributes( { links: [ ...links, { title: '', url: '' } ] } );
            };

            const removeLink = ( index ) => {
                const nextLinks = links.filter( ( _, i ) => i !== index );
                setAttributes( { links: nextLinks } );
            };

            return (
                <Fragment>
                    <InspectorControls>
                        <PanelBody title={ __( 'الروابط', 'renita' ) }>
                            { links.map( ( link, index ) => (
                                <div className="renita-quick-link-control" key={ index }>
                                    <TextControl
                                        label={ __( 'العنوان', 'renita' ) }
                                        value={ link.title }
                                        onChange={ ( value ) => updateLink( index, 'title', value ) }
                                    />
                                    <URLInputButton
                                        label={ __( 'الرابط', 'renita' ) }
                                        url={ link.url }
                                        onChange={ ( value ) => updateLink( index, 'url', value ) }
                                    />
                                    <ButtonGroup>
                                        <Button variant="secondary" onClick={ () => removeLink( index ) }>
                                            { __( 'حذف', 'renita' ) }
                                        </Button>
                                    </ButtonGroup>
                                </div>
                            ) ) }
                            <Button variant="primary" onClick={ addLink }>
                                { __( 'إضافة رابط', 'renita' ) }
                            </Button>
                        </PanelBody>
                    </InspectorControls>
                    <div { ...blockProps }>
                        <ServerSideRender block="renita/quick-links" attributes={ attributes } />
                    </div>
                </Fragment>
            );
        },
        save: () => null,
    } );
} )( window.wp );
