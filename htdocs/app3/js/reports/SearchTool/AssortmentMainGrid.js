
			
	var AssortmentStore = Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Assortment", 
				params: '&log=0',	
				pageSize: 10,			
				
				fields: [
					{name: 'article', type: 'string'},
					{name: 'oem', type: 'string'}, 
					{name: 'model', type: 'string'},
					{name: 'make', type: 'string'},
					{name: 'manufacturer', type: 'string'},
					{name: 'title', type: 'string'},
					{name: 'availability', type: 'int'},
					{name: 'priceS', type: 'double' },
					{name: 'subgroup', type: 'string'},
					{name: 'country', type: 'string'},
					{name: 'warehouse', type: 'string'}, 
					{name: 'organizationId', type: 'int'}, 
					{name: 'Reserved', type: 'int'},
					{name: 'New', type: 'int'},
					{ name:"SchneiderN",  type: 'string' },
					{ name:"SchneiderOldN",  type: 'string' },
					{ name:"TradeN",  type: 'string' },
					{ name:"Analogi",  type: 'string'},
					{ name: "Currency",  type: 'string'},
					{ name: "notes",  type: 'string'},
					{ name: "specialDescription",  type: 'string'},
					{ name: "ItemPosition",  type: 'string'},
					{ name: "OfferDescription",  type: 'string'},
				],
		});
		//var filter= '[{"property":"organizationId","value": "7"},{"property":"availability","comparison":">","value": "0"}]';
		//AssortmentStore.getProxy().setExtraParam('filter' , filter);
		AssortmentStore.load(); 
		
//=== ГЛАВНЫЙ ГРИД Assortment MainGrid ===		
		
		Ext.define("appMain.MainGrid",{
			extend: "Ext.grid.Panel",
			
			//width: 400,
			columnLines:true,
		    height: 300,
			//width: 500,
			//renderTo: 'Searchtool',
				//itemId: this.itemId + '-grid',
			//overflowX: 'scroll',
			//autoScroll: true, 
			//xtype:"grid",
			viewConfig: {
				enableTextSelection: true,
				getRowClass: function(record, rowIndex, rowParams, store){
					

					var notes = record.get("notes");
					var pos = notes.indexOf('UO');
					
					//console.log('pos'+pos+' notes '+notes);
					if(pos!=-1){
						//console.log(record.get("notes"));	
						return "UO"; 
					}else if (notes=="NI") {
						return "NI"; 
						//return "row-error";
					}else if (notes=="SM") {
						return "SM"; 
					}					
					//return record.get("notes") ? "row-valid" : "row-error";
				}
			},

			//viewConfig:{enableTextSelection: true},
			 
			tbar:  [
			{	xtype: 'pagingtoolbar',
				store: AssortmentStore,
				displayInfo: true,
				//pageSize: 10,
				displayMsg: "Displaying records {0} - {1} of {2}",
				emptyMsg: 'NO_RECORDS_TO_DISPLAY',
			}, ' ' ,
			{ 	xtype: 'button', 
				text: 'Create a new assortment item',
				icon: 'images/icons/CreateNew.png',
				handler: function(){ 
					 Ext.create('appMain.AssortmentInformationWindow', { Record1: '',    /* можно передать, но там он может поменяться, тогда это не подходит SubgroupStore: this.SubgroupStore */ }).show();
				},
			}], // end tbar
			store: 		AssortmentStore, 
					
					
			columns:  [
				{ dataIndex:"article", text: "Article", width: 100 },
				//{ dataIndex:"oem", text: "Oem", width: 100},
				{ dataIndex:"title", text: "Title", width: 150, },
				{ dataIndex:"model", text: "Model", width: 100 },
				{ dataIndex:"make", text: "Make", width: 100 },
				{ dataIndex:"availability", text: "Qty", width: 50, renderer: FAssortmentRenderer },
				
				{ dataIndex:"warehouse", text: "Warehouse", width: 100 ,
					/*renderer: function(value, metaData, record, rowIdx, colIdx, store) {
						metaData.tdAttr = 'data-qtip="' + value+ '"';
						return value;
					}*/

				},
				{ dataIndex:"notes", text: "Notes", width: 100 ,	
					renderer: function(value, metaData, record, rowIdx, colIdx, store) {
						/*var OfferN=value.substr(2);
						if (OfferN!=''){
							console.log(OfferN);
						}
						*/
						//record.get('OfferDescription');
						metaData.tdAttr = 'data-qtip="' + record.get('OfferDescription')+ '"';
						return value;
					}
				}, 
				{ dataIndex:"OfferDescription", text: "Offer description", width: 100 },
					{ dataIndex:"priceS", text: "Price", width: 50 },
					{ dataIndex:"Currency", text: "Currency", width: 50 },
						{ dataIndex:"Reserved", text: "Reserved", width: 50 },
				{ dataIndex:"New", text: "New", width: 50 },
 				//{ dataIndex:"Analogi", text: "Analogi", width: 50,  },
				{ dataIndex:"manufacturer", text: "Manufacturer", width: 100,		},
				{ dataIndex:"subgroup", text: "Subgroup", width: 100 },
				{ dataIndex:"country", text: "Country", width: 100 },
				{ dataIndex: "specialDescription",  text: 'Special description'},
				{ dataIndex: "ItemPosition",  text: 'Item position'},
						
						
			],
			listeners:
			{
				'itemdblclick':{
				fn:function(view,record,item,index,e,eOpts){
					//FShowModule(record.get('id'));
					//AssortmentWindow.ident=record.get('id');
					//AssortmentWindow.show();
					var Ident=record.get('id');
					var priceS=record.get('priceS');
					var article=record.get('article');
					var oem=record.get('oem');
					var title1=record.get('title');
					var amount=record.get('availability');
					var warehouse=record.get('warehouse');
					var organizationId=record.get('organizationId');
					var Currency=record.get('Currency');
					var notes=record.get('notes');
					
					if(priceS==0) {
						Ext.Msg.alert('Price must be >0', 'Price must be >0!');
						return;
					}
					//ContractorSelected='1';

					if (ContractorSelected!='')	{
						var AssortmentWindow=Ext.create("AssortmentWindow2",{
							ident: Ident,
							priceS: priceS,
							article: article,
							oem: oem,
							title1: title1,
							amount: amount,
							warehouse: warehouse, 
							organizationId: organizationId,
							Currency: Currency,
							notes: notes,
						}); 
						AssortmentWindow.show(); 					
					}
					else  Ext.Msg.alert('Select contractor', 'Please first select a contractor!');
					//console.log('Ident '+Ident);					
				

					/*
					AssortmentWindow.title= 'Enter Qty & Price for '+Ident;
					AssortmentWindow.ident= Ident;
					AssortmentWindow.show();*/
					
					
				},
				},
				'itemcontextmenu' : {fn:function(view, record, item, index, e){ 
				//console.log('itemcontextmenu');
				FtreeRightClick(view, record, item, index, e); 
				}},
				//FtreeRightClick();
			},
				
			
		}
		
		
		
		);
		
	
	//Renderer
	function FAssortmentRenderer(val){    
        if(val > 1){
            return '<span style="color:blue;">' + val + '</span>';
        }else {
            return '<span style="color:black;">' + val + '</span>';
        }
        return val;
    }
	
