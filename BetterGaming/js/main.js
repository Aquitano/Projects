// Toggle function of Menu

let menuList = document.getElementById("menuList");

menuList.style.maxHeight = "0px";

function togglemenu() {
  if (menuList.style.maxHeight == "0px") {
    menuList.style.maxHeight = "130px";
  } else {
    menuList.style.maxHeight = "0px";
  }
}

// Loading animation via PaceJS Framework

const paceOptions = {
  ajax: true,
  document: true,
  eventLag: false,
};

Pace.on("done", function () {
  $(".p").animate(
    {
      top: "30%",
      opacity: "0",
    },
    3000,
    $.bez([0.19, 1, 0.22, 1])
  );

  $("#preloader").animate(
    {
      top: "-100%",
    },
    2000,
    $.bez([0.19, 1, 0.22, 1])
  );
});

// Appear on Scroll via ScrollOut Framework

// ScrollOut v2.2.12
let ScrollOut=function(){"use strict";function e(e,t,n){return e<t?t:n<e?n:e}function t(e){return+(0<e)-+(e<0)}let n,i={};function o(e){return"-"+e[0].toLowerCase()}function l(e){return i[e]||(i[e]=e.replace(/([A-Z])/g,o))}function r(e,t){return e&&0!==e.length?e.nodeName?[e]:[].slice.call(e[0].nodeName?e:(t||document.documentElement).querySelectorAll(e)):[]}function c(e,t){for(let n in t)n.indexOf("_")&&e.setAttribute("data-"+l(n),t[n])}let s=[];function f(){n=0,s.slice().forEach((function(e){return e()})),u()}function u(){!n&&s.length&&(n=requestAnimationFrame(f))}function d(e,t,n,i){return"function"==typeof e?e(t,n,i):e}function a(){}return function(i){let o,f,h,m,g=(i=i||{}).onChange||a,v=i.onHidden||a,p=i.onShown||a,w=i.onScroll||a,X=i.cssProps?(o=i.cssProps,function(e,t){for(let i in t)i.indexOf("_")&&(!0===o||o[i])&&e.style.setProperty("--"+l(i),(n=t[i],Math.round(1e4*n)/1e4));let n}):a,Y=i.scrollingElement,b=Y?r(Y)[0]:window,D=Y?r(Y)[0]:document.documentElement,E=!1,L={},P=[];function _(){P=r(i.targets||"[data-scroll]",r(i.scope||D)[0]).map((function(e){return{element:e}}))}function H(){let o=D.clientWidth,c=D.clientHeight,a=t(-f+(f=D.scrollLeft||window.pageXOffset)),g=t(-h+(h=D.scrollTop||window.pageYOffset)),w=D.scrollLeft/(D.scrollWidth-o||1),Y=D.scrollTop/(D.scrollHeight-c||1);E=E||L.scrollDirX!==a||L.scrollDirY!==g||L.scrollPercentX!==w||L.scrollPercentY!==Y,L.scrollDirX=a,L.scrollDirY=g,L.scrollPercentX=w,L.scrollPercentY=Y;for(let n=!1,s=0;s<P.length;s++){for(let e=P[s].element,t=0,n=0;t+=e.offsetLeft,n+=e.offsetTop,(e=e.offsetParent)&&e!==b;);let u,a=W.clientHeight||W.offsetHeight||0,m=W.clientWidth||W.offsetWidth||0,g=(e(l+m,f,f+o)-e(l,f,f+o))/m,v=(e(r+a,h,h+c)-e(r,h,h+c))/a,p=1===g?0:t(l-f),w=1===v?0:t(r-h),Y=e((f-(m/2+l-o/2))/(o/2),-1,1),E=e((h-(a/2+r-c/2))/(c/2),-1,1);u=i.offset?d(i.offset,W,X,D)>h?0:1:(d(i.threshold,W,X,D)||0)<g*v?1:0;let L=X.visible!==u;(X._changed||L||X.visibleX!==g||X.visibleY!==v||X.index!==s||X.elementHeight!==a||X.elementWidth!==m||X.offsetX!==l||X.offsetY!==r||X.intersectX!=X.intersectX||X.intersectY!=X.intersectY||X.viewportX!==Y||X.viewportY!==E)&&(n=!0,X._changed=!0,X._visibleChanged=L,X.visible=u,X.elementHeight=a,X.elementWidth=m,X.index=s,X.offsetX=l,X.offsetY=r,X.visibleX=g,X.visibleY=v,X.intersectX=p,X.intersectY=w,X.viewportX=Y,X.viewportY=E,X.visible=u)}m||!E&&!p||(v=A,s.push(v),u(),m=function(){!(s=s.filter((function(e){return e!==v}))).length&&n&&(cancelAnimationFrame(n),n=0)})}function A(){W(),E&&(E=!1,c(D,{scrollDirX:L.scrollDirX,scrollDirY:L.scrollDirY}),X(D,L),w(D,L,P));for(let e=P.length-1;-1<e;e--){let t=P[e],n=t.element,o=t.visible,l=n.hasAttribute("scrollout-once")||!1;t._changed&&(t._changed=!1,X(n,t)),t._visibleChanged&&(c(n,{scroll:o?"in":"out"}),g(n,t,D),(o?p:v)(n,t,D)),o&&(i.once||l)&&P.splice(e,1)}}function W(){m&&(m(),m=void 0)}_(),H(),A();let x=0,O=function(){x=x||setTimeout((function(){x=0,H()}),0)};return window.addEventListener("resize",O),b.addEventListener("scroll",O),{index:_,update:H,teardown:function(){W(),window.removeEventListener("resize",O),b.removeEventListener("scroll",O)}}}}();

ScrollOut();

// Parallax mouse movement on Homepage (Changing x and y positions of image according to mouse movement)

document.addEventListener("mousemove", parallax);

function parallax(e) {
  let img = $(".controller");
  const speed = img.attr("data-speed");

  const x = (window.innerWidth - e.pageX * speed) / 100;
  const y = (window.innerHeight - e.pageY * speed) / 100;

  $(".controller").css("transform", `translate(${x}px,${y}px)`);
}