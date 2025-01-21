///////// Collecting Month name /////////////
function show_month(month){

var month_name=new Array(12);
month_name[0]="Jan"
month_name[1]="Feb"
month_name[2]="March"
month_name[3]="April"
month_name[4]="May"
month_name[5]="June"
month_name[6]="July"
month_name[7]="Aug"
month_name[8]="Sept"
month_name[9]="Oct"
month_name[10]="Nov"
month_name[11]="Dec"

return month_name[month];

}
///// End of collecting month name ////////////

//// Collect all date variables /////////////
function cal(chm,chy,month,year,bt,sub){
//alert('chm : ' + chm + ' chy ' + chy + ' month ' + month + ' year ' + year + ' bt ' + bt + ' sub ' + sub);
month=month + chm;
year=year + chy;
dt=new Date(year, month, 01);// Date object
var year=dt.getFullYear(); // read the current year
var display_month=dt.getMonth();
var return_month=display_month +1; 
var display_month_name=show_month(display_month);
var first_day=dt.getDay(); //, first day of present month

dt.setMonth(month+1,0); // Set to next month and one day backward.
var last_date=dt.getDate(); // Last date of present month
///// End of date variables ////////////
///// Start lower and upper date matching logic /////
/// if 2nd calendar is used  or TO date is used //
if(bt=='t2'){
var check_type='low_side';
var t1=document.getElementById('t1').value
t1=t1.split('-');
//alert(t1[1]);
dt_t1=new Date(t1[0],t1[1],t1[2]);
dt_t_tm=dt_t1.getTime();
}
//// if 1st calendar is used or FROM date is used  ////
if(bt=='t1'){
var check_type='high_side';
var t2=document.getElementById('t2').value
t2=t2.split('-');
//alert(t1[1]);
dt_t2=new Date(t2[0],t2[1],t2[2]);
dt_t_tm=dt_t2.getTime();
}
////////// end of 1st calendar //////


//// End of lower and upper date matching logic /////
var dy=1; // day variable for adjustment of starting date.
// Top display Links with present Month & year // 
var str1="<td><a href=# onclick=show_cal(0,-1," + display_month + "," + year + ",'" + bt + "','" + sub + "');><< </a> </td><td>   <a href=# onclick=show_cal(-1,0," + display_month + "," + year + ",'" + bt + "','"+ sub + "');><</a> </td><td> "+ display_month_name +"</td><td> " + year + " </td><td align=right><a href=# onclick=show_cal(1,0," + display_month + "," + year + ",'" + bt +"','" + sub + "');>></a> </td><td> <a href=# onclick=show_cal(0,1," + display_month + "," + year + ",'" + bt +"','" + sub + "');>>></a></td>";
// End of top display links /////

// Display calendar body ////
var str = '';
str = "<table class='main' ><tr> " + str1 + "  <td  align=right>";
str += " <a href=# onclick=\"close_cal('" + sub +"' );\";>X</a></td></tr>";  // adding the close button. 
str +="<tr><th>Su</th><th>Mon</th><th>Tue</th><th>Wed</th>";
str +="<th>Thu</th><th>Fri</th><th>Sat</th></tr>";

for(i=0;i<=41;i++){
if((i%7)==0){str = str + "</tr><tr>";} // if week is over then start a new line
if((i>= first_day) && (dy<= last_date)){
//// display the date ///
/// create date object ///
var dt_today = new Date(year,return_month,dy); 
var dt_today_tm=dt_today.getTime();
switch(check_type)
{
case 'low_side':
if(dt_today_tm < dt_t_tm) {
str = str + "<td >"+ dy +"</td>";
}else{
str = str + "<td bgcolor='#ccffcc'><a href=# onclick=return_value(" + return_month + "," + dy + ","+ year + ",'"+ bt +"','" + sub + "');> "+ dy +"</a></td>";
}
dy=dy+1;
break;
////////
case 'high_side':
if(dt_today_tm > dt_t_tm) {
str = str + "<td >"+ dy +"</td>";
}else{
str = str + "<td bgcolor='#ccffcc'><a href=# onclick=return_value(" + return_month + "," + dy + ","+ year + ",'"+ bt +"','" + sub + "');> "+ dy +"</a></td>";
}
dy=dy+1;
break;
//////////////// 
default:
str = str + "<td bgcolor='#ccffcc'><a href=# onclick=return_value(" + return_month + "," + dy + ","+ year + ",'"+ bt +"','" + sub + "');> "+ dy +"</a></td>";
dy=dy+1;
break; 
} // end of switch 


////////// end of date display ///
}else {str = str + "<td>*</td>";} // Blank dates.
} // end of for loop

str = str + "</tr></table>";
//alert(str);
return str; 
}

function show_cal(chm, chy,month,year,bt,sub) {
document.getElementById(sub).innerHTML = cal(chm,chy,month,year,bt,sub);
document.getElementById(sub).style.display = 'inline';
}
//// Stop displaying calendar ///////////
function close_cal(sub) {
document.getElementById(sub).style.display = 'none';
}
// 
function start_cal(bt,sub) {
var dt_object=new Date();
var month=dt_object.getMonth();
var year=dt_object.getFullYear();
show_cal(0,0,month,year,bt,sub);
}

function return_value(month,dt,year,bt,sub){
document.getElementById(bt).value=year + '-' + month + '-' + dt   ;
close_cal(sub);
month = month -1 ; // Month adjustment 
if(bt=='t1'){
//start_cal('t2','calendar2');
show_cal(0,0,month,year,'t2','calendar2');
}
//if(bt=='t2'){
//show_cal(0,0,month,year,'t1','calendar1');
//}
}

