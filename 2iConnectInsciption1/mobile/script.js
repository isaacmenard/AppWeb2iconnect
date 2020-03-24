function addZero(i) {
  if (i < 10) {
    i = "0" + i;
  }
  return i;
} 
if(document.getElementById("messageBonjour")){
refreshHour()
setInterval(function(){ 
  refreshHour()
 },1000)}

function refreshHour(){
	var d = new Date();
  var x = document.getElementById("hour");
  var h = addZero(d.getHours());
  var m = addZero(d.getMinutes());
  var s = addZero(d.getSeconds());
  var day = d.getDate();
var tab_mois=new Array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
  x.innerHTML = h + " h " + m + "<br> " + day + " "+ tab_mois[d.getMonth()] +" "+ d.getFullYear();
	if(h > 11){
document.getElementById("messageBonjour").innerHTML = "Good Afternoon !";
	}
		if(h > 18){
document.getElementById("messageBonjour").innerHTML = "Good Evening !";
	}
}

for(var i = 0; i < document.getElementsByClassName("contenaire").length;i++){
	document.getElementsByClassName("contenaire")[i].addEventListener('click', function (ev) {
	  if(ev.target.className == "contenaire" || ev.target.className == "contenaire active" || ev.target.className == "canCLick"){
		  
		if(this.className == "contenaire active"){
			this.className = "contenaire"
		}else {
			this.className = "contenaire active"
		}
	  }
	})
}
 

document.querySelector("html").classList.add('js');

var fileInput  = document.querySelector( ".input-file" ),  
    button     = document.querySelector( ".input-file-trigger" ),
    the_return = document.querySelector(".file-return");
      
if(button != null){

button.addEventListener( "click", function( event ) {
   fileInput.focus();
   return false;
});  
fileInput.addEventListener( "change", function( event ) {  
    the_return.innerHTML = this.value;  
});  }



