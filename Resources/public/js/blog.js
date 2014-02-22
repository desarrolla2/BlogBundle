$(document).ready(function () {
    (function () {
        tinyMCE.init({
            menubar: false,
            mode: 'textareas',
            content_css: '/bundles/blog/css/textarea.css'
        });
    })();

    (function () {
        $('a.rating').click(function (e) {
            e.preventDefault();
            $parent = $(this).parent()
            $parent.html('<img src="/bundles/blog/img/ajax-loader.gif" class="rating"/>');
            $.post($(this).data('url'))
                .done(function (data) {
                    $parent.html(data);
                });
        });
    })();

    (function () {
        var cookieLaw = Cookie.get('accepted-cookie-law');

        if (cookieLaw !== 'yes') {
            var $body = $('body');
            $body.append(
                '<div class="cookie-law">' +
                    '<p>' +
                    'Este sitio necesita cookies para que funcionar correctamente. ' +
                    ' La navegación en el sitio supone la aceptación de las mismas. ' +
                    '<a class="accept button" href="#" >Aceptar</a> ' +
                    'Ver <a class="button" href="/cookies-policy" >política de cookies</a> ' +
                    '</p>' +
                    '</div>'
            );

            $('div.cookie-law a.accept').click(function (e) {
                e.preventDefault();
                Cookie.set('accepted-cookie-law', 'yes', 365 * 10);
                $('div.cookie-law').hide();
            });
        }
    })();
});