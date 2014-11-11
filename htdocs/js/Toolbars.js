
			
			
 Ext.define('appMain.UniversalTab.SaveToolbar',{
	extend : 'Ext.toolbar.Toolbar',

	
	
	initComponent:function(){
		
		this.items =	[
			Ext.create('appMain.UniversalTab.SaveButton', {itemId: this.itemId}),
			{xtype:"tbseparator"},
			{xtype:"tbfill"},
			Ext.create('appMain.UniversalTab.AdvancedSearchButton')
				//appMain.UniversalTab.searchField
		];
		this.callParent();
	}
	
			
});


 Ext.define('appMain.UniversalTab.GridToolbar',{
	extend : 'Ext.toolbar.Toolbar',
	modelName: '',
	
	
	initComponent:function(){
	
		this.addListener('clearClicked' , function(){  //console.log('clearClicked'); 
			//SF.value='';
		} , this);
		this.addListener('searchFieldEnter' , function(combo){
			//console.log('searchFieldEnter'+combo);
		} , this);
		
		this.addListener('SaveAdvancedSearch' , function(combo){
			//console.log('SaveAdvancedSearch '+combo);
		} , this);
		
		
		
		var searchField= Ext.create('appMain.UniversalTab.searchField', {width: 300, listeners: {		keypress: {fn: function (combo, e){
					if (e.getKey() == e.ENTER) {
						
						this.fireEvent('searchFieldEnter', combo.getValue());
					}
					},scope:this
				}
			}
				
		});
		
		this.items =	[
			Ext.create('appMain.UniversalTab.AddButton', {itemId: this.itemId}),
			{xtype:"tbseparator"},
			//Ext.create('appMain.UniversalTab.searchField', {width: 100, listeners: {clearClicked:{fn: function(){this.fireEvent('clearClicked');}} }} ),
			searchField,
			{xtype:"tbseparator"},
			Ext.create('appMain.UniversalTab.ClearSearchButton',
			{   
				listeners: 
				{
					click: {
					  fn: function(){
						//console.log('click pressed...');
					  
						// инициируем свое событие
						this.fireEvent('clearClicked');
						searchField.setValue('');
					  },
						scope:this
					}
				},
			}),
			{xtype:"tbseparator"},
			{xtype:"tbfill"},
			
			Ext.create('appMain.UniversalTab.AdvancedSearchButton', {
				listeners: 
				{
					click: {
					  fn: function(){
						this.initSearchWindow(searchField.getValue(), this.modelName);
					  },
					  scope:this
					}
				},
			}),
			
		]; //this.items =
		 
		this.callParent();
	}, //initComponent:function(){
	
//=== 	initSearchWindow ===
	initSearchWindow: function(searchFieldValue, modelName){


			var StoreReferenceSettings = Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Cityes", 
				//modelName:"ReferenceSettings", 
				//filters: [{"property":"Users","value":UserId} ],
				sorters: [{"property":"Name","direction":"ASC"}],
				params: '&log=0',
				//limitParam: 300,
				
				fields: [
					{name: "Id", type: 'integer'},
					{name: "Name", type: 'string'},
					{name: "Reference", type: 'string'},			
					{name:"StoreFields",	type:"string",},
					{name:"Items", type: 'string'}, 
					{name:"Filters", type: 'string'},
					{name:"DefaultFor", type: 'string'},
					{name:"SearchFieldSettings", type: 'string'},
						
				],	
			});
			var filter= '[{"property":"Users","value": "'+UserId+'"}]';
			//StoreReferenceSettings.getProxy().setExtraParam('filter' , filter);
			//StoreReferenceSettings.getProxy().limitParam=300;
			
		
			



			//console.log('count'+StoreReferenceSettings.getTotalCount());
			var ComboBox = Ext.create("Ext.form.ComboBox",{
				 fieldLabel: FLang('Select setting'),
				 //queryMode: 'local',
				 displayField: 'Name',
				 valueField: 'Name',
				 Value: 'Setting2',

				 // width: 100,
			     store: StoreReferenceSettings,
				 /*listeners:{
					 //scope: yourScope,
					'change':function (combo, newValue, OldValue) {
						window.location.href = 'index.php?r=site/backendpavel&Language='+this.value;
					}
				}*/
			});

			var StoreFields=Ext.create('Ext.form.field.Text',{
						xtype:"textfield",
						width      : 300,
						name: 'StoreFields',
						fieldLabel: FLang("StoreFields"),
			});			
			var Items=Ext.create('Ext.form.field.Text',{
						xtype:"textfield",
						width      : 300,
						name: 'Items',
						fieldLabel: FLang("Items"),
			});
			var Filters=Ext.create('Ext.form.field.Text',{
						xtype:"textfield",
						width      : 300,
						name: 'Filters',
						fieldLabel: FLang("Filters"),
			});
			var SearchFieldSettings=Ext.create('Ext.form.field.Text',{
						xtype:"textfield",
						width      : 300,
						name: 'SearchFieldSettings',
						fieldLabel: FLang("SearchFieldSettings"),
			});
			
			
			//StoreReferenceSettings.load();
			//var Model=StoreReferenceSettings.findRecord( 'DefaultFor', UserId); 
			//console.log(Model.get('Name'));
			var Panel=Ext.create('Ext.form.Panel',{
				items:[
					ComboBox, StoreFields, Items, Filters, SearchFieldSettings
				
				],
				
			});
			
			StoreReferenceSettings.load(function(records) { 
				Ext.each(records, function(record){
				//	console.log(record.get('Id'));
					//Panel.items
					var N='.StoreFields';
					Panel.items[N].SetValue(N);
				});
			
			
			});
			

			//console.log()
				var Model=StoreReferenceSettings.getAt('1');
				console.log(Model.get('Name'));

				
			Ext.each(Panel.items.items, function(item){
				//item.setValue(StoreReferenceSettings[item.name]);
				//console.log('item.name '+item.name+' store '+StoreReferenceSettings[item.name]);
				//console.log(' store v '+StoreReferenceSettings['data']);
				//console.log(' store v '+StoreReferenceSettings['data']);
				
			});
		
			//Panel.getForm().loadRecord(StoreReferenceSettings);
			
			// StoreReferenceSettings.load(function(records) { 
				// Ext.each(records, function(record){
					// console.log(record.get('Reference'));
					// Reference.setValue(record.get('Reference'));
				
				
				// });
			// }); 
			
			
			
			
			var SearchWindow=Ext.create('Ext.window.Window', {
				title: FLang('Advanced search'),
				modal:true,
				height:300,
				width:400,
				layout:"anchor",

				items: [
				
					Panel,
				
				],
				bbar: [
					{   xtype: 'button', text: FLang('Close'), 
						icon: 'images/icons/Close.png',	
						handler: function(){ SearchWindow.destroy();},
					},
					{   xtype: 'button', text: FLang('Save'), 
						icon: 'images/icons/Save.png',	
						handler: function(){ 
							//this.fireEvent('SaveAdvancedSearch', AdvancedSearchField.getValue() );
							//searchField.setValue(AdvancedSearchField.getValue());
							console.log(modelName+'-store');
							var store = Ext.data.StoreManager.lookup(modelName+'-store');
							store.loadPage(2);
							
							SearchWindow.destroy(); 
						
						},
					},
				],
				
				
			}).show();
		
	},
//=== 	initSearchWindow ===	
			
});

