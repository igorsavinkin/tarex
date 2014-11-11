function FFindContractor(){
			//console.log('FFindContractor');
			
			var filter= '[{"property":"isCustomer","value": "1"}';
			//CustomersStore.getProxy().setExtraParam('filter' , filter);
		
			 filter+= ',{"property":"username","value": "'+SearchContractor.getValue()+'"}';
			filter+=',{"property":"email","value": "'+SearchContractor.getValue()+'","operand": "OR"}';	
			filter+=',{"property":"Childs","value": "'+SearchContractor.getValue()+'","operand": "OR"}';	
			filter+=',{"property":"phone","value": "'+SearchContractor.getValue()+'","operand": "OR"}';	
			filter+=',{"property":"address","value": "'+SearchContractor.getValue()+'","operand": "OR"}';	
			//filter+=',{"property":"notes","value": "'+SearchContractor.getValue()+'","operand": "OR"}';
			if(RoleId>3) {
				filter+=',{"property":"parentId","value": "'+UserId+'"}'
			}
			
			filter+=']';
			CustomersStore.clearFilter();
			CustomersStore.getProxy().setExtraParam('filter' , filter);
			//AssortmentStore.getProxy().setExtraParam('log' , 1);
			//AssortmentStore.loadPage(1);	
			CustomersStore.loadPage(1);	
		 
		};