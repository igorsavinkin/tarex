Ext.ns("appMain.Menu");
	
Ext.define('appMain.Menu.ClinkLabel', { extend:'Ext.form.Label', 
	alias: ['widget.ClinkLabel'],
	style: {
 	    textDecoration:'underline',
		//padding:'5px',
		//fontSize:'10px',
		//color:'#3F1BF6',
		clear: 'both',
		cursor:'pointer'
    },
    listeners:{
		afterrender:{
			fn:function(cmp){
			    cmp.getEl().on('click',function(){
					FShowModule(this.id,'','');	
				});
			},
				  //scope:this
		}
	},

});


function FAddSubsystem(name)
{   
   
   var MenuWestStore = Ext.create('appMain.Store.UniversalStore',{ 
			modelName:"MainMenu", 
			filters: [{"property":"RoleId","value":RoleId},{"property":"Subsystem","value":name} ],
			sorters: [{"property":"DisplayOrder","direction":"ASC"}],
			params: '&log=0',
			
			fields: [
				{name: 'Subsystem', type: 'string'},
				{name: 'Img', type: 'string'},			
				{
					name:"Reference",
					type:"string",
				},
				{name:"ReferenceImg", type: 'string'}, 
				{name:"Link", type: 'string'},
					
			],	
    });
	
	MenuWestStore.load(function(records) { 
	   appMain.WestRegion.removeAll(true);
	   Ext.each(records, function(record){
			appMain.WestRegion.add({
                xtype: 'ClinkLabel',
				id: record.get('Reference'),
				
			 
                text: FLang(record.get('Reference')) + '\r\n',
			}); 
		
	   });
	}); //MenuStore.load(function(records) { 
		
};
//function FAddSubsystem(name)




// FShowModule: function (itemId){
function FShowModule(itemId, recordId, store_id){
	
	var activeTab = appMain.CenterRegion.down('#' + recordId + itemId);
	if(Ext.isEmpty(activeTab)){
	 	if( recordId != '' ) {
			//activeTab=Ext.create("appMain."+itemId+".ElementForm",	{
			activeTab=Ext.create("appMain.UniversalTab.NewTab",	{
				title: recordId+" "+itemId,
				layout:'fit',
				itemId: recordId+itemId, 
				RecordId: recordId,
				ModelName: itemId,
				New: 1,
			});
//		}else if (recordId!=''){

		}
		else {   	// here recordId = ''
		
				console.log(itemId);
			 activeTab = Ext.create('appMain.'+itemId+'.ListForm',		
			 //activeTab = Ext.create('appMain.UniversalTab.GridTab',		
			 {
				 itemId: itemId,
				 title: FLang(itemId),
				 layout:'fit',
			 });
			
		} 
		
		appMain.CenterRegion.add(activeTab);
	} //if(Ext.isEmpty(activeTab)){
	appMain.CenterRegion.setActiveTab(activeTab);
}; // eo FshowModule 	
		