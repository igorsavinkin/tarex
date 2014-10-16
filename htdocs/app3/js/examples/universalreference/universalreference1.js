Ext.Loader.setPath('Ext.ux', 'extjs/examples/ux');
Ext.require([
	'Ext.ux.grid.FiltersFeature',
    //'Ext.ux.grid.*',
	//'Ext.grid.*', 
    //'Ext.data.*',
]);


var modelName= 'Assortment';
var params='';

var Store=Ext.create('Ext.data.Store',{

	autoLoad: true,
	fields: [{	    name: "title",	    type:"string",		},
				{		name: "make",	type:"string"		},
				{		name: "article",	type:"string",		},
				{		name: "oem",	type:"string"		},
				{		name: "organizationId",	type:"integer"		},
			], 
	//modelName: 'Assortment',
	params: '',
	proxy :
			{ 
				
				//url:  "index.php?r=backend/index&Table="+this.modelName+this.params,
				url:  "index.php?r=backend/index&Table="+modelName+params,
				reader: { 
					 root: "data",
					 totalProperty: "count",
					 type: "json"
				},
				type:"ajax"
	},
	//filters: [],
	//sort: [],
	
	
});


var Grid1=Ext.create('Ext.grid.Panel', {
    //title: 'Simpsons',
    store: Store,
	//features: [ { ftype: 'filters', encode: true, local: true} ],
	features: [ { ftype: 'filters', encode: true, local: true} ],
	tbar:Ext.create("Ext.PagingToolbar", {
					//itemID: 'pagingtoolbar',
					xtype: 'pagingtoolbar',
					store: Store,
					displayInfo: true,
					//pageSize: 20,
					displayMsg: "Displaying records {0} - {1} of {2}",
					emptyMsg: 'NO_RECORDS_TO_DISPLAY',
	}),	
    columns: [
        /*{ text: 'Name',  dataIndex: 'name' },
        { text: 'Email', dataIndex: 'email', flex: 1 },
        { text: 'Phone', dataIndex: 'phone' }
		*/
		 {  dataIndex:"title", text:"Title", itemId:"title",
			 //filter: { type: 'string' }
			 },
			 {  dataIndex:"article", text:"Article", itemId:"article", 
			
			 },
			 {  dataIndex:"make", text:"Make", itemId:"make" },
			 {  dataIndex:"oem", text:"OEM", itemId:"oem" },
			 {  dataIndex:"organizationId", text:"organizationId", itemId:"organizationId"  }
		
		
    ],
  
    //renderTo: Ext.getBody()
});


Ext.onReady(function() {
	//console.log('test');
	
	var Grid = Ext.create("Ext.panel.Panel",	{
		//xtype:"grid",
		//features: [filtersGrid],
		columnLines:true,
		renderTo: Ext.getBody(),
		title:"Assortment",
		/*tools:[{
				type:'refresh',
				tooltip: 'Refresh form Data',
				// hidden:true,
				handler: function(event, toolEl, panelHeader) {
				// refresh logic
				}
			},
		],*/
		items : [Grid1],
		

	});
	
	

});