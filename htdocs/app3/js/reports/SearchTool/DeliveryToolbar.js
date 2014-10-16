
		 
		
		var NorDeliv=Ext.create("Ext.Button",{
			icon: 'images/icons/DoReport.png',
			scale: 'small',
			//enableToggle: true,
			text: 'Nor Deliv',
			handler: function() {
				NorDeliv.setIcon('images/icons/DoReport.png');
				FastDeliv.setIcon('');
				HoldDeliv.setIcon('');
			}
		});
		var FastDeliv=Ext.create("Ext.Button",{
			//icon: 'images/icons/DoReport.png',
			scale: 'small',
			text: 'Fast Deliv',
			handler: function() {
				NorDeliv.setIcon('');
				FastDeliv.setIcon('images/icons/DoReport.png');
				HoldDeliv.setIcon('');
			}
		});
		var HoldDeliv=Ext.create("Ext.Button",{
			//icon: 'images/icons/DoReport.png',
			scale: 'small',
			text: 'Hold Deliv',
			handler: function() {
				NorDeliv.setIcon('');
				FastDeliv.setIcon('');
				HoldDeliv.setIcon('images/icons/DoReport.png');
			}
		});
	 
		
		
		var DeliveryToolbar = Ext.create("Ext.toolbar.Toolbar",{
			
			items: [{xtype:"tbseparator"},Currency,{xtype:"tbseparator"},Payment, {xtype:"tbseparator"},NorDeliv, FastDeliv, HoldDeliv,{xtype:"tbseparator"},ExecuteAll,{xtype:"tbseparator"},ExecuteCurrent], 
		});
		