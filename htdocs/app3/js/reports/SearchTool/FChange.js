
	
	
	function FChange(element){
		var DefaultTab=element.ActiveTab;
		//console.log('FChange '+ DefaultTab);
		
		if (DefaultTab=='Regular Items') {StoreToAdd=RegularItemsStore; StoreToAddPanel=RegularItems;}
		if (DefaultTab=='New Qty Items') {StoreToAdd=NewQtyItemsStore; StoreToAddPanel=NewQtyItems;}
		if (DefaultTab=='Items Under Offer') {StoreToAdd=ItemsUnderOfferStore; StoreToAddPanel=ItemsUnderOffer;}
		if (DefaultTab=='Market Price Items') {StoreToAdd=MarketPriceItemsStore; StoreToAddPanel=MarketPriceItems;}
		if (DefaultTab=='Oversale Items') {StoreToAdd=OversaleItemsStore; StoreToAddPanel=OversaleItems;}
		if (DefaultTab=='Shortage Items') {StoreToAdd=ShortageItemsStore; StoreToAddPanel=ShortageItems;}
		
		Ext.each(StoreToAdd.data.items, function(record){
           // console.log(record.get('id')+'/'+record.get('idtitle'));
			if (record.get('idtitle')==element.ident && record.get('Warehouse')==element.Warehouse && record.get('Currency')==element.Currency && record.get('Warehouse')==element.Warehouse && record.get('price')==element.Price  ){
				var Delta=record.get('amount')-element.QtyField.getValue();
				record.set('amount',Delta); 
				record.set('Sum',record.get('amount')*record.get('price')); 
				
				if (record.get('amount')==0)
					StoreToAdd.remove(record);  
			} 
		});
	
		FRecalcAll(); 
	};