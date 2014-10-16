//Ext.ns("appArticleClasses","appArticleRun");
Ext.Loader.setPath('Ext.ux', '../app/extjs/examples/ux');
Ext.require([
	'Ext.ux.grid.FiltersFeature',
//    'Ext.ux.grid.*',
	//'Ext.grid.*',
    //'Ext.data.*',
]);
		
var Table='assortment';

	    
var dataStore = Ext.create("Ext.data.Store",	{
		xtype:"store",
		remoteSort:true,
		autoLoad:true,
		fields:[
			{
				name:"title",
				type:"string"
			},
			{
				name:"id",
				type:"integer"
			},
			{
				name: "make",
				type:"string"
			},
			{
				name: "article",
				type:"string"
			},
			{
				name: "oem",
				type:"string"
			},
			
			
			
		],
		proxy:{
			
			url: '../dbaccess/getTest.php?Table='+Table+"&Condition="+Sf, 
			//directionParam:"pager[dir]"
			//limitParam:"pager[limit]",
			//simpleSortMode:true,
			//sortParam:"pager[sort]",
			//startParam:"pager[start]",
			//url:"/dvelum/app/adminarea/article/list.html",

			
			reader:{
			 idProperty:"id",
			 root:"data",
			 totalProperty:"count",
			 type:"json"
			},
			type:"ajax"


		
		}
	}

	
	
);

	console.log('Sf '+Sf);
	
	

var addButton = Ext.create("Ext.button.Button",	{
		xtype:"button",
		text:"Add item",
		listeners:{
				'click':{
					fn:function(btn,menu,e,eOpts){
				showArticleEditWindow(false);
		},
					scope:this
				}
		
			}
		
	}
);

var sep1 = Ext.create("Ext.toolbar.Separator",	{
		xtype:"tbseparator"
	}
);

var fill1 = Ext.create("Ext.toolbar.Fill",	{
		xtype:"tbfill"
	}
);
/*
var searchField = Ext.create("SearchPanel",	{
		xtype:"searchpanel",
		store:dataStore,
		fieldNames:["title","code"],
		width:200
	}
);
*/

var textfield = Ext.create("Ext.form.field.Text",	{
		xtype:"textfield",
		id: 'SearchField',
		name:"SearchField",
		fieldLabel:"Search: ",
		enableKeyEvents: true,
		listeners:{
						keypress: function (combo, e) {

							//alert(e.getKey());
							if (e.getKey() == e.ENTER) {
								//alert(e.getKey());
									dataStore.filter('title', Ext.getCmp('SearchField').getValue()	);
							}
						}
		}
		


		
		
});

var Sf=Ext.getCmp('SearchField').getValue('');
		

var ClearSearch =  Ext.create("Ext.button.Button",	{
		xtype:"button",
		text:"Clear search",
		handler:function(){
			Ext.getCmp('SearchField').setValue('');	
			dataStore.clearFilter();
		}
	});





var SearchWindow = Ext.create("Ext.button.Button",{
		xtype:"button",
		text:"Advanced search",
		
		handler:function(){
			var Window1 = Ext.create('Ext.window.Window', {
			title: 'Advanced Search Window',
			closable : true,
			height: 500,
			width: 500,
			//layout: 'fit',
			items: [{  // Let's put an empty grid in just to illustrate fit layout
				xtype: 'textfield',
				fieldLabel:"Title: ",
				id: 'Title',
				
			},{
				xtype: 'textfield',
				fieldLabel:"Article: ",
				id: 'Article',
			
			},{
				xtype: 'textfield',
				fieldLabel:"OEM: ",
				id: 'OEM',
			},{
				xtype: 'textfield',
				fieldLabel:"Make: ",
				id: 'Make',
			}
			],
			dockedItems: [
				SearchWindowDock
			]
			
			
			}).show();	
			
			
		}
});


var SearchWindowDock = Ext.create("Ext.toolbar.Toolbar",	{
		xtype:"toolbar",
		items:	[
				{
				xtype:"button",
				text:"Apply search",
				handler:function(){
					Ext.getCmp('Title').setValue('');	
					dataStore.filter('Title', Ext.getCmp('Title').getValue('')	);
					Window1.close();
				}
			}
		]
			
	
});



var filters = Ext.create("Ext.toolbar.Toolbar",	{
		xtype:"toolbar",
		items:	[
				addButton,
				sep1,
				fill1,
				//appArticleRun.searchField
				textfield,
				ClearSearch,
				SearchWindow
			]
			
	}
);


var dataGrid__docked = 	[
			filters
		];
		
var filtersGrid = {
        ftype: 'filters',
        encode: true,
        local: false
};




	


Ext.onReady(function() {

  var Grid = Ext.create("Ext.grid.Panel",	{
		xtype:"grid",
		features: [filtersGrid],
		columnLines:true,
		renderTo: 'grid1',
		bbar:Ext.create("Ext.PagingToolbar", {
			store: dataStore,
			displayInfo: true,
			displayMsg: "Displaying records {0} - {1} of {2}",
			emptyMsg:'NO_RECORDS_TO_DISPLAY',
		}),
		viewConfig:{enableTextSelection: true},
		store:dataStore,
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
		title:"Article :: Home",
		listeners:{
				'itemdblclick':{
					fn:function(view,record,item,index,e,eOpts){
				showArticleEditWindow(record.get("id"));
		},
					scope:this
				}
		
			}
		
	});
	
	
	/*
	var viewport = Ext.create('Ext.Viewport', {
         id:'simplevp'
        ,layout:'border'
		,border:false
		,items:[
			
			Grid,
			
		
		], 
		});
	*/
		
});