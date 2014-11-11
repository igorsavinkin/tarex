/**
 * Lukas Sliwinski
 * sliwinski.lukas@gmail.com
 *
 * Dynamic grid, allow to display data setting only URL.
 * Columns and model will be created dynamically.
 */
$store = Ext.create('Ext.data.Store', {
                    // Fields have to be set as empty array. Without this Ext will not create dynamic model.
                    fields: [],
                    // After loading data grid have to reconfigure columns with dynamic created columns
                    // in Ext.ux.data.reader.DynamicReader
                    listeners: {
                        'metachange': function(store, meta) {
                          //  me.reconfigure(store, meta.columns);
                            Ext.getCmp('grid').reconfigure($store, meta.columns);
                        }
                    },
                    autoLoad: true,
                    remoteSort: false,
                    remoteFilter: false,
                    remoteGroup: false,
                    proxy: {
                        reader: 'dynamicReaderCustom',
                        type: 'rest',
                        //url: me.url
                        url: 'dbaccess/getModel.php?model=doc_events&fields=Id,Subject' //Ext.getCmp('grid').url
                    }
                }); 
 

$grid = Ext.define('Ext.ux.grid.DynamicGridCustom', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.dynamicGridCustom',
    alternateClassName: 'Ext.grid.DynamicGridCustom',
	id: 'grid', 
	itemId: 'grid', 
    requires: [
        'Ext.ux.data.reader.DynamicReaderCustom'
    ],
    // URL used for request to the server. Required
    url: '',

	dockedItems: [{
		id: 'assortment-pages',
		itemID: 'pagingtoolbar',
		xtype: 'pagingtoolbar',
		store: $store,
		dock: 'bottom',
		displayInfo: true,
		displayMsg: 'Displaying items {0} - {1} of {2}',
		emptyMsg: "No items to display",
	}],
    initComponent: function() {
        console.log('DynamicGridCustom initComponent!');
        var me = this;

        if (me.url == '') {
            Ext.Error.raise('url parameter is empty! You have to set proper url to get data form server.');
        }
        else {
            Ext.applyIf(me, {
                columns: [],
                forceFit: true,
                store: $store,				
            });
        }

        me.callParent(arguments);
    }
});