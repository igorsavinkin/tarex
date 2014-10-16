		
				
	function FAdd(element){
		
		//console.log('FAdd');
		
			//1) Долг клиента по позиции превышен или нет
			var price=element.PriceField.getValue();
			var amount= element.QtyField.getValue();
			var Sum=price*amount;

			//Подсчет уже заказанного в заказе в валюте добавляемой позиции
			var WarehouseSelected=element.ComboBoxWarehouse.getValue();
					
			var AlredyOrderedinCurrency=0;
			for (var i = 0; i < AlredyOrdered.length; i++) {
				var Currency= AlredyOrdered[i].substr(0,3);
				var Limit= AlredyOrdered[i].substr(4);
				if (element.Currency==Currency) {
					AlredyOrderedinCurrency=Limit;
				}
			}

			//Определение количества которое можно добавить без перелимита 
			var LimitOk=0; AmountOk=0;
			for (var i = 0; i < ContractorSelectedLimit.length; i++) {
				var Currency= ContractorSelectedLimit[i].substr(0,3);
				var Limit= ContractorSelectedLimit[i].substr(4);
				if (element.Currency==Currency) {
					if (Limit-AlredyOrderedinCurrency>=Sum)	{LimitOk=Sum; AmountOk=amount;}
					else {	 AmountOk=parseInt((Limit-AlredyOrderedinCurrency)/price); 
						LimitOk=AmountOk*price;
					}
				}
			} 

			
			
			//2) Оставшееся для добавления количество > наличия или нет. Всё что больше добавляем в shortage
			var WarehouseString=0;
			
			//Опрределим реальный остаток
			/*var AssortmentStoreTemporary = Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Assortment", 
				params: '&log=0&id='+element.ident,	
				fields: [
					{name: 'warehouse', type: 'string'}, 
				],
			});
			var WarehouseTemporary='';
			AssortmentStoreTemporary.load(function(records) {
                           
			   Ext.each(records, function(record){
					WarehouseTemporary=record.get('warehouse');
					console.log('WarehouseTemporary '+WarehouseTemporary);
			   });
            }); 
			*/
			
			//временно
			//var WarehouseTemporary=''+element.warehouse;
 			//console.log('WarehouseTemporary '+WarehouseTemporary);
			 
			//SP=;
			SP=WarehouseTemporary.indexOf(WarehouseSelected);
			if(SP!=-1){
				WarehouseString=WarehouseTemporary.substr(SP);
				SP=WarehouseString.indexOf(',');
				if (SP!=-1){
					WarehouseString=WarehouseString.substr(0,SP);
				}
				SP=WarehouseString.indexOf('=');
				if (SP!=-1){
					WarehouseString=WarehouseString.substr(SP+1);
				}
			}
			
			//console.log(element.warehouse+'/'+element.amount+'/'+amount+'WarehouseString'+WarehouseString+'amount'+amount);
			if (amount>WarehouseString){ 
				var Delta=amount-WarehouseString;
			//	console.log('Delta '+Delta);
				var Sum=Delta*price;
				
				var rec = new OrderModel({
					article: element.article,
					oem: element.oem,
					title: element.title1,
					idtitle: element.ident,
					amount: Delta,
					price: price,
					Warehouse: WarehouseSelected,
					Sum: Sum,
					organizationId: element.organizationId,
					Currency: element.Currency,
				});
				
				
				var AddedAmount=0;
				var ShortageItemsCount=0; ShortageItemsSum=0;
				//Если в этой закладке уже есть позиция с такой ценой, валютой, складом, ид то увеличиваем кол-во
				Ext.each(ShortageItemsStore.data.items, function(record){
					ShortageItemsCount+=record.get('amount');
					ShortageItemsSum+=record.get('Sum');
					//console.log(record.get('price')+'/'+rec.get('price')+'/'+record.get('id')+'/'+rec.get('id'));
                    if (record.get('idtitle')==element.ident && record.get('price')==price && record.get('Currency')==element.Currency && record.get('Warehouse')==WarehouseSelected) 
					{	
						record.set('amount',record.get('amount')+Delta);
						record.set('Sum',record.get('amount')*record.get('price'));
						//console.log(record.get('amount'));
						AddedAmount=1;
					}
				});
				
				//Если не нашли позицию то добавляем новую
				if (AddedAmount==0){
					//console.log('AddedAmount '+AddedAmount);
					ShortageItemsStore.insert(0, rec);
				}
				ShortageItemsCount+=Delta;
				ShortageItemsSum+=Sum;
				
				ShortageItems.setTitle('Shortage Items ('+ShortageItemsCount+'/'+ShortageItemsSum+')');
				amount=amount-Delta;
				
				if (amount==0) 	{FRecalcAll(); return;}
				
			}
			
			//1) Добавление в закладку Oversale разницы (перелимита заказанного клиентом)
			if(AmountOk<amount){
				var Delta=amount-AmountOk;
				//console.log('Delta '+Delta);
				var Sum=Delta*price;
				
				var rec = new OrderModel({
					article: element.article,
					oem: element.oem,
					title: element.title1,
					idtitle: element.ident,
					amount: Delta,
					price: price,
					Warehouse: WarehouseSelected,
					Sum: Sum,
					organizationId: element.organizationId,
					Currency: element.Currency,
				});

				
				var Added=0;
				var OversaleItemsCount=0; OversaleItemsSum=0;
				//Если в этой закладке уже есть позиция с такой ценой, валютой, складом, ид то увеличиваем кол-во
				Ext.each(OversaleItemsStore.data.items, function(record){
						OversaleItemsCount+=record.get('amount');
					OversaleItemsSum+=record.get('Sum');
					
					if (record.get('idtitle')==element.ident && record.get('price')==price && record.get('Currency')==element.Currency && record.get('Warehouse')==WarehouseSelected) 
					{	
						record.set('amount',record.get('amount')+Delta);
						record.set('Sum',record.get('amount')*record.get('price'));
						Added=1;
					}
				});
				
				//Если не нашли позицию то добавляем новую
				if (Added==0){
					OversaleItemsStore.insert(0, rec);
				}
				OversaleItemsCount+=Delta;
				OversaleItemsSum+=Sum;
				OversaleItems.setTitle('Oversale Items ('+OversaleItemsCount+'/'+OversaleItemsSum+')');
				
				
			}
			
			//=== Списание со склада ===
			var Delta=element.amount-amount;
			//console.log('Delta '+Delta);
			
			var TemporaryWarehouseArray=element.warehouse.split(',');
			for (var i = 0; i < TemporaryWarehouseArray.length; i++) {
				var SS=TemporaryWarehouseArray[i].indexOf(WarehouseSelected);
				if(SS!=-1){
					SS=TemporaryWarehouseArray[i].indexOf('=');
					if(SS!=-1){
						var TemporaryCurrency=TemporaryWarehouseArray[i].substr(0,SS);
						var TemporaryValue=parseInt(TemporaryWarehouseArray[i].substr(SS+1));
						// console.log(TemporaryCurrency+'/'+TemporaryValue);
						TemporaryValue-=amount;
						TemporaryWarehouseArray[i]=TemporaryCurrency+'='+TemporaryValue;
						//console.log('TemporaryWarehouseArray[i] '+TemporaryWarehouseArray[i]);
					}
				}
			}
			
			//console.log('TemporaryWarehouseArray '+TemporaryWarehouseArray);
			//return;
			 
			Ext.Ajax.request({ 
			
				url:'index.php?r=Backend/Save&Table=Assortment&availability='+Delta+'&id=' + element.ident+'&warehouse='+TemporaryWarehouseArray.join(','),
				scope:this, 
				success: function(response){
					//var text = response.responseText;
					// process server response here
					AssortmentStore.reload(); 
				}
			});			
			
			//return
			
			amount=AmountOk;
			if (amount==0) 	{FRecalcAll(); return;}
			
			
			
			 
			//3) При цене ниже рекомендованной 
			if(element.priceS>price){
				var Sum=amount*price;
				
				var rec = new OrderModel({
					article: element.article,
					oem: element.oem,
					title: element.title1,
					idtitle: element.ident,
					amount: amount,
					price: price,
					RecomendedPrice: element.priceS,
					Warehouse: WarehouseSelected,
					Sum: Sum,
					organizationId: element.organizationId,
					Currency: element.Currency,
				});
				
				
				var AddedAmount=0;
				var MarketPriceItemsCount=0; ShortageItemsSum=0;
				//Если в этой закладке уже есть позиция с такой ценой, валютой, складом, ид то увеличиваем кол-во
				Ext.each(MarketPriceItemsStore.data.items, function(record){
					MarketPriceItemsCount+=record.get('amount');
					MarketPriceItemsSum+=record.get('Sum');
					//console.log(record.get('price')+'/'+rec.get('price')+'/'+record.get('id')+'/'+rec.get('id'));
                    if (record.get('idtitle')==element.ident && record.get('price')==price && record.get('Currency')==element.Currency && record.get('Warehouse')==WarehouseSelected) 
					{	
						record.set('amount',record.get('amount')+amount);
						record.set('Sum',record.get('amount')*record.get('price'));
						//console.log(record.get('amount'));
						AddedAmount=1;
					}
				});
				
				//Если не нашли позицию то добавляем новую
				if (AddedAmount==0){
					//console.log('AddedAmount '+AddedAmount);
					MarketPriceItemsStore.insert(0, rec);
				}
				MarketPriceItemsCount+=amount;
				MarketPriceItemsSum+=Sum;
				
				MarketPriceItems.setTitle('Market Price Items ('+MarketPriceItemsCount+'/'+MarketPriceItemsSum+')');
				//amount=amount-Delta;
			
			}else{
				var DefaultTab=element.ComboBoxTabSelector.getValue();
				var StoreToAdd=RegularItemsStore; StoreToAddPanel=RegularItems;
				
				if (DefaultTab=='New Qty Items') {StoreToAdd=NewQtyItemsStore; StoreToAddPanel=NewQtyItems;}
				if (DefaultTab=='Items Under Offer') {StoreToAdd=ItemsUnderOfferStore; StoreToAddPanel=ItemsUnderOffer;}
				if (DefaultTab=='Market Price Items') {StoreToAdd=MarketPriceItemsStore; StoreToAddPanel=MarketPriceItems;}
				if (DefaultTab=='Oversale Items') {StoreToAdd=OversaleItemsStore; StoreToAddPanel=OversaleItems;}
				if (DefaultTab=='Shortage Items') {StoreToAdd=ShortageItemsStore; StoreToAddPanel=ShortageItems;}
				
				var Sum=amount*price;
				
				var rec = new OrderModel({
					article: element.article,
					oem: element.oem,
					title: element.title1,
					idtitle: element.ident,
					amount: amount,
					price: price,
					Warehouse: WarehouseSelected,
					Sum: Sum,
					organizationId: element.organizationId,
					Currency: element.Currency,
				});
				
				
				var AddedAmount=0;
				var ItemsCount=0; ItemsSum=0;
				//Если в этой закладке уже есть позиция с такой ценой, валютой, складом, ид то увеличиваем кол-во
				Ext.each(StoreToAdd.data.items, function(record){
					ItemsCount+=record.get('amount');
					ItemsSum+=record.get('Sum');
					//console.log(record.get('price')+'/'+rec.get('price')+'/'+record.get('id')+'/'+rec.get('id'));
                    if (record.get('idtitle')==element.ident && record.get('price')==price && record.get('Currency')==element.Currency && record.get('Warehouse')==WarehouseSelected) 
					{	
						record.set('amount',record.get('amount')+amount);
						record.set('Sum',record.get('amount')*record.get('price'));
						//console.log(record.get('amount'));
						AddedAmount=1;
					}
				});
				
				//Если не нашли позицию то добавляем новую
				if (AddedAmount==0){
					//console.log('AddedAmount '+AddedAmount);
					StoreToAdd.insert(0, rec);
				}
				ItemsCount+=amount;
				ItemsSum+=Sum;
				
				StoreToAddPanel.setTitle(DefaultTab+' ('+ItemsCount+'/'+ItemsSum+')');
			
				
				
			} 
		FRecalcAll();
		
			
			
	};