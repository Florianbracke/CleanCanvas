// Modify settings for Core blocks
wp.hooks.addFilter( 'blocks.registerBlockType',
  'my/change_alignment', ( settings, name ) => {

  switch( name ) {
    case 'core/image':
    case 'core/video':
    case 'core/paragraph':
    case 'core/columns':
    case 'core/group':
    case 'core/list':
    case 'acf/faq':
    case 'core/cover':
    case 'core/heading':
      return lodash.assign( {}, settings, {
        supports: lodash.assign( {}, settings.supports, {
          align: ['wide', 'full']
        } ),
        attributes: lodash.assign( {}, settings.attributes, { align: {
          type: 'string', default: 'wide'
        } } ),
      } );
  }

  return settings;
});
