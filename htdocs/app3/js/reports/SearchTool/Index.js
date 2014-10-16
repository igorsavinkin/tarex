Ext.ns('appMain');		
var ContractorSelected='';
		//var AlredyOrdered=['EUR=12','USD=10'];
		var AlredyOrdered=new Array();
		var AlredyOrderedWOversale=new Array();
		var WarehouseTemporary='';


appMain.application = Ext.application({ 

    autoCreateViewport:false,
    name: 'MyApp',
	SubgroupStore: '',
	/*defaults: {                
            labelAlign: 'right',                
            labelStyle: {
                'font-weight': 'bold'
            },
           // labelWidth: 100
        },*/
    launch: function() {     
		
		Ext.create("appMain.Notes", {renderTo: 'Notes',}); 
		//Ext.define('appMain.Store.UniversalStore'){};
	    this.SubgroupStore = Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Subgroup",     
				autoLoad: true,
				params: '&log=0&compareField=name', /**/
				fields: [
				 { name: 'name', type: 'string'},
				 { name: 'id',       type: 'int'     },
				],
			/*	data: [{"id":"1", "name":"ОПТИКА, OPTICS"},
						 {"id":"2", "name":"ГИДРАВЛИЧЕСКАЯ СИСТЕМА, HYDRAULIC SYSTEM"}],*/
			});
		
		
		var QuickSearch=Ext.create("Ext.toolbar.Toolbar",{
			renderTo: 'QuickSearch',
			items: [
				QuickSearchField, ClearButtonQuickSearchField,  SubgroupComboBox /**/ /* CategorySearchField*/, ClearButtonCategorySearchField,
				CarSearchField, ClearButtonCarSearch, FindButton  
			]		
		});
		
		var CompanyToolbar=Ext.create("Ext.toolbar.Toolbar",{
			 renderTo: 'CompanyToolbar',
			items: [
				CompanyComboBox,ClearButtonCompanyComboBox, {xtype:"tbseparator"},OrganizationComboBox ,OrganizationComboBoxClearButton,  {xtype:"tbseparator"}, WarehouseComboBox, ClearButtonWarehouseComboBox,
			]		
		});
		
		
		Ext.create("appMain.MainGrid",{ renderTo: 'Searchtool',});
		
		
		//=== Панель с контрагентами
	
		
		var CustomerPanel=Ext.create("Ext.panel.Panel",{
			dockedItems: [CustomerToolbar],
			items: [CustomersGrid],
			renderTo: 'CustomerPanel',
		});
		
		
		Ext.create('Ext.tab.Panel', {		
			renderTo: 'Order',
			dockedItems: [DeliveryToolbar],
			items:[RegularItems,NewQtyItems,MarketPriceItems,ItemsUnderOffer,OversaleItems,ShortageItems], 
		});
		
	
	
	} //launch: function() { 
	
	
});