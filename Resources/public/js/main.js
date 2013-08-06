/*
 * This file is part of the desarrolla2 blog project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package     : desarrolla2.com
 * @author      : Daniel González <daniel.gonzalez@freelancemadrid.es>
 */
  
function addLoadEvent(func) {
    var oldonload = window.onload;
    if (typeof window.onload != 'function') {
        window.onload = func;
    } else {
        window.onload = function() {
            if (oldonload) {
                oldonload();
            }
            func();
        }
    }
}
addLoadEvent(function(){
    var codes = document.getElementsByTagName('code');
    for (var i = 0; i < codes.length; i++) { 
        hljs.highlightBlock(codes[i]);
    }
});
addLoadEvent(function(){    
    (function() {
        var sb = document.createElement("script");
        sb.type = "text/javascript";
        sb.async = true;
        sb.src = ("https:" == document.location.protocol ? "https://dtym7iokkjlif.cloudfront.net" : "http://cdn.shareaholic.com") + "/media/js/jquery.shareaholic-publishers-sb.min.js";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(sb, s);
    })();
});
var SHRSB_Settings = {
    "shr_class":{
        "src":"/bundles/blog/css/shareaholic/",
        "link":"",
        "service":"5,7,304,2,33,88,191,313",
        "apikey":"0747414f47c2b684cf5480c36b2478689",
        "localize":true,
        "shortener":"bitly",
        "shortener_key":"",
        "designer_toolTips":true,
        "tip_bg_color":"black",
        "tip_text_color":"white",
        "twitter_template":"${title} - ${short_link} via @desarrolla2"
    }
};
var SHRSB_Globals = {
    "perfoption":"1"
};

  
