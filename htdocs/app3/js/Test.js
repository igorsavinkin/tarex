
Ext.define('User', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'Id',  type: 'int'},
        {name: 'Name', type: 'string'}
    ]
});
 


 var myStore  = Ext.create('Ext.data.Store', {
     model: 'User',
     data : [
         {Id: '13',    Name: 'Spencer'},
         {Id: '24', Name: 'Maintz'},
     ]
 });
 
 
var Store= Ext.create('Ext.data.Store',{ 
			model: 'User',
			proxy :
			{ 
				url:  "index.php?r=backend/index&Table=Cityes&log=0", 
				reader: { 
					 root: "data",
					 totalProperty: "count",
					 type: "json"
				},
				type:"ajax",
			} 
			
 });
 
 
