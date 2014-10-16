
	Ext.define('ModelAnalogi', {
			extend: 'Ext.data.Model',
			fields: [
				{name: 'number', type: 'string'},				
			]	
		});

	Ext.define('UsedCarsModel', {
			extend: 'Ext.data.Model',
			fields:['manufacturer', 'series', 'model', 'year'],
		}); 
			
	Ext.define('appMain.AssortmentInformationWindow',{
		extend: 'Ext.window.Window',				
		/* // если мы хотим окно с динамической высотой
		autoHeight:true,
		layout: 'auto',
		*/
		height: 540,
		width: 600,
		layout: 'fit',
		
		initComponent:function(){
			me=this;  
		 	
			this.ButtonSave = Ext.create("Ext.Button",{
				icon: 'images/icons/Save.png',
				text: 'Save this assortment Item',  
				
				handler: function() {	
				    //console.log('User role = ' + UserRole);
					//this.Photos=me.PhotoTextfield.getValue();					
			
				// валидация всех компонентов		
					console.log('me.CmpArr = '); 	
					console.dir(me.CmpArr); // определён ниже
					var validationError='', errCount=0; 
			
					Ext.each(me.CmpArr, function(item, index, array){						
						 if(typeof item != 'undefined' && typeof item.isValid == "function") {
						// можно теперь провести валидацию							 
						 	if(item.isValid()  == true ) 
								console.log(index + '. Name ' + item.fieldLabel + ' is valid');
							else {
								//console.log(index + '. Name ' + item.fieldLabel + ' is NOT valid');
								validationError += '<b>' + item.fieldLabel + '</b> value should not be empty!<br>';
								errCount++;								
							}							
						 }	
					});
					if (0!=errCount) {
						Ext.MessageBox.show({ 
							title: errCount + ' fields(s) failed validation',
							height: 15*errCount +60 ,
							msg: validationError,
							icon: Ext.MessageBox.WARNING,
							buttons: Ext.MessageBox.OK,
						});	 
						return false;
					}
					
					me.FRecalc();	 
			 
					Ext.Ajax.request({ 					
						url:'index.php?r=Backend/Save&Table=Assortment&id='+me.Record1+'&Analogi=' + me.InformationAnalogi.getValue()+
							'&Photos=' + me.PhotoTextfield.getValue() + 
							
							'&title=' +  InformationTitle.getValue() + 
							'&article=' +  InformationArticle.getValue() +
							'&oem=' +  InformationOem.getValue() +
							'&model=' +  InformationModel.getValue() + 
							'&make=' +  InformationMake.getValue() +
							'&manufacturer=' +  InformationManufacturer.getValue() +
							'&userId=' +  InformationUserId.getValue() +
							'&date=' +  InformationDateTime.getValue() +							
							
							'&SchneiderOldN=' +  InformationSchneiderOldN.getValue() +
							'&SchneiderN=' +  InformationSchneiderN.getValue() +
							'&TradeN=' +  InformationTradeN.getValue() + 							
							'&ItemCode='  +  InformationItemCode.getValue() +
					 		
							'&FOBCost='  +  InformationFOBCost.getValue() +
							'&priceS='  +  InformationPriceS.getValue() +
				 		
							'&RealLeadTime='  +  InformationRealLeadTime.getValue() +
							'&LeadTime='  +  InformationLeadTime.getValue() +
							
							'&techInfo='  +  InformationTechInfo.getValue() + 
							'&specialDescription='  +  InformationSpecialDescription.getValue() + 
							'&PIN='  +  InformationPIN.getValue() +
							'&Barcode='  +  InformationBarcode.getValue() +
							'&YearBegin='  +  InformationYearBegin.getValue() +
							'&YearEnd='  +  InformationYearEnd.getValue() +
							
						// получение даных из comboBoxes	
							'&ItemFamily='  + ItemFamilyComboBox.getValue() +
							'&ItemCategory='  + ItemCategoryComboBox.getValue() +
							'&ItemPosition='  + ItemPositionComboBox.getValue() +
							'&SupplierCode='  +  SupplierNameComboBox.getValue() +	
							'&CostCalculation='  +  CostCalculationComboBox.getValue() +	
							'&Currency='  +   CurrencyComboBox.getValue() +
							'&PurchaseCurrency='  +   PurchaseCurrencyComboBox.getValue() +
							'&ItemOrigin='  +   ItemOriginComboBox.getValue() +
														
							'&subgroup=' 		+   SubgroupComboBox.getValue(),  
						method: 'get', 
						scope:this, 
						success: function(response){ 
							//var text = response.responseText;
							// process server response here
							if (response.responseText != '') {
								me.close();
								Ext.MessageBox.show({ 
									title: 'Success',
									msg: 'The record has been successfully saved', 
									icon: Ext.MessageBox.INFO,
									buttons: Ext.MessageBox.OK,
								}); 								
							} 
							else Ext.MessageBox.show({ 
									title: 'Failure',
									msg: 'The record could not be saved', 
									icon: Ext.MessageBox.WARNING,
									buttons: Ext.MessageBox.OK,
								}); 							
						}						
					});					
				}
			});
			
			if (RoleId>5) {
				console.log(RoleId, 'disable ButtonSave');
				this.ButtonSave.disable();			
			}
			
			this.dockedItems=[{ 
				xtype: 'toolbar',
				dock: 'top',
				items: [this.ButtonSave],
			}]; 
			
			/*Ext.each(StoreAssortmentInformationWindow.data.items, function(record){
                    console.log('record '+record.get('title'));
                this.FieldTitle=  record.get('title');                  
            });*/
	// поля info этого окна	
			var InformationTitle=Ext.create('Ext.form.field.Text',{
				value: '', width: 500, fieldLabel: 'Assortment title:'//, allowBlank: false
			});
			var InformationArticle=Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Article:', allowBlank: false
			});
			var InformationOem=Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Oem:', allowBlank: false
			});
			var InformationModel=Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Model:', allowBlank: false
			});
			var InformationMake=Ext.create('Ext.form.field.Text',{
				value: '', fieldLabel: 'Make:', allowBlank: false
			});
			var InformationPartN=Ext.create('Ext.form.field.Text',{
				value: '', fieldLabel: 'PartN:' , allowBlank: false
			});
			var InformationSchneiderN=Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'SchneiderN:', allowBlank: false
			});
			var InformationSchneiderOldN=Ext.create('Ext.form.field.Text',{
				value: '', fieldLabel: 'Schneider old N :', allowBlank: false
			});
			var InformationTradeN=Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Trade N :'
			});
			this.InformationAnalogi=Ext.create('Ext.form.field.TextArea',{
				value: '',  fieldLabel: 'Analogs:'
			});
			var InformationManufacturer=Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Manufacturer:', allowBlank: false
			});
			var InformationSubgroup=Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Subgroup:', allowBlank: false
			});
			var InformationUser=Ext.create('Ext.form.DisplayField',{
				value: '',  fieldLabel: 'User who created:' //, readOnly: true,
			});		
			var InformationUserId=Ext.create('Ext.form.field.Text',{
				value: 0,  hidded: true,
			});  
			var InformationDateTime = Ext.create('Ext.form.DisplayField', {
				value: Ext.Date.format(new Date(), 'Y-m-d H:i:s') , 
				fieldLabel : 'Date & time when item is created:'  
			});		
			var InformationItemCode = Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Item Code:', allowBlank: false
			});
			var InformationFOBCost = Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'FOB cost:', allowBlank: false
			});	
			var InformationPriceS = Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Selling price:' 
			});   
			var InformationLeadTime = Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Lead Time:', allowBlank: false
			});
			var InformationRealLeadTime = Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Real Lead Time:', allowBlank: false
			});
			var InformationItemFamily = Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Item family:', allowBlank: false
			});	
			var InformationTechInfo = Ext.create('Ext.form.field.TextArea',{
				value: '',  fieldLabel: 'Technical info:'
			});
			var InformationSupplierCode = Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Supplier code:', allowBlank: false
			});	 
			var InformationPIN = Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'PIN:'
			});
			var InformationBarcode = Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Barcode:', allowBlank: false
			});
			var InformationSpecialDescription = Ext.create('Ext.form.field.TextArea',{
				value: '',  fieldLabel: 'Special description (both languages):', allowBlank: false
			});
			var InformationYearBegin = Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Year begin:', allowBlank: false
			});			
			var InformationYearEnd = Ext.create('Ext.form.field.Text',{
				value: '',  fieldLabel: 'Year end:', allowBlank: false
			});
 
//  Currency & Purchase Currency -- ComboBoxes & store 
			var CurrencyStore = Ext.create('appMain.Store.UniversalStore', {
				modelName:"Currency",     
				autoLoad: true,
				params: '&log=0&compareField=name', 
				fields: [
					 { name: 'name', type: 'string'},
					// { name: 'id',      		 type: 'int'     },
				],			 
			});
			 
			var CurrencyComboBox= Ext.create('Ext.form.ComboBox', {
				fieldLabel: 'Selling currency:',
				store: CurrencyStore,
				queryMode: 'remote',
				displayField: 'name',
				valueField: 'name', 
			//	allowBlank: false,	// добавляем валидацию на то что поле не пустое			
				msgTarget: 'side',
			});
			var PurchaseCurrencyComboBox= Ext.create('Ext.form.ComboBox', {
				fieldLabel: 'Purchase currency:',
				store: CurrencyStore,
				queryMode: 'remote',
				displayField: 'name',
				valueField: 'name', 
				value: 'USD', // default value
			//	allowBlank: false,
				msgTarget: 'side',
			/* 
				validator: function (value) {
					if (value!='') return true;
					else return false; //'The value should not be empty.';
				} */
			});
// end of Currency & Purchase Currency   -- ComboBox & store 

// CostCalculation -- ComboBox & store 
			var CostCalculationStore = Ext.create('Ext.data.Store', {
				fields: ['name'],  // FIFI, LIFO, WA
				data : [{ "name":"FIFI"}, { "name":"LIFO"}, { "name":"WA"}]
			});
			 
			var CostCalculationComboBox= Ext.create('Ext.form.ComboBox', {
				fieldLabel: 'Cost calculation method:',
				store: CostCalculationStore,
				queryMode: 'local',
				displayField: 'name',
				valueField: 'name', 
			});
// end of CostCalculation  -- ComboBox & store 

// ItemPosition -- ComboBox & store 
			var ItemPositionStore = Ext.create('Ext.data.Store', {
				fields: ['name'],  // R=Right, L = Left, RL= Right & Left, U= Up, RU = Right Up...
				data : [{ "name":"R"}, { "name":"L"}, { "name":"U"},{ "name":"D"}, { "name":"RU"},{ "name":"RD"}, { "name":"LU"}, { "name":"LD"}, { "name":"N/A - not applicable"}]
			});
			 
			var ItemPositionComboBox= Ext.create('Ext.form.ComboBox', {
				fieldLabel: 'Item Position',
				store: ItemPositionStore,
				queryMode: 'local',
				displayField: 'name',
				valueField: 'name', 
			});
// end of ItemPosition  -- ComboBox & store 

// ItemFamily -- ComboBox & store 
			var itemFamilyStore = Ext.create('Ext.data.Store', {
				fields: ['name'],
				data : [{ "name":"E"}, { "name":"J"}, { "name":"A"}, { "name":"K"}]
			});
			 
			var ItemFamilyComboBox= Ext.create('Ext.form.ComboBox', {
				fieldLabel: 'Item Family',
				store: itemFamilyStore,
				queryMode: 'local',
				displayField: 'name',
				valueField: 'name', 
			});
// end of  ItemFamily -- ComboBox & store 

// ItemCategory -- ComboBox & store 
			var ItemCategoryStore = Ext.create('Ext.data.Store', {
				fields: ['name'],  // Grille, Bumper, Fender
				data : [{ "name":"Grille"}, { "name":"Bumper"}, { "name":"Fender"}]
			});
			 
			var ItemCategoryComboBox= Ext.create('Ext.form.ComboBox', {
				fieldLabel: 'Item Category',
				store: ItemCategoryStore,
				queryMode: 'local',
				displayField: 'name',
				valueField: 'name', 
			});
// end of  ItemCategory -- ComboBox & store 
 
// ItemOrigin -- ComboBox & store    
			var ItemOriginStore = Ext.create('appMain.Store.UniversalStore', {
				modelName:"Assortment",     
				autoLoad: true,
				params: '&log=0&distinct=1&fields=country&compareField=country', 
				fields: [
					 { name: 'country', type: 'string'}, 
				],			 
			});
			 
			var ItemOriginComboBox= Ext.create('Ext.form.ComboBox', {
				fieldLabel: 'Item Origin',
				store: ItemOriginStore,
				queryMode: 'remote',
				displayField: 'country',
				valueField: 'country', 
				minChars: 3,
				//value: 'JAPAN', // default value
			});
// end of ItemOrigin -- ComboBox & store 

// Suppler Name -- ComboBox & store 
			var SupplerNameStore = Ext.create('appMain.Store.UniversalStore', {
				modelName:"User",     
				autoLoad: true,
				params: '&log=0&compareField=username', 
				fields: [
					 { name: 'username', type: 'string'},
					 { name: 'id',      		 type: 'int'     },
				],			 
			});
			 
			var SupplierNameComboBox= Ext.create('Ext.form.ComboBox', {
				fieldLabel: 'Supplier name',
				store: SupplerNameStore,
				queryMode: 'remote',
				displayField: 'username',
				valueField: 'id', 
			});
// end of  Suppler Name -- ComboBox & store  
			 
//  Subgroup -- comboBox & store для подгрупп	 
			 var SubgroupStore = Ext.create('appMain.Store.UniversalStore',{ 
				modelName:"Subgroup",     
				autoLoad: true,
				params: '&log=0&compareField=name',  
				fields: [
				 { name: 'name', type: 'string'},
				 { name: 'id',       type: 'int'     },
				],
		 	});
		 	//SubgroupStore.load(); 
  
			var SubgroupComboBox=Ext.create("Ext.form.field.ComboBox",{
			    fieldLabel: 'Item group:', 
			    width: 500,
			    store: SubgroupStore, 
			    tpl: Ext.create('Ext.XTemplate', '<tpl for=".">', '<div class="x-boundlist-item">{id} - {name}</div>', '</tpl>'), // - работает http://try.sencha.com/extjs/4.1.1/docs/Ext.form.field.ComboBox.2/viewer.html
			   // displayTpl: Ext.create('Ext.XTemplate', '<tpl for=".">', '{id} - {name}', '</tpl>'), // - не обязательно
			   tabIndex: 3,
			   //queryMode: 'local', //'remote',
			   displayField: 'name',
			   valueField: 'id',
			   // hideTrigger: true,
			   // editable: false,
			   typeAhead: true,
			   // enableKeyEvents :  true,
			   minChars: 3,
			 //  listeners: {		   },
		}); // end of comboBox for Subgroup  			
			
			//=== Машины 
		/*	this.ButtonAddUsedCars=Ext.create("Ext.Button",{
				icon: 'images/icons/CreateNew.png',
				handler: function() {
					var rec = new UsedCarsModel({
					});					
					me.UsedCarsStore.insert(0, rec);
					//me.FRecalc();					
				}
			});*/
			
			this.UsedCarsStore=Ext.create('Ext.data.Store', {
				//storeId:'UsedCarsStore',
				model: 'UsedCarsModel',				
				data:[
					{ 'manufacturer': 'BMW',  "series":"X SERIES",  "model":"X5", "year":"2005"  },
					{ 'manufacturer': 'BMW',  "series":"X SERIES",  "model":"X5", "year":"2011"   },
					{ 'manufacturer': 'BMW',  "series":"X3",  "model":"E83", 'year':'2005'   },
					{ 'manufacturer': 'BMW',  "series":"X1",  "model":"E84", 'year':'2005'   }
				], 
			});			
			
			this.UsedCars = Ext.create('Ext.grid.Panel', {
				title: 'Sample for multiple cars:',
				id: 'UsedCars',
				tbar:  {	xtype: 'toolbar',   
							items: {
								xtype: 'button',
								text: 'Add one to used cars',
								icon: 'images/icons/CreateNew.png',
								handler: function() {
									var rec = new UsedCarsModel({
									});					
									me.UsedCarsStore.insert(0, rec);
									//me.FRecalc();					
								},
							}, 
					},
				store: this.UsedCarsStore,
				plugins: {
					ptype: 'cellediting',
					clicksToEdit: 1
				},			
				columns: [
					{ text: 'Manufacturer', type: 'string',  dataIndex: 'manufacturer',editor:  'textfield', },
					{ text: 'Series', type: 'string', dataIndex: 'series', flex: 1,editor:  'textfield', },
					{ text: 'Model', type: 'string',  dataIndex: 'model',width:  50 ,editor:  'textfield',},
					{ text: 'Year', type: 'string', dataIndex: 'year',width:  50,editor:  'textfield', },
					{
						xtype:"actioncolumn", text: "Delete", width: 50, 
						items: [
							{xtype: 'button', icon: "images/icons/Delete.png", width: 30, tooltip: 'Delete Item',  
								handler: function(grid, rowIndex, colIndex) {
									var rec = grid.getStore().getAt(rowIndex); 
									grid.store.remove(rec);  
								}
							}, 
						]
					}						
					//{ text: 'username', type: 'string', dataIndex: 'username',width: 150 },
				],
				//height: 200,
				//width: 400,
				//renderTo: Ext.getBody()
			});			

			//=== Аналоги 
			this.StoreAnalogs=Ext.create("Ext.data.Store",{
				model: 'ModelAnalogi', 
			});
			
		/*	TextFieldNewAnalog=Ext.create("Ext.form.field.Text",{
				fieldLabel: 'Add new analog number:',
				//labelWidth: 70, 				
			});	 
			
			this.ButtonAddAnalogi=Ext.create("Ext.Button",{
				 icon: 'images/icons/CreateNew.png',
				 text: 'Add new analog',
				 handler: function() {
					var rec = new ModelAnalogi({
						number: TextFieldNewAnalog.getValue(),
						});					
					me.StoreAnalogs.insert(0, rec);
					me.FRecalc();					
				}
			});
		*/	
			this.GridAnalogi=Ext.create('Ext.grid.Panel', {
				title: 'Item analogs',
				store: me.StoreAnalogs, 
				tbar:  {	xtype: 'toolbar',   
							items: [{  
								text   : 'Add new analog',
								icon: 'images/icons/CreateNew.png',
								scope  : this,
								handler: function() {
									//var text = prompt('Please enter the new analog number'); 
									var text = Ext.MessageBox.prompt('New analog number', 'Please enter the new analog number', function(btn, text){ 
												if (text) { 
													var rec = new ModelAnalogi({number: text });
													me.StoreAnalogs.insert(0, rec);
													me.FRecalc();	
												}
									}); 									
								 },
							}]
					},
				columns: [
					{ text: 'Number', type: 'string',  dataIndex: 'number' },					
					{  xtype:"actioncolumn", text: "Remove", width: 50, 
						items: [
							{   xtype: 'button', icon: "images/icons/Delete.png", width: 70, 
								tooltip: 'Delete Item',  
								handler: function(grid,rowIndex,colIndex) {
									var rec = grid.getStore().getAt(rowIndex);  // определяю удаляемую запись по номеру строки
									//FRestoreAvailability(rec.get('idtitle'),rec.get('Warehouse'),rec.get('amount'));
									grid.store.remove(rec);  
									me.FRecalc(); 
								}
							}, 
						
						]
					}	
					
				]
				
			});
			
		//Добавление фото
			//this.InformationTitle.setValue('123'+this.FieldTitle);
			
			
			this.PhotoTextfield=Ext.create('Ext.form.field.Text');			
			
			this.Img=Ext.create('Ext.Img', {
				src: 'http://www.sencha.com/img/20110215-feat-html5.png',
				//renderTo: Ext.getBody()
			});
			
	 
		/*	Ext.ux.form.FileUploadField.override({
				onChange : function() {
					var fullPath = this.getValue();
					var lastIndex = fullPath.lastIndexOf('\\');
					if (lastIndex == -1)
							return;
					var fileName = fullPath.substring(lastIndex + 1);
					this.setValue(fileName);
				}
			});*/
			
			
			this.PhotoPanel= Ext.create('Ext.form.Panel', {
				title: 'Photos',
				overflowY: 'scroll',
				//method: 'GET',
				fileUpload: true,
				dockedItems: [{
					xtype: 'fileuploadfield',
					id: 'file',
					emptyText: 'Select a file to upload...',
					name:'ufile',
					fieldLabel: 'Upload new photo',
					allowBlank: false,
					//msgTarget: 'side', 
					buttonText: 'Select File...',
					listeners: {
						'change': function(value, eOpts ){
							var File=Ext.getCmp('file').getValue();
							// из-за проблем с тем что браузеру не передаётся правильный путь к файлу, а что то такое: C:\fakepath\<file real name> то надо заменить эту строку. Это проявляется в некоторых браузерах: GChrome, IE10
							// http://www.sencha.com/forum/showthread.php?107982-FileUpload-fakepath&p=1062950#post1062950
					/*	if(File.indexOf('C:\\fakepath\\') != -1) 
						 		File = File.replace('C:\\fakepath\\', '');	//console.log('file name = ', File );  
						*/	
							var form = this.up('form').getForm();
							//form.method='GET';
							if (form.isValid()) {
									form.submit({
									//url: 'php/upload.php',
									url: 'upload.php', 
									waitMsg: 'Loading...',
									
									success: function(form, o) {
										//alert(o.response.responseText);
										//console.log(o.response.responseText);
										//Ext.Msg.alert('Loading of file successfull', 'File ' +File +" uploaded!");
										var OldValue=me.PhotoTextfield.getValue();
										me.PhotoTextfield.setValue(OldValue+File+',');
										me.FPhotoDeleteButton('Add');										
									},
									failure: function(form, o) {
										console.log(o.response.responseText);
										if (o.response.responseText=='Error: File size > 64K.'){
											Ext.Msg.alert('Loading not successfull', 'Size of file must be < 10MB !');
										}else if(o.response.responseText=='Error: Invalid file type.'){
											Ext.Msg.alert('Loading not successfull', 'Invalid file type. Allowed file types are: gif, jpg, png, jpeg, JPG!');
										}else{
											Ext.Msg.alert('Loading not successfull', 'Loading was not successfull!');
										}
									} 

								});
							}
						}
					},
					
					
				}, 
				//this.PhotoTextfield
				],
				//html: '<table border=1 ><tr><td><img width=500 src="images/catalog/n5hgm1dxth0.jpeg"></td><td>1</td></tr></table>',
				//items: [this.Img]
				
				 
			});
			
			if (this.Record1 != '')  //  если не новая запись
			{
		//=== Движения номенклатуры [если не новая запись] === 
				this.ItemMovementStore=Ext.create('appMain.Store.UniversalStore',{ 
					modelName:"AsortmentRemains", 
					//pageSize: 5,	
					params: '&log=0',
					fields: [
						{name: 'eventid', type: 'int'},
						{name: 'eventdate', type: 'string'}, 
						{name: 'amount', type: 'int'},
						{name: 'sum', type: 'double'},
						{name: 'contractor', type: 'string'},
						{name: 'event', type: 'string'},
					]
				});
				//this.filter= '[{"property":"isCustomer","value": "1"}';
				//this.ItemMovementStore.getProxy().setExtraParam('filter' , this.filter);			
				Ext.Ajax.request({ 
					//this.filter=[{'Assortment id': me.Record1}];				
					url:'index.php?r=Backend/Remains&ident='+me.Record1+'&UserId=' + UserId,
					//this.filter,
					method: 'get',   
					scope:this, 
					success: function(response){
						this.ItemMovementStore.load(); 
					}						
				});
			} // конец движения номенклатуры
			
			this.ItemMovementGrid=Ext.create("Ext.grid.Panel",{
				columnLines:true,
				//height: 200,
				viewConfig:{enableTextSelection: true},				
				tbar:Ext.create("Ext.PagingToolbar", {
							xtype: 'pagingtoolbar',
							store: this.ItemMovementStore,
							displayInfo: true,
							//pageSize: 5,
							displayMsg: "Displaying records {0} - {1} of {2}",
							emptyMsg: 'NO_RECORDS_TO_DISPLAY',
				}),	
				store: this.ItemMovementStore, 			
						
				columns:  [
					{dataIndex: 'event', type: 'string', text: "Event"},
					{dataIndex: 'eventid', type: 'int', text: "Number"},
					{dataIndex: 'eventdate', type: 'string', text: "Date"}, 
					{dataIndex: 'contractor', type: 'string', text: "Contractor"},
					{dataIndex: 'amount', type: 'int', text: "Qty"},
					{dataIndex: 'sum', type: 'double', text: "Sum"},
					//{dataIndex: 'event', type: 'string', text: "Name"},					
					//{dataIndex: 'username', type: 'string', text: "Name", width: 150 },						
				],
			});		
			
		//=== Основная панель 
			this.AssortmentInformationPanel=Ext.create('Ext.tab.Panel', {
				items: [
					this.PhotoPanel,
					{ title: 'Information',
						items: 
						[ InformationTitle, SubgroupComboBox, InformationArticle, InformationOem , ItemPositionComboBox, ItemOriginComboBox,
						   InformationUser , InformationDateTime, InformationSpecialDescription   ]
					},					
					{ title: 'Cost',
						items:[ InformationFOBCost,  PurchaseCurrencyComboBox, InformationPriceS,CurrencyComboBox, CostCalculationComboBox, InformationLeadTime, InformationRealLeadTime ]						
					},
					{ title: 'Cars',
						items:[InformationManufacturer, InformationModel, InformationMake,  InformationYearBegin, InformationYearEnd, /*this.ButtonAddUsedCars*/, this.UsedCars]						
					},
					{ title: 'Item Codes & Numbers',
						items:[InformationPartN,InformationSchneiderN,InformationSchneiderOldN,InformationTradeN, InformationItemCode, /*	this.InformationAnalogi, TextFieldNewAnalog,  this.ButtonAddAnalogi*/ 
						
						 ItemFamilyComboBox, ItemCategoryComboBox, InformationSupplierCode,  SupplierNameComboBox /* (should be comboBox)*/ , InformationPIN, InformationBarcode, InformationTechInfo  , this.GridAnalogi ]
					},
					{ title: 'Item movement',
						items: [this.ItemMovementGrid],					
					}
				]
			
			});
			this.title= (this.Record1) ? 'Assortment item "' + this.itemTitle + '" ' : 'A new assortment item';
			
			this.items= [
				this.AssortmentInformationPanel				
			];
			
			if (this.Record1 != '') { 
				// cоздаём store для хранения существующей записи и загружаем её.
				this.StoreAssortmentInformationWindow=Ext.create('appMain.Store.UniversalStore',{ 
					modelName:"Assortment", 
					params: '&log=0&id='+this.Record1,
					fields: [
						//{name: 'article', type: 'string'},
						{ name:"article", text: "Article", width: 100 ,type: 'string'},
						{ name:"oem", text: "Oem", width: 100,type: 'string'},
						{ name:"title", text: "Title", width: 150, type: 'string'},
						{ name:"model", text: "Model", width: 100 ,type: 'string'},
						{ name:"make", text: "Make", width: 100 ,type: 'string'},
						{ name:"PartN", text: "PartN", width: 50 ,type: 'string'},
						{ name:"SchneiderN", text: "SchneiderN", width: 50 ,type: 'string'},
						{ name:"SchneiderOldN", text: "SchneiderOldN", width: 50,type: 'string' },
						{ name:"TradeN", text: "TradeN", width: 50,type: 'string' },
						{ name:"Analogi", text: "Analogi", width: 50,type: 'string' },
						{ name:"manufacturer", text: "Manufacturer", width: 100,type: 'string' },
						{ name:"subgroup", text: "Subgroup", width: 100,type: 'string' },
						{ name:"country", text: "Country", width: 100,type: 'string' },
						{ name:"availability", text: "Qty", width: 50,type: 'string' },
						{ name:"priceS", text: "Price", width: 50,type: 'double' },
						{ name:"Warehouse", text: "Warehouse", width: 50, type: 'string' },
						{ name:"Photos", type: 'string' },
						{ name:"userId", text: "User created this item", type: 'int' },
						{ name:"date", text: "Date & time when this item was created", type: 'string' },
						{ name:"ItemCode", text: "Item Code", type: 'string' },
						{ name:"ItemPosition", text: "Item Position", type: 'string' },
						{ name:"FOBCost", text: "FOB cost", type: 'double' },
						{ name:"CostCalculation", text: "Cost calculation", type: 'string' },
						{ name:"PurchaseCurrency", text: "Purchase Currency", type: 'string' }, 
						{ name:"Currency", text: "Currency", type: 'string' }, 
						{ name:"YearBegin", text: "Year Begin", type: 'string' }, 
						{ name:"YearEnd", text: "Year End", type: 'string' }, 
					 
						{ name:"ItemOrigin", text: "Item Origin", type: 'string' },
						{ name:"ItemFamily", text: "Item Family", type: 'string' },
						{ name:"ItemCategory", text: "Item Category", type: 'string' },
						{ name:"techInfo", text: "Tech info", type: 'string' },
						{ name:"LeadTime", text: "Lead Time", type: 'int' },
						{ name:"RealLeadTime", text: "Real Lead Time", type: 'int' },
						{ name:"SupplierCode", text: "Supplier Code", type: 'int' },
						{ name:"specialDescription", text: "Special description", type: 'string' },
						{ name:"Barcode", text: "Barcode", type: 'string' }, 
						{ name:"PIN", text: "PIN", type: 'string' }, 
					],
				});
				// из этого store мы заносим данные в information поля
				this.StoreAssortmentInformationWindow.load(function(records) { 
				  
					Ext.each(records, function(record){ 
						if ('' != record.get('title')) 
							InformationTitle.setValue(record.get('title'));
						else 
						{  // заполняем это описание по формуле title = f(make, model, year, Item category, specialDescription, ItemPosition) 
						   // пример: BM E36 01-02 Fender, 4mm,  Aluminum, R
						   var tempArr = [record.get('make'), record.get('model'), record.get('YearBegin') + '-' + record.get('YearEnd'), record.get('ItemCategory'), record.get('specialDescription'), record.get('ItemPosition')];
						   InformationTitle.setValue(tempArr.join(' '));						
						}
						InformationArticle.setValue(record.get('article'));
						InformationOem.setValue(record.get('oem'))	;
						InformationModel.setValue(record.get('model'));
						InformationMake.setValue(record.get('make'));				
						
						InformationManufacturer.setValue(record.get('manufacturer'))	;
						InformationPartN.setValue(record.get('PartN'))	;
						InformationSchneiderN.setValue(record.get('SchneiderN'))	;
						InformationSchneiderOldN.setValue(record.get('SchneiderOldN'))	;
						InformationTradeN.setValue(record.get('TradeN'))	;
						me.InformationAnalogi.setValue(record.get('Analogi'))	;
						me.PhotoTextfield.setValue(record.get('Photos'))	;
						InformationUserId.setValue( record.get('userId')); // сохраняем id в скрытом поле для последующей передачи обратно на сервер
						
						InformationDateTime.setValue(record.get('date'));
						InformationItemCode.setValue(record.get('ItemCode'));
						InformationFOBCost.setValue(record.get('FOBCost'));
						InformationPriceS.setValue(record.get('priceS'));
				 		
					 	InformationTechInfo.setValue(record.get('techInfo'));
						InformationSupplierCode.setValue(record.get('SupplierCode'));
						InformationLeadTime.setValue(record.get('LeadTime')); 
						InformationRealLeadTime.setValue(record.get('RealLeadTime')); 
						InformationBarcode.setValue(record.get('Barcode'));			
						InformationSpecialDescription.setValue(record.get('specialDescription'));			
						InformationPIN.setValue(record.get('PIN'));			
						InformationYearBegin.setValue(record.get('YearBegin'));			
						InformationYearEnd.setValue(record.get('YearEnd'));			
						
				// загружаем величины в разные comboBoxes		
						SubgroupComboBox.setValue( parseInt(record.get('subgroup')) ); // должно быть числом
						SupplierNameComboBox.setValue( parseInt(record.get('SupplierCode')) ); // должно быть числом
						ItemFamilyComboBox.setValue(  record.get('ItemFamily') );
						ItemOriginComboBox.setValue(  record.get('ItemOrigin') );
						ItemCategoryComboBox.setValue(  record.get('ItemCategory') );
						ItemPositionComboBox.setValue(  record.get('ItemPosition') );
						CostCalculationComboBox.setValue(  record.get('CostCalculation') );
						CurrencyComboBox.setValue(  record.get('Currency') );
						PurchaseCurrencyComboBox.setValue(  record.get('PurchaseCurrency') );
					
						if( record.get('userId')!=0 ){ // загружаем через ajax имя создателя записи если его код не равен 0		
							Ext.Ajax.request({ 
								url: 'index.php?r=User/returnUsername',
								params: { id :  record.get('userId') },
								method: 'get', scope: this, 							
								success: function(response) {	
									InformationUser.setValue(response.responseText); 	 
									},
							});  
						} 
						
						//me.PhotoPanel.html='<table border=1>';
						ArrayPhotos=record.get('Photos').split(',');
						for (var i = 0; i < ArrayPhotos.length; i++) {
							if (ArrayPhotos[i]!=''){
								this.Photo=Ext.create('Ext.Img', {
									src: 'images/catalog/'+ArrayPhotos[i],
									width: 500,
								});
								this.PhotoDeleteButton=Ext.create("Ext.Button",{
									icon: 'images/icons/Delete.png',
									itemId: i,
									handler: function() {
										me.FPhotoDeleteButton(this.itemId);
									}
								});								
								me.PhotoPanel.add(this.Photo); 
								me.PhotoPanel.add(this.PhotoDeleteButton); 
							} 
							//	me.PhotoPanel.html+='<tr><td><img src="images/catalog/'+ArrayPhotos[i]+'"></td><td>1</td></tr>';					
						}
						//me.PhotoPanel.html+='</table>';
						//console.log(me.PhotoPanel.html);
						
						ArrayInformationAnalogi = record.get('Analogi').split(',');
						for (var i = 0; i < ArrayInformationAnalogi.length; i++) {
							
							if (ArrayInformationAnalogi[i]!=''){
								var rec = new ModelAnalogi({
									number: ArrayInformationAnalogi[i],
								});							
								me.StoreAnalogs.insert(0, rec);
							}						
						}					
						
				   });
				});		
			} // конец загрузки StoreAssortmentInformationWindow существующей записью this.Record1 через store
			else // мы загружаем в новую запись параметры текущего пользователя
			{
				InformationUser.setValue( UserName); // имя текущего залогиненного пользователя
				InformationUserId.setValue(UserId);		// id текущего залогиненного пользователя в скрытое поле	
			}
			this.CmpArr = [ InformationTitle, SubgroupComboBox, InformationArticle, InformationOem , ItemPositionComboBox, ItemOriginComboBox  ,
				InformationUser , InformationDateTime, InformationSpecialDescription,InformationFOBCost,  PurchaseCurrencyComboBox, InformationPriceS,CurrencyComboBox, CostCalculationComboBox, InformationLeadTime, InformationRealLeadTime , InformationManufacturer, InformationModel, InformationMake,  InformationYearBegin, InformationYearEnd, InformationPartN,InformationSchneiderN,InformationSchneiderOldN, InformationTradeN, InformationItemCode, ItemFamilyComboBox, ItemCategoryComboBox, InformationSupplierCode,  SupplierNameComboBox   , InformationPIN, InformationBarcode, InformationTechInfo  
						   ];
			
			//this.initStore();
			this.callParent(); 
		},
		
		FRecalc:function(){
			var  InformationAnalogiNew='';
			Ext.each(this.StoreAnalogs.data.items, function(record)
				{				
					InformationAnalogiNew+=''+record.get('number')+', ';
				});
			this.InformationAnalogi.setValue(InformationAnalogiNew);		
		},		
		FPhotoDeleteButton:function(itemId){
		
			console.log(itemId);
			ArrayPhotos=me.PhotoTextfield.getValue().split(',');
			var ArrayPhotos1=[];
			
			
			//ArrayPhotos= ["Scr31.jpg", "Scr32.jpg", "Scr33.jpg"]; 
			if(itemId!='Add'){
			

				console.log(ArrayPhotos);
				for (var i = 0; i < ArrayPhotos.length; i++) { 
					if (i!=itemId) ArrayPhotos1.push(ArrayPhotos[i]);
				}
				//ArrayPhotos=ArrayPhotos.splice(0,2);
				console.log(ArrayPhotos1);
				me.PhotoTextfield.setValue(ArrayPhotos1.join(','));
				
				//var SF=me.PhotoTextfield.getValue().indexOf(',');
				//if (SF=-1) me.PhotoTextfield.setValue(ArrayPhotos.join(',')+',');
			}else{
					ArrayPhotos1=ArrayPhotos; 
			}
			//console.log(ArrayPhotos);
			me.PhotoPanel.removeAll(true);
			
			for (var i = 0; i < ArrayPhotos1.length; i++) { 
						if (ArrayPhotos1[i]!=''){
							this.Photo=Ext.create('Ext.Img', {
								src: 'images/catalog/'+ArrayPhotos1[i],
								width: 500,
							});
							this.PhotoDeleteButton=Ext.create("Ext.Button",{
								icon: 'images/icons/Delete.png',
								itemId: i,
								handler: function() {
									me.FPhotoDeleteButton(this.itemId);
								}
							});
							
							me.PhotoPanel.add(this.Photo); 
							me.PhotoPanel.add(this.PhotoDeleteButton); 
						} 
						//	me.PhotoPanel.html+='<tr><td><img src="images/catalog/'+ArrayPhotos[i]+'"></td><td>1</td></tr>';
			}			
			//this.filter= '[{"property":"id","value": "'+this.Record1+'"]';
		}	
	/*	baseName:function(str)
		{
		  // var base = new String(str).substring(str.lastIndexOf('/') + 1); 
		   var base = new String(str).substring(str.lastIndexOf('\\') + 1); 
			if(base.lastIndexOf(".") != -1)       
				base = base.substring(0, base.lastIndexOf("."));
		   return base;
		}*/
		
	});