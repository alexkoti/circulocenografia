/*
 * jLayers - javascript plugin for creating mouse-driven motion animations
 *
 * @author flGravity 
 * @site http://codecanyon.net/user/flGravity
 * @created 16/06/11
 *
 * Plugin exports jLayers function in global namespace. 
 * Also it provides two help functions jLayers.layerSize() 
 * and jLayers.documentSize(); 
*/


(function(){
 //check if jLayers() was previously defined
 if(window.jLayers && typeof window.jLayers  == 'function')
   return;

 window.jLayers=function(base,s){
 //default settings
 var settings = {
	alpha: 1, //transparency from back to front layer
	catchGlobalMove: false, //catch mousemove document events, not only from container div
	cssPosition: undefined, //how to position div container
	cssLeft: undefined, //left position
	cssTop: undefined, //top position
	offsetX: 0, //layer max offset in px along X
        offsetY: 0, //layer max offset in px along Y
	offsetCenter: 'center', //start point of offset
 	easing: true, //enable easing
        easingRate: 50, //ms
	easingSpeed: 3 //bigger value slower the easing
 };

 //help function to read array values from settings
 settings.get = function(key,index){
   var val = this[key];
   if(index != undefined && val instanceof Array){
        var s=val[index];
        if(s == undefined) s=val[val.length-1];
        return s;
   }else{
	if(typeof val == 'boolean')
	 return (val)?-1:1;
	else
         return parseInt(val);
   }
 };

 //override basic settings
 if(s && typeof s == 'object'){
  for (var key in settings){
	if(s[key] != undefined) 
	  settings[key]=s[key];
  }
 }
 
 //get div container
 if(typeof base == "string"){
   base = document.getElementById(base); 
 }

 //set div position and positioning mode
 if(settings.cssPosition)
  base.style.position=settings.cssPosition;
 if(settings.cssTop)
  base.style.top=settings.cssTop;
 if(settings.cssLeft)
  base.style.left=settings.cssLeft;

 //wrap children inside of 'div' and add them to array in back-front order
 var layers = new Array();
 var layer = base.firstChild; var wrapper;
 while(layer != undefined){
 if(layer.nodeType == 1){
     wrapper = document.createElement('div');
     base.insertBefore(wrapper,layer);
     wrapper.appendChild(layer);
     //create array of divs
     layers.push(wrapper);
     //set style
     wrapper.className='jlayers-layer';
     layer.className+=(layer.className.length==0)?'jlayers-content':' jlayers-content';
     layer = wrapper; //make wrapper a new layer
   }
     layer = layer.nextSibling; 
 }

 //configure layers (set opacity)
 var i; var a;
 for(i=0; i<layers.length; i++){
    a = settings.get('alpha',i);
    //alpha should be inside 0...1
    if(a>1) a=1;
    if(a<0) a=0;

    if(navigator.appName.indexOf('Microsoft') == -1){
      layers[i].style.opacity=a.toString();
    }else{ //IE
      layers[i].style.filter='alpha(opacity='+a*100+')';
    }
 }

 //function to get absolute position of an element
 var getAbsolutePosition=function(t){
   if(t==null){
	return [0,0]; 
   }else{
    var startX=t.offsetLeft; 
    var startY=t.offsetTop;
    var tmp = arguments.callee(t.offsetParent);
    return [startX+tmp[0],startY+tmp[1]];
   }
 };
  
 //X,Y position of base element
 base.posx=getAbsolutePosition(base)[0];
 base.posy=getAbsolutePosition(base)[1]; 

 //easing function
 layers.tmpX = 0; layers.tmpY = 0;
 layers.endX = 0; layers.endY = 0; 

 var updateLayerPosition=function(){
   if(Math.abs(layers.tmpX - layers.endX) > 0.0001 || Math.abs(layers.tmpX - layers.endX) > 0.0001){

    //easing function
    layers.tmpX += (layers.endX-layers.tmpX)/settings.easingSpeed;
    layers.tmpY += (layers.endY-layers.tmpY)/settings.easingSpeed;

    //apply offset to layers
    for(var i=0; i<layers.length; i++){
      layers[i].style.left=layers.tmpX*settings.get('offsetX',i)+'px';
      layers[i].style.top=layers.tmpY*settings.get('offsetY',i)+'px';
    }
   }
 };
 
 //document 'mousemove' handler
 var moveHandler=function(e){
   //calculate offset
   e = e || window.event;
   var mouseX = e.clientX; var mouseY = e.clientY;
   if(settings.catchGlobalMove == false){
	mouseX -= base.posx;
	mouseY -= base.posy;
   }

   //mouse offset from center (default)
   layers.endX = 2*mouseX/base.offsetWidth-1;
   layers.endY = 2*mouseY/base.offsetHeight-1;

   if(/left/i.test(settings.offsetCenter)){
	layers.endX = mouseX/base.offsetWidth;
   }

   if(/right/i.test(settings.offsetCenter)){
	layers.endX = 1-mouseX/base.offsetWidth;
   }

   if(/top/i.test(settings.offsetCenter)){
	layers.endY = mouseY/base.offsetHeight;
   }

   if(/bottom/i.test(settings.offsetCenter)){
	layers.endY = 1-mouseY/base.offsetHeight;
   }

   //apply offset to layers
  if(settings.easing){
   if(base.timer == undefined)
     base.timer=setInterval(updateLayerPosition,settings.easingRate);
  }else{
   for(var i=0; i<layers.length; i++){
      layers[i].style.left=layers.endX*settings.get('offsetX',i)+'px';
      layers[i].style.top=layers.endY*settings.get('offsetY',i)+'px';
   }
  }
 }; 

 //function to add event listener
 var registerEventListener=function(target,event,listener){
   if(target.addEventListener){ //W3C DOM
        target.addEventListener(event,listener,false);
   }else if(target.attachEvent){ //IE
        target.attachEvent('on'+event,listener);
   }
 };


 //register event listeners
 registerEventListener((settings.catchGlobalMove)?document:base,'mousemove',moveHandler);
 registerEventListener(window,'unload',function(){
  clearInterval(base.timer);
 });
 registerEventListener(window,'resize',function(){
  base.posx=getAbsolutePosition(base)[0]; //x
  base.posy=getAbsolutePosition(base)[1]; //y
 });

//return function settings
return settings;

//end of jLayers() function
};





/*============================================================
 ** jLayers help functions (defined within jLayers object) 
============================================================*/

// jLayers.layerSize() function
// returns element's width and height (including border) as {width:xx,height:yy} object for given element
window.jLayers.layerSize=function(layer){
 if(typeof layer == 'string') 
  layer = document.getElementById(layer);
 return {width:layer.offsetWidth, height:layer.offsetHeight};
};

// jLayers.documentSize() function 
// returns Document size as object {width:xx,height:yy}
window.jLayers.documentSize=function(){
 if(window.innerWidth) //w3c
  return {width:window.innerWidth, height:window.innerHeight};
 else if(document.body && document.body.offsetWidth) //quirks mode
  return {width:document.body.offsetWidth,
	  height:document.body.offsetHeight};
 else if(document.documentElement && document.documentElement.offsetWidth) //strict mode
  return {width:document.documentElement.offsetWidth,
	  height:document.documentElement.offsetHeight};
};

})();
