//=== MENU
	Ext.define('appMain.view.AddMenu', {
    extend: 'Ext.menu.Menu',
    alias: 'widget.addMenu',
	width: 200,
   //   width: flex 1,	
	Record1: '',
	Offer: '',   
    Title: '',	
	initComponent: function() {
	  var me = this;
	
   // Ext.applyIf(me, {
	  this.items= [
			{
				xtype: 'menuitem',
				text: 'Item info in other tab',
				icon: 'images/icons/Edit.png',
				//url: 'index.php?r=assortment/update/id/'+me.Record1,
				handler: function(){ 
					//console.log('test'+me.Record1);

					//document.location.href ='index.php?r=assortment/update/id/'+me.Record1;
					//window.open('index.php?r=assortment/update/id/'+me.Record1, '','_blank'); 
					window.open('index.php?r=assortment/update/id/'+me.Record1); 

				},
				//click : function(){ console.log(this.Record); }
			},
			{
				xtype: 'menuitem',
				text: 'Info in new window',
				icon: 'images/icons/CreateNew.png',
				//url: 'index.php?r=assortment/update/id/'+me.Record1,
				handler: function(){ 
					Ext.create('appMain.AssortmentInformationWindow', { Record1: me.Record1, 
						 itemTitle: me.Title,						
					}).show();
				},					
			},
			/*{ // кнопка создания нового элемента номенклатуры - перенесена в AssortmentMainGrid.jd line 84
				xtype: 'menuitem',
				text: 'Create a new assort. item',
				icon: 'images/icons/CreateNew.png',
				handler: function(){ 
					Ext.create('appMain.AssortmentInformationWindow', { Record1: '' }).show();
				},
			},*/
			{
				xtype: 'menuitem',
				text: 'Open offer',
				icon: 'images/icons/Edit.png',
				handler: function(){ 
					if (me.Offer!=''){
						var OfferN=me.Offer.substr(2);
						console.log('OfferN'+OfferN);
						
						window.open('index.php?r=pricing/update/id/'+OfferN); 
					}else
						Ext.Msg.alert('Offer not defined', 'Offer not defined!');
				},
			}			
		]; // end of component items
		//});
		me.callParent(arguments);
		}
	}); // end of appMain.view.AddMenu


	function FtreeRightClick(view, record, item, index, e){
		e.stopEvent();        
        //this.application.currentRecord = record;
		console.log('FtreeRightClick ' + record.get('id'));
		addMenu = Ext.create('appMain.view.AddMenu', {
			Record1: record.get('id'),
			Offer: record.get('notes'),
			Oem: record.get('oem'), 			
			Title: record.get('title'),			
		});
		//addMenu.Record=record.get('id');
        addMenu.showAt(e.getXY());
		return false;
	}	
	
	
	function FContractorRightClick(view, record, item, index, e){ 
		e.stopEvent();
		
		var Record1= record.get('id');
		console.log('Record1'+Record1);
		addMenu = Ext.create('Ext.menu.Menu', {
			
			items: [
					{
						xtype: 'menuitem',
						text: 'Contractor info',
						icon: 'images/icons/Edit.png',
						handler: function(){ 
							window.open('index.php?r=user/update/id/'+Record1); 
						},
					},
			]
			
		});
        addMenu.showAt(e.getXY());
		return false;
	}