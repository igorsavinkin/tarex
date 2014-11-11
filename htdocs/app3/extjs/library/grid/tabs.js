function addTab2(name, fields)
{   
	var $tabpanel = Ext.getCmp('tabpanel'),
		  tabExists = false;  
	// проверка существует ли уже данная закладка
	/* не проверяем
	for(var i=0; i < $tabpanel.items.length && !tabExists; i++) { 
		var tabname = $tabpanel.items.getAt(i).id; //console.log(tabname);  		
	    if(tabname == name) { 
			tabExists = true; 
			$tabpanel.setActiveTab(tabname);
			//Ext.Msg.alert('Warning', 'Tab "' + name + '" already exists');	//return false;
	    }
	}	 
	*/
	// если не существует закладки с именем 'name' тогда создаём её
	if (!tabExists || 1) {
		var $newTab = $tabpanel.add({
			title: name,           // $tabPanel.items.length  - количество элементов панели
		//	html : '<h3>Model '+name +' has been loading ...</h3> ',
			itemId: name,
			id: name,
			closable: true,
			items: [
				{
					// All what you have to set! :)
					xtype: 'grid', // Custom
					url: 'dbaccess/getModel.php?model=' + name + '&field=' + fields,
				/*	dockedItems: [{
						id: name + '-paging-bar',
						itemID: 'pagingtoolbar',
						xtype: 'pagingtoolbar',
						store: this.getStore(),
						dock: 'bottom',
						displayInfo: true,
						displayMsg: 'Displaying items {0} - {1} of {2}',
						emptyMsg: "No items to display",
					}],*/
				}
			],
		});
		console.log('starting load dynamicGrid!'); //Custom
        var dynamicGrid = Ext.ComponentQuery.query('dynamicGrid')[0]; //Custom
        dynamicGrid.getStore().getProxy().url =  'dbaccess/getModel.php?model=' + name + '&fields=' + fields;
        dynamicGrid.getStore().load();	
		$tabpanel.setActiveTab($newTab); //console.log('added new tab ' + name);	 
	}	
};	