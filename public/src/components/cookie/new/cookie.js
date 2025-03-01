export default class Cookie {
  constructor() {
    let _cookie = {
      get_cookie: function (cookie_name) {
        let r = document.cookie.match('(^|;) ?' + cookie_name + '=([^;]*)(;|$)');
        return r ? unescape(r[2]) : null
      },
      delete_cookie: function (cookie_name) {
        let c = new Date();
        c.setTime(c.getTime() - 1);
        document.cookie = cookie_name += "=; expires=" + c.toGMTString()
      },
      set_cookie: function (name, value, exp_y, exp_m, exp_d, path, domain, secure) {
        let c = name + "=" + escape(value);
        if (exp_y) {
          let expires = new Date(exp_y, exp_m, exp_d);
          c += "; expires=" + expires.toGMTString()
        }
        if (path) c += "; path=" + escape(path);
        if (domain) c += "; domain=" + escape(domain);
        if (secure) c += "; secure";
        document.cookie = c;
      }
    };
    let __methods = {
      get: (t, m) => m in t ? t[m] : _cookie.get_cookie(m),
      set: (t, m, v) => v ? _cookie.set_cookie(m, v) : _cookie.delete_cookie(m)
    };
    this.cookie = new Proxy(_cookie, __methods);
  }

}