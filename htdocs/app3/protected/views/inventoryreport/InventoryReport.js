
Ext.ns("appMain");
var Condition='';

function FOpenInventoryReport (tab_name){
	var $tabpanel = appMain.CenterRegion,
		tabExists = false,
		tab_name;
	console.log('adding tabname = ' + tab_name); 
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
	// если не существует закладки с именем 'name' тогда создаём её
   if (!tabExists) {	
		var $Today=new Date();
		
		var Table='assortment_subgroups';
		console.log('Table = ' + Table); 
		var $InventoryReportStore=  Ext.create('Ext.data.Store', {
			fields: [
				{name: 'id', type: 'string'},
				{name: 'name',  type: 'string'},
			],
			proxy:{ 
				url: 'php/GetUniversal.php?Table='+Table, 
				reader: { 
					root:"data",
					type:"json"
				},
			type:"ajax"
			}
		});
		
		//var $InventoryReportStore=new 
		

	
		//$InventoryReportStore.load();
			
		
			
		
		var $newTab = $tabpanel.add({  		
			title: tab_name,      				
			itemId: tab_name,
		    id: tab_name,
			//setTitle: tab_name
			closable: true,
			items: [  
			{
				xtype: 'datefield',
				fieldLabel: 'From:',		
				format: 'd/m/Y',        
			    value: FBeginOfMonth($Today),   
			
			},
			{
				xtype: 'datefield',
				fieldLabel: 'To:',		
				format: 'd/m/Y',        
			    value: FEndOfMonth($Today),   
			
			
			},
			{
				xtype: 'textfield',
				//enableKeyEvents=true,
				fieldLabel: 'Contractor:',		
				
				
			},{
				xtype: 'combobox',
				fieldLabel: 'Contractor: ',
				disableKeyFilter: true,
				enableKeyEvents: true,
				store: $InventoryReportStore,
				typeAhead: false,
				//hideTrigger: true,
				queryMode: 'local',
				displayField: 'name',
				/*listConfig: {
					loadingText: 'Searching...',
					emptyText: 'No matching posts found.',

					// Custom rendering template for each item
					getInnerTpl: function() {
						return '{name}';
					}
				},
				pageSize: 10,
				*/
				
				listeners:{
					//keypress: function (combo, e) 
					keypress: function( combo, e){
						//console.log(this.getValue()+e.getKey() );
						
						if (e.getKey() == e.ENTER) {
							//???
							//alert('ENTER');
							//Condition="'name'="+this.getValue();
							//console.log('Condition'+Condition );
							if (this.getValue()!=null)
								$InventoryReportStore.getProxy().setExtraParam('Condition' ,"`name` LIKE '%"+this.getValue()+"%'"); 
							else $InventoryReportStore.getProxy().setExtraParam('Condition' ,""); 
							//$InventoryReportStore.clearFilter();
							//if (this.getValue()!=''){
							//	$InventoryReportStore.filter('name',this.getValue());
							//}
							//store.filter('eyeColor', 'Brown');
							$InventoryReportStore.reload();
						}
					}
				}
				
				//displayField: 'name',
				//valueField: 'abbr',
				//renderTo: Ext.getBody()
				
			},
			{
				xtype: 'component',
				style: 'margin-top:10px',
				html: 'Live search requires a minimum of 4 characters.'
			}
			],
		});
	};	
	
	$newTab.setTitle(tab_name);
	$tabpanel.setActiveTab($newTab);	


};