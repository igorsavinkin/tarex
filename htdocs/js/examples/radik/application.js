   function MathdecimalPlaces(num, p){return Math.round(num*(Math.pow(10,p)))/Math.pow(10,p)};

   function FCalcMedium(value,metaData, record){
		//console.log('console '+record.get('High'));
		var H = parseFloat(record.get('H'));
		var L = parseFloat(record.get('L'));
       // return (record.get('High')+record.get('L'))/2;
        return MathdecimalPlaces((H+L)/2,4);
   };

   function FCalcDelta(value,metaData, record){
		//console.log('console '+record.get('High'));
		var H = parseFloat(record.get('H'))*10000;
		var L = parseFloat(record.get('L'))*10000;
       // return (record.get('High')+record.get('L'))/2;
       // return MathdecimalPlaces((H-L),4);
        return MathdecimalPlaces((H-L),0);
   };

   function FDecimal(value,metaData, record){
        return MathdecimalPlaces(value,4);
   };

   
   //decimalPlaces = function(num, p){var a=(''+num); return parseFloat(a.substr(0, a.indexOf('.')+(++p)))}


   Ext.onReady(function () {
	var Store = Ext.create('Ext.data.Store', {
 		autoLoad: true, 
		proxy: {
			type: 'ajax',
			url: 'get.php?Table=test_data', 
			reader: { 
						 root: "data",
						 totalProperty: "count",
						 type: "json"
			},
					
		},
        fields: ['Date', 'Time', 'H','L','Volume', 'M','Delta' ],
    });	
	
	var Store1 = Ext.create('Ext.data.Store', {
 		autoLoad: true, 
		proxy: {
			type: 'ajax',
			url: 'getanalyze.php?Table=test_data_analyze', 
			reader: { 
						 root: "data",
						 totalProperty: "count",
						 type: "json"
			},
					
		},
        fields: [
		
			{name: 'Price', type: 'double'},
			
			{name: 'SumVolume', type: 'int'} 
			
		],
    });
	
	
	

	var Grid = Ext.create('Ext.grid.Panel', {
		title: 'Data',
		bbar:Ext.create("Ext.PagingToolbar", {
			store: Store,
			displayInfo: true,
			displayMsg: "Displaying records {0} - {1} of {2}",
			emptyMsg:'NO_RECORDS_TO_DISPLAY',
		}),
		store: Store,
		columns: [
			{ text: 'Date',  dataIndex: 'Date' },
			{ text: 'Time', dataIndex: 'Time' },
			{ text: 'High', dataIndex: 'H', renderer: FDecimal },
			{ text: 'Low', dataIndex: 'L', renderer: FDecimal },
			{ text: 'Delta', dataIndex: 'Delta', renderer: FCalcDelta },
			{ text: 'Medium',  dataIndex: 'M',  renderer: FCalcMedium },
			{ text: 'Volume', dataIndex: 'Volume' },
		],


	});
	
	var Grid1 = Ext.create('Ext.grid.Panel', {

		/*bbar:Ext.create("Ext.PagingToolbar", {
			store: Store1,
			displayInfo: true,
			displayMsg: "Displaying records {0} - {1} of {2}",
			emptyMsg:'NO_RECORDS_TO_DISPLAY',
		}),
		*/
		store: Store1,
		columns: [ 
			{ text: 'Price',  dataIndex: 'Price' },
			{ text: 'SumVolume', dataIndex: 'SumVolume' },
			
		],


	});
	

	
	var PanelAnalyze = Ext.create('Ext.panel.Panel', {		
		title: 'Grid Analyze',
		tbar: [
			{	

				xtype: 'datefield',
				fieldLabel: 'From:',
				id: 'Begin',
				name: 'From',
			},
			{
				xtype: 'datefield',
				fieldLabel: 'To:',
				id: 'End',
				name: 'To',
			
			
			},
			{ 
				xtype: 'button', text: 'Analyze',
				handler: function(){ 
					Ext.Ajax.request
					({
							url:'analyze.php?Begin='+Ext.Date.format(Ext.getCmp('Begin').getValue(), 'Y-m-d')+"&End="+
							Ext.Date.format(Ext.getCmp('End').getValue(), 'Y-m-d'), 
							method: 'post',
							params:{
								//Begin: Ext.getCmp('Begin').getValue(),
								//Begin: 'Begin',
								//End: Ext.getCmp('End').getValue(),
							},

						scope:this,
						success: function(response, request) {
						response =  Ext.JSON.decode(response.responseText);
							if(!response.success){
								Ext.Msg.alert('Response' , response.msg);
							} 
						},
					});
				
					Store1.reload();
				}
			},
			{
				type: 'button', text: 'Reload Grid',
				handler: function(){ 
					Store1.reload();
				}
				
			}
		],
		items: 
		[
			Grid1
			
		]
	
	});
	
	
	//var $tabPanel = Ext.create('Ext.tab.Panel', {		

	var win = Ext.create('Ext.tab.Panel', {
	    renderTo: Ext.getBody(), 
		title: 'Application for Radik',
		items: [
			PanelAnalyze,
			Grid,
			
			
		
		]
	
	
	});
	
});