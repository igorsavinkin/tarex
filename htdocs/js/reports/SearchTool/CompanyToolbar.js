//=== Company, Warehouse, ItemFamily
		var CompanyStore = Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Assortment", 
				params: '&log=0&distinct=1&fields=manufacturer',
				fields: [
					{name: 'manufacturer', type: 'string'},
				],
		});
		CompanyStore.load();
		
		var CompanyComboBox=Ext.create("Ext.form.field.ComboBox",{
			fieldLabel: 'Manufacturer',
			store: CompanyStore,
			queryMode: 'local',
			displayField: 'manufacturer',
			valueField: 'manufacturer',
			value: 'DEPO',
			listeners: {		
				select: {fn: function (combo, e){
						FFind();}					
				}				
			},			
		});	
		var ClearButtonCompanyComboBox=Ext.create("Ext.Button",{
			icon: 'images/icons/Close.png',
			 handler: function() {
				CompanyComboBox.setValue('');
					FFind();
			}
		});
		

		var WarehouseStore = Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Warehouse", 
				params: '&log=0',
				fields: [
					{name: 'name', type: 'string'},
				],
		});
		var filter= '[{"property":"organizationId","value": "'+OrganizationId+'"}]';
		WarehouseStore.getProxy().setExtraParam('filter' , filter);
		WarehouseStore.load();
		
		var WarehouseComboBox=Ext.create("Ext.form.field.ComboBox",{
			fieldLabel: 'Warehouse',
			store: WarehouseStore,
			
			
			queryMode: 'local',
			displayField: 'name',
			valueField: 'name',
			listeners: {		
				select: {fn: function (combo, e){
						FFind();}
					
				}
				
			},
			
		});	
		
		var ClearButtonWarehouseComboBox=Ext.create("Ext.Button",{
			icon: 'images/icons/Close.png',
			 handler: function() {
				WarehouseComboBox.setValue('');
					FFind();
			}
		});
		
		var OrganizationStore=Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Organization", 
				params: '&log=0',
				fields: [
					{name: 'name', type: 'string'},
					{name: 'id', type: 'int'},
				],
		});
		OrganizationStore.load();
		 
		
		
		var OrganizationComboBox=Ext.create("Ext.form.field.ComboBox",{
			fieldLabel: 'Organization',
			store: OrganizationStore,
			value: 'ООО"АПИ ДЕПО-ПАРТС"',
			
			queryMode: 'local',
			displayField: 'name',
			valueField: 'id',
			listeners: {		
				select: {fn: function (combo, e){
						FFind();
						// получаем величину и перезагружаем WarehouseStore  
						// console.log(' org id = ' + e[0].data.id);  
						WarehouseStore.getProxy().setExtraParam('filter' , '[{"property":"organizationId","value": "' + e[0].data.id + '"}]' );
						WarehouseStore.load();
					}					
				}
				
			},
			
		});	
		
		var OrganizationComboBoxClearButton=Ext.create("Ext.Button",{
			icon: 'images/icons/Close.png',
			 handler: function() {
				OrganizationComboBox.setValue('');
					FFind();
			}
		});
		
	