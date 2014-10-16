Ext.ns('appMain.Store');
Ext.ns('appMain.ComboBox');
 
Ext.define('appMain.ComboBox.UniversalComboBox', { 
	extend: 'Ext.form.field.ComboBox', 
	xtype: 'uni-comboBox',	
	store: '',
	params: '',  
	tpl: Ext.create('Ext.XTemplate', '<tpl for=".">', '<div class="x-boundlist-item">{id} - {name}</div>', '</tpl>'), // - работает	
	minChars: 3,
	displayField: 'name',
	valueField: 'id',
	constructor: function(config){
			/*this.store = config.store;
			this.params = config.params;
			this.tpl = config.tpl;
			this.minChars = config.minChars;
			this.params = config.params;
			this.displayField = config.displayField;
			this.valueField = config.valueField;*/
			
			this.callParent(arguments);
	}	
});
 /*var SubgroupComboBox = Ext.create('appMain.ComboBox.UniversalComboBox',{ 
				fieldLabel: 'Subgroup', 
				labelAlign : 'right',
			    width: 300,
			  //  store: appMain.SubgroupStore, 
			    store: SubgroupStore, 
				typeAhead: true,
				displayField: 'name',
			    valueField: 'id',
		});	
*/