$(document).ready(function() {
    var l = window.location;
    var base_url = l.protocol + "//" + l.host + "/" ;
    tinyMCE.init({
        theme : "ribbon",
        keep_styles : false,
        preformatted : true,
        document_base_url : base_url + "bundles/blog/js/tiny_mce/",
        mode : 'textareas',
        content_css : '/bundles/blog/css/textarea.css'
    });       
});