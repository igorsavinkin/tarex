// месяцы
function FBeginOfMonth(MyDate){
	return new Date(MyDate.getFullYear(),MyDate.getMonth(),'01');  
}

function FEndOfMonth(MyDate){
    return new Date(MyDate.getFullYear(),MyDate.getMonth(),new Date(MyDate.getFullYear(),MyDate.getMonth()+1,0).getDate());  // 28 February 2014
}

// недели 
function FBeginOfWeek(d) { 
  var day = d.getDay(),
       diff = d.getDate() - day + (day == 0 ? -6:1); // adjust when day is sunday
  return new Date(d.setDate(diff));                    // console.log('monday = ' + MyDate);  
} 
function FEndOfWeek(d) { 
  var day = d.getDay(),
       diff = d.getDate() - day + (day == 0 ? -6:1) + 7; // adjust when day is sunday
  return new Date(d.setDate(diff));                    // console.log('monday = ' + MyDate);  
} 

// дни
function FBeginOfDay(MyDate) { 
   return new Date(MyDate.setHours(0,0,0,0));    
} 
function FEndOfDay(MyDate) { 
   return new Date(MyDate.setHours(23,59,59,999));   
} 
/*
// проверка
var d= new Date(2014 , 0, 1);
console.log('monday = ' + FBeginOfWeek(d));
console.log('sunday = ' + FEndOfWeek(d)); 
var g = new Date();
console.log('begin of day = ' + FBeginOfDay(g));
console.log('end of day = ' + FEndOfDay(g));
*/