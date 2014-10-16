Ext.ns('appMain');		



appMain.application = Ext.application({


	

    autoCreateViewport:false,
    name: 'MyApp',
    launch: function() {  
	
	
		
		
		
		
		
		  
		  
//=== AssortmentStore
		
		
		
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
		
			
		
		
		/*var MainPanel = Ext.create("Ext.panel.Panel",{
			renderTo: 'Searchtool',
			autoScroll: true, 
			items: [MainGrid]
		});*/
		
			
		

//===  ПОИСК ПОЗИЦИИ ===		 
		
		
		//===  ПОИСК Контрагента ===		
		
		
		
		
		
//=== ДОБАВЛЕНИЕ ПОЗИЦИИ В ЗАКАЗ ===

	var RegularItemsSum=0; RegularItemsCount=0;
	var NewQtyItemsSum=0; NewQtyItemsCount=0;
	var MarketPriceItemsSum=0; MarketPriceItemsCount=0;
	var ItemsUnderOfferSum=0; ItemsUnderOfferCount=0;
	var OversaleItemsSum=0; OversaleItemsCount=0;
	
			
			
		
		
	
