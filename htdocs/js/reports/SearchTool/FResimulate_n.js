function FResimulate(ContractorSelectedLimit){
		//var DefaultTab=element.ActiveTab;
		//console.log('FChange '+ DefaultTab);
		var TemporaryTabs=['Regular Items','New Qty Items','Items Under Offer','Market Price Items','Oversale Items'];
		
		
		for (var i = 0; i < TemporaryTabs.length; i++) {
			var DefaultTab= TemporaryTabs[i];
			if (DefaultTab=='Regular Items') {StoreToAdd=RegularItemsStore; StoreToAddPanel=RegularItems;}
			if (DefaultTab=='New Qty Items') {StoreToAdd=NewQtyItemsStore; StoreToAddPanel=NewQtyItems;}
			if (DefaultTab=='Items Under Offer') {StoreToAdd=ItemsUnderOfferStore; StoreToAddPanel=ItemsUnderOffer;}
			if (DefaultTab=='Market Price Items') {StoreToAdd=MarketPriceItemsStore; StoreToAddPanel=MarketPriceItems;}
			if (DefaultTab=='Oversale Items') {StoreToAdd=OversaleItemsStore; StoreToAddPanel=OversaleItems;}
			if (DefaultTab=='Shortage Items') {StoreToAdd=ShortageItemsStore; StoreToAddPanel=ShortageItems;}
			
			Ext.each(StoreToAdd.data.items, function(record){		
				//Подсчет уже заказанного в заказе в валюте добавляемой позиции
				//var WarehouseSelected=record.get('Warehouse');
				var Sum=record.get('Sum');
				var Price=record.get('price');
				var amount=record.get('amount');
						
				var AlredyOrderedinCurrency=0;
				for (var i = 0; i < AlredyOrdered.length; i++) {
					var Currency= AlredyOrdered[i].substr(0,3);
					var Limit= AlredyOrdered[i].substr(4);
					if (Currency==record.get('Currency')) {
						AlredyOrderedinCurrency=Limit;
					}
				}

				//Определение количества которое можно добавить без перелимита 
				var LimitOk=0; AmountOk=0;
				for (var i = 0; i < ContractorSelectedLimit.length; i++) {
					var Currency= ContractorSelectedLimit[i].substr(0,3);
					var Limit= ContractorSelectedLimit[i].substr(4);
					if (record.get('Currency')==Currency) {
						if (Limit-AlredyOrderedinCurrency>=Sum)	{LimitOk=Sum; AmountOk=amount;}
						else {	 AmountOk=parseInt((Limit-AlredyOrderedinCurrency)/price); 
							LimitOk=AmountOk*price;
						}
					}
				} 
				console.log('LimitOk '+LimitOk+'/'+AmountOk); 
				if (AmountOk<amount){
					var Delta=amount-AmountOk;
					var Sum=Delta*Price;
					
					var rec = new OrderModel({
						article: record.get('article'),
						oem: record.get('oem'),
						title: record.get('title'),
						idtitle: record.get('idtitle'),
						amount: Delta,
						price: Price,
						Warehouse: record.get('Warehouse'),
						Sum: Sum,
						organizationId: record.get('organizationId'),
						Currency: record.get('Currency'),
					});
					
					var Added=0;
					Ext.each(OversaleItemsStore.data.items, function(record1){
						if (record1.get('idtitle')==rec.get('idtitle') && record1.get('price')==rec.get('price') && record1.get('Currency')==rec.get('Currency') && record1.get('Warehouse')==rec.get('Warehouse')) 
						{	
							record1.set('amount',record1.get('amount')+Delta);
							record1.set('Sum',record1.get('amount')*Price);
							Added=1;
						}
					});
					
					//Если не нашли позицию то добавляем новую
					if (Added==0){
						OversaleItemsStore.insert(0, rec);
						console.log('Added to OversaleItemsStore');
					}
					
					//OversaleItemsStore.insert(0,rec);
					record.set('amount',AmountOk);
					record.set('Sum',record.get('amount')*Price);
					if(AmountOk==0) StoreToAdd.remove(record);
					
					FRecalcAll();
				} 
				
			});
			
		}
	}
	
	
	
	function FResimulateWindowOpen(rec, ActiveTab){
		this.ResimulateWindow=Ext.create('AssortmentWindow2', {
			//title: 'Hello',
			//height: 300,
			//width: 500,
			//layout: 'fit',
			ActiveTab: ActiveTab,
			Resimulate: 1,		
			MaxAmount: rec.get('assortmentAmount'),
			Price: rec.get('price'),
			ident: rec.get('id'),
			RecomendedPrice: rec.get('RecomendedPrice'),
			Warehouse: rec.get('warehouseId'),
			Currency: rec.get('currencyId'),
		//	article: rec.get('article'),
		//	oem: rec.get('oem'),
			title1: rec.get('assortmentTitle'),
			//ActiveTab: ActiveTab,
			//ActiveTab: ActiveTab,
		}); 
		this.ResimulateWindow.title='Re-simulate item id:'+rec.get('id');
		this.ResimulateWindow.show();
	} 
	//=== Assortment Window ===