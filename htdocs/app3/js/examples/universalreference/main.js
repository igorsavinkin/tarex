
Ext.Loader.setPath('Ext.ux', '../app/extjs/examples/ux');
Ext.require([
	'Ext.ux.grid.FiltersFeature',
    'Ext.ux.grid.*',
	//'Ext.grid.*',
    //'Ext.data.*',
]);
	
	
	
function addTab(name,condition)
{   
	var $tabpanel = Ext.getCmp('tabpanel'),
		  tabExists = false;  
		  
	//console.log('name '+name); 	  
	
	var Condition=' 1 ';
	var Table = name;
	
	//Обращаемся именно к store того справочника, который открываем
	var Store = Ext.create('Ext.data.Store', {
        //storeId: 'Store',
		autoLoad: true, 
		remoteSort:true,
		
		proxy: {
			type: 'ajax',
			url: '../dbaccess/getTest.php?Table='+Table+"&Condition=1", 
			//url: "../dbaccess/getModel.php?model="+Table+"&Condition="+ Condition,
		},
        fields: ['id','name'],
    });
		
		  
	// проверка существует ли уже данная закладка
	for(var i=0; i < $tabpanel.items.length && !tabExists; i++) { 
		var tabname = $tabpanel.items.getAt(i).id; //console.log(tabname);  		
		
		//console.log('tabname '+tabname); 	  
	    if(tabname == name) { 
			tabExists = true; 
			$tabpanel.setActiveTab(tabname);
			//Ext.Msg.alert('Warning', 'Tab "' + name + '" already exists');	//return false;
	    }
	}	
	// если не существует закладки с именем 'name' тогда создаём её
	if (!tabExists) {
	
	
	var filters = {
        ftype: 'filters',
        encode: true,
        local: false
    };

		var $newTab = $tabpanel.add({
			title: name,           // $tabPanel.items.length  - количество элементов панели
		//	html : '<h3>Model '+name +' has been loading ...</h3> ',
			itemId: name,
			id: name,
			closable: true,
			items: 
			[
				
				{			
					xtype: 'button',
					text: 'Add',
					handler:function(){
					addTab('New '+name);	
					}
		
				},
				{
					xtype: 'textfield',
					id: 'SearchField',
					text: 'Search:',
					enableKeyEvents: true,
					 
					listeners:{
						keypress: function (combo, e) {

							//alert(e.getKey());
							if (e.getKey() == e.ENTER) {
									Store.filter('name', Ext.getCmp('SearchField').getValue('')	);
							}
						}
					}
				
				},
				{
					xtype: 'button',
					text: 'Search',
					handler:function(){
						Store.filter('name', Ext.getCmp('SearchField').getValue('')	);
						
					}
				},
				{
				
					xtype: 'button',
					text: 'Clear',
					handler:function(){
						Ext.getCmp('SearchField').setValue('');	
						Store.clearFilter();
						//Store.refresh;
					}
				
				},
				
				{
					
					xtype: 'grid',
					store: Store,
					features: [filters],
					columns: [ 
							{
								text         : 'id',
								dataIndex: 'id', 
								filter: {
									type: 'string'
								}
							} ,{
									text         : 'name',
								dataIndex: 'name', 
								filter: {
									type: 'string'
								}
							
							}
					],
					dockedItems: [{
							id: 'items-pages',
							itemID: 'pagingtoolbar',
							xtype: 'pagingtoolbar',
							store: Store,
							pageSize: 5,
							dock: 'top',
							displayInfo: true,
							displayMsg: 'Displaying items {0} - {1} of {2}',
							emptyMsg: "No items to display",
							},
							
									
					
					
					], //dockedItems
					
					/* bbar: Ext.create('Ext.PagingToolbar', {
						store: Store
					}),   
					*/
					//	url: '../dbaccess/getModel.php?model=' + name + '&field=' + fields,
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
					
					listeners:
					{
						'itemdblclick':{
						fn:function(view,record,item,index,e,eOpts){
							addTab(record.get('name'));
							//showArticleEditWindow(record.get("id"));
						},
						//scope:this
						}
					},
					//columnLines:true,
					/*bbar:Ext.create("Ext.PagingToolbar", {
					store: Store,
					pageSize: 25,
					displayInfo: true,
					displayMsg: "Displaying records {0} - {1} of {2}",
					emptyMsg: 'NO_RECORDS_TO_DISPLAY'
					}),
					*/
					//viewConfig:{enableTextSelection: true},
				
		
				},	
			
			
				
			],
			
			
			
		
		
		
		});
		//console.log('starting load dynamicGrid!'); //Custom
        //var dynamicGrid = Ext.ComponentQuery.query('dynamicGrid')[0]; //Custom
        //dynamicGrid.getStore().getProxy().url =  'dbaccess/getModel.php?model=' + name + '&fields=' + fields;
        //dynamicGrid.getStore().load();	
		$tabpanel.setActiveTab($newTab); //console.log('added new tab ' + name);	 
	}	
};


function addSubsystem(name)
{   
	var WestRegion = Ext.getCmp('WestRegion');
	WestRegion.removeAll();
	
	WestRegion.add(
		{
			xtype: 'button',
			text: 'contractor',
			//fieldLabel: 'Contactors',
			handler:  function() { 	addTabContractor(this.text,'','');  },
		},{
			xtype: 'button',
			text: 'assortmentFake', 
			handler:  function() { 	addTabAssortment(this.text, '' , '' );  },
		
		}
	);
};
	
Ext.onReady(function() {

    //var appMain;
	
	var Store = Ext.create('Ext.data.Store', {
        storeId: 'usersstore',
		autoLoad: true, 
		proxy: {
			type: 'ajax',
			url: '../dbaccess/getTest.php', 
		},
        fields: ['username', 'email', 'created'],
    }); 
	
	var $tabPanel = Ext.create('Ext.tab.Panel', {		
				region: 'center'
				,xtype: 'tabpanel'
				,id: 'tabpanel'				
				,border: false
				,title: 'Main window'
				,autoScroll:true
				//,tbar: [{text: 'smth'}]
				//,lbar: $leftBar/* [{
				//		text: 'Users', 
				//		handler:  function() { addTab(this.text); },
				//	}]*/ // end of west region left toolbar 
				,items:
				[{		
					xtype: 'grid', 
					title: 'Users(original)',
					id: 'Users',
					closable: true,
					store: Store,
					columns: [ 
							{
								text         : 'username',
								dataIndex: 'username', 
							} 
					],
					listeners:
						{
							'itemdblclick':{
								fn:function(view,record,item,index,e,eOpts) 
								{  
									//showEditWindow(record, 'yiiapp_user', "`username`='"+ record.get("username")+"'");
								},
								scope:this
							}
						},
				}
			],  // end of tabpanel (center) items 	
	}); // end of $tabPanel
	
	var $northPanel = Ext.create('Ext.panel.Panel', {		
				region: 'north'
				,xtype: 'panel'
				,id: 'northPanel'				
				,border:true
				,title: 'Subsystems' 
				,tbar: [{ 
							text: 'Subsystem1' , 
						    handler: function() { 
								addSubsystem(this.text); 
								//$WestRegion=
								//window.open('vieworders.html');
							},  
						 },
						{ 
							text: 'Subsystem2' , 
						    //handler: function() { 
								//addTab3('doc_events', 'Id,Subject,EventTypeId' /*this.text*/); 
								//window.open('vieworders.html');
							//},  
						 }
						 ,'->',
						 ComboBoxLang,						
						{ text: 'Exit' , handler: {} },
					   ] // end of west region left toolbar 
				,items:[{}],  // end of tabpanel (center) items 	
	}); // end of $northPanel
	
	var $WestRegion= Ext.create('Ext.panel.Panel', {		
				region: 'west'
				,xtype: 'panel'
				,id: 'WestRegion',	
				collapsible: true,
				floatable: true,
				width: 150,
				split: true				
				,border:true
				,title: 'Subsystem control' 
				
				,items:[{
					xtype: 'button',
					fieldLabel: 'Users',
					text:"Users",
					handler:  function() { addTab(this.text);},
					//scope:this				
				},{				
					xtype: 'button',
					fieldLabel: 'Contactors',
					text:"Contactors",
					handler:  function() { addTab(this.text); },
					//scope:this
				
				},{
					xtype: 'button',
					fieldLabel: 'Assortment',
					text:"assortmentFake",
					handler:  function() { addTabAssortment(this.text, '' , ''); },
					//scope:this
				},
				{
					xtype: 'button',
					fieldLabel: 'Orders',
					text:"Orders",
					handler:  function() { 	addTab(this.text);  },
					//scope:this 
				}  
			],  // end of tabpanel (center) items 	
	}); // end of $WestRegion
	
	
	var viewport = Ext.create('Ext.Viewport', {
         id:'simplevp'
        ,layout:'border'
		,border:false
		,items:[ 
			$northPanel,
			$WestRegion,
			$tabPanel   
		], // end of viewport items 	 
	}); 
	
	
	
}); // end of Ext.onReady() function

