function FFind(){
		
			var filter= '[{"property":"subgroup","value": "'+CategorySearchField.getValue()+'"}';
			 filter+= ',{"property":"warehouse","value": "'+WarehouseComboBox.getValue()+'"}';
			 filter+= ',{"property":"organizationId","value": "'+OrganizationComboBox.getValue()+'"}';
			
			
			filter+=',{"property":"article","value": "'+QuickSearchField.getValue()+'","operand": "AND ("}';	
			filter+=',{"property":"oem","value": "'+QuickSearchField.getValue()+'","operand": "OR"}';	
			filter+=',{"property":"title","value": "'+QuickSearchField.getValue()+'","operand": "OR"}';	
			filter+=',{"property":"Analogi","value": "'+QuickSearchField.getValue()+'","operand": "OR"}';	
			filter+=',{"property":"PartN","value": "'+QuickSearchField.getValue()+'","operand": "OR"}';	
			filter+=',{"property":"SchneiderN","value": "'+QuickSearchField.getValue()+'","operand": "OR"}';	
			filter+=',{"property":"SchneiderOldN","value": "'+QuickSearchField.getValue()+'","operand": "OR"}';	
			filter+=',{"property":"TradeN","value": "'+QuickSearchField.getValue()+'","operand": "OR"}';	
			
			filter+=',{"property":"model","value": "'+CarSearchField.getValue()+'","operand": ") AND ("}';	
			filter+=',{"property":"make","value": "'+CarSearchField.getValue()+'","operand": "OR"}';	
			filter+=',{"property":"country","value": "'+CarSearchField.getValue()+'","operand": "OR"}';	
			
			filter+=',{"property":"manufacturer","value": "'+CompanyComboBox.getValue()+'","operand": ") AND"}';	
			
			filter+=']';
			AssortmentStore.clearFilter();
			AssortmentStore.getProxy().setExtraParam('filter' , filter);
			//AssortmentStore.getProxy().setExtraParam('log' , 1);
			AssortmentStore.loadPage(1);	
			
		// сохранение в SearchTerm 	
			if (QuickSearchField.getValue()!=''){
				Ext.Ajax.request({ 
					url:'index.php?r=Backend/Save&Table=SearchTerm&Field=QuickSearchField&name=' + QuickSearchField.getValue(),
					method: 'get',
					scope:this, 
				});
			}
			if (CarSearchField.getValue()!=''){
				Ext.Ajax.request({ 
					url:'index.php?r=Backend/Save&Table=SearchTerm&Field=CarSearchField&name=' + CarSearchField.getValue(),
					method: 'get',
					scope:this, 
				});
			}			
		 
		};		