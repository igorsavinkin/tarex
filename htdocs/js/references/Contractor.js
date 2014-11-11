function RetrieveValueFromDB($tableName, $fieldName, $id)
{
	var $result;
	Ext.Ajax.request({
		url: '../dbaccess/getModel.php',
		method: 'GET',
		params: {
		 	condition: ' id= "' + $id + '" ',
			model: $tableName,
			fields: [$fieldName], // массив полей --- у нас одно поле
		}
		success: function(response) {
			$result = Ext.JSON.decode(response.responseText);
			console.log( 'result = ' + $result[0].name   );   // здесь мы ставим 'name' - это имя поля из $fieldName			
			 Ext.getCmp('my-name').setValue( $result[0].name ); // 'my-name' - имя id поля (не так универсально)
		}		
	});	
	// почему-то не работает
	//if ($result) return $result[0].name; 
	//else return '';
	
};  // end of RetrieveValueFromDB($tableName, $fieldName, $id)
	
	
	
function addTabContactor(name,condition,param)
{   
	var $tabpanel = Ext.getCmp('tabpanel'),
	tabExists = false;  
		  
	console.log('param '+param); 	  
	console.log('name '+name); 	  
	
	var Condition=' 1 ';
	var Table=''+name;
	

		
		  
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
		
		if (param != '')
		{
			//Открываем форму нового или существующего элемента
			if (param != 'New'){
			
				var Value1= param;
			} else {
			// новый элемент	
				var Value1= '';
			
			}
			
			//Форма элемента (форма создания-редактирования элемента списка)
			var $newTab= $tabpanel.add({
				title: name,      
				html : '<h3>Test</h3> ',			
				itemId: name,
				id: name,
				closable: true,
				items: 
				[
					{	
						xtype: "textfield",
						allowBlank: false,
						name: "name", 
						//id: 'my-name',
						fieldLabel: "Name",
						value: function(){ RetrieveValueFromDB('contractor', 'name', Value1); }, 
					},
					{
						xtype:"textfield",
						allowBlank:false,
						name:"id",
						fieldLabel:"ID",
						value: Value1
						
					
					}
				]
				
				
			});
				
				
			
			
		} else
		{
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
				// Как поля брать из таблицы а не самому их постоянно задавать?
				fields: ['id','name'],
			});

			//Форма списка
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
						addTabContactor('New record '+name,'','New');	
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
								addTabContactor('Exsisting record '+record.get('id'),'',record.get('id'));
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
			
		}
		 
		$tabpanel.setActiveTab($newTab); //console.log('added new tab ' + name);	 
	}	
};


