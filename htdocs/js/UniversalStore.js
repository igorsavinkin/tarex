Ext.ns('appMain.Store');
Ext.ns('appMain.ComboBox');

//Работает!!!
Ext.define('appMain.Store.UniversalStore',{
	extend: 'Ext.data.Store', 
	xtype: 'uni-store',	
	autoLoad: false,
	fields: '', 
	modelName: '',
	params: '',
	//limitParam: 50,
	//filters: [],
	//sort: [],
	constructor:function(config){
			this.modelName = config.modelName;
			this.params = config.params;
			//this.filters = config.filters;
			//this.sort = config.sort;
			
			this.proxy =         
			{ 
				
				//url:  "index.php?r=backend/index&Table="+this.modelName+this.params,
				url:  "index.php?r=backend/index&Table=" + this.modelName + this.params,
				reader: { 
					 root: "data",
					 totalProperty: "count",     
					 type: "json"
				},
				type:"ajax",
				// limitParam: this.limitParam,
			};
			this.callParent(arguments);
	}	
});

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
 /*ComboBox=Ext.create("Ext.form.field.ComboBox",{
			   fieldLabel: 'Subgroup combo', 
			   width: 500,
			   store: SubgroupStore,
			  http://try.sencha.com/extjs/4.1.1/docs/Ext.form.field.ComboBox.2/viewer.html
			   // displayTpl: Ext.create('Ext.XTemplate', '<tpl for=".">', '{id} - {name}', '</tpl>'), // - не обязательно
			   tabIndex: 3,
			   //queryMode: 'local', //'remote',
			   displayField: 'name',
			   valueField: 'id',
			   // hideTrigger: true,
			   // editable: false,
			   typeAhead: true,
			   // enableKeyEvents :  true,
			   minChars: 3,
			 //  listeners: {		   },
		}); // end of comboBox for Subgroup  
*/