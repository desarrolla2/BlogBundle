$(document).ready(function () {
    tinyMCE.init({
        menubar: false,
        mode: 'textareas',
        content_css: '/bundles/blog/css/textarea.css'
    });
    $('a.rating').click(function (e) {
        e.preventDefault();
        $parent = $(this).parent()
        $parent.html('<img src="/bundles/blog/img/wait.gif" class="rating"/>');
        $.post($(this).data('url'))
            .done(function (data) {
                $parent.html(data);
            });
    });
});