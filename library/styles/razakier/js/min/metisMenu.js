/*
 * Script Compressor v1.2.0 
 
 * ---------------------------------------------------------------------------------
 * Copyright (c) 2015 http://razakitechnology.com/application
 * generator compress javascript to minimize script production
 * and GPL licenses.
 * ----------------------------------------------------------------------------------
 
 * @ Depends	:	metisMenu.js
 * @ Date		:	2/15/2016
 * @ Author		:	razaki development team
 * @ Email		:	jombi_par@yahoo.com
 *
 */

(function(e,c,a,g){var d="metisMenu",f={toggle:true,doubleTapToGo:false};function b(i,h){this.element=e(i);this.settings=e.extend({},f,h);this._defaults=f;this._name=d;this.init()}b.prototype={init:function(){var j=this.element,h=this.settings.toggle,i=this;if(this.isIE()<=9){j.find("li.active").has("ul").children("ul").show();j.find("li").not(".active").has("ul").children("ul").hide()}else{j.find("li.active").has("ul").children("ul").addClass("collapse in");j.find("li").not(".active").has("ul").children("ul").addClass("collapse")}if(i.settings.doubleTapToGo){j.find("li.active").has("ul").children("a").addClass("doubleTapToGo")}j.find("li").has("ul").children("a").on("click."+d,function(k){k.preventDefault();if(i.settings.doubleTapToGo){if(i.doubleTapToGo(e(this))&&e(this).attr("href")!=="#"&&e(this).attr("href")!==""){k.stopPropagation();a.location=e(this).attr("href");return}}e(this).parent("li").toggleClass("active").children("ul").toggle();if(h){e(this).parent("li").siblings().removeClass("active").children("ul.in").hide()}})},isIE:function(){var j,h=3,k=a.createElement("div"),i=k.getElementsByTagName("i");while(k.innerHTML="<!--[if gt IE "+(++h)+"]><i></i><![endif]-->",i[0]){return h>4?h:j}},doubleTapToGo:function(h){var i=this.element;if(h.hasClass("doubleTapToGo")){h.removeClass("doubleTapToGo");return true}if(h.parent().children("ul").length){i.find(".doubleTapToGo").removeClass("doubleTapToGo");h.addClass("doubleTapToGo");return false}},remove:function(){this.element.off("."+d);this.element.removeData(d)}};console.log(typeof(e.fn.metisMenu));e.fn[d]=function(h){this.each(function(){var i=e(this);if(i.data(d)){i.data(d).remove()}i.data(d,new b(this,h))});return this};console.log(e.fn.metisMenu)})(jQuery,window,document);
