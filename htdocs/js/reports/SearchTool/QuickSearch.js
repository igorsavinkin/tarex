
		
		
		var QuickSearchField=Ext.create("Ext.form.field.Text",{
			fieldLabel: 'Quick item search',
			labelWidth: 70, 
			tabIndex: 1,
			enableKeyEvents: true,
			width: 150,
			listeners: {		
				keypress: {fn: function (combo, e){
					if (e.getKey() == e.ENTER) {
						FFind();
					}
					
					
				},scope:this
				}
			},
			//value: '301085',
			
			
			
			/*hideTrigger: true,
			minChars: 3,
			typeAhead: true,
			//editable: false,
			store: QuickSearchStore, 
			displayField: 'article',
			valueField: 'article',
			*/
		});
		
		
		var ClearButtonQuickSearchField=Ext.create("Ext.Button",{
			icon: 'images/icons/Close.png',
			tabIndex: 10,
			 handler: function() {
				QuickSearchField.setValue('');
				FFind();
			}
		});
// 	SubgroupСomboBox и его Store	
	 	var SubgroupStore = Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Subgroup",     
				autoLoad: true,
				params: '&log=0&compareField=name', 
				fields: [
				 { name: 'name', type: 'string'},
				 { name: 'id',       type: 'int'     },
				],
			 //data: [{"id":"1", "name":"ОПТИКА, OPTICS"},
			//			 {"id":"2", "name":"ГИДРАВЛИЧЕСКАЯ СИСТЕМА, HYDRAULIC SYSTEM"}], 
			});  
		// SubgroupStore.load(); - не надо так как autoLoad: true,
		var SubgroupComboBox = Ext.create('appMain.ComboBox.UniversalComboBox',{ 
				fieldLabel: 'Subgroup', 
				labelAlign : 'right',
			    width: 300,
			  //  store: appMain.SubgroupStore, 
			    store: SubgroupStore, 
				typeAhead: true,
				displayField: 'name',
			    valueField: 'id',
		});			
// конец SubgroupComboBox и его Store

// старый вариант для подгрупп
		var CategorySearchStore = Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Assortment", 				
				params: '&log=0&distinct=1&fields=subgroup',
				fields: [
					{name: 'subgroup', type: 'string'},
				],
		});
		CategorySearchStore.load();

		var CategorySearchField = Ext.create("Ext.form.field.ComboBox",{
			fieldLabel: 'Category search',
			store: CategorySearchStore,
			tabIndex: 3,
			queryMode: 'local',
			displayField: 'subgroup',
			valueField: 'subgroup',
			value: 'ОПТИКА',
			listeners: {		
				select: {fn: function (combo, e){
						FFind();}
					
				}
				
			},

			
		});
		
		var ClearButtonCategorySearchField=Ext.create("Ext.Button",{
			icon: 'images/icons/Close.png',
			tabIndex: 12,
			 handler: function() {
				CategorySearchField.setValue('');
				FFind();
			}
		});
		var CarSearchField=Ext.create("Ext.form.field.Text",{
			fieldLabel: 'Car search',
			tabIndex: 2,
			enableKeyEvents: true,
			listeners: {		
				keypress: {fn: function (combo, e){
				if (e.getKey() == e.ENTER) {
						FFind();
					}
					},scope:this
				}
			},
			
		});
		var ClearButtonCarSearch=Ext.create("Ext.Button",{
			icon: 'images/icons/Close.png',
			 handler: function() {
				CarSearchField.setValue('');
				FFind();
			}
		});
		var FindButton=Ext.create("Ext.Button",{
			icon: 'images/icons/DoReport.png',
			scale: 'medium',
			text: 'Find',
			 handler: function() {
				//CarSearchField.setValue('');
				//CustomerLimitLabel.setText('123');
				FFind();
			}
		});
		
		
		