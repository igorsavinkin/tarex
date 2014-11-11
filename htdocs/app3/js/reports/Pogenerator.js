Ext.ns('appMain');		

appMain.application = Ext.application({

    autoCreateViewport:false,
    name: 'MyApp',
    launch: function() {  


		//console.log('OrganizationId '+OrganizationId);
		
		var Store = Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Assortment", 
				pageSize: 10,
				//params: "&sort=DisplayOrder&dir=ASC&distinct=1&filter[0][data][value]="+RoleId+"&filter[0][field]=RoleId&filter[0][data][type]=string&fields=Subsystem,Img",
				params: '&log=0',
				fields: [
					{name: 'article', type: 'string'},
					{name: 'oem', type: 'string'},			
					{name: 'title', type: 'string'},			
					{name: 'availability', type: 'int'},			
					{name: 'sales', type: 'int'},			
					{name: 'priceS', type: 'int'},			
						
				],
				//filters: [{"property":"organizationId","value":7}],
				//sorters: [{"property":"DisplayOrder","direction":"ASC"}],
		});
		
		//var filter= '[{"property":"organizationId","value": "'+OrganizationId+'"}]';
		//Store.getProxy().setExtraParam('filter' , filter);
		//Store.getProxy().setExtraParam('limit' , 10);
		
		Store.load();
		
	
		
		var dataGrid = Ext.create("Ext.grid.Panel",{
					xtype:"grid",
					//overflowX: 'scroll',
					//overflowX: 'hidden',
 					columnLines:true,
					itemId: this.itemId + '-grid',
					tbar:Ext.create("Ext.PagingToolbar", {
						//itemID: 'pagingtoolbar',
						xtype: 'pagingtoolbar',
						store: Store,
						displayInfo: true,
						//pageSize: 10,
						displayMsg: "Displaying records {0} - {1} of {2}",
						emptyMsg: 'NO_RECORDS_TO_DISPLAY',
					}),		
					viewConfig:{enableTextSelection: true},
					store:  Store,
					columns:  [
						{ dataIndex:"article", text: "Article", width: 125, },
						{ dataIndex:"oem", text: "oem" },
						{ dataIndex:"title", text: "Title", width: 500, },
						{ dataIndex:"availability", text: "Availability", width: 50, },
						{ dataIndex:"sales", text: "Sales", width: 50, renderer: this.FSales },
						{ dataIndex:"availability", text: "FOB", width: 50, 
						//renderer: this.FOB 
						},
						{ dataIndex:"priceS", text: "Price", width: 50, },
						//{ xtype:"button", text: "Add", },
					],
		}); 
		
		
		var SuppliersStore= Ext.create('Ext.data.Store', {
			fields: [
				{ name:"SupplierName", type: 'string' },
				{ name:"SupplierItemCode", type: 'int' },
				{ name:"LedTime", type: 'int' },
				{ name:"Percent", type: 'int' },
				{ name:"CalcLandedCost", type: 'int' },
			],
			data: [{'SupplierName':'TRADE UNION', 'LedTime':'0', 'CalcLandedCost':'0'}],
		});
		
		var Suppliers = Ext.create("Ext.grid.Panel",{
			renderTo: 'Suppliers',
			store: SuppliersStore,
			columns:  [
				{ dataIndex:"SupplierName", text: "Supplier Name", width: 125, },
				{ dataIndex:"SupplierItemCode", text: "Supplier item code", width: 70, },
				{ dataIndex:"LedTime", text: "Led time", width: 70, },
				{ dataIndex:"Percent", text: "%", width: 50, },
				{ dataIndex:"CalcLandedCost", text: "Calc landed cost", width: 50, },
				
			
			],
			//data: {'items':[{'SupplierName':'TRADE UNION', 'LedTime':'0', 'CalcLandedCost':'0'}]},
			//items: [{'SupplierName':'TRADE UNION', 'LedTime':'0', 'CalcLandedCost':'0'}],
				


		}); 		
		
		var ReplacementItems = Ext.create("Ext.grid.Panel",{
			renderTo: 'ReplacementItems',
			columns:  [
				{ dataIndex:"Code", text: "Code", width: 50, },
				{ dataIndex:"Description", text: "Description", width: 300, },
				{ dataIndex:"FOB", text: "FOB", width: 50, },
				{ dataIndex:"USD", text: "USD", width: 50, },
			]
		}); 

		StoreItemStatistics= Ext.create('Ext.data.Store', {
			fields: [
				{ name:"Name", type: 'string' },
				{ name:"M1", type: 'int' },
				{ name:"M2", type: 'int' },
				{ name:"M3", type: 'int' },
				{ name:"M4", type: 'int' },
				{ name:"M5", type: 'int' },
				{ name:"M6", type: 'int' },
				{ name:"M7", type: 'int' },
				{ name:"M8", type: 'int' },
				{ name:"M9", type: 'int' },
				{ name:"M10", type: 'int' },
				{ name:"M11", type: 'int' },
				{ name:"M12", type: 'int' },
			],
			data: [
			{"Name":"Sold Qty"},
			{"Name":"Bought Qty"},
			{"Name":"Avalible Qty"},
			],
		});
		
		var ItemStatistics = Ext.create("Ext.grid.Panel",{
			renderTo: 'ItemStatistics',
			store: StoreItemStatistics,
			columns:  [
				{ dataIndex:"Name", text: "Name", width: 100, },
				{ dataIndex:"M1", text: "M1", width: 30, },
				{ dataIndex:"M2", text: "M2", width: 30, },
				{ dataIndex:"M3", text: "M3", width: 30, },
				{ dataIndex:"M4", text: "M4", width: 30, },
				{ dataIndex:"M5", text: "M5", width: 30, },
				{ dataIndex:"M6", text: "M6", width: 30, },
				{ dataIndex:"M7", text: "M7", width: 30, },
				{ dataIndex:"M8", text: "M8", width: 30, },
				{ dataIndex:"M9", text: "M9", width: 30, },
				{ dataIndex:"M10", text: "M10", width: 30, },
				{ dataIndex:"M11", text: "M11", width: 30, },
				{ dataIndex:"M12", text: "M12", width: 30, },
			],
		
		}); 
		
		/*
		var StoreFamily= Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Assortment", 
				params: '&log=0&distinct=1&fields=model&unlimited=1',
				fields: [
					{name: 'model', type: 'string'},			
				],
		});
		
		//var filter= '[{"property":"organizationId","value": "'+OrganizationId+'"}]';
		//Store.getProxy().setExtraParam('filter' , filter);
		//Store.getProxy().setExtraParam('limit' , 10);
		
		StoreFamily.load();
		

		var ComboBoxFamily = Ext.create("Ext.form.ComboBox",{
			 fieldLabel: 'Model',
			 //width: 50,
			     displayField: 'model',
				valueField: 'model',			
		    store: StoreFamily,
			
		});
		*/
		
		var SubgroupField=Ext.create('Ext.form.field.Text', {
			fieldLabel: 'Subgroup',
			labelWidth: 50,
			width: 150,
		});
		var TitleField=Ext.create('Ext.form.field.Text', {
			fieldLabel: 'Title',
			labelWidth: 50,
			width: 150,
		});
		var ModelField=Ext.create('Ext.form.field.Text', {
			fieldLabel: 'Model',
			labelWidth: 50,
			width: 150,
		});
		var MakeField=Ext.create('Ext.form.field.Text', {
			fieldLabel: 'Make',
			labelWidth: 50,
			width: 150,
		});
		var ManufacturerField=Ext.create('Ext.form.field.Text', {
			fieldLabel: 'Manufacturer',
			labelWidth: 70,
			width: 150,
		});

		var LoadButton=Ext.create('Ext.button.Button', {
			text: 'Search',
			icon: 'images/icons/Search.png',
			handler: function() {
				//alert('FamilyField '+SubgroupField.getValue());
				
				var filter= '[{"property":"subgroup","value": "'+SubgroupField.getValue()+'"},{"property":"title","value": "'+TitleField.getValue()+'"},{"property":"model","value": "'+ModelField.getValue()+'"},{"property":"make","value": "'+MakeField.getValue()+'"},{"property":"manufacturer","value": "'+ManufacturerField.getValue()+'"}]';
				Store.getProxy().setExtraParam('filter' , filter);
				//Store.getProxy().setExtraParam('limit' , 10);
				
				Store.loadPage(1);
				
			}
		});
		
		
		var SearchToolbar= Ext.create('Ext.toolbar.Toolbar', {
			items: [
				SubgroupField, TitleField, ModelField, MakeField, ManufacturerField, LoadButton
			],
		
		});
		
		Ext.create('Ext.panel.Panel', {
			//title: 'P.O.',
			//width: 200,
			//html: '<p>World!</p>',
			renderTo: 'Pogenerator',
			dockedItems: SearchToolbar,
			items: [ 
			
				dataGrid, 
			
			{
                id: 'detailPanel',
                region: 'center',
                bodyPadding: 7,
                bodyStyle: "background: #ffffff;",
                html: 'Please select to see additional details.',
			}]
		
			
			
		});
		 
		var bookTplMarkup = [
		"<table border=1 width=100%><tr>",
		"<td width=10%>Last Purchase</td>",
		"<td width=10%>{1}</td>",
		"<td width=10%>FOB Cost</td>",
		"<td width=10%>{FOBCost}</td>",
		"<td width=10%>LYLP</td>",
		"<td width=10%>{LYLP}</td>",
		"<td width=10%>AGP</td>",
		"<td width=10%>{AGP}</td>",
		"</tr><tr>",
		"<td width=10%>Last Sales</td>",
		"<td width=10%>{0}</td>",
		"<td width=10%>Landed Cost</td>",
		"<td width=10%>{LandedCost}</td>",
		"<td width=10%>L3MGP</td>",
		"<td width=10%>{L3MGP}</td>",
		"<td width=10%>AMS</td>",
		"<td width=10%>{AMS}</td>",
		"</tr><tr>",
		"<td colspan=8>Notes: {Notes}</td>",
		"</tr></table>",
		];
		var bookTpl = Ext.create('Ext.Template', bookTplMarkup);
	
	
		dataGrid.getSelectionModel().on('selectionchange', function(sm, selectedRecord) {
        if (selectedRecord.length) {
            var detailPanel = Ext.getCmp('detailPanel');
            detailPanel.update(bookTpl.apply(selectedRecord[0].data));
			console.log('id '+selectedRecord[0].data.id);
			
			var ArrayData = new Array();
			var ArraySuppliers = new Object();
			
			//продажи этой номенклатуры
			var LastSaleDate='00-00-0000';
			var assortmentId=selectedRecord[0].data.id;
			var StoreSalesContent = Ext.create('appMain.Store.UniversalStore',{ 
					modelName:"EventContent", 
					params: '&log=0',
					fields: [
						{name: 'eventId', type: 'int'},
						{name: 'assortmentId', type: 'int'},			
						{name: 'assortmentAmount', type: 'int'},			
						{name: 'price', type: 'float'},							
						{name: 'cost', type: 'float'},							
					],
			});
			
			var StoreSales= Ext.create('appMain.Store.UniversalStore',{ 
					modelName:"Events", 
					params: '&log=0',
					fields: [
						{name: 'id', type: 'int'},
						{name: 'EventTypeId', type: 'int'},			
						{name: 'contractorId', type: 'int'},			
						{name: 'Begin'},			
					],
			});
			var filter= '[{"property":"EventTypeId","value": "18"}]';
			StoreSales.getProxy().setExtraParam('filter' , filter);
			 
			var filter= '[{"property":"assortmentId","value": "'+assortmentId+'"}]';
			StoreSalesContent.getProxy().setExtraParam('filter' , filter);			
			
			var StoreUser=Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"User", 
				params: '&log=0',
				fields: [
						{name: 'username', type: 'string'},
				]
			});
			//StoreUser.getProxy().setExtraParam('filter' , filter);
			
			StoreSalesContent.load(function(records) { 
			   Ext.each(records, function(record){
					//SalesCount+=record.get('assortmentAmount');
					//console.log('eventId '+record.get('eventId'));
					var filter= '[{"property":"EventTypeId","value": "18"},{"property":"id","value": "'+record.get('eventId')+'"}]';
					StoreSales.getProxy().setExtraParam('filter' , filter);
					StoreSales.load(function(records) { 
						Ext.each(records, function(record){
							
							//detailPanel.update(bookTpl.apply({LastSales: record.get('Begin')}));
							//bookTpl.apply({LastSales: record.get('Begin')});
							ArrayData[0]=record.get('Begin');
							console.log('ArrayData0 '+ArrayData[0] );
							
						});
					});
					
					var filter= '[{"property":"EventTypeId","value": "31"},{"property":"id","value": "'+record.get('eventId')+'"}]';
					StoreSales.getProxy().setExtraParam('filter' , filter);
					StoreSales.load(function(records) { 
						Ext.each(records, function(record){
							//console.log('Begin  '+record.get('Begin')+' id '+record.get('id'));
							
							//detailPanel.update(bookTpl.apply({LastPurchase: record.get('Begin')}));
							//ArraySuppliers=[{'SupplierName': record.get('contractorId')}];
							var ContractorId=record.get('contractorId');
							console.log('ContractorId '+ContractorId );
							var filter= '[{"property":"id","value": "'+ContractorId+'"}]';
							StoreUser.getProxy().setExtraParam('filter' , filter);
							StoreUser.load(function(records) { 
								Ext.each(records, function(record){
									var ContractorName=record.get('username');
									console.log('ContractorName '+ContractorName );
									ArraySuppliers=[{'SupplierName': ContractorName}];
									SuppliersStore.loadData(ArraySuppliers);
									
								});
							});

							//console.log('ArraySuppliers '+ArraySuppliers );
							
							ArrayData[1]=record.get('Begin');
							console.log('ArrayData1 '+ArrayData[1] );
							detailPanel.update(bookTpl.apply(ArrayData));
							
						});
					});
					
					
					
			   });
			//console.log('ArrayData '+ArrayData[0] );
			//SuppliersStore.loadData(ArraySuppliers);
			   
			}); //MenuStore.load(function(records) { 
			
			
			//=== Обновление по suppliers
			
			//=== Обновление по suppliers
			
			//console.log('ArrayData1 '+ArrayData[1]);
			//detailPanel.update(bookTpl.apply(ArrayData));
			
        } //if (selectedRecord.length) {
	});
	
	

		//console.log('ready1');
		
	},
		
		
	FLastSale:function(value, metaData, record){
		
		
		return LastSaleDate;
	},
		
	FSales:function(value, metaData, record){
		//return 'id '+record.get('id');	
		var SalesCount=0;
		var assortmentId=record.get('id');
		var StoreSales= Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"EventContent", 
				params: '&log=0',
				fields: [
					{name: 'eventId', type: 'int'},
					{name: 'assortmentId', type: 'int'},			
					{name: 'assortmentAmount', type: 'int'},			
					{name: 'price', type: 'int'},			
					
						
				],
		});
		var filter= '[{"property":"assortmentId","value": "'+assortmentId+'"}]';
		StoreSales.getProxy().setExtraParam('filter' , filter);
		
		
		StoreSales.load(function(records) { 
		   Ext.each(records, function(record){
				SalesCount+=record.get('assortmentAmount');
		   });
		}); //MenuStore.load(function(records) { 
		
		
		return SalesCount;
		
	},
	
	
	
	
	

});