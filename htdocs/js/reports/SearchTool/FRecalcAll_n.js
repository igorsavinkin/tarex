function FRecalcAll(){
			var TabsStore= ['Regular Items','New Qty Items','Market Price Items','Items Under Offer','Oversale Items','Shortage Items'];
			
			var TemporaryStore=''; 
			var TemporaryPanel=''; 
			var TemporaryBalance='', TemporaryAllBalance='';
			//AlredyOrdered=['EUR=0', 'USD=0', 'JPY=0']; AlredyOrderedWOversale=['EUR=0', 'USD=0', 'JPY=0'];
			AlredyOrdered=[]; AlredyOrderedWOversale=[];
			for (var i = 0; i < TabsStore.length; i++) {
				if (TabsStore[i]=='Regular Items') {TemporaryStore=RegularItemsStore; TemporaryPanel=RegularItems;}
				if (TabsStore[i]=='New Qty Items') {TemporaryStore=NewQtyItemsStore; TemporaryPanel=NewQtyItems;}
				if (TabsStore[i]=='Market Price Items') {TemporaryStore=MarketPriceItemsStore; TemporaryPanel=MarketPriceItems;}
				if (TabsStore[i]=='Items Under Offer') {TemporaryStore=ItemsUnderOfferStore; TemporaryPanel=ItemsUnderOffer;}
				if (TabsStore[i]=='Oversale Items') {TemporaryStore=OversaleItemsStore; TemporaryPanel=OversaleItems;}
				if (TabsStore[i]=='Shortage Items') {TemporaryStore=ShortageItemsStore; TemporaryPanel=ShortageItems;}
				
				//console.log(TabsStore[i]);
				var TabsStore2=TabsStore[i];
				var ItemsCount=0; 
				var ItemsSum=0; 
				Ext.each(TemporaryStore.data.items, function(record){
                    // console.log('record '+record.get('title')+'/'+record.get('amount'));
					//this.FieldTitle=  record.get('title');   
					ItemsCount+=record.get('assortmentAmount'); 
					ItemsSum+=record.get('cost'); 
					//console.log('TabsStore2 '+TabsStore2);
					if(TabsStore2!='Oversale Items'){
						var AddedAmount=0;
						for (var i = 0; i < AlredyOrdered.length; i++) {
							//console.log(AlredyOrdered[i]);
							var SS= AlredyOrdered[i].indexOf(record.get('currencyId'));
							if(SS!=-1){
								//console.log(element1[AlredyOrdered[i]]);
								var SS= AlredyOrdered[i].indexOf('=');
								if(SS!=-1){
									
									var CurrentCurrency=AlredyOrdered[i].substr(0,SS); 
									var CurrentCurrencyAmount=parseFloat(AlredyOrdered[i].substr(SS+1));
									//console.log('AlredyOrdered upd '+CurrentCurrencyAmount+'/'+CurrentCurrency+'/'+TabsStore[i]);
									
									CurrentCurrencyAmount+=record.get('cost'); 
									AlredyOrdered[i]=CurrentCurrency+'='+CurrentCurrencyAmount;
									
									AddedAmount=1; 
								} 
							}
						} 

						if (AddedAmount==0){
								AlredyOrdered.push(record.get('currencyId')+'='+record.get('cost')); 
								//console.log('AlredyOrdered add '+record.get('Currency')+'/'+record.get('Sum')+'/'+TabsStore[i]);
						}
					
					}
					
					var AddedAmount=0;
					for (var i = 0; i < AlredyOrderedWOversale.length; i++) {
						
						//console.log(AlredyOrdered[i]);
						var SS= AlredyOrderedWOversale[i].indexOf(record.get('currencyId'));
						if(SS!=-1){
							//console.log(element1[AlredyOrdered[i]]);
							var SS= AlredyOrderedWOversale[i].indexOf('=');
							if(SS!=-1){ 
								
								var CurrentCurrency=AlredyOrderedWOversale[i].substr(0,SS); 
								
								var CurrentCurrencyAmount=AlredyOrderedWOversale[i].substr(SS+1);
								SS = CurrentCurrencyAmount.indexOf(',');
								if(SS!=-1){ 
									CurrentCurrencyAmount=CurrentCurrencyAmount.substr(0,SS);
								}
								CurrentCurrencyAmount=parseFloat(CurrentCurrencyAmount);
								 
								//console.log('upd AlredyOrderedWOversale '+CurrentCurrencyAmount+'/'+CurrentCurrency+'/'+AlredyOrderedWOversale[i]);
								
								CurrentCurrencyAmount+=record.get('cost'); 
								AlredyOrderedWOversale[i]=CurrentCurrency+'='+CurrentCurrencyAmount;
								AddedAmount=1; 
								console.log(AlredyOrderedWOversale[i]+' AddedAmount '+AddedAmount);
								//console.log('2'+AlredyOrderedWOversale);
							} 
						}
					} 

					if (AddedAmount==0){
						AlredyOrderedWOversale.push(record.get('currencyId')+'='+record.get('cost')); 
						//console.log('add AlredyOrderedWOversale '+AlredyOrderedWOversale);
					}
				});
				TemporaryPanel.setTitle(TabsStore[i]+': ('+ItemsCount+'/'+ItemsSum+')');

				CustomerBalanceLabel.setText('Balance: '+AlredyOrdered); 
				CustomerBalanceLabelWOversale.setText('Balance width Oversale Items: '+AlredyOrderedWOversale); 
	
			}					
				
		}	