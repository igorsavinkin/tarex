Ext.Loader.setPath('Ext.ux', '../app/extjs/examples/ux');
Ext.require([
	'Ext.ux.grid.FiltersFeature', 	
]); 

function addFormContractor(tabname, $record, tablename)
{
	var $tabpanel = Ext.getCmp('tabpanel'),
		 tabExists = false,
		 tab_name;
	console.log('adding tabname = ' + tabname); 
	// проверка существует ли уже данная закладка
	for(var i=0; i < $tabpanel.items.length && !tabExists; i++) { 
		tab_name = $tabpanel.items.getAt(i).itemId; //console.log(tabname);		
		//console.log('existing $tabpanel.items.getAt(' + i + ').itemId = ' + tab_name ); 
		
	    if(tab_name == tabname) { 
			tabExists = true; 
			$tabpanel.setActiveTab(tab_name);
			//Ext.Msg.alert('Warning', 'Tab "' + name + '" already exists');	//return false;
	    }
	}	
	
	var $itemForm = new Ext.form.Panel({
		id: 'item-'+tabname,
        frame: true, 
        //title: 'Contractor item: <em>' + $record.get('title') + '</em>',
		setTitle: function() // мы ставим title в зависимости от того это новая запись или нет
			{
				 if ($record.get('name')) this.title = $record.get('name'); 
				 else this.title = 'new ' + tablename + ' item';  
			},
        bodyPadding: 5, 
		url: '../dbaccess/saveItem.php?Table='+tablename, 
		method : 'get', 

        fieldDefaults: {
            labelAlign: 'left',
            msgTarget: 'side',
		 
        },	
		defaultType: 'textfield',
        items: [
				   {	fieldLabel: 'Name',		name: 'name',          width: 600 	        },
				   {	fieldLabel: 'ID',			name: 'id'	,           xtype: 'hidden'  	}, 
				   {	fieldLabel: "address",	name: "address"	 	}, 
		],
		// Reset and Submit buttons
		buttons: [{
			text: FLang('Cancel'),
			align: 'left',
			handler: function() {  
				 var tab = Ext.getCmp(tabname);
				 $tabpanel.remove(tab);
			}
		}, {
			text: FLang('OK'),
			formBind: true, //only enabled once the form is valid
			disabled: true,
			handler: function() {
				var form = this.up('form').getForm();
				if (form.isValid()) {
					form.submit({
						success: function(form, action) { 
							  // Ext.Msg.alert('Success', action.result.msg);							  
							  Ext.getStore('dataStoreContactor-' + tablename).reload(); // перезагружаем store относящийся к этой зааписи
							  var tab = Ext.getCmp(tabname);	 
							  $tabpanel.remove(tab); // убираем эту вкладку
							  
							},
						failure: function(form, action) {
							Ext.Msg.alert('Failed', action.result.msg); 
							},
						});
					}
				}
		},{
			text: FLang('Save'),
			formBind: true, //only enabled once the form is valid
			disabled: true,
			handler: function() {
				var form = this.up('form').getForm();
				if (form.isValid()) {
					form.submit({
						success: function(form, action) { 
							  //Ext.Msg.alert('Success', action.result.msg);							  
							  Ext.getStore('dataStoreContactor-' + tablename).reload(); // перезагружаем store относящийся к этой зааписи
							 // var tab = Ext.getCmp(tabname);	 
							//  $tabpanel.remove(tab); // убираем эту вкладку
							  
							},
						failure: function(form, action) {
							Ext.Msg.alert('Failed', action.result.msg); 
							},
						});
					}
				}
		}],  // end Form buttons
	});
	
	// если не существует закладки с именем 'name' тогда создаём её
   if (!tabExists) {	
		var $newTab = $tabpanel.add({  		
			title: tabname,      				
			itemId: tabname,
		    id: tabname,
			setTitle: function(newName) // мы ставим title в зависимости от того это новая запись или нет
			{
				 if ($record) this.title = newName; 
				 else this.title = newName.substring(0, newName.length - 2)
			},
			closable: true,
			items: [  $itemForm	],
		});
		if ($record) $itemForm.loadRecord($record); 
	};	
	
	$newTab.setTitle(tabname);
	$tabpanel.setActiveTab($newTab);	
} // end addFormContractor

function addTabContractor(name,condition,param)
{ 
    var $tabpanel = Ext.getCmp('tabpanel'),
	tabExists = false;  
		
	// проверка существует ли уже данная закладка
	for(var i=0; i < $tabpanel.items.length && !tabExists; i++) { 
		var tabname = $tabpanel.items.getAt(i).id; //console.log(tabname);  
		//console.log('tabname '+tabname); 	  
		if(tabname == name) { 
			tabExists = true; 
			$tabpanel.setActiveTab(tabname);
			//Ext.Msg.alert('Warning', 'Tab "' + name + '" already exists');	//return false;
			return;
		}
	}
		
		
		
		
/*	console.log('param '+param); 	  
	console.log('name '+name); */	  
	
	var Condition=' 1 '; 
	
	var SearchFld = Ext.create("Ext.form.field.Text",	{
		xtype:"textfield",
		id: 'SearchField',
		name:"SearchField",
		fieldLabel:"Search",
		width: 200,
		enableKeyEvents: true,
		listeners:{
			keypress: function (combo, e) {
				if (e.getKey() == e.ENTER) {
						//alert(e.getKey());
						//dataStoreContactor.clearFilter(); 
						dataStoreContactor.getProxy().setExtraParam('Param1' ,Ext.getCmp('SearchField').getValue()); 
						//dataStoreContactor.load();
						//dataStoreContactor.getProxy().setExtraParam('Condition' , SearchFld.getValue()); 
						dataStoreContactor.loadPage(1);
					}
				}
			}
	});
	
	var dataStoreContactor = Ext.create("Ext.data.Store",	{
			xtype: "store",
			id: 'dataStoreContactor-' + name,
			storeId: 'dataStoreContactor-' + name,
			remoteSort:true,
			autoLoad:true,
			pageSize: 20,
			fields:[		
				{	    name: "name",	    type:"string"		},
				{		name: "id", 	   		type:"integer"	},
				{		name: "address",	type:"string"		}, 
			],
			proxy:{ 
				url: '../dbaccess/getTablePagingFilter.php?Table='+name, 
				reader: {
					 idProperty: "id",
					 root: "data",
					 totalProperty: "count",
					 type: "json"
				},
				type:"ajax"
			}
		} 
	);  
	var addButton = Ext.create("Ext.button.Button",	
	   {
			xtype: 'button',
			text: 'Add item',
			handler:function(){
				//addItem('New ' + name + ' item',  '' , '');
				addFormContractor('new ' + name + ' item' + Math.floor(Math.random()*100),  '' , name); 	
				},
			scope: this,
	   } 
	); // end addButton
	
	var sep1 = Ext.create("Ext.toolbar.Separator",	{
			xtype:"tbseparator"		}
	);
	var fill1 = Ext.create("Ext.toolbar.Fill",	{
			xtype:"tbfill"		}
	); 
	var ClearSearchBtn =  Ext.create("Ext.button.Button",	{
		xtype:"button",
		iconCls: 'deleteIcon',
		text:"Clear search",
		handler:function(){ 
			SearchFld.setValue('');	 
			dataStoreContactor.getProxy().setExtraParam('Param1', ''); 
			dataStoreContactor.loadPage(1);
		}
	}); 
	var titleFld = Ext.create("Ext.form.field.Text",	{
			xtype:"textfield",
			id: 'Title',
			name:"Title",
			fieldLabel:"Title",
	});
	var articleFld = Ext.create("Ext.form.field.Text",	{
			xtype:"textfield",
			id: ' Article',
			name:" Article",
			fieldLabel:" Article",
	});
	var oemFld = Ext.create("Ext.form.field.Text",	{
			xtype:"textfield",
			id: 'OEM',
			name:"OEM",
			fieldLabel:"OEM",
	});
	var makeFld = Ext.create("Ext.form.field.Text",	{
			xtype:"textfield",
			id: 'Make',
			name:"Make",
			fieldLabel:"Make",
	});

	var AdvSearchWindow = Ext.create('Ext.window.Window', {
		title: 'Advanced Search',
		closable : true,
		closeAction: 'hide', 
		autoHeight:true,
		bodyPadding: 10, 			
		buttonAlign : 'center', 
		items: [  titleFld,			
					 articleFld,
					 oemFld, 
					 makeFld,
					{   xtype:"button",
						text:"Apply search",
						handler:function(){ 	
							dataStoreContactor.getProxy().setExtraParam('Param1' , titleFld.getValue());
							dataStoreContactor.loadPage(1); 
							AdvSearchWindow.close();
							}
					}
				]			
		});

	var AdvSearchBtn = Ext.create("Ext.button.Button",{
			xtype:"button",
			text:"Advanced search",		
			handler:function(){
				AdvSearchWindow.show();				
			}
	}); 

	var filterToolbar = Ext.create("Ext.toolbar.Toolbar", {
		xtype:"toolbar",
		items: [
				addButton,
				sep1,
				fill1, 
				SearchFld,
				ClearSearchBtn,
				AdvSearchBtn
			]
		}
	);
	
	var dataGrid__docked = [
			filterToolbar
		];
		
	var filtersGrid = {
			ftype: 'filters',
			encode: true,
		   // local: true
			local: false
	}; 
	
	var $Grid = Ext.create("Ext.grid.Panel",	{
		xtype:"grid",
		features: [filtersGrid],
		columnLines:true,
		renderTo: 'grid1',
		tbar:Ext.create("Ext.PagingToolbar", {
			store: dataStoreContactor,
			displayInfo: true,
			displayMsg: "Displaying records {0} - {1} of {2}",
			emptyMsg:'NO_RECORDS_TO_DISPLAY',
		}),
		viewConfig:{ enableTextSelection: true },
		store: dataStoreContactor,
		columns:[
				{
					xtype:"gridcolumn",
					dataIndex:"id",
					text:"Primary key",
					itemId:"id"
				},
				{
					xtype:"gridcolumn",
					dataIndex:"title",
					text:"Title",
					itemId:"title",
					filter: {
						type: 'string'
					}		
				},
				{
					xtype:"gridcolumn",
					dataIndex:"article",
					text:"Article",
					itemId:"article"
				},
				{
					xtype:"gridcolumn",
					dataIndex:"make",
					text:"Make",
					itemId:"make"
				},
				{
					xtype:"gridcolumn",
					dataIndex:"oem",
					text:"OEM",
					itemId:"oem"
				},
		],
		dockedItems:dataGrid__docked,
		title: "<span style=text-transform:capitalize;'>" + name + "</span>",
		listeners:{
				'itemdblclick':{
				fn:function(view,record,item,index,e,eOpts){ 
					addFormContractor(record.get('title').slice(0,11), record, name);
					}, 
				},	               
			}, 
	});	 	  
		
	// если не существует закладки с именем 'name' тогда создаём её
	if (!tabExists) {
		var filters = {
			ftype: 'filters',
			encode: true,
			local: false
		};
		
		//Форма списка - Вывод самой сетки с номенклатурой
		var $newTab = $tabpanel.add({
			title: name,    // $tabPanel.items.length  - количество элементов панели 
			itemId: name,
			id: name,
			closable: true,
			items: [ 	$Grid	],
		});			
				 
		$tabpanel.setActiveTab($newTab); //console.log('added new tab ' + name);	 
	}	 // end "если не существует такой вкладки"
}; // end of addTabContractor