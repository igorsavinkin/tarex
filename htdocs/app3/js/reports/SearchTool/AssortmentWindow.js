	Ext.define("QtyField",{
				extend: "Ext.form.field.Number", 
				allowDecimals: false,
				minValue: 1,
				fieldLabel: 'Qty',
			});
			
			Ext.define("PriceField", {
				extend: "Ext.form.field.Number",
				decimalPrecision: 3,
				minValue: 1,
				fieldLabel: 'Price',
			});	
			
			Ext.define("WarehouseField", {
				extend: "Ext.form.field.Text",
				fieldLabel: 'Warehouse selected:',
			});
			
			Ext.define("AddButton",{
				extend: "Ext.Button",
				icon: 'images/icons/DoReport.png',
				text: 'Add to order',
				
				initComponent:function(){
				
					
					this.callParent();
				
				}
			});
			
			
			
			
			Ext.define("CloseButton",{
				extend: "Ext.Button",
				icon: 'images/icons/Close.png',
				text: 'Close',
				//handler: function() {
				//	close();
				//}
				 initComponent:function(){
					//this.addEvents(['CloseButton']);
					this.callParent();
				 }
			}); 
				
//  Currency -- ComboBoxes & store 
			var CurrencyStore = Ext.create('appMain.Store.UniversalStore', {
				modelName:"Currency",     
				autoLoad: true,
				params: '&log=0&compareField=name', 
				fields: [
					 { name: 'name', type: 'string'},
				     { name: 'id',         type: 'int'     },
				],			 
			});
			 
			var CurrencyComboBox= Ext.create('Ext.form.ComboBox', {
				fieldLabel: 'Selling currency:',
				store: CurrencyStore,
				queryMode: 'remote',
				displayField: 'name',
				valueField: 'id', 
			//	allowBlank: false,	// добавляем валидацию на то что поле не пустое			
				msgTarget: 'side',
			});
		 			
	
	
	
//=== Окно добавления ассортимента или его перемещения между гридами ===	
			Ext.define("AssortmentWindow2",{
					extend: 'Ext.window.Window',
					ident: '',
					height: 250,
					width: 350,
					autoDestroy: true, 
					closable: true,
					Resimulate: '',
					ActiveTab: '',
					//layout: 'fit',
					initComponent:function(){ 
						
						this.title='Enter Qty & Price for '+this.ident;
						this.addListener('CloseButton' , function(){  
							this.close();
						} , this); 
				
						this.FieldText1=Ext.create("Ext.form.field.Text",{ 
						}); 
						
						this.AddButton=Ext.create("Ext.Button",{
							text: 'Add',
							icon: 'images/icons/DoReport.png',
							handler: function() {
								//this.FieldTextSelected=FieldText1.getValue();
								//console.log(this.FieldTextSelected);
								if (this.Resimulate!=''){
									FChange(this);
									FAdd(this); 
								}else{
									FAdd(this);
								} 
								this.fireEvent('CloseButton');
							},
							scope:this
						});
						
						this.CloseButton=Ext.create("Ext.Button",{
							text: 'Close',
							icon: 'images/icons/Close.png',
							handler: function() { 
								this.fireEvent('CloseButton');
							},scope:this
						});
						
						this.PriceField=Ext.create("PriceField");
						this.QtyField=Ext.create("QtyField");
						this.QtyField.setValue('1');
						this.PriceField.setValue(this.priceS);
						this.price=this.priceS;
						//this.amount=this.priceS;
					
			
			
					this.ComboBoxWarehouse=Ext.create("Ext.form.field.ComboBox",{
						fieldLabel: 'Warehouse:',
						store: WarehouseStore,
						queryMode: 'local',
						displayField: 'name',
						valueField: 'name',
					});
					
					this.ComboBoxTabSelector=Ext.create("Ext.form.field.ComboBox",{
						fieldLabel: 'Default tab:',
						//store: ['Regular Items','New Qty Items','Market Price Items','Items Under Offer','Oversale Items','Shortage Items'],
						store: ['Regular Items','Market Price Items','Oversale Items'],
						queryMode: 'local',
						value: 'Regular Items',
					});
					
					this.CurrencyLabel=Ext.create("Ext.form.Label",{
						text: ' Currency: '+this.Currency,
					});
					
					this.RecommendedPriceLabel=Ext.create("Ext.form.Label",{
						text: 'Recommended price: '+this.priceS,
					});
					
					this.WindowToolbar=Ext.create("Ext.toolbar.Toolbar",{ 
						items: [this.AddButton,this.CloseButton]
					
					});
					
					if (this.Resimulate!=''){
						//Опрределим реальный остаток
						var AssortmentStoreTemporary = Ext.create('appMain.Store.UniversalStore',{ 
							modelName:"Assortment", 
							params: '&log=0&id='+this.ident,	
							fields: [
								{name: 'warehouse', type: 'string'}, 
							],
						});
						//var WarehouseTemporary='';
						AssortmentStoreTemporary.load(function(records) {
									   
						   Ext.each(records, function(record){
								//var WarehouseTemporary=record.get('warehouse');
								//console.log('WarehouseTemporary '+WarehouseTemporary);
								WarehouseTemporary=record.get('warehouse'); 
								console.log('this.warehouse '+WarehouseTemporary);
						   }); 
						}); 
						
						
					//=== ПЕРЕРАСПРЕДЕЛЕНИЕ ПОЗИЦИЙ ===
						//console.log(this.Resimulate);
						this.ComboBoxTabSelector.fieldLabel= 'Transfer to tab:';
						this.ComboBoxWarehouse.fieldLabel= 'Transfer to warehouse:';
						this.QtyField.maxValue= this.MaxAmount;
						this.ComboBoxTabSelector.setValue(this.ActiveTab);
						this.ComboBoxWarehouse.setValue(this.Warehouse);
						
						this.PriceField.setValue(this.Price);
						this.CurrencyLabel.setText(' Currency: '+this.Currency);
						
						if (this.RecomendedPrice!='' && this.RecomendedPrice>0)
							this.RecommendedPriceLabel.setText('Recommended price: '+this.RecomendedPrice);
						else this.RecommendedPriceLabel.setText('Recommended price: '+this.Price);
						
						this.AddButton.text='Transfer'; 
						
						this.items= [this.QtyField,this.PriceField,this.RecommendedPriceLabel,this.ComboBoxTabSelector,this.ComboBoxWarehouse,this.CurrencyLabel];
						this.dockedItems= this.WindowToolbar;
						
					}else{ 
						//var notes=record.get("notes");
						
						//=== ЗАКЛАДКА ПО УМОЛЧАНИЮ ПРИ ОТКРЫТИИ ОКНА ===
						var pos = this.notes.indexOf('UO');
					
						//console.log('pos'+pos+' notes '+notes);
						if(pos!=-1){
							//console.log(record.get("notes"));	
							this.ComboBoxTabSelector.setValue("Items Under Offer");
							this.ComboBoxTabSelector.disable();
						}else if (this.notes=="NI") {
							this.ComboBoxTabSelector.setValue("New Qty Items");
							this.ComboBoxTabSelector.disable();
							//return "row-error";
						}else if (this.notes=="SM") {
							//
						}
						//=== Склад по умолчанию ===
						var SP=this.warehouse.indexOf('=');
						if(SP!=-1){
							this.ComboBoxWarehouse.setValue(this.warehouse.substr(0,SP));
						}
						
						WarehouseTemporary=this.warehouse;
						this.items= [this.QtyField,this.PriceField,this.RecommendedPriceLabel,this.ComboBoxTabSelector,this.ComboBoxWarehouse,this.CurrencyLabel,]; 
						
						
						this.dockedItems= this.WindowToolbar;
 							
						
					}
							
						this.callParent();
						
						
						
					}
					//title: 'Enter Qty & Price for ',
					
					//closeAction: 'hide',
					//ident: '',
				
					
			});
			