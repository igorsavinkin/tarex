var textfield = Ext.create("Ext.form.field.Text",{
				xtype:"textfield",
				allowBlank:false,
				name:"title",
				fieldLabel:"Title",
				//value: id.get("change"),
				value: 99,
			});
			
var $dynamicFields = ['Id', 'Subject', 'Begin', 'EventTypeId'];

var $columnsDynamic =  [
				{ text: 'id',  dataIndex: 'Id' },
				{ text: 'title', dataIndex: 'Subject', flex: 1 },
				{ text: 'begin', dataIndex: 'Begin' },
				{ text: 'Type', dataIndex: 'EventTypeId' }
			];
var $dynamicGridFiltersCfg = {
			ftype: 'filters',
			autoReload: false, //don't reload automatically
			local: true, //only filter locally			
			updateBuffer : 400,
			// filters may be configured through the plugin,
			// or in the column definition within the headers configuration
			filters: [{
				type: 'numeric',
				dataIndex: 'id'
			},{
				type: 'string',
				dataIndex: 'Subject',				
			}, {
				type: 'datetime',
				dataIndex: 'Begin'
			}, {
				type: 'numeric',
				dataIndex: 'EventTypeId'
			}]
		}; 