Ext.ns('app');

app.menuCfg = [
 {
    text:'Graph 1',
    itemId:'graph_1',
    objectClass:'app.graph.Main'
  },{
    text:'Graph 2',
    itemId:'graph_2',
    objectClass:'app.graph.Main'
  }
];

app.application = Ext.application({
    autoCreateViewport:false,
    name: 'MyApp',
    contentEl:'body',
    launch: function() {
	app.content = Ext.create('Ext.tab.Panel',{
	    region: 'center',
	    layout:'fit',
	    frame:false,
	    border:false,
	    autoSctoll:false,
	    deferredRender:false,
	    title:'Content'
	});

	app.header = Ext.create('Ext.Panel',{
	    region: 'north',
	    frame:false,
	    border:false
	});

	this.createMenu();

	app.viewport =  Ext.create('Ext.container.Viewport', {
	    layout: 'border',
	    items: [
	            app.header,
	            app.content
	    ]
	});
    },
    createMenu:function(){
			Ext.each(app.menuCfg, function(item , index){
			item.handler = this.showModule;
			item.scope = this;
		},this);

    app.header.addDocked({
		xtype:'toolbar',
		items:app.menuCfg,
		dock:'bottom'
      });
    },
   
   showModule:function(btn){
		 var activeTab = app.content.down('#' + btn.itemId);
		 if(Ext.isEmpty(activeTab)){
			 activeTab = Ext.create(btn.objectClass,{
			 itemId:btn.itemId,
			 title:btn.text,
			 layout:'fit',
			 closable: true
			 });
			 app.content.add(activeTab);
		 }
		 app.content.setActiveTab(activeTab);
    }
});