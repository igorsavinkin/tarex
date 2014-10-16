
var NewMarketItemField=Ext.create("Ext.form.field.Text",{
	fieldLabel: 'New Market Item',
});


var MarketField=Ext.create("Ext.form.field.Text",{
	fieldLabel: 'Market',
});

Ext.define("appMain.Notes",{
		extend: "Ext.toolbar.Toolbar",
			
			items: [
				NewMarketItemField, 
				{xtype: 'button', text: 'Save',
					icon: 'images/icons/Save.png',
					handler: function() {
						Ext.Ajax.request({ 
							url:'index.php?r=Backend/Save&Table=SearchTerm&Field=NewMarketItem&name=' + NewMarketItemField.getValue(),
							method: 'get',
							scope:this, 
						});
					}
				},
				{xtype:"tbseparator"},
				MarketField,
				
				{xtype: 'button', text: 'Save',
				icon: 'images/icons/Save.png',
					handler: function() {
						Ext.Ajax.request({ 
							url:'index.php?r=Backend/Save&Table=SearchTerm&Field=Market&name=' + MarketField.getValue(),
							method: 'get',
							scope:this, 
						});
					}
				
				}, 
				{xtype:"tbseparator"},
				{xtype: 'button', text: 'Frequent requests',
					icon: 'images/icons/DoReport.png',
					handler: function() {
						window.open('index.php?r=SearchTerm/admin'); 
					}
				
				},
				{xtype: 'button', text: 'Offers list',
					icon: 'images/icons/DoReport.png',
					handler: function() {
						window.open('index.php?r=Pricing/admin'); 
					}
				
				},
				
				{ xtype:'tbfill' }, 
				
				{ xtype: 'label', text: "" + UserName +"| UserId: "+UserId+" | RoleId: "+RoleId},
			] 
		
		
		});
		