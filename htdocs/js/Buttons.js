	


Ext.define('appMain.UniversalTab.AddButton', {
    extend : 'Ext.button.Button',
	icon: 'images/icons/CreateNew.png',
	
	initComponent:function(){
		
		this.text=FLang('Add');
		this.handler=function(){
			//console.log(this.itemId);
			FShowModule(this.itemId,'New');
			
		};
		this.callParent();
	}
	
});

Ext.define('appMain.UniversalTab.SaveAdvancedSearchButton', {
    extend : 'Ext.button.Button',
	icon: 'images/icons/Save.png',
	
	initComponent:function(){
		
		this.text=FLang('Save');
		this.addEvents([
			'SaveAdvancedSearch'
		]);
		this.callParent();
	}
	
});






Ext.define('appMain.UniversalTab.AdvancedSearchButton', {
    extend : 'Ext.button.Button',

	icon: 'images/icons/Search.png',
	
	initComponent:function(){
		this.text = FLang("Settings");
		
		this.callParent();

	}
});



Ext.define('appMain.UniversalTab.ClearSearchButton', {
    extend : 'Ext.button.Button',
	
	icon: 'images/icons/Delete.png',
	
	initComponent:function(){
		this.text= FLang("Clear");
	    // объявляем событие в компоненте, на которые могут подписаться другие
		this.addEvents([
			'clearClicked'
		]);
		//console.log('clearClicked added');
		this.callParent();
	}
	
	
});


Ext.define('appMain.UniversalTab.SaveButton', {
    extend : 'Ext.button.Button',
	icon: 'images/icons/Save.png',
	initComponent:function(){
		//this.text='Save '+this.itemId;
		this.text=FLang('Save');
		this.handler=function(){
			var activeTab = appMain.CenterRegion.down('#' + this.itemId);
			activeTab.destroy();
			
		};
		this.callParent();
	}
	
});
