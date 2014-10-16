Ext.ns('appMain.Lang');	

function FappLangRu (str) {
	return Messages[str] ? Messages[str] : str;
	

}


function FappLangArab (str) {

if (str=='ACTION') return "Arab1";
if (str=='ACTION1') return "Arab2";

};


appMain.Lang.ComboBoxLang = Ext.create("Ext.form.ComboBox",{

//var ComboBoxLang = Ext.create('Ext.form.ComboBox', {
     fieldLabel: '',
	 width: 50,
//    store: states,
	 store: ['en','ru','arab'],
	 value: Language, 
	 listeners:{
         //scope: yourScope,
        'change':function (combo, newValue, OldValue) {
            window.location.href = 'index.php?r=site/backendpavel&Language='+this.value;
        }
    }
    //queryMode: 'local',
    //displayField: 'name',
   // valueField: 'abbr',
    //renderTo: Ext.getBody()
});




function FLang(str){
//console.log('lang '+ComboBoxLang.getValue());

if (appMain.Lang.ComboBoxLang.getValue()=='en')
	return str;
else if (appMain.Lang.ComboBoxLang.getValue()=='ru')
	return FappLangRu(str);
else  
	return str;	
};


