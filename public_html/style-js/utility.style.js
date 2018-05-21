(function($) { $.fn.hasScrollBar = function() { return this.get(0).scrollHeight > this.get(0).clientHeight; } })(jQuery);
function getObjectIntProperty(object, property) { var value = window.getComputedStyle(object, null).getPropertyValue(property); return parseInt(value.substring(0, value.length - 2)); }
function goip(obj, prop) { return getObjectIntProperty(obj, prop); }