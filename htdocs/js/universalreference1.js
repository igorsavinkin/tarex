
var modelName= 'ReferenceSettings';
var params='';

Ext.ns('appMain.UniversalTab');		

Ext.define('appMain.UniversalTab.searchField',{
	extend: 'Ext.form.field.Text',	
	//value: FLang('Search'),
	value: 'Search',
	enableKeyEvents: true,
	initComponent:function(){
	
		this.addEvents([
			'searchFieldEnter'
		]);
		this.callParent();
	}	
		
});

			
			

Ext.define('StoreReferenceSettingsModel',{ 
	extend: 'Ext.data.Model',
	modelName:"ReferenceSettings", 
	params: '&log=0',

	fields: [
		{name: 'Name', type: 'string' },
		{name: 'StoreFields', type: 'text' },
		{name: 'Reference', type: 'string' },
		{name: 'Items', type: 'text' },
		{name: 'Filters', type: 'text' },
		{name: 'SearchFieldSettings', type: 'text' },
		{name: 'DefaultFor', type: 'text' },
	],
	proxy: {
		type: 'ajax',
		reader: { 
		 root: "data",
		 totalProperty: "count",
		 type: "json"
		},
		url : "index.php?r=backend/index&Table="+modelName+params,
	}

});
			


//var Model1=Ext.create('StoreReferenceSettingsModel');


var Store1=Ext.create('Ext.data.Store',{
	model: 'StoreReferenceSettingsModel',
	//autoLoad: false,
});



//var Grid1=Ext.create('Ext.grid.Panel', {
Ext.define('Grid1', {
	extend: 'Ext.grid.Panel',
    //title: 'Simpsons',
	xtype:"grid",
	tbar:Ext.create("Ext.PagingToolbar", {
					//itemID: 'pagingtoolbar',
					xtype: 'pagingtoolbar',
					store: Store1,
					displayInfo: true,
					//pageSize: 20,
					displayMsg: "Displaying records {0} - {1} of {2}",
					emptyMsg: 'NO_RECORDS_TO_DISPLAY',
	}),	
	store: Store1,
	//features: [filtersCfg],
    columns: [
 		 {  dataIndex:"Name", text:"Name", itemId:"Name",
			 //filter: { type: 'string' }
			 },
			 {  dataIndex:"StoreFields", text:"StoreFields", itemId:"StoreFields", 
			
			 },
			
		
		
    ],
  
    //renderTo: Ext.getBody()
});



Ext.define('SearchWindowWindow',{
	extend: 'Ext.Window',
	height:300,
	width:400,
	editForm:null,
	  
	layout:"anchor",
	constructor: function(config){
				config = Ext.apply({
					modal: true,
					layout:'border',
					closeAction: 'destroy',
					resizable:true,
					fieldDefaults:{
						labelAlign: 'right',
						labelWidth: 150,
						anchor: '100%'
					},
					items:[],
					buttonsAlign:'right',
					maximizable:true
				}, config || {});
			this.callParent(arguments);

	},
	
	
	  

	initComponent:function(){
		var Reference=Ext.create('Ext.form.field.Text',{
					xtype:"textfield",
					width      : 300,
					name: 'StoreFields',
					text: 'StoreFields',
					fieldLabel:"StoreFields",
					//value: searchFieldValue,
					//fieldLabel: FLang("Reference"),
		});		
		
		var Reference2=Ext.create('Ext.form.field.Text',{
					xtype:"textfield",
					width      : 300,
					name: 'Name',
					text: 'Name',
					fieldLabel:"Name",
					//value: searchFieldValue,
					//fieldLabel: FLang("Reference"),
		});

		var  Panel = Ext.create('Ext.form.Panel', {
			items: [Reference, Reference2,]
				
				
				
			
			//fieldDefaults: this.fieldDefaults
		});
		

			
		
		this.dataItemId='1';
		//Panel.loadRecord(Store1);
		
		this.items=[Panel, 
			{xtype: 'button', name: 'but1', text: 'test1', handler: function(){
				
				
					Ext.each(Panel.items.items , function(item){
							//items.setData(action.result.data[items.fieldName]);
							//console.log('success3'+cmp.fieldName);
							item.setValue('success3 '+item.name);
							//console.log('success3');

						});	
				
				//console.log('success3'+Panel.items);
				}	
			}
		
		];
	    //this.loadData();
		
		//var form = this.Panel.getForm();
		//form.load();*/
		this.callParent();
	},
	
	
	loadData: function()
	{
	  //console.log('loadData'+itemId);
	  var form = this.Panel.getForm();
	  var Items = this.Panel.items;
	  //form.waitMsgTarget = me.getEl();
	  //form.loadRecord('StoreReferenceSettingsModel');
	  
	  form.load({
		  waitMsg:'LOADING',
		   url : "index.php?r=backend/index&Table="+modelName+params,
		
		  //url:this.controllerUrl + 'loaddata',
			method:'get',
			/*params: {
				'modelName':'ReferenceSettings',
				'params':''
			},*/
			success: function(form, action)
			{
					console.log('success');
				if(action.result.success)
				{
					console.log('success1');
					if(!Ext.isEmpty(Items)){
						console.log('success2');
					
						Ext.each(Items , function(record){
							//items.setData(action.result.data[items.fieldName]);
							//console.log('success3'+cmp.fieldName);
							console.log('success3'+record.name);

						});
					}
					
					//me.fireEvent('dataLoaded' ,action.result);
				}
				else
				{
					Ext.Msg.alert('Failure').toFront();
					me.close();
				}
			},
	  
	  });
	},
	  
		

});

//var SearchWindow=Ext.create('SearchWindowWindow');


Ext.onReady(function() {
	Store1.load();
	var Grid1=Ext.create('Grid1');
	
	//console.log('test');
	//Store1.filter('organizationId',9);+
	var Panel = Ext.create("Ext.panel.Panel",	{
		//xtype:"grid",
		//features: [filtersGrid],
		//columnLines:true,
		renderTo: Ext.getBody(),
		title:"Assortment",
		items : [
			{	xtype: 'button', 
				text:'test', 
				handler: function(){
			
				    Ext.create('SearchWindowWindow').show();
				
				} 
			},
			Grid1,
		]
		

	});
	
	
	
	
});

