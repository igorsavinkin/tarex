function FRestoreAvailability(ident,WarehouseSelected,amount){
			var AssortmentStoreTemporary = Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Assortment", 
				params: '&log=0&id='+ident,	
				fields: [
					{name: 'warehouse', type: 'string'}, 
					{name: 'availability', type: 'int'}, 
				],
			});
			var WarehouseTemporary='';
			AssortmentStoreTemporary.load(function(records) {
						   
			   Ext.each(records, function(record){
					WarehouseTemporary=record.get('warehouse');
					var AvailabilityTemporary=record.get('availability');
					var Delta=AvailabilityTemporary+amount;
					
					var TemporaryWarehouseArray=WarehouseTemporary.split(',');
					for (var i = 0; i < TemporaryWarehouseArray.length; i++) {
						var SS=TemporaryWarehouseArray[i].indexOf(WarehouseSelected);
						if(SS!=-1){
							SS=TemporaryWarehouseArray[i].indexOf('=');
							if(SS!=-1){
								var TemporaryCurrency=TemporaryWarehouseArray[i].substr(0,SS);
								var TemporaryValue=parseInt(TemporaryWarehouseArray[i].substr(SS+1));
								// console.log(TemporaryCurrency+'/'+TemporaryValue);
								TemporaryValue+=amount;
								TemporaryWarehouseArray[i]=TemporaryCurrency+'='+TemporaryValue;
								//console.log('TemporaryWarehouseArray[i] '+TemporaryWarehouseArray[i]);
							}
						}
					}
					console.log('TemporaryWarehouseArray '+TemporaryWarehouseArray); 
					
					Ext.Ajax.request({ 
								
						url:'index.php?r=Backend/Save&Table=Assortment&availability='+Delta+'&id=' + ident+'&warehouse='+TemporaryWarehouseArray.join(','),
						scope:this, 
						success: function(response){
							//var text = response.responseText;
							// process server response here
							AssortmentStore.reload(); 
						}
					});

				});
			}); 		
		
						

	}	
		