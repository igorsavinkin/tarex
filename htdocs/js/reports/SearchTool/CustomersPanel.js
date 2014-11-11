
		
		var CustomersStore= Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"User", 
				pageSize: 5,	
				params: '&log=0',	
				fields: [
					{name: 'username', type: 'string'},
					{name: 'email', type: 'string'}, 
					{name: 'phone', type: 'string'},
					{name: 'address', type: 'string'},
					{name: 'discount', type: 'double'},
					{name: 'debtLimit', type: 'double'},
					{name: 'notes', type: 'string'},
					{name: 'Accounts', type: 'string'},
					{name: 'Childs', type: 'string'},
					//{name: 'Accounts', type: 'string'},
					
				]
				
		});
		var filter= '[{"property":"isCustomer","value": "1"}';
		
		if(RoleId>3) {
			filter+=',{"property":"parentId","value": "'+UserId+'"}'
		}
		filter+=']';
		CustomersStore.getProxy().setExtraParam('filter' , filter);
		CustomersStore.load(); 


//=== Грид выбора контрагента ===		
		var CustomersGrid= Ext.create("Ext.grid.Panel",{
			columnLines:true,
			   height: 150,
			viewConfig:{enableTextSelection: true},
			
			tbar:Ext.create("Ext.PagingToolbar", {
						xtype: 'pagingtoolbar',
						store: CustomersStore,
						displayInfo: true,
						pageSize: 5,
						displayMsg: "Displaying records {0} - {1} of {2}",
						emptyMsg: 'NO_RECORDS_TO_DISPLAY',
			}),	
			store: 		CustomersStore, 
					
					
			columns:  [
				{dataIndex: 'username', type: 'string', text: "Name", width: 150 },
					{dataIndex: 'email', type: 'string', text: "E-mail", width: 150 }, 
					{dataIndex: 'phone', type: 'string', text: "Phone", width: 150 },
					{dataIndex: 'address', type: 'string', text: "Adress", width: 300 },
					{dataIndex: 'discount', type: 'double', text: "Discount", width: 50 },
					{dataIndex: 'debtLimit', type: 'double', text: "Limit", width: 50 },
					{dataIndex: 'notes', text: "Notes", width: 150 },
					{dataIndex: 'Accounts', text: "Accounts info", width: 150 },
					{dataIndex: 'Childs', text: "Child accounts", width: 150 },
				//{ dataIndex:"New", text: "New", width: 50 },

						
						
			],
			listeners:
			{
				'itemdblclick':{
					fn:function(view,record,item,index,e,eOpts){
						ContractorSelected=record.get('username');
						AccountsSelected=record.get('Accounts');
						//while (AccountsSelected)
						ContractorSelectedLimit=AccountsSelected.split(';');
						//console.log(ContractorSelectedLimit); 
						 
						CustomerLimitLabel.setText('Contractor: '+ContractorSelected+' | Limit:'+AccountsSelected);	
						
						FResimulate(ContractorSelectedLimit);
						
					},
				},
				'itemcontextmenu' : {fn:function(view, record, item, index, e){ 
					console.log('itemcontextmenu'); 
					FContractorRightClick(view, record, item, index, e); 
				}},
				
				//FtreeRightClick();
			},
				
			
		});	
		

		var CustomerToolbar=Ext.create("Ext.toolbar.Toolbar",{
			
			items: [ SearchContractor, SearchContractorClear, {xtype:"tbseparator"}, CustomerLimitLabel, {xtype:"tbseparator"}, CustomerBalanceLabel ,  {xtype:"tbseparator"}, CustomerBalanceLabelWOversale], 
		});
		