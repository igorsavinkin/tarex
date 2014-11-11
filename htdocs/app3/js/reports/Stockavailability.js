Ext.require([
    'Ext.selection.CellModel',

]);
	

Ext.onReady(function () {
   
   
   var modelName="EventContent";
   
   
	
	
	
	 
	//Store.load(); 
	
	Ext.define('Fields', {
     extend: 'Ext.data.Model',
     fields: [
         {name: 'Field', type: 'string'},
         {name: 'Filter',  type: 'string'},
         {name: 'Check',  type: 'boolean'},
        ]
	});
 
	var StoreFields = Ext.create('Ext.data.Store', {
		 model: 'Fields',
	
	});
	
	
	var ComboBox=new Ext.form.field.ComboBox({
                    typeAhead: true,
                    triggerAction: 'all',
                    store: [
                        ['Warehouse','Wharehouse'], 
                        ['Contractor','Contractor'],
                        ['Author','Author'],
                        ['Assortment title','Assortment title'],
                        ['Assortment oem','Assortment oem'],
                        ['Assortment article','Assortment article'],
                       
                        ['Assortment model','Assortment model'],
                        ['Assortment make','Assortment make'],
                        ['Assortment manufacturer','Assortment manufacturer'],
                        ['Assortment subgroup','Assortment subgroup'],
                        ['Document number','Document number'],
                        ['Document date','Document date'],
                    ],
					
		listeners:{
        //scope: yourScope,
         'select': yourFunction
		}		
					
					
    });
	
	var ComboBoxStore2=Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Warehouse", 
				params: '&log=0',
				fields: [
					{name: 'name', type: 'string'},
				],
	});	
	ComboBoxStore2.load();
	
	var ComboBoxStore21=Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"User", 
				params: '&log=0',
				fields: [
					{name: 'username', type: 'string'},
				],
	});
	ComboBoxStore21.load();
	
	var ComboBoxStoreAssortmentModel=Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Assortment", 
				params: '&log=0&distinct=1&fields=model',
				fields: [
					{name: 'model', type: 'string'},
				],
	});
	ComboBoxStoreAssortmentModel.load();
	
	
	
	var ComboBox2=new Ext.form.field.ComboBox({
                  //  typeAhead: true,
                 //   triggerAction: 'all',
        store: ComboBoxStore2,
		  
		displayField: 'name',
		valueField: 'name',
					
    });
	
	//cb.on('select', yourFunction, this);
   
	var Grid=Ext.create("Ext.grid.Panel",{
		store: StoreFields,
		plugins: {
			ptype: 'cellediting',
			clicksToEdit: 1
		},	
		// this.cellEditing = new Ext.grid.plugin.CellEditing({
            // clicksToEdit: 1
        // });
		
		columns: [
		{
            text: 'Field',
            dataIndex: 'Field' ,
			editor: 
			ComboBox,
			
			
			width: 300,
        },		
		{
            text: 'Filter',
            dataIndex: 'Filter' ,
			editor:  'textfield',
			width: 500,
			//editor: 
			//ComboBox2,
	
				
			//editor: 'textfield',
        },		
		/*{
			text: 'Group by',
			xtype: 'checkcolumn',
            dataIndex: 'Check' ,
			editor:  'checkbox',
		} ,*/
		{ 
			text: 'Delete',
		}
		
		
		],	
		selModel: {
                selType: 'cellmodel'
        },
			
					
	});
	
	
	function yourFunction(){
	
		var ComboValue=ComboBox.getValue();
		
		
		console.log("/"+ComboValue+"/");
		if (ComboValue=="Warehouse"){
			//console.log("WH "+ComboValue);
			
			ComboBox2.store=ComboBoxStore2;
			ComboBox2.displayField='name';
			ComboBox2.valueField='name';
			return;
		}
		
		if (ComboValue=="Contractor" || ComboValue=="Author") {
			console.log("Contractor "+ComboValue);
			
			ComboBox2.store=ComboBoxStore21;
			ComboBox2.displayField='username';
			ComboBox2.valueField='username';
			return;
		}
		if (ComboValue=="Assortment model") {
		
			ComboBox2.store=ComboBoxStoreAssortmentModel;
			ComboBox2.displayField='model';
			ComboBox2.valueField='model';
			return;
		}
		
		
		ComboBox2.store= "";
		
		
	}
	
	

   
   var ButtonAdd= Ext.create('Ext.button.Button', {
			text: 'Add field',
			icon: 'images/icons/CreateNew.png',
			handler: function(){
				var rec = new Fields({
					Field: 'Warehouse',
					Filter: '',
					
				});
				
				StoreFields.insert(0, rec);
				Grid.cellEditing.startEditByPosition({
					row: 0, 
					 column: 0
				 });
			
			}
			
			
	});
	
	
	var Begin=Ext.create('Ext.form.field.Date', {
		fieldLabel: 'From:',
		labelWidth: 30,
		format: 'd.m.Y',
		 
	});
	
	var End=Ext.create('Ext.form.field.Date', {
		fieldLabel: 'To:',
		labelWidth: 30,
		format: 'd.m.Y',
	});
	
	var LoadButton=Ext.create('Ext.button.Button', {
			text: 'Generate',
			icon: 'images/icons/Search.png',
			handler: function() {
				var filter='[';
				var i=0;
				Ext.each(StoreFields.data.items, function(record){
					//console.log('record '+record.get('Check'));
					if (i>0) filter +=','; 
					filter += '{"property":"'+record.get('Field')+'","value": "'+record.get('Filter')+'","group": "'+record.get('Check')+'" }';
					i++;
				
			    });
				filter+=']';
				
			    Store.getProxy().setExtraParam('filter' , filter); 
			    Store.getProxy().setExtraParam('Begin' , Begin.getValue()); 
			    Store.getProxy().setExtraParam('End' , End.getValue()); 
				
				console.log('/'+End.getValue()+'/');
				Store.load(); 
			}
	});
		
		
	
   
   var Toolbar= Ext.create('Ext.toolbar.Toolbar', {
		items:[
			ButtonAdd, 
			Begin,
			End,
			LoadButton
		
		]
   });
   
   var Store = Ext.create('Ext.data.TreeStore', {

		autoLoad: false,
	
				 fields: [
					 {name: 'id', type: 'int'},
					 {name: 'Field', type: 'string'},
					 {name: 'OpeningBalance', type: 'int'},
					 {name: 'Arrival', type: 'int'},
					 {name: 'Consumption', type: 'int'},
					 {name: 'ClosingBalance', type: 'int'},
						
						
				 ],
			proxy:
			{ 
				url:  "index.php?r=backend/remains&log=0",
				/*reader: {  
					  root: "data",
					  totalProperty: "count",
					  type: "json"
				 },*/
				type:"ajax",
			
			}
	}) ;
	

	
	
	
    var TreeGrid = Ext.create('Ext.tree.Panel', {
        //title: 'Core Team Projects',
        //width: 500,
        //height: 300,
        //renderTo: Ext.getBody(),
        //collapsible: true,
		plugins: {
			ptype: 'cellediting',
			clicksToEdit: 1
		},	
		viewConfig:{enableTextSelection: true},
        //useArrows: true,
        rootVisible: false,
        store: Store,
        //store: TreeStore,
        multiSelect: false,
        singleExpand: false,
        //the 'columns' property is now 'headers'
        columns: [{
            xtype: 'treecolumn', //this is so we know which column will show the tree
            text: 'Field',
            flex: 2,
            sortable: true,
            dataIndex: 'Field' 
            //dataIndex: 'id' 
        },
		{
            //we must use the templateheader component so we can use a custom tpl
            //xtype: 'templatecolumn',
			//xtype: 'treecolumn',
            text: 'OpeningBalance',
            //flex: 1,
            sortable: true,
            dataIndex: 'OpeningBalance',
            //align: 'center',
            //add in the custom tpl for the rows

        },
		{
            text: 'Arrival',
			//xtype: 'treecolumn',
           // flex: 1,
            dataIndex: 'Arrival',
            sortable: true
        },		
		{
            text: 'Consumption',
			//xtype: 'treecolumn',
           // flex: 1,
            dataIndex: 'Consumption',
            sortable: true
        },		
		{
            text: 'ClosingBalance',
			//xtype: 'treecolumn',
           // flex: 1,
            dataIndex: 'ClosingBalance',
            sortable: true
        }
		
		]
    });
	
	
   Ext.create("Ext.panel.Panel",{
		renderTo: 'Filters',	
		items: [
			Toolbar,
			Grid
		
		
		]
   
   }); 
   
   
   Ext.create("Ext.panel.Panel",{
		renderTo: 'Grid',	
		items: [
			
			TreeGrid
		
		
		]
   
   });
   
   
   
   
   
   
   
   
   
   
   
   
 });