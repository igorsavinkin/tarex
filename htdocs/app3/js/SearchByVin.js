function FSeachByVin(vin){
  var request;
  if(window.XMLHttpRequest){
      request = new XMLHttpRequest();
  } else if(window.ActiveXObject){
      request = new ActiveXObject("Microsoft.XMLHTTP");  
  } else {
      return;
  }
 
  request.onreadystatechange = function(){
        switch (request.readyState) {
          case 1: //print_console("<br/><em>1: Подготовка к отправке...</em>"); break
          case 2:// print_console("<br/><em>2: Отправлен...</em>"); break
          case 3: //print_console("<br/><em>3: Идет обмен..</em>"); break
          case 4:{
           if(request.status==200){    
                       // print_console("<br/><em>4: Обмен завершен.</em>");
                        //document.getElementById("printResult").innerHTML = "<b>"+request.responseText['Vehichles']+"</b>";
						
                        //document.getElementById("printResult").innerHTML = "<b>"+request.responseText+"</b>";
                        document.getElementById("printResult").innerHTML = "<b>"+FDataLoaded(request.responseText)+"</b>";
                     }else if(request.status==404){
                        //alert("Ошибка: запрашиваемый скрипт не найден!");
                     }
                      else //alert("Ошибка: сервер вернул статус: "+ request.status);
           
            break
            }
        }      
    }
	url='http://comprir.herokuapp.com/api/vehicle_by_vin?vin='+vin;
    request.open ('GET', url, true);
    request.send ('');
  }
  
  function FDataLoaded(text){
	 value='<table border=1><tr><th>Дата</th><th>Двигатель</th><th>Цвет кузова</th><th>Модель</th><th>Наименование</th><th>Цвет салона</th><th>Идентификатор</th><th>Трансмиссия</th><th>Регион</th><th>Год производства</th><th>Модификация</th><th>Бренд</th></tr>';
	 //var values = obj.substr(100,120); //анализируем ответ сервера
	 var Vehichles = json_decode(text).Vehichles;
	for(var i=0; i<Vehichles.length; i++) {
	  date=Vehichles[i].date;
	  engine=Vehichles[i].engine;
	  framecolor=Vehichles[i].framecolor; //цвет кузова
	  model=Vehichles[i].model;
	  name=Vehichles[i].name;
	  trimcolor=Vehichles[i].trimcolor; //цвет салона
	  vehicleid=Vehichles[i].vehicleid; //Идентификатор
	  transmission=Vehichles[i].transmission;
	  manufactured=Vehichles[i].manufactured; //Год производства
	  destinationregion=Vehichles[i].destinationregion; //Регион
	  brand=Vehichles[i].brand;
	  modification=Vehichles[i].modification;
	  
	   value+='<tr><td>'+date+'</td><td>'+engine+'</td><td>'+framecolor+'</td><td><a href="index.php?r=assortment/index&Assortment[model]='+model+'">'+model+'</a></td><td>'+name+'</td><td>'+trimcolor+'</td><td>'+vehicleid+'</td><td>'+transmission+'</td><td>'+destinationregion+'</td><td>'+manufactured+'</td><td>'+modification+'</td><td>'+brand+'</td></tr>';
	  
	}
	value+='</table>' 
	 //foreach (Vehichles 
	 
	 //value=Vehichles[0].name;
	 //value=json_decode(text).Vehichles[0].name+text;
	 //value+=text;
	 
	 //return json_decode(text).result;
	 return value;
  }
  
  function print_console(text){
    document.getElementById("console").innerHTML = text;
  }
  
  function key(event) {return ('which' in event) ? event.which : event.keyCode;}
  
  function json_decode(str_json) {
  //       discuss at: http://phpjs.org/functions/json_decode/
  //      original by: Public Domain (http://www.json.org/json2.js)
  // reimplemented by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //      improved by: T.J. Leahy
  //      improved by: Michael White
  //        example 1: json_decode('[ 1 ]');
  //        returns 1: [1]

  /*
    http://www.JSON.org/json2.js
    2008-11-19
    Public Domain.
    NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.
    See http://www.JSON.org/js.html
  */

  var json = this.window.JSON;
  if (typeof json === 'object' && typeof json.parse === 'function') {
    try {
      return json.parse(str_json);
    } catch (err) {
      if (!(err instanceof SyntaxError)) {
        throw new Error('Unexpected error type in json_decode()');
      }
      this.php_js = this.php_js || {};
      this.php_js.last_error_json = 4; // usable by json_last_error()
      return null;
    }
  }

  var cx = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;
  var j;
  var text = str_json;

  // Parsing happens in four stages. In the first stage, we replace certain
  // Unicode characters with escape sequences. JavaScript handles many characters
  // incorrectly, either silently deleting them, or treating them as line endings.
  cx.lastIndex = 0;
  if (cx.test(text)) {
    text = text.replace(cx, function(a) {
      return '\\u' + ('0000' + a.charCodeAt(0)
        .toString(16))
        .slice(-4);
    });
  }

  // In the second stage, we run the text against regular expressions that look
  // for non-JSON patterns. We are especially concerned with '()' and 'new'
  // because they can cause invocation, and '=' because it can cause mutation.
  // But just to be safe, we want to reject all unexpected forms.
  // We split the second stage into 4 regexp operations in order to work around
  // crippling inefficiencies in IE's and Safari's regexp engines. First we
  // replace the JSON backslash pairs with '@' (a non-JSON character). Second, we
  // replace all simple value tokens with ']' characters. Third, we delete all
  // open brackets that follow a colon or comma or that begin the text. Finally,
  // we look to see that the remaining characters are only whitespace or ']' or
  // ',' or ':' or '{' or '}'. If that is so, then the text is safe for eval.
  if ((/^[\],:{}\s]*$/)
    .test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, '@')
      .replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']')
      .replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

    // In the third stage we use the eval function to compile the text into a
    // JavaScript structure. The '{' operator is subject to a syntactic ambiguity
    // in JavaScript: it can begin a block or an object literal. We wrap the text
    // in parens to eliminate the ambiguity.
    j = eval('(' + text + ')');

    return j;
  }

  this.php_js = this.php_js || {};
  this.php_js.last_error_json = 4; // usable by json_last_error()
  return null;
}


