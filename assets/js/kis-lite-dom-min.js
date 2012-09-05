(function(){if("undefined"!==typeof document.querySelector){var d,e,b,c;d=function(a){c="undefined"===typeof a?"undefined"!==typeof d.el?d.el:document.documentElement:"object"!==typeof a?e(a):a;d.prototype.el=c;var a=b(d),f;for(f in a)"object"===typeof a[f]&&(a[f].el=c);a.el=c;return a};e=function(a,f){var b;if("string"!=typeof a||"undefined"===typeof a)return a;b=null!=f&&1===f.nodeType?f:document;if(a.match(/^#([\w\-]+$)/))return document.getElementById(a.split("#")[1]);b=b.querySelectorAll(a);
return 1===b.length?b[0]:b};b=function(a){var f;if("undefined"!==typeof a){if("undefined"!==typeof Object.create)return Object.create(a);f=typeof a;if(!("object"!==f&&"function"!==f))return f=function(){},f.prototype=a,new f}};d.ext=function(a,f){f.el=c;d[a]=f};d.ext("each",function(a){if("undefined"!==typeof c.length&&c!==window)if("undefined"!==typeof Array.prototype.forEach)[].forEach.call(c,a);else{var f=c.length;if(0!==f)for(var b,h=0;h<f;h++)b=c.item(h)?c.item(h):c[h],a.call(b,b)}else a.call(c,
c)});d.type=function(a){return function(){return a&&a!==this}.call(a)?(typeof a).toLowerCase():{}.toString.call(a).match(/\s([a-z|A-Z]+)/)[1].toLowerCase()};d=window.$_=window.$_||d;d.$=e}})();"undefined"===typeof String.prototype.trim&&(String.prototype.trim=function(){return this.replace(/^[\s\uFEFF]+|[\s\uFEFF]+$/g,"")});
"undefined"===typeof Event.preventDefault&&"undefined"!==typeof window.event&&(Event.prototype.preventDefault=function(){window.event.returnValue=false},Event.prototype.stopPropagation=function(){window.event.cancelBubble=true});"undefined"===typeof Array.isArray&&(Array.isArray=function(d){return Object.prototype.toString.apply(d)==="[object Array]"});
(function(){if(typeof window.XMLHttpRequest!=="undefined"){var d={_do:function(d,b,c,a,f){var g=new XMLHttpRequest;typeof c==="undefined"&&(c=function(){});f=f?"POST":"GET";d=d+(f==="GET"?"?"+this._serialize(b):"");g.open(f,d);g.onreadystatechange=function(){g.readyState===4&&(g.status===200?c.call(g.responseText,g.responseText):typeof a!=="undefined"&&a.call(g.status,g.status))};if(f==="POST"){g.setRequestHeader("Content-Type","application/x-www-form-urlencoded");g.send(this._serialize(b))}else g.send(null)},
_serialize:function(d){var b,c,a=[];for(b in d)if(d.hasOwnProperty(b)&&typeof d[b]!=="function"){c=d[b].toString();b=encodeURIComponent(b);c=encodeURIComponent(c);a.push(b+"="+c)}return a.join("&")}};$_.ext("get",function(e,b,c,a){d._do(e,b,c,a,false)});$_.ext("post",function(e,b,c,a){d._do(e,b,c,a,true)});$_.ext("sse",function(d,b){var c;if(typeof EventSource!=="undefined"){c=new EventSource(d);c.onmessage=function(a){b.call(a.data,a.data)}}})}})();
(function(){var d,e,b,c;if(typeof document.addEventListener!=="undefined"){d=function(a,b,c){typeof a.addEventListener!=="undefined"&&a.addEventListener(b,c,false)};e=function(a,b,c){typeof a.removeEventListener!=="undefined"&&a.removeEventListener(b,c,false)}}else if(typeof document.attachEvent!=="undefined"){d=function(a,b,c){function d(a){c.apply(a)}if(typeof a.attachEvent!=="undefined"){e(b,c);a.attachEvent("on"+b,d);a=a.KIS_0_6_0=a.KIS_0_6_0||{};a.listeners=a.listeners||{};a.listeners[b]=a.listeners[b]||
[];a.listeners[b].push({callback:c,_listener:d})}};e=function(a,b,c){if(typeof a.detachEvent!=="undefined"){var d=a.KIS_0_6_0;if(d&&d.listeners&&d.listeners[b])for(var e=d.listeners[b],k=e.length,i=0;i<k;i++)if(e[i].callback===c){a.detachEvent("on"+b,e[i]._listener);e.splice(i,1);e.length===0&&delete d.listeners[b];break}}}}b=function(a,c,g,h){var j,k;if(typeof a==="undefined")return null;if(c.match(/^([\w\-]+)$/))h===true?d(a,c,g):e(a,c,g);else{c=c.split(" ");k=c.length;for(j=0;j<k;j++)b(a,c[j],
g,h)}};c=function(a,c,d,e){b(a,d,function(b){var d,i,g,b=b||window.event;i=$_.$(c,a);for(d in i){g=b.target||b.srcElement;if(g==i[d]){e.call(i[d],b);b.stopPropagation()}}},true)};$_.ext("event",{add:function(a,c){$_.each(function(d){b(d,a,c,true)})},remove:function(a,c){$_.each(function(d){b(d,a,c,false)})},live:function(a,b,d){c(document.documentElement,a,b,d)},delegate:function(a,b,d){$_.each(function(e){c(e,a,b,d)})}})})();
"undefined"!==typeof document&&!("classList"in document.createElement("a"))&&function(d){var d=(d.HTMLElement||d.Element).prototype,e=Object,b=String.prototype.trim||function(){return this.replace(/^\s+|\s+$/g,"")},c=Array.prototype.indexOf||function(a){for(var b=0,c=this.length;b<c;b++)if(b in this&&this[b]===a)return b;return-1},a=function(a,b){this.name=a;this.code=DOMException[a];this.message=b},f=function(b,d){if(d==="")throw new a("SYNTAX_ERR","An invalid or illegal string was specified");if(/\s/.test(d))throw new a("INVALID_CHARACTER_ERR",
"String contains an invalid character");return c.call(b,d)},g=function(a){for(var c=b.call(a.className),c=c?c.split(/\s+/):[],d=0,f=c.length;d<f;d++)this.push(c[d]);this._updateClassName=function(){a.className=this.toString()}},h=g.prototype=[],j=function(){return new g(this)};a.prototype=Error.prototype;h.item=function(a){return this[a]||null};h.contains=function(a){return f(this,a+"")!==-1};h.add=function(a){a=a+"";if(f(this,a)===-1){this.push(a);this._updateClassName()}};h.remove=function(a){a=
f(this,a+"");if(a!==-1){this.splice(a,1);this._updateClassName()}};h.toggle=function(a){a=a+"";f(this,a)===-1?this.add(a):this.remove(a)};h.toString=function(){return this.join(" ")};if(e.defineProperty){h={get:j,enumerable:true,configurable:true};try{e.defineProperty(d,"classList",h)}catch(k){if(k.number===-2146823252){h.enumerable=false;e.defineProperty(d,"classList",h)}}}else e.prototype.__defineGetter__&&d.__defineGetter__("classList",j)}(self);
(function(){function d(b,c,a){var d,e;if(typeof b.hasAttribute!=="undefined"){b.hasAttribute(c)&&(d=b.getAttribute(c));e=true}else if(typeof b[c]!=="undefined"){d=b[c];e=false}else if(c==="class"&&typeof b.className!=="undefined"){c="className";d=b.className;e=false}if(typeof d==="undefined"&&(typeof a==="undefined"||a===null))return null;if(typeof a==="undefined")return d;typeof a!=="undefined"&&a!==null?e===true?b.setAttribute(c,a):b[c]=a:a===null&&(e===true?b.removeAttribute(c):delete b[c]);return typeof a!==
"undefined"?a:d}function e(b,c,a){var d,c=c.replace(/(\-[a-z])/g,function(a){return a.toUpperCase().replace("-","")});d={outerHeight:"offsetHeight",outerWidth:"offsetWidth",top:"posTop"};if(typeof a==="undefined"&&b.style[c]!=="undefined")return b.style[c];if(typeof a==="undefined"&&b.style[d[c]]!=="undefined")return b.style[d[c]];if(typeof b.style[c]!=="undefined"){b.style[c]=a;return null}if(b.style[d[c]]){b.style[d[c]]=a;return null}}$_.ext("dom",{addClass:function(b){$_.each(function(c){c.classList.add(b)})},
removeClass:function(b){$_.each(function(c){c.classList.remove(b)})},hide:function(){this.css("display","none")},show:function(b){typeof b==="undefined"&&(b="block");this.css("display",b)},attr:function(b,c){var a=this.el;if(a.length>1&&typeof c==="undefined")return null;if(a.length>1&&typeof c!=="undefined")$_.each(function(a){return d(a,b,c)});else return d(a,b,c)},text:function(b){var c,a,d;d=this.el;a=typeof d.textContent!=="undefined"?"textContent":typeof d.innerText!=="undefined"?"innerText":
"innerHTML";c=d[a];if(typeof b!=="undefined")return d[a]=b;return c},css:function(b,c){if(typeof c==="undefined")return e(this.el,b);$_.each(function(a){e(a,b,c)})},append:function(b){typeof document.insertAdjacentHTML!=="undefined"?this.el.insertAdjacentHTML("beforeend",b):this.el.innerHTML=this.el.innerHTML+b},prepend:function(b){typeof document.insertAdjacentHTML!=="undefined"?this.el.insertAdjacentHTML("afterbegin",b):this.el.innerHTML=b+this.el.innerHTML},html:function(b){if(typeof b!=="undefined")this.el.innerHTML=
b;return this.el.innerHTML}})})();