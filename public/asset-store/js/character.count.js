!function(s){s.fn.jQTArea=function(t){var r=s.extend({},{setLimit:200,setExt:"W",setExtR:!1},t);return this.each(function(){var t=s(this);s(".jQTAreaValue").html(r.setLimit),s(".jQTAreaCount").html(0),t.is("textarea")&&t.bind("keyup focus change",function(){var t,e,i,n,a;t=s(this),i=t.val(),n=i.length,(a=r.setLimit)<n?t.val(i.substring(0,a)):(s(".jQTAreaCount").html(n),s(".jQTAreaCountR").html(a-n),e=100*n/a,r.setExtR&&(e=100-e),"W"===r.setExt?s(".jQTAreaExt").width(e+"%"):s(".jQTAreaExt").height(e+"%"))})}),this}}(jQuery);