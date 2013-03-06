$(document).ready(function() {
    var base_url = window.location.protocol + "//" + window.location.host + "/";
    tinyMCE.init({
        keep_styles: false,
        document_base_url: base_url + "bundles/blog/js/tiny_mce/",
        mode: 'textareas',
        content_css: '/bundles/blog/css/textarea.css'
    });
});