Ext.define('appMain.UniversalTab.GridTab',{
    extend : 'Ext.panel.Panel',
	closable: true,		
    tabName : '',
	controllerUrl : '',
	storeFields : '',
	gridColumns: [], 
	dataGrid:null, 
	params: '',
	modelName: '',

	
    initComponent:function(){
		this.initStore();
	    this.initGrid(); 
		this.items = [ this.dataGrid ];
		
		this.addListener('clearClicked' , function()
		{
			this.store.clearFilter();
			if (RoleId!=1){
				var filter= '[{"property":"organizationId","value": "'+OrganizationId+'"}]';
				this.store.getProxy().setExtraParam('filter' , filter);
			}
			this.store.loadPage(1);
			
		} , this
		);		
		this.addListener('searchFieldEnter' , function(combo)
		{
			this.store.clearFilter();
			var filter= '[{"property":"oem","value": "'+combo+'"}';
			if (RoleId!=1){
				filter +=',{"property":"organizationId","value": "'+OrganizationId+'"}';
			}
			filter+=']';
			this.store.getProxy().setExtraParam('filter' , filter);
			
			this.store.loadPage(1);
			
		} , this
		);
		
		this.dockedItems = Ext.create('appMain.UniversalTab.GridToolbar', 	
		{	
			itemId: this.itemId, 
			modelName: this.modelName,
			listeners: 
			{
				clearClicked: {
				  fn: function(){
					this.fireEvent('clearClicked');
				  },
					scope:this
				},		
				searchFieldEnter: {
				  fn: function(combo){
					this.fireEvent('searchFieldEnter',combo);
				  },
					scope:this
				},
				
			},			
			
		});
		this.callParent();
    },
	
	
	
	initStore:function(){
		//console.log('modelName '+this.modelName+" params "+this.params+" sf "+this.storeFields);
		this.store = Ext.create('appMain.Store.UniversalStore', { 
			modelName: this.modelName, 
			fields: this.storeFields, 
			params: this.params, 
			itemId: this.itemId+'-store',
			storeId: this.itemId+'-store',
			filters: this.filters, 
			sorters: this.sorters, 
		});
		console.log(this.itemId+'-store');
		this.store.load();
    },
	

	
	initGrid:function(){
		//console.log('gridColumns '+this.gridColumns);
		this.dataGrid = Ext.create("Ext.grid.Panel",{
				xtype:"grid",
				columnLines:true,
				itemId: this.itemId + '-grid',
				tbar:Ext.create("Ext.PagingToolbar", {
					//itemID: 'pagingtoolbar',
					xtype: 'pagingtoolbar',
					store: this.store,
					displayInfo: true,
					//pageSize: 20,
					displayMsg: FLang("Displaying records {0} - {1} of {2}"),
					emptyMsg: FLang('NO_RECORDS_TO_DISPLAY'),
				}),		
				viewConfig:{enableTextSelection: true},
				store:  this.store,
				columns:  this.gridColumns,
				listeners:
				{
					'itemdblclick':{
					fn:function(view,record,item,index,e,eOpts){
						FShowModule(this.modelName+record.get('id'));
						//showArticleEditWindow(record.get("id"));
					},
					//scope:this
					}
				},

		}); 
    }, 
});

Ext.define('appMain.UniversalTab.NewTab',{
    extend : 'Ext.panel.Panel',
	closable: true,		
	params: '',
	storeFields: '',
	//Items: [],
	New: 0,
	ModelName: '',
	RecordId: '',
	
    initComponent:function(){
		this.dockedItems =  Ext.create('appMain.UniversalTab.SaveToolbar', 	{itemId: this.itemId} );
		//if (RecordId!='New') 
		//FInitFields();
		//FInitValues();

		this.callParent();
    },
	
	/*
	FInitValues: function(){
		var storeFields=this.storeFields;
		this.store= Ext.create('appMain.Store.UniversalStore', {
		   modelName: this.ModelName, 
		   params: '&log=0',
		   filters: '[{"property":"id","value": "'+this.RecordId+'"} ]',
		   fields: storeFields
		});
		this.store.load();
		
		Ext.each(Panel.items.items, function(item){
			item.setValue(this.store[item.name]);
		});
	
	},
	FInitFields: function(){
		this.Panel = Ext.create('Ext.form.Panel', {
			items: [Reference, Reference2,]
		});
		this.form = Panel.getForm();
		this.form.load({
		   waitMsg:'LOADING',
		   this.modelName:"ReferenceSettings", 
		   this.params: '&log=0',
		   this.filters: '[{"property":"DefaultFor","value": "'+UserId+'"} ]',
		   url : "index.php?r=backend/index&Table="+this.modelName+this.params+this.filters,
		   	success: function(form, action)
			{
				if(action.result.success)
				{
					this.Panel.items=action.result.data[0].Items;
					this.StoreFields=action.result.data[0].StoreFields;
				}else{
					this.filters: '[{"property":"DefaultFor","value": "ALL"} ]',
					this.form.load({
						success: function(form, action)
						{
							if(action.result.success)
							{
								this.Panel.items=action.result.data[0].Items;
								this.StoreFields=action.result.data[0].StoreFields;
							}
						}else{
							console.log('fail');
						}
					});
				
				}
			}

		   
		});


		this.items=Panel;
		
		
	
	},
	*/
	
	
});