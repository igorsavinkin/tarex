	/*	Ext.define('OrderModel', {
			extend: 'Ext.data.Model',
			fields: [
				{name: 'article', type: 'string'},
				{name: 'oem', type: 'string'}, 
				{name: 'title',  type: 'string'},				 // assortmentTitle,
				{name: 'description',  type: 'string'},
				{name: 'idtitle',   type: 'int'}, 		    	// id,
				{name: 'price', type: 'double'},			// price,
				{name: 'organizationId', type: 'int'},	// - ? 
				{name: 'amount', type: 'int'}, 				// assortmentAmount, 
				{name: 'Warehouse', type: 'string'},   // - ?
				{name: 'Currency', type: 'string'},		// - ?
				{name: 'Sum', type: 'double'},			// cost,
			], 		
			proxy: {
				type: 'memory',
				reader: {
					type: 'json',
					rootProperty: 'data'
				}
			}

		});	 */
		
		Ext.define('Eventcontent2', {
			extend: 'Ext.data.Model',
			fields: [		
				{name: 'id', type: 'int'},
		// eventid is omitted
				{name: 'assortmentId',   type: 'int'}, 
				{name: 'assortmentTitle',  type: 'string'},	
				{name: 'assortmentAmount', type: 'int'}, 	 
		// discount is omitted
				{name: 'price', type: 'double'},			 
				{name: 'cost', type: 'double'},			 
				{name: 'organizationId', type: 'int'},	  
				{name: 'warehouseId', type: 'int'},		 
				{name: 'currencyId', type: 'int'},			 
				{name: 'userId', type: 'int'},		 
				{name: 'contractorId', type: 'int'},			 
				{name: 'contractorId', type: 'int'},		 
				{name: 'categoryId', type: 'string'},
				{name: 'RecommendedPrice', type: 'double'}, 
				{name: 'Barcode',  type: 'int'},		
			], 
		});	  
			
//=== Order ЗАКАЗ ===
		var RegularItemsStore=Ext.create("appMain.Store.UniversalStore",{
				modelName:"Eventcontent2", 
				model:"Eventcontent2", 
				params: '&log=0',	
				autoLoad: true,
				autoSync: true,
				pageSize: 10,				
		});
		var NewQtyItemsStore=Ext.create("appMain.Store.UniversalStore",{
				modelName:"Eventcontent2", 
				model:"Eventcontent2", 
				params: '&log=0',	
				autoLoad: true,
				autoSync: true,
				pageSize: 10,				
		});
		var MarketPriceItemsStore=Ext.create("appMain.Store.UniversalStore",{
				modelName:"Eventcontent2", 
				model:"Eventcontent2", 
				params: '&log=0',	
				autoLoad: true,
				autoSync: true,
				pageSize: 10,				
		});
		var ItemsUnderOfferStore=Ext.create("appMain.Store.UniversalStore",{
				modelName:"Eventcontent2", 
				model:"Eventcontent2", 
				params: '&log=0',	
				autoLoad: true,
				autoSync: true,
				pageSize: 10,				
		});
		var OversaleItemsStore=Ext.create("appMain.Store.UniversalStore",{
				modelName:"Eventcontent2", 
				model:"Eventcontent2", 
				params: '&log=0',	
				autoLoad: true,
				autoSync: true,
				pageSize: 10,				
		});
		var ShortageItemsStore=Ext.create("appMain.Store.UniversalStore",{
				modelName:"Eventcontent2", 
				model:"Eventcontent2", 
				params: '&log=0',	
				autoLoad: true,
				autoSync: true,
				pageSize: 10,				
		});
		var SpecialOrderStore=Ext.create("appMain.Store.UniversalStore",{
				modelName:"Eventcontent2", 
				model:"Eventcontent2", 
				params: '&log=0',	
				autoLoad: true,
				autoSync: true,
				pageSize: 10,				
		});
	/*	var RegularItemsStore=Ext.create("Ext.data.Store",{
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
		var SpecialOrderStore=Ext.create("Ext.data.Store",{
			model: 'OrderModel',
		}); 
	 */
		
		
		var SpecialOrderButtonAdd=Ext.create("Ext.Button",{
				icon: 'images/icons/CreateNew.png',
				 handler: function() {
					var rec = new Eventcontent2({
						//number: TextFieldNewAnalog.getValue(),
					});					
					SpecialOrderStore.insert(0, rec);
					FRecalcAll();	 // FRecalcAll_n.js				
				}
		});
			
			
		var SpecialOrderItems=Ext.create("Ext.grid.Panel",{
			title: 'Special Order (0)',
			disabled: true,
			autoDestroy: false,
			dockedItems: [SpecialOrderButtonAdd],
			
			store: SpecialOrderStore,
			plugins: {
				ptype: 'cellediting',
				clicksToEdit: 1
			},	
				
			columns:  [
					//{ dataIndex:"idtitle", text: "id", width: 50 },
					{ dataIndex:"title", text: "Title", width: 150, editor:  'textfield',},
					{ dataIndex:"description", text: "Description", width: 150, editor:  'textfield',},
					{ dataIndex:"amount", text: "Qty", width: 50, editor: 'numberfield',
						allowDecimals: false, 	minValue: 1, 
				
						
					},
					{ dataIndex:"price", text: "Market price", width: 50, editor:  'numberfield',
						decimalPrecision: 3,
						minValue: 1,
				
						
					
					},
					{ dataIndex:"Sum", text: "Sum", width: 50,
						renderer: function(value,metaData ,record ){
							
							//return record.get('amount')*record.get('price');
							var sum=record.get('amount')*record.get('price');
							//record.set("Sum",sum);
							
							//console.log('Sum '+record.get("Sum"));
							
							FRecalcAll();
							
							//return record.get("Sum");
							return sum;
							
							
						}
					
					},
					{
						xtype:"actioncolumn", text: "Delete", width: 25, 
						items: [
							{xtype: 'button', icon: "images/icons/Delete.png", width: 30, tooltip: 'Delete Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  
									//FRestoreAvailability(rec.get('idtitle'),rec.get('Warehouse'),rec.get('amount'));
									grid.store.remove(rec);  
									FRecalcAll();
								}
							}, 
						]
					}
			]
		});
		
		
		
		
		var RegularItems=Ext.create("Ext.grid.Panel",{
			title: 'Regular Items (0)',
			store: RegularItemsStore,
			//autoDestroy: false,
			//hideMode: 'visibility',
			//closeAction: 'hide',

			columns:  [ 
				{ dataIndex: 'id',  text:  'id' }, 
				{ dataIndex: 'assortmentId',  text:  'assortmentId' }, 
				{ dataIndex: 'assortmentTitle',  text:  'assortmentTitle'},	
				{ dataIndex: 'assortmentAmount',  text:  'assortmentAmount'},  		 
				{ dataIndex: 'price',  text:  'price' }, 
				{ dataIndex: 'cost',  text:  'cost' },		 
				{ dataIndex: 'organizationId',  text:  'organizationId' },	// 
				{ dataIndex: 'warehouseId',  text:  'warehouseId' },		// 
				{ dataIndex: 'currencyId',  text:  'currencyId'},			// 
				{ dataIndex: 'userId',  text:  'userId' },			// 
				{ dataIndex: 'contractorId',  text:  'contractorId' },			//   
				{ dataIndex: 'categoryId',  text:  'categoryId'},
				{ dataIndex: 'RecommendedPrice',  text:  'RecommendedPrice'}, 
				{ dataIndex: 'Barcode',  text:  'Barcode'},	
				/*	{ dataIndex:"idtitle", text: "id", width: 50 },
					{ dataIndex:"article", text: "Article", width: 100 },
					{ dataIndex:"oem", text: "Oem", width: 100},
					{ dataIndex:"title", text: "Title", width: 150, },
					{ dataIndex:"Warehouse", text: "Warehouse", width: 100, },
					{ dataIndex:"Currency", text: "Currency", width: 100, },
					{ dataIndex:"amount", text: "Qty", width: 50 },
					{ dataIndex:"price", text: "Price", width: 50 },
					{ dataIndex:"Sum", text: "Sum", width: 50 },
					*/
					{ xtype:"actioncolumn", text: "Re-simulate", width: 25,
						items: [
							{xtype: 'button', icon: "images/icons/Edit.png", width: 30, tooltip: 'Re-simulate Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по 
									FResimulateWindowOpen(rec,'Regular Items'); // FResimulate_n.js
								} 
							}, 
						]
					},{
						xtype:"actioncolumn", text: "Delete", width: 25, 
						items: [
							{xtype: 'button', icon: "images/icons/Delete.png", width: 30, tooltip: 'Delete Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по номеру строки
									FRestoreAvailability(rec.get('id'),rec.get('warehouseId'),rec.get('assortmentAmount')); // FRestoreAvailability_n.js
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
				{ dataIndex: 'id',  text:  'id' }, 
				{ dataIndex: 'assortmentId',  text:  'assortmentId' }, 
				{ dataIndex: 'assortmentTitle',  text:  'assortmentTitle'},	
				{ dataIndex: 'assortmentAmount',  text:  'assortmentAmount'},  		 
				{ dataIndex: 'price',  text:  'price' }, 
				{ dataIndex: 'cost',  text:  'cost' },		 
				{ dataIndex: 'organizationId',  text:  'organizationId' },	// 
				{ dataIndex: 'warehouseId',  text:  'warehouseId' },		// 
				{ dataIndex: 'currencyId',  text:  'currencyId'},			// 
				{ dataIndex: 'userId',  text:  'userId' },			// 
				{ dataIndex: 'contractorId',  text:  'contractorId' },			//   
				{ dataIndex: 'categoryId',  text:  'categoryId'},
				{ dataIndex: 'RecommendedPrice',  text:  'RecommendedPrice'}, 
				{ dataIndex: 'Barcode',  text:  'Barcode'},	
					
					
			/*		{ dataIndex:"idtitle", text: "id", width: 50 },
					{ dataIndex:"article", text: "Article", width: 100 },
					{ dataIndex:"oem", text: "Oem", width: 100},
					{ dataIndex:"title", text: "Title", width: 150, },
					{ dataIndex:"Warehouse", text: "Warehouse", width: 100, },
					{ dataIndex:"Currency", text: "Currency", width: 100, },
					{ dataIndex:"amount", text: "Qty", width: 50 },
					{ dataIndex:"price", text: "Price", width: 50 },
					{ dataIndex:"Sum", text: "Sum", width: 50 },
					*/
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
					
					{	xtype:"actioncolumn", text: "Delete", width: 25, 
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
		});	// end of 	NewQtyItems
		
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
		
	
		var OrderTypeRadio=Ext.create("Ext.form.FieldContainer",{
					defaultType: 'radiofield',
					width: 200, 
					bodyPadding: 1,
					fieldLabel : 'Order type',
					items: [ 
						//1,2
						{   
							boxLabel  : 'Normal',
							name      : 'order',
							checked: true,
							inputValue: 'Normal',
							id        : 'radio1',
							listeners: {
								'change': function( o, newValue, oldValue, eOpts ){
									//console.log('Normal '+newValue);
									
									//OrderPanel.removeAll();
									if(newValue==true){
		
										RegularItems.enable();
										NewQtyItems.enable();
										MarketPriceItems.enable();
										ItemsUnderOffer.enable();
										OversaleItems.enable();
										ShortageItems.enable();
										SpecialOrderItems.disable();  
									
									}
								}
							}
							
						},			
						{   
							boxLabel  : 'Special',
							name      : 'order',
							inputValue: 'Special',
							id        : 'radio2',
							listeners: {
								'change': function( o, newValue, oldValue, eOpts ){
									//console.log('Special '+newValue);
									
									
									//OrderPanel.removeAll();
									//NewQtyItems.close();
									if(newValue==true){
										RegularItems.disable();
										NewQtyItems.disable();
										MarketPriceItems.disable();
										ItemsUnderOffer.disable();
										OversaleItems.disable();
										ShortageItems.disable();
										SpecialOrderItems.enable();
									}
								}
							}
						}, 
					], 
				});