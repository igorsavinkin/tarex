Ext.ns('appMain.Assortment');

//Ext.define('appMain.Assortment.ListForm', {
Ext.define('appMain.Assortment.ListForm', {
    extend : 'appMain.UniversalTab.GridTab',

	initComponent:function(){
		this.modelName="Assortment";
		
		if (RoleId!=1){
			this.filters= [{"property":"organizationId","value":OrganizationId} ];
		}else{
			//this.params= "&sort=title&dir=ASC";
		}
		this.sorters= [{"property":"title","direction":"ASC"}];
		this.params='&log=2';
		
		this.storeFields = [		
				{	    name: "title",	    type:"string",		},
				{		name: "id", 	    type:"integer"	},
				{		name: "make",	type:"string"		},
				{		name: "article",	type:"string",		},
				{		name: "oem",	type:"string"		},
				{		name: "organizationId",	type:"integer"		},
		];
		this.gridColumns = [
			 { xtype:"gridcolumn", dataIndex:"id", text:"Primary key", itemId:"id" },
			 { xtype:"gridcolumn", dataIndex:"title", text:"Title", itemId:"title",filter: { type: 'string' }},
			 { xtype:"gridcolumn", dataIndex:"article", text:"Article", itemId:"article", filter: {type: 'string'}},
			 { xtype:"gridcolumn", dataIndex:"make", text:"Make", itemId:"make" },
			 { xtype:"gridcolumn", dataIndex:"oem", text:"OEM", itemId:"oem" },
			 { xtype:"gridcolumn", dataIndex:"organizationId", text:"organizationId", itemId:"organizationId" },
		];
		
	  	this.callParent();
	}
});
		
Ext.define('appMain.Assortment.ElementForm', {
    extend : 'appMain.UniversalTab.NewTab',
	
	
	initComponent:function(){
	
		if(this.New==0){
			this.modelName="Assortment";
			
			this.params= "&filter[0][data][value]="+AssortmentId+"&filter[0][field]=Id&filter[0][data][type]=numeric";
			
			this.storeFields = [		
					{	    name: "title",	    type:"string"		},
					{		name: "id", 	    type:"integer"	},
					{		name: "make",	type:"string"		},
					{		name: "article",	type:"string"		},
					{		name: "oem",	type:"string"		},
			];
		}
		this.items = [{ xtype:"textfield",  text:"Primary key"}];
		
	  	this.callParent();
	}
});
		