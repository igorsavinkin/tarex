Ext.ns('appMain');		




appMain.application = Ext.application({
    autoCreateViewport:false,
    name: 'MyApp',
    //contentEl:'body',
    launch: function() {  
		var Model1='';
		Store.load(function(records) { 
			//console.log();
			Model1= Store.getAt(1).get('Name');
			  Ext.each(records, function(record){
				console.log('Model1:'+Model1);
				
			});
			
			//var Model= records.getAt(1);
		});
			 
		//var Model= myStore.last();
		
	
		//var Model= myStore.getById(1);
		//var Model= Store.getAt(1);
 
		 console.log(Model1);
	
		 //console.log('UserName '+UserName);
	
		appMain.NorthRegion = Ext.create('Ext.panel.Panel', {		
				region: 'north',
				id: 'NorthRegion',				
				//frame:false,
				//border:false,
				tbar: [
					//<?php echo Yii::app()->user->name.' | role: '.Yii::app()->user->role.' | '.CHtml::Link(Yii::t('general', 'Logout'), array('/site/logout')); ?>

					 { xtype:'tbfill' }, 
					 { xtype: 'label', text: "" + UserName +"| UserId: "+UserId+" | RoleId: "+RoleId},
					  appMain.Lang.ComboBoxLang ,
					 { xtype:'button', text: FLang('Logout'), 
						handler: function(){ window.location.href="index.php?r=site/logout"; }
					 
					 },
					// { xtype:'tbseparator' },
					//   Ext.create('appMain.UniversalTab.LoginButton', {  } ),
				], // eo tbar
				//dockedItems: [ {xtype: 'tbar'}], 
				title: "Tarex v.2.3 FULL version",  

		}); 
				
		appMain.WestRegion= Ext.create('Ext.panel.Panel', {		
				region: 'west',
				collapsible: true,
				collapsed: false,
				//floatable: true,
				width: 100,
				split: true,				
				//border:true,
				title: FLang('Subsystems'),
			
		}); // end of $WestRegion
				
		appMain.CenterRegion = Ext.create('Ext.tab.Panel', {		
			region: 'center',
			xtype: 'tabpanel',		
		    layout:'fit',
			//border: true,
			//title: FLang('Main window'),
			autoScroll:true,
		}); 

		this.FCreateMenu();
		appMain.viewport =  Ext.create('Ext.container.Viewport', {
			layout: 'border',
			items: [
				appMain.NorthRegion,
				appMain.WestRegion,
				appMain.CenterRegion   
			]
		});
		
		
			
			
    }, //launch: function() {
	
	
		
	
	FCreateMenu:function(){
		
		var MenuStore = Ext.create('appMain.Store.UniversalStore',{ 
			modelName:"MainMenu", 
			//params: "&sort=DisplayOrder&dir=ASC&distinct=1&filter[0][data][value]="+RoleId+"&filter[0][field]=RoleId&filter[0][data][type]=string&fields=Subsystem,Img",
			params: '&distinct=1&fields=Subsystem,Img',
			fields: [
				{name: 'Subsystem', type: 'string'},
				{name: 'Img', type: 'string'},			
					
			],
			filters: [{"property":"RoleId","value":RoleId}],
			sorters: [{"property":"DisplayOrder","direction":"ASC"}],
		});
		
		// Работает !!!!
		var image;
		//MenuStore.sort('DisplayOrder', 'ASC');
		//MenuStore.filter("RoleId",RoleId);
		//MenuStore.filter("OrganizationId",OrganizationId);
		MenuStore.load(function(records) { 
		   Ext.each(records, function(record){
			 // console.log(record.get('Reference')); 
			image = (record.get('Img') != '') ? record.get('Img') : 'Alert.png';
			//console.log('icon = ' + image);
			appMain.NorthRegion.add([{
                xtype: 'button',
				scale: 'large',
                text: FLang(record.get('Subsystem')),
                itemId: record.get('Subsystem'),
				icon:  'http://k-m.ru/app2/images/icons/' + image, //record.get('Img'),
                handler:  function(){ FAddSubsystem(this.itemId , '' ); }

			}]);
			
		   });
		}); //MenuStore.load(function(records) { 
	}, //FCreateMenu:function(){
	
}); 
 



	
	


