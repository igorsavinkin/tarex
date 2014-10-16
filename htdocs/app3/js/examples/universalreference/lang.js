
function FappLangRu (str) {

var Value1=str;

if (str=='ACTION') Value1= "Действие";
if (str=='ACTION1') Value1="Действие1";
if (str=='CAR BODY') Value1="Правильно";

return Value1; 

}


function FappLangArab (str) {

if (str=='ACTION') return "Arab1";
if (str=='ACTION1') return "Arab2";


}

/*
var appLangRu = {


ACTION:"Действие",ACTIVE:"Активен",ACCES_DENIED:"Доступ запрещен"




}
*/

var ComboBoxLang = Ext.create('Ext.form.ComboBox', {
    fieldLabel: 'Choose Language',
//    store: states,
	 store: ['en','ru','arab'],
	 value: 'en',
    //queryMode: 'local',
    //displayField: 'name',
   // valueField: 'abbr',
    //renderTo: Ext.getBody()
});






function FLang(str ){


console.log('lang '+ComboBoxLang.getValue());

if (ComboBoxLang.getValue()=='en')
	return str;
else if (Lang1.getValue()=='ru')
	return FappLangRu(str);
else  
	return str;
	
}


