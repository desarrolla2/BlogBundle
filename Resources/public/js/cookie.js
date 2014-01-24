var Cookie = (function () {
    return {
        get: function (key) {
            var name = key + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i].trim();
                if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
            }
            return "";
        },
        set: function (key, value, days) {
            var d = new Date();
            d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toGMTString();
            document.cookie = key + "=" + value + "; " + expires;
        },
        remove: function (key) {
            this.set(key, '', -1);
        },
        clear: function () {
            var cookies = document.cookie.split(";");
            for (var i = 0; i < cookies.length; i++)
                this.set(cookies[i].split("=")[0], '', -1);
        }
    }
}());