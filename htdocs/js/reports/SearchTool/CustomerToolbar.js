
		
		//=== Customer
		var CustomerStore=Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"User", 
				params: '&log=0',
				fields: [
					{name: 'username', type: 'string'},
				],
		});
		var filter= '[{"property":"isCustomer","value": "1"}]';
		CustomerStore.getProxy().setExtraParam('filter' , filter);
		//CustomerStore.load();
		
		
		
		
		
		
		var CustomerLimitLabel=Ext.create("Ext.form.Label",{
			text: ' Limit: 0 ',
		});
		var CustomerBalanceLabel=Ext.create("Ext.form.Label",{
			text: ' Balance: 0 ',
		});
		var CustomerBalanceLabelWOversale=Ext.create("Ext.form.Label",{
			text: ' Balance with Oversale Items: 0 ',
		});

		
		var currentdebtLimit=0;
		var CustomerComboBox=Ext.create("Ext.form.field.ComboBox",{
			fieldLabel: 'Customer',
			labelWidth: 50,
			store: CustomerStore,
			queryMode: 'local',
			displayField: 'username',
			valueField: 'username',
			listeners:{
				'change':function (combo, newValue, OldValue) {
					//window.location.href = 'index.php?r=site/backendpavel&Language='+this.value;
					var CustomerStore2=Ext.create('appMain.Store.UniversalStore',{ 
							modelName:"User", 
							params: '&log=0',
							fields: [
								{name: 'username', type: 'string'},
								{name: 'debtLimit', type: 'int'},
							],
					});
					var filter= '[{"property":"username","value": "'+this.value+'"}]';
					CustomerStore2.getProxy().setExtraParam('filter' , filter);
					CustomerStore2.load(function(records){
						Ext.each(records, function(record){
							var debtLimit=record.get('debtLimit');
							
							console.log('debtLimit '+debtLimit); 
							//CustomerLimitLabel.setValue(' Limit: '+debtLimit);
							CustomerLimitLabel.setText(' Limit: '+debtLimit);
							currentdebtLimit=debtLimit;
						});
					});
					
					
				}
			}	
			
		});	
		
		var CurrencyStore=Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Currency", 
				params: '&log=0',
				fields: [
					{name: 'name', type: 'string'},
				],
		});
		CurrencyStore.load();
		
		var Currency=Ext.create("Ext.form.field.ComboBox",{
			fieldLabel: 'Currency',
			labelWidth: 50,
			store: CurrencyStore,
			queryMode: 'local',
			displayField: 'name',
			valueField: 'name',
			
		});
		
		var PaymentStore=Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"PaymentMethod", 
				params: '&log=0',
				fields: [
					{name: 'name', type: 'string'},
				],
		});
		PaymentStore.load();
		
		var Payment=Ext.create("Ext.form.field.ComboBox",{
			fieldLabel: 'Payment method:',
			labelWidth: 50,
			store: PaymentStore,
			queryMode: 'local',
			displayField: 'name',
			valueField: 'name',
			
		});
		
		var ExecuteAll=Ext.create("Ext.Button",{
			icon: 'images/icons/DoReport.png',
			scale: 'medium',
			text: 'Execute All',
			 handler: function() {
				//CarSearchField.setValue('');
				//CustomerLimitLabel.setText('123');
				
			}
		});		
		
		var ExecuteCurrent=Ext.create("Ext.Button",{
			icon: 'images/icons/DoReport.png',
			scale: 'medium',
			text: 'Execute Current',
			 handler: function() {
				//CarSearchField.setValue('');
				//CustomerLimitLabel.setText('123');
				
			}
		});
		
		
		
		var SearchContractor=Ext.create("Ext.form.field.Text",{
			fieldLabel: 'Contractor search',
			enableKeyEvents: true,
			listeners: {		
				keypress: {fn: function (combo, e){
				//console.log('e.getKey'+e.getKey() );
					if (e.getKey() == e.ENTER) {
					
						FFindContractor();
					}
				},scope:this
				}
			},
			
		});
		
		var SearchContractorClear=Ext.create("Ext.Button",{
			icon: 'images/icons/Close.png',
			 handler: function() {
				SearchContractor.setValue('');
				FFindContractor();
			}
		});		
		
