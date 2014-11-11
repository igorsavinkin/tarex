	var myData = [
        ['3m Co', 71.72, 0.02,  0.03,  '9/1 12:00am'],
        ['Alcoa Inc', 29.01, 0.42,  1.47,  '9/1 12:00am'],
        //..................
        ['Verizon Communications', 35.57, 0.39,  1.11,  '9/1 12:00am'],
        ['Wal-Mart Stores, Inc.', 45.45, 0.73,  1.63,  '9/1 12:00am']
    ];

function UpperCase(value,metaData, record)
{
	return record.get('company').toUpperCase();
}

function loadContent(record, index , id)
{
	var $id = 36;
	//$id = record.get('change');
	$id = index;
	var store2 = Ext.create('Ext.data.ArrayStore', {
        fields: ['company','price','change','pctChange','lastChange', 'email'],
        //data: myData,
		proxy: {
			type: 'ajax',
			api: {
				read:  'getUsers.php?id=' + $id,
			    update: 'setUsers.php',
			},
			reader: {
				type: 'json',
				root: 'users',
				totalProperty: 'total',
				successProperty: 'success',			
				},
			writer: {
				type: 'json',
				//root: 'users',
				//totalProperty: 'total',
				//successProperty: 'success',			
				},
		/*	 writer: new Ext.data.JsonWriter({
							writeAllFields: true,
                            getRecordData: function(record) { return record.data; }
                        }),*/
		},
        fields: ['username', 'email', 'created'],
		columns: [
			{header: 'UserName',  dataIndex: 'username',  flex: 2},
			{header: 'Email', dataIndex: 'email', flex: 3},
	        {header: 'Created', dataIndex: 'created', flex: 2},
		],  
    });
    var window = Ext.create('Ext.window.Window', {
		title: 'Users',
		height: 200,
		width: 400,
  		items: [ 
			{
				xtype:"grid",
				store: store2.load(),
				columnLines:true,
				columns:[
					{
						text     : 'UserName',
						dataIndex: 'username', 
					},{
						text     : 'Created',
						dataIndex: 'created', 
					},{
						text     : 'Email',
						dataIndex: 'email', 
					}], 
			},  
		]   	  
	}).show();

} // end loadContent

function showArticleEditWindow(id){
	
	var ageFilter = new Ext.util.Filter({
		property: 'company',
		value   : 'Alcoa Inc' //0.02
	});

	var longNameFilter = new Ext.util.Filter({
		filterFn: function(item) {
			return item.change > 0;
		}
	});


	/*
	var store = new Ext.data.JsonStore({
    // store configs
    storeId: 'myStore',

    proxy: {
        type: 'ajax',
        url: 'get-images.php?id='+id.get("change"),
        reader: {
            type: 'json',
            root: 'images',
            idProperty: 'name'
        } 
    },
	*/
	
	var store1 = Ext.create('Ext.data.ArrayStore', {
        fields: ['company','price','change','pctChange','lastChange'],
        data: myData,
	//	filter: { property: 'firstName',            value   : /Ed/ },
    });
	
	
	var Change = id.get("change");
	

/*	
	 store.filter([
		//property: "change", id.get("change") 
		{filterFn: function(item) 
			{
				return item.get("change") = Change;
			}
		}
	 ]); 
	*/
  	    MyWindow  =   Ext.create('Ext.window.Window', {
		title: 'Hello',
		height: 200,
		width: 400,
  		items: [//textfield
			{
				//me.childObjects.editWindow_title =  Ext.create("Ext.form.field.Text",{
				xtype:"textfield",
				allowBlank:false,
				name:"title",
				fieldLabel:"Title",
				value: Change, //id.get("change"),
			},
			{
				xtype:"grid",
				store: store1.filter({
				  property: 'change',
				  value: '0.02',
				  exactMatch: false,
				  caseSensitive: false,
				}),
				columnLines:true,
				columns:[
					{
						text     : 'Компания',
						dataIndex: 'company', 
					},{
						text     : 'Price',
						dataIndex: 'price', 
					},{
						text     : 'Change',
						dataIndex: 'change', 
					}],
					
				/*store: store,
				columns: [
				{
						text     : 'Компания',
						dataIndex: 'company',
					 
				},
				],
			*/
			
			
			
			},
				
		]      
			  
			  
			  
		});   
		
		MyWindow.show();
			  
  	} // end of showArticleEditWindow()
	
	