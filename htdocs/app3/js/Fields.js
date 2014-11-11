Ext.ns('appMain.UniversalTab');		


Ext.define('appMain.UniversalTab.searchField',{
	extend: 'Ext.form.field.Text',	
	value: 'Search',
	enableKeyEvents: true,
	initComponent:function(){
	
		// this.addEvents([
			// 'searchFieldEnter'
		// ]);
		this.callParent();
	}	
		
});
