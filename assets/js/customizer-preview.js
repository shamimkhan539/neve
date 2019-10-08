!function(){"use strict";var e="undefined"!=typeof globalThis?globalThis:"undefined"!=typeof window?window:"undefined"!=typeof global?global:"undefined"!=typeof self?self:{};function t(e,t){return e(t={exports:{}},t.exports),t.exports}var n,r,o,i,a="object",c=function(e){return e&&e.Math==Math&&e},l=c(typeof globalThis==a&&globalThis)||c(typeof window==a&&window)||c(typeof self==a&&self)||c(typeof e==a&&e)||Function("return this")(),f=function(e){try{return!!e()}catch(e){return!0}},u=!f(function(){return 7!=Object.defineProperty({},"a",{get:function(){return 7}}).a}),s={}.propertyIsEnumerable,d=Object.getOwnPropertyDescriptor,p={f:d&&!s.call({1:2},1)?function(e){var t=d(this,e);return!!t&&t.enumerable}:s},v=function(e,t){return{enumerable:!(1&e),configurable:!(2&e),writable:!(4&e),value:t}},h={}.toString,g=function(e){return h.call(e).slice(8,-1)},y="".split,w=f(function(){return!Object("z").propertyIsEnumerable(0)})?function(e){return"String"==g(e)?y.call(e,""):Object(e)}:Object,m=function(e){if(null==e)throw TypeError("Can't call method on "+e);return e},b=function(e){return w(m(e))},x=function(e){return"object"==typeof e?null!==e:"function"==typeof e},S=function(e,t){if(!x(e))return e;var n,r;if(t&&"function"==typeof(n=e.toString)&&!x(r=n.call(e)))return r;if("function"==typeof(n=e.valueOf)&&!x(r=n.call(e)))return r;if(!t&&"function"==typeof(n=e.toString)&&!x(r=n.call(e)))return r;throw TypeError("Can't convert object to primitive value")},C={}.hasOwnProperty,j=function(e,t){return C.call(e,t)},k=l.document,E=x(k)&&x(k.createElement),O=!u&&!f(function(){return 7!=Object.defineProperty((e="div",E?k.createElement(e):{}),"a",{get:function(){return 7}}).a;var e}),P=Object.getOwnPropertyDescriptor,A={f:u?P:function(e,t){if(e=b(e),t=S(t,!0),O)try{return P(e,t)}catch(e){}if(j(e,t))return v(!p.f.call(e,t),e[t])}},z=function(e){if(!x(e))throw TypeError(String(e)+" is not an object");return e},L=Object.defineProperty,N={f:u?L:function(e,t,n){if(z(e),t=S(t,!0),z(n),O)try{return L(e,t,n)}catch(e){}if("get"in n||"set"in n)throw TypeError("Accessors not supported");return"value"in n&&(e[t]=n.value),e}},I=u?function(e,t,n){return N.f(e,t,v(1,n))}:function(e,t,n){return e[t]=n,e},R=function(t,n){try{I(l,t,n)}catch(e){l[t]=n}return n},F=t(function(e){var t="__core-js_shared__",n=l[t]||R(t,{});(e.exports=function(e,t){return n[e]||(n[e]=void 0!==t?t:{})})("versions",[]).push({version:"3.2.1",mode:"global",copyright:"© 2019 Denis Pushkarev (zloirock.ru)"})}),M=F("native-function-to-string",Function.toString),T=l.WeakMap,U="function"==typeof T&&/native code/.test(M.call(T)),G=0,H=Math.random(),q=function(e){return"Symbol("+String(void 0===e?"":e)+")_"+(++G+H).toString(36)},W=F("keys"),$={},Q=l.WeakMap;if(U){var V=new Q,B=V.get,D=V.has,J=V.set;n=function(e,t){return J.call(V,e,t),t},r=function(e){return B.call(V,e)||{}},o=function(e){return D.call(V,e)}}else{var K=W[i="state"]||(W[i]=q(i));$[K]=!0,n=function(e,t){return I(e,K,t),t},r=function(e){return j(e,K)?e[K]:{}},o=function(e){return j(e,K)}}var Y,X,Z={set:n,get:r,has:o,enforce:function(e){return o(e)?r(e):n(e,{})},getterFor:function(n){return function(e){var t;if(!x(e)||(t=r(e)).type!==n)throw TypeError("Incompatible receiver, "+n+" required");return t}}},ee=t(function(e){var t=Z.get,c=Z.enforce,u=String(M).split("toString");F("inspectSource",function(e){return M.call(e)}),(e.exports=function(e,t,n,r){var o=!!r&&!!r.unsafe,i=!!r&&!!r.enumerable,a=!!r&&!!r.noTargetGet;"function"==typeof n&&("string"!=typeof t||j(n,"name")||I(n,"name",t),c(n).source=u.join("string"==typeof t?t:"")),e!==l?(o?!a&&e[t]&&(i=!0):delete e[t],i?e[t]=n:I(e,t,n)):i?e[t]=n:R(t,n)})(Function.prototype,"toString",function(){return"function"==typeof this&&t(this).source||M.call(this)})}),te=l,ne=function(e){return"function"==typeof e?e:void 0},re=Math.ceil,oe=Math.floor,ie=function(e){return isNaN(e=+e)?0:(0<e?oe:re)(e)},ae=Math.min,ce=function(e){return 0<e?ae(ie(e),9007199254740991):0},ue=Math.max,se=Math.min,le=function(s){return function(e,t,n){var r,o,i,a=b(e),c=ce(a.length),u=(r=c,(o=ie(n))<0?ue(o+r,0):se(o,r));if(s&&t!=t){for(;u<c;)if((i=a[u++])!=i)return!0}else for(;u<c;u++)if((s||u in a)&&a[u]===t)return s||u||0;return!s&&-1}},fe={includes:le(!0),indexOf:le(!1)}.indexOf,de=["constructor","hasOwnProperty","isPrototypeOf","propertyIsEnumerable","toLocaleString","toString","valueOf"].concat("length","prototype"),pe={f:Object.getOwnPropertyNames||function(e){return function(e,t){var n,r=b(e),o=0,i=[];for(n in r)!j($,n)&&j(r,n)&&i.push(n);for(;t.length>o;)j(r,n=t[o++])&&(~fe(i,n)||i.push(n));return i}(e,de)}},ve={f:Object.getOwnPropertySymbols},he=function(e,t){return arguments.length<2?ne(te[e])||ne(l[e]):te[e]&&te[e][t]||l[e]&&l[e][t]}("Reflect","ownKeys")||function(e){var t=pe.f(z(e)),n=ve.f;return n?t.concat(n(e)):t},ge=function(e,t){for(var n=he(t),r=N.f,o=A.f,i=0;i<n.length;i++){var a=n[i];j(e,a)||r(e,a,o(t,a))}},ye=/#|\.prototype\./,me=function(e,t){var n=we[be(e)];return n==_e||n!=xe&&("function"==typeof t?f(t):!!t)},be=me.normalize=function(e){return String(e).replace(ye,".").toLowerCase()},we=me.data={},xe=me.NATIVE="N",_e=me.POLYFILL="P",Se=me,Ce=A.f,je=function(e,t){var n,r,o,i,a,c=e.target,u=e.global,s=e.stat;if(n=u?l:s?l[c]||R(c,{}):(l[c]||{}).prototype)for(r in t){if(i=t[r],o=e.noTargetGet?(a=Ce(n,r))&&a.value:n[r],!Se(u?r:c+(s?".":"#")+r,e.forced)&&void 0!==o){if(typeof i==typeof o)continue;ge(i,o)}(e.sham||o&&o.sham)&&I(i,"sham",!0),ee(n,r,i,e)}},ke=[].join,Ee=w!=Object,Oe=(Y=",",!(X=[]["join"])||!f(function(){X.call(null,Y||function(){throw 1},1)}));je({target:"Array",proto:!0,forced:Ee||Oe},{join:function(e){return ke.call(b(this),void 0===e?",":e)}});var Pe,Ae=function(r,o,e){if(function(e){if("function"!=typeof e)throw TypeError(String(e)+" is not a function")}(r),void 0===o)return r;switch(e){case 0:return function(){return r.call(o)};case 1:return function(e){return r.call(o,e)};case 2:return function(e,t){return r.call(o,e,t)};case 3:return function(e,t,n){return r.call(o,e,t,n)}}return function(){return r.apply(o,arguments)}},ze=function(e){return Object(m(e))},Le=Array.isArray||function(e){return"Array"==g(e)},Ne=!!Object.getOwnPropertySymbols&&!f(function(){return!String(Symbol())}),Ie=l.Symbol,Re=F("wks"),Fe=function(e){return Re[e]||(Re[e]=Ne&&Ie[e]||(Ne?Ie:q)("Symbol."+e))},Me=Fe("species"),Te=function(e,t){var n;return Le(e)&&("function"!=typeof(n=e.constructor)||n!==Array&&!Le(n.prototype)?x(n)&&null===(n=n[Me])&&(n=void 0):n=void 0),new(void 0===n?Array:n)(0===t?0:t)},Ue=[].push,Ge=function(p){var v=1==p,h=2==p,g=3==p,y=4==p,m=6==p,b=5==p||m;return function(e,t,n,r){for(var o,i,a=ze(e),c=w(a),u=Ae(t,n,3),s=ce(c.length),l=0,f=r||Te,d=v?f(e,s):h?f(e,0):void 0;l<s;l++)if((b||l in c)&&(i=u(o=c[l],l,a),p))if(v)d[l]=i;else if(i)switch(p){case 3:return!0;case 5:return o;case 6:return l;case 2:Ue.call(d,o)}else if(y)return!1;return m?-1:g||y?y:d}},He={forEach:Ge(0),map:Ge(1),filter:Ge(2),some:Ge(3),every:Ge(4),find:Ge(5),findIndex:Ge(6)},qe=Fe("species"),We=He.map;je({target:"Array",proto:!0,forced:(Pe="map",!!f(function(){var e=[];return(e.constructor={})[qe]=function(){return{foo:1}},1!==e[Pe](Boolean).foo}))},{map:function(e){return We(this,e,1<arguments.length?arguments[1]:void 0)}});var $e="".repeat||function(e){var t=String(m(this)),n="",r=ie(e);if(r<0||r==1/0)throw RangeError("Wrong number of repetitions");for(;0<r;(r>>>=1)&&(t+=t))1&r&&(n+=t);return n},Qe=1..toFixed,Ve=Math.floor,Be=function(e,t,n){return 0===t?n:t%2==1?Be(e,t-1,n*e):Be(e*e,t/2,n)};je({target:"Number",proto:!0,forced:Qe&&("0.000"!==8e-5.toFixed(3)||"1"!==.9.toFixed(0)||"1.25"!==1.255.toFixed(2)||"1000000000000000128"!==(0xde0b6b3a7640080).toFixed(0))||!f(function(){Qe.call({})})},{toFixed:function(e){var t,n,r,o,i=function(e){if("number"!=typeof e&&"Number"!=g(e))throw TypeError("Incorrect invocation");return+e}(this),a=ie(e),c=[0,0,0,0,0,0],u="",s="0",l=function(e,t){for(var n=-1,r=t;++n<6;)r+=e*c[n],c[n]=r%1e7,r=Ve(r/1e7)},f=function(e){for(var t=6,n=0;0<=--t;)n+=c[t],c[t]=Ve(n/e),n=n%e*1e7},d=function(){for(var e=6,t="";0<=--e;)if(""!==t||0===e||0!==c[e]){var n=String(c[e]);t=""===t?n:t+$e.call("0",7-n.length)+n}return t};if(a<0||20<a)throw RangeError("Incorrect fraction digits");if(i!=i)return"NaN";if(i<=-1e21||1e21<=i)return String(i);if(i<0&&(u="-",i=-i),1e-21<i)if(n=(t=function(e){for(var t=0,n=e;4096<=n;)t+=12,n/=4096;for(;2<=n;)t+=1,n/=2;return t}(i*Be(2,69,1))-69)<0?i*Be(2,-t,1):i/Be(2,t,1),n*=4503599627370496,0<(t=52-t)){for(l(0,n),r=a;7<=r;)l(1e7,0),r-=7;for(l(Be(10,r,1),0),r=t-1;23<=r;)f(1<<23),r-=23;f(1<<r),l(1,1),f(2),s=d()}else l(0,n),l(1<<-t,0),s=d()+$e.call("0",a);return s=0<a?u+((o=s.length)<=a?"0."+$e.call("0",a-o)+s:s.slice(0,o-a)+"."+s.slice(o-a)):u+s}});var De=Fe("toStringTag"),Je="Arguments"==g(function(){return arguments}()),Ke={};Ke[Fe("toStringTag")]="z";var Ye="[object z]"!==String(Ke)?function(){return"[object "+(void 0===(e=this)?"Undefined":null===e?"Null":"string"==typeof(n=function(e,t){try{return e[t]}catch(e){}}(t=Object(e),De))?n:Je?g(t):"Object"==(r=g(t))&&"function"==typeof t.callee?"Arguments":r)+"]";var e,t,n,r}:Ke.toString,Xe=Object.prototype;Ye!==Xe.toString&&ee(Xe,"toString",Ye,{unsafe:!0});var Ze=function(){var e=z(this),t="";return e.global&&(t+="g"),e.ignoreCase&&(t+="i"),e.multiline&&(t+="m"),e.dotAll&&(t+="s"),e.unicode&&(t+="u"),e.sticky&&(t+="y"),t},et="toString",tt=RegExp.prototype,nt=tt[et],rt=f(function(){return"/a/b"!=nt.call({source:"a",flags:"b"})}),ot=nt.name!=et;(rt||ot)&&ee(RegExp.prototype,et,function(){var e=z(this),t=String(e.source),n=e.flags;return"/"+t+"/"+String(void 0===n&&e instanceof RegExp&&!("flags"in tt)?Ze.call(e):n)},{unsafe:!0});var it,at,ct=RegExp.prototype.exec,ut=String.prototype.replace,st=ct,lt=(it=/a/,at=/b*/g,ct.call(it,"a"),ct.call(at,"a"),0!==it.lastIndex||0!==at.lastIndex),ft=void 0!==/()??/.exec("")[1];(lt||ft)&&(st=function(e){var t,n,r,o,i=this;return ft&&(n=new RegExp("^"+i.source+"$(?!\\s)",Ze.call(i))),lt&&(t=i.lastIndex),r=ct.call(i,e),lt&&r&&(i.lastIndex=i.global?r.index+r[0].length:t),ft&&r&&1<r.length&&ut.call(r[0],n,function(){for(o=1;o<arguments.length-2;o++)void 0===arguments[o]&&(r[o]=void 0)}),r});var dt=st,pt=Fe("species"),vt=!f(function(){var e=/./;return e.exec=function(){var e=[];return e.groups={a:"7"},e},"7"!=="".replace(e,"$<a>")}),ht=!f(function(){var e=/(?:)/,t=e.exec;e.exec=function(){return t.apply(this,arguments)};var n="ab".split(e);return 2!==n.length||"a"!==n[0]||"b"!==n[1]}),gt=function(c){return function(e,t){var n,r,o=String(m(e)),i=ie(t),a=o.length;return i<0||a<=i?c?"":void 0:(n=o.charCodeAt(i))<55296||56319<n||i+1===a||(r=o.charCodeAt(i+1))<56320||57343<r?c?o.charAt(i):n:c?o.slice(i,i+2):r-56320+(n-55296<<10)+65536}},yt={codeAt:gt(!1),charAt:gt(!0)}.charAt,mt=function(e,t){var n=e.exec;if("function"==typeof n){var r=n.call(e,t);if("object"!=typeof r)throw TypeError("RegExp exec method returned something other than an Object or null");return r}if("RegExp"!==g(e))throw TypeError("RegExp#exec called on incompatible receiver");return dt.call(e,t)},bt=Math.max,wt=Math.min,xt=Math.floor,_t=/\$([$&'`]|\d\d?|<[^>]*>)/g,St=/\$([$&'`]|\d\d?)/g;!function(n,e,t,r){var o=Fe(n),i=!f(function(){var e={};return e[o]=function(){return 7},7!=""[n](e)}),a=i&&!f(function(){var e=!1,t=/a/;return t.exec=function(){return e=!0,null},"split"===n&&(t.constructor={},t.constructor[pt]=function(){return t}),t[o](""),!e});if(!i||!a||"replace"===n&&!vt||"split"===n&&!ht){var c=/./[o],u=t(o,""[n],function(e,t,n,r,o){return t.exec===dt?i&&!o?{done:!0,value:c.call(t,n,r)}:{done:!0,value:e.call(n,t,r)}:{done:!1}}),s=u[0],l=u[1];ee(String.prototype,n,s),ee(RegExp.prototype,o,2==e?function(e,t){return l.call(e,this,t)}:function(e){return l.call(e,this)}),r&&I(RegExp.prototype[o],"sham",!0)}}("replace",2,function(o,S,C){return[function(e,t){var n=m(this),r=null==e?void 0:e[o];return void 0!==r?r.call(e,n,t):S.call(String(n),e,t)},function(e,t){var n=C(S,e,this,t);if(n.done)return n.value;var r=z(e),o=String(this),i="function"==typeof t;i||(t=String(t));var a=r.global;if(a){var c=r.unicode;r.lastIndex=0}for(var u,s,l=[];;){var f=mt(r,o);if(null===f)break;if(l.push(f),!a)break;""===String(f[0])&&(r.lastIndex=(u=o,(s=ce(r.lastIndex))+(c?yt(u,s).length:1)))}for(var d,p="",v=0,h=0;h<l.length;h++){f=l[h];for(var g=String(f[0]),y=bt(wt(ie(f.index),o.length),0),m=[],b=1;b<f.length;b++)m.push(void 0===(d=f[b])?d:String(d));var w=f.groups;if(i){var x=[g].concat(m,y,o);void 0!==w&&x.push(w);var _=String(t.apply(void 0,x))}else _=j(g,o,y,m,w,t);v<=y&&(p+=o.slice(v,y)+_,v=y+g.length)}return p+o.slice(v)}];function j(i,a,c,u,s,e){var l=c+i.length,f=u.length,t=St;return void 0!==s&&(s=ze(s),t=_t),S.call(e,t,function(e,t){var n;switch(t.charAt(0)){case"$":return"$";case"&":return i;case"`":return a.slice(0,c);case"'":return a.slice(l);case"<":n=s[t.slice(1,-1)];break;default:var r=+t;if(0===r)return e;if(f<r){var o=xt(r/10);return 0===o?e:o<=f?void 0===u[o-1]?t.charAt(1):u[o-1]+t.charAt(1):e}n=u[r-1]}return void 0===n?"":n})}});var Ct,jt=/"/g;function kt(e){return(kt="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}je({target:"String",proto:!0,forced:(Ct="fixed",f(function(){var e=""[Ct]('"');return e!==e.toLowerCase()||3<e.split('"').length}))},{fixed:function(){return e="tt",n=t="",r=String(m(this)),o="<"+e,""!==t&&(o+=" "+t+'="'+String(n).replace(jt,"&quot;")+'"'),o+">"+r+"</"+e+">";var e,t,n,r,o}});var Et,Ot,Pt,At=function(e,t){if(e instanceof NodeList)for(var n=0;n<e.length;n++)e[n].classList.add(t);else(e instanceof Node||e instanceof Element)&&e.classList.add(t)},zt=function(e,t){var n=t.split(" ");if(e instanceof NodeList)for(var r=0;r<e.length;r++)for(var o=0;o<n.length;o++)e[r].classList.remove(n[o]);else if(e instanceof Node||e instanceof Element)for(var i=0;i<n.length;i++)e.classList.remove(n[i])};function Lt(e){var t=1<arguments.length&&void 0!==arguments[1]?arguments[1]:"",n=document.querySelector("#"+e+"-css-style");n||((n=document.createElement("style")).setAttribute("id",e+"-css-style"),n.setAttribute("type","text/css"),document.querySelector("head").appendChild(n)),n.innerHTML=t}window.addEventListener("load",function(){document.addEventListener("header_builder_panel_changed",function(e){return"hfg_header_layout_partial"===e.detail.partial_id?(window.HFG.init(),console.log("Reinitialize HFG with sidebar."),!1):"nav-icon_partial"===e.detail.partial_id?(window.HFG.init(!0),console.log("Reinitialize HFG with skip."),!1):void 0}),document.addEventListener("customize_control_sidebar",function(e){"open"===e.detail&&window.HFG.toggleMenuSidebar(!0),"close"===e.detail&&window.HFG.toggleMenuSidebar(!1)}.bind(this)),document.addEventListener("customize_section_opened",function(e){"header_sidebar"===e.detail&&window.HFG.toggleMenuSidebar(!0)}.bind(this));var p={mobile:"max-width: 576px",tablet:"min-width: 576px",desktop:"min-width: 961px"};_.each(neveCustomizePreview,function(e,d){_.each(e,function(l,f){wp.customize(f,function(e){e.bind(function(t){var e="";switch(d){case"neve_background_control":if("color"===t.type){e+="body "+l.selector+"{background-image: none !important;}";var n="undefined"!==t.colorValue?t.colorValue:"inherit";return e+="body "+l.selector+"{background-color: "+n+" !important; }",e+=l.selector+":before{ content: none !important; }",Lt(f,e),!1}e+=l.selector+"{",e+=t.imageUrl?'background-image: url("'+t.imageUrl+'") !important;':"background-image: none !important;",e+=!0===t.fixed?"background-attachment: fixed !important;":"background-attachment: initial !important;",e+="background-position:"+(100*t.focusPoint.x).toFixed(2)+"% "+(100*t.focusPoint.y).toFixed(2)+"% !important;",e+="background-size: cover !important;",document.querySelector(".header-menu-sidebar").classList.contains("dropdown")||(e+="position: absolute;"),e+='top: 0; bottom: 0; width: 100%; content:"";',e+="}";var r="undefined"!==t.overlayColorValue?t.overlayColorValue:"inherit";e+=l.selector+':before { content: "";position: absolute; top: 0; bottom: 0; width: 100%;background-color: '+r+" !important;opacity: "+t.overlayOpacity/100+"!important;}",e+=l.selector+"{ background-color: transparent !important; }",Lt(f,e);break;case"\\Neve\\Customizer\\Controls\\Button_Group":var o=document.querySelectorAll(l.selector);_.each(o,function(e){zt(e.parentNode,"hfg-item-center hfg-item-right hfg-item-left"),At(e.parentNode,"hfg-item-"+t)});break;case"\\Neve\\Customizer\\Controls\\Radio_Image":var i=document.querySelectorAll(l.selector);zt(i,"dark-mode light-mode"),At(i,t);break;case"\\Neve\\Customizer\\Controls\\Range":var a=JSON.parse(t);0<a.mobile?e+="@media (max-width: 576px) { body "+l.selector+"{ "+l.additional.prop+":"+a.mobile+l.additional.unit+";}}":e+="@media (max-width: 576px) { body "+l.selector+"{ "+l.additional.prop+":unset;}}",0<a.tablet?e+="@media (min-width: 576px) { body "+l.selector+"{ "+l.additional.prop+":"+a.tablet+l.additional.unit+";}}":e+="@media (min-width: 576px) { body "+l.selector+"{ "+l.additional.prop+":unset;}}",0<a.desktop?e+="@media (min-width: 961px) { body "+l.selector+"{ "+l.additional.prop+":"+a.desktop+l.additional.unit+";}}":e+="@media (min-width: 961px) { body "+l.selector+"{ "+l.additional.prop+":unset;}}",Lt(f,e);break;case"\\Neve\\Customizer\\Controls\\React\\Spacing":for(var c in p){for(var u in e+="@media ("+p[c]+") { body "+l.selector+"{",t[c])""!==t[c][u]?e+=l.additional.prop+"-"+u+":"+t[c][u]+t[c+"-unit"]+";":e+=l.additional.prop+"-"+u+": unset;";e+="}}"}Lt(f,e);break;case"\\Neve\\Customizer\\Controls\\React\\Typography":for(var s in e+="html "+l.selector+"{text-transform:"+t.textTransform+";font-weight:"+t.fontWeight+";}",p)e+="@media ("+p[s]+") { html "+l.selector+"{font-size:"+t.fontSize[s]+t.fontSize.suffix[s]+";letter-spacing:"+t.letterSpacing[s]+"px;line-height:"+t.lineHeight[s]+";}}";Lt(f,e)}})})})}),wp.customize.preview.bind("font-selection",function(e){var t=neveCustomizePreview[e.type][e.controlId].selector,n=e.source,r=e.controlId+"_font_family";if(t=(t=t.split(",")).map(function(e){return"html "+e}).join(","),!1===e.value?Lt(e.controlId,t+'{font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;}'):Lt(e.controlId,t+"{font-family: "+e.value+" ;}"),"google"===n.toLowerCase()){var o=document.querySelector("#"+r),i="//fonts.googleapis.com/css?family="+e.value.replace(" ","+")+"%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800";if(null!==o)return o.setAttribute("href",i),!1;var a=document.createElement("link");a.setAttribute("rel","stylesheet"),a.setAttribute("id",r),a.setAttribute("href",i),a.setAttribute("type","text/css"),a.setAttribute("media","all"),document.querySelector("head").appendChild(a)}})}),(Et=jQuery).neveCustomizeUtilities={setLiveCss:function(o,e){var i="",t=Et("."+o.styleClass);if("object"!==kt(e))return Et(o.selectors).css(o.cssProperty,e.toString()+o.propertyUnit),!1;Et.each(e,function(e,t){var n;if("suffix"===e)return!0;var r=o.propertyUnit;switch("object"===kt(o.propertyUnit)&&(r=o.propertyUnit[e]),n=o.selectors+"{ "+o.cssProperty+":"+t+r+"}",e){default:case"mobile":i+=n;break;case"desktop":i+="@media(min-width: 960px) {"+n+"}";break;case"tablet":i+="@media (min-width: 576px){"+n+"}"}}),0<t.length?t.text(i):Et("head").append('<style type="text/css" class="'+o.styleClass+'">'+i+"</style>")}},(Ot=jQuery).neveRangesPreview={init:function(){this.rangesPreview()},ranges:{neve_container_width:{selector:".container",cssProp:"max-width",unit:"px",styleClass:"container-width-css"}},rangesPreview:function(){_.each(this.ranges,function(r,e){wp.customize(e,function(e){e.bind(function(e){var t=JSON.parse(e);if(!t)return!0;"object"===kt(t.suffix)&&(r.unit=t.suffix);var n={selectors:r.selector,cssProperty:r.cssProp,propertyUnit:r.unit?r.unit:"",styleClass:r.styleClass};Ot.neveCustomizeUtilities.setLiveCss(n,t)})})})}},jQuery.neveRangesPreview.init(),(Pt=jQuery).neveLayoutPreview={init:function(){this.contentWidthsPreview(),this.containersLivePreview()},contentWidths:{neve_sitewide_content_width:{content:".neve-main > .container .col",sidebar:".nv-sidebar-wrap"},neve_blog_archive_content_width:{content:".archive-container .nv-index-posts",sidebar:".archive-container .nv-sidebar-wrap"},neve_single_post_content_width:{content:".single-post-container .nv-single-post-wrap",sidebar:".single-post-container .nv-sidebar-wrap"},neve_shop_archive_content_width:{content:".archive.woocommerce .shop-container .nv-shop.col",sidebar:".archive.woocommerce .shop-container .nv-sidebar-wrap"},neve_single_product_content_width:{content:".single-product .shop-container .nv-shop.col",sidebar:".single-product .shop-container .nv-sidebar-wrap"},neve_other_pages_content_width:{content:"body:not(.single):not(.archive):not(.blog) .neve-main > .container .col",sidebar:"body:not(.single):not(.archive):not(.blog) .nv-sidebar-wrap"}},contentWidthsPreview:function(){Pt.each(this.contentWidths,function(e,t){wp.customize(e,function(e){e.bind(function(e){jQuery(t.content).css("max-width",e+"%"),jQuery(t.sidebar).css("max-width",100-e+"%")})})})},containersLayoutMap:{neve_default_container_style:".page:not(.woocommerce) .single-page-container",neve_blog_archive_container_style:".archive-container",neve_single_post_container_style:".single-post-container",neve_shop_archive_container_style:".woocommerce-page.post-type-archive .neve-main > div",neve_single_product_container_style:".single-product .neve-main > div"},containersLivePreview:function(){Pt.each(this.containersLayoutMap,function(e,t){t+=":not(.set-in-metabox)",wp.customize(e,function(e){e.bind(function(e){if("contained"===e)return Pt(t).removeClass("container-fluid").addClass("container"),!1;Pt(t).removeClass("container").addClass("container-fluid")})})})}},jQuery.neveLayoutPreview.init()}();
