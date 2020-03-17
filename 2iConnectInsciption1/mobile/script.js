function addZero(i) {
  if (i < 10) {
    i = "0" + i;
  }
  return i;
} 
refreshHour()
setInterval(function(){ 
  refreshHour()
 },1000)

function refreshHour(){
	var d = new Date();
  var x = document.getElementById("hour");
  var h = addZero(d.getHours());
  var m = addZero(d.getMinutes());
  var s = addZero(d.getSeconds());
  x.innerHTML = h + " h " + m
	if(h > 12){
		document.getElementById("messageBonjour").innerHTML = "Good Afternoon !";
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
      
button.addEventListener( "keydown", function( event ) {  
    if ( event.keyCode == 13 || event.keyCode == 32 ) {  
        fileInput.focus();  
    }  
});
button.addEventListener( "click", function( event ) {
   fileInput.focus();
   return false;
});  
fileInput.addEventListener( "change", function( event ) {  
    the_return.innerHTML = this.value;  
});  