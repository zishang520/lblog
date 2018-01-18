/*
 * metismenu - v1.0.3
 */
!function(i,e,n,t){function l(e,n){this.element=e,this.settings=i.extend({},a,n),this._defaults=a,this._name=s,this.init()}var s="metisMenu",a={toggle:!0};l.prototype={init:function(){var e=i(this.element),n=this.settings.toggle;this.isIE()<=9?(e.find("li.active").has("ul").children("ul").collapse("show"),e.find("li").not(".active").has("ul").children("ul").collapse("hide")):(e.find("li.active").has("ul").children("ul").addClass("collapse in"),e.find("li").not(".active").has("ul").children("ul").addClass("collapse"));var t=!0;e.find("li").has("ul").children("a").on("click",function(e){e.preventDefault(),t&&(t=!1,i(this).parent("li").toggleClass("active").children("ul").collapse("toggle").on("shown.bs.collapse hidden.bs.collapse",function(){t=!0})),n&&i(this).parent("li").siblings().removeClass("active").children("ul.in").collapse("hide")})},isIE:function(){for(var i,e=3,t=n.createElement("div"),l=t.getElementsByTagName("i");t.innerHTML="<!--[if gt IE "+ ++e+"]><i></i><![endif]-->",l[0];)return e>4?e:i}},i.fn[s]=function(e){return this.each(function(){i.data(this,"plugin_"+s)||i.data(this,"plugin_"+s,new l(this,e))})}}(jQuery,window,document);
// toggleClick
!function(e){if("function"==typeof define&&define.amd)define(["jquery"],e);else if("object"==typeof exports){var t=require("jquery");module.exports=e(t)}else e(window.jQuery||window.Zepto||window.$)}(function(e){"use strict";e.fn.toggleClick=function(){var t=arguments;return this.click(function(){var i=e(this).data("iteration")||0;t[i].apply(this,arguments),i=(i+1)%t.length,e(this).data("iteration",i)})}});
/*!
  SerializeJSON jQuery plugin.
*/
!function(e){if("function"==typeof define&&define.amd)define(["jquery"],e);else if("object"==typeof exports){var n=require("jquery");module.exports=e(n)}else e(window.jQuery||window.Zepto||window.$)}(function(e){"use strict";e.fn.serializeJSON=function(n){var r,t,a,i,s,u,o,l,p,c,d;return r=e.serializeJSON,t=this,a=r.setupOpts(n),i=t.serializeArray(),r.readCheckboxUncheckedValues(i,a,t),s={},e.each(i,function(e,n){u=n.name,o=n.value,l=r.extractTypeAndNameWithNoType(u),p=l.nameWithNoType,c=l.type,c||(c=r.tryToFindTypeFromDataAttr(u,t)),r.validateType(u,c,a),"skip"!==c&&(d=r.splitInputNameIntoKeysArray(p),o=r.parseValue(o,u,c,a),r.deepSet(s,d,o,a))}),s},e.serializeJSON={defaultOptions:{checkboxUncheckedValue:void 0,parseNumbers:!1,parseBooleans:!1,parseNulls:!1,parseAll:!1,parseWithFunction:null,customTypes:{},defaultTypes:{string:function(e){return String(e)},number:function(e){return Number(e)},"boolean":function(e){var n=["false","null","undefined","","0"];return-1===n.indexOf(e)},"null":function(e){var n=["false","null","undefined","","0"];return-1===n.indexOf(e)?e:null},array:function(e){return JSON.parse(e)},object:function(e){return JSON.parse(e)},auto:function(n){return e.serializeJSON.parseValue(n,null,null,{parseNumbers:!0,parseBooleans:!0,parseNulls:!0})},skip:null},useIntKeysAsArrayIndex:!1},setupOpts:function(n){var r,t,a,i,s,u;u=e.serializeJSON,null==n&&(n={}),a=u.defaultOptions||{},t=["checkboxUncheckedValue","parseNumbers","parseBooleans","parseNulls","parseAll","parseWithFunction","customTypes","defaultTypes","useIntKeysAsArrayIndex"];for(r in n)if(-1===t.indexOf(r))throw new Error("serializeJSON ERROR: invalid option '"+r+"'. Please use one of "+t.join(", "));return i=function(e){return n[e]!==!1&&""!==n[e]&&(n[e]||a[e])},s=i("parseAll"),{checkboxUncheckedValue:i("checkboxUncheckedValue"),parseNumbers:s||i("parseNumbers"),parseBooleans:s||i("parseBooleans"),parseNulls:s||i("parseNulls"),parseWithFunction:i("parseWithFunction"),typeFunctions:e.extend({},i("defaultTypes"),i("customTypes")),useIntKeysAsArrayIndex:i("useIntKeysAsArrayIndex")}},parseValue:function(n,r,t,a){var i,s;return i=e.serializeJSON,s=n,a.typeFunctions&&t&&a.typeFunctions[t]?s=a.typeFunctions[t](n):a.parseNumbers&&i.isNumeric(n)?s=Number(n):!a.parseBooleans||"true"!==n&&"false"!==n?a.parseNulls&&"null"==n&&(s=null):s="true"===n,a.parseWithFunction&&!t&&(s=a.parseWithFunction(s,r)),s},isObject:function(e){return e===Object(e)},isUndefined:function(e){return void 0===e},isValidArrayIndex:function(e){return/^[0-9]+$/.test(String(e))},isNumeric:function(e){return e-parseFloat(e)>=0},optionKeys:function(e){if(Object.keys)return Object.keys(e);var n,r=[];for(n in e)r.push(n);return r},readCheckboxUncheckedValues:function(n,r,t){var a,i,s,u,o;null==r&&(r={}),o=e.serializeJSON,a="input[type=checkbox][name]:not(:checked):not([disabled])",i=t.find(a).add(t.filter(a)),i.each(function(t,a){s=e(a),u=s.attr("data-unchecked-value"),u?n.push({name:a.name,value:u}):o.isUndefined(r.checkboxUncheckedValue)||n.push({name:a.name,value:r.checkboxUncheckedValue})})},extractTypeAndNameWithNoType:function(e){var n;return(n=e.match(/(.*):([^:]+)$/))?{nameWithNoType:n[1],type:n[2]}:{nameWithNoType:e,type:null}},tryToFindTypeFromDataAttr:function(e,n){var r,t,a,i;return r=e.replace(/(:|\.|\[|\]|\s)/g,"\\$1"),t='[name="'+r+'"]',a=n.find(t).add(n.filter(t)),i=a.attr("data-value-type"),i||null},validateType:function(n,r,t){var a,i;if(i=e.serializeJSON,a=i.optionKeys(t?t.typeFunctions:i.defaultOptions.defaultTypes),r&&-1===a.indexOf(r))throw new Error("serializeJSON ERROR: Invalid type "+r+" found in input name '"+n+"', please use one of "+a.join(", "));return!0},splitInputNameIntoKeysArray:function(n){var r,t;return t=e.serializeJSON,r=n.split("["),r=e.map(r,function(e){return e.replace(/\]/g,"")}),""===r[0]&&r.shift(),r},deepSet:function(n,r,t,a){var i,s,u,o,l,p;if(null==a&&(a={}),p=e.serializeJSON,p.isUndefined(n))throw new Error("ArgumentError: param 'o' expected to be an object or array, found undefined");if(!r||0===r.length)throw new Error("ArgumentError: param 'keys' expected to be an array with least one element");i=r[0],1===r.length?""===i?n.push(t):n[i]=t:(s=r[1],""===i&&(o=n.length-1,l=n[o],i=p.isObject(l)&&(p.isUndefined(l[s])||r.length>2)?o:o+1),""===s?(p.isUndefined(n[i])||!e.isArray(n[i]))&&(n[i]=[]):a.useIntKeysAsArrayIndex&&p.isValidArrayIndex(s)?(p.isUndefined(n[i])||!e.isArray(n[i]))&&(n[i]=[]):(p.isUndefined(n[i])||!p.isObject(n[i]))&&(n[i]={}),u=r.slice(1),p.deepSet(n[i],u,t,a))}}});

// CSRF
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

$(document).ready(function() {

    $('#side-menu').metisMenu();

    // 弹出层消失
    setTimeout(function() {
        $('.alert-close').alert('close');
    }, 5000);

    // 切换
    (function($){
        var status = true;
        $('#adv').click(function(event) {
            if (status) {
                status = false;
                $("#advset").fadeToggle(function() {
                    status = true;
                    $.cookie("advset", $(this).css('display'), {
                        expires: 365
                    });
                });
            }
        });
    })($);
});

function selectAllToggle() {
    $("#select_all").toggleClick(function() {
        $(".ids").prop("checked", "checked");
    }, function() {
        $(".ids").prop("checked", null);
    });
}

function getChecked(node) {
    var re = false;
    $('input.' + node).each(function(i) {
        if (this.checked) {
            re = true;
            return false; // 存在了就跳出each
        }
    });
    return re;
}
// 显示提示信息
function ShowMsg(msg, time, noclosemodal, fun) {
    var f = (typeof(time) == 'function') ? time : ((typeof(noclosemodal) == 'function') ? noclosemodal : ((typeof(fun) == 'function') ? fun : function() {})),
        t = (typeof(time) == 'number') ? time : 1000,
        s = (typeof(time) == 'boolean') ? time : ((typeof(noclosemodal) == 'boolean') ? noclosemodal : false),
        model = $('<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"><div class="modal-dialog modal-sm zs-modal-top"><div class="modal-content"><div class="modal-body text-center">'+msg+'</div></div></div></div>');
    $('body').append(model);
    var Tnum = setTimeout(function() {
        model.modal('hide');
    }, t);
    model.modal('show').on('hide.bs.modal', function() {
        clearTimeout(Tnum); // 如果触发关闭命令就清除计时器
    }).on('hidden.bs.modal', function() {
        model.remove();
        if (s) { $('body').addClass('modal-open'); }
        f();
    });
}
