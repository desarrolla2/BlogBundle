$(document).ready(function () {
    var base_url = window.location.protocol + "//" + window.location.host + "/";
    tinyMCE.init({
        keep_styles: false,
        preformatted: true,
        content_css: '/bundles/blog/css/textarea.css',
        selector: ".wysiwyg",
        theme: "modern",
        plugins: [
            "advlist autolink lists link image preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "template paste textcolor"
        ],
        toolbar1: " undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media preview",
        image_advtab: true
    });
});