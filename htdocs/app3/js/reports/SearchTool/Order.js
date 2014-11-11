		Ext.define('OrderModel', {
			extend: 'Ext.data.Model',
			fields: [
				{name: 'article', type: 'string'},
				{name: 'oem', type: 'string'}, 
				{name: 'title',  type: 'string'},
				{name: 'idtitle',   type: 'int'},
				{name: 'price', type: 'double'},
				{name: 'organizationId', type: 'int'},
				{name: 'amount', type: 'int'},
				//{name: 'Ware', type: 'string'},
				{name: 'Warehouse', type: 'string'},
				{name: 'Currency', type: 'string'},
				{name: 'Sum', type: 'double'},
			],
			/*proxy: {
				type: 'memory',
				reader: {
					type: 'json',
					rootProperty: 'data'
				}
			}*/

		});
			
//=== Order ЗАКАЗ ===
		var RegularItemsStore=Ext.create("Ext.data.Store",{
			model: 'OrderModel',
		});
		var NewQtyItemsStore=Ext.create("Ext.data.Store",{
			model: 'OrderModel',
		});
		var MarketPriceItemsStore=Ext.create("Ext.data.Store",{
			model: 'OrderModel',
		});
		var ItemsUnderOfferStore=Ext.create("Ext.data.Store",{
			model: 'OrderModel',
		});
		var OversaleItemsStore=Ext.create("Ext.data.Store",{
			model: 'OrderModel',
		});
		var ShortageItemsStore=Ext.create("Ext.data.Store",{
			model: 'OrderModel',
		});
		
		
		var RegularItems=Ext.create("Ext.grid.Panel",{
			title: 'Regular Items (0)',
			store: RegularItemsStore,

			columns:  [
					{ dataIndex:"idtitle", text: "id", width: 50 },
					{ dataIndex:"article", text: "Article", width: 100 },
					{ dataIndex:"oem", text: "Oem", width: 100},
					{ dataIndex:"title", text: "Title", width: 150, },
					{ dataIndex:"Warehouse", text: "Warehouse", width: 100, },
					{ dataIndex:"Currency", text: "Currency", width: 100, },
					{ dataIndex:"amount", text: "Qty", width: 50 },
					{ dataIndex:"price", text: "Price", width: 50 },
					{ dataIndex:"Sum", text: "Sum", width: 50 },
					{ xtype:"actioncolumn", text: "Re-simulate", width: 25,
						items: [
							{xtype: 'button', icon: "images/icons/Edit.png", width: 30, tooltip: 'Re-simulate Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по 
									FResimulateWindowOpen(rec,'Regular Items');
								} 
							}, 
						]
					},{
						xtype:"actioncolumn", text: "Delete", width: 25, 
						items: [
							{xtype: 'button', icon: "images/icons/Delete.png", width: 30, tooltip: 'Delete Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по номеру строки
									FRestoreAvailability(rec.get('idtitle'),rec.get('Warehouse'),rec.get('amount'));
									grid.store.remove(rec);  
									
									FRecalcAll();
								}
							}, 
						
						]
					}	
				],
		});
		
		
		var NewQtyItems=Ext.create("Ext.grid.Panel",{
			title: 'New Qty Items (0)',
			store: NewQtyItemsStore,

			columns:  [
					{ dataIndex:"idtitle", text: "id", width: 50 },
					{ dataIndex:"article", text: "Article", width: 100 },
					{ dataIndex:"oem", text: "Oem", width: 100},
					{ dataIndex:"title", text: "Title", width: 150, },
					{ dataIndex:"Warehouse", text: "Warehouse", width: 100, },
					{ dataIndex:"Currency", text: "Currency", width: 100, },
					{ dataIndex:"amount", text: "Qty", width: 50 },
					{ dataIndex:"price", text: "Price", width: 50 },
					{ dataIndex:"Sum", text: "Sum", width: 50 },
					/*{ xtype:"actioncolumn", text: "Re-simulate", width: 25,
						items: [
							{xtype: 'button', icon: "images/icons/Edit.png", width: 30, tooltip: 'Re-simulate Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по 
									FResimulateWindowOpen(rec,'New Qty Items');
								} 
							}, 
						]
					},*/
					
					{
						xtype:"actioncolumn", text: "Delete", width: 25, 
						items: [
							{xtype: 'button', icon: "images/icons/Delete.png", width: 30, tooltip: 'Delete Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по номеру строки
									FRestoreAvailability(rec.get('idtitle'),rec.get('Warehouse'),rec.get('amount'));
									grid.store.remove(rec); FRecalcAll();                
								}
							}, 
						
						]
					}	
				],
		});		
		
		var MarketPriceItems=Ext.create("Ext.grid.Panel",{
			title: 'Market Price Items (0)',
			store: MarketPriceItemsStore,
	
			columns:  [
				{ dataIndex:"idtitle", text: "id", width: 50 },
					{ dataIndex:"article", text: "Article", width: 100 },
					{ dataIndex:"oem", text: "Oem", width: 100},
					{ dataIndex:"title", text: "Title", width: 150, },
					{ dataIndex:"Warehouse", text: "Warehouse", width: 100, },
					{ dataIndex:"Currency", text: "Currency", width: 100, },
					{ dataIndex:"amount", text: "Qty", width: 50 },
					{ dataIndex:"price", text: "Price", width: 50 },
					{ dataIndex:"RecomendedPrice", text: "Recomended price", width: 50 },
					{ dataIndex:"Sum", text: "Sum", width: 50 },
					{ xtype:"actioncolumn", text: "Re-simulate", width: 25,
						items: [
							{xtype: 'button', icon: "images/icons/Edit.png", width: 30, tooltip: 'Re-simulate Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по 
									FResimulateWindowOpen(rec,'Market Price Items');
								} 
							}, 
						]
					},{
						xtype:"actioncolumn", text: "Delete", width: 25, 
						items: [
							{xtype: 'button', icon: "images/icons/Delete.png", width: 30, tooltip: 'Delete Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по номеру строки
									FRestoreAvailability(rec.get('idtitle'),rec.get('Warehouse'),rec.get('amount'));									grid.store.remove(rec);       FRecalcAll();          
								}
							}, 
						
						]
					}	
				],
		});		
		var ItemsUnderOffer=Ext.create("Ext.grid.Panel",{
			title: 'Items under offer (0)',
			store: ItemsUnderOfferStore,

			columns:  [
					{ dataIndex:"idtitle", text: "id", width: 50 },
					{ dataIndex:"article", text: "Article", width: 100 },
					{ dataIndex:"oem", text: "Oem", width: 100},
					{ dataIndex:"title", text: "Title", width: 150, },
					{ dataIndex:"Warehouse", text: "Warehouse", width: 100, },
					{ dataIndex:"Currency", text: "Currency", width: 100, },
					{ dataIndex:"amount", text: "Qty", width: 50 },
					{ dataIndex:"price", text: "Price", width: 50 },
					{ dataIndex:"Sum", text: "Sum", width: 50 },
					/*{ xtype:"actioncolumn", text: "Re-simulate", width: 25,
						items: [
							{xtype: 'button', icon: "images/icons/Edit.png", width: 30, tooltip: 'Re-simulate Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по 
									FResimulateWindowOpen(rec,'Items under offer');
								} 
							}, 
						]
					},*/
					
					{
						xtype:"actioncolumn", text: "Delete", width: 25, 
						items: [
							{xtype: 'button', icon: "images/icons/Delete.png", width: 30, tooltip: 'Delete Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по номеру строки
									FRestoreAvailability(rec.get('idtitle'),rec.get('Warehouse'),rec.get('amount'));
									grid.store.remove(rec);       FRecalcAll();          
								}
							}, 
						
						]
					}	
				],
		});		
		
	//	var 
		 
		
		var OversaleItems=Ext.create("Ext.grid.Panel",{
			title: 'Oversale items (0)',
			store: OversaleItemsStore,
			viewConfig: {
				enableTextSelection: true,
			},
			
			columns:  [
					{ dataIndex:"idtitle", text: "id", width: 50 },
					{ dataIndex:"article", text: "Article", width: 100 },
					{ dataIndex:"oem", text: "Oem", width: 100},
					{ dataIndex:"title", text: "Title", width: 150, },
					{ dataIndex:"Warehouse", text: "Warehouse", width: 100, },
					{ dataIndex:"Currency", text: "Currency", width: 100, },
					{ dataIndex:"amount", text: "Qty", width: 50 },
					{ dataIndex:"price", text: "Price", width: 50 },
					{ dataIndex:"Sum", text: "Sum", width: 50 },
					{ xtype:"actioncolumn", text: "Re-simulate", width: 25,
						items: [
							{xtype: 'button', icon: "images/icons/Edit.png", width: 30, tooltip: 'Re-simulate Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по 
									FResimulateWindowOpen(rec,'Oversale Items');
								} 
							}, 
						]
					},{
						xtype:"actioncolumn", text: "Delete", width: 25, 
						items: [
							{xtype: 'button', icon: "images/icons/Delete.png", width: 30, tooltip: 'Delete Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по номеру строки
									FRestoreAvailability(rec.get('idtitle'),rec.get('Warehouse'),rec.get('amount'));
									grid.store.remove(rec);      FRecalcAll();          
								}
							}, 
						
						]
					}	
				],
			
		});
		
		var ShortageItems=Ext.create("Ext.grid.Panel",{
			title: 'Shortage items (0)',
			store: ShortageItemsStore,
			
			columns:  [
					{ dataIndex:"idtitle", text: "id", width: 50 },
					{ dataIndex:"article", text: "Article", width: 100 },
					{ dataIndex:"oem", text: "Oem", width: 100},
					{ dataIndex:"title", text: "Title", width: 150, },
					{ dataIndex:"Warehouse", text: "Warehouse", width: 100, },
					{ dataIndex:"Currency", text: "Currency", width: 100, },
					{ dataIndex:"amount", text: "Qty", width: 50 },
					{ dataIndex:"price", text: "Price", width: 50 },
					{ dataIndex:"Sum", text: "Sum", width: 50 },
					/*{ xtype:"actioncolumn", text: "Re-simulate", width: 25,
						items: [
							{xtype: 'button', icon: "images/icons/Edit.png", width: 30, tooltip: 'Re-simulate Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по 
									FResimulateWindowOpen(rec,'Shortage Items');
								} 
							}, 
						]
					},*/
					{
						xtype:"actioncolumn", text: "Delete", width: 25, 
						items: [
							{xtype: 'button', icon: "images/icons/Delete.png", width: 30, tooltip: 'Delete Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по номеру строки
									//FRestoreAvailability(rec.get('idtitle'),rec.get('Warehouse'),rec.get('amount'));
									grid.store.remove(rec);    FRecalcAll();            
								}
							}, 
						
						]
					}	
				],
		});
		
	
		