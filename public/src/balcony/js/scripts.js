!(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    const banner = document.getElementById("cookie-banner");
    const btn = document.getElementById("accept-cookie-btn");

    if (!localStorage.getItem("cookieAccepted")) {
      banner.style.display = "flex"; // показать баннер
    }

    btn.addEventListener("click", function () {
      banner.style.display = "none"; // скрыть баннер
      localStorage.setItem("cookieAccepted", "true");
    });
  });

  var e,
    t = {
      851: function (e, t, s) {
        var i = s(23),
          a = s.n(i),
          n = s(171);
        var l = new (class {
            constructor() {
              ((this.mapModules = new Map()), (this.mapComponents = new Map()));
            }

            init() {
              for (let [e, t] of this.mapModules.entries())
                if (n(e).length) {
                  let s = t(e);
                  s && this.mapComponents.set(e, s);
                }
            }

            initElement(e) {
              if (n(e).length) {
                let t = this.mapModules.get(e)(e);
                t && this.mapComponents.set(e, t);
              }
            }

            add(e, t) {
              e && t && this.mapModules.set(e, t);
            }

            getComponent(e) {
              return this.mapComponents.get(e);
            }
          })(),
          o = s(178),
          r = s.n(o);
        var c = new (class {
            constructor() {
              this.timer = {};
            }

            get hash() {
              return this.createHash(8);
            }

            getMidSize(e, t) {
              return Math.ceil((t + e) / 2);
            }

            actionFilter(e) {
              let { keyTimer: t, duration: s = 10, action: i } = e;
              (this.timer[t] &&
                (clearTimeout(this.timer[t]), (this.timer[t] = "")),
                i &&
                  (this.timer[t] = setTimeout(() => {
                    i();
                  }, s)));
            }

            getNum(e) {
              return Number(r()(e).format("0,0.[00]").replace(/,/g, ""));
            }

            getMoney(e) {
              return r()(e).format("0,0.[00]").replace(/,/g, " ");
            }

            getFormatNum(e) {
              return r()(e).format("0.[00]").replace(/\./g, ",");
            }

            inputDigits(e) {
              let t = /^\d*(\.\d{0,1})?$/,
                s = e.target.value;
              !(
                "Enter" != e.key &&
                t.test(e.key) &&
                t.test(s) &&
                (Number(s) || 0 == Number(s))
              ) && e.preventDefault();
            }

            createHash(e) {
              let t = "abcdefghijklmnopqrstuvwxyz0123456789",
                s = "";
              e = e || 6;
              for (let i = 0; i < e; i++)
                s += t.charAt(Math.floor(36 * Math.random()));
              return s;
            }

            ucFirst(e) {
              return e ? e[0].toUpperCase() + e.slice(1) : e;
            }

            numFormat(e) {
              let t,
                s =
                  arguments.length > 1 && void 0 !== arguments[1]
                    ? arguments[1]
                    : "rub",
                i =
                  arguments.length > 2 && void 0 !== arguments[2]
                    ? arguments[2]
                    : null;
              return (
                "rub" == s
                  ? (t = {
                      style: "currency",
                      currency: "RUB",
                      maximumFractionDigits: null === i ? 0 : i,
                      roundingIncrement: 1,
                    })
                  : "num" == s
                    ? (t = {
                        style: "decimal",
                        minimumFractionDigits: null == i ? 0 : i,
                      })
                    : "per" == s &&
                      (t = {
                        style: "percent",
                        minimumFractionDigits: null == i ? 0 : i,
                      }),
                new Intl.NumberFormat("ru", t).format(Number(e))
              );
            }

            clearPhone(e) {
              return String(e).replace(/[^\d]/g, "");
            }
          })(),
          d = s(651),
          m = s(34),
          u = s(227);

        function p(e) {
          let t =
            arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
          const s = (e) => {
            try {
              ym(9847573, "reachGoal", e);
            } catch (e) {}
          };
          if (t) s(t);
          else if ("mail" != e.attribute)
            switch (e.form) {
              case "zamer":
                s("zamer-float" === e?.type ? "zamer-float" : "sendOrder");
                break;
              case "gotovie":
                s("doneOrderCart");
                break;
              case "gotovieCart":
                s("addToCart");
                break;
              case "gotovieAction":
                s("gotovieAction");
                break;
              case "calc_banner_gotovie":
                s("calcBannerGotovie");
                break;
              case "mosquito":
                s("mosqPay");
                break;
              case "configurator":
                s("configOrder");
                break;
              case "callback_popup":
                s("callBack");
                break;
              case "coop-designer":
                s("designOrder");
                break;
              default:
                s("sendOrder");
            }
          else
            switch (e.form) {
              case "partnership":
                s("partnership");
                break;
              case "service":
                s("services-feedback");
                break;
              case "review":
                s("customerReview");
            }
        }

        var h = s(171);
        var _ = new (class {
            constructor() {
              ((this.videoModal = ""),
                (this.daData = new u.Z(
                  "c0fdecb6f2a2d2d82a991c705f9be59b3b5f59dc",
                )));
            }

            fixVHMobileDevice() {
              let e = 0.01 * window.innerHeight;
              (document.documentElement.style.setProperty("--vh", `${e}px`),
                window.addEventListener("resize", () => {
                  let e = 0.01 * window.innerHeight;
                  document.documentElement.style.setProperty("--vh", `${e}px`);
                }));
            }

            initVideoModal() {
              let e = (e, t) => {
                let s = h(e).find("iframe")[0];
                const i = (e, t) => {
                  e.contentWindow.postMessage(
                    JSON.stringify({ event: "command", func: t }),
                    "*",
                  );
                };
                "playVideo" == t
                  ? s.src
                    ? i(s, t)
                    : (s.addEventListener("load", () => {
                        setTimeout(() => {
                          i(s, t);
                        }, 1e3);
                      }),
                      (s.src = s.dataset.src))
                  : i(s, t);
              };
              this.videoModal = new d.Z({
                linkAttributeName: "data-video-modal",
                beforeOpen: function (t) {
                  e(t.openedWindow, "playVideo");
                },
                afterClose: function (t) {
                  e(t.openedWindow, "pauseVideo");
                },
              });
            }

            initSmoothScrollToAnchor() {
              if (
                (h('a[href^="#"]')
                  .filter((e, t) => !!h(t).attr("href").substring(1))
                  .off("click.scroll_to_anchor")
                  .on("click.scroll_to_anchor", function (e) {
                    e.preventDefault();
                    let t =
                        window.document.scrollingElement ||
                        window.document.body ||
                        window.document.documentElement,
                      s = h(this).attr("href"),
                      i = h(".js-head-menu").innerHeight(),
                      a = h(s).offset().top - i;
                    (0, m.Z)({
                      targets: t,
                      scrollTop: a,
                      duration: 500,
                      easing: "easeInOutQuad",
                    });
                  }),
                window.location.hash)
              ) {
                let e = h(window.location.hash);
                if (e[0]) {
                  let t =
                      window.document.scrollingElement ||
                      window.document.body ||
                      window.document.documentElement,
                    s = h(".js-head-menu").innerHeight(),
                    i = e.offset().top - s;
                  setTimeout(() => {
                    (0, m.Z)({
                      targets: t,
                      scrollTop: i,
                      duration: 500,
                      easing: "easeInOutQuad",
                    });
                  }, 500);
                }
              }
            }

            initWaCt() {
              window.ct &&
                window.ct("modules", "widgets", "subscribeToEvent", [
                  {
                    object: "button",
                    action: "click",
                    callback: function (e) {
                      "whatsapp-messenger" == e.data.widgetType &&
                        p({}, "wabtn");
                    },
                  },
                ]);
            }

            initMobileBtn() {
              setTimeout(() => {
                let e = h(".js-mobile-button");
                if (window.OnlineChat) {
                  (e.removeClass("mobile-button--hidden"),
                    e.find(".js-mobile-button--chat").on("click", () => {
                      window.OnlineChat("openSupport");
                    }));
                }
              }, 3e3);
            }

            initFlBanner() {
              window.$flBanner = h(".js-flocktory-banner");
            }

            checkJS() {
              document.body.classList.add("js-enabled");
            }

            sessionCttoWaTg() {
              if (window.call_value) {
                let e = document.querySelectorAll("[href*=POSaleBot]"),
                  t = document.querySelectorAll("[href*=whatsapp]");
                (e.forEach((e) => {
                  e.href = e.href + "?start=" + window.call_value;
                }),
                  t.forEach((e) => {
                    e.href = encodeURI(
                      decodeURI(e.href) + "+Колтач+" + window.call_value,
                    );
                  }));
              }
            }
          })(),
          g = s(171),
          w = (e) => {
            let t = g(e);
            for (let e of t) {
              let t = Number(g(e).text().replace(/ /g, ""));
              g(e).text(c.getMoney(t));
            }
          },
          v = s(171);

        class f {
          constructor(e) {
            ((this.el = e),
              (this.count = Number(v(e).data("count"))),
              (this.weight = Number(v(e).data("weight"))),
              (this.direction = v(e).data("direction")),
              (this.tempIco = v(e).html()),
              this.init(),
              v(e).show());
          }

          init() {
            (v(this.el).empty(),
              (this.$wrap = this.createWrapper()),
              (this.$items = this.createItems()),
              this.setDisableItems());
          }

          createEl(e) {
            let t = document.createElement("div"),
              s = v(t);
            return (s.addClass(e), s);
          }

          createWrapper() {
            let e = this.createEl("weight-bar__wrap");
            return (v(this.el).append(e), e);
          }

          createItems() {
            let e = [];
            for (; e.length < this.count; ) {
              let t = this.createEl("weight-bar__item");
              (t.html(this.tempIco), e.push(t), this.$wrap.append(t));
            }
            return e;
          }

          setDisableItems(e) {
            let { $items: t, direction: s, count: i } = this;
            if ((e && (this.weight = e), "rtl" == s))
              for (let [e, s] of Object.entries(t))
                e < i - this.weight
                  ? s.addClass("disable")
                  : s.removeClass("disable");
            else
              for (let [e, s] of Object.entries(t))
                e < this.weight
                  ? s.removeClass("disable")
                  : s.addClass("disable");
          }
        }

        var y = (e) => {
            let t = [];
            return (
              v(e).each(function (e, s) {
                t.push(new f(this));
              }),
              t
            );
          },
          b = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "search-address" }, [
              t(
                "div",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: e.strSearch,
                      expression: "strSearch",
                    },
                  ],
                  staticClass: "search-address__clear",
                  attrs: { title: "Очистить" },
                  on: { click: e.clearField },
                },
                [
                  t("svg", { staticClass: "ico" }, [
                    t("use", {
                      attrs: {
                        "xlink:href":
                          "/new_style_files/upload/icon/interface.svg#close-2",
                      },
                    }),
                  ]),
                ],
              ),
              t("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: e.strDetailAddress,
                    expression: "strDetailAddress",
                  },
                ],
                attrs: { type: "hidden", name: `${e.inputParam.name}-detail` },
                domProps: { value: e.strDetailAddress },
                on: {
                  input: function (t) {
                    t.target.composing || (e.strDetailAddress = t.target.value);
                  },
                },
              }),
              t("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: e.strSearch,
                    expression: "strSearch",
                  },
                ],
                staticClass:
                  "control__input search-address__input js-user-address",
                class: e.inputParam.class ? e.inputParam.class : "",
                attrs: {
                  type: "text",
                  name: e.inputParam.name,
                  autocomplete: "street-address",
                  required: e.inputParam.required,
                },
                domProps: { value: e.strSearch },
                on: {
                  input: function (t) {
                    t.target.composing || (e.strSearch = t.target.value);
                  },
                },
              }),
              t(
                "div",
                { ref: "menuList", staticClass: "search-address__list" },
                e._l(e.searchList, function (s) {
                  return t(
                    "div",
                    {
                      key: s.id,
                      staticClass: "search-address__list-item",
                      on: {
                        click: function (t) {
                          return e.setItem(s);
                        },
                      },
                    },
                    [e._v(e._s(s.value))],
                  );
                }),
                0,
              ),
            ]);
          };
        b._withStripped = !0;
        var k = s(171);
        var C = new (class {
            slideDown(e) {
              let {
                el: t,
                duration: s = 300,
                maxHeight: i = 300,
                onStart: a,
                onStop: n,
              } = e;
              (!t.anime?.completed && t.anime) ||
                (t.anime = (0, m.Z)({
                  targets: t,
                  height: () => {
                    k(t).css({ display: "block", opacity: 0 });
                    let e = k(t).height();
                    return (
                      (t.style.cssText = ""),
                      i &&
                        e > i &&
                        ((e = i),
                        k(t).css({
                          maxHeight: i,
                          "overflow-y": "scroll",
                        })),
                      ["0px", `${e}px`]
                    );
                  },
                  duration: s,
                  easing: "easeInOutExpo",
                  begin: (e) => {
                    ((t.style.display = "block"), a && a(t));
                  },
                  complete: (e) => {
                    n && n(t);
                  },
                }));
            }

            slideUp(e) {
              let { el: t, duration: s = 300, onStart: i, onStop: a } = e;
              (!t.anime?.completed && t.anime) ||
                (t.anime = (0, m.Z)({
                  targets: t,
                  height: "0px",
                  duration: s,
                  easing: "easeInOutExpo",
                  begin: (e) => {
                    ((t.style.display = "none"), i && i(t));
                  },
                  complete: (e) => {
                    ((t.style.cssText = ""), a && a(t));
                  },
                }));
            }

            barFlip(e) {
              let { el: t, onStart: s, duration: i = 300 } = e;
              (!t.anime?.completed && t.anime) ||
                (t.anime = (0, m.Z)({
                  targets: t,
                  translateY: s,
                  duration: i,
                  easing: "easeInOutExpo",
                }));
            }
          })(),
          S = s(171),
          x = {
            name: "search-address",
            props: { param: Object, deliveryAddress: String },
            data() {
              return {
                hash: c.hash,
                strSearch: "",
                inputParam: {},
                isShow: !1,
                searchList: [],
                curItem: "",
                strDetailAddress: "",
              };
            },
            methods: {
              slideDownMenu() {
                let { menuList: e } = this.$refs;
                C.slideDown({
                  maxHeight: 126,
                  el: e,
                  duration: 150,
                  onStart: () => {},
                });
              },
              slideUpMenu() {
                let { menuList: e } = this.$refs;
                C.slideUp({
                  el: e,
                  duration: 150,
                  onStart: () => {},
                });
              },
              getDadata() {
                _.daData.suggest("address", this.strSearch.trim()).then((e) => {
                  ((this.searchList = e.map((e) => ((e.id = c.hash), e))),
                    e.length && (this.isShow = !0));
                });
              },
              setItem(e) {
                ((this.curItem = e), (this.isShow = !1));
              },
              clickOutBlock() {
                S(window).on("click.out_search_input_address", (e) => {
                  S(e.target).closest(this.$el).length || (this.isShow = !1);
                });
              },
              clearField() {
                ((this.strSearch = ""), this.$emit("onClear"));
              },
            },
            mounted() {
              this.clickOutBlock();
            },
            created() {
              this.param
                ? (this.inputParam = this.param)
                : this.$parent.inputParam
                  ? (this.inputParam = this.$parent.inputParam)
                  : (this.inputParam = {
                      name: "address-delivery",
                      class: "js-user-address",
                      required: !0,
                    });
            },
            watch: {
              strSearch(e) {
                let t = e.trim();
                t && t.length > 3 && t != this.deliveryAddress
                  ? this.curItem.value != e &&
                    c.actionFilter({
                      keyTimer: "search_input_string" + this.hash,
                      duration: 500,
                      action: () => {
                        this.getDadata();
                      },
                    })
                  : (this.isShow = !1);
              },
              isShow(e) {
                e ? this.slideDownMenu() : this.slideUpMenu();
              },
              curItem(e) {
                ((this.strSearch = e.value),
                  (this.strDetailAddress = e.unrestricted_value),
                  this.$emit("onChange", e));
              },
              deliveryAddress(e) {
                e && ((this.strSearch = e), (this.strDetailAddress = ""));
              },
            },
          },
          P = s(659),
          j = (0, P.Z)(x, b, [], !1, null, null, null).exports,
          q = s(171);

        class D {
          constructor(e) {
            this.el = e;
            let t = (this.name = q(e).attr("name")),
              s = (this.required = void 0 !== q(e).attr("required")),
              i = (this.vueID = `input-address-dadata-${c.hash}`);
            (q(e).after(`<vue-app id="${this.vueID}"></vue-app>`),
              q(e).remove());
            this.vueApp = new (a())({
              el: `#${i}`,
              data: { inputParam: { name: t, required: s } },
              render: (e) => e(j),
            });
          }
        }

        var L = (e) => {
            q(e).each(function (e, t) {
              new D(this);
            });
          },
          M = s(309);
        var $ = new (class {
            constructor() {
              ((this.dataName = {
                listSlider: "promotions-slider",
                listSliderNext: "promotions-slider-next",
                listSliderPrev: "promotions-slider-prev",
              }),
                this.init());
            }

            init() {
              let e = document.querySelectorAll(
                `[data-${this.dataName.listSlider}]`,
              );
              if (!e.length) return !1;
              e.forEach((e) => {
                let t = e,
                  s = t.querySelector(`[data-${this.dataName.listSliderNext}]`),
                  i = t.querySelector(`[data-${this.dataName.listSliderPrev}]`);
                new M.ZP(e, {
                  modules: [M.W_],
                  slidesPerView: 1,
                  spaceBetween: 10,
                  loop: !1,
                  autoHeight: !1,
                  navigation: { nextEl: s, prevEl: i },
                  breakpoints: {
                    768: { slidesPerView: 1.5, spaceBetween: 10 },
                    991: { slidesPerView: 2.3, spaceBetween: 20 },
                  },
                });
              });
            }
          })(),
          z = s(171);

        class E {
          constructor(e) {
            ((this.el = e),
              (this.$mg_items = z(e).find(".js-mega-menu-item")),
              (this.$curOpenMgItem = ""),
              (this.$curOpenSmMenu_lv1 = ""),
              (this.$onMouse = ""),
              (this.className = { menuOpen: "open" }),
              (this.dataName = {
                submenu: "submenu",
                submenuToggle: "submenu-toggle",
              }),
              (this.$submenuToggle = document.querySelectorAll(
                `[data-${this.dataName.submenuToggle}]`,
              )),
              this.createMgItemCountLink(),
              this.initEvents());
          }

          get $openSmMenu_lv1() {
            return z("body")
              .find(".js-mg-submenu-lv1")
              .filter((e, t) => t.isShowMenu);
          }

          get width() {
            return z(this.el).width();
          }

          set positionSmMenu_lv1(e) {
            let { $mg_item: t, $sm_menu: s } = e,
              i = t.offset().left,
              a = t.offset().right,
              n = t.offset().top + t.height(),
              l = window.pageYOffset,
              o = z(window).height(),
              r = z(window).width(),
              c = s.height(),
              d = s.width(),
              m = "unset";
            n -= l;
            let u = o - (c + n);
            (u < 0 && (n += u), n < 0 && (n = 0));
            let p = r - (d + i);
            (s.hasClass("mg-submenu-lv1_ul")
              ? ((a = 100), (i = "auto"))
              : p < 0 && ((a = 0), (i = "auto")),
              s.hasClass("type-big-submenu") &&
                ((i = (r - d) / 2), (a = (r - d) / 2)),
              s.hasClass("type--slider") &&
                ((i = "50%"), (a = "auto"), (m = "translateX(-50%)")),
              s.css({
                top: n,
                left: i,
                right: a,
                maxHeight: "",
                transform: m,
              }));
          }

          initEvents() {
            (this.windowResize(),
              this.scrollMg(),
              this.clickOutside(),
              this.clickMgItem(),
              this.$submenuToggle.forEach((e) => {
                e.addEventListener("mouseenter", (e) => {
                  this.openSubmenu(e.currentTarget);
                });
              }),
              this.$submenuToggle.forEach((e) => {
                e.addEventListener("mouseleave", (e) => {
                  this.closeSubmenu(e.currentTarget);
                });
              }));
          }

          openSubmenu(e) {
            return (
              e.classList.contains(this.className.menuOpen) ||
                (this.hideSmMenu_lv1(),
                e.classList.add(this.className.menuOpen)),
              !1
            );
          }

          closeSubmenu(e) {
            return (
              e.classList.contains(this.className.menuOpen) &&
                e.classList.remove(this.className.menuOpen),
              !1
            );
          }

          onMouseItem() {
            let { $mg_items: e, el: t, $onMouse: s } = this;
            e.on("mouseenter", (e) => {
              s = e.path[1];
            });
          }

          createMgItemCountLink() {
            this.$mg_items.each((e, t) => {
              let s = z(t).children("a");
              s.length && (s[0].countLink = 0);
            });
          }

          createSmItemCountLink() {
            this.$curOpenSmMenu_lv1
              .find(".js-mg-submenu-lv1-item")
              .each((e, t) => {
                let s = z(t).children("a");
                s.length && (s[0].countLink = 0);
              });
          }

          setCurOpenMenu(e) {
            let { $mg_item: t, $sm_menu: s } = e;
            if (
              ((this.$curOpenMgItem = t),
              (this.$curOpenSmMenu_lv1 = s),
              this.$curOpenSmMenu_lv1 &&
                this.$curOpenSmMenu_lv1[0].classList.contains("js-system-menu"))
            ) {
              let e = this.$curOpenSmMenu_lv1.find("[data-system-code]"),
                t = this.$curOpenSmMenu_lv1.find("[data-system-banner]");
              e.each((e, s) => {
                s.addEventListener("mouseenter", (e) => {
                  if (e.target.dataset.systemCode) {
                    let s = this.$curOpenSmMenu_lv1.find(
                      `[data-system-banner="${e.target.dataset.systemCode}"]`,
                    );
                    "none" == s[0].style.display &&
                      (t.each((e, t) => {
                        t.style.display = "none";
                      }),
                      (s[0].style.display = "flex"));
                  }
                });
              });
            }
          }

          fixPositionMg() {
            let { $curOpenMgItem: e, $curOpenSmMenu_lv1: t } = this;
            e && t && (this.positionSmMenu_lv1 = { $mg_item: e, $sm_menu: t });
          }

          hideSmMenu_lv1() {
            let e = this.$openSmMenu_lv1;
            (this.$mg_items.removeClass("active"),
              e.length &&
                (e.hide(),
                e.remove(),
                this.setCurOpenMenu({
                  $mg_item: "",
                  $sm_menu: "",
                })));
          }

          showSmMenu_lv1(e, t) {
            return (
              (t = t.clone()),
              z("body").append(t),
              t.hasClass("type--slider") && $.init(),
              this.setCurOpenMenu({
                $mg_item: e,
                $sm_menu: t,
              }),
              (t[0].isShowMenu = !0),
              e.addClass("active"),
              this.createSmItemCountLink(),
              this.clickSmLinkItem(),
              t.show(),
              t.hasClass("type-big-submenu") && t.css({ display: "flex" }),
              t.hasClass("mg-submenu-lv1_ul") && t.css({ display: "flex" }),
              this.closeOnMouseLeave(t[0]),
              setTimeout(() => {
                this.fixPositionMg();
              }, 50),
              this.clickSmItem(),
              t
            );
          }

          closeOnMouseLeave(e) {
            e.addEventListener("mouseleave", (e) => {
              this.hideSmMenu_lv1();
            });
          }

          getIsClosest(e, t) {
            return !!z(e).closest(t).length;
          }

          clickOutside() {
            z(window).on("click.mg_menu", (e) => {
              let t = e.target,
                s = this.getIsClosest(t, this.el),
                i = this.getIsClosest(t, ".js-mg-submenu-lv1");
              s || i || this.hideSmMenu_lv1();
            });
          }

          clickMgItem() {
            let e = this;
            this.$mg_items.on("mouseenter.mg_menu", function () {
              let t = z(this).find(".js-mg-submenu-lv1"),
                s = z(this).hasClass("active");
              (s || e.hideSmMenu_lv1(),
                setTimeout(() => {
                  if (t.length && !s && window.innerWidth > 991) {
                    let s = e
                      .showSmMenu_lv1(z(this), t)
                      .find(".js-mg-submenu-lv1-item");
                    for (let e of s)
                      if (z(e).hasClass("open-menu")) {
                        let t = z(e).children("a");
                        (z(e).addClass("active"), t[0].countLink++);
                      }
                  }
                }, 10));
            });
          }

          clickMgLinkItem() {
            for (let e of this.$mg_items) {
              let t = z(e).children("a"),
                s = z(e),
                i = s.find(".js-mg-submenu-lv1");
              t.length &&
                i.length &&
                t.on("click.mg_item_link", function (e) {
                  this.countLink
                    ? s.hasClass("active") || e.preventDefault()
                    : (e.preventDefault(), this.countLink++);
                });
            }
          }

          clickSmItem() {
            let e = this,
              { $curOpenMgItem: t, $curOpenSmMenu_lv1: s } = this;
            if (s.length) {
              let t = s.find(".js-mg-submenu-lv1-item"),
                i = s.find(".js-mg-submenu-lv2");
              t.off("click.mg_menu").on("click.mg_menu", function () {
                let s = z(this).find(".js-mg-submenu-lv2");
                if (s.length) {
                  let a = z(this).hasClass("active");
                  (i.hide(),
                    t.removeClass("active"),
                    a
                      ? e.fixPositionMg()
                      : (z(this).addClass("active"),
                        C.slideDown({
                          el: s[0],
                          duration: 300,
                          maxHeight: "",
                          onStop() {
                            e.fixPositionMg();
                          },
                        })));
                }
              });
            }
          }

          clickSmLinkItem() {
            let e = this.$curOpenSmMenu_lv1
              .find(".js-mg-submenu-lv1-item")
              .children("a");
            e.length &&
              e.on("click.sm_item_link", function (e) {
                let t = z(this).closest(".js-mg-submenu-lv1-item"),
                  s = t.find(".js-mg-submenu-lv2");
                s.length && !this.countLink
                  ? (e.preventDefault(), this.countLink++)
                  : s.length && !t.hasClass("active") && e.preventDefault();
              });
          }

          hoverMenu() {
            let { el: e, $mg_items: t } = this;
            (z(e).on("mouseenter.mega_menu", () => {
              z("body").hasClass("mega-menu-rollup") &&
                (z("body").addClass("rollup-full"), this.hideSmMenu_lv1());
            }),
              z(e).on("mouseleave.mega_menu", () => {
                let e = z("body").hasClass("mega-menu-rollup"),
                  s = !1;
                e &&
                  (t.each(function (e, t) {
                    s = s || z(this).hasClass("active");
                  }),
                  s || z("body").removeClass("rollup-full"));
              }));
          }

          scrollMg() {
            let e = this;
            z(this.el).on("scroll", () => {
              c.actionFilter({
                keyTimer: "scroll-mg-menu",
                action() {
                  e.fixPositionMg();
                },
              });
            });
          }

          windowResize() {
            let e = this;
            z(window).on("resize.mg_menu", () => {
              c.actionFilter({
                keyTimer: "resize-mg-menu",
                action() {
                  e.fixPositionMg();
                },
              });
            });
          }
        }

        var F = (e) => new E(e),
          O = s(171);

        class T {
          constructor(e) {
            ((this.el = e),
              (this.isMenuOpen = !1),
              (this.$mobMenu = O(e)),
              (this.$mb_items = O(e).find(".js-mob-mg-item")),
              (this.headMenu = ""),
              (this.$overlay = O(e).find(".js-mb-overlay")),
              (this.$actionBox = O(e).find(".js-mob-mg__action-box")),
              (this.depthItems = []),
              this.initEvents());
          }

          get $btnBackMenu() {
            return this.$actionBox.find(".js-mob-mg-back");
          }

          get $subItems() {
            return this.$actionBox.find(".js-mob-mg-item");
          }

          initEvents() {
            (this.windowResize(), this.clickOverlay(), this.clickItem());
          }

          windowResize() {
            let e = this;
            O(window).on("resize.mob_mg_menu", () => {
              c.actionFilter({
                keyTimer: "resize_window_mob-mg-menu",
                duration: 100,
                action() {
                  e.close();
                },
              });
            });
          }

          clickOverlay() {
            this.$overlay.on("click.mob_mg_menu", () => {
              this.close();
            });
          }

          clickItem() {
            let e = this;
            this.$mb_items.on("click.mb_mg_item", function () {
              let t = O(this).children(".js-mg-submenu").clone();
              (e.clearDepthItems(), e.addSubMenu(t));
            });
          }

          clickSubItem() {
            let e = this;
            this.$subItems
              .off("click.mob_mg_menu")
              .on("click.mob_mg_menu", function () {
                let t = O(this).children(".js-mg-submenu").clone();
                e.addSubMenu(t);
              });
          }

          clickBtnBack() {
            this.$btnBackMenu
              .off("click.mob_mg_menu")
              .on("click.mob_mg_menu", () => {
                let e = this.depthItems.pop();
                (e && e.remove(),
                  this.depthItems.length ||
                    this.$actionBox.removeClass("active"));
              });
          }

          addSubMenu(e) {
            e.length &&
              (this.depthItems.push(e),
              this.$actionBox.append(e).addClass("active"),
              e.show(),
              this.clickBtnBack(),
              this.clickSubItem());
          }

          clearDepthItems() {
            for (
              this.$actionBox.hasClass("active") &&
              this.$actionBox.removeClass("active");
              this.depthItems.length;

            ) {
              this.depthItems.pop().remove();
            }
          }

          close() {
            this.isMenuOpen &&
              (O("body").removeClass("no-scroll"),
              this.$mobMenu.hide(),
              this.headMenu && this.headMenu.show(),
              this.clearDepthItems(),
              (this.isMenuOpen = !1));
          }

          open(e) {
            ((this.isMenuOpen = !0),
              e && (this.headMenu = e),
              this.$mobMenu.css({ display: "flex" }),
              O("body").addClass("no-scroll"));
          }
        }

        var B = (e) => new T(e),
          I = s(171);

        class W {
          constructor(e) {
            ((this.el = e),
              (this.$headMenu = I(e)),
              (this.$btnOpenMenu = I(e).find(".js-btn-open-menu")),
              (this.pageYOffset = window.pageYOffset),
              this.initEvents());
          }

          get offsetTop() {
            return $head.offset().top;
          }

          get height() {
            return this.$headMenu.height();
          }

          initEvents() {
            (this.clickBtnOpenMenu(), this.burgerAccess());
          }

          clickBtnOpenMenu() {
            let e = l.getComponent(".js-mob-mega-menu");
            this.$btnOpenMenu.on("click.head_menu", () => {
              (this.$btnOpenMenu.hasClass("burger-nav--open")
                ? e && e.close(this)
                : e && e.open(this),
                this.$btnOpenMenu.toggleClass("burger-nav--open"));
            });
          }

          burgerAccess() {
            this.$btnOpenMenu.hasClass("burger-nav--open") &&
              this.$btnOpenMenu.toggleClass("burger-nav--open");
          }

          scrollWindow() {
            let e = this;
            I(window).on("scroll.head_menu", () => {
              ((this.pageYOffset = window.pageYOffset),
                c.actionFilter({
                  keyTimer: "fix_header_menu",
                  duration: 100,
                  action() {
                    e.fixPosition();
                  },
                }));
            });
          }

          fixPosition() {
            let { $headMenu: e, height: t, pageYOffset: s } = this;
            s > 2 * t && !e.hasClass("head-menu--fixed")
              ? (e.addClass("head-menu--fixed"),
                C.slideDown({
                  el: this.$headMenu[0],
                  duration: 300,
                  maxHeight: "",
                  onStart(e) {
                    I(e).css({ display: "flex", overflowY: "hidden" });
                  },
                  onStop(e) {
                    I(e).css({ height: "" });
                  },
                }))
              : 0 == s && e.removeClass("head-menu--fixed");
          }

          show() {
            this.$headMenu.show();
          }

          hide() {
            this.$headMenu.hide();
          }
        }

        var A = (e) => new W(e);
        new (class {
          constructor() {
            ((this.dataName = {
              headSlider: "head-slider",
              headSliderNext: "head-slider-next",
              headSliderPrev: "head-slider-prev",
            }),
              this.init());
          }

          init() {
            let e = document.querySelectorAll(
              `[data-${this.dataName.headSlider}]`,
            );
            if (!e.length) return !1;
            e.forEach((e) => {
              let t = e,
                s = t.querySelector(`[data-${this.dataName.headSliderNext}]`),
                i = t.querySelector(`[data-${this.dataName.headSliderPrev}]`);
              new M.ZP(e, {
                modules: [M.W_],
                slidesPerView: "auto",
                spaceBetween: 4,
                loop: !1,
                autoHeight: !1,
                navigation: { nextEl: s, prevEl: i },
                breakpoints: {
                  768: { spaceBetween: 40 },
                  991: { spaceBetween: 60 },
                },
              });
            });
          }
        })();
        var V = () => {
            new M.tq(".work-example__slider", {
              slidesPerView: 1,
              spaceBetween: 10,
              modules: [M.W_],
              navigation: {
                nextEl: ".arrow-box--right",
                prevEl: ".arrow-box--left",
              },
            });
          },
          N = s(307),
          Z = s(728);
        var R = new (class {
            constructor() {
              ((this.origin = window.location.origin),
                (this.hostname = window.location.hostname),
                (this.search = window.location.search),
                (this.pathname = window.location.pathname),
                (this.isValidUrl = (e) => {
                  try {
                    return Boolean(new URL(e));
                  } catch (e) {
                    return !1;
                  }
                }));
            }

            async ajaxPost(e) {
              let { url: t, data: s } = e,
                i =
                  (c.hash,
                  await fetch(t, {
                    method: "POST",
                    headers: {
                      "Content-Type": "application/json;charset=utf-8",
                    },
                    body: JSON.stringify(s),
                  }));
              if (i.ok) return i.json();
            }

            async ajaxGet(e) {
              let { url: t, data: s } = e,
                i = (c.hash, null);
              ((i = this.isValidUrl(t) ? new URL(t) : new URL(t, this.origin)),
                s &&
                  (i.search =
                    i.searchParams.toString() +
                    "&" +
                    new URLSearchParams(s).toString()));
              let a = await fetch(i);
              if (a.ok) return a.json();
            }

            async post(e) {
              let { url: t, data: s, json: i = !1 } = e,
                a =
                  (c.hash,
                  await fetch(t, {
                    method: "POST",
                    headers: {
                      "Content-Type":
                        "application/x-www-form-urlencoded;charset=UTF-8",
                    },
                    body: new URLSearchParams(s),
                  }));
              return a.ok && i ? a.json() : a.text();
            }

            async postBackGet(e) {
              let { phone: t } = e;
              if (window.location.search) {
                let e = new URLSearchParams(window.location.search);
                if (e.has("click_id")) {
                  let s = {
                    goal_id: 4478,
                    click_id: e.get("click_id"),
                    track_id: t || c.hash,
                  };
                  if (
                    (
                      await fetch(
                        `https://go.cpaex.ru/track/goal-by-click-id?${new URLSearchParams(s).toString()}`,
                      )
                    ).ok
                  )
                    return;
                }
              } else if (window.$queryString && $queryString.click_id) {
                let e = {
                  goal_id: 4478,
                  click_id: $queryString.click_id,
                  track_id: t || c.hash,
                };
                if (
                  (
                    await fetch(
                      `https://go.cpaex.ru/track/goal-by-click-id?${new URLSearchParams(e).toString()}`,
                    )
                  ).ok
                )
                  return;
              }
            }

            async sendSMS(e) {
              let { url: t, data: s } = e;
              if (
                (
                  await fetch(t, {
                    method: "POST",
                    headers: {
                      Accept: "application/json",
                      "Content-Type": "application/json",
                    },
                    body: JSON.stringify(s),
                  })
                ).ok
              )
                return { success: !0 };
            }

            queryObj() {
              if (window.location.search) {
                let e = new URLSearchParams(window.location.search),
                  t = {};
                return (e.forEach((e, s) => (t = { ...t, [s]: e })), t);
              }
              return null;
            }
          })(),
          U = s(171);
        var G = class {
            constructor(e, t) {
              ((this.el = e),
                (this.params = t),
                (this.$form = U(e).find("form")),
                (this.$name = U(e).find(".js-user-name")),
                (this.$addName = U(e).find(".js-user-add-name")),
                (this.$phone = U(e).find(".js-user-phone")),
                (this.$email = U(e).find(".js-user-email")),
                (this.$message = U(e).find(".js-user-message")),
                (this.$address = U(e).find(".js-user-address")),
                (this.$doc = U(e).find(".js-user-doc")),
                (this.$personDataCheckbox = U(e).find(".js-person-data")),
                (this.$agreementDataCheckbox = U(e).find(".js-agreement-data")),
                (this.$button = U(e).find("button")),
                (this.ctwType = this.$form.find('input[name="form"]').val()),
                (this.nameMask = ""),
                (this.addNameMask = ""),
                (this.phoneMask = ""),
                (this.emailMask = ""),
                (this.docMask = ""),
                (this.validation = ""),
                this.initMask(),
                this.$form.length &&
                  (this.initValidation(),
                  this.initValidationEvents(),
                  this.submitForm()));
            }

            getSelector(e) {
              return (" " + e.className).replace(/ /g, ".");
            }

            initMask() {
              let {
                $name: e,
                $addName: t,
                $phone: s,
                $email: i,
                $doc: a,
              } = this;
              if (
                (e.length &&
                  (this.nameMask = (0, N.ZP)(e[0], {
                    mask: /[А-Яа-яA-Za-z\s]$/,
                  })),
                t.length &&
                  (this.addNameMask = (0, N.ZP)(t[0], {
                    mask: /[А-Яа-яA-Za-z\s]$/,
                  })),
                s.length)
              ) {
                this.phoneMask = (0, N.ZP)(s[0], {
                  mask: "+{7}(000)000-00-00",
                  prepare: function (e, t) {
                    if (t.value.includes("+7") && "8" == t.value[3]) {
                      let e = t.value.replace("8", "");
                      t.value = e;
                    }
                    return e;
                  },
                });
              }
              if (
                (i.length &&
                  (this.emailMask = (0, N.ZP)(i[0], {
                    mask: function (e) {
                      return (
                        !!/^[a-z0-9_\.-]+$/.test(e) ||
                        !!/^[a-z0-9_\.-]+@$/.test(e) ||
                        !!/^[a-z0-9_\.-]+@[a-z0-9-]+$/.test(e) ||
                        !!/^[a-z0-9_\.-]+@[a-z0-9-]+\.$/.test(e) ||
                        !!/^[a-z0-9_\.-]+@[a-z0-9-]+\.[a-z]{1,4}$/.test(e) ||
                        !!/^[a-z0-9_\.-]+@[a-z0-9-]+\.[a-z]{1,4}\.$/.test(e) ||
                        !!/^[a-z0-9_\.-]+@[a-z0-9-]+\.[a-z]{1,4}\.[a-z]{1,4}$/.test(
                          e,
                        )
                      );
                    },
                  })),
                a.length)
              ) {
                this.docMask = (0, N.ZP)(a[0], { mask: "000000" });
              }
            }

            initValidation() {
              let {
                  $form: e,
                  $name: t,
                  $addName: s,
                  $phone: i,
                  $message: a,
                  $email: n,
                  $address: l,
                  $personDataCheckbox: o,
                  ctwType: r,
                  $doc: c,
                } = this,
                d =
                  (this.params?.onSuccess,
                  this.params?.onFail,
                  this.params?.tooltip);
              d && (d = { position: "top" });
              let m = (this.validation = new Z.ZP(e[0], {
                tooltip: d,
                errorLabelCssClass: "control__label-error",
              }));
              (!t.length ||
                ("mosquito" !== r && "vacancy" !== r) ||
                m.addField(t.getSelector(), [
                  {
                    rule: "required",
                    errorMessage: "Поле не заполнено!",
                  },
                  {
                    rule: "minLength",
                    value: 3,
                    errorMessage: "ФИО не может быть меньше 3 символов!",
                  },
                  {
                    rule: "maxLength",
                    value: 100,
                    errorMessage: "ФИО не может быть больше 100 символов!",
                  },
                ]),
                s.length &&
                  m.addField(s.getSelector(), [
                    {
                      rule: "required",
                      errorMessage: "Поле не заполнено!",
                    },
                    {
                      rule: "minLength",
                      value: 3,
                      errorMessage: "Имя не может быть меньше 3 символов!",
                    },
                    {
                      rule: "maxLength",
                      value: 30,
                      errorMessage: "Имя не может быть больше 30 символов!",
                    },
                  ]),
                i.length &&
                  m.addField(i.getSelector(), [
                    {
                      rule: "required",
                      errorMessage: "Поле не заполнено!",
                    },
                    {
                      rule: "minLength",
                      value: 16,
                      errorMessage: "Номер телефона не заполнен полностью!",
                    },
                  ]),
                n.length &&
                  m.addField(n.getSelector(), [
                    {
                      rule: "required",
                      errorMessage: "Поле не заполнено!",
                    },
                  ]),
                a.length &&
                  m.addField(a.getSelector(), [
                    {
                      rule: "maxLength",
                      value: 1e3,
                      errorMessage:
                        "Сообщение не может быть больше 1000 символов!",
                    },
                  ]),
                l.length &&
                  m.addField(l.getSelector(), [
                    {
                      rule: "required",
                      errorMessage: "Поле не заполнено!",
                    },
                  ]),
                o.length &&
                  o.each((e, t) => {
                    m.addField(U(t).getSelector(), [
                      {
                        rule: "required",
                        errorMessage: "Без согласия форма не будет отправлена",
                      },
                    ]);
                  }),
                c.length &&
                  m.addField(c.getSelector(), [
                    {
                      rule: "required",
                      errorMessage: "Поле не заполнено!",
                    },
                  ]),
                m.onFail((e) => {}),
                m.onSuccess((e) => {}));
            }

            clearField() {
              let {
                  $form: e,
                  $name: t,
                  $addName: s,
                  $phone: i,
                  $email: a,
                  $message: n,
                  $button: l,
                  nameMask: o,
                  addNameMask: r,
                  phoneMask: c,
                  emailMask: d,
                } = this,
                m = e.find("textarea");
              (t.length && (t.val(""), o.updateValue()),
                s.length && (s.val(""), r.updateValue()),
                i.length && (i.val(""), c.updateValue()),
                a.length && (a.val(""), d.updateValue()),
                n.length && m.val(""),
                l[0].disabled && l[0].removeAttribute("disabled"),
                (l[0].innerText = "Отправлено"));
            }

            ctwCreateRequest(e) {
              let { ctwType: t } = this;
              if (!t || "localhost" == R.hostname || isDev) return;
              let s = "",
                i = [];
              for (let [t, a] of Object.entries(e))
                (t.includes("name") &&
                  i.push({
                    name: t,
                    value: a,
                  }),
                  (t.includes("phone") || t.includes("tel")) &&
                    ((s = a.replace(/\D/g, "")),
                    i.push({
                      name: t,
                      value: s,
                    })),
                  (t.includes("comment") || t.includes("message")) &&
                    i.push({ name: t, value: a }));
              s &&
                i.length &&
                window.ctw.createRequest(t, s, i, function (e, t) {
                  e || t.type;
                });
            }

            initValidationEvents() {
              let {
                $name: e,
                $email: t,
                $phone: s,
                $message: i,
                validation: a,
              } = this;
              (e.on("change", (t) => {
                a.revalidateField(
                  e
                    .getSelector()
                    .replace(/\.just-validate-(success|error)-field/gi, ""),
                ).then((e) => {
                  a.isValid = e;
                });
              }),
                t.on("change", (e) => {
                  a.revalidateField(
                    t
                      .getSelector()
                      .replace(/\.just-validate-(success|error)-field/gi, ""),
                  ).then((e) => {
                    a.isValid = e;
                  });
                }),
                s.on("change", (e) => {
                  a.revalidateField(
                    s
                      .getSelector()
                      .replace(/\.just-validate-(success|error)-field/gi, ""),
                  ).then((e) => {
                    a.isValid = e;
                  });
                }),
                i.on("change", (e) => {
                  a.revalidateField(
                    i
                      .getSelector()
                      .replace(/\.just-validate-(success|error)-field/gi, ""),
                  ).then((e) => {
                    a.isValid = e;
                  });
                }));
            }

            submitForm() {
              let { $form: e, validation: t, $button: s, flEmail: i } = this,
                a = e.attr("action");
              e.on("submit", (i) => {
                i.preventDefault();
                let n = e.find("input"),
                  l = e.find("textarea"),
                  o = {};
                if (t.isValid && a) {
                  let e = this.params?.onSubmit,
                    i = this.params?.onSuccess,
                    r = this.params?.onFail;
                  (s[0].setAttribute("disabled", !0),
                    s[0].setAttribute("data-name", s[0].innerText),
                    (s[0].innerHTML =
                      '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>'),
                    n.each((e, t) => {
                      let s = U(t).attr("name"),
                        i = t.value;
                      ("checkbox" == U(t).attr("type") && (i = t.checked),
                        (o[s] = i));
                    }),
                    l.each((e, t) => {
                      let s = U(t).attr("name"),
                        i = t.value;
                      ("checkbox" == U(t).attr("type") && (i = t.checked),
                        (o[s] = i));
                    }),
                    (o.search = R.queryObj()),
                    ("vacancy" != o.form && "vacancy-piter" != o.form) ||
                      ((o["vacancy-name"] = window.$vacantion.name),
                      (o["vacancy-city"] = window.$vacantion.city)),
                    t.refresh(),
                    e
                      ? e({
                          onSuccess: i,
                          onFail: r,
                          data: o,
                          action: a,
                          form: this,
                        })
                      : R.ajaxPost({ url: a, data: o }).then((e) => {
                          e.success
                            ? (this.clearField(),
                              i && i(this),
                              (o.phone = o.phone ? o.phone : o["user-phone"]),
                              [
                                "director",
                                "partnership",
                                "tender",
                                "supplier",
                                "owner",
                                "service",
                                "vacancy",
                                "vacancy-piter",
                                "review",
                              ].includes(o.form) ||
                                (window.$flBanner &&
                                  window.$flBanner[0].insertAdjacentHTML(
                                    "afterbegin",
                                    `<div class="i-flocktory" data-fl-action="exchange" data-fl-user-email="${c.clearPhone(o.phone)}@unknown.email"></div>`,
                                  )),
                              isDev ||
                                (R.postBackGet({ phone: o.phone }),
                                "ct" == o.attribute &&
                                  "vacancy" != o.form &&
                                  this.ctwCreateRequest(o),
                                p(o)))
                            : (isDev && (window.$testForm = this),
                              s[0].removeAttribute("disabled"),
                              (s[0].innerText = s[0].dataset.name),
                              "FORM_ERROR_PHONE" === e.status &&
                                t.showErrors({
                                  [this.$phone.getSelector()]: e.data.message,
                                }),
                              "FORM_ERROR_NAME" === e.status &&
                                t.showErrors({
                                  [this.$name.getSelector()]: e.data.message,
                                }),
                              "FORM_ERROR_MESSAGE" === e.status &&
                                t.showErrors({
                                  [this.$message.getSelector()]: e.data.message,
                                }),
                              "FORM_ERROR_COOKIE" === e.status && r(this, e),
                              r && e && t.isValid && r(this, e));
                        }));
                }
              });
            }
          },
          H = s(171),
          Y = (e) => {
            let t = l.getComponent(".js-modal-win");
            H(e).each(
              (e, s) =>
                new G(s, {
                  tooltip: !0,
                  onSuccess(e) {
                    (t.close(), t.open("#modal-success-form"));
                  },
                  onFail(e, s) {
                    (t.close(),
                      t.open("#modal-error", (e) => {
                        if (s.data.message) {
                          e.openedWindow.querySelector(
                            ".modal-win__head-desc",
                          ).innerText = s.data.message;
                        }
                      }));
                  },
                }),
            );
          },
          J = (e) => {
            let t = l.getComponent(".js-modal-win");
            return new G(e, {
              tooltip: !0,
              onSuccess(e) {
                (t.close(), t.open("#modal-success-form"));
              },
              onFail(e, s) {
                (t.close(),
                  t.open("#modal-error", (e) => {
                    if (s.data.message) {
                      e.openedWindow.querySelector(
                        ".modal-win__head-desc",
                      ).innerText = s.data.message;
                    }
                  }));
              },
            });
          },
          X = (e) => {
            let t = l.getComponent(".js-modal-win");
            return new G(e, {
              tooltip: !0,
              onSuccess(e) {
                (t.close(), t.open("#modal-success-form"));
              },
              onFail(e, s) {
                (t.close(),
                  t.open("#modal-error", (e) => {
                    if (s.data.message) {
                      e.openedWindow.querySelector(
                        ".modal-win__head-desc",
                      ).innerText = s.data.message;
                    }
                  }));
              },
            });
          },
          K = (e) => {
            let t = l.getComponent(".js-modal-win");
            return new G(e, {
              tooltip: !1,
              onSuccess(e) {
                (t.close(), t.open("#modal-success-form"));
              },
              onFail(e, s) {
                (t.close(),
                  t.open("#modal-error", (e) => {
                    if (s.data.message) {
                      e.openedWindow.querySelector(
                        ".modal-win__head-desc",
                      ).innerText = s.data.message;
                    }
                  }));
              },
            });
          },
          Q = s(171),
          ee = (e) => {
            let t = Q(e).find(".js-coop-form--init"),
              s = l.getComponent(".js-modal-win");
            t.each(function (e, t) {
              return new G(t, {
                onSuccess(e) {
                  (s.close(), s.open("#modal-success-form"));
                },
                onFail(e, t) {
                  (s.close(),
                    s.open("#modal-error", (e) => {
                      if (t.data.message) {
                        e.openedWindow.querySelector(
                          ".modal-win__head-desc",
                        ).innerText = t.data.message;
                      }
                    }));
                },
              });
            });
          },
          te = (e) => {
            let t = l.getComponent(".js-modal-win");
            return new G(e, {
              tooltip: !0,
              onSuccess(e) {
                (t.close(), t.open("#modal-success-form"));
              },
              onFail(e, s) {
                (t.close(),
                  t.open("#modal-error", (e) => {
                    if (s.data.message) {
                      e.openedWindow.querySelector(
                        ".modal-win__head-desc",
                      ).innerText = s.data.message;
                    }
                  }));
              },
            });
          },
          se = (e) => {
            const t = l.getComponent(".js-modal-win");
            return new G(e, {
              tooltip: !0,
              onSuccess() {
                (t.close(), t.open("#modal-success-form"));
              },
              onFail(e, s) {
                (t.close(),
                  t.open("#modal-error", (e) => {
                    if (s.data.message) {
                      e.openedWindow.querySelector(
                        ".modal-win__head-desc",
                      ).innerText = s.data.message;
                    }
                  }));
              },
            });
          },
          ie = (e) => {
            let t = l.getComponent(".js-modal-win");
            return new G(e, {
              tooltip: !1,
              onSuccess(e) {
                (t.close(), t.open("#modal-success-form"));
              },
              onFail(e, s) {
                (t.close(),
                  t.open("#modal-error", (e) => {
                    if (s.data.message) {
                      e.openedWindow.querySelector(
                        ".modal-win__head-desc",
                      ).innerText = s.data.message;
                    }
                  }));
              },
            });
          },
          ae = s(171),
          ne = (e) => {
            let t = ae(e).find("form"),
              s = l.getComponent(".js-modal-win");
            (t.each(function (e, t) {
              return new G(t, {
                onSuccess(e) {
                  (s.close(), s.open("#modal-success-form"));
                },
                onFail(e, t) {
                  (s.close(),
                    s.open("#modal-error", (e) => {
                      if (t.data.message) {
                        e.openedWindow.querySelector(
                          ".modal-win__head-desc",
                        ).innerText = t.data.message;
                      }
                    }));
                },
              });
            }),
              (function (e) {
                const t = e.querySelector(".js-user-upload"),
                  s = e.querySelector(".js-upload-area"),
                  i = new ResizeObserver((e) => {
                    e.forEach((e) => {
                      const t = document.documentElement.clientWidth < 769;
                      e.target.innerHTML = t
                        ? "Загрузите файл с резюме<br/>(*.doc, *.pdf, *.docx)"
                        : "Перетащите или загрузите файл с резюме<br>(*.doc, *.pdf, *.docx)";
                    });
                  });
                (i.observe(s),
                  t.addEventListener("change", (e) => {
                    t.files.length &&
                      ((s.innerText = t.files[0].name), i.unobserve(s));
                  }),
                  ["dragleave", "dragend"].forEach((e) => {
                    s.addEventListener(e, (e) => {
                      s.classList.remove("vacancy-respond__upload-label--over");
                    });
                  }),
                  s.addEventListener("dragover", (e) => {
                    (e.preventDefault(),
                      s.classList.add("vacancy-respond__upload-label--over"));
                  }),
                  s.addEventListener("drop", (e) => {
                    (e.preventDefault(),
                      e.dataTransfer.files.length &&
                        ((t.files = e.dataTransfer.files),
                        (s.innerText = e.dataTransfer.files[0].name),
                        i.unobserve(s)),
                      s.classList.remove(
                        "vacancy-respond__upload-label--over",
                      ));
                  }));
              })(document.querySelector(e)));
          },
          le = s(171),
          oe = (e) => {
            let t = le(e);
            ((window.$vacantion = null),
              t.each(function (e, t) {
                t.addEventListener("click", (e) => {
                  window.$vacantion = {
                    city: e.target.dataset.city,
                    name: e.target.dataset.vacancy,
                  };
                });
              }));
          },
          re = s(171);

        class ce {
          constructor() {
            ((this.onOpen = ""),
              (this.onClose = ""),
              (this.modal = new d.Z({
                linkAttributeName: "data-modal-window",
                beforeOpen: () => {
                  if (re(".js-modal-gotovie-order").length) {
                    let e = re(".js-modal-gotovie-order");
                    "own" == window.$form.gotovie
                      ? (e
                          .find(".modal-gotovie-order-size--hidden")
                          .removeClass("modal-gotovie-order-size--hidden"),
                        (e.find(".modal-win__head-desc")[0].innerText =
                          "Введите размеры окна и наш менеджер подберет подходящий для Вас вариант."))
                      : "no" != window.$form.gotovie &&
                        (e.find(".modal-win__head-desc")[0].innerText =
                          "Наш менеджер уже проверяет наличие окна заданных размеров на складе и готов связаться с Вами для отправки.");
                  }
                  this.onOpen && this.onOpen(this.modal);
                },
                afterClose: () => {
                  if (
                    (this.onClose && this.onClose(this.modal),
                    this.onOpen && (this.onOpen = ""),
                    this.onClose && (this.onClose = ""),
                    re(".js-modal-gotovie-order").length)
                  ) {
                    let e = re(".js-modal-gotovie-order");
                    (e
                      .find(".modal-win__control--flex")
                      .addClass("modal-gotovie-order-size--hidden"),
                      (e.find(".modal-win__head-desc")[0].innerText =
                        "Сейчас наш менеджер свяжется с Вами для уточнения деталей."),
                      (window.$form.gotovie = "no"));
                  }
                },
              })));
          }

          open(e, t) {
            (t && (this.onOpen = t), this.modal.open(e));
          }

          close(e) {
            (e && (this.onClose = e), this.modal.close());
          }
        }

        var de = (e) => new ce(),
          me = s(171),
          ue = (e) => {
            let t = l.getComponent(".js-modal-win"),
              s = me(e);
            for (let e of s) {
              new G(e, {
                onSuccess(e) {
                  (t.close(), t.open("#modal-success-form", () => {}));
                },
                onFail(e, s) {
                  (t.close(),
                    t.open("#modal-error", (e) => {
                      if (s.data.message) {
                        e.openedWindow.querySelector(
                          ".modal-win__head-desc",
                        ).innerText = s.data.message;
                      }
                    }));
                },
              });
            }
          },
          pe = s(171),
          he = (e) => {
            let t = l.getComponent(".js-modal-win"),
              s = pe(e);
            for (let e of s) {
              new G(e, {
                onSuccess(e) {
                  (t.close(), t.open("#modal-success-form", () => {}));
                },
                onFail(e, s) {
                  (t.close(),
                    t.open("#modal-error", (e) => {
                      if (s.data.message) {
                        e.openedWindow.querySelector(
                          ".modal-win__head-desc",
                        ).innerText = s.data.message;
                      }
                    }));
                },
              });
            }
          },
          _e = s(171),
          ge = (e) => {
            let t = l.getComponent(".js-modal-win"),
              s = _e(e);
            for (let e of s) {
              new G(e, {
                onSuccess(e) {
                  (t.close(), t.open("#modal-success-form", () => {}));
                },
                onFail(e, s) {
                  (t.close(),
                    t.open("#modal-error", (e) => {
                      if (s.data.message) {
                        e.openedWindow.querySelector(
                          ".modal-win__head-desc",
                        ).innerText = s.data.message;
                      }
                    }));
                },
              });
            }
          },
          we = s(171),
          ve = (e) => {
            let t = l.getComponent(".js-modal-win"),
              s = we(e);
            for (let e of s) {
              new G(e, {
                onSuccess(e) {
                  (t.close(),
                    t.open("#modal-success-form", () => {
                      window.$vacantion = null;
                    }));
                },
                onFail(e, s) {
                  (t.close(),
                    t.open("#modal-error", (e) => {
                      if (s.data.message) {
                        e.openedWindow.querySelector(
                          ".modal-win__head-desc",
                        ).innerText = s.data.message;
                      }
                      window.$vacantion = null;
                    }));
                },
              });
            }
          },
          fe = s(486),
          ye = s.n(fe),
          be = s(171),
          ke = (e) => {
            const t = be(e),
              s = be(".education-info__row"),
              i = be(".js-education-form");
            let a = [];
            window.$edu = null;
            const n = (e) => {
              let n = "";
              ($edu.forEach((e, t) => {
                e.active &&
                  "online" != e.type &&
                  e.schedules.forEach((s) => {
                    let i = new Date().getTime(),
                      n = new Date(s.datetime).getTime();
                    n > i &&
                      s.seats > 0 &&
                      (ye().lang("ru"),
                      a.push({
                        item: t,
                        id: e.id,
                        title: e.title,
                        subtitle: e.subtitle,
                        subtitle_po: e.subtitle_po,
                        seats: s.seats,
                        date: {
                          day: ye()(s.datetime).day(),
                          month: ye()(s.datetime).format("%B"),
                          year: ye()(s.datetime).year(),
                          time: ye()(s.datetime).format("%H:%M"),
                          stamp: n,
                        },
                      }));
                  });
              }),
                a.sort(function (e, t) {
                  return e.date.stamp > t.date.stamp
                    ? 1
                    : e.date.stamp < t.date.stamp
                      ? -1
                      : 0;
                }),
                a.forEach(
                  (e) =>
                    (n += ((e) => {
                      let t = "";
                      return (
                        $edu[e.item].speakers.length &&
                          (t = $edu[e.item].speakers[0].name),
                        `\n\t\t<div class="simple-cards-list__item">\n\t\t\t<div class="simple-card js-education-info" data-seminar="${e.id}">\n\t\t\t\t<div class="simple-card__header">\n\t\t\t\t\t<div class="simple-card__header-title education-date">${e.date.day}<span>${e.date.month}</span></div>\n\t\t\t\t</div>\n\t\t\t\t<div class="simple-card__body">\n\t\t\t\t\t<div class="simple-card__title">${e.title}</div>\n\t\t\t\t\t<div class="simple-card__desc">${e.subtitle_po}</div>\n\t\t\t\t\t<div class="simple-card__desc">${t}</b></div>\n\t\t\t\t\t<div class="simple-card__desc">Свободные места: <b>${e.seats}</b></div>\n\t\t\t\t</div>\n\t\t\t\t<div class="simple-card__bottom">\n\t\t\t\t\t<button class="btn btn--black-invert" data-modal-window="#modal-education-info" aria-hidden="true">Подробности</button>\n\t\t\t\t\t<br><br>\n\t\t\t\t\t<button class="btn" data-modal-window="#modal-education-order" aria-hidden="true">Записаться</button>\n\t\t\t\t</div>\n\t\t\t\t<a class="simple-card__link" data-modal-window="#modal-education-info" href="#" aria-label="Подробности"></a>\n\t\t\t</div>\n\t\t</div>\n\t\t`
                      );
                    })(e)),
                ),
                (t[0].innerHTML = n),
                t.find(".simple-cards-list__item").each((e, t) => {
                  let n = a[e],
                    l = window.$edu[n.item];
                  t.querySelectorAll("[data-modal-window]").forEach((e) => {
                    e.addEventListener("click", (t) => {
                      if (
                        ((i.find("input[name=seminar]")[0].value =
                          `${n.title}. ${n.date.day} ${n.date.month} ${n.date.year}`),
                        "#modal-education-info" == e.dataset.modalWindow)
                      ) {
                        let e = `<div class="education-info__col">\n\t\t\t\t\t\t\t<h2>${n.title}</h2>\n\t\t\t\t\t\t\t\t<div class="education-info__cours-description">\n\t\t\t\t\t\t\t\t\t<h3 class="subtitle">${n.subtitle}</h3>\n\t\t\t\t\t\t\t\t\t<ul>`;
                        (l.description.forEach((t) => {
                          e += `<li>${t}</li>`;
                        }),
                          (e += `</ul>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t<div class="education-info__cours-couch">\n\t\t\t\t\t\t\t\t\t<div class="education-info__speakers-card">\n\t\t\t\t\t\t\t\t\t\t<img src="https://diler.plastika-okon.ru${l.speakers.length ? l.speakers[0].img : ""}" alt="" class="education-info__speakers-card-photo">\n\t\t\t\t\t\t\t\t\t\t<div class="education-info__speakers-card-name">${l.speakers.length ? l.speakers[0].name : ""}</div>\n\t\t\t\t\t\t\t\t\t\t<div class="education-info__speakers-card-desc">${l.speakers.length ? l.speakers[0].position : ""}</div>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t<div class="education-info__cours-data">\n\t\t\t\t\t\t\t\t\tДата проведения: <b>${n.date.day} ${n.date.month}</b><br>\n\t\t\t\t\t\t\t\t\tСвободные места: <b>${n.seats}</b>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>`),
                          (s[0].innerHTML = e));
                      }
                    });
                  });
                }));
            };
            R.ajaxGet({
              url: "https://diler.plastika-okon.ru/api/plastika/education/get",
            }).then((e) => {
              e && ((window.$edu = e), n());
            });
          },
          Ce = s(171),
          Se = (e) => {
            (Ce(e).find(".js-main-banner-input"),
              Ce(e).find(".js-checkbox-small"));
            let t = Ce(e).find(".js-button"),
              s = Ce(e).data("btn-type"),
              i = [].slice.call(Ce(e).find(".js-video"));
            Ce(e).data("title");
            let a = Ce(window).width(),
              n = l.getComponent(".js-modal-win");
            new G(e, {
              tooltip: !0,
              onSuccess(e) {
                (n.close(), n.open("#modal-success-form"));
              },
              onFail(e, t) {
                (n.close(),
                  n.open("#modal-error", (e) => {
                    if (t.data.message) {
                      e.openedWindow.querySelector(
                        ".modal-win__head-desc",
                      ).innerText = t.data.message;
                    }
                  }));
              },
            });
            if (
              (Ce(window).on("resize.plastic_win_banner", () => {
                ((a = Ce(window).width()),
                  c.actionFilter({
                    keyTimer: "resize_default_banner" + c.hash,
                    duration: 100,
                    action() {},
                  }));
              }),
              s && "black" == s && t.addClass("btn--black"),
              s && "white" == s && t.addClass("btn--white"),
              "IntersectionObserver" in window)
            ) {
              var o = new IntersectionObserver(function (e, t) {
                e.forEach(function (e) {
                  if (e.isIntersecting) {
                    for (var t in e.target.children) {
                      var s = e.target.children[t];
                      "string" == typeof s.tagName &&
                        "SOURCE" === s.tagName &&
                        (s.src = s.dataset.src);
                    }
                    (e.target.load(),
                      e.target.classList.remove("js-video"),
                      o.unobserve(e.target));
                  }
                });
              });
              i.forEach(function (e) {
                o.observe(e);
              });
            }
          },
          xe = s(378),
          Pe = s(171),
          je = (e) => {
            let t = Pe(e).find(".js-default-banner-input"),
              s = Pe(e).find(".js-checkbox-small"),
              i = Pe(e).find(".js-button"),
              a = Pe(e).data("mode"),
              n = Pe(e).data("btn-type");
            const o = document.querySelector(
                ".default-banner-actions__head-title",
              ),
              r = document.querySelector(
                ".default-banner-actions__wrapper-description",
              ),
              d = document.querySelector(".default-banner-actions__container"),
              m = document.querySelector(".default-banner-actions"),
              u = document.querySelector(".default-banner-diler"),
              p = document.querySelector(
                ".default-banner-diler__wrapper-description",
              ),
              h = Pe(e).data("title");
            let _ = new xe.Z(),
              g = Pe(e).data("img-src"),
              w = Pe(window).width(),
              v = l.getComponent(".js-modal-win");
            new G(e, {
              tooltip: !0,
              onSuccess(e) {
                (v.close(), v.open("#modal-success-form"));
              },
              onFail(e, t) {
                (v.close(),
                  v.open("#modal-error", (e) => {
                    if (t.data.message) {
                      e.openedWindow.querySelector(
                        ".modal-win__head-desc",
                      ).innerText = t.data.message;
                    }
                  }));
              },
            });

            function f() {
              g &&
                _.getColorAsync(g, {
                  algorithm: "simple",
                  left: 50,
                  top: 50,
                  step: 10,
                })
                  .then((l) => {
                    (a &&
                      ((l.isLight = "light" == a), (l.isDark = "dark" == a)),
                      l.isLight &&
                        (Pe(e).addClass("default-banner--light"),
                        t.addClass("control--black"),
                        s.addClass("checkbox-small--black")),
                      l.isDark &&
                        (Pe(e).addClass("default-banner--dark"),
                        t.addClass("control--white"),
                        s.addClass("checkbox-small--white")),
                      n && "black" == n && i.addClass("btn--black"),
                      n && "white" == n && i.addClass("btn--white"));
                  })
                  .catch((e) => {});
            }

            if (
              (f(),
              Pe(window).on("resize.plastic_win_banner", () => {
                ((w = Pe(window).width()),
                  c.actionFilter({
                    keyTimer: "resize_default_banner" + c.hash,
                    duration: 100,
                    action() {
                      f();
                    },
                  }));
              }),
              h &&
                !u &&
                ((window.onload = function () {
                  (w < 500
                    ? r.insertBefore(o, r.children[0]) && (o.innerHTML = h)
                    : d.insertBefore(o, d.children[0]) && (o.innerHTML = h),
                    r.classList.add("banner-wrapper-active"),
                    (m.style.marginBottom = r.clientHeight - 50 + "px"));
                }),
                Pe(window).on("resize.plastic_win_banner", () => {
                  (w < 500
                    ? r.insertBefore(o, r.children[0])
                    : d.insertBefore(o, d.children[0]),
                    (m.style.marginBottom = r.clientHeight - 50 + "px"));
                })),
              u)
            ) {
              let e = p.getBoundingClientRect(),
                t = u.getBoundingClientRect();
              ((u.style.marginBottom = e.bottom - t.bottom + 25 + "px"),
                Pe(window).on("resize.plastic_win_banner", () => {
                  let e = p.getBoundingClientRect(),
                    t = u.getBoundingClientRect();
                  u.style.marginBottom = e.bottom - t.bottom + 25 + "px";
                }));
            }
          },
          qe = s(171);

        class De {
          constructor(e) {
            ((this.el = e),
              (this.$sliderContainer = qe(e).find(".js-stock-banner-slider")),
              (this.$slides = qe(e).find(".js-stock-banner-slide")),
              (this.$pagination = qe(e).find(".js-stock-banner-pagination")),
              (this.$tabs = qe(e).find(".js-stock-banner-tab")),
              (this.slider = this.initSlider()),
              this.initEvents(),
              this.getAverageColor());
          }

          get windowWidth() {
            return qe(window).width();
          }

          initSlider() {
            let { $tabs: e, $sliderContainer: t, $pagination: s } = this;
            return new M.ZP(t[0], {
              modules: [M.W_, M.tl, M.pt],
              slidesPerView: 1,
              spaceBetween: 15,
              pagination: { el: s[0] },
              autoplay: { disableOnInteraction: !1, delay: 1e4 },
              on: {
                init: () => {
                  qe(this.el).removeClass("stock-banner--hidden");
                },
                slideChange() {
                  for (let t of e)
                    qe(t).data("slide-index") == this.activeIndex &&
                      qe(t).trigger("click.stock_banner");
                },
              },
            });
          }

          initEvents() {
            (this.clickTab(), this.resizeWindow());
          }

          resizeWindow() {
            let e = this;
            qe(window).on("resize.stock_banner", () => {
              c.actionFilter({
                keyTimer: "resize_stock_banner",
                duration: 100,
                action() {
                  e.getAverageColor();
                },
              });
            });
          }

          getAverageColor() {
            let { $slides: e } = this;
            for (let t of e) {
              (qe(t).data("img-src"),
                qe(t).data("img-mobile-src"),
                qe(t).data("mobile-color"));
              let e = qe(t).data("text-color"),
                s =
                  (qe(t).data("is-video"),
                  qe(t).find(".js-slide-title, .js-slide-desc"));
              e && s.css({ color: e });
            }
          }

          clickTab() {
            let e = this,
              { slider: t } = this;
            this.$tabs.on("click.stock_banner", function () {
              if (!qe(this).hasClass("active")) {
                let s = qe(this).data("slide-index");
                (t.activeIndex != s && t.slideTo(s),
                  e.$tabs.removeClass("active"),
                  qe(this).addClass("active"));
              }
            });
          }
        }

        var Le = (e) => new De(e),
          Me = s(171),
          $e = (e) => {
            let t = new xe.Z(),
              s = Me(e).data("img-src"),
              i = Me(window).width();

            function a() {
              t.getColorAsync(s, {
                algorithm: "simple",
                left: 50,
                top: 50,
                step: 10,
              })
                .then((t) => {
                  i < 500
                    ? Me(e).css({
                        backgroundImage: "",
                        backgroundColor: t.hexa,
                      })
                    : Me(e).css({
                        backgroundImage: `url('${s}')`,
                        backgroundColor: "",
                      });
                })
                .catch((e) => {});
            }

            (a(),
              Me(window).on("resize.plastic_win_banner", () => {
                ((i = Me(window).width()),
                  c.actionFilter({
                    keyTimer: "resize_plastic_win_banner",
                    duration: 100,
                    action() {
                      a();
                    },
                  }));
              }));
          },
          ze = (e) => {
            let t = l.getComponent(".js-modal-win");
            new G(e, {
              tooltip: !0,
              onSuccess(e) {
                (t.close(), t.open("#modal-success-form"));
              },
              onFail(e, s) {
                (t.close(),
                  t.open("#modal-error", (e) => {
                    if (s.data.message) {
                      e.openedWindow.querySelector(
                        ".modal-win__head-desc",
                      ).innerText = s.data.message;
                    }
                  }));
              },
            });
          },
          Ee = s(171),
          Fe = (e) => {
            let t = Ee(e),
              s = Ee(e).find(".icon-basket__count");
            setTimeout(() => {
              !(async function () {
                let e = R.hostname,
                  i = "/ajax/?controller=FullWindows&action=basket",
                  a = "/ajax/?controller=FullWindows&action=basket";
                R.ajaxGet({ url: "localhost" == e ? i : a }).then(
                  (e) => (
                    e?.success &&
                      e.data.length &&
                      (t[0].classList.add("active"),
                      (s[0].textContent = e.data.length)),
                    e
                  ),
                );
              })();
            }, 100);
          },
          Oe = s(125),
          Te = s(171),
          Be = (e) => {
            let t = null;
            const s = () => {
              !t &&
                Te(window).width() < 750 &&
                (t = (0, Oe.ZP)(".system-characters__pin", {
                  hideOnClick: !0,
                  trigger: "click",
                  arrow: !1,
                  offset: [0, -10],
                }));
            };
            (s(),
              Te(window).on("resize.system-characters", () => {
                Te(window).width() < 750 ? s() : (t = null);
              }));
          },
          Ie = s(171),
          We = (e) => {
            Ie(e).each((e, t) => {
              (0, Oe.ZP)(t, {
                hideOnClick: !0,
                trigger: "click",
                maxWidth: "200px",
              });
            });
          },
          Ae = s(171),
          Ve = (e) => {
            let t = Ae(e).find(".js-case-articles-slider"),
              s = Ae(e).find(".js-case-articles-prev"),
              i = Ae(e).find(".js-case-articles-next");
            new M.ZP(t[0], {
              modules: [M.W_, M.tl],
              spaceBetween: 20,
              slidesPerView: 4,
              breakpoints: {
                320: { slidesPerView: "auto", spaceBetween: 15 },
                500: { slidesPerView: 3, spaceBetween: 15 },
                768: { spaceBetween: 20, slidesPerView: 4 },
              },
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {
                  Ae(e).removeClass("case-articles--hidden");
                },
              },
            });

            function a() {
              Ae(e)
                .find(".js-case-articles-item")
                .each(function (e, t) {
                  let s = Ae(this).data("mobile-picture");
                  Ae(window).width() < 768
                    ? s &&
                      Ae(this)
                        .addClass("on-filter")
                        .css({
                          backgroundImage: `url('${s}')`,
                          color: "#ffffff",
                        })
                    : Ae(this)
                        .removeClass("on-filter")
                        .css({ backgroundImage: "", color: "" });
                });
            }

            (a(),
              Ae(window).on("resize", function () {
                c.actionFilter({
                  key: "resize_window__case_articles",
                  action() {
                    a();
                  },
                });
              }));
          },
          Ne = s(171),
          Ze = (e) => {
            let t = Ne(e).find(".main-about__wrap"),
              s = () => {
                if (t.length) {
                  Ne(window).width() < 767
                    ? (t[0].classList.add("main-about__wrap--mobile"),
                      Ne(t[0]).on("click.main-about", () => {
                        t[0].classList.remove("main-about__wrap--mobile");
                      }))
                    : (t[0].classList.contains("main-about__wrap--mobile") &&
                        t[0].classList.remove("main-about__wrap--mobile"),
                      Ne(t[0]).off("click.main-about"));
                }
              };
            (s(),
              Ne(window).on("resize.main-about", () => {
                c.actionFilter({
                  keyTimer: "main-about",
                  duration: 50,
                  action: s,
                });
              }));
          },
          Re = s(171);

        class De2 {
          constructor(e) {
            ((this.el = e),
              (this.$sliderContainer = qe(e).find(".js-stock-banner-slider-2")),
              (this.$slides = qe(e).find(".js-stock-banner-slide-2")),
              (this.$pagination = qe(e).find(".js-stock-banner-pagination-2")),
              (this.$tabs = qe(e).find(".js-stock-banner-tab-2")),
              (this.slider = this.initSlider()),
              this.initEvents(),
              this.getAverageColor());
          }

          get windowWidth() {
            return qe(window).width();
          }

          initSlider() {
            let { $tabs: e, $sliderContainer: t, $pagination: s } = this;
            return new M.ZP(t[0], {
              modules: [M.W_, M.tl, M.pt],
              slidesPerView: 1,
              spaceBetween: 15,
              pagination: { el: s[0] },
              autoplay: { disableOnInteraction: !1, delay: 1e4 },
              on: {
                init: () => {
                  qe(this.el).removeClass("stock-banner--hidden");
                },
                slideChange() {
                  for (let t of e)
                    qe(t).data("slide-index") == this.activeIndex &&
                      qe(t).trigger("click.stock_banner");
                },
              },
            });
          }

          initEvents() {
            (this.clickTab(), this.resizeWindow());
          }

          resizeWindow() {
            let e = this;
            qe(window).on("resize.stock_banner", () => {
              c.actionFilter({
                keyTimer: "resize_stock_banner",
                duration: 100,
                action() {
                  e.getAverageColor();
                },
              });
            });
          }

          getAverageColor() {
            let { $slides: e } = this;
            for (let t of e) {
              (qe(t).data("img-src"),
                qe(t).data("img-mobile-src"),
                qe(t).data("mobile-color"));
              let e = qe(t).data("text-color"),
                s =
                  (qe(t).data("is-video"),
                  qe(t).find(".js-slide-title, .js-slide-desc"));
              e && s.css({ color: e });
            }
          }

          clickTab() {
            let e = this,
              { slider: t } = this;
            this.$tabs.on("click.stock_banner", function () {
              if (!qe(this).hasClass("active")) {
                let s = qe(this).data("slide-index");
                (t.activeIndex != s && t.slideTo(s),
                  e.$tabs.removeClass("active"),
                  qe(this).addClass("active"));
              }
            });
          }
        }

        var Le2 = (e) => new De2(e),
          Me = s(171),
          $e = (e) => {
            let t = new xe.Z(),
              s = Me(e).data("img-src"),
              i = Me(window).width();

            function a() {
              t.getColorAsync(s, {
                algorithm: "simple",
                left: 50,
                top: 50,
                step: 10,
              })
                .then((t) => {
                  i < 500
                    ? Me(e).css({
                        backgroundImage: "",
                        backgroundColor: t.hexa,
                      })
                    : Me(e).css({
                        backgroundImage: `url('${s}')`,
                        backgroundColor: "",
                      });
                })
                .catch((e) => {});
            }

            (a(),
              Me(window).on("resize.plastic_win_banner", () => {
                ((i = Me(window).width()),
                  c.actionFilter({
                    keyTimer: "resize_plastic_win_banner",
                    duration: 100,
                    action() {
                      a();
                    },
                  }));
              }));
          },
          ze = (e) => {
            let t = l.getComponent(".js-modal-win");
            new G(e, {
              tooltip: !0,
              onSuccess(e) {
                (t.close(), t.open("#modal-success-form"));
              },
              onFail(e, s) {
                (t.close(),
                  t.open("#modal-error", (e) => {
                    if (s.data.message) {
                      e.openedWindow.querySelector(
                        ".modal-win__head-desc",
                      ).innerText = s.data.message;
                    }
                  }));
              },
            });
          },
          Ee = s(171),
          Fe = (e) => {
            let t = Ee(e),
              s = Ee(e).find(".icon-basket__count");
            setTimeout(() => {
              !(async function () {
                let e = R.hostname,
                  i = "/ajax/?controller=FullWindows&action=basket",
                  a = "/ajax/?controller=FullWindows&action=basket";
                R.ajaxGet({ url: "localhost" == e ? i : a }).then(
                  (e) => (
                    e?.success &&
                      e.data.length &&
                      (t[0].classList.add("active"),
                      (s[0].textContent = e.data.length)),
                    e
                  ),
                );
              })();
            }, 100);
          },
          Oe = s(125),
          Te = s(171),
          Be = (e) => {
            let t = null;
            const s = () => {
              !t &&
                Te(window).width() < 750 &&
                (t = (0, Oe.ZP)(".system-characters__pin", {
                  hideOnClick: !0,
                  trigger: "click",
                  arrow: !1,
                  offset: [0, -10],
                }));
            };
            (s(),
              Te(window).on("resize.system-characters", () => {
                Te(window).width() < 750 ? s() : (t = null);
              }));
          },
          Ie = s(171),
          We = (e) => {
            Ie(e).each((e, t) => {
              (0, Oe.ZP)(t, {
                hideOnClick: !0,
                trigger: "click",
                maxWidth: "200px",
              });
            });
          },
          Ae = s(171),
          Ve = (e) => {
            let t = Ae(e).find(".js-case-articles-slider"),
              s = Ae(e).find(".js-case-articles-prev"),
              i = Ae(e).find(".js-case-articles-next");
            new M.ZP(t[0], {
              modules: [M.W_, M.tl],
              spaceBetween: 20,
              slidesPerView: 4,
              breakpoints: {
                320: { slidesPerView: "auto", spaceBetween: 15 },
                500: { slidesPerView: 3, spaceBetween: 15 },
                768: { spaceBetween: 20, slidesPerView: 4 },
              },
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {
                  Ae(e).removeClass("case-articles--hidden");
                },
              },
            });

            function a() {
              Ae(e)
                .find(".js-case-articles-item")
                .each(function (e, t) {
                  let s = Ae(this).data("mobile-picture");
                  Ae(window).width() < 768
                    ? s &&
                      Ae(this)
                        .addClass("on-filter")
                        .css({
                          backgroundImage: `url('${s}')`,
                          color: "#ffffff",
                        })
                    : Ae(this)
                        .removeClass("on-filter")
                        .css({ backgroundImage: "", color: "" });
                });
            }

            (a(),
              Ae(window).on("resize", function () {
                c.actionFilter({
                  key: "resize_window__case_articles",
                  action() {
                    a();
                  },
                });
              }));
          },
          Ne = s(171),
          Ze = (e) => {
            let t = Ne(e).find(".main-about__wrap"),
              s = () => {
                if (t.length) {
                  Ne(window).width() < 767
                    ? (t[0].classList.add("main-about__wrap--mobile"),
                      Ne(t[0]).on("click.main-about", () => {
                        t[0].classList.remove("main-about__wrap--mobile");
                      }))
                    : (t[0].classList.contains("main-about__wrap--mobile") &&
                        t[0].classList.remove("main-about__wrap--mobile"),
                      Ne(t[0]).off("click.main-about"));
                }
              };
            (s(),
              Ne(window).on("resize.main-about", () => {
                c.actionFilter({
                  keyTimer: "main-about",
                  duration: 50,
                  action: s,
                });
              }));
          },
          Re = s(171);

        class Ue {
          constructor(e) {
            ((this.$el = e),
              (this.$tabs = Re(e).find(".js-win-prices-tab-item")),
              (this.$contents = Re(e).find(".js-win-prices-item")),
              (this.$sliderContainer = null),
              (this.tabSlider = this.initTabSlider()),
              this.initWinTypeSlider(),
              this.initEvent());
          }

          get winWidth() {
            return Re(window).width();
          }

          initEvent() {
            this.clickTab();
          }

          initTabSlider() {
            let { $el: e, winWidth: t } = this,
              s = Re(e).find(".js-win-prices-tab"),
              i = Re(e).find(".js-coop-form-tab");
            if (s.length) {
              return new M.ZP(s[0], {
                slidesPerView: 5,
                breakpoints: {
                  320: { slidesPerView: 2.2, spaceBetween: 10 },
                  600: { slidesPerView: 3.2, spaceBetween: 10 },
                  1024: { slidesPerView: 4.2, spaceBetween: 10 },
                  1200: { slidesPerView: 6 },
                },
                on: {
                  init() {
                    s.removeClass("win-prices-tab--hidden");
                  },
                },
              });
            }
            if (i.length) {
              return new M.ZP(i[0], {
                slidesPerView: 5,
                centerInsufficientSlides: !0,
                breakpoints: {
                  320: { slidesPerView: "auto", spaceBetween: 10 },
                  600: { slidesPerView: "auto", spaceBetween: 10 },
                  1024: { slidesPerView: 4.2, spaceBetween: 10 },
                  1200: { slidesPerView: 6 },
                },
                on: {
                  init() {
                    s.removeClass("coop-form-tab--hidden");
                  },
                },
              });
            }
          }

          initWinTypeSlider() {
            let { $contents: e } = this,
              t = e.find(".js-win-prices-type-slider");
            0 === t.length && (t = e.find(".js-win-prices-type-v2-slider"));
            let s = e.find(".js-glazing-prices-slider"),
              i = e.find(".js-glazing-prices-slider-new"),
              a = e.find(".js-price-typical-house-slider"),
              n = e.find(".js-win-prices-type-gotovie-slider");
            (t.length &&
              t.each(function (e, t) {
                let s = Re(this),
                  i = s.find(".js-arrow-prev"),
                  a = s.find(".js-arrow-next"),
                  n = new M.ZP(this, {
                    modules: [M.W_, M.tl, M.Gk],
                    mousewheel: { forceToAxis: !0, releaseOnEdges: !0 },
                    centerInsufficientSlides: !0,
                    breakpoints: {
                      320: { slidesPerView: 1, spaceBetween: 0 },
                      660: { slidesPerView: 2, spaceBetween: 0 },
                      1024: { slidesPerView: 3, spaceBetween: 0 },
                    },
                    navigation: { prevEl: i[0], nextEl: a[0] },
                    on: {
                      init() {
                        (s.hasClass("win-prices-type--hidden") &&
                          s.removeClass("win-prices-type--hidden"),
                          s.hasClass("win-prices-type-v2--hidden") &&
                            s.removeClass("win-prices-type-v2--hidden"));
                      },
                    },
                  });
                this.typeSlider = n;
              }),
              n.length &&
                n.each(function (e, t) {
                  let s = Re(this),
                    i = s.closest(".js-win-prices-type").find(".js-arrow-prev"),
                    a = s.closest(".js-win-prices-type").find(".js-arrow-next"),
                    n = s.find(".win-prices-type__content");
                  ((window.$form = { gotovie: "no" }),
                    n.each((e, t) => {
                      let s = Re(t).find(".win-prices-type__button");
                      t.id.includes("none")
                        ? s.on("click.gotovie__btn", function (e) {
                            window.$form = { gotovie: "own" };
                          })
                        : s.on("click.gotovie__btn", function (e) {
                            window.$form = { gotovie: "buy" };
                          });
                    }));
                  let l = new M.ZP(this, {
                    modules: [M.W_, M.Gk],
                    mousewheel: { forceToAxis: !0, releaseOnEdges: !0 },
                    centerInsufficientSlides: !0,
                    breakpoints: {
                      320: { slidesPerView: 1, spaceBetween: 40 },
                      576: { slidesPerView: 2, spaceBetween: 20 },
                      1024: { slidesPerView: 3, spaceBetween: 20 },
                      1400: { slidesPerView: 4, spaceBetween: 20 },
                    },
                    navigation: { prevEl: i[0], nextEl: a[0] },
                    on: {
                      init() {
                        s.removeClass("win-prices-type--hidden");
                      },
                    },
                  });
                  this.typeSlider = l;
                }),
              s.length &&
                s.each(function (e, t) {
                  let s = Re(this),
                    i = s.closest(".js-win-prices-type").find(".js-arrow-prev"),
                    a = s.closest(".js-win-prices-type").find(".js-arrow-next"),
                    n = new M.ZP(this, {
                      modules: [M.W_, M.Gk],
                      mousewheel: { forceToAxis: !0, releaseOnEdges: !0 },
                      centerInsufficientSlides: !0,
                      breakpoints: {
                        320: { slidesPerView: 1, spaceBetween: 40 },
                        500: { slidesPerView: 2, spaceBetween: 20 },
                        1024: { slidesPerView: 3, spaceBetween: 20 },
                      },
                      navigation: { prevEl: i[0], nextEl: a[0] },
                      on: {
                        init() {
                          s.removeClass("glazing-prices-type--hidden");
                        },
                      },
                    });
                  this.typeSlider = n;
                }),
              i.length &&
                i.each(function (e, t) {
                  let s = Re(this),
                    i = s.closest(".js-win-prices-type").find(".js-arrow-prev"),
                    a = s.closest(".js-win-prices-type").find(".js-arrow-next"),
                    n = new M.ZP(this, {
                      modules: [M.W_, M.Gk],
                      mousewheel: { forceToAxis: !0, releaseOnEdges: !0 },
                      centerInsufficientSlides: !0,
                      breakpoints: {
                        540: { slidesPerView: 1, spaceBetween: 20 },
                        1024: { slidesPerView: 2, spaceBetween: 20 },
                      },
                      navigation: { prevEl: i[0], nextEl: a[0] },
                      on: {
                        init() {
                          s.removeClass("glazing-prices-type--hidden");
                        },
                      },
                    });
                  this.typeSlider = n;
                }),
              a.length &&
                a.each(function (e, t) {
                  let s = Re(this),
                    i = new M.ZP(s[0], {
                      modules: [M.Gk],
                      mousewheel: { forceToAxis: !0, releaseOnEdges: !0 },
                      spaceBetween: 20,
                      slidesPerView: "auto",
                    });
                  this.typeSlider = i;
                }));
          }

          clickTab() {
            let e = this,
              { $tabs: t } = this;
            t.on("click.win_price", function () {
              let s = Re(this).hasClass("active"),
                i = Re(this).data("tab-index");
              s ||
                (t.removeClass("active"),
                Re(this).addClass("active"),
                e.setContent(i));
            });
          }

          setContent(e) {
            let { $contents: t } = this;
            t.removeClass("active");
            for (let s of t) {
              if (e == Re(s).data("tab-index")) {
                let e = Re(s).find(".js-win-prices-type-slider");
                if (
                  (0 === e.length &&
                    (e = Re(s).find(".js-win-prices-type-v2-slider")),
                  Re(s).addClass("active"),
                  e.length)
                ) {
                  e[0].typeSlider.updateSize();
                }
                break;
              }
            }
          }
        }

        var Ge = (e) => new Ue(e),
          He = s(36),
          Ye = s.n(He),
          Je = s(171),
          Xe = (e) => {
            let t = Je(e).find(".js-certif-slider"),
              s = Je(e).find(".js-certif-scrollbar"),
              i = Je(e).find(".js-arrow-left"),
              a = Je(e).find(".js-arrow-right");
            new M.ZP(t[0], {
              modules: [M.LW, M.W_, M.pt, M.Gk],
              spaceBetween: 20,
              slidesPerView: "auto",
              mousewheel: { forceToAxis: !0, releaseOnEdges: !0 },
              autoplay: { disableOnInteraction: !1, delay: 5e3 },
              scrollbar: { el: s[0], draggable: !0 },
              navigation: { prevEl: i[0], nextEl: a[0] },
              on: {
                init: () => {
                  Je(e).removeClass("certif-slider--hidden");
                },
              },
            });
            new d.Z({
              linkAttributeName: "data-certif-modal",
              beforeOpen: function (e) {
                let t = e.openedWindow,
                  s = Je(t).find("img");
                new (Ye())(s);
              },
              afterClose: function (e) {},
            });
          },
          Ke = (e) => {
            new M.tq(`${e}`, {
              modules: [M.W_, M.tl],
              slidesPerView: 1,
              navigation: {
                prevEl: ".arrow-box--left",
                nextEl: ".arrow-box--right",
              },
              pagination: {
                el: ".certif-slider__window-pag",
                type: "bullets",
                clickable: !0,
              },
            });
          },
          Qe = s(171),
          et = (e) => {
            Qe(e)
              .find(".js-faq-quest-btn")
              .on("click.faq_quest", function () {
                let e = Qe(this).closest(".js-faq-quest-item"),
                  t = e.find(".js-faq-quest-answer");
                e.hasClass("answer-open")
                  ? (e.removeClass("answer-open"),
                    C.slideUp({
                      el: t[0],
                      duration: 0,
                    }))
                  : (e.addClass("answer-open"),
                    C.slideDown({
                      el: t[0],
                      duration: 150,
                      maxHeight: "",
                      onStop(e) {
                        Qe(e).css({ height: "" });
                      },
                    }));
              });
          },
          tt = s(171),
          st = (e) => {
            let t = tt(e).find(".js-news-company-slider"),
              s = tt(e).find(".js-arrow-left"),
              i = tt(e).find(".js-arrow-right");
            new M.ZP(t[0], {
              modules: [M.W_],
              spaceBetween: 20,
              slidesPerView: "auto",
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {
                  tt(e).removeClass("news-company--hidden");
                },
              },
            });
          },
          it = s(171),
          at = (e) => {
            let t = it(e).find(".js-advan-plastic-win-slider"),
              s = it(e).find(".js-arrow-prev"),
              i = it(e).find(".js-arrow-next");
            new M.ZP(t[0], {
              modules: [M.W_],
              loop: !0,
              spaceBetween: 20,
              slidesPerView: 3,
              breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 40 },
                768: { spaceBetween: 20, slidesPerView: 2 },
                1024: { spaceBetween: 20, slidesPerView: 3 },
              },
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {
                  it(e).removeClass("advan-plastic-win--hidden");
                },
                slideChange() {
                  let { activeIndex: e, slides: t } = this,
                    s = it(window).width();
                  for (let [i, a] of Object.entries(t))
                    ((i = Number(i)),
                      e + 1 == i
                        ? s >= 1024 && it(a).addClass("active")
                        : it(a).removeClass("active"));
                },
              },
            });
          },
          nt = s(171),
          lt = (e) => {
            let t = nt(e).find(".js-win-access-slider"),
              s = nt(e).find(".js-arrow-prev"),
              i = nt(e).find(".js-arrow-next");
            new M.ZP(t[0], {
              modules: [M.W_],
              loop: !0,
              spaceBetween: 10,
              slidesPerView: 4,
              breakpoints: {
                320: { slidesPerView: 1 },
                600: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
              },
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {
                  nt(e).removeClass("win-access--hidden");
                },
              },
            });
          },
          ot = s(171);

        class rt {
          constructor(e) {
            ((this.el = e),
              (this.slider = ""),
              (this.$recommends = ot(e).find(".js-present-recommend")),
              this.initSlider());
          }

          initSlider() {
            let e = this,
              { el: t } = this,
              s = ot(t).find(".js-price-present-slider"),
              i = ot(t).find(".js-arrow-left"),
              a = ot(t).find(".js-arrow-right");
            this.slider = new M.ZP(s[0], {
              modules: [M.W_],
              spaceBetween: 20,
              slidesPerView: 1,
              navigation: { prevEl: i[0], nextEl: a[0] },
              on: {
                init: () => {
                  ot(t).removeClass("price-present--hidden");
                },
                slideChange() {
                  let { activeIndex: t } = this;
                  e.setRecommend(t);
                },
              },
            });
          }

          setRecommend(e) {
            let { $recommends: t } = this;
            for (let s of t) {
              ot(s).data("slide-index") == e
                ? ot(s).addClass("active")
                : ot(s).removeClass("active");
            }
          }
        }

        var ct = (e) => new rt(e),
          dt = s(171),
          mt = (e) => {
            let t = dt(e).find(".js-decor-design-slider"),
              s = dt(e).find(".js-arrow-left"),
              i = dt(e).find(".js-arrow-right"),
              a = "",
              n = () => {
                dt(window).width() < 600
                  ? a ||
                    (a = new M.ZP(t[0], {
                      modules: [M.W_],
                      init: !0,
                      spaceBetween: 20,
                      slidesPerView: 1,
                      navigation: { prevEl: s[0], nextEl: i[0] },
                      on: {
                        init: () => {},
                      },
                    }))
                  : (a && a.destroy(), (a = ""));
              };
            (n(),
              dt(window).on("resize.decor_design", () => {
                c.actionFilter({
                  keyTimer: "resize_decor_design",
                  duration: 100,
                  action: () => {
                    n();
                  },
                });
              }));
          },
          ut = s(171),
          pt = (e) => {
            let t = ut(e).find(".js-ready-made-win-slider"),
              s = ut(e).find(".js-arrow-left"),
              i = ut(e).find(".js-arrow-right");
            new M.ZP(t[0], {
              modules: [M.W_],
              spaceBetween: 20,
              slidesPerView: 3,
              breakpoints: {
                320: { spaceBetween: 20, slidesPerView: 1 },
                768: { spaceBetween: 20, slidesPerView: 2 },
                1024: { spaceBetween: 20, slidesPerView: 3 },
              },
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {
                  ut(e).removeClass("ready-made-win--hidden");
                },
              },
            });
          },
          ht = s(171),
          _t = (e) => {
            let t = ht(e);
            t.each((e, s) => {
              let i = ht(s).find(".js-advan-info-triple-slider");
              new M.ZP(i[0], {
                modules: [M.Gk, M.W_],
                mousewheel: { forceToAxis: !0, releaseOnEdges: !0 },
                navigation: {
                  nextEl: ".arrow-box--right",
                  prevEl: ".arrow-box--left",
                },
                spaceBetween: 30,
                slidesPerView: 3,
                breakpoints: {
                  320: { spaceBetween: 20, slidesPerView: 1 },
                  576: { spaceBetween: 20, slidesPerView: 1.5 },
                  768: { spaceBetween: 20, slidesPerView: 2.3 },
                  991: { spaceBetween: 30, slidesPerView: 2.55 },
                  1200: { spaceBetween: 30, slidesPerView: 3 },
                },
                on: {
                  init: () => {
                    ht(t[e]).removeClass("advan-info-triple--hidden");
                  },
                },
              });
            });
          },
          gt = s(171),
          wt = (e) => {
            let t = gt(e).find(".js-card-line-swiper"),
              s = gt(e).find(".js-arrow-left"),
              i = gt(e).find(".js-arrow-right");
            new M.ZP(t[0], {
              modules: [M.W_, M.pt, M.Gk],
              spaceBetween: 24,
              slidesPerView: "auto",
              autoHeight: !0,
              mousewheel: { forceToAxis: !0, releaseOnEdges: !0 },
              autoplay: { disableOnInteraction: !1, delay: 5e3 },
              breakpoints: { 1280: { autoplay: !1 } },
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {
                  gt(e).removeClass("card-line-swiper--hidden");
                },
              },
            });
          },
          vt = s(171),
          ft = (e) => {
            let t = vt(e).find(".js-feature-masonry-slider");
            const s = vt("[data-feature]"),
              i = new Array();
            for (let e = 0; e < s.length; e++)
              i.push(`<div class="swiper-slide">${s[e].innerHTML}</div>`);
            let a = "",
              n = () => {
                vt(window).width() < 767
                  ? a ||
                    ((a = new M.ZP(t[0], {
                      modules: [M.bi],
                      slidesPerView: 1.2,
                      spaceBetween: 10,
                      breakpoints: {
                        480: { slidesPerView: 2.2, spaceBetween: 10 },
                      },
                      on: {
                        init: () => {
                          vt(e)
                            .find(".feature-masonry__cards")
                            .addClass("feature-masonry__cards--hidden");
                        },
                      },
                    })),
                    a.appendSlide(i))
                  : "string" != typeof a &&
                    (a.removeAllSlides(),
                    a.destroy(),
                    vt(e)
                      .find(".feature-masonry__cards")
                      .removeClass("feature-masonry__cards--hidden"),
                    (a = ""));
              };
            (n(),
              vt(window).on("resize.decor_design", () => {
                c.actionFilter({
                  keyTimer: "resize_decor_design",
                  duration: 100,
                  action: () => {
                    n();
                  },
                });
              }));
          },
          yt = s(171),
          bt = (e) => {
            const t = yt(e),
              s = yt(e).find(".js-arrow-prev"),
              i = yt(e).find(".js-arrow-next");
            new M.ZP(t[0], {
              modules: [M.W_],
              slidesPerView: 1,
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {},
              },
            });
          },
          kt = (e) => {
            const t = document
              .querySelector(e)
              .querySelector(".js-two-column-and-slider--swiper");
            t &&
              new M.ZP(t, {
                modules: [M.pt, M.xW],
                slidesPerView: 1,
                spaceBetween: 0,
                centeredSlides: !0,
                autoplay: { delay: 5e3 },
                effect: "fade",
              });
          },
          Ct = s(171);

        class St {
          constructor(e) {
            ((this.el = e),
              (this.$slider = Ct(e).find(".js-advan-win-system-slider")),
              (this.$images = Ct(e).find(".js-advan-system-image")),
              (this.$sliderItems = Ct(e).find(".js-advan-win-system-item")),
              (this.slider = ""),
              this.initSlider(),
              this.clickSlide());
          }

          get winWidth() {
            return Ct(window).width();
          }

          initSlider() {
            let e = this,
              { $slider: t, el: s } = this;
            this.slider = new M.ZP(t[0], {
              spaceBetween: 20,
              slidesPerView: 4,
              breakpoints: {
                320: { spaceBetween: 20, slidesPerView: 1 },
                500: { spaceBetween: 20, slidesPerView: 2 },
                768: { spaceBetween: 20, slidesPerView: 3 },
                1024: { spaceBetween: 20, slidesPerView: 4 },
              },
              on: {
                init: () => {
                  Ct(s).removeClass("advan-win-system--hidden");
                },
                slideChange() {
                  let { activeIndex: t } = this;
                  e.setActive(t);
                },
              },
            });
          }

          setActive(e) {
            let { $images: t, $sliderItems: s } = this,
              i = (t) => {
                for (let s of t) {
                  Ct(s).data("slide-index") == e
                    ? Ct(s).addClass("active")
                    : Ct(s).removeClass("active");
                }
              };
            (i(t), i(s));
          }

          clickSlide() {
            let e = this,
              { $sliderItems: t } = this;
            t.on("click.advan_win_system", function () {
              let t = Ct(this).data("slide-index");
              e.winWidth >= 500 && e.setActive(t);
            });
          }
        }

        var xt = (e) => new St(e),
          Pt = s(171),
          jt = (e) => {
            let t = (t) => {
              Pt(e)
                .find("iframe")[0]
                .contentWindow.postMessage(
                  JSON.stringify({ event: "command", func: t }),
                  "*",
                );
            };
            new d.Z({
              linkAttributeName: "data-video-modal",
              beforeOpen: function (e) {
                t("playVideo");
              },
              afterClose: function (e) {
                t("pauseVideo");
              },
            });
          },
          qt = s(171),
          Dt = (e) => {
            let t = qt(e).find(".js-price-option-slider");
            new M.ZP(t[0], {
              slidesPerView: "auto",
              breakpoints: {
                320: { slidesPerView: 2 },
                500: { slidesPerView: "auto" },
              },
              on: {
                init: () => {
                  qt(e).removeClass("price-option--hidden");
                },
              },
            });
          },
          Lt = (e) => {
            document.querySelectorAll(".reviews-list__item").forEach((e) => {
              const t = e.querySelector(".reviews-list__item-more"),
                s = e.querySelector(".reviews-list__item-body");
              t.addEventListener("click", (e) => {
                (e.preventDefault(),
                  s.classList.toggle("visible"),
                  "Подробнее" !== t.textContent
                    ? (t.textContent = "Скрыть")
                    : (t.textContent = "Подробнее"));
              });
            });
          },
          Mt = s(171),
          $t = (e) => {
            let t = Mt(e).find(".js-advan-doors-slider"),
              s = "",
              i = () => {
                Mt(window).width() < 1024
                  ? s ||
                    (s = new M.ZP(t[0], {
                      spaceBetween: 20,
                      slidesPerView: "auto",
                    }))
                  : s && (s.destroy(), (s = ""));
              };
            (i(),
              Mt(window).on("resize.advan-doors-slider", () => {
                c.actionFilter({
                  keyTimer: "resize_advan-doors-slider",
                  duration: 100,
                  action: i,
                });
              }));
          },
          zt = s(171),
          Et = (e) => {
            let t = zt(e).find(".js-front-doors-vars-slider");
            new M.ZP(t[0], {
              slidesPerView: "auto",
              spaceBetween: 60,
              centerInsufficientSlides: "true",
              on: {
                init: () => {
                  zt(e).removeClass("front-doors-vars--hidden");
                },
              },
            });
          },
          Ft = s(171),
          Ot = (e) => {
            let t = Ft(e).find(".js-doors-price-slider"),
              s = Ft(e).find(".js-arrow-prev"),
              i = Ft(e).find(".js-arrow-next");
            new M.ZP(t[0], {
              modules: [M.W_],
              loop: !0,
              spaceBetween: 20,
              slidesPerView: 1,
              breakpoints: { 600: { spaceBetween: 20, slidesPerView: 2 } },
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {
                  Ft(e).removeClass("doors-price--hidden");
                },
              },
            });
          },
          Tt = s(171),
          Bt = (e) => {
            let t = Tt(e).find(".js-turnkey-balcony-slider");
            new M.ZP(t[0], {
              spaceBetween: 20,
              slidesPerView: "auto",
              on: {
                init: () => {
                  Tt(e).removeClass("turnkey-balcony--hidden");
                },
              },
            });
          },
          It = s(171),
          Wt = (e) => {
            let t = It(e).find(".js-price-typical-house-slider");
            new M.ZP(t[0], {
              spaceBetween: 20,
              slidesPerView: "auto",
              on: {
                init: () => {
                  It(e).removeClass("price-typical-house--hidden");
                },
              },
            });
          },
          At = s(171),
          Vt = (e) => {
            let t = At(e).find(".js-six-steps-slider"),
              s = "",
              i = () => {
                s ||
                  (s = new M.ZP(t[0], {
                    spaceBetween: 20,
                    slidesPerView: "auto",
                    breakpoints: { 1200: { slidesPerView: 6 } },
                  }));
              };
            (i(),
              At(window).on("resize.six_steps_slider", () => {
                c.actionFilter({
                  keyTimer: "resize_six_steps_slider",
                  duration: 100,
                  action: i,
                });
              }));
          },
          Nt = s(171),
          Zt = (e) => {
            let t = Nt(e).find(".js-how-it-work-cashback-slider"),
              s = Nt(e).find(
                ".js-include-area-how-it-work-cashback__container",
              ),
              i = "",
              a = () => {
                let e = Nt(window).width();
                (e < 1024
                  ? i || (i = new M.ZP(t[0], { slidesPerView: "auto" }))
                  : i && (i.destroy(), (i = "")),
                  e < 650
                    ? s.css({ marginTop: "41px" })
                    : s.css({ marginTop: "77px" }));
              };
            (a(),
              Nt(window).on("resize.how-it-work-cashback_slider", () => {
                c.actionFilter({
                  keyTimer: "resize_how-it-work-cashback_slider",
                  duration: 100,
                  action: a,
                });
              }));
          },
          Rt = s(171),
          Ut = (e) => {
            let t = Rt(e).find(".js-doors-advan-slider");
            new M.ZP(t[0], {
              spaceBetween: 20,
              slidesPerView: "auto",
              centerInsufficientSlides: "true",
              breakpoints: { 1024: { slidesPerView: 4 } },
              on: {
                init: () => {
                  Rt(e).removeClass("doors-advan--hidden");
                },
              },
            });
          },
          Gt = s(171),
          Ht = (e) => {
            let t = Gt(e).find(".js-sliding-doors-types-slider"),
              s = Gt(e).find(".js-arrow-prev"),
              i = Gt(e).find(".js-arrow-next");
            new M.ZP(t[0], {
              modules: [M.W_],
              spaceBetween: 20,
              slidesPerView: 1,
              breakpoints: { 600: { slidesPerView: 2 } },
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {
                  Gt(e).removeClass("sliding-doors-types--hidden");
                },
              },
            });
          },
          Yt = s(171),
          Jt = (e) => {
            let t = Yt(e).find(".js-balcony-doors-parts-slider"),
              s = "",
              i = () => {
                Yt(window).width() < 1024
                  ? s ||
                    (s = new M.ZP(t[0], {
                      spaceBetween: 20,
                      slidesPerView: "auto",
                    }))
                  : s && (s.destroy(), (s = ""));
              };
            (i(),
              Yt(window).on("resize.balcony-doors-parts-slider", () => {
                c.actionFilter({
                  keyTimer: "resize_balcony-doors-parts-slider",
                  duration: 100,
                  action: i,
                });
              }));
          },
          Xt = s(171),
          Kt = (e) => {
            let t = Xt(e).find(".js-balcony-glazing-vars-slider");
            new M.ZP(t[0], {
              slidesPerView: "auto",
              spaceBetween: 20,
              centerInsufficientSlides: "true",
              on: {
                init: () => {
                  Xt(e).removeClass("balcony-glazing-vars--hidden");
                },
              },
            });
          },
          Qt = s(171),
          es = (e) => {
            let t = Qt(e).find(".js-price-french-glazing-slider");
            new M.ZP(t[0], {
              slidesPerView: "auto",
              spaceBetween: 20,
              on: {
                init() {
                  Qt(e).removeClass("price-french-glazing--hidden");
                },
              },
            });
          },
          ts = s(171),
          ss = (e) => {
            let t = ts(e).find(".js-company-about-slider");
            new M.ZP(t[0], {
              slidesPerView: "auto",
              spaceBetween: 20,
              centerInsufficientSlides: "true",
              on: {
                init: () => {
                  ts(e).removeClass("company-about--hidden");
                },
              },
            });
          },
          is = s(171),
          as = (e) => {
            let t = is(e).find(".js-own-production-slider"),
              s = "",
              i = () => {
                is(window).width() < 1024
                  ? s ||
                    (s = new M.ZP(t[0], {
                      spaceBetween: 20,
                      slidesPerView: "auto",
                    }))
                  : s && (s.destroy(), (s = ""));
              };
            (i(),
              is(window).on("resize.own-production-slider", () => {
                c.actionFilter({
                  keyTimer: "resize_own-production-slider",
                  duration: 100,
                  action: i,
                });
              }));
          },
          ns = s(171),
          ls = (e) => {
            let t = ns(e).find(".js-dealer-warranties-slider");
            new M.ZP(t[0], {
              slidesPerView: "auto",
              spaceBetween: 20,
              centerInsufficientSlides: "true",
              on: {
                init: () => {
                  ns(e).removeClass("dealer-warranties--hidden");
                },
              },
            });
          },
          os = (e) => {
            const t = document
              .querySelector(e)
              .querySelector(".js-our-advantages--swiper");
            t &&
              new M.ZP(t, {
                slidesPerView: "auto",
                spaceBetween: 20,
                breakpoints: { 1e3: { slidesPerView: 6 } },
              });
          },
          rs = (e) => {
            const t = document
              .querySelector(e)
              .querySelector(".js-three-column-block--swiper");
            t &&
              new M.ZP(t, {
                slidesPerView: "auto",
                spaceBetween: 20,
                centerInsufficientSlides: "true",
                breakpoints: { 1e3: { slidesPerView: 3 } },
              });
          },
          cs = (e) => {
            const t = document
              .querySelector(e)
              .querySelector(".js-slider-window-tiles--swiper");
            t &&
              new M.ZP(t, {
                slidesPerView: "auto",
                spaceBetween: 20,
                centerInsufficientSlides: "true",
              });
          },
          ds = (e) => {
            const t = document.querySelectorAll(e);
            for (let e of t) {
              let t = document.createElement("div"),
                s = document.createElement("div"),
                i = document.createElement("datalist"),
                a = document.createElement("span"),
                n = e.options,
                l = e.parentElement,
                o = e.hasAttribute("multiple"),
                r = document.createElement("div");
              const c = function (t) {
                  this.hasAttribute("data-disabled");
                  ((e.value = this.dataset.value),
                    (a.innerText = this.dataset.label));
                },
                d = function (e) {
                  (e.preventDefault(),
                    e.stopPropagation(),
                    13 === e.keyCode && this.click());
                };
              (t.classList.add("js-select"),
                s.classList.add("header-select"),
                a.classList.add("span-label"),
                r.classList.add("select-arrow"),
                (r.textContent = "↓"),
                (t.tabIndex = 1),
                (e.tabIndex = -1),
                (a.innerText = e.label),
                s.appendChild(a),
                s.appendChild(r));
              for (let s of e.attributes)
                s.name.includes("data-") || (t.dataset[s.name] = s.value);
              for (let e = 0; e < n.length; e++) {
                const t = document.createElement("div"),
                  s = document.createElement("div"),
                  a = n[e];
                for (let e of a.attributes) t.dataset[e.name] = e.value;
                (t.classList.add("option"),
                  s.classList.add("label"),
                  (s.innerText = a.label),
                  (t.dataset.value = a.value),
                  (t.dataset.label = a.label),
                  (t.onclick = c),
                  (t.onkeyup = d),
                  (t.tabIndex = e + 1),
                  t.appendChild(s),
                  i.appendChild(t));
              }
              (t.appendChild(s),
                (t.onclick = function (e) {
                  e.preventDefault();
                }),
                l.insertBefore(t, e),
                s.appendChild(e),
                t.appendChild(i),
                (i.style.top = s.offsetTop + s.offsetHeight + "px"),
                (t.onclick = function (e) {
                  let s = t.querySelector(".select-arrow");
                  if (o);
                  else {
                    let t = this.hasAttribute("data-open");
                    (e.stopPropagation(),
                      t
                        ? ((a.style.borderBottomLeftRadius = "10px"),
                          (a.style.borderBottomRightRadius = "10px"),
                          this.removeAttribute("data-open"),
                          s.classList.remove("active-arrow"))
                        : ((a.style.borderBottomLeftRadius = 0),
                          (a.style.borderBottomRightRadius = 0),
                          this.setAttribute("data-open", ""),
                          s.classList.add("active-arrow")));
                  }
                }),
                (t.onkeyup = function (e) {
                  (e.preventDefault(), 13 === e.keyCode && this.click());
                }),
                document.addEventListener("click", function (e) {
                  let s = t.querySelector(".select-arrow");
                  t.hasAttribute("data-open") &&
                    (t.removeAttribute("data-open"),
                    (a.style.borderBottomLeftRadius = "10px"),
                    (a.style.borderBottomRightRadius = "10px"),
                    s.classList.remove("active-arrow"));
                }),
                (a.innerText = Array.from(n)[0].label));
            }
          },
          ms = s(880),
          us = s.n(ms),
          ps = (e) => {
            const t = document.querySelector(e),
              s = t.querySelector(".js-save-new-windows--swiper"),
              i = t.querySelectorAll(".js-save-new-windows--nouislider"),
              a = t.querySelector(".js-installment-calculator__amount-payment"),
              n = t.querySelector(".js-save-new-windows-card__value-square"),
              l = t.querySelector(".js-save-new-windows-card__value-quantity"),
              o = t.querySelector(".js-save-new-windows-card__value-place"),
              r = t.querySelector(".js-save-new-windows-card__value-type"),
              c = t.querySelector(".js-save-new-windows-card__value-price"),
              d = t.querySelector(".js-control__input-place"),
              m = t.querySelector(".js-control__input-type"),
              u = t.querySelectorAll(".control__option"),
              p = t.querySelectorAll(".select"),
              h = t.querySelectorAll(".span-label"),
              _ = function (e) {
                let t,
                  s =
                    arguments.length > 1 && void 0 !== arguments[1]
                      ? arguments[1]
                      : "rub",
                  i =
                    arguments.length > 2 && void 0 !== arguments[2]
                      ? arguments[2]
                      : null;
                return (
                  "rub" == s
                    ? (t = {
                        style: "currency",
                        currency: "RUB",
                        minimumFractionDigits: null == i ? 0 : i,
                      })
                    : "num" == s
                      ? (t = {
                          style: "decimal",
                          minimumFractionDigits: null == i ? 0 : i,
                        })
                      : "per" == s &&
                        (t = {
                          style: "percent",
                          minimumFractionDigits: null == i ? 0 : i,
                        }),
                  new Intl.NumberFormat("ru", t).format(Number(e))
                );
              },
              g = (e, t, s) => {
                ((c.textContent = _((e * t * s).toFixed(0))),
                  (o.textContent = d.selectedOptions[0].text),
                  (r.textContent = m.selectedOptions[0].text));
              };
            if (
              (s &&
                new M.ZP(s, {
                  slidesPerView: "auto",
                  spaceBetween: 20,
                  breakpoints: { 1e3: { slidesPerView: 3 } },
                }),
              i.length)
            ) {
              let e = [];
              i.forEach((t, s) => {
                const { start: w, max: v, min: f, step: y } = t.dataset;
                (us().create(t, {
                  start: [Number(w)],
                  step: Number(y),
                  range: { min: Number(f), max: Number(v) },
                  tooltips: [
                    {
                      to: (e) =>
                        `${t.closest(".installment-calculator__amount") ? _(e.toFixed(0), "rub", 0) : t.closest(".installment-calculator__contribution") ? _(e.toFixed(0) / 100, "per") : _(e.toFixed(0), "num")}`,
                    },
                  ],
                }),
                  t.noUiSlider.on("update", () => {
                    if (((e[s] = Number(i[s].noUiSlider.get())), a)) {
                      let t = (e[0] * e[1]) / 100,
                        s = (e[0] - t) / 6;
                      a.textContent = _(s.toFixed(0), "rub", 0);
                    }
                    if (n) {
                      let e = +i[s].noUiSlider.get();
                      ((n.textContent = `${e} м²`),
                        g(e, +d.value, +m.value),
                        p[0].addEventListener("click", (t) => {
                          g(e, +d.value, +m.value);
                        }),
                        p[1].addEventListener("click", () => {
                          g(e, +d.value, +m.value);
                        }));
                    }
                    if (l) {
                      let e = +i[s].noUiSlider.get(),
                        t = p[0].value,
                        a = p[1].value,
                        n = 0;
                      const d = function (e) {
                        let d =
                          arguments.length > 1 && void 0 !== arguments[1]
                            ? arguments[1]
                            : p[1].value;
                        ((t = p[0].value), (a = p[1].value));
                        ("Панельный/блочный дом" === d
                          ? (a = {
                              1: 2035,
                              2: 3245,
                              3: 4345,
                              4: 5665,
                              5: 6875,
                              6: 8085,
                              7: 9295,
                              8: 10505,
                              9: 11715,
                              10: 12925,
                            }[e])
                          : "Кирпичный с одинарной рамой" === d
                            ? (a = {
                                1: 2310,
                                2: 3520,
                                3: 4730,
                                4: 5940,
                                5: 7150,
                                6: 8360,
                                7: 9570,
                                8: 10780,
                                9: 13145,
                                10: 14190,
                              }[e])
                            : "Кирпичный с двойной рамой" === d &&
                              (a = {
                                1: 3245,
                                2: 5808,
                                3: 8580,
                                4: 10945,
                                5: 13530,
                                6: 16115,
                                7: 17545,
                                8: 20185,
                                9: 22275,
                                10: 23595,
                              }[e]),
                          (l.textContent = +i[s].noUiSlider.get()),
                          (o.textContent = h[0].textContent),
                          (r.textContent = h[1].textContent),
                          (n = +a + +t),
                          (c.textContent =
                            Intl.NumberFormat("ru").format(Number(n)) +
                            " руб"));
                      };
                      (d(e, h[1].textContent),
                        u.forEach((s) => {
                          s.addEventListener("click", (s) => {
                            (s.target.parentElement.getAttribute(
                              "data-value",
                            ) &&
                              (t =
                                s.target.parentElement.getAttribute(
                                  "data-value",
                                )),
                              d(e, h[1].textContent));
                          });
                        }));
                    }
                  }));
              });
            }
          },
          hs = (e) => {
            const t = document
              .querySelector(e)
              .querySelector(".js-pop-colors--swiper");
            t &&
              new M.ZP(t, {
                slidesPerView: "auto",
                spaceBetween: 5,
                breakpoints: { 1e3: { slidesPerView: 5 } },
              });
          },
          _s = (e) => {
            const t = document
              .querySelector(e)
              .querySelector(".js-two-column-block--swiper");
            t &&
              new M.ZP(t, {
                slidesPerView: "auto",
                spaceBetween: 20,
                breakpoints: { 1200: { slidesPerView: 2 } },
              });
          },
          gs = (e) => {
            const t = document
              .querySelector(e)
              .querySelector(".js-slider-window-cards--swiper");
            t &&
              new M.ZP(t, {
                slidesPerView: "auto",
                spaceBetween: 20,
                centerInsufficientSlides: "true",
              });
          },
          ws = s(171),
          vs = (e) => {
            let t = ws(e).find(".js-add-options-slider");
            new M.ZP(t[0], {
              slidesPerView: "auto",
              spaceBetween: 20,
              on: {
                init: () => {
                  ws(e).removeClass("add-options--hidden");
                },
              },
            });
          },
          fs = s(171),
          ys = (e) => {
            let t = fs(e).find(".js-install-steps-slider"),
              s = "",
              i = () => {
                fs(window).width() < 1024
                  ? s || (s = new M.ZP(t[0], { slidesPerView: "auto" }))
                  : s && (s.destroy(), (s = ""));
              };
            (i(),
              fs(window).on("resize.install_steps_slider", () => {
                c.actionFilter({
                  keyTimer: "resize_install_steps_slider",
                  duration: 100,
                  action: i,
                });
              }));
          },
          bs = s(171),
          ks = (e) => {
            let t = bs(e).find(".js-device-types-slider");
            new M.ZP(t[0], {
              spaceBetween: 20,
              slidesPerView: 1,
              breakpoints: { 600: { slidesPerView: 2 } },
              on: {
                init: () => {
                  bs(e).removeClass("device-types--hidden");
                },
              },
            });
          },
          Cs = s(171),
          Ss = (e) => {
            let t = Cs(e).find(".js-best-measurers-slider");
            new M.ZP(t[0], {
              slidesPerView: "auto",
              spaceBetween: 20,
              centerInsufficientSlides: "true",
              on: {
                init: () => {
                  Cs(e).removeClass("best-measurers--hidden");
                },
              },
            });
          },
          xs = s(171),
          Ps = (e) => {
            let t = xs(e).find(".js-measure-include-slider"),
              s = "",
              i = () => {
                xs(window).width() < 1024
                  ? s ||
                    (s = new M.ZP(t[0], {
                      modules: [M.Rv],
                      spaceBetween: 20,
                      slidesPerView: "auto",
                      freeMode: "true",
                    }))
                  : s && (s.destroy(), (s = ""));
              };
            (i(),
              xs(window).on("resize.measure-include-slider", () => {
                c.actionFilter({
                  keyTimer: "resize_measure-include-slider",
                  duration: 100,
                  action: i,
                });
              }));
          },
          js = s(171),
          qs = (e) => {
            let t = js(e).find(".js-delivery-price-slider");
            new M.ZP(t[0], {
              spaceBetween: 20,
              slidesPerView: "auto",
              centerInsufficientSlides: "true",
              on: {
                init: () => {
                  js(e).removeClass("delivery-price--hidden");
                },
              },
            });
          },
          Ds = (e) => {
            document
              .querySelector(e)
              .querySelectorAll(".js-before-after-slider__container")
              .forEach((e) => {
                !(function (e) {
                  const t = e.querySelector(
                      ".js-before-after-slider__img-before",
                    ),
                    s = t.querySelector(".js-before-after-slider__img"),
                    i = e.querySelector(".js-before-after-slider__delimiter"),
                    a = document.body;
                  let n = !1;

                  function l() {
                    let t = e.offsetWidth;
                    s.style.width = `${t}px`;
                  }

                  (l(),
                    window.addEventListener("resize", l),
                    i.addEventListener("mousedown", () => {
                      n = !0;
                    }),
                    a.addEventListener("mouseup", () => {
                      n = !1;
                    }),
                    a.addEventListener("mouseleave", () => {
                      n = !1;
                    }));
                  const o = (s) => {
                      let a = Math.max(15, Math.min(s, e.offsetWidth - 15));
                      ((t.style.width = (a / e.offsetWidth) * 100 + "%"),
                        (i.style.left = (a / e.offsetWidth) * 100 + "%"));
                    },
                    r = (e) => (e.stopPropagation(), e.preventDefault(), !1);
                  (a.addEventListener("mousemove", (t) => {
                    if (!n) return;
                    let s = t.pageX;
                    ((s -= e.getBoundingClientRect().left), o(s), r(t));
                  }),
                    i.addEventListener("touchstart", () => {
                      n = !0;
                    }),
                    a.addEventListener("touchend", () => {
                      n = !1;
                    }),
                    a.addEventListener("touchcancel", () => {
                      n = !1;
                    }),
                    a.addEventListener(
                      "touchmove",
                      (t) => {
                        if (!n) return;
                        let s, i;
                        for (i = 0; i < t.changedTouches.length; i++)
                          s = t.changedTouches[i].pageX;
                        ((s -= e.getBoundingClientRect().left), o(s), r(t));
                      },
                      { passive: !1 },
                    ),
                    e.addEventListener("selectstart", (e) => {
                      e.preventDefault();
                    }));
                })(e);
              });
          },
          Ls = s(171),
          Ms = (e) => {
            let t = Ls(e).find(".js-our-partners-slider"),
              s = "",
              i = () => {
                Ls(window).width() < 768
                  ? s ||
                    (s = new M.ZP(t[0], {
                      spaceBetween: 25,
                      slidesPerView: "auto",
                    }))
                  : s && (s.destroy(), (s = ""));
              };
            (i(),
              Ls(window).on("resize.our-partners-slider", () => {
                c.actionFilter({
                  keyTimer: "resize_our-partners-slider",
                  duration: 100,
                  action: i,
                });
              }));
          },
          $s = s(171),
          zs = (e) => {
            let t = $s(e).find(".js-our-employees-slider"),
              s = $s(e).find(".js-arrow-left"),
              i = $s(e).find(".js-arrow-right");
            new M.ZP(t[0], {
              modules: [M.W_],
              slidesPerView: 1,
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {
                  $s(e).removeClass("our-employees--hidden");
                },
              },
            });
          },
          Es = s(171),
          Fs = (e) => {
            let t = Es(e).find(".js-vacations-slider"),
              s = Es(e).find(".js-arrow-left"),
              i = Es(e).find(".js-arrow-right");
            new M.ZP(t[0], {
              modules: [M.W_],
              slidesPerView: 1,
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {
                  Es(e).removeClass("vacations--hidden");
                },
              },
            });
          },
          Os = s(171),
          Ts = (e) => {
            let t = Os(e).find(".js-prod-price-slider__slider"),
              s = Os(e).find(".js-arrow-left"),
              i = Os(e).find(".js-arrow-right");
            new M.ZP(t[0], {
              modules: [M.W_, M.pt, M.Gk],
              spaceBetween: 20,
              slidesPerView: "auto",
              mousewheel: { forceToAxis: !0, releaseOnEdges: !0 },
              autoplay: { disableOnInteraction: !1, delay: 5e3 },
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {
                  Os(e).removeClass("prod-price-slider--hidden");
                },
              },
            });
          },
          Bs = s(171),
          Is = (e) => {
            let t = Bs(e).find(".js-garbage-collection-vars-slider");
            new M.ZP(t[0], {
              spaceBetween: 20,
              slidesPerView: "auto",
              centerInsufficientSlides: "true",
              on: {
                init: () => {
                  Bs(e).removeClass("garbage-collection-vars--hidden");
                },
              },
            });
          },
          Ws = s(171),
          As = (e) => {
            (Ws(e).find(".js-garbage-collection-price-slider"),
              Ws(e).find(".js-price-scrollbar"));
          },
          Vs = (e, t) => {
            ((e.style.animation = "unset"),
              setTimeout(() => {
                e.style.animation = `animate-progress-bar ${t / 1e3}s linear`;
              }, 100));
          },
          Ns = s(171),
          Zs = (e) => {
            let t = Ns(e).find(".js-handles-color-slider"),
              s = Ns(e).find(".js-handles-color-thumbs"),
              i = new M.ZP(s[0], {
                slidesPerView: "auto",
                centerInsufficientSlides: !0,
              });
            const a = 5e3,
              n = t.find(".slider-progress");
            new M.ZP(t[0], {
              modules: [M.o3, M.pt, M.xW],
              slidesPerView: 1,
              spaceBetween: 20,
              effect: "fade",
              autoplay: { delay: a, disableOnInteraction: !0 },
              thumbs: { swiper: i },
              on: {
                init: () => {
                  (Ns(e).removeClass("handles-color--hidden"), Vs(n[0], a));
                },
                slideChange: () => {
                  Vs(n[0], a);
                },
              },
            });
          },
          Rs = s(171),
          Us = (e) => {
            let t = Rs(e).find(".js-handles-func__slider");
            new M.ZP(t[0], {
              spaceBetween: 40,
              slidesPerView: "auto",
              centerInsufficientSlides: !0,
              breakpoints: {
                768: { spaceBetween: 110 },
                1024: { spaceBetween: 180 },
              },
              on: {
                init: () => {
                  Rs(e).removeClass("handles-func--hidden");
                },
              },
            });
          },
          Gs = s(171),
          Hs = (e) => {
            let t = Gs(e).find(".js-vacancy-slider-slider");
            new M.ZP(t[0], {
              spaceBetween: 20,
              slidesPerView: 1.5,
              centerInsufficientSlides: "true",
              breakpoints: {
                576: { slidesPerView: 2.5 },
                768: { slidesPerView: 3.5 },
                1024: { spaceBetween: 0, slidesPerView: "auto" },
              },
              on: {
                init: () => {
                  Gs(e).removeClass("vacancy-slider--hidden");
                },
              },
            });
          },
          Ys = (e) => {
            const t = document.querySelector(e),
              s = t.querySelector(".js-decorative-layouts-cards__swiper"),
              i = t.querySelector(".js-decorative-layouts-swiper-pagination"),
              a = t.querySelector(".decorative-layouts__wrapp-icon"),
              n = a.querySelector(".decorative-layouts__pag"),
              l = [{ name: "8 мм" }, { name: "18 мм" }, { name: "26 мм" }],
              o = 5e3,
              r = s.querySelector(".slider-progress");
            new M.ZP(s, {
              modules: [M.tl, M.xW, M.pt],
              slidesPerView: 1,
              effect: "fade",
              autoplay: { delay: o, disableOnInteraction: !0 },
              pagination: {
                el: i,
                type: "bullets",
                bulletElement: "div",
                clickable: !0,
              },
              on: {
                init(e) {
                  Vs(r, o);
                },
                slideChange: (e) => {
                  (Vs(r, o),
                    0 === e.realIndex
                      ? ((n.style.display = "flex"),
                        (a.innerHTML =
                          '\n\t\t\t\t\t\t\t<div class="decorative-layouts__pag"> \n\t\t\t\t\t\t\t\t<p class="decorative-layouts__text-icon">Белый</p>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t<div class="decorative-layouts__pag decorative-layouts__pag_last">\n\t\t\t\t\t\t\t\t<p class="decorative-layouts__text-icon decorative-layouts__text-icon_last">Золотой</p>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t'))
                      : ((n.style.display = "none"),
                        (a.innerHTML = "Доступны все цвета<br> ламинации"),
                        (a.style.color = "#fff")));
                },
              },
            }).pagination.bullets.forEach((e, t) => {
              e.innerHTML = `<p class="bullets__text bullets__text_${t}">${l[t].name}</p>`;
            });
          },
          Js = (e) => {
            document.querySelectorAll(e).forEach(function (e, t, s) {
              let i = e.querySelector(".js-advan-slider-slider");
              4 != i.querySelectorAll(".swiper-slide").length
                ? new M.ZP(i, {
                    slidesPerView: "auto",
                    centerInsufficientSlides: !0,
                    on: {
                      init: () => {
                        e.classList.remove("advan-slider--hidden");
                      },
                    },
                  })
                : new M.ZP(i, {
                    slidesPerView: "auto",
                    centerInsufficientSlides: !0,
                    breakpoints: {
                      1024: { slidesPerView: 4 },
                      1440: { slidesPerView: "auto" },
                    },
                    on: {
                      init: () => {
                        e.classList.remove("advan-slider--hidden");
                      },
                    },
                  });
            });
          },
          Xs = s(171),
          Ks = (e) => {
            Xs(e)
              .find(".js-stained-glass-incl-slider")
              .each(function (t, s) {
                new M.ZP(s, {
                  modules: [M.W_],
                  slidesPerView: 1,
                  spaceBetween: 20,
                  navigation: {
                    prevEl: Xs(s).find(".js-arrow-left")[0],
                    nextEl: Xs(s).find(".js-arrow-right")[0],
                  },
                  on: {
                    init: () => {
                      Xs(e).removeClass("stained-glass-incl--hidden");
                    },
                  },
                });
              });
          },
          Qs = s(171),
          ei = (e) => {
            let t = Qs(e).find(".js-classic-glass-banner-slider"),
              s = Qs(e).find(".js-arrow-left"),
              i = Qs(e).find(".js-arrow-right"),
              a = Qs(e).find(".js-classic-glass-img-slider");
            (new M.ZP(t[0], {
              modules: [M.W_],
              slidesPerView: 1,
              spaceBetween: 20,
              navigation: { prevEl: s[0], nextEl: i[0] },
            }),
              new M.ZP(a[0], {
                slidesPerView: "auto",
                spaceBetween: 20,
                centerInsufficientSlides: !0,
                on: {
                  init: () => {
                    Qs(e).removeClass("classic-glass--hidden");
                  },
                },
              }));
          },
          ti = s(171),
          si = (e) => {
            let t = ti(e).find(".js-climatherm-slider-slider"),
              s = ti(e).find(".js-arrow-left"),
              i = ti(e).find(".js-arrow-right");
            new M.ZP(t[0], {
              modules: [M.W_],
              slidesPerView: 1,
              spaceBetween: 50,
              navigation: { prevEl: s[0], nextEl: i[0] },
              breakpoints: {
                650: { slidesPerView: 2 },
                1024: { slidesPerView: 1 },
              },
              on: {
                init: () => {
                  ti(e).removeClass("climatherm-slider--hidden");
                },
              },
            });
          },
          ii = s(171),
          ai = (e) => {
            let t = ii(e).find(".js-glazing-table-slider"),
              s = ii(e).find(".js-table-scrollbar");
            new M.ZP(t[0], {
              modules: [M.LW, M.Rv],
              slidesPerView: "auto",
              freeMode: { enabled: !0, momentum: !1 },
              scrollbar: { el: s[0], draggable: !0, snapOnRelease: !1 },
              on: {
                init: () => {
                  ii(e).removeClass("glazing-table--hidden");
                },
              },
            });
          },
          ni = s(171),
          li = (e) => {
            let t = ni(e).find(".js-glazing-vars-slider"),
              s = ni(e).find(".js-arrow-left"),
              i = ni(e).find(".js-arrow-right");
            new M.ZP(t[0], {
              modules: [M.W_, M.pt, M.Gk],
              slidesPerView: "auto",
              spaceBetween: 20,
              centerInsufficientSlides: !0,
              mousewheel: { forceToAxis: !0, releaseOnEdges: !0 },
              autoplay: { disableOnInteraction: !1, delay: 5e3 },
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {
                  ni(e).removeClass("glazing-vars--hidden");
                },
              },
            });
          },
          oi = s(171),
          ri = (e) => {
            let t = oi(e).find(".js-glazing-decoration-slider");
            new M.ZP(t[0], {
              slidesPerView: "auto",
              spaceBetween: 20,
              centerInsufficientSlides: !0,
              on: {
                init: () => {
                  oi(e).removeClass("glazing-decoration--hidden");
                },
              },
            });
          },
          ci = (e) => {
            (0, Oe.ZP)("[data-tippy-content]", {
              appendTo: "parent",
              arrow: !1,
              placement: "top-end",
              offset: [4, 14],
              maxWidth: 110,
              duration: [300, 0],
              hideOnClick: !1,
            });
          },
          di = (e) => {
            let t = l.getComponent(".js-modal-win");
            return new G(e, {
              tooltip: !0,
              onSuccess(e) {
                (t.close(), t.open("#modal-success-form"));
              },
              onFail(e, s) {
                (t.close(),
                  t.open("#modal-error", (e) => {
                    if (s.data.message) {
                      e.openedWindow.querySelector(
                        ".modal-win__head-desc",
                      ).innerText = s.data.message;
                    }
                  }));
              },
            });
          },
          mi = (e) => {
            const t = document
              .querySelector(e)
              .querySelector(".js-noise-protect-info-slider");
            t &&
              new M.ZP(t, {
                modules: [M.Rv],
                slidesPerView: "auto",
                spaceBetween: 20,
                freeMode: !0,
              });
          },
          ui = (e) => {
            const t = document.querySelector(e);
            let s = t.querySelector(".js-tinting-vars-slider");
            s &&
              new M.ZP(s, {
                modules: [M.Rv],
                slidesPerView: "auto",
                centerInsufficientSlides: !0,
                FreeMode: !0,
                on: {
                  init: () => {
                    t.classList.remove("tinting-vars--hidden");
                  },
                },
              });
          },
          pi = s(171),
          hi = (e) => {
            let t = pi(e).find(".js-tinting-rate-slider");
            new M.ZP(t[0], {
              slidesPerView: "auto",
              spaceBetween: 40,
              centerInsufficientSlides: !0,
              on: {
                init: () => {
                  pi(e).removeClass("tinting-rate--hidden");
                },
              },
            });
          },
          _i = (e) => {
            const t = document.querySelector(e);
            let s = t.querySelector(".js-tinting-slider-slider");
            s &&
              new M.ZP(s, {
                modules: [M.rj],
                slidesPerView: "auto",
                centerInsufficientSlides: !0,
                breakpoints: { 1024: { grid: { fill: "row", rows: 2 } } },
                on: {
                  init: () => {
                    t.classList.remove("tinting-slider--hidden");
                  },
                },
              });
          },
          gi = s(171),
          wi = (e) => {
            let t = gi(e).find(".js-work-gallery-slider");
            Ge(".js-work-gallery");
            t.each((e, t) => {
              new M.ZP(t, {
                modules: [M.W_, M.tl, M.Gk, M.pt],
                mousewheel: { forceToAxis: !0, releaseOnEdges: !0 },
                autoplay: { delay: 5e3, disableOnInteraction: !0 },
                loop: !0,
                spaceBetween: 20,
                slidesPerView: "auto",
                centeredSlides: !0,
                navigation: {
                  prevEl: t.querySelector(".js-arrow-left"),
                  nextEl: t.querySelector(".js-arrow-right"),
                },
                pagination: {
                  el: t.querySelector(".js-work-gallery-pagination"),
                  clickable: !0,
                },
                on: {
                  init: () => {
                    gi(t).removeClass("work-gallery--hidden");
                  },
                },
              });
            });
          },
          vi = s(171);

        class fi {
          constructor(e) {
            ((this.el = e),
              (this.$tabs = vi(e).find(".js-win-prices-tab-item")),
              (this.$contents = vi(e).find(".js-win-prices-item")),
              (this.$sliderThumb = vi(e).find(".js-types-material-thumb")),
              (this.$imgBanner = vi(e).find(".js-banner-img")),
              (this.$titleBanner = vi(e).find(".js-banner-title")),
              this.initTabSlider(),
              this.initSliderThumb(),
              this.clickSlideThumb(),
              this.clickTab());
          }

          initTabSlider() {
            let { el: e, winWidth: t } = this,
              s = vi(e).find(".js-win-prices-tab");
            if (s.length) {
              return new M.ZP(s[0], {
                breakpoints: {
                  320: { slidesPerView: 2, spaceBetween: 10 },
                  600: { slidesPerView: 3, spaceBetween: 10 },
                  1024: { slidesPerView: 4 },
                },
                on: {
                  init() {
                    s.removeClass("win-prices-tab--hidden");
                  },
                },
              });
            }
          }

          initSliderThumb() {
            let { el: e, $sliderThumb: t } = this;
            t.each(function (t, s) {
              let i = vi(this).find(".js-thumb-scrollbar"),
                a = new M.ZP(this, {
                  modules: [M.LW],
                  spaceBetween: 10,
                  slidesPerView: "auto",
                  resistanceRatio: 0,
                  scrollbar: { el: i[0], draggable: !0 },
                  on: {
                    init: () => {
                      vi(e).removeClass("types-material--hidden");
                    },
                  },
                });
              this.typeSlider = a;
            });
          }

          setActiveThumb(e, t) {
            let { $imgBanner: s, $titleBanner: i } = this,
              a = t.find("[data-slide-index]");
            for (let t of a) {
              let n = vi(t);
              if (n.data("slide-index") == e) {
                let e = n.data("img-banner"),
                  t = n.data("title-banner");
                (s.attr("src", e),
                  i.html(t),
                  a.removeClass("active"),
                  n.addClass("active"));
                break;
              }
            }
          }

          clickSlideThumb() {
            let e = this,
              { $sliderThumb: t } = this;
            t.find("[data-slide-index]").on(
              "click.types_material_thumb",
              function () {
                let t = vi(this).data("slide-index"),
                  s = vi(this).closest(".js-types-material-thumb");
                e.setActiveThumb(t, s);
              },
            );
          }

          clickTab() {
            let e = this,
              { $tabs: t } = this;
            t.on("click.type_material_tab", function () {
              let s = vi(this).hasClass("active"),
                i = vi(this).data("tab-index");
              s ||
                (t.removeClass("active"),
                vi(this).addClass("active"),
                e.setContent(i));
            });
          }

          setContent(e) {
            let { $contents: t } = this;
            t.removeClass("active");
            for (let s of t) {
              if (e == vi(s).data("tab-index")) {
                let e = vi(s).find(".js-types-material-thumb");
                if ((vi(s).addClass("active"), e.length)) {
                  let t = e[0].typeSlider;
                  (t.updateSize(), t.slideTo(0), this.setActiveThumb(0, e));
                }
                break;
              }
            }
          }
        }

        var yi = (e) => new fi(e),
          bi = s(171),
          ki = (e) => {
            let t = bi(e).find(".js-calc-work-performed-slider"),
              s = bi(e).find(".js-arrow-left"),
              i = bi(e).find(".js-arrow-right");
            new M.ZP(t[0], {
              modules: [M.W_],
              slidesPerView: 2,
              spaceBetween: 20,
              breakpoints: {
                320: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1600: { slidesPerView: 3 },
              },
              navigation: { prevEl: s[0], nextEl: i[0] },
              on: {
                init: () => {
                  bi(e).removeClass("calc-work-performed--hidden");
                },
              },
            });
          },
          Ci = (e) => {
            const t = document
              .querySelector(e)
              .querySelector(".js-about-slider--swiper");
            if (t) {
              const e = t.querySelector(".js-arrow-left"),
                s = t.querySelector(".js-arrow-right");
              new M.ZP(t, {
                modules: [M.W_],
                slidesPerView: "auto",
                spaceBetween: 20,
                navigation: { prevEl: e, nextEl: s },
              });
            }
          },
          Si = (e) => {
            const t = document.querySelector(e),
              s = t.querySelector(".js-about-slider-tabs--swiper"),
              i = t.querySelectorAll(".js-about-slider-tab");
            if (s) {
              const e = s.querySelector(".js-arrow-left"),
                t = s.querySelector(".js-arrow-right"),
                a = new M.ZP(s, {
                  modules: [M.W_],
                  slidesPerView: "auto",
                  navigation: { prevEl: e, nextEl: t },
                });
              document.addEventListener("about-tabs:about-slider-tabs", (e) => {
                const t = e.detail;
                (i.forEach((e) => {
                  if ("all" === t) e.classList.remove("hide");
                  else {
                    e.dataset.category.split(",").includes(t)
                      ? e.classList.remove("hide")
                      : e.classList.add("hide");
                  }
                }),
                  a.update());
              });
            }
          },
          xi = (e) => {
            const t = document.querySelector(e),
              s = t.querySelector(".js-about-tiles-tabs--swiper"),
              i = t.querySelectorAll(".js-about-tiles-tab");
            if (s) {
              const e = new M.ZP(s, {
                modules: [M.LW],
                spaceBetween: 20,
                slidesPerView: "auto",
                scrollbar: { draggable: !0 },
              });
              document.addEventListener("about-tabs:about-tiles-tabs", (t) => {
                const s = t.detail;
                (i.forEach((e) => {
                  if ("all" === s) e.classList.remove("hide");
                  else {
                    e.dataset.category.split(",").includes(s)
                      ? e.classList.remove("hide")
                      : e.classList.add("hide");
                  }
                }),
                  e.update());
              });
            }
            new d.Z({ linkAttributeName: "data-certif-modal" });
          },
          Pi = s(190);

        class ji {
          constructor(e) {
            ((this.map = null),
              (this.zoom = null),
              (this.center = null),
              (this.markers = []),
              (this.bounds = []),
              (this.popupCollection = []),
              this.createMap(e));
          }

          createMap(e) {
            const { lat: t, lng: s, zoom: i } = e.dataset;
            ((this.zoom = parseFloat(i)),
              (this.center = [parseFloat(t), parseFloat(s)]),
              (this.map = Pi.map(e, {
                center: this.center,
                zoom: this.zoom,
                scrollWheelZoom: !1,
                attributionControl: !1,
                zoomControl: !1,
              })),
              Pi.tileLayer(
                "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
              ).addTo(this.map));
          }

          createMarkersAll(e, t) {
            ((this.popupCollection = [...e]),
              this.markers.forEach((e) => {
                this.map.removeLayer(e.marker);
              }),
              (this.markers = []),
              (this.bounds = []),
              this.popupCollection.forEach((e) => {
                const { lat: s, lng: i } = e.dataset,
                  a = [parseFloat(s), parseFloat(i)],
                  n = Pi.marker(a, {
                    icon: Pi.icon({
                      iconUrl: "/new_style_files/assets/img/res/map-marker.png",
                    }),
                  }).addTo(this.map),
                  l = Pi.popup({ closeButton: !1 }).setContent(e.innerHTML);
                (n.on("click", () => {
                  t() &&
                    (this.hideAllNodes(e),
                    (e.style.display =
                      "block" === e.style.display ? "none" : "block"));
                }),
                  t() || n.bindPopup(l),
                  this.markers.push({ marker: n, popup: l }),
                  this.bounds.push(a));
              }));
            const [s] = this.bounds;
            (this.map.setView(s, parseFloat(this.zoom)),
              this.map.fitBounds(this.bounds));
          }

          createMarkers(e, t, s) {
            this.popupCollection = [...t];
            const i = this.popupCollection.filter((t) => t.dataset.name === e);
            (this.markers.forEach((e) => {
              this.map.removeLayer(e.marker);
            }),
              (this.markers = []),
              (this.bounds = []),
              i.forEach((e) => {
                const { lat: t, lng: i } = e.dataset,
                  a = [parseFloat(t), parseFloat(i)],
                  n = Pi.marker(a, {
                    icon: Pi.icon({
                      iconUrl: "/new_style_files/assets/img/res/map-marker.png",
                    }),
                  }).addTo(this.map),
                  l = Pi.popup({ closeButton: !1 }).setContent(e.innerHTML);
                (n.on("click", () => {
                  s() &&
                    (this.hideAllNodes(e),
                    (e.style.display =
                      "block" === e.style.display ? "none" : "block"));
                }),
                  s() || n.bindPopup(l),
                  this.markers.push({ marker: n, popup: l }),
                  this.bounds.push(a));
              }));
            const [a] = this.bounds;
            (this.map.setView(a, parseFloat(this.zoom)),
              this.map.fitBounds(this.bounds));
          }

          hideAllNodes(e) {
            this.popupCollection.forEach((t) => {
              t !== e && (t.style.display = "none");
            });
          }

          closeAllPopups() {
            this.markers.forEach((e) => {
              e.marker.closePopup().unbindPopup();
            });
          }

          bindAllPopups() {
            this.markers.forEach((e) => {
              e.marker.bindPopup(e.popup);
            });
          }
        }

        var qi = (e) => {
            const t = document.querySelector(e),
              s = t
                .querySelector(".js-about-contacts-addresses--templates")
                .querySelectorAll(".js-about-contacts-addresses--popup"),
              i = t.querySelector(".js-about-contacts-addresses--map"),
              { eventName: a, defaultCity: n } = i.dataset,
              l = new ji(i),
              o = () => document.documentElement.clientWidth < 768;
            (document.addEventListener(a, (e) => {
              const t = e.detail;
              (l.hideAllNodes(),
                "Все" !== t
                  ? l.createMarkers(t, s, o)
                  : l.createMarkersAll(s, o));
            }),
              window.addEventListener("resize", (e) => {
                o()
                  ? l.closeAllPopups()
                  : (l.hideAllNodes(), l.bindAllPopups());
              }),
              l.createMarkersAll(s, o));
          },
          Di = (e) => {
            const t = document.querySelector(e),
              s = t.querySelector(".js-about-contacts-list--swiper");
            (t.addEventListener("click", (e) => {
              const t = document.forms.writeKeyPerson;
              if (e.target.classList.contains("about-contacts-list__btn")) {
                let s = e.target.dataset.email,
                  i = "";
                (e.target.dataset?.bbc && (i = e.target.dataset.bbc),
                  (t.owner.value = s),
                  (t.bbc.value = i));
              }
            }),
              new M.ZP(s, { slidesPerView: "auto", spaceBetween: 20 }));
          },
          Li = (e) => {
            const t = document
              .querySelector(e)
              .querySelector(".js-about-contacts-info--swiper");
            new M.ZP(t, { slidesPerView: "auto", spaceBetween: 20 });
          },
          Mi = (e) => {
            document.querySelectorAll(e).forEach((e) => {
              const t = e.querySelectorAll(".js-rating-star--item");
              t.forEach((e, s) => {
                e.addEventListener("click", (e) => {
                  (t.forEach((e, t) => {
                    t <= s
                      ? e.classList.add("active")
                      : e.classList.remove("active");
                  }),
                    e.target.dataset?.rating &&
                      (document.querySelector(
                        ".about-reviews-form__form input[name=rating]",
                      ).value = e.target.dataset.rating));
                });
              });
            });
          },
          $i = (e) => {
            const t = document.querySelector(e),
              s = t.querySelectorAll(".js-about-tab"),
              i = (e) => {
                const { eventName: s } = t.dataset,
                  i = new window.CustomEvent(s, { detail: e });
                document.dispatchEvent(i);
              };
            (t &&
              new M.ZP(t, {
                slidesPerView: "auto",
                spaceBetween: 10,
                breakpoints: { 1200: { spaceBetween: 0 } },
              }),
              s.forEach((e) => {
                (e.addEventListener("click", () => {
                  (i(e.dataset.category),
                    s.forEach((t) => {
                      e === t
                        ? t.classList.add("active")
                        : t.classList.remove("active");
                    }));
                }),
                  setTimeout(() => {
                    e.classList.contains("active") && i(e.dataset.category);
                  }, 100));
              }));
          },
          zi = (e) => {
            const t = document
              .querySelector(e)
              .querySelectorAll(".js-about-portfolio-card");
            document.addEventListener(
              "about-tabs:about-portfolio-cards",
              (e) => {
                const s = e.detail;
                t.forEach((e) => {
                  if ("all" === s) e.classList.remove("hide");
                  else {
                    e.dataset.category.split(",").includes(s)
                      ? e.classList.remove("hide")
                      : e.classList.add("hide");
                  }
                });
              },
            );
          },
          Ei = s(171),
          Fi = (e) => {
            let t = Ei(e).find(".js-mosq-advan-slider");
            new M.ZP(t[0], {
              spaceBetween: 20,
              slidesPerView: "auto",
              on: {
                init: () => {
                  Ei(e).removeClass("mosq-advan--hidden");
                },
              },
            });
          },
          Oi = s(171),
          Ti = (e) => {
            let t = Oi(e).find(".js-mosq-net-type-slider");
            new M.ZP(t[0], {
              spaceBetween: 20,
              slidesPerView: "auto",
              on: {
                init: () => {
                  Oi(e).removeClass("mosq-net-type--hidden");
                },
              },
            });
          },
          Bi = s(171);

        class Ii {
          constructor(e) {
            ((this.el = e),
              (this.$form = Bi(e).find("form")),
              (this.form = ""),
              this.initForm());
          }

          initForm() {
            let { el: e } = this;
            l.getComponent(".js-modal-win");
            this.form = new G(e, {
              onSubmit: (e) => {
                let { action: t, data: s } = e,
                  i = l.getComponent("#vue-calendar-delivery").$store.state,
                  a = l.getComponent("#vue-mosq-basket").$store.state;
                ((s = {
                  "user-data": { ...s, "date-delivery": i.date },
                  items: a.mosqData,
                  options: {
                    "price-delivery": a.deliveryPrice,
                    "price-mounting": a.mountingPrice,
                  },
                }),
                  R.ajaxPost({ url: t, data: s }).then((e) => {
                    e.success && this.buildPayment(e.data);
                  }));
              },
            });
          }

          buildPayment(e) {
            let { el: t, $form: s } = this,
              i = e.payment;
            if (i)
              for (let [e, t] of Object.entries(i))
                ("URL" == e
                  ? s.attr("action", t)
                  : s.append(
                      `\n\t\t\t\t\t<input type="hidden" name="${e}" value="${t}">\n\t\t\t\t`,
                    ),
                  s[0].submit());
          }
        }

        var Wi = (e) => new Ii(e),
          Ai = (e) => {
            const t = document.querySelector(e),
              s = t.querySelector(".js-slider-lamination-swiper-pagination"),
              i = [
                { name: "Шоколад", color: "#381C1C" },
                { name: "Антрацит", color: "#1E222E" },
                {
                  name: "Карамель",
                  color: "#D89C55",
                },
              ],
              a = 5e3,
              n = t.querySelector(".slider-progress");
            new M.ZP(".js-slider-lamination-cards__swiper", {
              modules: [M.tl, M.pt, M.xW],
              slidesPerView: 1,
              effect: "fade",
              autoplay: { delay: a, disableOnInteraction: !0 },
              pagination: {
                el: s,
                type: "bullets",
                bulletElement: "div",
                clickable: !0,
              },
              initialSlide: 1,
              on: {
                init() {
                  Vs(n, a);
                },
                slideChange: () => {
                  Vs(n, a);
                },
              },
            }).pagination.bullets.forEach((e, t) => {
              ((e.textContent = i[t].name),
                (e.style.backgroundColor = i[t].color));
            });
          },
          Vi = s(171),
          Ni = (e) => {
            const t = document.querySelector(".aluminium-systems-slider"),
              s = document.querySelector(
                ".aluminium-systems-slider__container",
              ),
              i = document.querySelectorAll(".aluminium-systems-slider__slide"),
              a = document.querySelector(".aluminium-systems-slider__btn-warm"),
              n = document.querySelector(".aluminium-systems-slider__btn-cold"),
              l = document.querySelector(
                ".aluminium-systems-slider__btn-window",
              ),
              o = document.querySelector(
                ".aluminium-systems-slider__btn-facade",
              ),
              r = document.querySelector(".aluminium-systems-slider__btn-door"),
              c = document.querySelector(
                ".aluminium-systems-slider__btn-accordion",
              ),
              d = document.querySelector(
                ".aluminium-systems-slider__btn-portal",
              );
            let m = Vi(window).width();
            const u = new M.ZP(".js-aluminium-systems-slider", {
                modules: [M.W_, M.xW, M.pt, M.bi],
                effect: "fade",
                crossFade: !0,
                speed: 1e3,
                slidesPerView: 1,
                navigation: {
                  prevEl: ".aluminium-systems-slider__arrow-left",
                  nextEl: ".aluminium-systems-slider__arrow-right",
                },
              }),
              p = document.querySelector(".aluminium-systems-slider__title"),
              h = document.querySelector(
                ".aluminium-systems-slider__wrap-button-one",
              ),
              _ = document.querySelector(
                ".aluminium-systems-slider__wrap-tabs",
              ),
              g = document.querySelector(
                ".aluminium-systems-slider__block-left",
              ),
              w = document.querySelector(
                ".aluminium-systems-slider__wrap-button",
              ),
              v = document.querySelector(
                ".aluminium-systems-slider__wrap-button-two",
              );
            !(function (e, s, i, a, n, l) {
              const o = t.getBoundingClientRect(),
                r = e.getBoundingClientRect(),
                c = s.getBoundingClientRect(),
                d = i.getBoundingClientRect(),
                u = n.getBoundingClientRect();
              (l.getBoundingClientRect(),
                m < 1025 &&
                  ((h.style.top = Math.round(c.y - r.y - 210) + "px"),
                  (v.style.left = Math.round(d.width - 60) + "px"),
                  (v.style.top = Math.round(d.y - o.y + 20) + "px")),
                m > 1025 &&
                  ((a.style.bottom = Math.round(u.y - d.y - d.height) + "px"),
                  (v.style.top = Math.round(d.y - o.y + 40) + "px"),
                  (v.style.left = Math.round(d.width - 78) + "px")));
            })(
              _,
              p,
              g,
              w,
              document.querySelector(".program-calculate-slider"),
              v,
            );
            (u.removeAllSlides(),
              u.prependSlide([i[1], i[2], i[4]]),
              u.slideTo(0, 1e3),
              u.updateSlides(),
              u.update(),
              s.addEventListener("click", (e) => {
                (e.target.closest(".aluminium-systems-slider__arrow-left") &&
                  m < 1025 &&
                  y(),
                  e.target.closest(".aluminium-systems-slider__arrow-right") &&
                    m < 1025 &&
                    y(),
                  e.target.closest(".aluminium-systems-slider__btn-window") &&
                    (u.removeAllSlides(),
                    u.prependSlide([i[1], i[2], i[4]]),
                    u.slideTo(0, 1e3),
                    u.updateSlides(),
                    n.classList.contains(
                      "aluminium-systems-slider__btn-warm-active",
                    ) &&
                      n.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                    !a.classList.contains(
                      "aluminium-systems-slider__btn-warm-active",
                    ) &&
                      a.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                    n.classList.contains("button-disabled") &&
                      n.classList.toggle("button-disabled"),
                    u.update(),
                    m < 1025 && y(),
                    document
                      .querySelector(".aluminium-systems-slider__btn-active")
                      .classList.toggle("aluminium-systems-slider__btn-active"),
                    l.classList.toggle("aluminium-systems-slider__btn-active")),
                  e.target.closest(".aluminium-systems-slider__btn-facade") &&
                    (u.removeAllSlides(),
                    u.prependSlide([i[6], i[5]]),
                    u.slideTo(0, 1e3),
                    u.updateSlides(),
                    n.classList.contains(
                      "aluminium-systems-slider__btn-warm-active",
                    ) &&
                      n.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                    !a.classList.contains(
                      "aluminium-systems-slider__btn-warm-active",
                    ) &&
                      a.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                    !n.classList.contains("button-disabled") &&
                      n.classList.toggle("button-disabled"),
                    u.update(),
                    m < 1025 && y(),
                    document
                      .querySelector(".aluminium-systems-slider__btn-active")
                      .classList.toggle("aluminium-systems-slider__btn-active"),
                    o.classList.toggle("aluminium-systems-slider__btn-active")),
                  e.target.closest(".aluminium-systems-slider__btn-door") &&
                    (u.removeAllSlides(),
                    u.prependSlide([i[8], i[10], i[11], i[13]]),
                    u.slideTo(0, 1e3),
                    u.updateSlides(),
                    n.classList.contains(
                      "aluminium-systems-slider__btn-warm-active",
                    ) &&
                      n.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                    !a.classList.contains(
                      "aluminium-systems-slider__btn-warm-active",
                    ) &&
                      a.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                    n.classList.contains("button-disabled") &&
                      n.classList.toggle("button-disabled"),
                    u.update(),
                    m < 1025 && y(),
                    document
                      .querySelector(".aluminium-systems-slider__btn-active")
                      .classList.toggle("aluminium-systems-slider__btn-active"),
                    r.classList.toggle("aluminium-systems-slider__btn-active")),
                  e.target.closest(".aluminium-systems-slider__btn-portal") &&
                    (u.removeAllSlides(),
                    u.prependSlide([i[14], i[15], i[16], i[17]]),
                    u.slideTo(0, 1e3),
                    u.updateSlides(),
                    n.classList.contains(
                      "aluminium-systems-slider__btn-warm-active",
                    ) &&
                      n.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                    !a.classList.contains(
                      "aluminium-systems-slider__btn-warm-active",
                    ) &&
                      a.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                    !n.classList.contains("button-disabled") &&
                      n.classList.toggle("button-disabled"),
                    u.update(),
                    m < 1025 && y(),
                    document
                      .querySelector(".aluminium-systems-slider__btn-active")
                      .classList.toggle("aluminium-systems-slider__btn-active"),
                    d.classList.toggle("aluminium-systems-slider__btn-active")),
                  e.target.closest(
                    ".aluminium-systems-slider__btn-accordion",
                  ) &&
                    (u.removeAllSlides(),
                    u.prependSlide([i[18]]),
                    u.slideTo(0, 1e3),
                    u.updateSlides(),
                    n.classList.contains(
                      "aluminium-systems-slider__btn-warm-active",
                    ) &&
                      n.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                    !a.classList.contains(
                      "aluminium-systems-slider__btn-warm-active",
                    ) &&
                      a.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                    !n.classList.contains("button-disabled") &&
                      n.classList.toggle("button-disabled"),
                    u.update(),
                    m < 1025 && y(),
                    document
                      .querySelector(".aluminium-systems-slider__btn-active")
                      .classList.toggle("aluminium-systems-slider__btn-active"),
                    c.classList.toggle("aluminium-systems-slider__btn-active")),
                  e.target.closest(".aluminium-systems-slider__btn-cold") &&
                  !e.target.classList.contains("button-disabled") &&
                  document
                    .querySelector(".aluminium-systems-slider__btn-active")
                    .classList.contains("aluminium-systems-slider__btn-window")
                    ? (u.removeAllSlides(),
                      u.prependSlide([i[0], i[3]]),
                      u.slideTo(0, 1e3),
                      u.updateSlides(),
                      a.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                      n.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                      u.update(),
                      m < 1025 && y())
                    : e.target.closest(".aluminium-systems-slider__btn-warm") &&
                      document
                        .querySelector(".aluminium-systems-slider__btn-active")
                        .classList.contains(
                          "aluminium-systems-slider__btn-window",
                        ) &&
                      (u.removeAllSlides(),
                      u.prependSlide([i[1], i[2], i[4]]),
                      u.slideTo(0, 1e3),
                      u.updateSlides(),
                      a.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                      n.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                      u.update(),
                      m < 1025 && y()),
                  e.target.closest(".aluminium-systems-slider__btn-cold") &&
                  !e.target.classList.contains("button-disabled") &&
                  document
                    .querySelector(".aluminium-systems-slider__btn-active")
                    .classList.contains("aluminium-systems-slider__btn-door")
                    ? (u.removeAllSlides(),
                      u.prependSlide([i[12], i[9], i[7]]),
                      u.slideTo(0, 1e3),
                      u.updateSlides(),
                      a.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                      n.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                      u.update(),
                      m < 1025 && y())
                    : e.target.closest(".aluminium-systems-slider__btn-warm") &&
                      document
                        .querySelector(".aluminium-systems-slider__btn-active")
                        .classList.contains(
                          "aluminium-systems-slider__btn-door",
                        ) &&
                      (u.removeAllSlides(),
                      u.prependSlide([i[8], i[10], i[11], i[13]]),
                      u.slideTo(0, 1e3),
                      u.updateSlides(),
                      a.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                      n.classList.toggle(
                        "aluminium-systems-slider__btn-warm-active",
                      ),
                      u.update(),
                      m < 1025 && y()));
              }));
            const f = t
              .querySelector(".swiper-slide-active")
              .querySelector(".aluminium-systems-slider__title");
            if (m < 1025) {
              const e = f.cloneNode(!0);
              (e.classList.add("title-slide-active"),
                (f.style.opacity = 0),
                (f.style.display = "none"),
                t.before(e));
            }

            function y() {
              const e = t.querySelector(".swiper-slide-active"),
                s = document.querySelector(".title-slide-active"),
                i = e.querySelector(".aluminium-systems-slider__title");
              ((i.style.opacity = "0"),
                (i.style.display = "none"),
                (s.textContent = i.textContent));
            }
          };
        var Zi = class {
            constructor(e, t) {
              let s =
                arguments.length > 2 && void 0 !== arguments[2]
                  ? arguments[2]
                  : "rub";
              ((this.$el = e),
                (this.params = t),
                (this.sumType = s),
                this.$slider,
                this.initRanger());
            }

            initRanger() {
              let { $el: e, params: t, sumType: s } = this;
              this.$slider = us().create(e, {
                start: [Number(t.start)],
                step: Number(t.step),
                connect: "lower",
                range: { min: Number(t.min), max: Number(t.max) },
                tooltips: [
                  {
                    to: (e) => {
                      switch (s) {
                        case "rub":
                          return c.numFormat(e);
                        case "per":
                          return c.numFormat(e / 100, "per");
                        case "num":
                          return c.numFormat(e, "num");
                        default:
                          return `${c.numFormat(e, "num")} ${s}`;
                      }
                    },
                  },
                ],
              });
            }
          },
          Ri = s(171),
          Ui = (e) => {
            let t = Ri(e),
              s = t.find(".js-ranger"),
              i = t.find(".js-calc-perform--select select"),
              a = t.find(".js-select"),
              n = t.find(".js-calc-perform-desc"),
              l = {
                summ: { price: 0, el: t.find(".js-calc-perform--final") },
                square: { el: s },
              },
              o = (e) => {
                let {
                  type: t,
                  val: s,
                  select: i,
                  id: a = "",
                  el: n = null,
                } = e;
                "square" === t
                  ? (i = `${i} м²`)
                  : "system" === t && (i = `Exprof ${i}`);
                let l = {};
                return (
                  a && (l.id = a),
                  n && (l.el = n),
                  (l.value = s),
                  (l.selected = i),
                  l
                );
              },
              r = function (e) {
                let { square: t, place: s, heat: i, system: a } = e,
                  n = t.value * s.value * i.value;
                ((e.summ.price = (n - n * a.value).toFixed(0)),
                  e.summ.el.text(c.numFormat(e.summ.price)));
              };
            (i.each((e, s) => {
              ((l[s.dataset.selectType] = o({
                type: s.dataset.selectType,
                val: s.value,
                select: s.selectedOptions[0].text,
                id: s.id,
                el: t.find(`.js-calc-perform--${s.dataset.selectType}`),
              })),
                Ri(s).on("change", (e) => {
                  ((l[e.target.dataset.selectType] = {
                    ...l[e.target.dataset.selectType],
                    ...o({
                      type: e.target.dataset.selectType,
                      val: e.target.value,
                      select: e.target.selectedOptions[0].text,
                    }),
                  }),
                    l[e.target.dataset.selectType].el.text(
                      l[e.target.dataset.selectType].selected,
                    ),
                    r(l));
                }));
            }),
              a.each((e, t) => {
                Ri(t).on("click", (e) => {
                  let s = t.querySelector("select");
                  if (
                    ((l[s.dataset.selectType] = {
                      ...l[s.dataset.selectType],
                      ...o({
                        type: s.dataset.selectType,
                        val: s.value,
                        select: s.selectedOptions[0].text,
                      }),
                    }),
                    l[s.dataset.selectType].el.text(
                      l[s.dataset.selectType].selected,
                    ),
                    (s.id = "js-select-type-system"))
                  ) {
                    let e = l.system.selected.split("Exprof ")[1].toLowerCase();
                    n.find(".hot-economy__text").each((t, s) => {
                      s.classList.contains("hot-economy__text--hidden") &&
                      s.classList.contains(`js-calc-perform-desc--${e}`)
                        ? s.classList.remove("hot-economy__text--hidden")
                        : s.classList.contains(`js-calc-perform-desc--${e}`) ||
                          s.classList.add("hot-economy__text--hidden");
                    });
                  }
                  r(l);
                });
              }),
              s.each((e, s) => {
                let { start: i, max: a, min: n, step: o, type: c } = s.dataset,
                  d = new Zi(s, { start: i, max: a, min: n, step: o }, c);
                ((l.square.el = t.find(".js-calc-perform--square")),
                  (l.square.value = Number(d.$slider.get()).toFixed(0)),
                  (l.square.selected = `${l.square.value} м²`),
                  l.square.el.text(l.square.selected),
                  d.$slider.on("update", () => {
                    ((l.square.value = Number(d.$slider.get()).toFixed(0)),
                      (l.square.selected = `${l.square.value} м²`),
                      l.square.el.text(l.square.selected),
                      r(l));
                  }));
              }),
              r(l));
          },
          Gi = s(171),
          Hi = (e) => {
            let t = Gi(e),
              s = t.find(".js-ranger"),
              i = t.find(".js-garbage-calc-collection__selects .js-select"),
              a =
                (t.find(".js-select"),
                {
                  summ: {
                    price: 0,
                    el: t.find(".js-garbage-calc-collection__total-value"),
                  },
                  quantity: { el: s },
                });
            const n = [
                2035, 3245, 4345, 5665, 6875, 8085, 9295, 10505, 11715, 12925,
              ],
              l = [
                2310, 3520, 4730, 5940, 7150, 8360, 9570, 10780, 13145, 14190,
              ],
              o = [
                3245, 5808, 8580, 10945, 13530, 16115, 17545, 20185, 22275,
                23595,
              ],
              r = 400,
              c = 900,
              d = 1500;

            function m(e) {
              const t = document.querySelector(
                  "#calc-place-select .js-select__current",
                ),
                s = document.querySelector(
                  "#calc-type-select .js-select__current",
                ),
                i = document.querySelector(
                  ".js-garbage-calc-collection__total-value",
                );
              let a = 0;
              ((a =
                "Кирпичный с двойной рамой" == s.textContent
                  ? o[e.quantity.value - 1]
                  : "Кирпичный с одинарной рамой" == s.textContent
                    ? l[e.quantity.value - 1]
                    : n[e.quantity.value - 1]),
                "до 5км от МКАД" == t.textContent
                  ? (i.textContent = a + r + " руб")
                  : "до 10км от МКАД" == t.textContent
                    ? (i.textContent = a + c + " руб")
                    : "до 15км от МКАД" == t.textContent
                      ? (i.textContent = a + d + " руб")
                      : (i.textContent = a + " руб"));
            }

            (i.each((e, t) => {
              t.addEventListener("click", () => {
                m(a);
              });
            }),
              s.each((e, s) => {
                let {
                    start: i = 3,
                    max: n = 10,
                    min: l = 1,
                    step: o = 1,
                    type: r = "num",
                  } = s.dataset,
                  c = new Zi(s, { start: i, max: n, min: l, step: o }, r);
                ((a.quantity.el = t.find(
                  "#garbage-calc-collection__window-count",
                )),
                  (a.quantity.value = Number(c.$slider.get()).toFixed(0)),
                  (a.quantity.selected = `${a.quantity.value}`),
                  a.quantity.el.text(a.quantity.selected),
                  c.$slider.on("update", () => {
                    ((a.quantity.value = Number(c.$slider.get()).toFixed(0)),
                      (a.quantity.selected = `${a.quantity.value}`),
                      a.quantity.el.text(a.quantity.selected),
                      m(a));
                  }));
              }),
              m(a));
          },
          Yi = (e) => {
            const t = document.querySelectorAll(".select__header"),
              s = document.querySelectorAll(".select__item"),
              i = document.querySelectorAll(".js-select"),
              a = document.querySelector("#garbage-calc-collection__place"),
              n = document.querySelector(
                "#garbage-calc-collection__house-type",
              ),
              l = function () {
                i.forEach((e) => {
                  e.classList.remove("is-active");
                });
              },
              o = function () {
                (l(),
                  this.classList.contains("is-active") ||
                    this.parentElement.classList.add("is-active"));
              },
              r = function () {
                let e = this.textContent;
                ((this.closest(".js-select").querySelector(
                  ".select__current",
                ).textContent = e),
                  this.closest("#calc-place-select")
                    ? (a.textContent = e)
                    : (n.textContent = e),
                  l());
              };
            (t.forEach((e) => {
              e.addEventListener("click", o);
            }),
              s.forEach((e) => {
                e.addEventListener("click", r);
              }),
              window.addEventListener("click", (e) => {
                const t = e.target;
                t.closest(".js-select") || t.closest(".select__header") || l();
              }));
          },
          Ji = s(171),
          Xi = (e) => {
            let t = Ji(e),
              s = t.find(`${e}--swiper`),
              i = t.find(`${e}--switch`).find("[data-color-index]"),
              a = t.find(`${e}--header`),
              n = t.find(`${e}--desc`),
              l = (Ji(window).width(), null),
              o = new M.ZP(s[0], {
                modules: [M.xW],
                loop: !0,
                centeredSlides: !0,
                slidesPerView: 1,
                effect: "fade",
                on: {
                  init: () => {
                    i.on("click.color", (e) => {
                      o.slideToLoop(e.target.dataset.colorIndex);
                    });
                  },
                  slideChange: (e) => {
                    (a.text(`${e.slides[e.activeIndex].dataset.elementName}`),
                      n.text(`${e.slides[e.activeIndex].dataset.elementDesc}`),
                      ((e) => {
                        let t = i.eq(e);
                        (t.addClass("sill-color__list-item--active"),
                          l && l.removeClass("sill-color__list-item--active"),
                          (l = t));
                      })(e.slides[e.activeIndex].dataset.colorIndex));
                  },
                },
              });
          },
          Ki = s(171),
          Qi = (e) => {
            Ki(e).each(function (e, t) {
              let s = Ki(t).find(".js-common-swiper-slider"),
                i =
                  !!s[0].dataset.swiperBreakpoints &&
                  JSON.parse(s[0].dataset.swiperBreakpoints),
                a = s[0].dataset.swiperPerview
                  ? s[0].dataset.swiperPerview
                  : "auto",
                n = s[0].dataset.swiperBetween
                  ? s[0].dataset.swiperBetween
                  : 20,
                l =
                  !!s[0].dataset.swiperAutoheight &&
                  s[0].dataset.swiperAutoheight,
                o = s[0].dataset.swiperDirection
                  ? s[0].dataset.swiperDirection
                  : "horizontal",
                r =
                  !!s[0].dataset.swiperCentered && s[0].dataset.swiperCentered,
                c = !!s[0].dataset.swiperLoop && s[0].dataset.swiperLoop,
                d = s[0].dataset.swiperSpeed ? s[0].dataset.swiperSpeed : 300,
                m =
                  !!s[0].dataset.swiperAutoplay && s[0].dataset.swiperAutoplay,
                u =
                  !!s[0].dataset.swiperNavigation &&
                  s[0].dataset.swiperNavigation,
                p =
                  !!s[0].dataset.swiperPagination &&
                  s[0].dataset.swiperPagination,
                h = s[0].dataset.swiperEffect
                  ? s[0].dataset.swiperEffect
                  : "slide",
                _ = [];
              (u && _.push(M.W_),
                p && _.push(M.tl),
                m && _.push(M.pt),
                "fade" === h && _.push(M.xW));
              let g = {
                modules: _,
                slidesPerView: a,
                spaceBetween: n,
                breakpoints: i,
                autoHeight: l,
                direction: o,
                centered: r,
                loop: c,
                speed: d,
                navigation: u
                  ? { nextEl: `.${u}-next`, prevEl: `.${u}-prev` }
                  : u,
                pagination: p ? { el: `.${p}`, type: "bullets" } : p,
                autoplay: m ? { delay: m } : m,
                effect: h,
                fadeEffect: "fade" === h && { crossFade: !0 },
                on: {
                  init: () => {
                    (s.removeClass("js-common-swiper--hidden"),
                      s.find(".lds-roller").remove());
                  },
                },
              };
              new M.ZP(s[0], g);
            });
          },
          ea = s(171),
          ta = (e) => {
            const t = ea(e);
            let s = [];
            t.each((e, t) => {
              let i = ea(t).find(".js-actions-carousel-swiper"),
                a = ea(t).find(".js-arrow-left"),
                n = ea(t).find(".js-arrow-right");
              s[e] = new M.ZP(i[0], {
                modules: [M.W_, M.pt, M.Gk],
                spaceBetween: 30,
                slidesPerView: 1.2,
                mousewheel: { forceToAxis: !0, releaseOnEdges: !0 },
                autoplay: { disableOnInteraction: !1, delay: 5e3 },
                breakpoints: {
                  1280: { slidesPerView: 3, autoplay: !1 },
                  1600: { slidesPerView: 4, autoplay: !1 },
                  768: { slidesPerView: 2.2 },
                },
                navigation: { prevEl: a[0], nextEl: n[0] },
                on: {
                  init: () => {},
                },
              });
            });
          },
          sa = s(171);

        class ia {
          constructor(e) {
            ((this.el = e),
              (this.$items = sa(e).find(".js-tender-gallery--items")),
              (this.$sliders = sa(e).find(".js-tender-gallery--slider")),
              (this.$galleryIndex = sa(e).find(".js-tender-gallery--index")),
              (window.ob$galleryIndex = this.$galleryIndex),
              (this.current = {
                gallery: null,
                slider: null,
                sliderIndex: null,
                initModal: null,
              }),
              (window.ob$current = this.current),
              this.eventInit());
          }

          sliderInit() {
            let e = this,
              { current: t, $sliders: s } = this;
            t.slider = new M.ZP(
              s.filter(`[data-slide-index="${t.sliderIndex}"]`)[0],
              {
                modules: [M.W_, M.tl, M.xW, M.pt],
                effect: "fade",
                autoplay: !0,
                speed: 1e3,
                delay: 7e3,
                navigation: {
                  prevEl: t.gallery.find(".js-arrow-left")[0],
                  nextEl: t.gallery.find(".js-arrow-right")[0],
                },
                pagination: {
                  el: t.gallery.find(".js-tender-gallery--pagination")[0],
                  type: "bullets",
                  clickable: !0,
                },
                on: {
                  init() {
                    e.activeSlider();
                  },
                },
              },
            );
          }

          activeSlider() {
            let e = this;
            setTimeout(() => {
              (e.current.gallery.removeClass(
                "tender-gallery-modal__gallery--hidden",
              ),
                e.initProjectNav());
            }, 100);
          }

          eventInit() {
            let e = this,
              { $items: t, $galleryIndex: s, current: i } = this;
            t.on("click", (t) => {
              ((i.sliderIndex = Number(t.target.dataset.slideIndex)),
                (i.initModal = new d.Z({
                  beforeOpen: (t) => {
                    ((i.gallery = s.filter(
                      `[data-gallery-index="${i.sliderIndex}"]`,
                    )),
                      e.sliderInit());
                  },
                  afterClose: (e) => {
                    (i.gallery.addClass(
                      "tender-gallery-modal__gallery--hidden",
                    ),
                      i.slider.destroy());
                  },
                })),
                i.initModal.open("#tender-gallery-modal"));
            });
          }

          initProjectNav() {
            let e = this,
              { $galleryIndex: t, current: s } = this,
              i = s.gallery.find(".js-tender-gallery--next"),
              a = s.gallery.find(".js-tender-gallery--prev");
            (s.sliderIndex
              ? a.off("click.prjPrev").on("click.prjPrev", () => {
                  (s.gallery.addClass("tender-gallery-modal__gallery--hidden"),
                    s.slider.destroy(),
                    (s.sliderIndex = --s.sliderIndex),
                    (s.gallery = t.filter(
                      `[data-gallery-index="${s.sliderIndex}"]`,
                    )),
                    e.sliderInit());
                })
              : a.attr("data-disabled", ""),
              s.sliderIndex < t.length - 1
                ? i.off("click.prjNext").on("click.prjNext", () => {
                    (s.gallery.addClass(
                      "tender-gallery-modal__gallery--hidden",
                    ),
                      s.slider.destroy(),
                      (s.sliderIndex = ++s.sliderIndex),
                      (s.gallery = t.filter(
                        `[data-gallery-index="${s.sliderIndex}"]`,
                      )),
                      e.sliderInit());
                  })
                : i.attr("data-disabled", ""));
          }
        }

        var aa = (e) => new ia(e),
          na = s(600);
        a().use(na.ZP);

        var la = new na.ZP.Store({
            state: {
              configuatorData: [],
              typeWin: {
                "1x": {
                  id: 1,
                  name: "Одностворчатое окно",
                  size: "600 × 900",
                  isActive: !0,
                },
                "2x": {
                  id: 2,
                  name: "Двухстворчатое окно",
                  size: "1300 × 1400",
                  isActive: !1,
                },
                "3x": {
                  id: 3,
                  name: "Трёхстворчатое окно",
                  size: "1750 × 1420",
                  isActive: !1,
                },
                bb: {
                  id: 4,
                  name: "Балконный блок",
                  size: "2150 × 2150",
                  isActive: !1,
                },
              },
              systemList: {
                lite60: { name: "Profecta", isActive: !0, isMassa: !1 },
                //lite70: { name: "Lite`70", isActive: !1, isMassa: !1 },
                //smart: { name: "Smart", isActive: !1, isMassa: !1 },
                evolution: { name: "Provin", isActive: !1, isMassa: !0 },
                //art: { name: "Art", isActive: !1, isMassa: !0 },
                //centum: { name: "Centum", isActive: !1, isMassa: !0, lamination: !0 },
              },
              laminationColor: {
                shock: {
                  name: "шоколадно-коричневый",
                  imgPrefix: "_dark",
                  preview:
                    "/new_style_files/upload/img_verstka/configurator/new/color/dark-shok.jpg",
                  isActive: !0,
                },
                dub: {
                  name: "тёмный дуб",
                  imgPrefix: "_dark",
                  preview:
                    "/new_style_files/upload/img_verstka/configurator/new/color/dark-dub.jpg",
                  isActive: !1,
                },
                oreh: {
                  name: "орех",
                  imgPrefix: "_oak",
                  preview:
                    "/new_style_files/upload/img_verstka/configurator/new/color/oreh.jpg",
                  isActive: !1,
                },
                maha: {
                  name: "махагон",
                  imgPrefix: "_mahgn",
                  preview:
                    "/new_style_files/upload/img_verstka/configurator/new/color/maha.jpg",
                  isActive: !1,
                },
                antra: {
                  name: "антрацитово-серый",
                  imgPrefix: "_antra",
                  preview:
                    "/new_style_files/upload/img_verstka/configurator/new/color/antra.jpg",
                  isActive: !1,
                },
              },
              systemSwitcher: "evolution",
              laminationSwitcher: !1,
              doubleLamination: !1,
              massaSwitcher: !1,
              typeWinSwitcher: "1x",
              typeGlassSwitcher: "one",
              colorSwitcher: "shock",
              isLoadConfigData: !1,
              windowImg: "1x_white",
              altText: "Одностворчатое окно Exprof Lite`60 белое",
              isImgLoad: !1,
              modalSettings: !1,
              modalDescription: !1,
              systemData: [],
            },

            mutations: {
              putPoket(e, t) {
                e.typeGlassSwitcher = t;
              },
              toggleModalDescription(e) {
                e.modalDescription = !e.modalDescription;
              },
              urlImageGen(e) {
                let {
                  laminationSwitcher: t,
                  typeWinSwitcher: s,
                  laminationColor: i,
                  colorSwitcher: a,
                } = e;
                t
                  ? a && (e.windowImg = url + `${s}${i[a].imgPrefix}`)
                  : (e.windowImg = url + `${s}_white`);
              },
              toggleLaminat(e) {
                e.laminationSwitcher = !e.laminationSwitcher;
              },
              onLoadImg(e) {
                e.isImgLoad = !0;
              },
              toggleModalSettings(e) {
                e.modalSettings = !e.modalSettings;
              },
              togglePocket(e, t) {
                "centum" === e.systemSwitcher
                  ? (e.typeGlassSwitcher = "three")
                  : (e.typeGlassSwitcher = t ? "two" : "one");
              },
              toggleDobleLamination(e) {
                e.doubleLamination = !e.doubleLamination;
              },
              toggleMassa(e) {
                e.massaSwitcher = !e.massaSwitcher;
              },
              mainSystem(e) {
                switch (R.pathname) {
                  case "/okna/Exprof-lite60/":
                    e.systemSwitcher = "lite60";
                    break;
                  case "/okna/Exprof-lite70/":
                    e.systemSwitcher = "lite70";
                    break;
                  case "/okna/Exprof-smart/":
                    e.systemSwitcher = "smart";
                    break;
                  case "/okna/Exprof-evolution/":
                    e.systemSwitcher = "evolution";
                    break;
                  case "/okna/Exprof-art/":
                    e.systemSwitcher = "art";
                    break;
                  case "/okna/Exprof-centum/":
                    ((e.systemSwitcher = "centum"),
                      (e.typeGlassSwitcher = "three"));
                }
              },
            },
            actions: {
              getConfiguratorData(e) {
                let { state: t } = e;
                ((t.configuatorData = [
                  {
                    "lite60-l0-m0-s1": {
                      id: "100",
                      type: "1",
                      size: "600x900",
                      system: "lite60",
                      sp: "1",
                      lami: "0",
                      massa: "0",
                      price: "5400",
                      pricemontag: "0",
                    },
                    //"lite70-l0-m0-s1": { id: "101", type: "1", size: "600x900", system: "lite70", sp: "1", lami: "0", massa: "0", price: "9086", pricemontag: "17470" },
                    "evolution-l0-m0-s1": {
                      id: "103",
                      type: "1",
                      size: "600x900",
                      system: "evolution",
                      sp: "1",
                      lami: "0",
                      massa: "0",
                      price: "4590",
                      pricemontag: "0",
                    },
                    //"art-l0-m0-s1": { id: "104", type: "1", size: "600x900", system: "art", sp: "1", lami: "0", massa: "0", price: "12383", pricemontag: "22931" },
                    "lite60-l0-m0-s2": {
                      id: "120",
                      type: "1",
                      size: "600x900",
                      system: "lite60",
                      sp: "2",
                      lami: "0",
                      massa: "0",
                      price: "5940",
                      pricemontag: "16661",
                    },
                    //"lite70-l0-m0-s2": { id: "121", type: "1", size: "600x900", system: "lite70", sp: "2", lami: "0", massa: "0", price: "10086", pricemontag: "17859" },
                    "evolution-l0-m0-s2": {
                      id: "123",
                      type: "1",
                      size: "600x900",
                      system: "evolution",
                      sp: "2",
                      lami: "0",
                      massa: "0",
                      price: "5940",
                      pricemontag: "21572",
                    },
                    //"art-l0-m0-s2": { id: "124", type: "1", size: "600x900", system: "art", sp: "2", lami: "0", massa: "0", price: "12594", pricemontag: "23322" },
                    "lite60-l1-m0-s1": {
                      id: "140",
                      type: "1",
                      size: "600x900",
                      system: "lite60",
                      sp: "1",
                      lami: "1",
                      massa: "0",
                      price: "7020",
                      pricemontag: "0",
                    },
                    //"lite70-l1-m0-s1": { id: "141", type: "1", size: "600x900", system: "lite70", sp: "1", lami: "1", massa: "0", price: "11807", pricemontag: "21864" },
                    "evolution-l1-m0-s1": {
                      id: "143",
                      type: "1",
                      size: "600x900",
                      system: "evolution",
                      sp: "1",
                      lami: "1",
                      massa: "0",
                      price: "5967",
                      pricemontag: "0",
                    },
                    //"art-l1-m0-s1": { id: "144", type: "1", size: "600x900", system: "art", sp: "1", lami: "1", massa: "0", price: "13048", pricemontag: "27603" },
                    "lite60-l1-m0-s2": {
                      id: "160",
                      type: "1",
                      size: "600x900",
                      system: "lite60",
                      sp: "2",
                      lami: "1",
                      massa: "0",
                      price: "7722",
                      pricemontag: "19512",
                    },
                    //"lite70-l1-m0-s2": { id: "161", type: "1", size: "600x900", system: "lite70", sp: "2", lami: "1", massa: "0", price: "10892", pricemontag: "20170" },
                    "evolution-l1-m0-s2": {
                      id: "163",
                      type: "1",
                      size: "600x900",
                      system: "evolution",
                      sp: "2",
                      lami: "1",
                      massa: "0",
                      price: "6318",
                      pricemontag: "24162",
                    },
                    //"art-l1-m0-s2": { id: "164", type: "1", size: "600x900", system: "art", sp: "2", lami: "1", massa: "0", price: "13604", pricemontag: "25192" },
                    "evolution-l1-m1-s1": {
                      id: "180",
                      type: "1",
                      size: "600x900",
                      system: "evolution",
                      sp: "1",
                      lami: "1",
                      massa: "1",
                      price: "11161",
                      pricemontag: "29927",
                    },
                    //"art-l1-m1-s1": { id: "181", type: "1", size: "600x900", system: "art", sp: "1", lami: "1", massa: "1", price: "16863", pricemontag: "31227" },
                    "evolution-l1-m1-s2": {
                      id: "188",
                      type: "1",
                      size: "600x900",
                      system: "evolution",
                      sp: "2",
                      lami: "1",
                      massa: "1",
                      price: "11651",
                      pricemontag: "29422",
                    },
                    //"art-l1-m1-s2": { id: "189", type: "1", size: "600x900", system: "art", sp: "2", lami: "1", massa: "1", price: "17047", pricemontag: "31568" },
                    //"smart-l1-m0-s2": { id: "162", type: "1", size: "600x900", system: "smart", sp: "2", lami: "1", massa: "0", price: "12621", pricemontag: "21490" },
                    //"smart-l1-m0-s1": { id: "142", type: "1", size: "600x900", system: "smart", sp: "1", lami: "1", massa: "0", price: "11605", pricemontag: "23372" },
                    //"smart-l0-m0-s2": { id: "122", type: "1", size: "600x900", system: "smart", sp: "2", lami: "0", massa: "0", price: "10744", pricemontag: "19896" },
                    //"smart-l0-m0-s1": { id: "102", type: "1", size: "600x900", system: "smart", sp: "1", lami: "0", massa: "0", price: "10534", pricemontag: "19507" },
                    //"smart-l1-m1-s2": { id: "122", type: "1", size: "600x900", system: "smart", sp: "2", lami: "1", massa: "1", price: "13421", pricemontag: "19896" },
                    //"smart-l1-m1-s1": { id: "102", type: "1", size: "600x900", system: "smart", sp: "1", lami: "1", massa: "1", price: "12547", pricemontag: "19507" },
                    //"centum-l0-m0-s3": { id: "196", type: "1", size: "600x900", system: "centum", sp: "3", lami: "0", massa: "0", price: "13800", pricemontag: "0" },
                    //"centum-l1-m0-s3": { id: "200", type: "1", size: "600x900", system: "centum", sp: "3", lami: "1", massa: "0", price: "16032", pricemontag: "0" },
                    //"centum-l1-m1-s3": { id: "204", type: "1", size: "600x900", system: "centum", sp: "3", lami: "1", massa: "1", price: "18076", pricemontag: "0" },
                  },
                  {
                    "lite60-l0-m0-s1": {
                      id: "105",
                      type: "2",
                      size: "1300х1400",
                      system: "lite60",
                      sp: "1",
                      lami: "0",
                      massa: "0",
                      price: "16380",
                      pricemontag: "0",
                    },
                    //"lite70-l0-m0-s1": { id: "106", type: "2", size: "1300х1400", system: "lite70", sp: "1", lami: "0", massa: "0", price: "13639", pricemontag: "10532" },
                    "evolution-l0-m0-s1": {
                      id: "108",
                      type: "2",
                      size: "1300х1400",
                      system: "evolution",
                      sp: "1",
                      lami: "0",
                      massa: "0",
                      price: "14560",
                      pricemontag: "0",
                    },
                    //"art-l0-m0-s1": { id: "109", type: "2", size: "1300х1400", system: "art", sp: "1", lami: "0", massa: "0", price: "16982", pricemontag: "14151" },
                    "lite60-l0-m0-s2": {
                      id: "125",
                      type: "2",
                      size: "1300х1400",
                      system: "lite60",
                      sp: "2",
                      lami: "0",
                      massa: "0",
                      price: "17290",
                      pricemontag: "10817",
                    },
                    //"lite70-l0-m0-s2": { id: "126", type: "2", size: "1300х1400", system: "lite70", sp: "2", lami: "0", massa: "0", price: "14098", pricemontag: "11748" },
                    //"smart-l0-m0-s2": { id: "127", type: "2", size: "1300х1400", system: "smart", sp: "2", lami: "0", massa: "0", price: "14844", pricemontag: "12370" },
                    //"smart-l0-m0-s1": { id: "107", type: "2", size: "1300х1400", system: "smart", sp: "1", lami: "0", massa: "0", price: "14382", pricemontag: "11985" },
                    //"smart-l1-m1-s2": { id: "127", type: "2", size: "1300х1400", system: "smart", sp: "2", lami: "1", massa: "1", price: "21801", pricemontag: "12370" },
                    //"smart-l1-m1-s1": { id: "107", type: "2", size: "1300х1400", system: "smart", sp: "1", lami: "1", massa: "1", price: "21108", pricemontag: "11985" },
                    "evolution-l0-m0-s2": {
                      id: "128",
                      type: "2",
                      size: "1300х1400",
                      system: "evolution",
                      sp: "2",
                      lami: "0",
                      massa: "0",
                      price: "15470",
                      pricemontag: "13614",
                    },
                    //"art-l0-m0-s2": { id: "129", type: "2", size: "1300х1400", system: "art", sp: "2", lami: "0", massa: "0", price: "17441", pricemontag: "14534" },
                    "lite60-l1-m0-s1": {
                      id: "145",
                      type: "2",
                      size: "1300х1400",
                      system: "lite60",
                      sp: "1",
                      lami: "1",
                      massa: "0",
                      price: "21294",
                      pricemontag: "0",
                    },
                    //"lite70-l1-m0-s1": { id: "146", type: "2", size: "1300х1400", system: "lite70", sp: "1", lami: "1", massa: "0", price: "15962", pricemontag: "13301" },
                    //"smart-l1-m0-s1": { id: "147", type: "2", size: "1300х1400", system: "smart", sp: "1", lami: "1", massa: "0", price: "16239", pricemontag: "13532" },
                    "evolution-l1-m0-s1": {
                      id: "148",
                      type: "2",
                      size: "1300х1400",
                      system: "evolution",
                      sp: "1",
                      lami: "1",
                      massa: "0",
                      price: "18928",
                      pricemontag: "0",
                    },
                    //"art-l1-m0-s1": { id: "149", type: "2", size: "1300х1400", system: "art", sp: "1", lami: "1", massa: "0", price: "19018", pricemontag: "15848" },
                    "lite60-l1-m0-s2": {
                      id: "165",
                      type: "2",
                      size: "1300х1400",
                      system: "lite60",
                      sp: "2",
                      lami: "1",
                      massa: "0",
                      price: "22477",
                      pricemontag: "12894",
                    },
                    //"lite70-l1-m0-s2": { id: "166", type: "2", size: "1300х1400", system: "lite70", sp: "2", lami: "1", massa: "0", price: "16363", pricemontag: "13635" },
                    // "smart-l1-m0-s2": { id: "167", type: "2", size: "1300х1400", system: "smart", sp: "2", lami: "1", massa: "0", price: "16643", pricemontag: "13869" },
                    "evolution-l1-m0-s2": {
                      id: "168",
                      type: "2",
                      size: "1300х1400",
                      system: "evolution",
                      sp: "2",
                      lami: "1",
                      massa: "0",
                      price: "20111",
                      pricemontag: "15578",
                    },
                    //"art-l1-m0-s2": { id: "169", type: "2", size: "1300х1400", system: "art", sp: "2", lami: "1", massa: "0", price: "19419", pricemontag: "16182" },
                    "evolution-l1-m1-s1": {
                      id: "182",
                      type: "2",
                      size: "1300х1400",
                      system: "evolution",
                      sp: "1",
                      lami: "1",
                      massa: "1",
                      price: "21609",
                      pricemontag: "18007",
                    },
                    // "art-l1-m1-s1": { id: "183", type: "2", size: "1300х1400", system: "art", sp: "1", lami: "1", massa: "1", price: "22328", pricemontag: "18606" },
                    "evolution-l1-m1-s2": {
                      id: "190",
                      type: "2",
                      size: "1300х1400",
                      system: "evolution",
                      sp: "2",
                      lami: "1",
                      massa: "1",
                      price: "22609",
                      pricemontag: "18341",
                    },
                    //"art-l1-m1-s2": { id: "191", type: "2", size: "1300х1400", system: "art", sp: "2", lami: "1", massa: "1", price: "22709", pricemontag: "18924" },
                    //"centum-l0-m0-s3": { id: "197", type: "2", size: "1300х1400", system: "centum", sp: "3", lami: "0", massa: "0", price: "20524", pricemontag: "0" },
                    //"centum-l1-m0-s3": { id: "201", type: "2", size: "1300х1400", system: "centum", sp: "3", lami: "1", massa: "0", price: "23635", pricemontag: "0" },
                    //"centum-l1-m1-s3": { id: "205", type: "2", size: "1300х1400", system: "centum", sp: "3", lami: "1", massa: "1", price: "26892", pricemontag: "0" },
                  },
                  {
                    "lite60-l0-m0-s1": {
                      id: "110",
                      type: "3",
                      size: "1750х1440",
                      system: "lite60",
                      sp: "1",
                      lami: "0",
                      massa: "0",
                      price: "22320",
                      pricemontag: "0",
                    },
                    //"lite70-l0-m0-s1": { id: "111", type: "3", size: "1750х1440", system: "lite70", sp: "1", lami: "0", massa: "0", price: "18872", pricemontag: "10402" },
                    "evolution-l0-m0-s1": {
                      id: "113",
                      type: "3",
                      size: "1750х1440",
                      system: "evolution",
                      sp: "1",
                      lami: "0",
                      massa: "0",
                      price: "19840",
                      pricemontag: "0",
                    },
                    //"art-l0-m0-s1": { id: "114", type: "3", size: "1750х1440", system: "art", sp: "1", lami: "0", massa: "0", price: "25624", pricemontag: "13211" },
                    "lite60-l0-m0-s2": {
                      id: "130",
                      type: "3",
                      size: "1750х1440",
                      system: "lite60",
                      sp: "2",
                      lami: "0",
                      massa: "0",
                      price: "23560",
                      pricemontag: "9972",
                    },
                    //"lite70-l0-m0-s2": { id: "131", type: "3", size: "1750х1440", system: "lite70", sp: "2", lami: "0", massa: "0", price: "19731", pricemontag: "10763" },
                    //"smart-l0-m0-s2": { id: "132", type: "3", size: "1750х1440", system: "smart", sp: "2", lami: "0", massa: "0", price: "21373", pricemontag: "11474" },
                    //"smart-l0-m0-s1": { id: "112", type: "3", size: "1750х1440", system: "smart", sp: "1", lami: "0", massa: "0", price: "20504", pricemontag: "11109" },
                    //"smart-l1-m1-s2": { id: "132", type: "3", size: "1750х1440", system: "smart", sp: "2", lami: "1", massa: "1", price: "33567", pricemontag: "11474" },
                    //"smart-l1-m1-s1": { id: "112", type: "3", size: "1750х1440", system: "smart", sp: "1", lami: "1", massa: "1", price: "32697", pricemontag: "11109" },
                    "evolution-l0-m0-s2": {
                      id: "133",
                      type: "3",
                      size: "1750х1440",
                      system: "evolution",
                      sp: "2",
                      lami: "0",
                      massa: "0",
                      price: "21080",
                      pricemontag: "12513",
                    },
                    //"art-l0-m0-s2": { id: "134", type: "3", size: "1750х1440", system: "art", sp: "2", lami: "0", massa: "0", price: "26483", pricemontag: "13571" },
                    "lite60-l1-m0-s1": {
                      id: "150",
                      type: "3",
                      size: "1750х1440",
                      system: "lite60",
                      sp: "1",
                      lami: "1",
                      massa: "0",
                      price: "29016",
                      pricemontag: "0",
                    },
                    //"lite70-l1-m0-s1": { id: "151", type: "3", size: "1750х1440", system: "lite70", sp: "1", lami: "1", massa: "0", price: "25224", pricemontag: "12378" },
                    //"smart-l1-m0-s1": { id: "152", type: "3", size: "1750х1440", system: "smart", sp: "1", lami: "1", massa: "0", price: "26205", pricemontag: "12769" },
                    "evolution-l1-m0-s1": {
                      id: "153",
                      type: "3",
                      size: "1750х1440",
                      system: "evolution",
                      sp: "1",
                      lami: "1",
                      massa: "0",
                      price: "25792",
                      pricemontag: "0",
                    },
                    //"art-l1-m0-s1": { id: "154", type: "3", size: "1750х1440", system: "art", sp: "1", lami: "1", massa: "0", price: "32379", pricemontag: "14977" },
                    "lite60-l1-m0-s2": {
                      id: "170",
                      type: "3",
                      size: "1750х1440",
                      system: "lite60",
                      sp: "2",
                      lami: "1",
                      massa: "0",
                      price: "30628",
                      pricemontag: "11959",
                    },
                    //"lite70-l1-m0-s2": { id: "171", type: "3", size: "1750х1440", system: "lite70", sp: "2", lami: "1", massa: "0", price: "26083", pricemontag: "12694" },
                    //"smart-l1-m0-s2": { id: "172", type: "3", size: "1750х1440", system: "smart", sp: "2", lami: "1", massa: "0", price: "27075", pricemontag: "13089" },
                    "evolution-l1-m0-s2": {
                      id: "173",
                      type: "3",
                      size: "1750х1440",
                      system: "evolution",
                      sp: "2",
                      lami: "1",
                      massa: "0",
                      price: "27404",
                      pricemontag: "14342",
                    },
                    //"art-l1-m0-s2": { id: "174", type: "3", size: "1750х1440", system: "art", sp: "2", lami: "1", massa: "0", price: "33238", pricemontag: "15292" },
                    "evolution-l1-m1-s1": {
                      id: "184",
                      type: "3",
                      size: "1750х1440",
                      system: "evolution",
                      sp: "1",
                      lami: "1",
                      massa: "1",
                      price: "36515",
                      pricemontag: "17046",
                    },
                    //"art-l1-m1-s1": { id: "185", type: "3", size: "1750х1440", system: "art", sp: "1", lami: "1", massa: "1", price: "39905", pricemontag: "18088" },
                    "evolution-l1-m1-s2": {
                      id: "192",
                      type: "3",
                      size: "1750х1440",
                      system: "evolution",
                      sp: "2",
                      lami: "1",
                      massa: "1",
                      price: "37374",
                      pricemontag: "17361",
                    },
                    //"art-l1-m1-s2": { id: "193", type: "3", size: "1750х1440", system: "art", sp: "2", lami: "1", massa: "1", price: "40764,744", pricemontag: "18403" },
                    //"centum-l0-m0-s3": { id: "198", type: "3", size: "1750х1440", system: "centum", sp: "3", lami: "0", massa: "0", price: "33356", pricemontag: "0" },
                    //"centum-l1-m0-s3": { id: "202", type: "3", size: "1750х1440", system: "centum", sp: "3", lami: "1", massa: "0", price: "40864", pricemontag: "0" },
                    //"centum-l1-m1-s3": { id: "206", type: "3", size: "1750х1440", system: "centum", sp: "3", lami: "1", massa: "1", price: "48098", pricemontag: "0" },
                  },
                  {
                    "lite60-l0-m0-s1": {
                      id: "115",
                      type: "4",
                      size: "1970х2180",
                      system: "lite60",
                      sp: "1",
                      lami: "0",
                      massa: "0",
                      price: "32340",
                      pricemontag: "0",
                    },
                    //"lite70-l0-m0-s1": { id: "116", type: "4", size: "1970х2180", system: "lite70", sp: "1", lami: "0", massa: "0", price: "27494", pricemontag: "11699" },
                    "evolution-l0-m0-s1": {
                      id: "118",
                      type: "4",
                      size: "1970х2180",
                      system: "evolution",
                      sp: "1",
                      lami: "0",
                      massa: "0",
                      price: "27720",
                      pricemontag: "0",
                    },
                    //"art-l0-m0-s1": { id: "119", type: "4", size: "1970х2180", system: "art", sp: "1", lami: "0", massa: "0", price: "36055", pricemontag: "15342" },
                    "lite60-l0-m0-s2": {
                      id: "135",
                      type: "4",
                      size: "1970х2180",
                      system: "lite60",
                      sp: "2",
                      lami: "0",
                      massa: "0",
                      price: "34650",
                      pricemontag: "11422",
                    },
                    //"lite70-l0-m0-s2": { id: "136", type: "4", size: "1970х2180", system: "lite70", sp: "2", lami: "0", massa: "0", price: "28272", pricemontag: "12030" },
                    //"smart-l0-m0-s2": { id: "137", type: "4", size: "1970х2180", system: "smart", sp: "2", lami: "0", massa: "0", price: "30911", pricemontag: "13153" },
                    //"smart-l0-m0-s1": { id: "117", type: "4", size: "1970х2180", system: "smart", sp: "1", lami: "0", massa: "0", price: "30119", pricemontag: "12816" },
                    //"smart-l1-m1-s2": { id: "137", type: "4", size: "1970х2180", system: "smart", sp: "2", lami: "1", massa: "1", price: "47342", pricemontag: "13153" },
                    //"smart-l1-m1-s1": { id: "117", type: "4", size: "1970х2180", system: "smart", sp: "1", lami: "1", massa: "1", price: "46027", pricemontag: "12816" },
                    "evolution-l0-m0-s2": {
                      id: "138",
                      type: "4",
                      size: "1970х2180",
                      system: "evolution",
                      sp: "2",
                      lami: "0",
                      massa: "0",
                      price: "30030",
                      pricemontag: "14298",
                    },
                    //"art-l0-m0-s2": { id: "139", type: "4", size: "1970х2180", system: "art", sp: "2", lami: "0", massa: "0", price: "36833", pricemontag: "15673" },
                    "lite60-l1-m0-s1": {
                      id: "155",
                      type: "4",
                      size: "1970х2180",
                      system: "lite60",
                      sp: "1",
                      lami: "1",
                      massa: "0",
                      price: "42042",
                      pricemontag: "0",
                    },
                    //"lite70-l1-m0-s1": { id: "156", type: "4", size: "1970х2180", system: "lite70", sp: "1", lami: "1", massa: "0", price: "33351", pricemontag: "14191" },
                    //"smart-l1-m0-s1": { id: "157", type: "4", size: "1970х2180", system: "smart", sp: "1", lami: "1", massa: "0", price: "34826", pricemontag: "14819" },
                    "evolution-l1-m0-s1": {
                      id: "158",
                      type: "4",
                      size: "1970х2180",
                      system: "evolution",
                      sp: "1",
                      lami: "1",
                      massa: "0",
                      price: "36036",
                      pricemontag: "0",
                    },
                    //"art-l1-m0-s1": { id: "159", type: "4", size: "1970х2180", system: "art", sp: "1", lami: "1", massa: "0", price: "41287", pricemontag: "17568" },
                    "lite60-l1-m0-s2": {
                      id: "175",
                      type: "4",
                      size: "1970х2180",
                      system: "lite60",
                      sp: "2",
                      lami: "1",
                      massa: "0",
                      price: "45045",
                      pricemontag: "13819",
                    },
                    //"lite70-l1-m0-s2": { id: "176", type: "4", size: "1970х2180", system: "lite70", sp: "2", lami: "1", massa: "0", price: "34032", pricemontag: "14481" },
                    //"smart-l1-m0-s2": { id: "177", type: "4", size: "1970х2180", system: "smart", sp: "2", lami: "1", massa: "0", price: "35518", pricemontag: "15114" },
                    "evolution-l1-m0-s2": {
                      id: "178",
                      type: "4",
                      size: "1970х2180",
                      system: "evolution",
                      sp: "2",
                      lami: "1",
                      massa: "0",
                      price: "39039",
                      pricemontag: "15475",
                    },
                    //"art-l1-m0-s2": { id: "179", type: "4", size: "1970х2180", system: "art", sp: "2", lami: "1", massa: "0", price: "41968", pricemontag: "17858" },
                    "evolution-l1-m1-s1": {
                      id: "186",
                      type: "4",
                      size: "1970х2180",
                      system: "evolution",
                      sp: "1",
                      lami: "1",
                      massa: "1",
                      price: "45887",
                      pricemontag: "19526",
                    },
                    //"art-l1-m1-s1": { id: "187", type: "4", size: "1970х2180", system: "art", sp: "1", lami: "1", massa: "1", price: "48855", pricemontag: "20789" },
                    "evolution-l1-m1-s2": {
                      id: "194",
                      type: "4",
                      size: "1970х2180",
                      system: "evolution",
                      sp: "2",
                      lami: "1",
                      massa: "1",
                      price: "46568",
                      pricemontag: "19816",
                    },
                    //"art-l1-m1-s2": { id: "195", type: "4", size: "1970х2180", system: "art", sp: "2", lami: "1", massa: "1", price: "49535", pricemontag: "21078" },
                    //"centum-l0-m0-s3": { id: "199", type: "4", size: "1970х2180", system: "centum", sp: "3", lami: "0", massa: "0", price: "50931", pricemontag: "0" },
                    //"centum-l1-m0-s3": { id: "203", type: "4", size: "1970х2180", system: "centum", sp: "3", lami: "1", massa: "0", price: "59886", pricemontag: "0" },
                    //"centum-l1-m1-s3": { id: "207", type: "4", size: "1970х2180", system: "centum", sp: "3", lami: "1", massa: "1", price: "71045", pricemontag: "0" },
                  },
                ]),
                  (t.isLoadConfigData = !0));
              },
              async getSystemData(e) {
                let { state: t } = e;
                return R.ajaxGet({ url: "/api/configurator/systems" }).then(
                  (e) => {
                    e.success && (t.systemData = e.data);
                  },
                );
              },
              setSwitcher(e, t) {
                let { state: s } = e;
                ((s.typeWin[s.typeWinSwitcher].isActive = !1),
                  (s.typeWin[t].isActive = !0),
                  (s.typeWinSwitcher = t));
              },
              systemSelect(e, t) {
                let { state: s, commit: i } = e;
                ((s.systemList[s.systemSwitcher].isActive = !1),
                  (s.systemList[t].isActive = !0),
                  (s.systemSwitcher = t));
              },
              colorSelect(e, t) {
                let { state: s, commit: i } = e;
                ((s.laminationColor[s.colorSwitcher].isActive = !1),
                  (s.laminationColor[t].isActive = !0),
                  (s.colorSwitcher = t));
              },
            },

            getters: {
              getWinImage(e) {
                let t,
                  {
                    laminationSwitcher: s,
                    typeWinSwitcher: i,
                    laminationColor: a,
                    colorSwitcher: n,
                  } = e;
                return ((t = a[n].imgPrefix), s ? `${i}${t}` : `${i}_white`);
              },
              getProfileSystem(e) {
                let t = [];
                return (
                  Object.entries(e.systemList).forEach((e) => {
                    t.push({ title: e[1].name, value: e[0] });
                  }),
                  t
                );
              },
              getWinObj(e) {
                let {
                    configuatorData: t,
                    systemSwitcher: s,
                    laminationSwitcher: i,
                    massaSwitcher: a,
                    typeWinSwitcher: n,
                    typeGlassSwitcher: l,
                    isLoadConfigData: o,
                    systemList: r,
                    typeWin: c,
                  } = e,
                  d = {};
                if (o) {
                  let e, o;
                  switch (n) {
                    case "1x":
                      e = 0;
                      break;
                    case "2x":
                      e = 1;
                      break;
                    case "3x":
                      e = 2;
                      break;
                    case "bb":
                      e = 3;
                  }
                  let m = i ? "l1" : "l0",
                    u = a ? "m1" : "m0",
                    p = "one" === l ? "s1" : "s2";
                  ("centum" === s && (p = "s3"),
                    (d = t[e][`${s}-${m}-${u}-${p}`]),
                    (o = `${c[n].name} ${c[n].size} мм`));
                  let h = (e) => {
                      let t = (e = String(e)).substring(e.length - 2),
                        s = 100 * Math.round(e / 100);
                      //return Math.round(t / 100) ? (s += 90) : (s -= 10), s;
                      return e;
                    },
                    _ = Number(d.price); //(Number(d.price)* + 0.1 * Number(d.price)).toFixed(0);
                  //alert(Number(d.price));
                  return {
                    system: `Exprof ${r[s].name}`,
                    title: o,
                    price: h(_),
                  };
                }
                return { system: "", title: "", price: 0 };
              },
              getMassa(e) {
                return !(
                  e.laminationSwitcher &&
                  "lite60" !== e.systemSwitcher &&
                  "lite70" !== e.systemSwitcher
                );
              },
              getWinImg(e) {
                let t,
                  s,
                  {
                    laminationSwitcher: i,
                    typeWinSwitcher: a,
                    laminationColor: n,
                    colorSwitcher: l,
                  } = e,
                  o =
                    "/new_style_files/upload/img_verstka/configurator/new/upd/";
                return (
                  (t = n[l].imgPrefix),
                  (s = i ? `${a}${t}` : `${a}_white`),
                  {
                    hires: `${o}${s}.webp`,
                    x1000: `${o}${s}_2.webp`,
                  }
                );
              },
              getPoket(e) {
                let t = [];
                return (
                  (t =
                    "centum" !== e.systemSwitcher
                      ? [
                          { title: "Однокамерный", value: "one" },
                          { title: "Двухкамерный", value: "two" },
                        ]
                      : [{ title: "Трёхкамерный", value: "three" }]),
                  t
                );
              },
              getSystemInfo(e) {
                let t = 0;
                switch (e.systemSwitcher) {
                  case "lite60":
                    t = 5;
                    break;
                  case "lite70":
                    t = 4;
                    break;
                  case "smart":
                    t = 3;
                    break;
                  case "evolution":
                    t = 2;
                    break;
                  case "art":
                    t = 1;
                    break;
                  case "centum":
                    t = 0;
                }
                return {
                  name: e.systemData[t].name,
                  desc: e.systemData[t].desc_detail,
                  icons: e.systemData[t].icons,
                  schema: e.systemData[t].schema_img,
                };
              },
              getSchemeSM(e) {
                let t = 0;
                if (0 === e.systemData.length)
                  return "/new_style_files/upload/iblock/3ce/8yd3hph4ft1zpma6dvaz82gwpr838q1w/60.svg";
                switch (e.systemSwitcher) {
                  case "lite60":
                    t = 5;
                    break;
                  case "lite70":
                    t = 4;
                    break;
                  case "smart":
                    t = 3;
                    break;
                  case "evolution":
                    t = 2;
                    break;
                  case "art":
                    t = 1;
                    break;
                  case "centum":
                    t = 0;
                }
                return e.systemData[t].img;
              },
            },
          }),
          oa = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return e.isLoadConfigData
              ? t(
                  "div",
                  { staticClass: "configurator__app-vue" },
                  [
                    t("configurator-tabs"),
                    e.configuatorData.length > 0
                      ? t("configurator-view")
                      : e._e(),
                    e.modalSettings ? t("mobile-settings") : e._e(),
                    e.modalDescription ? t("system-description") : e._e(),
                  ],
                  1,
                )
              : t("div", { staticClass: "configurator-loader" }, [e._m(0)]);
          };
        oa._withStripped = !0;
        var ra = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t(
            "div",
            { staticClass: "inner-container configurator__tabs-container" },
            [
              t("div", { staticClass: "configurator__tabs swiper" }, [
                t(
                  "div",
                  { staticClass: "configurator__tabs-wrap swiper-wrapper" },
                  e._l(Object.entries(e.typeWin), function (s, i) {
                    return t(
                      "div",
                      {
                        key: s[0],
                        staticClass: "configurator__tabs-item swiper-slide",
                        class: { active: s[1].isActive },
                        on: {
                          click: function (t) {
                            return e.switchAction(s[0]);
                          },
                        },
                      },
                      [e._v(e._s(s[1].name))],
                    );
                  }),
                  0,
                ),
              ]),
            ],
          );
        };
        ra._withStripped = !0;
        var ca = s(171),
          da = {
            data() {
              return { tabs: null, tabsSlider: null };
            },
            computed: { ...(0, na.rn)(["typeWinSwitcher", "typeWin"]) },
            methods: {
              ...(0, na.nv)(["setSwitcher"]),
              switchAction(e) {
                this.setSwitcher(e);
              },
              initTab() {
                ((this.tabs = ca(".configurator__tabs").find(
                  ".configurator__tabs-item",
                )),
                  (this.tabsSlider = new M.ZP(".configurator__tabs", {
                    slidesPerView: 4,
                    centerInsufficientSlides: !0,
                    breakpoints: {
                      320: { slidesPerView: 2.2, spaceBetween: 10 },
                      600: { slidesPerView: 3.2, spaceBetween: 10 },
                      1024: { slidesPerView: 4, spaceBetween: 10 },
                    },
                  })));
              },
            },
            mounted() {
              (this.initTab(),
                -1 != window.location.href.indexOf("/balkony-i-lodzhii/") &&
                  this.setSwitcher("bb"));
            },
          },
          ma = (0, P.Z)(da, ra, [], !1, null, null, null).exports,
          ua = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t(
              "div",
              { staticClass: "configurator__data" },
              [
                "desktop" == e.screenType
                  ? t("configurator-view-desktop")
                  : e._e(),
                "mobile" == e.screenType
                  ? t("configurator-view-mobile")
                  : e._e(),
              ],
              1,
            );
          };
        ua._withStripped = !0;
        var pa = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t(
            "div",
            { staticClass: "inner-container configurator__data-container" },
            [
              t("div", { staticClass: "configurator__data-row" }, [
                t("div", { staticClass: "configurator__data-col" }, [
                  t("div", { staticClass: "configurator__card" }, [
                    t("div", { staticClass: "configurator__card-image" }, [
                      t(
                        "div",
                        { staticClass: "configurator__card-image-sign" },
                        [
                          e._m(0),
                          "centum" == e.systemSwitcher
                            ? t(
                                "a",
                                {
                                  attrs: {
                                    href: "/about/articles/Exprof-awards-at-MosBuild-2023/",
                                  },
                                },
                                [
                                  t("img", {
                                    staticClass: "sign-ico",
                                    attrs: {
                                      src: "/assets/img/ico/MosBuild.svg",
                                      alt: "",
                                    },
                                  }),
                                ],
                              )
                            : e._e(),
                        ],
                      ),
                      e._m(1),
                      t(
                        "div",
                        { staticClass: "configurator__card-image-wrapper" },
                        [
                          t("img", {
                            staticClass: "img",
                            attrs: {
                              src: e.getWinImg.hires,
                              srcset: `${e.getWinImg.x1000} 1000w`,
                              alt: e.altText,
                            },
                            on: { load: e.onLoadImg },
                          }),
                        ],
                      ),
                    ]),
                  ]),
                ]),
                t("div", { staticClass: "configurator__data-col" }, [
                  t(
                    "div",
                    {
                      staticClass:
                        "configurator__card configurator__card--info",
                    },
                    [
                      t(
                        "div",
                        { staticClass: "configurator__card-description" },
                        [
                          t("div", { staticClass: "configurator__card-name" }, [
                            e._v(e._s(e.getWinObj.system)),
                          ]),
                          t("div", {
                            staticClass: "configurator__card-subname",
                            domProps: { innerHTML: e._s(e.getWinObj.title) },
                          }),
                          t(
                            "div",
                            { staticClass: "configurator__card-price" },
                            [e._v(e._s(e.numFormat(e.getWinObj.price)))],
                          ),
                          t("div", { staticClass: "configurator__card-info" }, [
                            e._v(
                              "* Точная цена будет известна после замера на объекте",
                            ),
                          ]),
                          e._m(2),
                        ],
                      ),
                      t("div", { staticClass: "configurator__card-settings" }, [
                        t("div", { staticClass: "configurator__card-system" }, [
                          t(
                            "div",
                            { staticClass: "configurator__card-title" },
                            [e._v("Профиль Exprof")],
                          ),
                          t(
                            "div",
                            { staticClass: "configurator__card-system-list" },
                            [
                              t("calc-select", {
                                staticClass: "theme-bw",
                                attrs: { data: e.getProfileSystem },
                                model: {
                                  value: e.switchSelect,
                                  callback: function (t) {
                                    e.switchSelect = t;
                                  },
                                  expression: "switchSelect",
                                },
                              }),
                            ],
                            1,
                          ),
                        ]),
                        t("div", { staticClass: "configurator__card-pocket" }, [
                          t(
                            "div",
                            { staticClass: "configurator__card-title" },
                            [e._v("Тип стеклопакета")],
                          ),
                          t(
                            "div",
                            { staticClass: "configurator__card-system-list" },
                            [
                              t("calc-select", {
                                staticClass: "theme-bw",
                                attrs: { data: e.getPoket },
                                model: {
                                  value: e.switchPoket,
                                  callback: function (t) {
                                    e.switchPoket = t;
                                  },
                                  expression: "switchPoket",
                                },
                              }),
                            ],
                            1,
                          ),
                        ]),
                      ]),
                      t(
                        "div",
                        { staticClass: "configurator__card-lamination" },
                        [
                          t(
                            "div",
                            {
                              staticClass:
                                "configurator__card-lamination-switcher",
                            },
                            [
                              t(
                                "div",
                                { staticClass: "configurator__card-title" },
                                [e._v("Ламинация профиля")],
                              ),
                              t(
                                "div",
                                { staticClass: "configurator__card-switch" },
                                [
                                  t("toggle-switcher", {
                                    on: { setCheckboxVal: e.laminationSelect },
                                  }),
                                ],
                                1,
                              ),
                            ],
                          ),
                          t(
                            "div",
                            {
                              staticClass: "configurator__card-switch-group",
                              class: { "no-active": e.getMassa },
                            },
                            [
                              t(
                                "div",
                                { staticClass: "configurator__card-switch" },
                                [
                                  t("check-box", {
                                    staticClass: "checkbox-small--black",
                                    attrs: { label: "Двусторонняя" },
                                    model: {
                                      value: e.switchDoubleLamination,
                                      callback: function (t) {
                                        e.switchDoubleLamination = t;
                                      },
                                      expression: "switchDoubleLamination",
                                    },
                                  }),
                                ],
                                1,
                              ),
                              t(
                                "div",
                                { staticClass: "configurator__card-switch" },
                                [
                                  t("check-box", {
                                    staticClass: "checkbox-small--black",
                                    attrs: { label: "Профиль в массе" },
                                    model: {
                                      value: e.switchMassa,
                                      callback: function (t) {
                                        e.switchMassa = t;
                                      },
                                      expression: "switchMassa",
                                    },
                                  }),
                                ],
                                1,
                              ),
                            ],
                          ),

                          t(
                            "div",
                            {
                              staticClass: "configurator__card-switch-color",
                              class: { "no-active": !e.laminationSwitcher },
                            },
                            [t("color-switcher")],
                            1,
                          ),

                          /*
t("div",{staticClass:"configurator__card-schema",on:{click:function(t){return e.toggleModalDescription()}}},[t("img",{staticClass:"schema",attrs:{src:e.getSchemeSM,alt:"",loading:"lazy"}}),t("div",{staticClass:"configurator__card-schema-link"},[e._v("Чёртеж")])])
*/
                        ],
                      ),
                    ],
                  ),
                ]),
              ]),
            ],
          );
        };
        pa._withStripped = !0;
        var ha = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "calc-select" }, [
            t("input", {
              attrs: { type: "hidden" },
              domProps: { value: e.value },
              on: { input: e.updateSelect },
            }),
            t(
              "div",
              {
                staticClass: "calc-select__arrow",
                on: { click: e.clickSelect },
              },
              [
                t(
                  "svg",
                  {
                    staticClass: "ico",
                    class: { "arrow-up": e.isUpArrow },
                  },
                  [
                    t("use", {
                      attrs: {
                        "xlink:href":
                          "/new_style_files/upload/icon/interface.svg#short-arrow-down",
                      },
                    }),
                  ],
                ),
              ],
            ),
            t(
              "div",
              {
                staticClass: "calc-select__cur-item",
                on: { click: e.clickSelect },
              },
              [
                t("span", { staticClass: "span" }, [
                  e._v(e._s(e.curSelect.title)),
                ]),
              ],
            ),
            t(
              "div",
              {
                ref: "menuList",
                staticClass: "calc-select__list",
              },
              e._l(e.selects, function (s) {
                return t(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: s.show && !s.disable,
                        expression: "sel.show && !sel.disable",
                      },
                    ],
                    key: s.id,
                    staticClass: "calc-select__item",
                    on: {
                      click: function (t) {
                        return e.selectedItem(s);
                      },
                    },
                  },
                  [t("span", { staticClass: "span" }, [e._v(e._s(s.title))])],
                );
              }),
              0,
            ),
          ]);
        };
        ha._withStripped = !0;
        var _a = s(171),
          ga = {
            name: "calc-select",
            props: {
              value: String | Number,
              data: Array,
              disable: Array,
              keyTitle: String,
              keyValue: String,
            },
            data() {
              return {
                elId: c.hash,
                isShowMenu: !1,
                isUpArrow: !1,
                curSelect: this.value,
              };
            },
            computed: {
              selects() {
                return this.formatData();
              },
              isShowAllSelects() {
                return !!this.selects.filter((e) => e.show && !e.disable)
                  .length;
              },
            },
            methods: {
              slideDownMenu() {
                let { menuList: e } = this.$refs;
                C.slideDown({
                  el: e,
                  duration: 150,
                  onStart: () => {
                    this.isUpArrow = !0;
                  },
                });
              },
              slideUpMenu() {
                let { menuList: e } = this.$refs;
                C.slideUp({
                  el: e,
                  duration: 150,
                  onStart: () => {
                    this.isUpArrow = !1;
                  },
                });
              },
              clickSelect() {
                this.isShowMenu = !this.isShowMenu;
              },
              selectedItem(e) {
                ((this.isShowMenu = !1),
                  (this.curSelect.show = !0),
                  (this.curSelect = e),
                  (this.curSelect.show = !1));
              },
              formatData() {
                return this.data.map((e) => {
                  let t = this.keyTitle ? this.keyTitle : "title",
                    s = this.keyValue ? this.keyValue : "value",
                    i = !1;
                  return (
                    this.disable &&
                      this.disable.length &&
                      (i = this.disable.includes(e[s])),
                    {
                      id: c.hash,
                      title: e[t],
                      value: e[s],
                      disable: i,
                      show: !0,
                    }
                  );
                });
              },
              setItem(e) {
                for (let t of this.selects)
                  t.value == e
                    ? ((t.show = !1), (this.curSelect = t))
                    : (t.show = !0);
              },
              updateSelect(e) {
                this.$emit("input", e.target.value);
              },
            },
            mounted() {
              let e = this;
              _a(window).on("click.calc-select", function (t) {
                _a(t.target).closest(e.$el).length || (e.isShowMenu = !1);
              });
            },
            created() {
              this.value
                ? this.setItem(this.value)
                : ((this.curSelect = this.selects[0]),
                  (this.curSelect.show = !1));
            },
            watch: {
              isShowMenu(e) {
                e
                  ? this.isShowAllSelects
                    ? this.slideDownMenu()
                    : (this.isShowMenu = !1)
                  : this.slideUpMenu();
              },
              curSelect(e) {
                this.$emit("input", e.value);
              },
              selects() {
                this.value
                  ? this.setItem(this.value)
                  : ((this.curSelect = this.selects[0]),
                    (this.curSelect.show = !1));
              },
              value(e) {
                this.setItem(e);
              },
              data(e) {
                this.curSelect = e[0];
              },
            },
          },
          wa = (0, P.Z)(ga, ha, [], !1, null, null, null).exports,
          va = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("label", { staticClass: "toggle-switch" }, [
              t("input", {
                staticClass: "toggle-switch__checkbox",
                attrs: { type: "checkbox" },
                on: { click: e.toggleCheckbox },
              }),
              t("span", {
                staticClass:
                  "toggle-switch__slider toggle-switch__slider--round",
              }),
            ]);
          };
        va._withStripped = !0;
        var fa = {
            name: "ToggleSwitcher",
            components: {},
            data() {
              return { toggleStatus: !1 };
            },
            methods: {
              toggleCheckbox() {
                ((this.checkbox = !this.checkbox),
                  this.$emit("setCheckboxVal", this.checkbox));
              },
            },
          },
          ya = (0, P.Z)(fa, va, [], !1, null, null, null).exports,
          ba = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t(
              "ul",
              { staticClass: "color-switcher" },
              e._l(Object.entries(e.laminationColor), function (s, i) {
                return t(
                  "li",
                  {
                    key: i,
                    staticClass: "color-switcher__item",
                    class: { active: s[1].isActive },
                    on: {
                      click: function (t) {
                        return e.toggleColor(s[0]);
                      },
                    },
                  },
                  [
                    t("div", { staticClass: "color-switcher__img" }, [
                      t("img", {
                        staticClass: "img",
                        attrs: { src: s[1].preview, alt: "", loazding: "lazy" },
                      }),
                    ]),
                    t("div", { staticClass: "color-switcher__title" }, [
                      e._v(e._s(s[1].name)),
                    ]),
                  ],
                );
              }),
              0,
            );
          };
        ba._withStripped = !0;
        var ka = {
            name: "ColorSwitcher",
            components: {},
            data() {
              return { colorStatus: "shock" };
            },
            computed: { ...(0, na.rn)(["laminationColor"]) },
            methods: {
              ...(0, na.nv)(["colorSelect"]),
              toggleColor(e) {
                (this.colorSelect(e), this.$emit("setColor", e));
              },
            },
          },
          Ca = (0, P.Z)(ka, ba, [], !1, null, null, null).exports,
          Sa = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("label", { staticClass: "checkbox-small" }, [
              t("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: e.check,
                    expression: "check",
                  },
                ],
                staticClass: "checkbox-small__input",
                attrs: { id: `checkbox-small-${e.hash}`, type: "checkbox" },
                domProps: {
                  checked: Array.isArray(e.check)
                    ? e._i(e.check, null) > -1
                    : e.check,
                },
                on: {
                  change: function (t) {
                    var s = e.check,
                      i = t.target,
                      a = !!i.checked;
                    if (Array.isArray(s)) {
                      var n = e._i(s, null);
                      i.checked
                        ? n < 0 && (e.check = s.concat([null]))
                        : n > -1 &&
                          (e.check = s.slice(0, n).concat(s.slice(n + 1)));
                    } else e.check = a;
                  },
                },
              }),
              t("label", {
                staticClass: "checkbox-small__checkbox",
                attrs: { for: `checkbox-small-${e.hash}` },
              }),
              e.label
                ? t("span", { staticClass: "checkbox-small__label" }, [
                    e._v(e._s(e.label)),
                  ])
                : e._e(),
            ]);
          };
        Sa._withStripped = !0;
        var xa = {
            name: "CheckBox",
            props: { label: String, value: Boolean },
            data() {
              return { check: this.value, hash: c.hash };
            },
            computed: {},
            methods: {
              updateValue(e) {
                this.check = e.target.checked;
              },
            },
            mounted() {},
            watch: {
              check(e) {
                this.$emit("input", e);
              },
            },
          },
          Pa = (0, P.Z)(xa, Sa, [], !1, null, null, null).exports,
          ja = {
            components: {
              CalcSelect: wa,
              ToggleSwitcher: ya,
              ColorSwitcher: Ca,
              CheckBox: Pa,
            },
            data() {
              return {};
            },
            computed: {
              ...(0, na.Se)([
                "getSchemeSM",
                "getPoket",
                "getProfileSystem",
                "getWinImage",
                "getWinObj",
                "getMassa",
                "getWinImg",
              ]),
              ...(0, na.rn)([
                "systemSwitcher",
                "windowImg",
                "altText",
                "isImgLoad",
                "laminationSwitcher",
                "typeGlassSwitcher",
                "doubleLamination",
                "massaSwitcher",
              ]),
              switchSelect: {
                get() {
                  return this.systemSwitcher;
                },
                set(e) {
                  this.systemSelect(e);
                },
              },
              switchPoket: {
                get() {
                  return this.typeGlassSwitcher;
                },
                set(e) {
                  this.putPoket(e);
                },
              },
              switchDoubleLamination: {
                get() {
                  return this.doubleLamination;
                },
                set(e) {
                  this.toggleDobleLamination();
                },
              },
              switchMassa: {
                get() {
                  return this.massaSwitcher;
                },
                set(e) {
                  this.toggleMassa();
                },
              },
            },
            methods: {
              ...(0, na.OI)([
                "toggleModalDescription",
                "putPoket",
                "onLoadImg",
                "toggleLaminat",
                "togglePocket",
                "toggleDobleLamination",
                "switch",
                "toggleMassa",
              ]),
              ...(0, na.nv)(["systemSelect", "colorSelect"]),
              laminationSelect(e) {
                this.toggleLaminat();
              },
              numFormat(e) {
                return c.numFormat(e);
              },
            },
          },
          qa = (0, P.Z)(
            ja,
            pa,
            [
              function () {
                var e = this._self._c;
                this._self._setupProxy;
                return e(
                  "a",
                  {
                    attrs: { href: "/about/articles/catalog-Green-Book-2023/" },
                  },
                  [
                    e("img", {
                      staticClass: "sign-ico",
                      attrs: {
                        src: "/new_style_files/upload/img_verstka/sign-greenbook.svg",
                        alt: "",
                      },
                    }),
                  ],
                );
              },
              function () {
                var e = this,
                  t = e._self._c;
                e._self._setupProxy;
                return t(
                  "div",
                  {
                    staticClass:
                      "configurator__sale-label label-small label-small__sale",
                  },
                  [e._v("-65"), t("span", [e._v("%")])],
                );
              },
              function () {
                var e = this,
                  t = e._self._c;
                e._self._setupProxy;
                return t("div", { staticClass: "configurator__card-buttons" }, [
                  t(
                    "button",
                    {
                      staticClass: "btn",
                      attrs: { "data-modal-window": "#modal-calc-config" },
                    },
                    [e._v("Заказать расчет\t")],
                  ),
                ]);
              },
            ],
            !1,
            null,
            null,
            null,
          ).exports,
          Da = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t(
              "div",
              { staticClass: "inner-container configurator__data-container" },
              [
                t("div", { staticClass: "configurator__card" }, [
                  t("div", { staticClass: "configurator__card-description" }, [
                    t("div", { staticClass: "configurator__card-name" }, [
                      e._v(e._s(e.getWinObj.system)),
                    ]),
                    t("div", {
                      staticClass: "configurator__card-subname",
                      domProps: { innerHTML: e._s(e.getWinObj.title) },
                    }),
                  ]),
                  t("div", { staticClass: "configurator__win-setting" }, [
                    t(
                      "button",
                      {
                        staticClass: "btn btn--small",
                        on: {
                          click: function (t) {
                            return e.toggleModalSettings();
                          },
                        },
                      },
                      [e._v("Настройки")],
                    ),
                  ]),
                  t(
                    "div",
                    {
                      staticClass:
                        "configurator__card-image configurator__card-image--mobile",
                    },
                    [
                      t(
                        "div",
                        { staticClass: "configurator__card-image-sign" },
                        [
                          e._m(0),
                          "centum" == e.systemSwitcher
                            ? t(
                                "a",
                                {
                                  attrs: {
                                    href: "/about/articles/Exprof-awards-at-MosBuild-2023/",
                                  },
                                },
                                [
                                  t("img", {
                                    staticClass: "sign-ico",
                                    attrs: {
                                      src: "/new_style_files/assets/img/ico/MosBuild.svg",
                                      alt: "",
                                    },
                                  }),
                                ],
                              )
                            : e._e(),
                        ],
                      ),
                      e._m(1),
                      t(
                        "div",
                        { staticClass: "configurator__card-image-wrapper" },
                        [
                          t("img", {
                            staticClass: "img",
                            attrs: {
                              src: e.getWinImg.hires,
                              srcset: `${e.getWinImg.x1000} 1000w`,
                              loading: "lazy",
                              decoding: "async",
                              alt: e.altText,
                            },
                            on: { load: e.onLoadImg },
                          }),
                        ],
                      ),
                    ],
                  ),
                  t("div", { staticClass: "configurator__card-description" }, [
                    t("div", { staticClass: "configurator__card-price" }, [
                      e._v(e._s(e.numFormat(e.getWinObj.price))),
                    ]),
                  ]),
                  e._m(2),
                  e._m(3),
                ]),
              ],
            );
          };
        Da._withStripped = !0;
        var La = {
            components: {
              CalcSelect: wa,
              ToggleSwitcher: ya,
              ColorSwitcher: Ca,
              CheckBox: Pa,
            },
            data() {
              return { modalWinSetting: !1 };
            },
            computed: {
              ...(0, na.Se)([
                "getProfileSystem",
                "getWinImage",
                "getWinObj",
                "getWinImg",
              ]),
              ...(0, na.rn)([
                "systemSwitcher",
                "windowImg",
                "altText",
                "isImgLoad",
                "laminationSwitcher",
              ]),
              switchSelect: {
                get() {
                  return this.systemSwitcher;
                },
                set(e) {
                  this.systemSelect(e);
                },
              },
            },
            methods: {
              ...(0, na.OI)([
                "onLoadImg",
                "toggleLaminat",
                "toggleModalSettings",
              ]),
              ...(0, na.nv)(["systemSelect", "colorSelect"]),
              poketSelect(e) {},
              laminationSelect(e) {
                this.toggleLaminat();
              },
              numFormat(e) {
                return c.numFormat(e);
              },
            },
          },
          Ma = (0, P.Z)(
            La,
            Da,
            [
              function () {
                var e = this._self._c;
                this._self._setupProxy;
                return e(
                  "a",
                  {
                    attrs: { href: "/about/articles/catalog-Green-Book-2023/" },
                  },
                  [
                    e("img", {
                      staticClass: "sign-ico",
                      attrs: {
                        src: "/new_style_files/upload/img_verstka/sign-greenbook.svg",
                        alt: "",
                      },
                    }),
                  ],
                );
              },
              function () {
                var e = this,
                  t = e._self._c;
                e._self._setupProxy;
                return t(
                  "div",
                  {
                    staticClass:
                      "configurator__sale-label label-small label-small__sale",
                  },
                  [e._v("-65"), t("span", [e._v("%")])],
                );
              },
              function () {
                var e = this,
                  t = e._self._c;
                e._self._setupProxy;
                return t("div", { staticClass: "configurator__card-buttons" }, [
                  t(
                    "button",
                    {
                      staticClass: "btn",
                      attrs: { "data-modal-window": "#modal-calc-config" },
                    },
                    [e._v("Заказать расчет")],
                  ),
                ]);
              },
              function () {
                var e = this,
                  t = e._self._c;
                e._self._setupProxy;
                return t(
                  "div",
                  { staticClass: "configurator__card-description" },
                  [
                    t("div", { staticClass: "configurator__card-info" }, [
                      e._v(
                        "* Точная цена будет известна после замера на объекте",
                      ),
                    ]),
                  ],
                );
              },
            ],
            !1,
            null,
            null,
            null,
          ).exports,
          $a = s(171),
          za = {
            components: {
              ConfiguratorViewDesktop: qa,
              ConfiguratorViewMobile: Ma,
            },
            data() {
              return { screenWidth: null };
            },
            computed: {
              screenType() {
                return this.screenWidth > 1023 ? "desktop" : "mobile";
              },
            },
            methods: {
              getWindowWidth() {
                let e = this;
                ((this.screenWidth = $a(window).width()),
                  $a(window).on("resize", function () {
                    e.screenWidth = $a(this).width();
                  }));
              },
            },
            mounted() {
              this.getWindowWidth();
            },
          },
          Ea = (0, P.Z)(za, ua, [], !1, null, null, null).exports,
          Fa = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "configurator__mobile-setting" }, [
              t(
                "div",
                {
                  staticClass: "hystmodal modal-win",
                  attrs: {
                    "aria-hidden": "true",
                    id: "configurator-win-settings",
                  },
                },
                [
                  t("div", { staticClass: "hystmodal__wrap modal-win__wrap" }, [
                    t(
                      "div",
                      {
                        staticClass: "hystmodal__window modal-win__window",
                        attrs: { role: "dialog", "aria-modal": "true" },
                      },
                      [
                        t(
                          "div",
                          {
                            staticClass:
                              "modal-win__container configurator__win-settings",
                          },
                          [
                            t(
                              "div",
                              {
                                staticClass: "modal-win__close",
                                attrs: { "data-hystclose": "" },
                              },
                              [
                                t("svg", { staticClass: "ico" }, [
                                  t("use", {
                                    attrs: {
                                      "xlink:href":
                                        "/new_style_files/upload/icon/interface.svg#close",
                                    },
                                  }),
                                ]),
                              ],
                            ),
                            t("div", { staticClass: "modal-win__content" }, [
                              t(
                                "div",
                                { staticClass: "configurator__data-row" },
                                [
                                  t(
                                    "div",
                                    {
                                      staticClass:
                                        "configurator__data-col configurator__data-col--mobile",
                                    },
                                    [
                                      t(
                                        "div",
                                        { staticClass: "configurator__card" },
                                        [
                                          t(
                                            "div",
                                            {
                                              staticClass:
                                                "configurator__card-image",
                                            },
                                            [
                                              t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "configurator__card-image-wrapper",
                                                },
                                                [
                                                  t("img", {
                                                    staticClass: "img",
                                                    attrs: {
                                                      src: e.getWinImg.hires,
                                                      srcset: `${e.getWinImg.x1000} 1000w`,
                                                      alt: e.altText,
                                                    },
                                                    on: { load: e.onLoadImg },
                                                  }),
                                                ],
                                              ),
                                            ],
                                          ),
                                          t(
                                            "div",
                                            {
                                              staticClass:
                                                "configurator__card-description",
                                            },
                                            [
                                              t("div", {
                                                staticClass:
                                                  "configurator__card-subname",
                                                domProps: {
                                                  innerHTML: e._s(
                                                    e.getWinObj.title,
                                                  ),
                                                },
                                              }),
                                              t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "configurator__card-price",
                                                },
                                                [
                                                  e._v(
                                                    e._s(
                                                      e.numFormat(
                                                        e.getWinObj.price,
                                                      ),
                                                    ),
                                                  ),
                                                ],
                                              ),
                                            ],
                                          ),
                                        ],
                                      ),
                                    ],
                                  ),
                                  t(
                                    "div",
                                    { staticClass: "configurator__data-col" },
                                    [
                                      t(
                                        "div",
                                        { staticClass: "configurator__card" },
                                        [
                                          t(
                                            "div",
                                            {
                                              staticClass:
                                                "configurator__card-system",
                                            },
                                            [
                                              t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "configurator__card-title",
                                                },
                                                [
                                                  e._v("Профиль Exprof"),
                                                  t(
                                                    "div",
                                                    {
                                                      staticClass:
                                                        "configurator__card-system-list",
                                                    },
                                                    [
                                                      t("calc-select", {
                                                        staticClass: "theme-bw",
                                                        attrs: {
                                                          data: e.getProfileSystem,
                                                        },
                                                        model: {
                                                          value: e.switchSelect,
                                                          callback: function (
                                                            t,
                                                          ) {
                                                            e.switchSelect = t;
                                                          },
                                                          expression:
                                                            "switchSelect",
                                                        },
                                                      }),
                                                    ],
                                                    1,
                                                  ),
                                                ],
                                              ),
                                            ],
                                          ),
                                          t(
                                            "div",
                                            {
                                              staticClass:
                                                "configurator__card-pocket",
                                            },
                                            [
                                              t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "configurator__card-title",
                                                },
                                                [
                                                  e._v("Тип стеклопакета"),
                                                  t(
                                                    "div",
                                                    {
                                                      staticClass:
                                                        "configurator__card-system-list",
                                                    },
                                                    [
                                                      t("calc-select", {
                                                        staticClass: "theme-bw",
                                                        attrs: {
                                                          data: e.getPoket,
                                                        },
                                                        model: {
                                                          value: e.switchPoket,
                                                          callback: function (
                                                            t,
                                                          ) {
                                                            e.switchPoket = t;
                                                          },
                                                          expression:
                                                            "switchPoket",
                                                        },
                                                      }),
                                                    ],
                                                    1,
                                                  ),
                                                ],
                                              ),
                                            ],
                                          ),
                                          t(
                                            "div",
                                            {
                                              staticClass:
                                                "configurator__card-lamination",
                                            },
                                            [
                                              t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "configurator__card-lamination-switcher",
                                                },
                                                [
                                                  t(
                                                    "div",
                                                    {
                                                      staticClass:
                                                        "configurator__card-title",
                                                    },
                                                    [e._v("Ламинация профиля")],
                                                  ),
                                                  t(
                                                    "div",
                                                    {
                                                      staticClass:
                                                        "configurator__card-switch",
                                                    },
                                                    [
                                                      t("toggle-switcher", {
                                                        on: {
                                                          setCheckboxVal:
                                                            e.laminationSelect,
                                                        },
                                                      }),
                                                    ],
                                                    1,
                                                  ),
                                                ],
                                              ),
                                              t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "configurator__card-switch-group",
                                                  class: {
                                                    "no-active": e.getMassa,
                                                  },
                                                },
                                                [
                                                  t(
                                                    "div",
                                                    {
                                                      staticClass:
                                                        "configurator__card-switch",
                                                    },
                                                    [
                                                      t("check-box", {
                                                        staticClass:
                                                          "checkbox-small--black",
                                                        attrs: {
                                                          label: "Двусторонняя",
                                                        },
                                                        model: {
                                                          value:
                                                            e.switchDoubleLamination,
                                                          callback: function (
                                                            t,
                                                          ) {
                                                            e.switchDoubleLamination =
                                                              t;
                                                          },
                                                          expression:
                                                            "switchDoubleLamination",
                                                        },
                                                      }),
                                                    ],
                                                    1,
                                                  ),
                                                  t(
                                                    "div",
                                                    {
                                                      staticClass:
                                                        "configurator__card-switch",
                                                    },
                                                    [
                                                      t("check-box", {
                                                        staticClass:
                                                          "checkbox-small--black",
                                                        attrs: {
                                                          label:
                                                            "Профиль в массе",
                                                        },
                                                        model: {
                                                          value: e.switchMassa,
                                                          callback: function (
                                                            t,
                                                          ) {
                                                            e.switchMassa = t;
                                                          },
                                                          expression:
                                                            "switchMassa",
                                                        },
                                                      }),
                                                    ],
                                                    1,
                                                  ),
                                                ],
                                              ),
                                              t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "configurator__card-switch-color",
                                                  class: {
                                                    "no-active":
                                                      !e.laminationSwitcher,
                                                  },
                                                },
                                                [t("color-switcher")],
                                                1,
                                              ),
                                            ],
                                          ),
                                          e._m(0),
                                        ],
                                      ),
                                    ],
                                  ),
                                ],
                              ),
                            ]),
                          ],
                        ),
                      ],
                    ),
                  ]),
                ],
              ),
            ]);
          };
        Fa._withStripped = !0;
        var Oa = {
            name: "ModalWinSettings",
            components: {
              CalcSelect: wa,
              ToggleSwitcher: ya,
              ColorSwitcher: Ca,
              CheckBox: Pa,
            },
            data() {
              return { modal: null };
            },
            computed: {
              ...(0, na.Se)([
                "getPoket",
                "getProfileSystem",
                "getWinImage",
                "getWinObj",
                "getMassa",
                "getWinImg",
              ]),
              ...(0, na.rn)([
                "systemSwitcher",
                "windowImg",
                "altText",
                "isImgLoad",
                "laminationSwitcher",
                "modalSettings",
                "typeGlassSwitcher",
                "doubleLamination",
                "massaSwitcher",
              ]),
              switchSelect: {
                get() {
                  return this.systemSwitcher;
                },
                set(e) {
                  this.systemSelect(e);
                },
              },
              switchDoubleLamination: {
                get() {
                  return this.doubleLamination;
                },
                set(e) {
                  this.toggleDobleLamination();
                },
              },
              switchPoket: {
                get() {
                  return this.typeGlassSwitcher;
                },
                set(e) {
                  this.putPoket(e);
                },
              },
              switchMassa: {
                get() {
                  return this.massaSwitcher;
                },
                set(e) {
                  this.toggleMassa();
                },
              },
            },
            methods: {
              ...(0, na.OI)([
                "onLoadImg",
                "toggleLaminat",
                "toggleModalSettings",
                "togglePocket",
                "toggleDobleLamination",
                "switch",
                "toggleMassa",
              ]),
              ...(0, na.nv)(["systemSelect", "colorSelect"]),
              poketSelect(e) {
                this.togglePocket(e);
              },
              laminationSelect(e) {
                this.toggleLaminat();
              },
              numFormat(e) {
                return c.numFormat(e);
              },
            },
            mounted() {
              ((this.modal = new d.Z({
                linkAttributeName: "configurator-win-settings",
                beforeOpen: () => {},
                afterClose: () => {
                  (this.$emit("onClose"), this.toggleModalSettings());
                },
              })),
                this.modal.open("#configurator-win-settings"));
            },
          },
          Ta = (0, P.Z)(
            Oa,
            Fa,
            [
              function () {
                var e = this,
                  t = e._self._c;
                e._self._setupProxy;
                return t("div", { staticClass: "configurator__card-buttons" }, [
                  t(
                    "div",
                    {
                      staticClass: "btn",
                      attrs: { "data-hystclose": "" },
                    },
                    [e._v("ОК")],
                  ),
                ]);
              },
            ],
            !1,
            null,
            null,
            null,
          ).exports,
          Ba = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t(
              "div",
              { staticClass: "configurator__system-description" },
              [
                t(
                  "div",
                  {
                    staticClass: "hystmodal modal-win",
                    attrs: {
                      "aria-hidden": "true",
                      id: "configurator-system-description",
                    },
                  },
                  [
                    t(
                      "div",
                      { staticClass: "hystmodal__wrap modal-win__wrap" },
                      [
                        t(
                          "div",
                          {
                            staticClass:
                              "hystmodal__window modal-win__window configurator__system-description-modal",
                            attrs: { role: "dialog", "aria-modal": "true" },
                          },
                          [
                            t(
                              "div",
                              {
                                staticClass:
                                  "modal-win__container configurator__description",
                              },
                              [
                                t(
                                  "div",
                                  {
                                    staticClass: "modal-win__close",
                                    attrs: { "data-hystclose": "" },
                                  },
                                  [
                                    t("svg", { staticClass: "ico" }, [
                                      t("use", {
                                        attrs: {
                                          "xlink:href":
                                            "/new_style_files/upload/icon/interface.svg#close",
                                        },
                                      }),
                                    ]),
                                  ],
                                ),
                                t(
                                  "div",
                                  { staticClass: "modal-win__content" },
                                  [
                                    t(
                                      "div",
                                      { staticClass: "configurator__data-row" },
                                      [
                                        t(
                                          "div",
                                          {
                                            staticClass:
                                              "configurator__data-col",
                                          },
                                          [
                                            t(
                                              "div",
                                              {
                                                staticClass:
                                                  "configurator__card",
                                              },
                                              [
                                                t(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "configurator__card-description",
                                                  },
                                                  [
                                                    t(
                                                      "div",
                                                      {
                                                        staticClass:
                                                          "configurator__card-name",
                                                      },
                                                      [
                                                        e._v(
                                                          e._s(
                                                            e.getSystemInfo
                                                              .name,
                                                          ),
                                                        ),
                                                      ],
                                                    ),
                                                    t(
                                                      "div",
                                                      {
                                                        staticClass:
                                                          "configurator__card-text",
                                                      },
                                                      [
                                                        e._v(
                                                          e._s(
                                                            e.getSystemInfo
                                                              .desc,
                                                          ),
                                                        ),
                                                      ],
                                                    ),
                                                  ],
                                                ),
                                                t(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "configurator__card-icons",
                                                  },
                                                  e._l(
                                                    e.getSystemInfo.icons,
                                                    function (s, i) {
                                                      return t(
                                                        "div",
                                                        {
                                                          key: i,
                                                          staticClass:
                                                            "configurator__card-items",
                                                        },
                                                        [
                                                          t("img", {
                                                            staticClass: "ico",
                                                            attrs: {
                                                              src: s.url,
                                                              alt: "",
                                                            },
                                                          }),
                                                          t("div", {
                                                            staticClass:
                                                              "configurator__card-item-desc",
                                                            domProps: {
                                                              innerHTML: e._s(
                                                                s.desc,
                                                              ),
                                                            },
                                                          }),
                                                        ],
                                                      );
                                                    },
                                                  ),
                                                  0,
                                                ),
                                                e._m(0),
                                              ],
                                            ),
                                          ],
                                        ),
                                        t(
                                          "div",
                                          {
                                            staticClass:
                                              "configurator__data-col",
                                          },
                                          [
                                            t(
                                              "div",
                                              {
                                                staticClass:
                                                  "configurator__card",
                                              },
                                              [
                                                t("img", {
                                                  staticClass: "img",
                                                  attrs: {
                                                    src: e.getSystemInfo.schema,
                                                  },
                                                }),
                                              ],
                                            ),
                                          ],
                                        ),
                                      ],
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          ],
                        ),
                      ],
                    ),
                  ],
                ),
              ],
            );
          };
        Ba._withStripped = !0;
        var Ia = {
            name: "SystemDescription",
            components: {},
            data() {
              return { modal: null };
            },
            computed: { ...(0, na.Se)(["getSystemInfo"]) },
            methods: { ...(0, na.OI)(["toggleModalDescription"]) },
            mounted() {
              ((this.modal = new d.Z({
                linkAttributeName: "configurator-system-description",
                beforeOpen: () => {},
                afterClose: () => {
                  (this.$emit("onClose"), this.toggleModalDescription());
                },
              })),
                this.modal.open("#configurator-system-description"));
            },
          },
          Wa = {
            components: {
              ConfiguratorTabs: ma,
              ConfiguratorView: Ea,
              MobileSettings: Ta,
              SystemDescription: (0, P.Z)(
                Ia,
                Ba,
                [
                  function () {
                    var e = this,
                      t = e._self._c;
                    e._self._setupProxy;
                    return t(
                      "div",
                      { staticClass: "configurator__card-buttons" },
                      [
                        t(
                          "div",
                          {
                            staticClass: "btn btn--large",
                            attrs: { "data-hystclose": "" },
                          },
                          [e._v("Отлично всё понятно")],
                        ),
                      ],
                    );
                  },
                ],
                !1,
                null,
                null,
                null,
              ).exports,
            },
            data() {
              return { typeList: [] };
            },
            computed: {
              ...(0, na.rn)([
                "modalDescription",
                "configuatorData",
                "isLoadConfigData",
                "modalSettings",
              ]),
              ...(0, na.OI)(["mainSystem"]),
            },
            methods: {
              ...(0, na.nv)(["getConfiguratorData", "getSystemData"]),
            },
            mounted() {
              (this.getConfiguratorData(),
                this.mainSystem,
                this.getSystemData());
            },
          },
          Aa = (0, P.Z)(
            Wa,
            oa,
            [
              function () {
                var e = this._self._c;
                this._self._setupProxy;
                return e("div", { staticClass: "lds-roller" }, [
                  e("div"),
                  e("div"),
                  e("div"),
                  e("div"),
                  e("div"),
                  e("div"),
                  e("div"),
                  e("div"),
                ]);
              },
            ],
            !1,
            null,
            null,
            null,
          ).exports,
          Va = (e) => new (a())({ el: e, store: la, render: (e) => e(Aa) }),
          Na = s(171);
        a().use(na.ZP);
        var Za = new na.ZP.Store({
            state: {
              option: {},
              dataSpecif: [
                { code: "depth", title: "Монтажная ширина, мм" },
                {
                  code: "width",
                  title: "Стеклопакет, мм",
                },
                { code: "count_cam", title: "Воздушные камеры" },
                {
                  code: "thermal_coef",
                  title: "Теплозащита, м2·°С/Вт",
                },
                { code: "body_color", title: "Цвет массы профиля" },
                {
                  code: "seal_color",
                  title: "Цвет уплотнителя",
                },
                { code: "system_class", title: "Класс системы" },
                { code: "price", title: "Цена, руб/м²" },
              ],
              dataSystem: [
                {
                  id: c.hash,
                  name: "Exprof Smart",
                  name_short: "Exprof Smart",
                  desc: "Классические теплые окна 60й серии",
                  img: "/new_style_files/assets/img/res/assort-Exprof/Exprof-smart.svg",
                  depth: "60",
                  width: "24/32",
                  count_cam: { num: "4/4/4", info: "(рама/створка/импост)" },
                  body_color: ["#FFFFFF", "#A56820"],
                  thermal_coef: "0.88",
                  system_class: "класс «А»",
                  life_time: "200",
                  seal_color: ["#FFFFFF", "#C4C4C4", "#00171F"],
                  price: "9680",
                  stock: "",
                },
                {
                  id: c.hash,
                  name: "Exprof Evolution",
                  name_short: "Exprof Evo",
                  desc: "Оптимальные окна по соотношению/качество",
                  img: "/new_style_files/assets/img/res/assort-Exprof/Exprof-evo.svg",
                  depth: "70",
                  width: "32/40",
                  count_cam: { num: "5/5/5", info: "(рама/створка/импост)" },
                  body_color: ["#FFFFFF", "#A56820", "#2E1F12", "#474747"],
                  thermal_coef: "1.06",
                  system_class: "класс «А»",
                  life_time: "200",
                  seal_color: ["#FFFFFF", "#C4C4C4", "#00171F"],
                  price: "15684",
                  stock: "Хит продаж",
                },
                {
                  id: c.hash,
                  name: "Exprof Art",
                  name_short: "Exprof Art",
                  desc: "Эксклюзивные окна для ценителей тепла и дизайна",
                  img: "/new_style_files/assets/img/res/assort-Exprof/Exprof-art.svg",
                  depth: "70",
                  width: "32/40",
                  count_cam: { num: "5/6/5", info: "(рама/створка/импост)" },
                  body_color: ["#FFFFFF", "#A56820", "#2E1F12", "#474747"],
                  thermal_coef: "1.08",
                  system_class: "класс «А»",
                  life_time: "200",
                  seal_color: ["#FFFFFF", "#C4C4C4", "#00171F"],
                  price: "25654",
                  stock: "",
                },
                {
                  id: c.hash,
                  name: "Exprof Smart 2",
                  name_short: "Exprof Smart 2",
                  desc: "Классические теплые окна 60й серии",
                  img: "/new_style_files/assets/img/res/assort-Exprof/Exprof-smart.svg",
                  depth: "60",
                  width: "24/32",
                  count_cam: { num: "4/4/4", info: "(рама/створка/импост)" },
                  body_color: ["#FFFFFF", "#A56820"],
                  thermal_coef: "0.88",
                  system_class: "класс «А»",
                  life_time: "200",
                  seal_color: ["#FFFFFF", "#C4C4C4", "#00171F"],
                  price: "9680",
                  stock: "",
                },
                {
                  id: c.hash,
                  name: "Exprof Evolution 2",
                  name_short: "Exprof Evo 2",
                  desc: "Оптимальные окна по соотношению/качество",
                  img: "/new_style_files/assets/img/res/assort-Exprof/Exprof-evo.svg",
                  depth: "70",
                  width: "32/40",
                  count_cam: { num: "5/5/5", info: "(рама/створка/импост)" },
                  body_color: ["#FFFFFF", "#A56820", "#2E1F12", "#474747"],
                  thermal_coef: "1.06",
                  system_class: "класс «А»",
                  life_time: "200",
                  seal_color: ["#FFFFFF", "#C4C4C4", "#00171F"],
                  price: "15684",
                  stock: "Хит продаж",
                },
                {
                  id: c.hash,
                  name: "Exprof Art 2",
                  name_short: "Exprof Art 2",
                  desc: "Эксклюзивные окна для ценителей тепла и дизайна",
                  img: "/new_style_files/assets/img/res/assort-Exprof/Exprof-art.svg",
                  depth: "70",
                  width: "32/40",
                  count_cam: { num: "5/6/5", info: "(рама/створка/импост)" },
                  body_color: ["#FFFFFF", "#A56820", "#2E1F12", "#474747"],
                  thermal_coef: "1.08",
                  system_class: "класс «А»",
                  life_time: "200",
                  seal_color: ["#FFFFFF", "#C4C4C4", "#00171F"],
                  price: "25654",
                  stock: "",
                },
              ],
            },
            mutations: {},
            actions: {
              async getData(e, t) {
                let { state: s } = e,
                  i = Na(t.$el).closest("[data-action]").data("action");
                (i && (s.dataSystem = []),
                  i &&
                    R.ajaxGet({ url: i }).then((e) => {
                      e?.success && (s.dataSystem = e.data);
                    }));
              },
              getOption(e, t) {
                let { state: s } = e,
                  i = Na(t.$el).closest("[data-option]").data("option");
                i && "object" == typeof i && (s.option = i);
              },
            },
          }),
          Ra = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "assort-Exprof__vue-app" }, [
              "desktop" == e.typeDevice
                ? t(
                    "div",
                    { staticClass: "assort-Exprof__desktop" },
                    [t("assort-Exprof-desktop")],
                    1,
                  )
                : e._e(),
              "mobile" == e.typeDevice
                ? t(
                    "div",
                    { staticClass: "assort-Exprof__mobile" },
                    [t("assort-Exprof-mob")],
                    1,
                  )
                : e._e(),
            ]);
          };
        Ra._withStripped = !0;
        var Ua = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t(
            "div",
            {
              staticClass: "assort-Exprof__table",
              class: { "no-head-img": e.option["no-head-img"] },
            },
            [
              t(
                "div",
                { staticClass: "assort-Exprof__table-container" },
                e._l(e.dataSystem, function (s, i) {
                  return t("assort-Exprof-item", {
                    key: s.id,
                    class: {
                      "last-item": i == e.dataSystem.length - 1,
                      accent: s.stock && e.option["hit-accent"],
                    },
                    attrs: { sys: s },
                  });
                }),
                1,
              ),
            ],
          );
        };
        Ua._withStripped = !0;
        var Ga = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "assort-Exprof__item" }, [
            t("div", { staticClass: "assort-Exprof__item-head" }, [
              e.option["no-head-img"]
                ? e._e()
                : t("div", { staticClass: "assort-Exprof__item-img" }, [
                    t("img", {
                      staticClass: "img",
                      attrs: {
                        src: e.sys.img,
                        alt: `Оконный профиль ${e.sys.name.toLowerCase()}`,
                        decoding: "async",
                        loading: "lazy",
                      },
                    }),
                  ]),
              t("div", { staticClass: "assort-Exprof__item-text" }, [
                t("div", { staticClass: "h4 assort-Exprof__item-title" }, [
                  e._v(e._s(e.sys.name)),
                ]),
                t("p", {
                  staticClass: "assort-Exprof__item-desc",
                  domProps: { innerHTML: e._s(e.sys.desc) },
                }),
              ]),
              t("div", { staticClass: "assort-Exprof__item-label" }, [
                e.sys.stock
                  ? t(
                      "div",
                      { staticClass: "label-small assort-Exprof__item-stock" },
                      [e._v(e._s(e.sys.stock))],
                    )
                  : e._e(),
              ]),
              t("a", {
                staticClass: "no-style assort-Exprof__item-link",
                attrs: {
                  href: e.sys.url,
                  "aria-label": `Ссылка на страницу ${e.sys.name}`,
                },
              }),
            ]),
            t(
              "div",
              { staticClass: "assort-Exprof__item-body" },
              e._l(e.dataSpecif, function (s) {
                return t("div", { staticClass: "assort-Exprof__row" }, [
                  "price" == s.code
                    ? t(
                        "div",
                        {
                          staticClass: "assort-Exprof__item-data",
                          class: `row-${s.code}`,
                        },
                        [
                          t("div", [e._v(e._s(e.getMoney(e.sys[s.code])))]),
                          t("div", [e._v(e._s(s.title))]),
                          t("a", { attrs: { href: e.sys.url } }, [
                            e._v("Подробнее"),
                          ]),
                        ],
                      )
                    : "count_cam" == s.code
                      ? t("div", { staticClass: "assort-Exprof__item-data" }, [
                          t("div", { staticClass: "assort-Exprof__item-cam" }, [
                            e._v(e._s(e.sys[s.code].num)),
                            t(
                              "span",
                              {
                                ref: "tippy",
                                refInFor: !0,
                                staticClass: "helper-info",
                              },
                              [e._v("?")],
                            ),
                          ]),
                          t("div", [e._v(e._s(s.title))]),
                        ])
                      : "body_color" == s.code || "seal_color" == s.code
                        ? t(
                            "div",
                            { staticClass: "assort-Exprof__item-data" },
                            [
                              t("color-palette", {
                                attrs: { colors: e.sys[s.code] },
                              }),
                              t("div", [e._v(e._s(s.title))]),
                            ],
                            1,
                          )
                        : t(
                            "div",
                            { staticClass: "assort-Exprof__item-data" },
                            [
                              t("div", [e._v(e._s(e.sys[s.code]))]),
                              t("div", [e._v(e._s(s.title))]),
                            ],
                          ),
                ]);
              }),
              0,
            ),
          ]);
        };
        Ga._withStripped = !0;
        var Ha = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "color-palette" }, [
            t(
              "div",
              { staticClass: "color-palette__wrap" },
              e._l(e.colors, function (e) {
                return t("div", {
                  staticClass: "color-palette__item",
                  style: { backgroundColor: e },
                });
              }),
              0,
            ),
          ]);
        };
        Ha._withStripped = !0;
        var Ya = {
            name: "color-palette",
            props: { colors: Array },
            data() {
              return {};
            },
          },
          Ja = (0, P.Z)(Ya, Ha, [], !1, null, null, null).exports,
          Xa = {
            name: "assort-Exprof-item",
            components: { ColorPalette: Ja },
            props: ["sys"],
            data() {
              return { tippy: [], items: [] };
            },
            computed: { ...(0, na.rn)(["dataSpecif", "dataSystem", "option"]) },
            methods: {
              getMoney(e) {
                return c.getMoney(e);
              },
              initInfo() {
                (0, Oe.ZP)(this.$refs.tippy[0], {
                  hideOnClick: !0,
                  trigger: "click",
                  maxWidth: "200px",
                  content: "Воздушные камеры в раме/створке/импосте",
                });
              },
            },
            mounted() {
              this.initInfo();
            },
            watch: {},
          },
          Ka = {
            name: "assort-Exprof-desktop",
            components: {
              AssortExprofItem: (0, P.Z)(Xa, Ga, [], !1, null, null, null)
                .exports,
            },
            data() {
              return { tippy: [], items: [] };
            },
            computed: { ...(0, na.rn)(["dataSpecif", "dataSystem", "option"]) },
            methods: {
              getMoney(e) {
                return c.getMoney(e);
              },
            },
            mounted() {},
            watch: {},
          },
          Qa = (0, P.Z)(Ka, Ua, [], !1, null, null, null).exports,
          en = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "assort-Exprof-mob" }, [
              t("div", { staticClass: "assort-Exprof-mob__head" }, [
                t(
                  "div",
                  { staticClass: "assort-Exprof-mob__head-item" },
                  [
                    t("select-sys-mob", {
                      attrs: {
                        label: "name_short",
                        options: e.dataSystem,
                      },
                      model: {
                        value: e.selSysOne,
                        callback: function (t) {
                          e.selSysOne = t;
                        },
                        expression: "selSysOne",
                      },
                    }),
                  ],
                  1,
                ),
                t(
                  "div",
                  { staticClass: "assort-Exprof-mob__head-item" },
                  [
                    t("select-sys-mob", {
                      attrs: {
                        label: "name_short",
                        options: e.dataSystem,
                      },
                      model: {
                        value: e.selSysTwo,
                        callback: function (t) {
                          e.selSysTwo = t;
                        },
                        expression: "selSysTwo",
                      },
                    }),
                  ],
                  1,
                ),
              ]),
              t(
                "div",
                { staticClass: "assort-Exprof-mob__table" },
                e._l(e.dataSpecif, function (s) {
                  return t("div", { staticClass: "assort-Exprof-mob__item" }, [
                    t("div", { staticClass: "assort-Exprof-mob__label" }, [
                      e._v(e._s(s.title)),
                    ]),
                    t("div", { staticClass: "assort-Exprof-mob__specif" }, [
                      t("div", { staticClass: "assort-Exprof-mob__variable" }, [
                        "price" == s.code
                          ? t(
                              "span",
                              {
                                staticClass: "span",
                                class: `row-${s.code}`,
                              },
                              [e._v(e._s(e.getMoney(e.selSysOne[s.code])))],
                            )
                          : "count_cam" == s.code
                            ? t("span", { staticClass: "span" }, [
                                e._v(e._s(e.selSysOne[s.code].num)),
                              ])
                            : "body_color" == s.code || "seal_color" == s.code
                              ? t(
                                  "span",
                                  { staticClass: "span" },
                                  [
                                    t("color-palette", {
                                      attrs: { colors: e.selSysOne[s.code] },
                                    }),
                                  ],
                                  1,
                                )
                              : t("span", { staticClass: "span" }, [
                                  e._v(e._s(e.selSysOne[s.code])),
                                ]),
                      ]),
                      t("div", { staticClass: "assort-Exprof-mob__variable" }, [
                        "price" == s.code
                          ? t(
                              "span",
                              {
                                staticClass: "span",
                                class: `row-${s.code}`,
                              },
                              [e._v(e._s(e.getMoney(e.selSysTwo[s.code])))],
                            )
                          : "count_cam" == s.code
                            ? t("span", { staticClass: "span" }, [
                                e._v(e._s(e.selSysTwo[s.code].num)),
                              ])
                            : "body_color" == s.code || "seal_color" == s.code
                              ? t(
                                  "span",
                                  { staticClass: "span" },
                                  [
                                    t("color-palette", {
                                      attrs: { colors: e.selSysTwo[s.code] },
                                    }),
                                  ],
                                  1,
                                )
                              : t("span", { staticClass: "span" }, [
                                  e._v(e._s(e.selSysTwo[s.code])),
                                ]),
                      ]),
                    ]),
                  ]);
                }),
                0,
              ),
            ]);
          };
        en._withStripped = !0;
        var tn = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t(
            "div",
            {
              staticClass: "select-sys-mob",
              class: { "select-open": e.isOpenList },
              on: {
                click: function (t) {
                  e.isOpenList = !e.isOpenList;
                },
              },
            },
            [
              t("div", { staticClass: "select-sys-mob__label" }, [
                e._v(e._s(e.selSys[e.label])),
              ]),
              t("div", { staticClass: "select-sys-mob__arrow" }),
              t(
                "div",
                {
                  ref: "menuList",
                  staticClass: "select-sys-mob__list",
                },
                e._l(e.options, function (s, i) {
                  return t(
                    "div",
                    {
                      directives: [
                        {
                          name: "show",
                          rawName: "v-show",
                          value: e.selSys.id != s.id,
                          expression: "selSys.id!=opt.id",
                        },
                      ],
                      key: s.id,
                      staticClass: "select-sys-mob__item",
                      on: {
                        click: function (t) {
                          return e.selectedSys(s);
                        },
                      },
                    },
                    [e._v(e._s(s[e.label]))],
                  );
                }),
                0,
              ),
            ],
          );
        };
        tn._withStripped = !0;
        var sn = s(171),
          an = {
            name: "select-sys-mob",
            props: { value: Object, label: String, options: Array },
            data() {
              return { isOpenList: !1, selSys: this.value };
            },
            computed: {},
            methods: {
              clickOutside() {
                sn(window).on("click.select_sys_mob", (e) => {
                  !!sn(e.target).closest(this.$el).length ||
                    (this.isOpenList = !1);
                });
              },
              slideDownMenu() {
                let { menuList: e } = this.$refs;
                C.slideDown({
                  el: e,
                  duration: 150,
                  onStop(e) {
                    sn(e).css({ height: "" });
                  },
                });
              },
              slideUpMenu() {
                let { menuList: e } = this.$refs;
                C.slideUp({
                  el: e,
                  duration: 150,
                  maxHeight: "",
                  onStart: () => {},
                });
              },
              selectedSys(e) {
                this.selSys = e;
              },
            },
            created() {
              this.clickOutside();
            },
            watch: {
              isOpenList(e) {
                e ? this.slideDownMenu() : this.slideUpMenu();
              },
              selSys(e) {
                this.$emit("input", e);
              },
            },
          },
          nn = {
            name: "assort-Exprof-mob",
            components: {
              ColorPalette: Ja,
              SelectSysMob: (0, P.Z)(an, tn, [], !1, null, null, null).exports,
            },
            data() {
              return { selSysOne: "", selSysTwo: "" };
            },
            computed: { ...(0, na.rn)(["dataSpecif", "dataSystem"]) },
            methods: {
              getMoney(e) {
                return c.getMoney(e);
              },
            },
            created() {
              ((this.selSysOne = this.dataSystem[0]),
                (this.selSysTwo = this.dataSystem[1]));
            },
          },
          ln = (0, P.Z)(nn, en, [], !1, null, null, null).exports,
          on = s(171),
          rn = {
            components: { AssortExprofMob: ln, AssortExprofDesktop: Qa },
            data() {
              return { winWidth: on(window).width() };
            },
            computed: {
              typeDevice() {
                return this.winWidth < 768 ? "mobile" : "desktop";
              },
            },
            methods: {
              ...(0, na.nv)(["getData", "getOption"]),
              resizeWindow() {
                let e = this;
                on(window).on("resize.assort_Exprof", () => {
                  c.actionFilter({
                    keyTimer: "resize-win-assort-Exprof",
                    duration: 100,
                    action() {
                      e.winWidth = on(window).width();
                    },
                  });
                });
              },
            },
            mounted() {
              (this.getData(this), this.getOption(this));
            },
            created() {
              this.resizeWindow();
            },
            watch: {
              typeDevice() {},
            },
          },
          cn = (0, P.Z)(rn, Ra, [], !1, null, null, null).exports,
          dn = (e) => new (a())({ el: e, store: Za, render: (e) => e(cn) });
        a().use(na.ZP);
        var mn = new na.ZP.Store({
            state: { winSelData: [], isWinSelData: !1 },
            mutations: {},
            actions: {
              async getData(e) {
                let { state: t } = e;
                R.hostname;
                return R.ajaxGet({
                  url: "/ajax/?controller=systems&action=getselectiondata",
                }).then((e) => {
                  e?.success &&
                    ((t.winSelData = e.data), (t.isWinSelData = !0));
                });
              },
            },
          }),
          un = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("section", { staticClass: "winsel-param" }, [
              t(
                "div",
                { staticClass: "inner-container winsel-param__container" },
                [
                  t("h2", { staticClass: "h2 winsel-param__head-title" }, [
                    e._v("Подбор окна по параметрам"),
                  ]),
                  t(
                    "div",
                    { staticClass: "winsel-param__sample-panel" },
                    [
                      t("sample-panel", {
                        model: {
                          value: e.sampleCode,
                          callback: function (t) {
                            e.sampleCode = t;
                          },
                          expression: "sampleCode",
                        },
                      }),
                    ],
                    1,
                  ),
                  t(
                    "div",
                    { staticClass: "winsel-param__filter-panel" },
                    [
                      t("filter-panel", {
                        attrs: { sampleCode: e.sampleCode },
                        on: { updateFilter: e.updateFilter },
                      }),
                    ],
                    1,
                  ),
                  t(
                    "div",
                    { staticClass: "winsel-param__selection" },
                    [
                      t("winsel-selection", {
                        attrs: { winSelections: e.filterSelection },
                      }),
                    ],
                    1,
                  ),
                ],
              ),
            ]);
          };
        un._withStripped = !0;
        var pn = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "sample-panel" }, [
            t(
              "div",
              {
                ref: "sampleSlider",
                staticClass: "sample-panel__slider swiper",
              },
              [
                t(
                  "div",
                  {
                    ref: "arrowPrev",
                    staticClass: "btn-arrow sample-panel__arrow arrow-left",
                  },
                  [
                    t("svg", { staticClass: "ico" }, [
                      t("use", {
                        attrs: {
                          "xlink:href":
                            "/new_style_files/upload/icon/interface.svg#short-arrow-left",
                        },
                      }),
                    ]),
                  ],
                ),
                t(
                  "div",
                  {
                    ref: "arrowNext",
                    staticClass: "btn-arrow sample-panel__arrow arrow-right",
                  },
                  [
                    t("svg", { staticClass: "ico" }, [
                      t("use", {
                        attrs: {
                          "xlink:href":
                            "/new_style_files/upload/icon/interface.svg#short-arrow-right",
                        },
                      }),
                    ]),
                  ],
                ),
                t(
                  "div",
                  { staticClass: "sample-panel__wrap swiper-wrapper" },
                  e._l(e.samples, function (s, i) {
                    return t(
                      "div",
                      {
                        key: s.code,
                        staticClass: "sample-panel__item swiper-slide",
                        class: { active: s.active },
                      },
                      [
                        t("div", { staticClass: "sample-panel__circle" }, [
                          t("div", { staticClass: "sample-panel__ico" }, [
                            t("svg", { staticClass: "ico" }, [
                              t("use", {
                                attrs: {
                                  "xlink:href": `/assets/img/res/winsel-param/sprite-tileset.svg#${s.ico}`,
                                },
                              }),
                            ]),
                          ]),
                          t("div", { staticClass: "sample-panel__title" }, [
                            e._v(e._s(s.title)),
                          ]),
                          t("div", {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: e.widthWindow >= 500,
                                expression: "widthWindow>=500",
                              },
                            ],
                            staticClass: "sample-panel__click-zone",
                            on: {
                              click: function (t) {
                                return e.clickSample(s);
                              },
                            },
                          }),
                        ]),
                        e.widthWindow >= 500
                          ? t("div", { staticClass: "sample-panel__ellipse" }, [
                              t("img", {
                                staticClass: "img",
                                attrs: {
                                  src: "/new_style_files/assets/img/res/winsel-param/ellipse.png",
                                  decoding: "async",
                                  loading: "lazy",
                                  alt: "",
                                },
                              }),
                            ])
                          : e._e(),
                      ],
                    );
                  }),
                  0,
                ),
              ],
            ),
          ]);
        };
        pn._withStripped = !0;
        var hn = s(171),
          _n = {
            name: "sample-panel",
            props: { value: [Object, String] },
            data() {
              return {
                samples: [
                  { active: !0, ico: "room", title: "Квартира", code: "room" },
                  {
                    active: !1,
                    ico: "private-house",
                    title: "Частный дом",
                    code: "private-house",
                  },
                  {
                    active: !1,
                    ico: "country-house",
                    title: "Дачный дом",
                    code: "country-house",
                  },
                ],
                slider: "",
                widthWindow: hn(window).width(),
                curCode: "",
              };
            },
            computed: {},
            methods: {
              clickSample(e) {
                for (let t of this.samples) t.active = t.code == e.code;
                this.curCode = e.code;
              },
              initSlider() {
                let e = this,
                  { sampleSlider: t, arrowPrev: s, arrowNext: i } = this.$refs;
                this.slider = new M.ZP(t, {
                  modules: [M.W_],
                  breakpoints: {
                    320: { slidesPerView: 1 },
                    500: { slidesPerView: 2 },
                    768: { slidesPerView: 3 },
                  },
                  navigation: { prevEl: s, nextEl: i },
                  on: {
                    init: () => {},
                    slideChange() {
                      let { activeIndex: t } = this;
                      e.setActiveSample(t);
                    },
                  },
                });
              },
              windowResize() {
                hn(window).on("resize.sample_panel", () => {
                  c.actionFilter({
                    keyTimer: "resize-sample-panel",
                    duration: 100,
                    action: () => {
                      ((this.widthWindow = hn(window).width()),
                        this.slider.update());
                    },
                  });
                });
              },
              setActiveSample(e) {
                if (this.widthWindow < 500) {
                  let t = this.samples[e];
                  this.clickSample(t);
                }
              },
            },
            mounted() {
              (this.initSlider(), this.windowResize());
            },
            created() {
              this.curCode = this.samples.find((e) => e.active).code;
            },
            watch: {
              curCode(e) {
                e && this.$emit("input", e);
              },
            },
          },
          gn = (0, P.Z)(_n, pn, [], !1, null, null, null).exports,
          wn = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "filter-panel" }, [
              t(
                "div",
                { staticClass: "filter-panel__wrap" },
                e._l(e.filters, function (s) {
                  return t(
                    "div",
                    {
                      key: s.code,
                      staticClass: "filter-panel__item",
                    },
                    [
                      t(
                        "div",
                        { staticClass: "filter-panel__range-slider" },
                        [
                          t("filter-range-slider", {
                            attrs: {
                              min: 1,
                              max: 5,
                              orientation: "horizontal",
                            },
                            on: { input: e.updateFilter },
                            scopedSlots: e._u(
                              [
                                {
                                  key: "label-min",
                                  fn: function () {
                                    return [
                                      "text" == s.label.type
                                        ? t("span", { staticClass: "span" }, [
                                            e._v(e._s(s.label.min)),
                                          ])
                                        : "ico" == s.label.type
                                          ? e._l(s.label.min, function (e, s) {
                                              return t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "filter-panel__range-slider-ico",
                                                },
                                                [
                                                  t(
                                                    "svg",
                                                    { staticClass: "ico" },
                                                    [
                                                      t("use", {
                                                        attrs: {
                                                          "xlink:href":
                                                            "/new_style_files/assets/img/res/winsel-param/sprite-tileset.svg#light",
                                                        },
                                                      }),
                                                    ],
                                                  ),
                                                ],
                                              );
                                            })
                                          : e._e(),
                                    ];
                                  },
                                  proxy: !0,
                                },
                                {
                                  key: "label-max",
                                  fn: function () {
                                    return [
                                      "text" == s.label.type
                                        ? t("span", { staticClass: "span" }, [
                                            e._v(e._s(s.label.max)),
                                          ])
                                        : "ico" == s.label.type
                                          ? e._l(s.label.max, function (e, s) {
                                              return t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "filter-panel__range-slider-ico",
                                                },
                                                [
                                                  t(
                                                    "svg",
                                                    { staticClass: "ico" },
                                                    [
                                                      t("use", {
                                                        attrs: {
                                                          "xlink:href":
                                                            "/new_style_files/assets/img/res/winsel-param/sprite-tileset.svg#light",
                                                        },
                                                      }),
                                                    ],
                                                  ),
                                                ],
                                              );
                                            })
                                          : e._e(),
                                    ];
                                  },
                                  proxy: !0,
                                },
                              ],
                              null,
                              !0,
                            ),
                            model: {
                              value: s.value,
                              callback: function (t) {
                                e.$set(s, "value", t);
                              },
                              expression: "item.value",
                            },
                          }),
                        ],
                        1,
                      ),
                      t("div", { staticClass: "filter-panel__title" }, [
                        e._v(e._s(s.title)),
                      ]),
                      t("div", { staticClass: "filter-panel__desc" }, [
                        e._v(e._s(s.desc)),
                      ]),
                    ],
                  );
                }),
                0,
              ),
            ]);
          };
        wn._withStripped = !0;
        var vn = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "filter-range-slider" }, [
            t(
              "div",
              { staticClass: "noUi-label__min" },
              [e._t("label-min")],
              2,
            ),
            t(
              "div",
              { staticClass: "noUi-label__max" },
              [e._t("label-max")],
              2,
            ),
          ]);
        };
        vn._withStripped = !0;
        var fn = s(171),
          yn = {
            name: "filter-range-slider",
            props: {
              value: Number,
              min: Number,
              max: Number,
              orientation: String,
            },
            data() {
              return { selValue: this.value };
            },
            computed: {
              minMax() {
                return [this.min, this.max];
              },
            },
            methods: {
              init() {
                let { min: e, max: t, orientation: s, $el: i } = this,
                  a = "vertical" == s ? "rtl" : "ltr";
                (us().create(i, {
                  start: this.selValue,
                  tooltips: [!0],
                  orientation: "vertical" == s ? "vertical" : "horizontal",
                  step: 1,
                  direction: a,
                  range: { min: e, max: t },
                  format: {
                    to(e) {
                      return c.getNum(e);
                    },
                    from(e) {
                      return Math.ceil(c.getNum(e));
                    },
                  },
                }),
                  i.noUiSlider.off("change.filterRangeSlider"),
                  i.noUiSlider.on("change.filterRangeSlider", (e) => {
                    this.selValue = e[0];
                  }),
                  i.noUiSlider.off("update.filterRangeSlider"),
                  i.noUiSlider.on("update.filterRangeSlider", (e) => {}),
                  i.noUiSlider.off("set.filterRangeSlider"),
                  i.noUiSlider.on("set.filterRangeSlider", () => {}),
                  i.noUiSlider.off("slide.filterRangeSlider"),
                  i.noUiSlider.on("slide.filterRangeSlider", () => {
                    if (!i.windowScroll) {
                      let e = fn(window).width();
                      ((i.windowScroll = !0),
                        e < 1200 && fn("body").addClass("no-scroll"));
                    }
                    c.actionFilter({
                      keyTimer: "slide_filterRangeSlider",
                      duration: 500,
                      action() {
                        ((i.windowScroll = !1),
                          fn("body").removeClass("no-scroll"));
                      },
                    });
                  }));
              },
              update(e) {
                let { min: t, max: s, $el: i } = this;
                (i.noUiSlider.updateOptions(e),
                  i.noUiSlider.off("update.filterRangeSlider"),
                  i.noUiSlider.on("update.filterRangeSlider", (e) => {}));
              },
            },
            mounted() {
              this.init();
            },
            created() {},
            watch: {
              selValue(e) {
                e && this.$emit("input", e);
              },
              value(e) {
                if (e) {
                  this.selValue = e;
                  let t = { start: e };
                  this.update(t);
                }
              },
              minMax(e) {
                let { getMidSize: t } = c,
                  { min: s, max: i, $el: a } = this;
                this.selValue = t(...e);
                let n = { start: this.selValue, range: { min: s, max: i } };
                this.update(n);
              },
            },
          },
          bn = (0, P.Z)(yn, vn, [], !1, null, null, null).exports,
          kn = {
            name: "filter-panel",
            components: { FilterRangeSlider: bn },
            props: { sampleCode: String },
            data() {
              return {
                filters: [
                  {
                    code: "burglary-resist",
                    label: { type: "text", min: "2 мин", max: "15 мин" },
                    title: "Взломостойкость",
                    desc: "Наличие противовзломных элементов",
                    value: 4,
                  },
                  {
                    code: "cheap",
                    label: { type: "text", min: "дешево", max: "дорого" },
                    title: "Стоимость",
                    desc: "Выберите ценовой диапазон",
                    value: 4,
                  },
                  {
                    code: "noise-level",
                    label: {
                      type: "text",
                      min: "дом в лесу",
                      max: "железная дорога",
                    },
                    title: "Шумоизоляция",
                    desc: "Насколько важна защита от уличного шума",
                    value: 4,
                  },
                  {
                    code: "heat-saving",
                    label: { type: "text", min: "ГОСТ", max: "Супер тёплое" },
                    title: "Теплосбережение",
                    desc: "Насколько теплые окна Вам нужны",
                    value: 4,
                  },
                ],
                testValue: 0,
              };
            },
            computed: { ...(0, na.rn)(["isWinSelData"]) },
            methods: {
              setCode() {
                let { sampleCode: e, filters: t } = this;
                ("room" == e &&
                  t.forEach((e) => {
                    ("burglary-resist" == e.code && (e.value = 2),
                      "cheap" == e.code && (e.value = 2),
                      "noise-level" == e.code && (e.value = 4),
                      "heat-saving" == e.code && (e.value = 4));
                  }),
                  "private-house" == e &&
                    t.forEach((e) => {
                      ("burglary-resist" == e.code && (e.value = 3),
                        "cheap" == e.code && (e.value = 3),
                        "noise-level" == e.code && (e.value = 3),
                        "heat-saving" == e.code && (e.value = 5));
                    }),
                  "country-house" == e &&
                    t.forEach((e) => {
                      ("burglary-resist" == e.code && (e.value = 3),
                        "cheap" == e.code && (e.value = 1),
                        "noise-level" == e.code && (e.value = 3),
                        "heat-saving" == e.code && (e.value = 2));
                    }));
              },
              updateFilter() {
                c.actionFilter({
                  keyTimer: "filter-panel-updateFilter",
                  duration: 50,
                  action: () => {
                    let e = {};
                    (this.filters.forEach((t) => {
                      e[t.code] = t.value;
                    }),
                      this.$emit("updateFilter", e));
                  },
                });
              },
            },
            watch: {
              sampleCode(e) {
                e && (this.setCode(), this.updateFilter());
              },
              isWinSelData(e) {
                e && this.updateFilter();
              },
            },
          },
          Cn = (0, P.Z)(kn, wn, [], !1, null, null, null).exports,
          Sn = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "winsel-selection" }, [
              t("div", { staticClass: "winsel-selection__head" }, [
                t("h4", { staticClass: "h4 winsel-selection__title" }, [
                  e._v("Подходящие для вас окна:"),
                ]),
                t("div", { staticClass: "winsel-selection__btn" }, [
                  t(
                    "div",
                    {
                      staticClass: "btn",
                      on: { click: e.getFeedbackPrice },
                    },
                    [e._v("Запросить цену")],
                  ),
                ]),
              ]),
              t(
                "div",
                {
                  ref: "sliderSelection",
                  staticClass: "winsel-selection__slider swiper",
                },
                [
                  t(
                    "div",
                    { staticClass: "winsel-selection__wrap swiper-wrapper" },
                    e._l(e.winSelections, function (s) {
                      return t(
                        "div",
                        {
                          key: s.id,
                          staticClass: "winsel-selection__item swiper-slide",
                        },
                        [
                          t(
                            "div",
                            { staticClass: "winsel-selection__item-img" },
                            [
                              t("img", {
                                staticClass: "img",
                                attrs: {
                                  src: s.img,
                                  decoding: "async",
                                  loading: "lazy",
                                  alt: "",
                                },
                              }),
                            ],
                          ),
                          t(
                            "div",
                            { staticClass: "winsel-selection__item-label" },
                            [e._v(e._s(s.label))],
                          ),
                        ],
                      );
                    }),
                    0,
                  ),
                ],
              ),
              t(
                "div",
                {
                  ref: "arrowPrev",
                  staticClass: "btn-arrow winsel-selection__arrow arrow-left",
                },
                [
                  t("svg", { staticClass: "ico" }, [
                    t("use", {
                      attrs: {
                        "xlink:href":
                          "/new_style_files/upload/icon/interface.svg#short-arrow-left",
                      },
                    }),
                  ]),
                ],
              ),
              t(
                "div",
                {
                  ref: "arrowNext",
                  staticClass: "btn-arrow winsel-selection__arrow arrow-right",
                },
                [
                  t("svg", { staticClass: "ico" }, [
                    t("use", {
                      attrs: {
                        "xlink:href":
                          "/new_style_files/upload/icon/interface.svg#short-arrow-right",
                      },
                    }),
                  ]),
                ],
              ),
            ]);
          };
        Sn._withStripped = !0;
        var xn = {
            name: "winsel-selection",
            props: { winSelections: Array },
            data() {
              return { slider: "", modalWin: "" };
            },
            computed: {
              sizeSelection() {
                return this.winSelections.length;
              },
            },
            methods: {
              initSlider() {
                let {
                  sliderSelection: e,
                  arrowPrev: t,
                  arrowNext: s,
                } = this.$refs;
                this.slider = new M.ZP(e, {
                  modules: [M.W_],
                  spaceBetween: 20,
                  slidesPerView: 4,
                  breakpoints: {
                    320: { spaceBetween: 20, slidesPerView: 2 },
                    500: { spaceBetween: 20, slidesPerView: 2 },
                    600: { spaceBetween: 20, slidesPerView: 3 },
                    1024: { spaceBetween: 20, slidesPerView: 4 },
                  },
                  navigation: { prevEl: t, nextEl: s },
                  on: {
                    init: () => {},
                    slideChange() {
                      let { activeIndex: e } = this;
                    },
                  },
                });
              },
              getFeedbackPrice() {
                let { modalWin: e } = this;
                (e.close(), e.open("#modal-calc-win"));
              },
            },
            mounted() {
              (this.initSlider(),
                (this.modalWin = l.getComponent(".js-modal-win")));
            },
            watch: {
              sizeSelection() {
                setTimeout(() => {
                  this.slider.update();
                }, 100);
              },
            },
          },
          Pn = {
            name: "winsel-param",
            components: {
              SamplePanel: gn,
              FilterPanel: Cn,
              WinselSelection: (0, P.Z)(xn, Sn, [], !1, null, null, null)
                .exports,
            },
            data() {
              return { sampleCode: "", filterSelection: [] };
            },
            computed: { ...(0, na.rn)(["winSelData"]) },
            methods: {
              ...(0, na.nv)(["getData"]),
              updateFilter(e) {
                this.filterSelection = this.winSelData.filter((t) => {
                  let s = !0;
                  for (let [i, a] of Object.entries(e)) s = s && t[i] >= a;
                  return s;
                });
              },
            },
            created() {
              this.getData();
            },
          },
          jn = (0, P.Z)(Pn, un, [], !1, null, null, null).exports,
          qn = (e) => new (a())({ el: e, store: mn, render: (e) => e(jn) }),
          Dn = s(171);
        a().use(na.ZP);

        var Ln = new na.ZP.Store({
            state: {
              dataLaminColor: [
                {
                  id: "174",
                  title: "Антрацитово-серый",
                  layoutImg: "/new_style_files/images/colors/antra-min.webp",
                  windowImg: "/new_style_files/images/colors/antracit.jpg",
                  vendor: "",
                  active: !0,
                  sectionId: "32",
                },
                {
                  id: "176",
                  title: "Шоколадно-коричневый",
                  layoutImg: "/new_style_files/images/colors/chokolad-min.webp",
                  windowImg: "/new_style_files/images/colors/chokolad.jpg",
                  vendor: "",
                  active: !1,
                  sectionId: "32",
                },
                {
                  id: "177",
                  title: "Тёмный дуб ",
                  layoutImg: "/new_style_files/images/colors/dark-dub-min.webp",
                  windowImg: "/new_style_files/images/colors/dark-dub.jpg",
                  vendor: "",
                  active: !1,
                  sectionId: "32",
                },
                {
                  id: "178",
                  title: "Орех ",
                  layoutImg: "/new_style_files/images/colors/oreh-min.webp",
                  windowImg: "/new_style_files/images/colors/oreh.jpg",
                  vendor: "",
                  active: !1,
                  sectionId: "32",
                },
                {
                  id: "179",
                  title: "Махагон ",
                  layoutImg: "/new_style_files/images/colors/mahagon-min.webp",
                  windowImg: "/new_style_files/images/colors/mahagon.jpg",
                  vendor: "",
                  active: !1,
                  sectionId: "32",
                },
              ],
              currentLamin: {
                id: "174",
                title: "Антрацитово-серый",
                layoutImg: "/new_style_files/images/colors/antra-min.webp",
                windowImg: "/new_style_files/images/colors/antracit.jpg",
                vendor: "",
                active: !0,
                sectionId: "32",
              },
              currentIndex: 0,
            },

            mutations: {
              switchLamin(e, t) {
                ((e.dataLaminColor[e.currentIndex].active = !1),
                  (e.dataLaminColor[t.index].active = !0),
                  (e.currentLamin = e.dataLaminColor[t.index]),
                  (e.currentIndex = t.index));
              },
            },
            actions: {
              async getData(e, t) {
                let { state: s } = e,
                  i = Dn(t.$el).closest("[data-action]").data("action");
                if ((i && (s.dataSystem = []), i))
                  return R.ajaxGet({ url: i }).then((e) => {
                    if (e?.success) {
                      let t = [];
                      (e.data.forEach((e, i) => {
                        ((e.active = 0 == i),
                          0 == i && (s.currentLamin = e),
                          i <= 4 && t.push(e));
                      }),
                        (s.dataLaminColor = t));
                    }
                    return e;
                  });
              },
            },
          }),
          Mn = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "lamin-color__app" }, [
              t("div", { staticClass: "lamin-color__window-form" }, [
                t(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: e.currentLamin,
                        expression: "currentLamin",
                      },
                    ],
                    staticClass: "window-color-form",
                  },
                  [
                    t("div", { staticClass: "window-color-form__img" }, [
                      t("img", {
                        staticClass: "img",
                        attrs: {
                          src: e.currentLamin.windowImg,
                          decoding: "async",
                          loading: "lazy",
                          alt: "",
                        },
                      }),
                    ]),
                    t("div", { staticClass: "window-color-form__info" }, [
                      t("div", { staticClass: "window-color-form__title" }, [
                        e._v(e._s(e.currentLamin.title)),
                      ]),
                      t("div", { staticClass: "window-color-form__vendor" }, [
                        e._v(e._s(e.currentLamin.vendor)),
                      ]),
                    ]),
                    t("div", { staticClass: "window-color-form__btn" }, [
                      t(
                        "button",
                        {
                          staticClass: "btn",
                          on: { click: e.submit },
                        },
                        [e._v("Заказать расчет")],
                      ),
                    ]),
                  ],
                ),
              ]),
              t(
                "div",
                { staticClass: "lamin-color__list" },
                [t("lamination-list")],
                1,
              ),
            ]);
          };
        Mn._withStripped = !0;
        var $n = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "lamination-list" }, [
            t("div", { staticClass: "lamination-list__header" }, [
              e._v("Акционные цвета ламинации, производство за 5 дней:"),
            ]),
            t(
              "div",
              { staticClass: "lamination-list__action" },
              e._l(e.dataLaminColor, function (s, i) {
                return t(
                  "div",
                  {
                    key: s.id,
                    staticClass: "lamination-list__item",
                    class: { "lamination-list__item--active": s.active },
                    on: {
                      click: function (t) {
                        return e.switchLamin({ index: i });
                      },
                    },
                  },
                  [
                    t("div", { staticClass: "lamination-list__item-img" }, [
                      t("img", {
                        staticClass: "img",
                        attrs: { src: s.layoutImg, loazding: "lazy" },
                      }),
                    ]),
                    t("div", { staticClass: "lamination-list__item-desc" }, [
                      t("div", { staticClass: "lamination-list__item-title" }, [
                        e._v(e._s(s.title)),
                      ]),
                      s.vendor
                        ? t(
                            "div",
                            { staticClass: "lamination-list__item-sku" },
                            [e._v("Арт: " + e._s(s.vendor))],
                          )
                        : e._e(),
                    ]),
                  ],
                );
              }),
              0,
            ),
          ]);
        };
        $n._withStripped = !0;
        var zn = {
            name: "lamination-list",
            components: {},
            data() {
              return {};
            },
            props: ["winWidth"],
            computed: { ...(0, na.rn)(["dataLaminColor"]) },
            methods: { ...(0, na.OI)(["switchLamin"]) },
          },
          En = (0, P.Z)(zn, $n, [], !1, null, null, null).exports,
          Fn = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t(
              "div",
              {
                ref: "sliderTypeColor",
                staticClass: "swiper",
              },
              [
                t(
                  "div",
                  { staticClass: "lamin-color__wrap swiper-wrapper" },
                  [
                    e.winWidth >= 500
                      ? e._l(e.dataLaminColor, function (s) {
                          return t(
                            "div",
                            { staticClass: "lamin-color__item swiper-slide" },
                            e._l(s, function (s) {
                              return t(
                                "div",
                                {
                                  key: s.id,
                                  staticClass: "lamin-color-cart",
                                },
                                [
                                  t(
                                    "div",
                                    {
                                      staticClass: "lamin-color-cart__img",
                                      class: { active: s.active },
                                      on: {
                                        click: function (t) {
                                          return e.setLaminColor(s);
                                        },
                                      },
                                    },
                                    [
                                      t("img", {
                                        staticClass: "img",
                                        attrs: {
                                          src: s.layoutImg,
                                          decoding: "async",
                                          loading: "lazy",
                                          alt: "",
                                        },
                                      }),
                                    ],
                                  ),
                                  t(
                                    "div",
                                    { staticClass: "lamin-color-cart__title" },
                                    [e._v(e._s(s.title))],
                                  ),
                                  t(
                                    "div",
                                    { staticClass: "lamin-color-cart__vendor" },
                                    [e._v(e._s(s.vendor))],
                                  ),
                                ],
                              );
                            }),
                            0,
                          );
                        })
                      : e._l(e.dataLaminColor, function (s) {
                          return t(
                            "div",
                            {
                              key: s.id,
                              staticClass: "lamin-color__item swiper-slide",
                            },
                            [
                              t("div", { staticClass: "lamin-color-cart" }, [
                                t(
                                  "div",
                                  {
                                    staticClass: "lamin-color-cart__img",
                                    class: { active: s.active },
                                    on: {
                                      click: function (t) {
                                        return e.setLaminColor(s);
                                      },
                                    },
                                  },
                                  [
                                    t("img", {
                                      staticClass: "img",
                                      attrs: {
                                        src: s.layoutImg,
                                        decoding: "async",
                                        loading: "lazy",
                                        alt: "",
                                      },
                                    }),
                                  ],
                                ),
                                t(
                                  "div",
                                  { staticClass: "lamin-color-cart__title" },
                                  [e._v(e._s(s.title))],
                                ),
                                t(
                                  "div",
                                  { staticClass: "lamin-color-cart__vendor" },
                                  [e._v(e._s(s.vendor))],
                                ),
                              ]),
                            ],
                          );
                        }),
                  ],
                  2,
                ),
              ],
            );
          };
        Fn._withStripped = !0;
        var On = {
            name: "decoration-slider",
            components: {},
            data() {
              return { curLaminColor: "", slider: "" };
            },
            props: ["winWidth"],
            computed: { ...(0, na.rn)(["dataLaminColor"]) },
            methods: {
              initSlider() {
                let { sliderTypeColor: e } = this.$refs;
                this.slider = new M.ZP(e, {
                  modules: [M.LW, M.Gk],
                  mousewheel: { forceToAxis: !0, releaseOnEdges: !0 },
                  resistanceRatio: 0,
                  spaceBetween: 20,
                  slidesPerView: 2,
                  breakpoints: {
                    768: { slidesPerView: 3 },
                    1024: { slidesPerView: 2 },
                  },
                });
              },
            },
            mounted() {
              this.initSlider();
            },
          },
          Tn = (0, P.Z)(On, Fn, [], !1, null, null, null).exports,
          Bn = s(171),
          In = {
            name: "lamin-color",
            components: { LaminationList: En, DecorationSlider: Tn },
            data() {
              return {
                winWidth: Bn(window).width(),
                curLaminColor: "",
                modalWin: "",
              };
            },
            computed: { ...(0, na.rn)(["dataLaminColor", "currentLamin"]) },
            methods: {
              ...(0, na.nv)(["getData"]),
              resizeWindow() {
                Bn(window).on("resize.lamin_color", () => {
                  c.actionFilter({
                    keyTimer: "resize-lamin-color",
                    duration: 100,
                    action: () => {
                      this.winWidth = Bn(window).width();
                    },
                  });
                });
              },
              submit(e) {
                (e.preventDefault(), this.getFeedbackPrice());
              },
              setLaminColor(e) {
                this.curLaminColor = e;
                for (let t of this.dataLaminColor) t.active = t.id == e.id;
              },
              getFeedbackPrice() {
                let { modalWin: e } = this;
                (e.close(), e.open("#modal-calc-win"));
              },
            },
            created() {},
            mounted() {
              (this.getData(this).then((e) => {
                this.setLaminColor(this.dataLaminColor[0]);
              }),
                this.resizeWindow(),
                (this.modalWin = l.getComponent(".js-modal-win")));
            },
          },
          Wn = (0, P.Z)(In, Mn, [], !1, null, null, null).exports,
          An = s(171),
          Vn = (e) =>
            new (a())({
              el: e,
              store: Ln,
              data: { sectionId: An(e)[0].dataset.type },
              render: (e) => e(Wn),
            }),
          Nn = s(171);
        a().use(na.ZP);
        var Zn = new na.ZP.Store({
            state: {
              type: "",
              windows: [
                {
                  id: c.hash,
                  typeCol: "col-4",
                  title: "Exprof Art",
                  images: {
                    srcProfile:
                      "/new_style_files/assets/img/res/tiled-win-sys/profile/img-profile-1.svg",
                    srcPhoto:
                      "/new_style_files/assets/img/res/tiled-win-sys/img-1.jpg",
                  },
                  stock: {
                    is: !1,
                    type: "",
                    label: "",
                    dateOut: "",
                    timeOut: "",
                    discountPercent: "",
                    discountTitle: "",
                  },
                  price: { old: "", cur: 8540 },
                  props: {
                    widthProfile: "70/85мм",
                    countProfileCameras: 6,
                    shortNameProfile: "",
                    typeGlass: "Двухкамерный стеклопакет",
                    brandGlass: "Climatherm Balance",
                    thermalProtect: 1.08,
                    colorSeal: "серые",
                    classes: "",
                    furniture: "Siegenia Titan (Германия)",
                    countColor: 200,
                  },
                  link: "#",
                },
                {
                  id: c.hash,
                  typeCol: "col-4",
                  title: "Exprof Evolution",
                  images: {
                    srcProfile:
                      "/new_style_files/assets/img/res/tiled-win-sys/profile/img-profile-2.svg",
                    srcPhoto:
                      "/new_style_files/assets/img/res/tiled-win-sys/img-2.jpg",
                  },
                  stock: {
                    is: !1,
                    type: "",
                    label: "Хит продаж",
                    dateOut: "",
                    timeOut: "",
                    discountPercent: "",
                    discountTitle: "",
                  },
                  price: { old: "", cur: 8540 },
                  props: {
                    widthProfile: "70/70мм",
                    countProfileCameras: 5,
                    shortNameProfile: "",
                    typeGlass: "Двухкамерный стеклопакет",
                    brandGlass: "Climatherm",
                    thermalProtect: 1.06,
                    colorSeal: "серые",
                    classes: "",
                    furniture: "Siegenia Titan (Германия)",
                    countColor: 200,
                  },
                  link: "#",
                },
                {
                  id: c.hash,
                  typeCol: "col-2",
                  title: "Окна Smart",
                  images: {
                    srcProfile:
                      "/new_style_files/assets/img/res/tiled-win-sys/profile/img-profile-2.svg",
                    srcPhoto:
                      "/new_style_files/assets/img/res/tiled-win-sys/img-2.jpg",
                  },
                  stock: {
                    is: !0,
                    type: "discount",
                    label: "Акция",
                    dateOut: "",
                    timeOut: "",
                    discountPercent: 40,
                    discountTitle: "",
                  },
                  price: { old: 9500, cur: 6220 },
                  props: {
                    widthProfile: "",
                    countProfileCameras: "",
                    shortNameProfile: "Трехкамерный профиль 60 мм",
                    typeGlass: "Двухкамерный стеклопакет",
                    brandGlass: "Climatherm",
                    thermalProtect: 0.78,
                    colorSeal: "серые",
                    classes: "",
                    furniture: "",
                    countColor: "",
                  },
                  link: "#",
                },
                {
                  id: c.hash,
                  typeCol: "col-full",
                  title: "Exprof Lite’60",
                  images: {
                    srcProfile:
                      "/new_style_files/assets/img/res/tiled-win-sys/profile/img-profile-2.svg",
                    srcPhoto:
                      "/new_style_files/assets/img/res/tiled-win-sys/img-4.jpg",
                  },
                  stock: {
                    is: !1,
                    type: "",
                    label: "Самая низкая цена",
                    dateOut: "",
                    timeOut: "",
                    discountPercent: "",
                    discountTitle: "",
                  },
                  price: { old: "", cur: 5540 },
                  props: {
                    widthProfile: "70/70мм",
                    countProfileCameras: 4,
                    shortNameProfile: "",
                    typeGlass: "Двухкамерный стеклопакет",
                    brandGlass: "",
                    thermalProtect: 0.7,
                    colorSeal: "черные",
                    classes: "А",
                    furniture: "Vorne (Турция)",
                    countColor: "",
                  },
                  link: "#",
                },
                {
                  id: c.hash,
                  typeCol: "col-full revers",
                  title: "Exprof Lite’70",
                  images: {
                    srcProfile:
                      "/new_style_files/assets/img/res/tiled-win-sys/profile/img-profile-2.svg",
                    srcPhoto:
                      "/new_style_files/assets/img/res/tiled-win-sys/img-3.jpg",
                  },
                  stock: {
                    is: !1,
                    type: "",
                    label: "",
                    dateOut: "",
                    timeOut: "",
                    discountPercent: "",
                    discountTitle: "",
                  },
                  price: { old: "", cur: 5540 },
                  props: {
                    widthProfile: "60/60мм",
                    countProfileCameras: 3,
                    shortNameProfile: "",
                    typeGlass: " Двухкамерный стеклопакет",
                    brandGlass: "",
                    thermalProtect: 0.76,
                    colorSeal: "черные",
                    classes: "А",
                    furniture: "Vorne (Турция)",
                    countColor: "",
                  },
                  link: "#",
                },
              ],
              balconies: [
                {
                  id: c.hash,
                  typeCol: "col-4",
                  title: "Холодное остекление",
                  images: {
                    srcProfile: "",
                    srcPhoto:
                      "/new_style_files/assets/img/res/tiled-win-sys/balcons/img-1.jpg",
                  },
                  stock: {
                    is: !1,
                    type: "",
                    label: "",
                    dateOut: "",
                    timeOut: "",
                    discountPercent: "",
                    discountTitle: "",
                  },
                  price: { old: "", cur: 24695 },
                  props: [
                    "Защита от ветра, пыли и осадков",
                    "Раздвижное открывание удобно на маленьких балконах",
                    "Небольшой вес конструкций, подходит даже для «ветхих» балконов",
                  ],
                  link: "#",
                },
                {
                  id: c.hash,
                  typeCol: "col-4",
                  title: "Теплое пластиковое остекление",
                  images: {
                    srcProfile: "",
                    srcPhoto:
                      "/new_style_files/assets/img/res/tiled-win-sys/balcons/img-2.jpg",
                  },
                  stock: {
                    is: !1,
                    type: "",
                    label: "Хит продаж",
                    dateOut: "",
                    timeOut: "",
                    discountPercent: "",
                    discountTitle: "",
                  },
                  price: { old: "", cur: 8540 },
                  props: [
                    "Защита от ветра, пыли и осадков",
                    "Раздвижное открывание удобно на маленьких балконах",
                    "Небольшой вес конструкций, подходит даже для «ветхих» балконов",
                  ],
                  link: "#",
                },
                {
                  id: c.hash,
                  typeCol: "col-2",
                  title: "Остекление балкона с выносом",
                  images: {
                    srcProfile: "",
                    srcPhoto:
                      "/new_style_files/assets/img/res/tiled-win-sys/balcons/img-2.jpg",
                  },
                  stock: {
                    is: !0,
                    type: "",
                    label: "Акция",
                    dateOut: "",
                    timeOut: "",
                    discountPercent: "",
                    discountTitle: "Акция",
                  },
                  price: { old: 9500, cur: 6220 },
                  props: [
                    "Защита от ветра, пыли и осадков",
                    "Раздвижное открывание удобно на маленьких балконах",
                    "Небольшой вес конструкций, подходит даже для «ветхих» балконов",
                  ],
                  link: "#",
                },
                {
                  id: c.hash,
                  typeCol: "col-full",
                  title: "От пола до потолка",
                  images: {
                    srcProfile: "",
                    srcPhoto:
                      "/new_style_files/assets/img/res/tiled-win-sys/balcons/img-4.jpg",
                  },
                  stock: {
                    is: !1,
                    type: "",
                    label: "Самая низкая цена",
                    dateOut: "",
                    timeOut: "",
                    discountPercent: "",
                    discountTitle: "",
                  },
                  price: { old: "", cur: 5540 },
                  props: [
                    "Защита от ветра, пыли и осадков",
                    "Раздвижное открывание удобно на маленьких балконах",
                    "Небольшой вес конструкций, подходит даже для «ветхих» балконов",
                  ],
                  link: "#",
                },
                {
                  id: c.hash,
                  typeCol: "col-full revers",
                  title: "От пола до потолка",
                  images: {
                    srcProfile: "",
                    srcPhoto:
                      "/new_style_files/assets/img/res/tiled-win-sys/balcons/img-4.jpg",
                  },
                  stock: {
                    is: !1,
                    type: "",
                    label: "",
                    dateOut: "",
                    timeOut: "",
                    discountPercent: "",
                    discountTitle: "",
                  },
                  price: { old: "", cur: 5540 },
                  props: [
                    "Защита от ветра, пыли и осадков",
                    "Раздвижное открывание удобно на маленьких балконах",
                    "Небольшой вес конструкций, подходит даже для «ветхих» балконов",
                  ],
                  link: "#",
                },
              ],
            },
            mutations: {
              setType(e, t) {
                t && (e.type = t);
              },
              setData(e, t) {
                ((e.windows = t), (e.balconies = t));
              },
            },
            actions: {
              async getData(e, t) {
                let { state: s, commit: i } = e,
                  { type: a } = s,
                  n = Nn(t.$el).closest("[data-action]").data("action");
                (n &&
                  ("win" == a && (s.windows = []),
                  "balcon" == a && (s.balconies = [])),
                  n &&
                    R.ajaxGet({ url: n }).then((e) => {
                      e?.success && i("setData", e.data);
                    }));
              },
            },
          }),
          Rn = function () {
            var e = this._self._c;
            this._self._setupProxy;
            return e(
              "div",
              { staticClass: "tiled-win-sys__app" },
              [e("tiled-win-desk")],
              1,
            );
          };
        Rn._withStripped = !0;
        var Un = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "tiled-win-desk" }, [
            t(
              "div",
              { staticClass: "tiled-win-desk__wrap" },
              [
                e._l(e.windows, function (s) {
                  return "win" == e.type
                    ? t(
                        "div",
                        {
                          key: s.id,
                          staticClass: "tiled-win-desk__item",
                        },
                        [t("tiled-win-card", { attrs: { win: s } })],
                        1,
                      )
                    : e._e();
                }),
                e._l(e.balconies, function (s) {
                  return "balcon" == e.type
                    ? t(
                        "div",
                        {
                          key: s.id,
                          staticClass: "tiled-win-desk__item",
                          class: s.typeCol,
                        },
                        [t("tiled-win-card", { attrs: { win: s } })],
                        1,
                      )
                    : e._e();
                }),
              ],
              2,
            ),
          ]);
        };
        Un._withStripped = !0;
        var Gn = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "tiled-win-card" }, [
            e.win.stock.label
              ? t(
                  "div",
                  {
                    staticClass:
                      "label-sticker tiled-win-card__label label-sticker--right",
                  },
                  [e._v(e._s(e.win.stock.label))],
                )
              : e._e(),
            t("div", { staticClass: "tiled-win-card__container" }, [
              t("div", { staticClass: "tiled-win-card__sign" }, [
                e._m(0),
                444753 == e.win.id
                  ? t(
                      "a",
                      {
                        attrs: {
                          href: "/about/articles/Exprof-awards-at-MosBuild-2023/",
                        },
                      },
                      [
                        t("img", {
                          staticClass: "sign-ico",
                          attrs: {
                            src: "/new_style_files/assets/img/ico/MosBuild.svg",
                            alt: "",
                            loading: "lazy",
                          },
                        }),
                      ],
                    )
                  : e._e(),
              ]),
              t("div", { staticClass: "tiled-win-card__name" }, [
                e._v(e._s(e.win.name)),
              ]),
              t(
                "a",
                {
                  staticClass: "tiled-win-card__img",
                  attrs: { href: e.win.link },
                },
                [
                  t("img", {
                    staticClass: "img",
                    attrs: {
                      src: e.win.images.srcPhoto,
                      decoding: "async",
                      loading: "lazy",
                      alt: "",
                    },
                  }),
                ],
              ),
              t(
                "div",
                { staticClass: "tiled-win-card__info" },
                [
                  e.win.images.srcProfile
                    ? t("div", { staticClass: "tiled-win-card__profile-img" }, [
                        t("img", {
                          staticClass: "img",
                          attrs: {
                            src: e.win.images.srcProfile,
                            decoding: "async",
                            loading: "lazy",
                            alt: "",
                          },
                        }),
                      ])
                    : e._e(),
                  t("div", { staticClass: "tiled-win-card__block-prices" }, [
                    t("div", { staticClass: "tiled-win-card__price" }, [
                      e._v(
                        "от " + e._s(e.getMoney(e.win.price.cur)) + " руб/м²",
                      ),
                    ]),
                  ]),
                  "win" == e.type
                    ? [
                        t(
                          "div",
                          { staticClass: "tiled-win-card__block-props" },
                          [
                            t(
                              "div",
                              { staticClass: "tiled-win-card__props-item" },
                              [
                                e._v("Воздушные камеры — "),
                                t("b", [
                                  e._v(
                                    e._s(e.win.props.countProfileCameras) +
                                      "шт.",
                                  ),
                                ]),
                              ],
                            ),
                            t(
                              "div",
                              { staticClass: "tiled-win-card__props-item" },
                              [
                                e._v("Ширина рама/створка — "),
                                t("b", [
                                  e._v(e._s(e.win.props.widthProfile) + "мм."),
                                ]),
                              ],
                            ),
                            t(
                              "div",
                              { staticClass: "tiled-win-card__props-item" },
                              [
                                e._v("Теплозащита — "),
                                t("b", [
                                  e._v(
                                    e._s(
                                      e.getFormatNum(
                                        e.win.props.thermalProtect,
                                      ),
                                    ),
                                  ),
                                ]),
                              ],
                            ),
                          ],
                        ),
                      ]
                    : "balcon" == e.type
                      ? [
                          t(
                            "div",
                            { staticClass: "tiled-win-card__block-props" },
                            e._l(e.win.props, function (s) {
                              return t(
                                "div",
                                { staticClass: "tiled-win-card__props-item" },
                                [e._v(e._s(s))],
                              );
                            }),
                            0,
                          ),
                        ]
                      : e._e(),
                  t("div", { staticClass: "tiled-win-card__spacer" }),
                  e._m(1),
                ],
                2,
              ),
            ]),
          ]);
        };
        Gn._withStripped = !0;
        var Hn = {
            name: "tiled-win-card",
            props: { win: Object },
            data() {
              return {};
            },
            computed: { ...(0, na.rn)(["type"]) },
            methods: {
              getFormatNum(e) {
                return c.getFormatNum(e);
              },
              getMoney(e) {
                return c.getMoney(e);
              },
            },
            created() {},
          },
          Yn = {
            name: "tiled-win-desk",
            components: {
              TiledWinCard: (0, P.Z)(
                Hn,
                Gn,
                [
                  function () {
                    var e = this._self._c;
                    this._self._setupProxy;
                    return e(
                      "a",
                      {
                        attrs: {
                          href: "/about/articles/catalog-Green-Book-2023/",
                        },
                      },
                      [
                        e("img", {
                          staticClass: "sign-ico",
                          attrs: {
                            src: "/new_style_files/upload/img_verstka/sign-greenbook.svg",
                            alt: "",
                            loading: "lazy",
                          },
                        }),
                      ],
                    );
                  },
                  function () {
                    var e = this,
                      t = e._self._c;
                    e._self._setupProxy;
                    return t(
                      "div",
                      { staticClass: "tiled-win-card__block-buttons" },
                      [
                        t(
                          "button",
                          {
                            staticClass: "btn btn--red",
                            attrs: { "data-modal-window": "#modal-calc-win" },
                          },
                          [e._v("Заказать расчет")],
                        ),
                      ],
                    );
                  },
                ],
                !1,
                null,
                null,
                null,
              ).exports,
            },
            data() {
              return {};
            },
            computed: { ...(0, na.rn)(["type", "windows", "balconies"]) },
          },
          Jn = (0, P.Z)(Yn, Un, [], !1, null, null, null).exports,
          Xn = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "tiled-win-mob" }, [
              t(
                "div",
                {
                  ref: "sliderWindow",
                  staticClass: "tiled-win-mob__slider swiper",
                },
                [
                  t(
                    "div",
                    {
                      ref: "arrowLeft",
                      staticClass: "btn-arrow tiled-win-mob__arrow arrow-left",
                    },
                    [
                      t("svg", { staticClass: "ico" }, [
                        t("use", {
                          attrs: {
                            "xlink:href":
                              "/new_style_files/upload/icon/interface.svg#short-arrow-left",
                          },
                        }),
                      ]),
                    ],
                  ),
                  t(
                    "div",
                    {
                      ref: "arrowRight",
                      staticClass: "btn-arrow tiled-win-mob__arrow arrow-right",
                    },
                    [
                      t("svg", { staticClass: "ico" }, [
                        t("use", {
                          attrs: {
                            "xlink:href":
                              "/new_style_files/upload/icon/interface.svg#short-arrow-right",
                          },
                        }),
                      ]),
                    ],
                  ),
                  t(
                    "div",
                    { staticClass: "tiled-win-mob__wrap swiper-wrapper" },
                    e._l(e.windows, function (s, i) {
                      return t(
                        "div",
                        {
                          key: s.id,
                          staticClass: "tiled-win-mob__item col-4 swiper-slide",
                        },
                        [
                          t("div", { staticClass: "tiled-win-card" }, [
                            s.stock.label
                              ? t(
                                  "div",
                                  {
                                    staticClass:
                                      "label-sticker tiled-win-card__label label-sticker--left",
                                  },
                                  [e._v(e._s(s.stock.label))],
                                )
                              : e._e(),
                            t(
                              "div",
                              { staticClass: "tiled-win-card__container" },
                              [
                                t(
                                  "div",
                                  { staticClass: "tiled-win-card__img" },
                                  [
                                    t("img", {
                                      staticClass: "img",
                                      attrs: {
                                        src: s.images.srcPhoto,
                                        decoding: "async",
                                        loading: "lazy",
                                        alt: "",
                                      },
                                    }),
                                  ],
                                ),
                                t(
                                  "div",
                                  { staticClass: "tiled-win-card__info" },
                                  [
                                    s.images.srcProfile
                                      ? t(
                                          "div",
                                          {
                                            staticClass:
                                              "tiled-win-card__profile-img",
                                          },
                                          [
                                            t("img", {
                                              staticClass: "img",
                                              attrs: {
                                                src: s.images.srcProfile,
                                                decoding: "async",
                                                loading: "lazy",
                                                alt: "",
                                              },
                                            }),
                                          ],
                                        )
                                      : e._e(),
                                    t(
                                      "div",
                                      {
                                        staticClass:
                                          "tiled-win-card__block-titles",
                                      },
                                      [
                                        t(
                                          "div",
                                          {
                                            staticClass:
                                              "tiled-win-card__title",
                                          },
                                          [e._v(e._s(s.title))],
                                        ),
                                        s.stock.is
                                          ? [
                                              s.stock.discountTitle
                                                ? t(
                                                    "div",
                                                    {
                                                      staticClass:
                                                        "tiled-win-card__discount",
                                                    },
                                                    [
                                                      e._v(
                                                        e._s(
                                                          s.stock.discountTitle,
                                                        ),
                                                      ),
                                                    ],
                                                  )
                                                : e._e(),
                                              s.stock.timeOut
                                                ? t(
                                                    "div",
                                                    {
                                                      staticClass:
                                                        "tiled-win-card__time-out-promotion",
                                                    },
                                                    [
                                                      e._v(
                                                        "До конца акции осталось: ",
                                                      ),
                                                      t(
                                                        "span",
                                                        { staticClass: "span" },
                                                        [
                                                          e._v(
                                                            e._s(
                                                              s.stock.timeOut,
                                                            ),
                                                          ),
                                                        ],
                                                      ),
                                                    ],
                                                  )
                                                : e._e(),
                                            ]
                                          : e._e(),
                                      ],
                                      2,
                                    ),
                                    "win" == e.type
                                      ? [
                                          t(
                                            "div",
                                            {
                                              staticClass:
                                                "tiled-win-card__block-props",
                                            },
                                            [
                                              t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "tiled-win-card__props-item",
                                                },
                                                [
                                                  e._v(
                                                    "Ширина рама/створка: " +
                                                      e._s(
                                                        s.props.widthProfile,
                                                      ),
                                                  ),
                                                ],
                                              ),
                                              t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "tiled-win-card__props-item",
                                                },
                                                [
                                                  e._v(
                                                    "Количество камер: " +
                                                      e._s(
                                                        s.props
                                                          .countProfileCameras,
                                                      ),
                                                  ),
                                                ],
                                              ),
                                              t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "tiled-win-card__props-item",
                                                },
                                                [
                                                  e._v(
                                                    e._s(s.props.typeGlass) +
                                                      " " +
                                                      e._s(s.props.brandGlass),
                                                  ),
                                                ],
                                              ),
                                              t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "tiled-win-card__props-item",
                                                },
                                                [
                                                  e._v("Теплозащита: "),
                                                  t("b", [
                                                    e._v(
                                                      e._s(
                                                        e.getFormatNum(
                                                          s.props
                                                            .thermalProtect,
                                                        ),
                                                      ),
                                                    ),
                                                  ]),
                                                ],
                                              ),
                                              t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "tiled-win-card__props-item",
                                                },
                                                [
                                                  e._v(
                                                    "Уплотнения " +
                                                      e._s(s.props.colorSeal),
                                                  ),
                                                ],
                                              ),
                                              t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "tiled-win-card__props-item",
                                                },
                                                [
                                                  e._v(
                                                    "Фурнитура " +
                                                      e._s(s.props.furniture),
                                                  ),
                                                ],
                                              ),
                                              t(
                                                "div",
                                                {
                                                  staticClass:
                                                    "tiled-win-card__props-item",
                                                },
                                                [
                                                  e._v(
                                                    "Более " +
                                                      e._s(s.props.countColor) +
                                                      " цветов",
                                                  ),
                                                ],
                                              ),
                                            ],
                                          ),
                                        ]
                                      : "balcon" == e.type
                                        ? [
                                            t(
                                              "div",
                                              {
                                                staticClass:
                                                  "tiled-win-card__block-props",
                                              },
                                              e._l(s.props, function (s) {
                                                return t(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "tiled-win-card__props-item",
                                                  },
                                                  [e._v(e._s(s))],
                                                );
                                              }),
                                              0,
                                            ),
                                          ]
                                        : e._e(),
                                    t("div", {
                                      staticClass: "tiled-win-card__spacer",
                                    }),
                                    t(
                                      "div",
                                      {
                                        staticClass:
                                          "tiled-win-card__block-prices",
                                      },
                                      [
                                        s.price.old
                                          ? t(
                                              "div",
                                              {
                                                staticClass:
                                                  "tiled-win-card__old-price",
                                              },
                                              [
                                                e._v(
                                                  "от " +
                                                    e._s(
                                                      e.getMoney(s.price.old),
                                                    ) +
                                                    " руб/м²",
                                                ),
                                              ],
                                            )
                                          : e._e(),
                                        t(
                                          "div",
                                          {
                                            staticClass:
                                              "tiled-win-card__price",
                                          },
                                          [
                                            e._v(
                                              "от " +
                                                e._s(e.getMoney(s.price.cur)) +
                                                " руб/м²",
                                            ),
                                          ],
                                        ),
                                      ],
                                    ),
                                    t(
                                      "div",
                                      {
                                        staticClass:
                                          "tiled-win-card__block-buttons",
                                      },
                                      [
                                        t(
                                          "a",
                                          {
                                            staticClass: "no-style btn",
                                            attrs: { href: s.link },
                                          },
                                          [e._v("Подробнее")],
                                        ),
                                      ],
                                    ),
                                  ],
                                  2,
                                ),
                              ],
                            ),
                          ]),
                        ],
                      );
                    }),
                    0,
                  ),
                ],
              ),
            ]);
          };
        Xn._withStripped = !0;
        var Kn = {
            name: "tiled-win-mob",
            data() {
              return { slider: "" };
            },
            computed: { ...(0, na.rn)(["type", "windows", "balconies"]) },
            methods: {
              getFormatNum(e) {
                return c.getFormatNum(e);
              },
              getMoney(e) {
                return c.getMoney(e);
              },
              initSlider() {
                let {
                  sliderWindow: e,
                  arrowLeft: t,
                  arrowRight: s,
                } = this.$refs;
                this.slider = new M.ZP(e, {
                  modules: [M.W_],
                  spaceBetween: 20,
                  slidesPerView: 3,
                  breakpoints: {
                    320: { slidesPerView: 1, spaceBetween: 40 },
                    576: { slidesPerView: 2.2, spaceBetween: 20 },
                    848: { slidesPerView: 2.5, spaceBetween: 20 },
                  },
                  navigation: { prevEl: t, nextEl: s },
                });
              },
            },
            mounted() {
              this.initSlider();
            },
            watch: {},
          },
          Qn = (0, P.Z)(Kn, Xn, [], !1, null, null, null).exports,
          el = s(171),
          tl = {
            name: "tiled-win-sys",
            components: { TiledWinDesk: Jn, TiledWinMob: Qn },
            data() {
              return { wWidth: el(window).width() };
            },
            computed: {
              ...(0, na.rn)(["type", "windows", "balconies"]),
              isDesktop() {
                return this.wWidth >= 1024;
              },
            },
            methods: {
              ...(0, na.OI)(["setType", "setData"]),
              ...(0, na.nv)(["getData"]),
              resizeWindow() {
                el(window).on("resize.tiled_win_sys", () => {
                  this.wWidth = el(window).width();
                });
              },
              setDemoDateOut() {
                for (let e of this.windows) {
                  let t = new Date();
                  (ye()(t).calc({ day: 17, hours: 11, minutes: 52 }),
                    (e.stock.dateOut = t));
                }
              },
              startStockTimerTimeOut() {
                for (let e of this.windows) {
                  let { stock: t } = e,
                    { is: s, dateOut: i } = t,
                    a = () => {
                      let e = ye()().between(ye()(i), "day"),
                        s = ye()().between(ye()(i), "hours"),
                        a = ye()().between(ye()(i), "minutes");
                      ((t.timeOut = `${e}д. ${s - 24 * e}ч. ${a - 60 * s}мин.`),
                        a || (t.timeOut = ""));
                    };
                  s && i && (a(), setInterval(() => a(), 6e4));
                }
              },
            },
            mounted() {
              (this.resizeWindow(), this.getData(this));
            },
            created() {
              (this.setType(el(".js-tiled-win-sys").data("type")),
                "balcon" == this.type && this.setData(this.balconies),
                this.setDemoDateOut(),
                this.startStockTimerTimeOut());
            },
          },
          sl = (0, P.Z)(tl, Rn, [], !1, null, null, null).exports,
          il = (e) => new (a())({ el: e, store: Zn, render: (e) => e(sl) }),
          al = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "loggia-calc__app-vue" }, [
              t("div", { staticClass: "loggia-calc__title" }, [
                e._v("Выберите тип вашего остекления"),
              ]),
              t(
                "div",
                { staticClass: "loggia-calc__type" },
                [t("loggia-calc-type", { attrs: { typeList: e.typeList } })],
                1,
              ),
              t(
                "div",
                { staticClass: "loggia-calc__option" },
                [
                  t("loggia-calc-option", {
                    attrs: { optionList: e.optionList },
                  }),
                ],
                1,
              ),
              t(
                "div",
                {
                  ref: "feedbackForm",
                  staticClass: "loggia-calc__form",
                },
                [e._m(0)],
              ),
            ]);
          };
        al._withStripped = !0;
        var nl = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "loggia-calc-type" }, [
            t(
              "div",
              {
                ref: "arrowLeft",
                staticClass: "btn-arrow loggia-calc-type__arrow arrow-left",
              },
              [
                t("svg", { staticClass: "ico" }, [
                  t("use", {
                    attrs: {
                      "xlink:href":
                        "/new_style_files/upload/icon/interface.svg#short-arrow-left",
                    },
                  }),
                ]),
              ],
            ),
            t(
              "div",
              {
                ref: "arrowRight",
                staticClass: "btn-arrow loggia-calc-type__arrow arrow-right",
              },
              [
                t("svg", { staticClass: "ico" }, [
                  t("use", {
                    attrs: {
                      "xlink:href":
                        "/new_style_files/upload/icon/interface.svg#short-arrow-right",
                    },
                  }),
                ]),
              ],
            ),
            t(
              "div",
              {
                ref: "sliderWindow",
                staticClass: "loggia-calc-type__slider swiper",
              },
              [
                t(
                  "div",
                  { staticClass: "loggia-calc-type__wrap swiper-wrapper" },
                  e._l(e.typeList, function (s, i) {
                    return t(
                      "div",
                      {
                        key: s.id,
                        staticClass: "loggia-calc-type__item swiper-slide",
                        class: { active: s.check },
                        on: {
                          click: function (t) {
                            return e.checkType(s);
                          },
                        },
                      },
                      [
                        t("img", {
                          staticClass: "loggia-calc-type__img",
                          attrs: {
                            src: s.img,
                            decoding: "async",
                            loading: "lazy",
                            alt: "",
                          },
                        }),
                      ],
                    );
                  }),
                  0,
                ),
              ],
            ),
          ]);
        };
        nl._withStripped = !0;
        var ll = {
            name: "loggia-calc-type",
            props: { typeList: Array },
            data() {
              return { slider: "" };
            },
            methods: {
              initSlider() {
                let {
                  sliderWindow: e,
                  arrowLeft: t,
                  arrowRight: s,
                } = this.$refs;
                this.slider = new M.ZP(e, {
                  modules: [M.W_],
                  spaceBetween: 20,
                  slidesPerView: 3,
                  breakpoints: {
                    320: { slidesPerView: 1, spaceBetween: 40 },
                    500: { slidesPerView: 2, spaceBetween: 20 },
                    848: { slidesPerView: 3, spaceBetween: 20 },
                  },
                  navigation: { prevEl: t, nextEl: s },
                });
              },
              checkType(e) {
                let { typeList: t } = this;
                e.check ||
                  ((e.check = !0),
                  t.forEach((t) => {
                    t.check = e.id == t.id;
                  }));
              },
            },
            mounted() {
              this.initSlider();
            },
          },
          ol = (0, P.Z)(ll, nl, [], !1, null, null, null).exports,
          rl = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "loggia-calc-option" }, [
              t(
                "div",
                {
                  ref: "sliderOption",
                  staticClass: "loggia-calc-option__slider swiper",
                },
                [
                  t(
                    "div",
                    { staticClass: "loggia-calc-option__wrap swiper-wrapper" },
                    e._l(e.optionList, function (s) {
                      return t(
                        "div",
                        {
                          key: s.id,
                          staticClass: "loggia-calc-option__item swiper-slide",
                        },
                        [
                          t(
                            "div",
                            { staticClass: "loggia-calc-option__title" },
                            [e._v(e._s(s.name))],
                          ),
                          "radio" == s.type
                            ? t(
                                "div",
                                {
                                  staticClass: "loggia-calc-option__inp-group",
                                  class: {
                                    "item-row": "row" == s.direction,
                                    "item-column": "column" == s.direction,
                                  },
                                },
                                e._l(s.items, function (i) {
                                  return t(
                                    "div",
                                    {
                                      key: i.id,
                                      staticClass:
                                        "loggia-calc-option__inp-item",
                                    },
                                    [
                                      t(
                                        "label",
                                        {
                                          staticClass:
                                            "radio-btn radio-btn--small radio-btn--black",
                                        },
                                        [
                                          t("input", {
                                            staticClass: "radio-btn__input",
                                            attrs: {
                                              type: "radio",
                                              id: i.id,
                                              name: s.id,
                                            },
                                            domProps: { checked: i.check },
                                            on: {
                                              change: function (t) {
                                                return e.checkRadio({
                                                  opt: s,
                                                  item: i,
                                                });
                                              },
                                            },
                                          }),
                                          t("label", {
                                            staticClass: "radio-btn__radio",
                                            attrs: { for: i.id },
                                          }),
                                          t(
                                            "span",
                                            { staticClass: "radio-btn__label" },
                                            [e._v(e._s(i.value))],
                                          ),
                                        ],
                                      ),
                                    ],
                                  );
                                }),
                                0,
                              )
                            : e._e(),
                          "checkbox" == s.type
                            ? t(
                                "div",
                                {
                                  staticClass: "loggia-calc-option__inp-group",
                                  class: {
                                    "item-row": "row" == s.direction,
                                    "item-column": "column" == s.direction,
                                  },
                                },
                                e._l(s.items, function (i) {
                                  return t(
                                    "div",
                                    {
                                      key: i.id,
                                      staticClass:
                                        "loggia-calc-option__inp-item",
                                    },
                                    [
                                      t(
                                        "label",
                                        {
                                          staticClass:
                                            "checkbox-small checkbox-small--black",
                                        },
                                        [
                                          t("input", {
                                            staticClass:
                                              "checkbox-small__input",
                                            attrs: {
                                              type: "checkbox",
                                              id: i.id,
                                              name: s.id,
                                            },
                                            domProps: { checked: i.check },
                                            on: {
                                              change: function (t) {
                                                return e.checkBox(i);
                                              },
                                            },
                                          }),
                                          t("label", {
                                            staticClass:
                                              "checkbox-small__checkbox",
                                            attrs: { for: i.id },
                                          }),
                                          t(
                                            "span",
                                            {
                                              staticClass:
                                                "checkbox-small__label",
                                            },
                                            [e._v(e._s(i.value))],
                                          ),
                                        ],
                                      ),
                                    ],
                                  );
                                }),
                                0,
                              )
                            : e._e(),
                        ],
                      );
                    }),
                    0,
                  ),
                ],
              ),
            ]);
          };
        rl._withStripped = !0;
        var cl = {
            name: "loggia-calc-option",
            props: { optionList: Array },
            data() {
              return { slider: "" };
            },
            methods: {
              checkRadio(e) {
                let { opt: t, item: s } = e;
                t.items.forEach((e) => {
                  e.check = e.id == s.id;
                });
              },
              checkBox(e) {
                e.check = !e.check;
              },
              initSlider() {
                let { sliderOption: e } = this.$refs;
                this.slider = new M.ZP(e, {
                  spaceBetween: 20,
                  slidesPerView: "auto",
                });
              },
            },
            mounted() {
              this.initSlider();
            },
          },
          dl = (0, P.Z)(cl, rl, [], !1, null, null, null).exports,
          ml = s(171),
          ul = {
            components: { LoggiaCalcType: ol, loggiaCalcOption: dl },
            data() {
              return {
                typeList: [
                  {
                    id: c.hash,
                    check: !0,
                    type: "type-1",
                    img: "/new_style_files/assets/img/res/loggia-calc/type-1.svg",
                  },
                  {
                    id: c.hash,
                    check: !1,
                    type: "type-2",
                    img: "/new_style_files/assets/img/res/loggia-calc/type-2.svg",
                  },
                  {
                    id: c.hash,
                    check: !1,
                    type: "type-3",
                    img: "/new_style_files/assets/img/res/loggia-calc/type-3.svg",
                  },
                ],
                optionList: [
                  {
                    id: c.hash,
                    name: "Обшивка панелями",
                    type: "radio",
                    direction: "row",
                    items: [
                      { id: c.hash, check: !0, value: "ПВХ" },
                      { id: c.hash, check: !1, value: "МДФ" },
                    ],
                  },
                  {
                    id: c.hash,
                    name: "Тип остекления",
                    type: "radio",
                    direction: "column",
                    items: [
                      { id: c.hash, check: !0, value: "холодное" },
                      { id: c.hash, check: !1, value: "тёплое" },
                    ],
                  },
                  {
                    id: c.hash,
                    name: "Утепление",
                    type: "radio",
                    direction: "row",
                    items: [
                      { id: c.hash, check: !0, value: "да" },
                      { id: c.hash, check: !1, value: "нет" },
                    ],
                  },
                  {
                    id: c.hash,
                    name: "Доп. опции",
                    type: "checkbox",
                    direction: "column",
                    items: [
                      { id: c.hash, check: !0, value: "потолочная сушилка" },
                      {
                        id: c.hash,
                        check: !1,
                        value: "тёплый пол",
                      },
                    ],
                  },
                ],
              };
            },
            methods: {
              getAction() {
                let { feedbackForm: e } = this.$refs,
                  t = ml(e).closest("[data-action]").data("action");
                t && ml(e).find("form").attr("action", t);
              },
              initForm() {
                let { feedbackForm: e } = this.$refs,
                  t = l.getComponent(".js-modal-win");
                new G(e, {
                  tooltip: !0,
                  onSubmit: (e) => {
                    let { action: s, data: i } = e,
                      { typeList: a, optionList: n } = this,
                      l = a.find((e) => e.check).type,
                      o = n.map((e) => {
                        let t = e.items.find((e) => e.check).value;
                        return { name: e.name, value: t };
                      });
                    ((i = { ...i, "balcon-type": l, options: o }),
                      R.ajaxPost({ url: s, data: i }).then((e) => {
                        (t.close(), t.open("#modal-success-form"));
                      }));
                  },
                });
              },
            },
            mounted() {
              (this.getAction(), this.initForm());
            },
          },
          pl = (0, P.Z)(
            ul,
            al,
            [
              function () {
                var e = this,
                  t = e._self._c;
                e._self._setupProxy;
                return t(
                  "form",
                  {
                    staticClass: "loggia-calc__feedback",
                    attrs: { action: "/ajax/?controller=form&action=add" },
                  },
                  [
                    t("input", {
                      attrs: {
                        type: "hidden",
                        name: "attribute",
                        value: "ct",
                      },
                    }),
                    t(
                      "div",
                      {
                        staticClass:
                          "control control--black loggia-calc__input",
                      },
                      [
                        t("div", { staticClass: "control__group" }, [
                          t(
                            "label",
                            {
                              staticClass: "control__label",
                              attrs: { for: "" },
                            },
                            [e._v("Ваш телефон")],
                          ),
                          t("input", {
                            staticClass: "control__input js-user-phone",
                            attrs: {
                              id: "",
                              name: "user-phone",
                              placeholder: "+7",
                              type: "tel",
                              required: "",
                            },
                          }),
                        ]),
                      ],
                    ),
                    t(
                      "button",
                      {
                        staticClass: "btn",
                        attrs: { type: "submit" },
                      },
                      [e._v("Рассчитать стоимость")],
                    ),
                    t("div", { staticClass: "loggia-calc__person-data" }, [
                      t(
                        "label",
                        { staticClass: "checkbox-small checkbox-small--black" },
                        [
                          t("input", {
                            staticClass: "checkbox-small__input js-person-data",
                            attrs: {
                              type: "checkbox",
                              name: "person-data",
                              id: "loggia-calc-person-data",
                              checked: "",
                            },
                          }),
                          t("label", {
                            staticClass: "checkbox-small__checkbox",
                            attrs: { for: "loggia-calc-person-data" },
                          }),
                          t("span", { staticClass: "checkbox-small__label" }, [
                            e._v("Даю согласие на обработку "),
                            t(
                              "a",
                              {
                                staticClass: "a no-style",
                                attrs: { href: "/confidence/" },
                              },
                              [e._v("персональных данных")],
                            ),
                          ]),
                        ],
                      ),
                    ]),
                  ],
                );
              },
            ],
            !1,
            null,
            null,
            null,
          ).exports,
          hl = (e) => new (a())({ el: e, render: (e) => e(pl) });
        a().use(na.ZP);
        var _l = new na.ZP.Store({
            state: {
              emptyObj: {
                width: 600,
                height: 1200,
                color: "white",
                anticat: !1,
                amount: 1,
                price: 0,
              },
              mosqList: [],
              mounting: !0,
              priceMounting: 0,
              totalPrice: 0,
              dataInfo: "",
              isDataInfo: !1,
            },
            mutations: {
              addMosq(e) {
                let { emptyObj: t, mosqList: s } = e;
                s.push(Object.assign({ id: c.hash }, t));
              },
              delMosq(e, t) {
                let { mosqList: s } = e;
                s.splice(t, 1);
              },
              setTotalPrice(e, t) {
                e.totalPrice = t;
              },
              setMounting(e, t) {
                e.mounting = t;
              },
            },
            actions: {
              async getDataInfo(e) {
                let { state: t } = e;
                R.hostname;
                return R.ajaxGet({
                  url: "/ajax/?controller=mosquitoNet&action=getinfo",
                }).then((e) => {
                  e?.success && ((t.dataInfo = e.data), (t.isDataInfo = !0));
                });
              },
              calculateMosq(e, t) {
                let {} = e;
                R.hostname;
                return R.ajaxPost({
                  url: "/ajax/?controller=mosquitoNet&action=calculate",
                  data: t,
                }).then((e) => {
                  if (e?.success) return e;
                });
              },
              setMountingData(e, t) {
                let { state: s } = e,
                  { mosqList: i } = s,
                  a = R.hostname,
                  n = "/ajax/?controller=mosquitoNet&action=setOptions",
                  l = "/ajax/?controller=mosquitoNet&action=setOptions",
                  o = t,
                  r = 0;
                for (let e of i) e.price && (r += e.amount);
                let d = { montage: o, quantity: r };
                return t && r
                  ? R.ajaxPost({
                      url: "localhost" == a ? n : l,
                      data: d,
                    }).then(
                      (e) => (
                        e.success && (s.priceMounting = c.getNum(e.data.price)),
                        !0
                      ),
                    )
                  : ((s.priceMounting = 0),
                    R.ajaxPost({
                      url: "localhost" == a ? n : l,
                      data: d,
                    }).then((e) => {}));
              },
              deleteMosq(e, t) {
                let { state: s } = e,
                  i = (R.hostname, { id: t.id });
                return R.ajaxPost({
                  url: "/ajax/?controller=mosquitoNet&action=delete",
                  data: i,
                });
              },
              clearMosq(e) {
                let { state: t } = e;
                R.hostname;
                return R.ajaxPost({
                  url: "/ajax/?controller=mosquitoNet&action=clear",
                  data: {},
                });
              },
            },
            getters: {
              getTotalAmount(e) {
                let t = 0;
                if (e.mosqList.length > 0)
                  return (
                    e.mosqList.forEach((e) => {
                      t += e.amount;
                    }),
                    t
                  );
              },
            },
          }),
          gl = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "mosq-calc__app" }, [
              t(
                "div",
                {
                  ref: "sliderMosq",
                  staticClass: "mosq-calc__slider swiper",
                },
                [
                  t(
                    "div",
                    { staticClass: "mosq-calc__wrap swiper-wrapper" },
                    e._l(e.mosqList, function (s, i) {
                      return t(
                        "div",
                        {
                          key: s.id,
                          staticClass: "mosq-calc__item swiper-slide",
                        },
                        [
                          e.mosqList.length > 1
                            ? t(
                                "div",
                                {
                                  staticClass: "mosq-calc__close",
                                  on: {
                                    click: function (t) {
                                      return e.del(i, s);
                                    },
                                  },
                                },
                                [
                                  t("svg", { staticClass: "ico" }, [
                                    t("use", {
                                      attrs: {
                                        "xlink:href":
                                          "/new_style_files/upload/icon/sprites-min.svg#close-2",
                                      },
                                    }),
                                  ]),
                                ],
                              )
                            : e._e(),
                          t("mosq-calc-cart", {
                            attrs: { data: s },
                            on: { updatePrice: e.updatePrice },
                          }),
                        ],
                        1,
                      );
                    }),
                    0,
                  ),
                  t("div", { staticClass: "mosq-calc__add-container" }, [
                    t(
                      "div",
                      {
                        staticClass: "btn-arrow mosq-calc__btn-add",
                        on: { click: e.add },
                      },
                      [
                        t("svg", { staticClass: "ico" }, [
                          t("use", {
                            attrs: {
                              "xlink:href":
                                "/new_style_files/upload/icon/sprites-min.svg#plus",
                            },
                          }),
                        ]),
                      ],
                    ),
                  ]),
                ],
              ),
              t("div", { staticClass: "mosq-calc__info" }, [
                t("svg", { staticClass: "ico" }, [
                  t("use", {
                    attrs: {
                      "xlink:href":
                        "/new_style_files/upload/icon/sprites-min.svg#warning",
                    },
                  }),
                ]),
                e._m(0),
              ]),
              t("div", { staticClass: "mosq-calc__total" }, [
                t("div", { staticClass: "mosq-calc__total-block" }, [
                  t("div", { staticClass: "mosq-calc__total-price" }, [
                    e._v("Итого с монтажом: "),
                    t("span", [e._v(e._s(e.getMoney(e.totalPrice)))]),
                    e._v(" руб"),
                  ]),
                ]),
                t("div", { staticClass: "mosq-calc__total-block" }, [
                  t("div", { staticClass: "mosq-calc__btn" }, [
                    t(
                      "button",
                      {
                        staticClass: "btn",
                        on: { click: e.toCart },
                      },
                      [e._v("Оформить заказ")],
                    ),
                  ]),
                ]),
              ]),
            ]);
          };
        gl._withStripped = !0;
        var wl = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "mosq-calc-cart" }, [
            t("div", { staticClass: "mosq-calc-cart__img" }, [
              t("img", {
                staticClass: "img",
                attrs: {
                  src: e.height > 600 ? e.srcMosqImg[1] : e.srcMosqImg[0],
                  decoding: "async",
                  loading: "lazy",
                  alt: "",
                },
              }),
            ]),
            t("div", { staticClass: "mosq-calc-cart__form" }, [
              t("div", { staticClass: "mosq-calc-cart__block" }, [
                t("div", { staticClass: "mosq-calc-cart__block-title" }, [
                  e._v("Размер сетки:"),
                ]),
                t("div", { staticClass: "mosq-calc-cart__group input-group" }, [
                  t("div", { staticClass: "control control--black" }, [
                    t("div", { staticClass: "control__group" }, [
                      t(
                        "label",
                        {
                          staticClass: "control__label",
                          attrs: { for: "" },
                        },
                        [e._v("Ширина")],
                      ),
                      t("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: e.width,
                            expression: "width",
                          },
                        ],
                        staticClass: "control__input js-user-name",
                        attrs: { id: "", type: "tel" },
                        domProps: { value: e.width },
                        on: {
                          keypress: e.inputDigits,
                          input: function (t) {
                            t.target.composing || (e.width = t.target.value);
                          },
                        },
                      }),
                    ]),
                  ]),
                  t("div", { staticClass: "control control--black" }, [
                    t("div", { staticClass: "control__group" }, [
                      t(
                        "label",
                        {
                          staticClass: "control__label",
                          attrs: { for: "" },
                        },
                        [e._v("Высота")],
                      ),
                      t("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: e.height,
                            expression: "height",
                          },
                        ],
                        staticClass: "control__input js-user-name",
                        attrs: { id: "", type: "tel" },
                        domProps: { value: e.height },
                        on: {
                          keypress: e.inputDigits,
                          input: function (t) {
                            t.target.composing || (e.height = t.target.value);
                          },
                        },
                      }),
                    ]),
                  ]),
                ]),
                e.error
                  ? t("div", { staticClass: "mosq-calc-cart__error" }, [
                      e._v(e._s(e.error)),
                    ])
                  : e._e(),
              ]),
              t("div", { staticClass: "mosq-calc-cart__block" }, [
                t("div", { staticClass: "mosq-calc-cart__block-title" }, [
                  e._v("Антикошка:"),
                ]),
                t("div", { staticClass: "mosq-calc-cart__group" }, [
                  t(
                    "label",
                    {
                      staticClass:
                        "checkbox-small checkbox-small--black checkbox-small--smaller",
                    },
                    [
                      t("input", {
                        staticClass: "checkbox-small__input js-person-data",
                        attrs: { type: "radio", id: `mosq-yes-${e.data.id}` },
                        domProps: { checked: e.data.anticat },
                        on: {
                          change: function (t) {
                            return e.checkAnticat(!0);
                          },
                        },
                      }),
                      t("label", {
                        staticClass: "checkbox-small__checkbox",
                        attrs: { for: `mosq-yes-${e.data.id}` },
                      }),
                      t("span", { staticClass: "checkbox-small__label" }, [
                        e._v("Да"),
                      ]),
                    ],
                  ),
                  t(
                    "label",
                    {
                      staticClass:
                        "checkbox-small checkbox-small--black checkbox-small--smaller",
                    },
                    [
                      t("input", {
                        staticClass: "checkbox-small__input js-person-data",
                        attrs: { type: "radio", id: `mosq-no-${e.data.id}` },
                        domProps: { checked: !e.data.anticat },
                        on: {
                          change: function (t) {
                            return e.checkAnticat(!1);
                          },
                        },
                      }),
                      t("label", {
                        staticClass: "checkbox-small__checkbox",
                        attrs: { for: `mosq-no-${e.data.id}` },
                      }),
                      t("span", { staticClass: "checkbox-small__label" }, [
                        e._v("Нет"),
                      ]),
                    ],
                  ),
                ]),
              ]),
              t("div", { staticClass: "mosq-calc-cart__block" }, [
                t("div", { staticClass: "mosq-calc-cart__block-title" }, [
                  e._v("Цвет сетки:"),
                ]),
                t(
                  "div",
                  { staticClass: "mosq-calc-cart__group" },
                  e._l(e.enumColor, function (s, i, a) {
                    return t(
                      "label",
                      {
                        key: i,
                        staticClass:
                          "checkbox-small checkbox-small--black checkbox-small--smaller",
                        attrs: { for: `mosq-color-${i}-${e.data.id}` },
                      },
                      [
                        t("input", {
                          staticClass: "checkbox-small__input js-person-data",
                          attrs: {
                            type: "radio",
                            id: `mosq-color-${i}-${e.data.id}`,
                          },
                          domProps: { checked: e.color[i] },
                          on: {
                            change: function (t) {
                              return e.checkColor(i);
                            },
                          },
                        }),
                        t("label", {
                          staticClass: "checkbox-small__checkbox",
                          attrs: { for: `mosq-color-${i}-${e.data.id}` },
                        }),
                        t("span", { staticClass: "checkbox-small__label" }, [
                          e._v(e._s(s)),
                        ]),
                      ],
                    );
                  }),
                  0,
                ),
              ]),
              t("div", { staticClass: "mosq-calc-cart__block" }, [
                t("div", { staticClass: "mosq-calc-cart__block-title" }, [
                  e._v("Количество:"),
                ]),
                t("div", { staticClass: "mosq-calc-cart__group" }, [
                  t(
                    "div",
                    {
                      staticClass: "btn-arrow mosq-calc-cart__arrow arrow-plus",
                      on: {
                        click: function (t) {
                          return e.countAmount(1);
                        },
                      },
                    },
                    [
                      t("svg", { staticClass: "ico" }, [
                        t("use", {
                          attrs: {
                            "xlink:href":
                              "/new_style_files/upload/icon/interface.svg#plus",
                          },
                        }),
                      ]),
                    ],
                  ),
                  t("div", { staticClass: "mosq-calc-cart__count" }, [
                    e._v(e._s(e.data.amount)),
                  ]),
                  t(
                    "div",
                    {
                      staticClass:
                        "btn-arrow mosq-calc-cart__arrow arrow-minus",
                      on: {
                        click: function (t) {
                          return e.countAmount(-1);
                        },
                      },
                    },
                    [
                      t("svg", { staticClass: "ico" }, [
                        t("use", {
                          attrs: {
                            "xlink:href":
                              "/new_style_files/upload/icon/interface.svg#minus",
                          },
                        }),
                      ]),
                    ],
                  ),
                ]),
              ]),
            ]),
            t("div", { staticClass: "mosq-calc-cart__price" }, [
              t("div", { staticClass: "mosq-calc-cart__block" }, [
                t("div", { staticClass: "mosq-calc-cart__block-title" }, [
                  e._v("Цена:"),
                ]),
                t("div", { staticClass: "mosq-calc-cart__price-value" }, [
                  t("span", [e._v(e._s(e.getMoney(e.data.price)))]),
                  e._v(" руб"),
                ]),
              ]),
            ]),
          ]);
        };
        wl._withStripped = !0;
        var vl = {
            name: "mosq-calc-cart",
            props: { data: Object },
            data() {
              return {
                enumColor: { white: "Белый", ral: "В цвет Ral" },
                srcMosqImg: [
                  "/new_style_files/images/aksessuary/mosq-net.svg",
                  "/new_style_files/images/aksessuary/mosq-net-2.svg",
                ],
                error: null,
              };
            },
            computed: {
              ...(0, na.rn)(["dataInfo", "isDataInfo"]),
              color() {
                let e = {};
                this.isDataInfo &&
                  this.dataInfo &&
                  (this.enumColor = this.dataInfo.enumColor);
                for (let t in this.enumColor) e[t] = this.data.color == t;
                return e;
              },
              width: {
                get() {
                  return c.getNum(this.data.width);
                },
                set(e) {
                  this.data.width = c.getNum(e);
                },
              },
              height: {
                get() {
                  return c.getNum(this.data.height);
                },
                set(e) {
                  this.data.height = c.getNum(e);
                },
              },
            },
            methods: {
              ...(0, na.nv)(["calculateMosq"]),
              getMoney(e) {
                return c.getMoney(e);
              },
              checkColor(e) {
                this.data.color = e;
              },
              checkAnticat(e) {
                this.data.anticat = e;
              },
              countAmount(e) {
                ((this.data.amount += e),
                  this.data.amount < 1 && (this.data.amount = 1));
              },
              inputDigits(e) {
                return c.inputDigits(e);
              },
              async updateDataCart() {
                let {
                    id: e,
                    width: t,
                    height: s,
                    color: i,
                    anticat: a,
                    amount: n,
                  } = this.data,
                  l = {
                    id: e,
                    width: t,
                    height: s,
                    color: i,
                    anticat: a,
                    quantity: n,
                  },
                  o = await this.calculateMosq(l);
                if (o) {
                  let e = c.getNum(o.data.price);
                  ((this.data.price = e), this.$emit("updatePrice"));
                }
              },
            },
            watch: {
              height(e) {
                c.actionFilter({
                  keyTimer: `mosq_calc_height_${this.data.id}`,
                  duration: 1500,
                  action: () => {
                    (e < 400 &&
                      ((this.height = 400),
                      (this.error = "Высота не может быть меньше 400мм")),
                      e > 1800 &&
                        ((this.height = 1800),
                        (this.error = "Высота не может быть больше 1800мм")));
                  },
                });
              },
              width(e) {
                c.actionFilter({
                  keyTimer: `mosq_calc_width_${this.data.id}`,
                  duration: 1500,
                  action: () => {
                    (e < 400 &&
                      ((this.width = 400),
                      (this.error = "Ширина не может быть меньше 400мм")),
                      e > 950 &&
                        ((this.width = 950),
                        (this.error = "Ширина не может быть больше 950мм")));
                  },
                });
              },
            },
            updated() {
              c.actionFilter({
                keyTimer: "update_mosq_cart_data",
                duration: 300,
                action: () => {
                  this.updateDataCart();
                },
              });
            },
          },
          fl = {
            name: "vue-mosq-calc",
            components: {
              MosqCalcCart: (0, P.Z)(vl, wl, [], !1, null, null, null).exports,
            },
            data() {
              return { slider: "" };
            },
            computed: {
              ...(0, na.rn)([
                "mosqList",
                "mounting",
                "priceMounting",
                "totalPrice",
              ]),
              ...(0, na.Se)(["getTotalAmount"]),
            },
            methods: {
              ...(0, na.OI)([
                "addMosq",
                "delMosq",
                "setTotalPrice",
                "setMounting",
              ]),
              ...(0, na.nv)([
                "getDataInfo",
                "setMountingData",
                "deleteMosq",
                "clearMosq",
              ]),
              getMoney(e) {
                return c.getMoney(e);
              },
              initSlider() {
                let { sliderMosq: e } = this.$refs;
                this.slider = new M.ZP(e, {
                  spaceBetween: 20,
                  slidesPerView: "auto",
                  on: {
                    init: () => {},
                  },
                });
              },
              add() {
                let { mosqList: e } = this;
                (this.addMosq(),
                  setTimeout(() => {
                    (this.slider.update(), this.slider.slideTo(e.length - 1));
                  }, 100));
              },
              del(e, t) {
                let { mosqList: s } = this;
                (this.delMosq(e),
                  this.deleteMosq(t).then((e) => {
                    (this.setMountingData(this.mounting),
                      setTimeout(() => {
                        (this.slider.update(),
                          this.slider.slideToClosest(),
                          this.updatePrice());
                      }, 100));
                  }));
              },
              async updatePrice() {
                let { mosqList: e } = this,
                  t = 0;
                (e.forEach((e) => {
                  t += e.price * e.amount;
                }),
                  (await this.setMountingData(this.mounting)) &&
                    (t += this.priceMounting),
                  this.setTotalPrice(t));
              },
              toCart() {
                new d.Z({ linkAttributeName: "data-modal-window" }).open(
                  "#modal-mosqit-order",
                );
              },
            },
            beforeMount() {
              this.clearMosq();
            },
            mounted() {
              this.initSlider();
            },
            created() {
              (this.getDataInfo(), this.addMosq());
            },
            watch: {
              mounting(e) {
                c.actionFilter({
                  keyTimer: "set_mounting_data",
                  duration: 100,
                  action: () => {
                    this.updatePrice();
                  },
                });
              },
              priceMounting(e) {},
            },
          },
          yl = (0, P.Z)(
            fl,
            gl,
            [
              function () {
                var e = this,
                  t = e._self._c;
                e._self._setupProxy;
                return t("div", { staticClass: "mosq-calc__info-desc" }, [
                  t("p", { staticClass: "p" }, [
                    e._v(
                      "Размеры москитных сеток: максмальный — 950×1800 мм, минимальный — 400×400 мм. Минимальное количество москитных сеток к заказу — 2 штуки.",
                    ),
                  ]),
                ]);
              },
            ],
            !1,
            null,
            null,
            null,
          ).exports,
          bl = (e) => new (a())({ el: e, store: _l, render: (e) => e(yl) });
        var kl = new (class {
          constructor() {
            ((this.tempus = ye()),
              (this.days = ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"]),
              (this.months = [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь",
              ]));
          }

          getMonthName(e) {
            return this.months[new Date(e).getMonth()];
          }

          getFormatDate(e) {
            return ye()(new Date(e)).format("%Y-%m-%d");
          }

          getDateDayCount(e, t) {
            return ye()(new Date(e)).day(t).format("%Y-%m-%d");
          }

          getMonthDays(e) {
            let t = ye()(new Date(e)).day(1),
              s = ye()(t.format("%Y-%m-%d")).calc({ month: 1, day: 1 });
            return t.between(s, "day");
          }

          getFirstDayMonth(e) {
            let t = ye()(new Date(e)).day(1).format("%Y-%m-%d"),
              s = new Date(t).getDay();
            return (0 == s && (s = 7), s);
          }

          betweenMonths(e, t) {
            let s = ye()(e).day(1).format("%Y-%m-%d"),
              i = ye()(t).day(2).format("%Y-%m-%d");
            return ye()(new Date(s)).between(ye()(new Date(i)), "month");
          }

          betweenDays(e, t) {
            return ye()(new Date(e)).between(ye()(new Date(t)), "day");
          }

          setMonth(e, t) {
            return ye()(new Date(e))
              .day(1)
              .calc({ month: t })
              .format("%Y-%m-%d");
          }
        })();
        a().use(na.ZP);
        var Cl = new na.ZP.Store({
            state: {
              nameDays: kl.days,
              date: kl.getFormatDate(new Date()),
              nextDate: kl.getFormatDate(new Date()),
              curDate: kl.getFormatDate(new Date()),
            },
            mutations: {
              setSelDate(e, t) {
                e.date = t;
              },
              setCurDate(e, t) {
                e.curDate = t;
              },
            },
            actions: {},
          }),
          Sl = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t(
              "div",
              { staticClass: "calendar-delivery__app" },
              [
                e.isDesktop
                  ? t("calendar-delivery-desk")
                  : t("calendar-delivery-mob"),
              ],
              1,
            );
          };
        Sl._withStripped = !0;
        var xl = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "calendar-delivery-desk" }, [
            t("div", { staticClass: "calendar-delivery-desk__ico" }, [
              t("svg", { staticClass: "ico" }, [
                t("use", {
                  attrs: {
                    "xlink:href":
                      "/new_style_files/upload/icon/sprites-min.svg#delivery-2",
                  },
                }),
              ]),
            ]),
            t("div", { staticClass: "calendar-delivery-desk__title" }, [
              e._v(e._s(e.title) + " " + e._s(e.getDateFormat(e.selDate))),
            ]),
            t("div", { staticClass: "calendar-delivery-desk__desc" }, [
              e._v(
                "Для выбора удобной даты и времени наш менеджер свяжется с Вами дополнительно.",
              ),
            ]),
          ]);
        };
        xl._withStripped = !0;
        var Pl = {
            name: "calendar-delivery-desk",
            data() {
              return { title: "Ближайшая дата доставки" };
            },
            computed: {
              ...(0, na.rn)(["nameDays", "date", "nextDate", "curDate"]),
              dataDays() {
                let e = kl.getMonthDays(this.curDate),
                  t = kl.getFirstDayMonth(this.curDate),
                  s = [];
                for (let i = 0; i < 7 * Math.ceil((e + t) / 7); i++) {
                  let a = Math.trunc(i / 7),
                    n = i + 1 - (t - 1);
                  (s.length != a + 1 && s.push([]),
                    i < t - 1 || n > e
                      ? s[a].push("")
                      : s[a].push({
                          num: n,
                          date: kl.getDateDayCount(this.curDate, n),
                        }));
                }
                return (
                  7 == s[s.length - 1].filter((e) => !e).length &&
                    s.splice(s.length - 1, 1),
                  s
                );
              },
              curMonth() {
                return kl.getMonthName(this.curDate);
              },
              curYear() {
                return new Date(this.curDate).getFullYear();
              },
              selDate: {
                get() {
                  return this.date;
                },
                set(e) {
                  this.setSelDate(e);
                },
              },
            },
            methods: {
              ...(0, na.OI)(["setSelDate", "setCurDate"]),
              dayBetween(e) {
                return kl.betweenDays(this.nextDate, e);
              },
              betweenMonths(e) {
                return kl.betweenMonths(this.nextDate, e);
              },
              selectDate(e) {
                ((this.selDate = e), (this.title = "Выбранная дата доставки"));
              },
              setMonth(e) {
                let t = kl.setMonth(this.curDate, e);
                this.setCurDate(t);
              },
              getDateFormat(e) {
                return kl.tempus(e).format("%d.%m.%Y");
              },
            },
            mounted() {},
            created() {
              this.selDate = this.date;
            },
            watch: {},
          },
          jl = (0, P.Z)(Pl, xl, [], !1, null, null, null).exports,
          ql = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "calendar-delivery-mob" }, [
              t("div", { staticClass: "calendar-delivery-mob__ico" }, [
                t("svg", { staticClass: "ico" }, [
                  t("use", {
                    attrs: {
                      "xlink:href":
                        "/new_style_files/upload/icon/sprites-min.svg#delivery-2",
                    },
                  }),
                ]),
              ]),
              t("div", { staticClass: "calendar-delivery-mob__title" }, [
                e._v(e._s(e.title) + " " + e._s(e.getDateFormat(e.selDate))),
              ]),
              t("div", { staticClass: "calendar-delivery-mob__desc" }, [
                e._v(
                  "Для выбора удобной даты и времени наш менеджер свяжется с Вами дополнительно.",
                ),
              ]),
            ]);
          };
        ql._withStripped = !0;
        var Dl = {
            name: "calendar-delivery-mob",
            data() {
              return {
                title: "Ближайшая дата доставки",
                sliderMonth: "",
                sliderDays: "",
              };
            },
            computed: {
              ...(0, na.rn)(["nameDays", "date", "nextDate", "curDate"]),
              monthData() {
                let e = [];
                for (let t = 0; t < 8; t++) {
                  let s = kl
                      .tempus(this.nextDate)
                      .day(1)
                      .calc({ month: t })
                      .format("%Y-%m-%d"),
                    i = kl.getMonthName(s),
                    a = kl.tempus(s).format("%Y").replace("20", "");
                  e.push({ title: `${i}\`${a}`, date: s });
                }
                return e;
              },
              dayData() {
                let e = kl.getMonthDays(this.curDate),
                  t = kl
                    .tempus(new Date(this.curDate))
                    .day(1)
                    .format("%Y-%m-%d"),
                  s = [];
                for (let i = 0; i < e; i++)
                  s.push({
                    num: i + 1,
                    date: kl.tempus(t).calc({ day: i }).format("%Y-%m-%d"),
                  });
                return s;
              },
              selDate: {
                get() {
                  return this.date;
                },
                set(e) {
                  this.setSelDate(e);
                },
              },
            },
            methods: {
              ...(0, na.OI)(["setSelDate", "setCurDate"]),
              getDateFormat(e) {
                return kl.tempus(e).format("%d.%m.%Y");
              },
              betweenMonths(e) {
                return kl.betweenMonths(this.curDate, e);
              },
              dayBetween(e) {
                return kl.betweenDays(this.nextDate, e);
              },
              setMonth(e) {
                let t = kl.setMonth(this.nextDate, e);
                (this.setCurDate(t),
                  setTimeout(() => {
                    this.sliderDays.update();
                  }, 10));
              },
              selectDate(e) {
                ((this.selDate = e), (this.title = "Выбранная дата доставки"));
              },
              compareMonth(e) {
                let t = new Date(this.curDate),
                  s = new Date(e);
                return t.getMonth() == s.getMonth();
              },
              initSliderMonth() {
                let { sliderMonths: e } = this.$refs;
                this.sliderMonth = new M.ZP(e, {
                  spaceBetween: 16,
                  slidesPerView: "auto",
                  on: {
                    init: () => {},
                  },
                });
              },
              initSliderDay() {
                let { sliderDays: e, arrowLeft: t, arrowRight: s } = this.$refs;
                this.sliderDays = new M.ZP(e, {
                  modules: [M.W_],
                  spaceBetween: 10,
                  slidesPerView: "auto",
                  navigation: { prevEl: t, nextEl: s },
                  on: {
                    init: (e) => {
                      let t = new Date(this.nextDate).getDate();
                      e.slideTo(t - 1);
                    },
                  },
                });
              },
            },
            mounted() {
              this.initSliderMonth();
            },
            created() {
              this.selDate = this.date;
            },
            watch: {},
          },
          Ll = (0, P.Z)(Dl, ql, [], !1, null, null, null).exports,
          Ml = s(171),
          $l = {
            name: "calendar-delivery",
            components: { CalendarDeliveryDesk: jl, CalendarDeliveryMob: Ll },
            data() {
              return { windowWidth: Ml(window).width() };
            },
            computed: {
              ...(0, na.rn)(["selDate"]),
              isDesktop() {
                return this.windowWidth > 499;
              },
            },
            methods: {
              resizeWindow() {
                let e = this;
                Ml(window).on("resize", function () {
                  e.windowWidth = Ml(window).width();
                });
              },
            },
            created() {
              this.resizeWindow();
            },
          },
          zl = (0, P.Z)($l, Sl, [], !1, null, null, null).exports,
          El = (e) => new (a())({ el: e, store: Cl, render: (e) => e(zl) });
        a().use(na.ZP);
        var Fl = new na.ZP.Store({
            state: {
              deliveryPrice: 500,
              mountingPrice: 0,
              deliveryDate: kl.tempus(new Date()).format("%d.%m.%Y"),
              mosqData: [],
              enumColor: {
                black: "Чёрный",
                white: "Белый",
                anthracite: "Антрацит",
              },
            },
            mutations: {
              setMounting(e, t) {
                e.mountingPrice = c.getNum(t);
              },
              buildMosqData(e, t) {
                let s = [];
                for (let [i, a] of Object.entries(t)) {
                  let { size: t, color: n, price: l, quantity: o, cat: r } = a;
                  s.push({
                    id: i,
                    color: n,
                    width: c.getNum(t.split("x")[0]),
                    height: c.getNum(t.split("x")[1]),
                    amount: o,
                    price: c.getNum(l),
                    anticat: !!r,
                    mounting: !e.mountingPrice,
                  });
                }
                e.mosqData = s;
              },
            },
            actions: {
              async getDataInfo(e) {
                let { state: t } = e;
                R.hostname;
                return R.ajaxGet({
                  url: "/ajax/?controller=mosquitoNet&action=getinfo",
                }).then((e) => {
                  if (e?.success) {
                    let {
                      enumColor: s,
                      deliveryPrice: i,
                      deliveryDate: a,
                    } = e.data;
                    (s && (t.enumColor = s),
                      i && (t.deliveryPrice = i),
                      a && (t.deliveryDate = a));
                  }
                  return !0;
                });
              },
              async getData(e, t) {
                let { state: s, commit: i, dispatch: a } = e;
                R.hostname;
                return R.ajaxGet({
                  url: "/ajax/?controller=mosquitoNet&action=getBasket",
                }).then((e) => {
                  if (e?.success) {
                    let { items: t, options: n } = e.data;
                    (n?.montage && (s.mountingPrice = n.montage),
                      i("buildMosqData", t),
                      a("setMountingData", !!n.montage));
                  }
                });
              },
              calculateMosq(e, t) {
                let {} = e;
                R.hostname;
                return R.ajaxPost({
                  url: "/ajax/?controller=mosquitoNet&action=calculate",
                  data: t,
                }).then((e) => {
                  if (e?.success) return e;
                });
              },
              setMountingData(e, t) {
                let { state: s } = e,
                  { mosqData: i } = s,
                  a = R.hostname,
                  n = "/ajax/?controller=mosquitoNet&action=setOptions",
                  l = "/ajax/?controller=mosquitoNet&action=setOptions",
                  o = t,
                  r = 0;
                for (let e of i) e.price && (r += e.amount);
                let d = { montage: o, quantity: r };
                return t && r
                  ? R.ajaxPost({
                      url: "localhost" == a ? n : l,
                      data: d,
                    }).then(
                      (e) => (
                        e.success && (s.mountingPrice = c.getNum(e.data.price)),
                        !0
                      ),
                    )
                  : ((s.mountingPrice = 0),
                    R.ajaxPost({
                      url: "localhost" == a ? n : l,
                      data: d,
                    }).then((e) => {}));
              },
              deleteMosq(e, t, s) {
                let { state: i } = e,
                  a = (R.hostname, { id: t.id });
                return R.ajaxPost({
                  url: "/ajax/?controller=mosquitoNet&action=delete",
                  data: a,
                });
              },
            },
          }),
          Ol = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t(
              "div",
              {
                directives: [
                  {
                    name: "show",
                    rawName: "v-show",
                    value: e.mosqData.length,
                    expression: "mosqData.length",
                  },
                ],
                staticClass: "mosq-basket",
              },
              [
                e.isDesktop ? t("mosq-basket-desk") : e._e(),
                e.isDesktop ? e._e() : t("mosq-basket-mob"),
                t("div", { staticClass: "mosq-basket__pre-price" }, [
                  e._v("Доставка: "),
                  t("span", { staticClass: "span" }, [
                    e._v(e._s(e.getMoney(e.deliveryPrice)) + " руб"),
                  ]),
                ]),
                t("div", { staticClass: "mosq-basket__pre-price" }, [
                  e._v("Монтаж: "),
                  t("span", { staticClass: "span" }, [
                    e._v(e._s(e.getMoney(e.mountingPrice)) + " руб"),
                  ]),
                ]),
                t("div", { staticClass: "mosq-basket__total-price" }, [
                  e._v("Итого к оплате: "),
                  t("span", { staticClass: "span" }, [
                    e._v(e._s(e.getMoney(e.totalPrice)) + " руб"),
                  ]),
                ]),
              ],
              1,
            );
          };
        Ol._withStripped = !0;
        var Tl = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "mosq-basket-desk" }, [
            t("table", { staticClass: "mosq-basket-desk__table" }, [
              t("thead", { staticClass: "mosq-basket-desk__thead" }, [
                t(
                  "tr",
                  { staticClass: "mosq-basket-desk__row" },
                  e._l(e.column, function (s) {
                    return t(
                      "th",
                      {
                        key: s.type,
                        staticClass: "mosq-basket-desk__th",
                        class: `th-${s.type}`,
                      },
                      [
                        "mounting" != s.type && "delivery" != s.type
                          ? t("div", { staticClass: "th-ceil" }, [
                              e._v(e._s(s.name)),
                            ])
                          : e._e(),
                      ],
                    );
                  }),
                  0,
                ),
              ]),
              t(
                "tbody",
                { staticClass: "mosq-basket-desk__tbody" },
                e._l(e.mosqData, function (s, i) {
                  return t(
                    "tr",
                    { key: s.id, staticClass: "mosq-basket-desk__row" },
                    e._l(e.column, function (a) {
                      return t(
                        "td",
                        {
                          key: a.type,
                          staticClass: "mosq-basket-desk__td",
                          class: `td-${a.type}`,
                        },
                        [
                          "title" == a.type
                            ? t(
                                "div",
                                { staticClass: "mosq-basket-desk__ceil" },
                                [
                                  e._v("Москитная сетка"),
                                  t("div", { staticClass: "span" }, [
                                    e._v(
                                      e._s(s.anticat ? "антикошка" : "обычная"),
                                    ),
                                  ]),
                                ],
                              )
                            : e._e(),
                          "color" == a.type
                            ? t(
                                "div",
                                { staticClass: "mosq-basket-desk__ceil" },
                                [e._v(e._s(e.enumColor[s.color]))],
                              )
                            : e._e(),
                          "size" == a.type
                            ? t(
                                "div",
                                { staticClass: "mosq-basket-desk__ceil" },
                                [
                                  e._v(
                                    e._s(e.getNum(s.width)) +
                                      "×" +
                                      e._s(e.getNum(s.height)) +
                                      " мм",
                                  ),
                                ],
                              )
                            : e._e(),
                          "amount" == a.type
                            ? t(
                                "div",
                                { staticClass: "mosq-basket-desk__ceil" },
                                [
                                  t(
                                    "div",
                                    {
                                      staticClass:
                                        "btn-arrow mosq-basket-desk__arrow btn-minus",
                                      on: {
                                        click: function (t) {
                                          e.countAmount(s, -1);
                                        },
                                      },
                                    },
                                    [
                                      t("svg", { staticClass: "ico" }, [
                                        t("use", {
                                          attrs: {
                                            "xlink:href":
                                              "/new_style_files/upload/icon/interface.svg#minus",
                                          },
                                        }),
                                      ]),
                                    ],
                                  ),
                                  t(
                                    "div",
                                    {
                                      staticClass:
                                        "mosq-basket-desk__num-amount",
                                    },
                                    [e._v(e._s(e.getNum(s.amount)) + " шт.")],
                                  ),
                                  t(
                                    "div",
                                    {
                                      staticClass:
                                        "btn-arrow mosq-basket-desk__arrow btn-plus",
                                      on: {
                                        click: function (t) {
                                          e.countAmount(s, 1);
                                        },
                                      },
                                    },
                                    [
                                      t("svg", { staticClass: "ico" }, [
                                        t("use", {
                                          attrs: {
                                            "xlink:href":
                                              "/new_style_files/upload/icon/interface.svg#plus",
                                          },
                                        }),
                                      ]),
                                    ],
                                  ),
                                ],
                              )
                            : e._e(),
                          "price" == a.type
                            ? t(
                                "div",
                                { staticClass: "mosq-basket-desk__ceil" },
                                [
                                  e._v(
                                    e._s(e.getMoney(s.price * s.amount)) +
                                      " руб",
                                  ),
                                ],
                              )
                            : e._e(),
                          "action" == a.type
                            ? t(
                                "div",
                                { staticClass: "mosq-basket-desk__ceil" },
                                [
                                  t(
                                    "div",
                                    {
                                      staticClass:
                                        "btn-arrow mosq-basket-desk__arrow btn-remove",
                                      on: {
                                        click: function (t) {
                                          return e.removeRow(s, i);
                                        },
                                      },
                                    },
                                    [
                                      t("svg", { staticClass: "ico" }, [
                                        t("use", {
                                          attrs: {
                                            "xlink:href":
                                              "/new_style_files/upload/icon/sprites-min.svg#remove-urn",
                                          },
                                        }),
                                      ]),
                                    ],
                                  ),
                                ],
                              )
                            : e._e(),
                        ],
                      );
                    }),
                    0,
                  );
                }),
                0,
              ),
            ]),
          ]);
        };
        Tl._withStripped = !0;
        var Bl = [
            { type: "title", name: "Наименование", show: !0 },
            {
              type: "color",
              name: "Цвет",
              show: !0,
            },
            { type: "size", name: "Размер", show: !0 },
            { type: "mounting", name: "Монтаж", show: !0 },
            {
              type: "delivery",
              name: "Доставка",
              show: !0,
            },
            { type: "amount", name: "Кол-во", show: !0 },
            { type: "price", name: "К оплате", show: !0 },
            {
              type: "action",
              name: "",
              show: !0,
            },
          ],
          Il = {
            name: "mosq-basket-desk",
            data() {
              return { column: Bl };
            },
            computed: {
              ...(0, na.rn)([
                "mosqData",
                "mountingPrice",
                "deliveryPrice",
                "enumColor",
              ]),
            },
            methods: {
              ...(0, na.nv)(["setMountingData", "deleteMosq", "calculateMosq"]),
              getMoney(e) {
                return c.getMoney(e);
              },
              getNum(e) {
                return c.getNum(e);
              },
              countAmount(e, t) {
                ((e.amount += t), e.amount < 1 && (e.amount = 1));
                let {
                    id: s,
                    width: i,
                    height: a,
                    color: n,
                    anticat: l,
                    amount: o,
                  } = e,
                  r = {
                    id: s,
                    width: i,
                    height: a,
                    color: n,
                    anticat: l,
                    quantity: o,
                  };
                (this.calculateMosq(r),
                  this.mountingPrice &&
                    c.actionFilter({
                      action: "counting_msq_amount",
                      duration: 300,
                      action: () => {
                        this.setMountingData(!0);
                      },
                    }));
              },
              removeRow(e, t) {
                this.mosqData.length > 1 &&
                  this.deleteMosq(e, t).then((e) => {
                    !0 === e.success && this.mosqData.splice(t, 1);
                  });
              },
            },
          },
          Wl = (0, P.Z)(Il, Tl, [], !1, null, null, null).exports,
          Al = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "mosq-basket-mob" }, [
              t(
                "div",
                {
                  ref: "sliderMosq",
                  staticClass: "mosq-basket-mob__slider swiper",
                },
                [
                  t(
                    "div",
                    { staticClass: "mosq-basket-mob__wrap swiper-wrapper" },
                    e._l(e.mosqData, function (s, i) {
                      return t(
                        "div",
                        {
                          key: s.id,
                          staticClass: "mosq-basket-mob__item swiper-slide",
                        },
                        [
                          e.mosqData.length > 1
                            ? t(
                                "span",
                                {
                                  staticClass: "mosq-basket-mob__close",
                                  on: {
                                    click: function (t) {
                                      return e.removeRow(s, i);
                                    },
                                  },
                                },
                                [
                                  t("svg", { staticClass: "ico" }, [
                                    t("use", {
                                      attrs: {
                                        "xlink:href":
                                          "/new_style_files/upload/icon/interface.svg#close-2",
                                      },
                                    }),
                                  ]),
                                ],
                              )
                            : e._e(),
                          t(
                            "div",
                            {
                              staticClass: "mosq-basket-mob__block type-title",
                            },
                            [
                              t(
                                "div",
                                { staticClass: "mosq-basket-mob__block-title" },
                                [e._v("Наименование")],
                              ),
                              t(
                                "div",
                                { staticClass: "mosq-basket-mob__block-value" },
                                [
                                  e._v("Москитная сетка"),
                                  t("div", { staticClass: "span" }, [
                                    e._v(
                                      e._s(s.anticat ? "антикошка" : "обычная"),
                                    ),
                                  ]),
                                ],
                              ),
                            ],
                          ),
                          t("div", { staticClass: "mosq-basket-mob__block" }, [
                            t(
                              "div",
                              { staticClass: "mosq-basket-mob__block-title" },
                              [e._v("Цвет")],
                            ),
                            t(
                              "div",
                              { staticClass: "mosq-basket-mob__block-value" },
                              [e._v(e._s(e.enumColor[s.color]))],
                            ),
                          ]),
                          t("div", { staticClass: "mosq-basket-mob__block" }, [
                            t(
                              "div",
                              { staticClass: "mosq-basket-mob__block-title" },
                              [e._v("Размер")],
                            ),
                            t(
                              "div",
                              { staticClass: "mosq-basket-mob__block-value" },
                              [
                                e._v(
                                  e._s(e.getNum(s.width)) +
                                    "×" +
                                    e._s(e.getNum(s.height)) +
                                    "мм",
                                ),
                              ],
                            ),
                          ]),
                          t(
                            "div",
                            {
                              staticClass: "mosq-basket-mob__block type-amount",
                            },
                            [
                              t(
                                "div",
                                { staticClass: "mosq-basket-mob__block-title" },
                                [e._v("Кол-во")],
                              ),
                              t(
                                "div",
                                { staticClass: "mosq-basket-mob__block-value" },
                                [
                                  t(
                                    "div",
                                    {
                                      staticClass:
                                        "btn-arrow mosq-basket-mob__arrow btn-minus",
                                      on: {
                                        click: function (t) {
                                          e.countAmount(s, -1);
                                        },
                                      },
                                    },
                                    [
                                      t("svg", { staticClass: "ico" }, [
                                        t("use", {
                                          attrs: {
                                            "xlink:href":
                                              "/new_style_files/upload/icon/interface.svg#minus",
                                          },
                                        }),
                                      ]),
                                    ],
                                  ),
                                  t(
                                    "div",
                                    {
                                      staticClass:
                                        "mosq-basket-mob__num-amount",
                                    },
                                    [e._v(e._s(e.getNum(s.amount)) + "шт")],
                                  ),
                                  t(
                                    "div",
                                    {
                                      staticClass:
                                        "btn-arrow mosq-basket-mob__arrow btn-plus",
                                      on: {
                                        click: function (t) {
                                          e.countAmount(s, 1);
                                        },
                                      },
                                    },
                                    [
                                      t("svg", { staticClass: "ico" }, [
                                        t("use", {
                                          attrs: {
                                            "xlink:href":
                                              "/new_style_files/upload/icon/interface.svg#plus",
                                          },
                                        }),
                                      ]),
                                    ],
                                  ),
                                ],
                              ),
                            ],
                          ),
                          t(
                            "div",
                            {
                              staticClass: "mosq-basket-mob__block type-price",
                            },
                            [
                              t(
                                "div",
                                { staticClass: "mosq-basket-mob__block-title" },
                                [e._v("К оплате")],
                              ),
                              t(
                                "div",
                                { staticClass: "mosq-basket-mob__block-value" },
                                [
                                  e._v(
                                    e._s(e.getMoney(s.price * s.amount)) +
                                      " руб",
                                  ),
                                ],
                              ),
                            ],
                          ),
                        ],
                      );
                    }),
                    0,
                  ),
                ],
              ),
            ]);
          };
        Al._withStripped = !0;
        var Vl = {
            name: "mosq-basket-mob",
            data() {
              return {};
            },
            computed: {
              ...(0, na.rn)([
                "mosqData",
                "mountingPrice",
                "deliveryPrice",
                "enumColor",
              ]),
            },
            methods: {
              ...(0, na.nv)(["setMountingData", "deleteMosq", "calculateMosq"]),
              getMoney(e) {
                return c.getMoney(e);
              },
              getNum(e) {
                return c.getNum(e);
              },
              countAmount(e, t) {
                ((e.amount += t), e.amount < 1 && (e.amount = 1));
                let {
                    id: s,
                    width: i,
                    height: a,
                    color: n,
                    anticat: l,
                    amount: o,
                  } = e,
                  r = {
                    id: s,
                    width: i,
                    height: a,
                    color: n,
                    anticat: l,
                    quantity: o,
                  };
                (this.calculateMosq(r),
                  this.mountingPrice &&
                    c.actionFilter({
                      action: "counting_msq_amount",
                      duration: 300,
                      action: () => {
                        this.setMountingData(!0);
                      },
                    }));
              },
              removeRow(e, t) {
                this.mosqData.length > 1 &&
                  this.deleteMosq(e, t).then((e) => {
                    e.success && this.mosqData.splice(t, 1);
                  });
              },
              initSlider() {
                let { sliderMosq: e } = this.$refs;
                this.slider = new M.ZP(e, {
                  spaceBetween: 20,
                  slidesPerView: "auto",
                  on: {
                    init: () => {},
                  },
                });
              },
            },
            mounted() {
              this.initSlider();
            },
          },
          Nl = (0, P.Z)(Vl, Al, [], !1, null, null, null).exports,
          Zl = s(171),
          Rl = {
            name: "mosq-basket",
            components: { MosqBasketDesk: Wl, MosqBasketMob: Nl },
            data() {
              return { windowWidth: Zl(window).width() };
            },
            computed: {
              ...(0, na.rn)([
                "deliveryDate",
                "deliveryPrice",
                "mountingPrice",
                "mosqData",
              ]),
              totalPrice() {
                let e = 0;
                return (
                  (e += this.deliveryPrice),
                  (e += this.mountingPrice),
                  this.mosqData.forEach((t) => {
                    e += t.price * t.amount;
                  }),
                  e
                );
              },
              isDesktop() {
                return this.windowWidth > 768;
              },
              countMosqData() {
                return this.mosqData.length;
              },
            },
            methods: {
              ...(0, na.nv)(["getDataInfo", "getData"]),
              getMoney(e) {
                return c.getMoney(e);
              },
              resizeWindow() {
                let e = this;
                Zl(window).on("resize", function () {
                  e.windowWidth = Zl(window).width();
                });
              },
              setHeadCount() {
                Zl(".js-mosq-сheckout-head-prod-count").text(
                  this.countMosqData,
                );
              },
              setHeadTotalPrice() {
                Zl(".js-mosq-сheckout-head-total-price").text(
                  c.getMoney(this.totalPrice),
                );
              },
              setTemplatePriceDelivery(e) {
                Zl(function () {
                  Zl(".js-mosq-checkout-form")
                    .find(".js-price-delivery")
                    .text(c.getMoney(e));
                });
              },
            },
            mounted() {
              (this.setHeadTotalPrice(),
                this.setHeadCount(),
                this.setTemplatePriceDelivery(this.deliveryPrice));
            },
            created() {
              (this.resizeWindow(),
                this.getDataInfo().then((e) => {
                  this.getData();
                }));
            },
            watch: {
              totalPrice() {
                this.setHeadTotalPrice();
              },
              countMosqData() {
                this.setHeadCount();
              },
              deliveryPrice(e) {
                this.setTemplatePriceDelivery(e);
              },
              deliveryDate(e) {
                let t = l.getComponent("#vue-calendar-delivery").$store.state,
                  s = kl.tempus(e).format("%Y-%m-%d");
                ((t.curDate = s), (t.nextDate = s), (t.date = s));
              },
            },
          },
          Ul = (0, P.Z)(Rl, Ol, [], !1, null, null, null).exports,
          Gl = (e) => new (a())({ el: e, store: Fl, render: (e) => e(Ul) });
        a().use(na.ZP);
        var Hl = new na.ZP.Store({ state: {}, mutations: {}, actions: {} }),
          Yl = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t(
              "div",
              { staticClass: "payment-online" },
              [
                e.modalErrorData.isShow
                  ? t("calc-modal-error", {
                      attrs: { message: e.modalErrorData.message },
                      on: {
                        onClose: function (t) {
                          return e.setModalError({ isShow: !1, message: "" });
                        },
                      },
                    })
                  : e._e(),
                t(
                  "form",
                  {
                    ref: "payForm",
                    staticClass: "payment-online__form",
                    attrs: { action: "" },
                    on: { submit: e.submitForm },
                  },
                  [
                    e._l(e.payData, function (s, i) {
                      return t("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: e.payData[i],
                            expression: "payData[key]",
                          },
                        ],
                        key: i,
                        attrs: { type: "hidden", name: i },
                        domProps: { value: e.payData[i] },
                        on: {
                          input: function (t) {
                            t.target.composing ||
                              e.$set(e.payData, i, t.target.value);
                          },
                        },
                      });
                    }),
                    t(
                      "div",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: 1 == e.step,
                            expression: "step == 1",
                          },
                        ],
                        staticClass: "payment-online__step",
                      },
                      [
                        t("div", { staticClass: "payment-online__part" }, [
                          e._v("Шаг 1"),
                        ]),
                        t("div", { staticClass: "payment-online__title h3" }, [
                          e._v(
                            "Заполните номер договора и телефон, чтобы загрузить информацио об оплате",
                          ),
                        ]),
                        t(
                          "div",
                          {
                            staticClass: "payment-online__input-group control",
                          },
                          [
                            t("div", { staticClass: "control__group" }, [
                              t(
                                "div",
                                { staticClass: "payment-online__input" },
                                [
                                  t("input", {
                                    ref: "payDoc",
                                    staticClass: "control__input",
                                    attrs: {
                                      type: "text",
                                      inputmode: "numeric",
                                      name: "num-doc",
                                      autocomplete: "off",
                                      placeholder: "123456",
                                    },
                                  }),
                                  t(
                                    "div",
                                    {
                                      staticClass:
                                        "payment-online__input-label",
                                    },
                                    [e._v("Номер договора XX.123456.XX")],
                                  ),
                                ],
                              ),
                              t(
                                "div",
                                { staticClass: "payment-online__input" },
                                [
                                  t("input", {
                                    ref: "payPhone",
                                    staticClass: "control__input",
                                    attrs: {
                                      type: "tel",
                                      inputmode: "tel",
                                      name: "phone",
                                      autocomplete: "tel",
                                      placeholder: "+7 (___) ___-__-__",
                                    },
                                  }),
                                  t(
                                    "div",
                                    {
                                      staticClass:
                                        "payment-online__input-label",
                                    },
                                    [e._v("Ваш телефон")],
                                  ),
                                ],
                              ),
                            ]),
                          ],
                        ),
                      ],
                    ),
                    t(
                      "div",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value:
                              2 == e.step &&
                              e.orderInfo &&
                              0 == e.orderInfo?.split,
                            expression:
                              "step == 2 && orderInfo && orderInfo?.split == 0",
                          },
                        ],
                        staticClass: "payment-online__step",
                      },
                      [
                        t("div", { staticClass: "payment-online__part" }, [
                          e._v("Шаг 2"),
                        ]),
                        t("div", { staticClass: "payment-online__title h3" }, [
                          e._v("Подтвердите сумму к оплате"),
                        ]),
                        t("div", { staticClass: "payment-online__title h4" }, [
                          e._v(
                            "Договор " +
                              e._s(e.orderInfo?.dogovor) +
                              " на " +
                              e._s(e.orderInfo?.username) +
                              ".",
                          ),
                        ]),
                        t("div", { staticClass: "payment-online__title h4" }, [
                          e._v(
                            "Полная задолжность " +
                              e._s(e.orderInfo?.dolg) +
                              " руб.",
                          ),
                        ]),
                        t(
                          "div",
                          {
                            staticClass: "payment-online__input-group control",
                          },
                          [
                            t("div", { staticClass: "control__group" }, [
                              t(
                                "div",
                                {
                                  staticClass:
                                    "payment-online__input payment-online__input-100",
                                },
                                [
                                  t("input", {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: e.total_price,
                                        expression: "total_price",
                                      },
                                    ],
                                    staticClass: "control__input",
                                    attrs: {
                                      type: "text",
                                      inputmode: "number",
                                      autocomplete: "off",
                                      placeholder: "0",
                                    },
                                    domProps: { value: e.total_price },
                                    on: {
                                      keypress: e.inputDigits,
                                      input: function (t) {
                                        t.target.composing ||
                                          (e.total_price = t.target.value);
                                      },
                                    },
                                  }),
                                  t(
                                    "div",
                                    {
                                      staticClass:
                                        "payment-online__input-label",
                                    },
                                    [e._v("Сумма к оплате")],
                                  ),
                                ],
                              ),
                            ]),
                          ],
                        ),
                        t("div", { staticClass: "payment-online__btn-group" }, [
                          t(
                            "button",
                            {
                              staticClass: "btn payment-online__total-pay-btn",
                              on: { click: e.approveSum },
                            },
                            [e._v("Дальше")],
                          ),
                        ]),
                      ],
                    ),
                    t(
                      "div",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: 3 == e.step && 0 == e.orderInfo.split,
                            expression: "step == 3 && orderInfo.split == 0",
                          },
                        ],
                        staticClass: "payment-online__step",
                      },
                      [
                        t("div", { staticClass: "payment-online__part" }, [
                          e._v("Шаг 3"),
                        ]),
                        t("div", { staticClass: "payment-online__title h3" }, [
                          e._v("Для получения чека введите email"),
                        ]),
                        t(
                          "div",
                          {
                            staticClass: "payment-online__input-group control",
                          },
                          [
                            t("div", { staticClass: "control__group" }, [
                              t(
                                "div",
                                {
                                  staticClass:
                                    "payment-online__input payment-online__input-100",
                                },
                                [
                                  t("input", {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: e.email,
                                        expression: "email",
                                      },
                                    ],
                                    staticClass: "control__input",
                                    attrs: {
                                      type: "email",
                                      inputmode: "email",
                                      autocomplete: "email",
                                      placeholder: "person@mail.ru",
                                      name: "email",
                                    },
                                    domProps: { value: e.email },
                                    on: {
                                      input: [
                                        function (t) {
                                          t.target.composing ||
                                            (e.email = t.target.value);
                                        },
                                        e.validateEmail,
                                      ],
                                    },
                                  }),
                                ],
                              ),
                            ]),
                          ],
                        ),
                        t("div", { staticClass: "payment-online__btn-group" }, [
                          t(
                            "button",
                            {
                              staticClass: "btn payment-online__total-pay-btn",
                              attrs: {
                                type: "submit",
                                disabled: !(
                                  e.isValidForm &&
                                  e.total_price &&
                                  e.isSubmit
                                ),
                              },
                            },
                            [e._v("Оплатить")],
                          ),
                        ]),
                        e._m(0),
                      ],
                    ),
                    t(
                      "div",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: 2 == e.step && 1 == e.orderInfo.split,
                            expression: "step == 2 && orderInfo.split == 1",
                          },
                        ],
                        staticClass: "payment-online__step",
                      },
                      [
                        t("div", { staticClass: "payment-online__part" }, [
                          e._v("Шаг 2"),
                        ]),
                        t("div", { staticClass: "payment-online__title h3" }, [
                          e._v("Оплата"),
                        ]),
                        t("div", { staticClass: "payment-online__title h4" }, [
                          e._v(
                            "Договор " +
                              e._s(e.orderInfo?.dogovor) +
                              " на " +
                              e._s(e.orderInfo?.username) +
                              ".",
                          ),
                        ]),
                        t("div", { staticClass: "payment-online__title h4" }, [
                          e._v(
                            "Сумма к оплате " +
                              e._s(e.orderInfo?.dolg) +
                              " руб.",
                          ),
                        ]),
                        t(
                          "div",
                          {
                            staticClass: "payment-online__input-group control",
                          },
                          [
                            t("div", { staticClass: "control__group" }, [
                              t(
                                "div",
                                {
                                  staticClass:
                                    "payment-online__input payment-online__input-100",
                                },
                                [
                                  t("input", {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: e.email,
                                        expression: "email",
                                      },
                                    ],
                                    staticClass: "control__input",
                                    attrs: {
                                      type: "email",
                                      inputmode: "email",
                                      autocomplete: "email",
                                      placeholder: "person@mail.ru",
                                      name: "email",
                                    },
                                    domProps: { value: e.email },
                                    on: {
                                      input: [
                                        function (t) {
                                          t.target.composing ||
                                            (e.email = t.target.value);
                                        },
                                        e.validateEmail,
                                      ],
                                    },
                                  }),
                                  t(
                                    "div",
                                    {
                                      staticClass:
                                        "payment-online__input-label",
                                    },
                                    [
                                      e._v(
                                        "На данный email мы отправим чек об оплате",
                                      ),
                                    ],
                                  ),
                                ],
                              ),
                            ]),
                          ],
                        ),
                        t("div", { staticClass: "payment-online__split" }, [
                          t("div", {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: e.isValid.email,
                                expression: "isValid.email",
                              },
                            ],
                            ref: "yaSection",
                            staticClass: "payment-online__split-data",
                          }),
                        ]),
                        e._m(1),
                      ],
                    ),
                  ],
                  2,
                ),
              ],
              1,
            );
          };
        Yl._withStripped = !0;
        var Jl = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "calc-modal-error" }, [
            t(
              "div",
              {
                staticClass: "hystmodal modal-win",
                attrs: { "aria-hidden": "true", id: "modal-calc-error" },
              },
              [
                t("div", { staticClass: "hystmodal__wrap modal-win__wrap" }, [
                  t(
                    "div",
                    {
                      staticClass: "hystmodal__window modal-win__window",
                      attrs: { role: "dialog", "aria-modal": "true" },
                    },
                    [
                      t(
                        "div",
                        { staticClass: "modal-win__container modal-calc-win" },
                        [
                          t("div", { staticClass: "modal-win__content" }, [
                            t("div", { staticClass: "modal-win__head-title" }, [
                              e._v("Ошибка!!! "),
                              t("br"),
                              e._v(" " + e._s(e.message)),
                            ]),
                            e._m(0),
                          ]),
                        ],
                      ),
                    ],
                  ),
                ]),
              ],
            ),
          ]);
        };
        Jl._withStripped = !0;
        var Xl = {
            name: "calc-modal-error",
            props: { message: String },
            data() {
              return { modal: "" };
            },
            mounted() {
              ((this.modal = new d.Z({
                linkAttributeName: "data-calc-modal",
                beforeOpen: () => {},
                afterClose: () => {
                  this.$emit("onClose");
                },
              })),
                this.modal.open("#modal-calc-error"));
            },
          },
          Kl = (0, P.Z)(
            Xl,
            Jl,
            [
              function () {
                var e = this,
                  t = e._self._c;
                e._self._setupProxy;
                return t("div", { staticClass: "modal-win__btn" }, [
                  t(
                    "div",
                    {
                      staticClass: "btn",
                      attrs: { "data-hystclose": "" },
                    },
                    [e._v("ОК")],
                  ),
                ]);
              },
            ],
            !1,
            null,
            null,
            null,
          ).exports,
          Ql = s(171),
          eo = {
            name: "payment-online",
            components: { CalcModalError: Kl },
            data() {
              return {
                step: 1,
                canPay: !1,
                num_doc: "",
                phone: "",
                email: "",
                phoneMask: null,
                docMask: null,
                orderInfo: null,
                isChecking: !1,
                total_price: "",
                total_price_max: "",
                curNumOrder: "",
                isSubmit: !0,
                isValid: { num_doc: "", phone: "", email: "" },
                payData: {
                  AMOUNT: "",
                  BACKREF: "",
                  CURRENCY: "",
                  DESC: "",
                  EMAIL: "",
                  MERCHANT: "",
                  MERCH_NAME: "",
                  NONCE: "",
                  ORDER: "",
                  P_SIGN: "",
                  TERMINAL: "",
                  TIMESTAMP: "",
                  TRTYPE: "",
                  NOTIFY_URL: "",
                },
                isSubmitForm: !1,
                modalErrorData: { isShow: !1, message: "" },
                yaPay: !1,
                yaPaymentData: {},
              };
            },
            computed: {
              isValidForm() {
                let { num_doc: e, phone: t, email: s } = this.isValid;
                return Boolean(e && t && s);
              },
              isValidCustomer() {
                let { num_doc: e, phone: t } = this.isValid;
                return Boolean(e && t);
              },
            },
            methods: {
              approveSum() {
                this.step = 3;
              },
              getMoney(e) {
                return c.getMoney(e);
              },
              inputDigits(e) {
                return c.inputDigits(e);
              },
              getPhone(e) {
                ((this.phone = e.target.value), this.validatePhone());
              },
              getDoc(e) {
                ((this.num_doc = e.target.value), this.validateNumDoc());
              },
              initInputmaskPhone() {
                let e = this,
                  { payPhone: t } = this.$refs,
                  s = Ql(t);
                ((this.phoneMask = (0, N.ZP)(s[0], {
                  mask: "+{7} (000) 000-00-00",
                  prepare: function (e, t) {
                    if (t.value.includes("+7") && "8" == t.value[3]) {
                      let e = t.value.replace("8", "");
                      t.value = e;
                    }
                    return e;
                  },
                })),
                  s.on("input", function (t) {
                    e.getPhone(t);
                  }));
              },
              initInputmaskDoc() {
                let e = this,
                  { payDoc: t } = this.$refs,
                  s = Ql(t);
                ((this.docMask = (0, N.ZP)(s[0], { mask: "000000" })),
                  s.on("input", function (t) {
                    e.getDoc(t);
                  }));
              },
              validateNumDoc() {
                this.isValid.num_doc = Boolean(
                  this.num_doc &&
                    this.num_doc.replace(/[^0-9]/gim, "").length >= 6,
                );
              },
              validatePhone() {
                this.isValid.phone = Boolean(
                  this.phone &&
                    this.phone.replace(/[^0-9]/gim, "").length >= 11,
                );
              },
              validateEmail() {
                let e = new RegExp(
                  /^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u,
                );
                this.isValid.email = e.test(this.email);
              },
              setInputForm(e) {
                let { payForm: t } = this.$refs,
                  s = Ql(t);
                if (e) {
                  s.attr("action", e.URL);
                  for (let t in this.payData)
                    (e[t] && (this.payData[t] = e[t]),
                      "AMOUNT" == t &&
                        e[t] &&
                        ((this.total_price = c.getNum(e[t])),
                        this.curNumOrder != this.num_doc &&
                          ((this.total_price_max = this.total_price),
                          (this.curNumOrder = this.num_doc))));
                } else {
                  ((this.total_price = ""), s.attr("action", ""));
                  for (let e in this.payData) this.payData[e] = "";
                }
              },
              async getOrderInfo() {
                let e = this,
                  t = {
                    "num-doc": e.num_doc,
                    phone: e.phone.replace(/[^0-9]/gim, ""),
                  };
                return R.ajaxPost({
                  url: "/api/crm/order/info",
                  data: t,
                }).then(
                  (t) => (
                    t.success
                      ? ((e.orderInfo = t.data),
                        (e.total_price = e.total_price_max =
                          c.getNum(t.data.dolg)),
                        152732 == e.orderInfo.docnum &&
                          ((e.orderInfo.dolg = "20000"),
                          (e.orderInfo.split = "1"),
                          (e.total_price = 2e4),
                          (e.total_price_max = 2e4),
                          (e.orderInfo.docnum =
                            e.orderInfo.docnum +
                            Math.floor(1e3 * Math.random()) +
                            Math.floor(1e3 * Math.random()))),
                        1 == e.orderInfo.split && this.loadYaPay(),
                        (e.step = 2))
                      : (e.setInputForm(!1),
                        e.setModalError({
                          isShow: !0,
                          message: t.message,
                        })),
                    t
                  ),
                );
              },
              async testJWT() {
                return R.ajaxPost({
                  url: "/api/payment/yandex/callback",
                  data: {},
                }).then((e) => {
                  e.success;
                });
              },
              async getAjaxData(e) {
                let { payCredit: t } = e,
                  s = {
                    ajax: "y",
                    payCredit: t ? "y" : "",
                    "num-doc": this.num_doc,
                    phone: this.phone.replace(/[^0-9]/gim, ""),
                    email: this.email,
                    price: c.getNum(this.total_price),
                  };
                return R.ajaxPost({ url: "", data: s }).then((e) => {
                  if (e.success) {
                    let t = e.data.PAYMENT;
                    (this.setInputForm(t), (this.canPay = !0));
                  } else
                    (this.setInputForm(!1),
                      this.setModalError({ isShow: !0, message: e.message }));
                  return e;
                });
              },
              submitForm(e) {
                e.preventDefault();
                let { modalErrorData: t } = this,
                  { payForm: s } = this.$refs,
                  i = Ql(s);
                i.attr("action") &&
                  ((this.isSubmit = !1),
                  this.getAjaxData({}).then((e) => {
                    ((this.isSubmitForm = !0),
                      e.success
                        ? i[0].submit()
                        : this.setModalError({
                            isShow: !0,
                            message: e.message,
                          }));
                  }));
              },
              setModalError(e) {
                let { isShow: t, message: s } = e,
                  { modalErrorData: i } = this;
                (void 0 !== t && (i.isShow = t),
                  void 0 !== s && (i.message = s));
              },
              checkQuarry() {
                let e = Object.fromEntries(
                  new URLSearchParams(window.location.search).entries(),
                );
                if (e?.docnum && e?.phone) {
                  let t = this;
                  setTimeout(() => {
                    let { payDoc: s, payPhone: i } = t.$refs;
                    (Ql(i)[0], Ql(s)[0]);
                    ((t.phoneMask.value = `+7${e.phone.slice(1, 11)}`),
                      (t.docMask.value = e.docnum),
                      (t.phone = t.phoneMask.unmaskedValue),
                      (t.num_doc = t.docMask.unmaskedValue),
                      t.validateNumDoc(),
                      t.validatePhone(),
                      document
                        .querySelector("#cardpay")
                        .scrollIntoView({ behavior: "smooth" }),
                      t.getOrderInfo());
                  }, 500);
                }
              },
              async getYandexData() {
                let e = this,
                  t = {
                    numdoc: e.num_doc,
                    amount: e.total_price,
                    email: e.email,
                  };
                return R.ajaxPost({
                  url: "/api/payment/yandex/geturl",
                  data: t,
                }).then((e) => {
                  if (e.success) return e.data.paymentUrl;
                });
              },
              async loadYaPay() {
                let e = document.createElement("script");
                ((e.src = "https://pay.yandex.ru/sdk/v1/pay.js"),
                  document.head.append(e),
                  (e.onload = () => {
                    (this.onYaPayLoad(),
                      this.yaPay ||
                        ((this.yaPay = !0), this.createYaSession()));
                  }));
              },
              onYaPayLoad() {
                if (window?.YaPay) {
                  let e = {
                    env: isDev
                      ? window.YaPay.PaymentEnv.Sandbox
                      : window.YaPay.PaymentEnv.Production,
                    version: 4,
                    currencyCode: window.YaPay.CurrencyCode.Rub,
                    merchantId: "34b18330-d8e4-493b-92e9-b992c903ab92",
                    totalAmount: this.total_price,
                    availablePaymentMethods: ["SPLIT"],
                  };
                  this.yaPaymentData = e;
                }
              },
              onFormOpenError(e) {},
              createYaSession() {
                let e = this.$refs.yaSection;
                window.YaPay.createSession(this.yaPaymentData, {
                  onPayButtonClick: this.getYandexData,
                  onFormOpenError: this.onFormOpenError,
                })
                  .then((t) => {
                    t.mountWidget(e, {
                      widgetType: YaPay.WidgetType.BnplOffer,
                      buttonTheme: YaPay.ButtonTheme.Black,
                      bnplSelected: !0,
                      borderRadius: 10,
                    });
                  })
                  .catch((e) => {});
              },
            },
            mounted() {
              (this.initInputmaskPhone(),
                this.initInputmaskDoc(),
                window.location.search && this.checkQuarry());
            },
            watch: {
              isValidForm(e) {
                e ? this.getAjaxData({}) : this.setInputForm(!1);
              },
              isValidCustomer(e) {
                this.orderInfo ||
                  (e ? this.getOrderInfo({}) : this.setInputForm(!1));
              },
              total_price(e) {
                let t = c.getNum(e);
                e &&
                  (t <= this.total_price_max
                    ? (this.payData.AMOUNT = t)
                    : ((this.total_price = this.total_price_max),
                      (this.payData.AMOUNT = this.total_price_max)));
              },
            },
          },
          to = (0, P.Z)(
            eo,
            Yl,
            [
              function () {
                var e = this,
                  t = e._self._c;
                e._self._setupProxy;
                return t("div", { staticClass: "payment-online__info" }, [
                  e._v("Нажимая на кнопку «Оплатить» вы принимаете условия "),
                  t(
                    "a",
                    {
                      staticClass: "a",
                      attrs: { href: "/confidence/", target: "_blank" },
                    },
                    [e._v(" политики конфиденциальности")],
                  ),
                  e._v(
                    " в отношении обработки персональных данных и подтверждаете, что ознакомлены с правилами оплаты пластиковыми картами.",
                  ),
                ]);
              },
              function () {
                var e = this,
                  t = e._self._c;
                e._self._setupProxy;
                return t("div", { staticClass: "payment-online__info" }, [
                  e._v("Нажимая на кнопку «Оплатить» вы принимаете условия "),
                  t(
                    "a",
                    {
                      staticClass: "a",
                      attrs: { href: "/confidence/", target: "_blank" },
                    },
                    [e._v(" политики конфиденциальности")],
                  ),
                  e._v(
                    " в отношении обработки персональных данных и подтверждаете, что ознакомлены с правилами оплаты пластиковыми картами.",
                  ),
                  t("br"),
                  e._v("Оплачивая заказы через Яндекс Сплит вы принимаете "),
                  t(
                    "a",
                    {
                      staticClass: "a",
                      attrs: { href: "/oferta/yandex/", target: "_blank" },
                    },
                    [e._v("условия оферты")],
                  ),
                  e._v("."),
                ]);
              },
            ],
            !1,
            null,
            null,
            null,
          ).exports,
          so = (e) => new (a())({ el: e, store: Hl, render: (e) => e(to) }),
          io = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "article-content" }, [
              e.contentData.length
                ? t("h3", { staticClass: "h3 article-content__title" }, [
                    e._v("Содержание"),
                  ])
                : e._e(),
              t(
                "ul",
                e._l(e.contentData, function (s) {
                  return t("li", { key: s.id }, [
                    t("a", { attrs: { href: `#${s.id}` } }, [
                      e._v(e._s(s.title)),
                    ]),
                  ]);
                }),
                0,
              ),
            ]);
          };
        io._withStripped = !0;
        var ao = s(171),
          no = {
            name: "article-content",
            data() {
              return { contentData: [] };
            },
            methods: {
              buildData() {
                ao(".js-article-detail")
                  .find("[name]")
                  .each((e, t) => {
                    let s = `${ao(t).attr("name")}-${c.hash}`,
                      i = ao(t).text().trim();
                    if (!i) {
                      i = ao(t).parent().text().trim();
                    }
                    (ao(t).attr("id", s),
                      i && this.contentData.push({ id: s, title: i }));
                  });
              },
              setToBack() {
                let e = ao(".js-article-detail").find(".js-toback"),
                  t = ao("nav.bread-crumbs").find("a"),
                  s = ao(t[t.length - 1]).attr("href");
                e.attr("href", s);
              },
            },
            mounted() {
              (this.buildData(), this.setToBack());
            },
            watch: {
              contentData() {
                setTimeout(() => {
                  _.initSmoothScrollToAnchor();
                }, 100);
              },
            },
          },
          lo = (0, P.Z)(no, io, [], !1, null, null, null).exports,
          oo = (e) => new (a())({ el: e, render: (e) => e(lo) });
        a().use(na.ZP);
        var ro = new na.ZP.Store({
            state: {
              winData: [],
              isLoadWinData: !1,
              winDataOpen: [],
              isOneBatch: !1,
              winDataFilter: [],
              basketWinData: [],
            },
            mutations: {
              batchWin(e) {
                let { winDataFilter: t, winDataOpen: s } = e,
                  i = t.length,
                  a = [];
                (i >= 12
                  ? (a = t.splice(0, 12))
                  : i < 12 && i > 0 && (a = t.splice(0, i)),
                  a.length && (s.push(...a), (e.isOneBatch = !0)));
              },
              setFilter(e, t) {
                let {
                    height: s,
                    width: i,
                    numberSashes: a,
                    numberСameras: n,
                    mountingDepth: l,
                    currentSystem: o,
                  } = t,
                  [r, c] = s.range,
                  [d, m] = i.range;
                ((e.winDataOpen = []),
                  (e.winDataFilter = e.winData.filter((e) => {
                    let t = !0,
                      s = !1,
                      i = !1,
                      u = !1;
                    return (
                      (t = t && r <= Number(e.height) && c >= Number(e.height)),
                      (t = t && d <= Number(e.width) && m >= Number(e.width)),
                      a.forEach((t) => {
                        t.value == Number(e.numberSashes) && (s = s || t.is);
                      }),
                      (t = t && s),
                      l.forEach((t) => {
                        t.value == Number(e.mountingDepth) && (i = i || t.is);
                      }),
                      (t = t && i),
                      n.forEach((t) => {
                        let s = e.props.filter((e) => 81 == e.id);
                        t.value == s[0].value && (u = u || t.is);
                      }),
                      (t = t && u),
                      0 !== o.value && (t = t && o.value == e.system.id),
                      t
                    );
                  })),
                  this.commit("batchWin"));
              },
            },
            actions: {
              async getData(e) {
                let { state: t, commit: s } = e;
                R.hostname;
                return R.ajaxGet({
                  url: "/ajax/?controller=FullWindows&action=getList",
                }).then(
                  (e) => (
                    e?.success &&
                      ((t.winData = e.data.map((e) => ({
                        ...e,
                        type: "win",
                      }))),
                      (t.winDataFilter = [...t.winData]),
                      (t.isLoadWinData = !0),
                      s("batchWin")),
                    e
                  ),
                );
              },
              async getDataWin(e, t) {
                let { state: s } = e,
                  i = R.hostname,
                  a = "/ajax/?controller=FullWindows&action=getWin&id=" + t,
                  n = "/ajax/?controller=FullWindows&action=getWin&id=" + t;
                return R.ajaxGet({ url: "localhost" == i ? a : n }).then(
                  (e) => (
                    e?.success &&
                      s.winData.push({
                        ...e.data,
                        type: "win",
                      }),
                    e
                  ),
                );
              },
              async getBasketData(e) {
                let { state: t } = e;
                R.hostname;
                return R.ajaxGet({
                  url: "/ajax/?controller=FullWindows&action=basket",
                }).then((e) => {
                  if (e?.success) {
                    let s = e.data;
                    t.basketWinData = s;
                  }
                  return e;
                });
              },
              async addBasket(e, t) {
                let { state: s } = e;
                R.hostname;
                (R.ajaxPost({
                  url: "/ajax/?controller=FullWindows&action=add",
                  data: { id: t.id },
                }).then((e) => (e?.success, e)),
                  s.basketWinData.push(t));
              },
              async delBasket(e, t) {
                let { state: s } = e;
                R.hostname;
                R.ajaxPost({
                  url: "/ajax/?controller=FullWindows&action=delete",
                  data: { id: t.id },
                }).then((e) => (e?.success, e));
                let i = s.basketWinData.findIndex((e) => e.id == t.id);
                s.basketWinData.splice(i, 1);
              },
            },
          }),
          co = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "window-catalog__app" }, [
              t("h2", { staticClass: "h2 window-catalog__head-title" }, [
                e._v("Цены на стандартные окна"),
              ]),
              t("div", { staticClass: "window-catalog__top-panel" }, [
                t(
                  "div",
                  {
                    ref: "btnFilter",
                    staticClass: "window-catalog__btn-filter",
                    on: {
                      click: function (t) {
                        e.isShowFilter = !e.isShowFilter;
                      },
                    },
                  },
                  [
                    t("svg", { staticClass: "ico" }, [
                      t("use", {
                        attrs: {
                          "xlink:href":
                            "/new_style_files/assets/img/ico/sprites-pack-2.svg#filter",
                        },
                      }),
                    ]),
                  ],
                ),
                t(
                  "div",
                  {
                    staticClass: "window-catalog__btn-basket",
                    on: { click: e.goBasket },
                  },
                  [
                    t("div", { staticClass: "window-catalog__num-basket" }, [
                      e._v(e._s(e.basketWinData.length)),
                    ]),
                    t("svg", { staticClass: "ico" }, [
                      t("use", {
                        attrs: {
                          "xlink:href":
                            "/new_style_files/upload/icon/interface.svg#shopping-cart",
                        },
                      }),
                    ]),
                  ],
                ),
              ]),
              t("div", { staticClass: "window-catalog__wrapper" }, [
                t(
                  "div",
                  {
                    ref: "catalogFilter",
                    staticClass: "window-catalog__filter",
                    class: { "open-filter": e.isShowFilter },
                  },
                  [
                    t("catalog-filter", {
                      on: {
                        apply: function (t) {
                          e.isShowFilter = !1;
                        },
                      },
                    }),
                  ],
                  1,
                ),
                t(
                  "div",
                  { staticClass: "window-catalog__block-items" },
                  [
                    e._l(e.winDataOpen, function (s, i) {
                      return [
                        t("catalog-cart", {
                          key: s.id,
                          attrs: { win: s },
                        }),
                        5 == i
                          ? t("div", { staticClass: "catalog-banner" }, [
                              e._m(0, !0),
                            ])
                          : e._e(),
                      ];
                    }),
                    e.isLoadWinData && !e.winDataOpen.length
                      ? t("div", { staticClass: "window-catalog__empty" }, [
                          t("p", [
                            e._v(
                              "Извините, по данным параметрам ничего не найдено...",
                            ),
                          ]),
                          t("p", [e._v("Попробуйте их сбросить!")]),
                        ])
                      : e._e(),
                  ],
                  2,
                ),
              ]),
              e.isLoadWinData && e.winDataFilter.length
                ? t("div", { staticClass: "window-catalog__btn" }, [
                    t(
                      "div",
                      {
                        staticClass: "btn btn--black-invert",
                        on: { click: e.batchWin },
                      },
                      [e._v("Ещё...")],
                    ),
                  ])
                : e._e(),
            ]);
          };
        co._withStripped = !0;
        var mo = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t(
            "div",
            {
              staticClass: "catalog-filter",
              class: { "filter-updated": e.isUpdatedFilter },
            },
            [
              t("div", { staticClass: "catalog-filter__block" }, [
                t("div", { staticClass: "catalog-filter__block-title" }, [
                  e._v("Системы"),
                ]),
                t(
                  "div",
                  { staticClass: "catalog-filter__block-group group-column" },
                  [
                    t("calc-select", {
                      staticClass: "theme-bw theme-bgmain",
                      attrs: { data: e.profileSystem },
                      on: { input: e.updSystem },
                    }),
                  ],
                  1,
                ),
              ]),
              t("div", { staticClass: "catalog-filter__block" }, [
                t("div", { staticClass: "catalog-filter__block-title" }, [
                  e._v("Количество створок"),
                ]),
                t(
                  "div",
                  { staticClass: "catalog-filter__block-group group-row" },
                  e._l(e.numberSashes, function (s, i) {
                    return t(
                      "div",
                      {
                        key: s.id,
                        staticClass: "catalog-filter__checkbox",
                      },
                      [
                        t("label", { staticClass: "checkbox-small" }, [
                          t("input", {
                            staticClass: "checkbox-small__input",
                            attrs: {
                              name: "number-sashes",
                              id: `checkbox-small-${s.id}`,
                              type: "checkbox",
                            },
                            domProps: { checked: s.is },
                            on: {
                              input: function (t) {
                                return e.checkNumberSashes(s);
                              },
                            },
                          }),
                          t("label", {
                            staticClass: "checkbox-small__checkbox",
                            attrs: { for: `checkbox-small-${s.id}` },
                          }),
                          t("span", { staticClass: "checkbox-small__label" }, [
                            e._v(e._s(s.name)),
                          ]),
                        ]),
                      ],
                    );
                  }),
                  0,
                ),
              ]),
              t("div", { staticClass: "catalog-filter__block" }, [
                t("div", { staticClass: "catalog-filter__block-title" }, [
                  e._v("Стеклопакет"),
                ]),
                t(
                  "div",
                  { staticClass: "catalog-filter__block-group group-column" },
                  e._l(e.numberСameras, function (s, i) {
                    return t(
                      "div",
                      {
                        key: s.id,
                        staticClass: "catalog-filter__checkbox",
                      },
                      [
                        t("label", { staticClass: "checkbox-small" }, [
                          t("input", {
                            staticClass: "checkbox-small__input",
                            attrs: {
                              name: "number-cameras",
                              id: `checkbox-small-${s.id}`,
                              type: "checkbox",
                            },
                            domProps: { checked: s.is },
                            on: {
                              input: function (t) {
                                e.checkNumberСameras(s);
                              },
                            },
                          }),
                          t("label", {
                            staticClass: "checkbox-small__checkbox",
                            attrs: { for: `checkbox-small-${s.id}` },
                          }),
                          t("span", { staticClass: "checkbox-small__label" }, [
                            e._v(e._s(s.name)),
                          ]),
                        ]),
                      ],
                    );
                  }),
                  0,
                ),
              ]),
              t("div", { staticClass: "catalog-filter__block" }, [
                t("div", { staticClass: "catalog-filter__block-title" }, [
                  e._v("Монтажная глубина"),
                ]),
                t(
                  "div",
                  { staticClass: "catalog-filter__block-group group-row" },
                  e._l(e.mountingDepth, function (s, i) {
                    return t(
                      "div",
                      {
                        key: s.id,
                        staticClass: "catalog-filter__checkbox",
                      },
                      [
                        t("label", { staticClass: "checkbox-small" }, [
                          t("input", {
                            staticClass: "checkbox-small__input",
                            attrs: {
                              name: "mounting-depth",
                              id: `checkbox-small-${s.id}`,
                              type: "checkbox",
                            },
                            domProps: { checked: s.is },
                            on: {
                              input: function (t) {
                                return e.checkMountingDepth(s);
                              },
                            },
                          }),
                          t("label", {
                            staticClass: "checkbox-small__checkbox",
                            attrs: { for: `checkbox-small-${s.id}` },
                          }),
                          t("span", { staticClass: "checkbox-small__label" }, [
                            e._v(e._s(s.name)),
                          ]),
                        ]),
                      ],
                    );
                  }),
                  0,
                ),
              ]),
              t("div", { staticClass: "catalog-filter__block" }, [
                t("div", { staticClass: "catalog-filter__block-title" }, [
                  e._v("Высота"),
                ]),
                t("div", { staticClass: "catalog-filter__block-group" }, [
                  t(
                    "div",
                    { staticClass: "catalog-filter__range" },
                    [
                      t("dual-range-slider", {
                        attrs: {
                          min: e.height.min,
                          max: e.height.max,
                          range: e.height.range,
                        },
                        on: { change: e.setHeightRange },
                      }),
                    ],
                    1,
                  ),
                  t("div", { staticClass: "catalog-filter__input-group" }, [
                    t("div", { staticClass: "label" }, [e._v("от")]),
                    t("div", { staticClass: "control control--black" }, [
                      t("div", { staticClass: "control__group" }, [
                        t("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: e.height.range[0],
                              expression: "height.range[0]",
                            },
                          ],
                          staticClass: "control__input js-user-phone",
                          domProps: { value: e.height.range[0] },
                          on: {
                            input: [
                              function (t) {
                                t.target.composing ||
                                  e.$set(e.height.range, 0, t.target.value);
                              },
                              function (t) {
                                return e.validateSize(e.height, 1e3);
                              },
                            ],
                          },
                        }),
                      ]),
                    ]),
                    t("div", { staticClass: "label" }, [e._v("до")]),
                    t("div", { staticClass: "control control--black" }, [
                      t("div", { staticClass: "control__group" }, [
                        t("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: e.height.range[1],
                              expression: "height.range[1]",
                            },
                          ],
                          staticClass: "control__input js-user-phone",
                          domProps: { value: e.height.range[1] },
                          on: {
                            input: [
                              function (t) {
                                t.target.composing ||
                                  e.$set(e.height.range, 1, t.target.value);
                              },
                              function (t) {
                                return e.validateSize(e.height, 1e3);
                              },
                            ],
                          },
                        }),
                      ]),
                    ]),
                  ]),
                ]),
              ]),
              t("div", { staticClass: "catalog-filter__block" }, [
                t("div", { staticClass: "catalog-filter__block-title" }, [
                  e._v("Ширина"),
                ]),
                t("div", { staticClass: "catalog-filter__block-group" }, [
                  t(
                    "div",
                    { staticClass: "catalog-filter__range" },
                    [
                      t("dual-range-slider", {
                        attrs: {
                          min: e.height.min,
                          max: e.width.max,
                          range: e.width.range,
                        },
                        on: { change: e.setWidthRange },
                      }),
                    ],
                    1,
                  ),
                  t("div", { staticClass: "catalog-filter__input-group" }, [
                    t("div", { staticClass: "label" }, [e._v("от")]),
                    t("div", { staticClass: "control control--black" }, [
                      t("div", { staticClass: "control__group" }, [
                        t("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: e.width.range[0],
                              expression: "width.range[0]",
                            },
                          ],
                          staticClass: "control__input js-user-phone",
                          domProps: { value: e.width.range[0] },
                          on: {
                            input: [
                              function (t) {
                                t.target.composing ||
                                  e.$set(e.width.range, 0, t.target.value);
                              },
                              function (t) {
                                return e.validateSize(e.width, 1e3);
                              },
                            ],
                          },
                        }),
                      ]),
                    ]),
                    t("div", { staticClass: "label" }, [e._v("до")]),
                    t("div", { staticClass: "control control--black" }, [
                      t("div", { staticClass: "control__group" }, [
                        t("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: e.width.range[1],
                              expression: "width.range[1]",
                            },
                          ],
                          staticClass: "control__input js-user-phone",
                          domProps: { value: e.width.range[1] },
                          on: {
                            input: [
                              function (t) {
                                t.target.composing ||
                                  e.$set(e.width.range, 1, t.target.value);
                              },
                              function (t) {
                                return e.validateSize(e.width, 1e3);
                              },
                            ],
                          },
                        }),
                      ]),
                    ]),
                  ]),
                ]),
              ]),
              t("div", { staticClass: "catalog-filter__btn-apply" }, [
                t(
                  "div",
                  {
                    staticClass: "btn",
                    on: { click: e.filterApply },
                  },
                  [e._v("Применить")],
                ),
              ]),
              t(
                "div",
                {
                  staticClass: "catalog-filter__reset",
                  on: { click: e.clearFilter },
                },
                [e._v("Сбросить фильтр")],
              ),
            ],
          );
        };
        mo._withStripped = !0;
        var uo = function () {
          var e = this._self._c;
          this._self._setupProxy;
          return e("div", { staticClass: "dual-range-slider" });
        };
        uo._withStripped = !0;
        var po = s(171),
          ho = {
            name: "dual-range-slider",
            props: { range: Array, min: Number, max: Number },
            data() {
              return {};
            },
            methods: {
              init() {
                let { min: e, max: t, $el: s } = this;
                (us().create(s, {
                  start: this.range,
                  orientation: "horizontal",
                  connect: !0,
                  step: 1,
                  range: { min: e, max: t },
                }),
                  s.noUiSlider.off("change.filterRangeSlider"),
                  s.noUiSlider.on("change.filterRangeSlider", (e) => {
                    let t = e.map((e) => c.getNum(e));
                    this.$emit("change", t);
                  }),
                  s.noUiSlider.off("update.filterRangeSlider"),
                  s.noUiSlider.on("update.filterRangeSlider", (e) => {}),
                  s.noUiSlider.off("set.filterRangeSlider"),
                  s.noUiSlider.on("set.filterRangeSlider", () => {}),
                  s.noUiSlider.off("slide.filterRangeSlider"),
                  s.noUiSlider.on("slide.filterRangeSlider", () => {
                    if (!s.windowScroll) {
                      let e = po(window).width();
                      ((s.windowScroll = !0),
                        e < 1200 && po("body").addClass("no-scroll"));
                    }
                    c.actionFilter({
                      keyTimer: "slide_filterRangeSlider",
                      duration: 500,
                      action() {
                        ((s.windowScroll = !1),
                          po("body").removeClass("no-scroll"));
                      },
                    });
                  }));
              },
              update(e) {},
            },
            mounted() {
              this.init();
            },
            watch: {
              range(e) {
                let { $el: t } = this;
                t.noUiSlider.set(e);
              },
              min(e) {
                let { $el: t, range: s } = this;
                (t.noUiSlider.updateOptions({
                  range: { min: s[0], max: s[1] },
                }),
                  t.noUiSlider.set(s));
              },
            },
          },
          _o = {
            name: "catalog-filter",
            components: {
              FilterRangeSlider: bn,
              DualRangeSlider: (0, P.Z)(ho, uo, [], !1, null, null, null)
                .exports,
              CalcSelect: wa,
            },
            data() {
              return {
                profileSystem: [
                  { id: c.hash, title: "Все", value: 0, is: !0 },
                  {
                    id: c.hash,
                    title: "Lite`60",
                    value: 283,
                    is: !0,
                  },
                  { id: c.hash, title: "Lite`70", value: 290, is: !0 },
                ],
                currentSystem: { id: c.hash, title: "Все", value: 0, is: !0 },
                height: { range: [400, 800], min: 0, max: 1e3 },
                width: { range: [400, 800], min: 0, max: 1e3 },
                numberSashes: [
                  { id: c.hash, name: "1", value: 1, is: !0 },
                  {
                    id: c.hash,
                    name: "2",
                    value: 2,
                    is: !0,
                  },
                  { id: c.hash, name: "3", value: 3, is: !0 },
                ],
                numberСameras: [
                  {
                    id: c.hash,
                    name: "Однокамерный",
                    value: "Однокамерный",
                    is: !0,
                  },
                  {
                    id: c.hash,
                    name: "Двухкамерный",
                    value: "Двухкамерный",
                    is: !0,
                  },
                  {
                    id: c.hash,
                    name: "Энергосберегающий",
                    value: "Энергосберегающий",
                    is: !0,
                  },
                ],
                mountingDepth: [
                  { id: c.hash, name: "60", value: 60, is: !0 },
                  {
                    id: c.hash,
                    name: "70",
                    value: 70,
                    is: !0,
                  },
                  { id: c.hash, name: "100", value: 100, is: !0 },
                ],
                isUpdatedFilter: !1,
              };
            },
            computed: { ...(0, na.rn)(["winData", "isLoadWinData"]) },
            methods: {
              ...(0, na.OI)(["setFilter"]),
              checkNumberSashes(e) {
                ((e.is = !e.is), (this.isUpdatedFilter = !0));
              },
              checkNumberСameras(e) {
                ((e.is = !e.is), (this.isUpdatedFilter = !0));
              },
              checkMountingDepth(e) {
                ((e.is = !e.is), (this.isUpdatedFilter = !0));
              },
              updSystem(e) {
                this.currentSystem.value != e &&
                  ((this.currentSystem = this.profileSystem.filter(
                    (t) => t.value == e,
                  )[0]),
                  (this.isUpdatedFilter = !0));
              },
              validateSize(e, t) {
                let { min: s, max: i, range: a } = e;
                ((e.range = a.map((e) => Number(e))),
                  c.actionFilter({
                    keyTimer: "filter_valid_win_size",
                    duration: t,
                    action() {
                      (a[0] > a[1] && (a[0] = a[1] - 1),
                        a[0] < s && (a[0] = s),
                        a[1] > i && (a[1] = i),
                        a[1] == s && (a[1] += 1),
                        a[0] == i && (a[0] -= 1),
                        (e.range = a));
                    },
                  }));
              },
              setHeightRange(e) {
                ((this.height.range = e),
                  this.validateSize(this.height, 0),
                  (this.isUpdatedFilter = !0));
              },
              setWidthRange(e) {
                ((this.width.range = e),
                  this.validateSize(this.width, 0),
                  (this.isUpdatedFilter = !0));
              },
              filterApply() {
                let {
                    height: e,
                    width: t,
                    numberSashes: s,
                    numberСameras: i,
                    mountingDepth: a,
                    currentSystem: n,
                  } = this,
                  l = {
                    height: e,
                    width: t,
                    numberSashes: s,
                    numberСameras: i,
                    mountingDepth: a,
                    currentSystem: n,
                  };
                ((this.isUpdatedFilter = !1),
                  this.setFilter(l),
                  this.$emit("apply"));
              },
              clearFilter() {
                let {
                  height: e,
                  width: t,
                  numberSashes: s,
                  numberСameras: i,
                  mountingDepth: a,
                  profileSystem: n,
                  currentSystem: l,
                } = this;
                ((this.width.range = [t.min, t.max]),
                  (this.height.range = [e.min, e.max]),
                  (l = n[0]),
                  [s, i, a].forEach((e) => {
                    e.forEach((e) => {
                      e.is = !0;
                    });
                  }),
                  this.filterApply());
              },
              getWinSizeLimit() {
                let e = { min: 1e3, max: 1e3 },
                  t = { min: 1e3, max: 1e3 };
                (this.winData.forEach((s) => {
                  (e.min > c.getNum(s.width) && (e.min = c.getNum(s.width)),
                    e.max < c.getNum(s.width) && (e.max = c.getNum(s.width)),
                    t.min > c.getNum(s.height) && (t.min = c.getNum(s.height)),
                    t.max < c.getNum(s.height) && (t.max = c.getNum(s.height)));
                }),
                  (this.width = {
                    range: [e.min, e.max],
                    min: e.min,
                    max: e.max,
                  }),
                  (this.height = {
                    range: [t.min, t.max],
                    min: t.min,
                    max: t.max,
                  }));
              },
            },
            watch: {
              isLoadWinData(e) {
                this.getWinSizeLimit();
              },
            },
          },
          go = (0, P.Z)(_o, mo, [], !1, null, null, null).exports,
          wo = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t(
              "div",
              {
                staticClass: "catalog-cart",
                class: { "win-in-basket": e.isBasket },
              },
              [
                t("div", {
                  staticClass: "catalog-cart__head-title",
                  domProps: {
                    innerHTML: e._s(`${e.win.title} ${e.win.system.label}`),
                  },
                }),
                t("div", { staticClass: "catalog-cart__img" }, [
                  t("img", {
                    staticClass: "img",
                    attrs: {
                      src: e.win.images.pre,
                      decoding: "async",
                      loading: "lazy",
                      alt: "",
                    },
                  }),
                ]),
                t("div", { staticClass: "catalog-cart__price" }, [
                  e._v(e._s(e.getMoney(e.win.price)) + " руб"),
                ]),
                t("div", { staticClass: "catalog-cart__btn" }, [
                  t(
                    "div",
                    {
                      staticClass: "btn",
                      on: { click: e.clickBtnBasket },
                    },
                    [
                      t("svg", { staticClass: "ico" }, [
                        t("use", {
                          attrs: {
                            "xlink:href":
                              "/new_style_files/upload/icon/interface.svg#shopping-cart",
                          },
                        }),
                      ]),
                      e._v(e._s(e.btnBasketLabel)),
                    ],
                  ),
                ]),
                t(
                  "div",
                  { staticClass: "catalog-cart__props" },
                  e._l(e.win.props, function (s) {
                    return t(
                      "div",
                      {
                        key: s.id,
                        staticClass: "catalog-cart__props-row",
                      },
                      [
                        t("div", { staticClass: "catalog-cart__props-label" }, [
                          e._v(e._s(s.label)),
                        ]),
                        t("div", { staticClass: "catalog-cart__props-value" }, [
                          e._v(e._s(s.value)),
                        ]),
                      ],
                    );
                  }),
                  0,
                ),
                t("a", {
                  staticClass: "catalog-cart__link",
                  attrs: { href: e.detailLink },
                }),
              ],
            );
          };
        wo._withStripped = !0;
        var vo = s(171);

        function fo() {
          let e = vo(".js-head-contact--basket"),
            t = e.find(".icon-basket__count");
          e[0].classList.contains("active")
            ? (t[0].textContent = Number(t[0].textContent) + 1)
            : (e[0].classList.add("active"), (t[0].textContent = 1));
        }

        var yo = {
            name: "catalog-cart",
            props: { win: Object },
            data() {
              return {};
            },
            computed: {
              ...(0, na.rn)(["isOneBatch", "basketWinData"]),
              isBasket() {
                return !!this.basketWinData.find((e) => e.id == this.win.id);
              },
              btnBasketLabel() {
                return this.isBasket ? "В корзине" : "В корзину";
              },
              detailLink() {
                return `/okna/standartnye/${this.win.id}/`;
              },
            },
            methods: {
              ...(0, na.nv)(["addBasket", "delBasket"]),
              getMoney: c.getMoney,
              animateShowCart() {
                this.isOneBatch &&
                  (0, m.Z)({
                    targets: this.$el,
                    opacity: [0, 1],
                    duration: 500,
                    easing: "easeInOutExpo",
                  });
              },
              clickBtnBasket() {
                this.isBasket
                  ? (window.location.pathname = "/okna/standartnye/cart/")
                  : (this.addBasket(this.win),
                    fo(),
                    p({
                      form: "gotovieCart",
                      attribute: "gotovie",
                    }));
              },
            },
            mounted() {
              this.animateShowCart();
            },
          },
          bo = (0, P.Z)(yo, wo, [], !1, null, null, null).exports,
          ko = s(171),
          Co = {
            name: "window-catalog",
            components: { CatalogFilter: go, CatalogCart: bo },
            data() {
              return { isShowFilter: !1 };
            },
            computed: {
              ...(0, na.rn)([
                "winData",
                "winDataFilter",
                "winDataOpen",
                "isLoadWinData",
                "basketWinData",
              ]),
            },
            methods: {
              ...(0, na.OI)(["batchWin"]),
              ...(0, na.nv)(["getData", "getBasketData"]),
              outClickCatalogFilter() {
                let e = this,
                  { btnFilter: t, catalogFilter: s } = this.$refs;
                ko(window).on("click.out_click_catalog_filter", function (i) {
                  let a = ko(window).width(),
                    n = ko(i.target).closest(s);
                  ko(i.target).closest(t).length || n.length || !e.isShowFilter
                    ? a < 1024 &&
                      e.isShowFilter &&
                      c.actionFilter({
                        keyTimer: "out_click_catalog_filter",
                        duration: 1e4,
                        action() {
                          e.isShowFilter = !1;
                        },
                      })
                    : (e.isShowFilter = !1);
                });
              },
              goBasket() {
                window.location.href = "/okna/standartnye/cart/";
              },
            },
            mounted() {
              this.outClickCatalogFilter();
            },
            created() {
              (this.getData(), this.getBasketData());
            },
          },
          So = (0, P.Z)(
            Co,
            co,
            [
              function () {
                var e = this,
                  t = e._self._c;
                e._self._setupProxy;
                return t("div", { staticClass: "catalog-banner__container" }, [
                  t("div", { staticClass: "catalog-banner__head-title" }, [
                    e._v("А ещё у нас есть цветные окна!"),
                  ]),
                  t("div", { staticClass: "catalog-banner__img-wrap" }, [
                    t("div", { staticClass: "catalog-banner__img-item" }, [
                      t("img", {
                        staticClass: "img",
                        attrs: {
                          src: "/new_style_files/assets/img/res/window-catalog/catalog-banner/img-1.jpg",
                          decoding: "async",
                          loading: "lazy",
                          alt: "",
                        },
                      }),
                    ]),
                    t("div", { staticClass: "catalog-banner__img-item" }, [
                      t("img", {
                        staticClass: "img",
                        attrs: {
                          src: "/new_style_files/assets/img/res/window-catalog/catalog-banner/img-2.jpg",
                          decoding: "async",
                          loading: "lazy",
                          alt: "",
                        },
                      }),
                    ]),
                    t("div", { staticClass: "catalog-banner__img-item" }, [
                      t("img", {
                        staticClass: "img",
                        attrs: {
                          src: "/new_style_files/assets/img/res/window-catalog/catalog-banner/img-2.jpg",
                          decoding: "async",
                          loading: "lazy",
                          alt: "",
                        },
                      }),
                    ]),
                    t("div", { staticClass: "catalog-banner__img-item" }, [
                      t("img", {
                        staticClass: "img",
                        attrs: {
                          src: "/new_style_files/assets/img/res/window-catalog/catalog-banner/img-4.jpg",
                          decoding: "async",
                          loading: "lazy",
                          alt: "",
                        },
                      }),
                    ]),
                  ]),
                  t("div", { staticClass: "catalog-banner__desc" }, [
                    e._v(
                      "Окна из цветного профиля или с ламинацией креативно смотрятся в любом интерьере. ",
                    ),
                    t("br"),
                    t(
                      "a",
                      {
                        staticClass: "no-style",
                        attrs: { href: "/aksessuary/laminatsiya/" },
                      },
                      [e._v("Посмотреть варианты")],
                    ),
                  ]),
                ]);
              },
            ],
            !1,
            null,
            null,
            null,
          ).exports,
          xo = (e) => new (a())({ el: e, store: ro, render: (e) => e(So) });
        a().use(na.ZP);
        var Po = new na.ZP.Store({
            state: { basketWinData: [], isLoadBasketData: !1 },
            mutations: {
              removeProd(e, t) {
                e.basketWinData.splice(t, 1);
              },
            },
            actions: {
              async getBasketData(e) {
                let { state: t } = e;
                R.hostname;
                return R.ajaxGet({
                  url: "/ajax/?controller=FullWindows&action=basket",
                }).then((e) => {
                  if (e?.success) {
                    let s = e.data;
                    (s.length && (t.basketWinData = s),
                      (t.isLoadBasketData = !0));
                  }
                  return e;
                });
              },
              async addBasket(e, t) {
                let { state: s } = e;
                R.hostname;
                R.ajaxPost({
                  url: "/ajax/?controller=FullWindows&action=add",
                  data: { id: t.id, quantity: t.amount, options: t.options },
                }).then((e) => (e?.success, e));
              },
              async delBasket(e, t) {
                let { state: s } = e;
                R.hostname;
                R.ajaxPost({
                  url: "/ajax/?controller=FullWindows&action=delete",
                  data: { id: t.id },
                }).then((e) => (e?.success, e));
                let i = s.basketWinData.findIndex((e) => e.id == t.id);
                s.basketWinData.splice(i, 1);
              },
            },
          }),
          jo = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t(
              "div",
              {
                directives: [
                  {
                    name: "show",
                    rawName: "v-show",
                    value: e.isLoadBasketData,
                    expression: "isLoadBasketData",
                  },
                ],
                staticClass: "catalog-basket__app",
              },
              [
                t(
                  "div",
                  {
                    ref: "sliderBasket",
                    staticClass: "catalog-basket__slider swiper",
                  },
                  [
                    t(
                      "div",
                      { staticClass: "catalog-basket__wrap swiper-wrapper" },
                      [
                        e._l(e.basketWinData, function (e, s) {
                          return t("catalog-basket-cart", {
                            key: e.id,
                            staticClass: "swiper-slide",
                            attrs: { win: e, index: s },
                          });
                        }),
                        e.basketWinData.length
                          ? e._e()
                          : t("div", { staticClass: "catalog-basket__empty" }, [
                              t("p", [e._v("Корзина пуста!")]),
                              t("br"),
                              e._m(0),
                            ]),
                      ],
                      2,
                    ),
                  ],
                ),
                e.basketWinData.length
                  ? [
                      t("div", { staticClass: "catalog-basket__total-price" }, [
                        e._v(
                          "Итого к оплате: " +
                            e._s(e.getSale(e.totalPrice)) +
                            " ",
                        ),
                        t(
                          "div",
                          {
                            staticClass: "label-small label-small__sale",
                            staticStyle: {
                              display: "inline-flex",
                              "letter-spacing": "1px",
                              "margin-bottom": "0",
                              "align-items": "center",
                              position: "relative",
                              top: "-20px",
                            },
                          },
                          [e._v("со скидкой 5%")],
                        ),
                      ]),
                      t(
                        "div",
                        { staticClass: "catalog-basket__total-weight" },
                        [
                          e._v(
                            "Старая цена: " + e._s(e.getMoney(e.totalPrice)),
                          ),
                        ],
                      ),
                      e._m(1),
                    ]
                  : e._e(),
              ],
              2,
            );
          };
        jo._withStripped = !0;
        var qo = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "catalog-basket-cart" }, [
            t(
              "div",
              {
                staticClass: "catalog-basket-cart__btn-del",
                on: {
                  click: function (t) {
                    return e.delBasket(e.win);
                  },
                },
              },
              [
                t("svg", { staticClass: "ico" }, [
                  t("use", {
                    attrs: {
                      "xlink:href":
                        "/new_style_files/upload/icon/sprites-min.svg#remove-urn",
                    },
                  }),
                ]),
              ],
            ),
            t("div", { staticClass: "catalog-basket-cart__num-title" }, [
              e._v("№" + e._s(e.index + 1)),
            ]),
            t("div", { staticClass: "catalog-basket-cart__wrap-block" }, [
              t(
                "div",
                { staticClass: "catalog-basket-cart__block block-info" },
                [
                  t("div", { staticClass: "catalog-basket-cart__img" }, [
                    t("img", {
                      staticClass: "img",
                      attrs: {
                        src: e.win.images.pre,
                        decoding: "async",
                        loading: "lazy",
                        alt: "",
                      },
                    }),
                  ]),
                  t("div", {
                    staticClass: "catalog-basket-cart__title",
                    domProps: { innerHTML: e._s(e.win.title) },
                  }),
                  t(
                    "div",
                    { staticClass: "catalog-basket-cart__props" },
                    e._l(e.win.props, function (s) {
                      return t(
                        "div",
                        {
                          key: s.id,
                          staticClass: "catalog-basket-cart__props-row",
                        },
                        [
                          t(
                            "div",
                            { staticClass: "catalog-basket-cart__props-label" },
                            [e._v(e._s(s.label) + ":")],
                          ),
                          t(
                            "div",
                            { staticClass: "catalog-basket-cart__props-value" },
                            [e._v(e._s(s.value))],
                          ),
                        ],
                      );
                    }),
                    0,
                  ),
                ],
              ),
              t(
                "div",
                { staticClass: "catalog-basket-cart__block block-option" },
                [
                  t(
                    "div",
                    {
                      staticClass: "catalog-basket-cart__option option-amount",
                    },
                    [
                      t(
                        "div",
                        { staticClass: "catalog-basket-cart__option-title" },
                        [e._v("Кол-во:")],
                      ),
                      t(
                        "div",
                        { staticClass: "catalog-basket-cart__option-value" },
                        [
                          t(
                            "div",
                            {
                              staticClass:
                                "btn-arrow catalog-basket-cart__arrow btn-minus",
                              on: {
                                click: function (t) {
                                  e.countAmount(e.win, -1);
                                },
                              },
                            },
                            [
                              t("svg", { staticClass: "ico" }, [
                                t("use", {
                                  attrs: {
                                    "xlink:href":
                                      "/new_style_files/upload/icon/interface.svg#minus",
                                  },
                                }),
                              ]),
                            ],
                          ),
                          t(
                            "div",
                            { staticClass: "catalog-basket-cart__num-amount" },
                            [e._v(e._s(e.getNum(e.win.amount)))],
                          ),
                          t(
                            "div",
                            {
                              staticClass:
                                "btn-arrow catalog-basket-cart__arrow btn-plus",
                              on: {
                                click: function (t) {
                                  e.countAmount(e.win, 1);
                                },
                              },
                            },
                            [
                              t("svg", { staticClass: "ico" }, [
                                t("use", {
                                  attrs: {
                                    "xlink:href":
                                      "/new_style_files/upload/icon/interface.svg#plus",
                                  },
                                }),
                              ]),
                            ],
                          ),
                        ],
                      ),
                    ],
                  ),
                ],
              ),
            ]),
            t("div", { staticClass: "catalog-basket-cart__total-price" }, [
              e._v("Цена: " + e._s(e.getMoney(e.totalPrice)) + " руб"),
            ]),
          ]);
        };
        qo._withStripped = !0;
        var Do = {
            name: "catalog-basket-cart",
            props: { index: Number, win: Object },
            data() {
              return {};
            },
            computed: {
              totalPrice() {
                let e = 0;
                return (
                  (e += Number(this.win.price)),
                  this.win.options.forEach((t) => {
                    t.is && (e += Number(t.price));
                  }),
                  (e *= this.win.amount),
                  this.$set(this.win, "totalPrice", e),
                  e
                );
              },
            },
            methods: {
              ...(0, na.nv)(["delBasket", "addBasket"]),
              getMoney: c.getMoney,
              getNum: c.getNum,
              countAmount(e, t) {
                ((e.amount += t),
                  e.amount < 1 && (e.amount = 1),
                  this.addBasket(this.win));
              },
              checkOption(e) {
                ((e.is = !e.is), this.addBasket(this.win));
              },
            },
          },
          Lo = (0, P.Z)(Do, qo, [], !1, null, null, null).exports,
          Mo = s(171),
          $o = {
            name: "catalog-basket",
            components: { CatalogBasketCart: Lo },
            data() {
              return { slider: "", winWidth: Mo(window).width(), form: null };
            },
            computed: {
              ...(0, na.rn)(["basketWinData", "isLoadBasketData"]),
              totalWeight() {
                let e = 0;
                return (
                  this.basketWinData.forEach((t) => {
                    e += Number(t.weight) * t.amount;
                  }),
                  e
                );
              },
              totalPrice() {
                let e = 0;
                return (
                  this.basketWinData.forEach((t) => {
                    e += t.totalPrice;
                  }),
                  e
                );
              },
            },
            watch: {
              basketWinData() {
                setTimeout(() => {
                  this.form || this.initForm();
                }, 300);
              },
            },
            methods: {
              ...(0, na.nv)(["getBasketData"]),
              getMoney: c.numFormat,
              getSale(e) {
                return c.numFormat(0.95 * e);
              },
              initSlider() {
                let { sliderBasket: e } = this.$refs;
                this.slider = new M.ZP(e, {
                  spaceBetween: 20,
                  slidesPerView: "auto",
                });
              },
              resizeWindow() {
                Mo(window).on("resize.resize_catalog_basket", () => {
                  ((this.winWidth = Mo(window).width()),
                    c.actionFilter({
                      keyTimer: "resize_catalog_basket",
                      duration: 100,
                      action: () => {
                        this.winWidth < 1024
                          ? this.slider || this.initSlider()
                          : this.slider &&
                            (this.slider.destroy(), (this.slider = ""));
                      },
                    }));
                });
              },
              submitOrderForm(e) {
                e.preventDefault();
              },
              initForm() {
                let e = l.getComponent(".js-modal-win");
                this.form = new G(this.$el, {
                  onSubmit(e) {
                    let {
                        action: t,
                        data: s,
                        onSuccess: i,
                        onFail: a,
                        form: n,
                      } = e,
                      o = l.getComponent("#vue-catalog-basket").$store.state;
                    ((s = { "user-data": { ...s }, items: o.basketWinData }),
                      R.ajaxPost({ url: t, data: s }).then((e) => {
                        if (e.success)
                          (n.clearField(),
                            window.scrollTo(0, 0),
                            i && i(n),
                            (o.basketWinData = []),
                            p({
                              form: "gotovie",
                              attribute: "gotovie",
                            }));
                        else {
                          let { $button: t, validation: s } = n;
                          (t[0].removeAttribute("disabled"),
                            (t[0].innerText = t[0].dataset.name),
                            "FORM_ERROR_PHONE" === e.status &&
                              s.showErrors({
                                [n.$phone.getSelector()]: e.data.message,
                              }),
                            "FORM_ERROR_NAME" === e.status &&
                              s.showErrors({
                                [n.$name.getSelector()]: e.data.message,
                              }),
                            "FORM_ERROR_COOKIE" === e.status && a(n, e),
                            a && e && a(n, e));
                        }
                      }));
                  },
                  onSuccess(t) {
                    (e.close(), e.open("#modal-success-form"));
                  },
                  onFail(t, s) {
                    (e.close(),
                      e.open("#modal-error", (e) => {
                        if (s.data.message) {
                          e.openedWindow.querySelector(
                            ".modal-win__head-desc",
                          ).innerText = s.data.message;
                        }
                      }));
                  },
                });
              },
            },
            mounted() {
              (this.winWidth < 1024 && this.initSlider(), this.resizeWindow());
            },
            created() {
              this.getBasketData();
            },
          },
          zo = (0, P.Z)(
            $o,
            jo,
            [
              function () {
                var e = this,
                  t = e._self._c;
                e._self._setupProxy;
                return t("p", [
                  e._v("Перейдите в раздел "),
                  t("a", { attrs: { href: "/okna/standartnye/" } }, [
                    e._v("стандартных окон"),
                  ]),
                  e._v(" чтобы добавить окна в корзину."),
                ]);
              },
              function () {
                var e = this,
                  t = e._self._c;
                e._self._setupProxy;
                return t(
                  "form",
                  {
                    staticClass: "catalog-order__block",
                    attrs: {
                      action: "/ajax/?controller=FullWindows&action=order",
                    },
                  },
                  [
                    t("input", {
                      attrs: {
                        type: "hidden",
                        name: "form",
                        value: "gotovie",
                      },
                    }),
                    t("input", {
                      attrs: {
                        type: "hidden",
                        name: "attribute",
                        value: "gotovie",
                      },
                    }),
                    t("div", { staticClass: "catalog-order__block-title" }, [
                      e._v("Оформление заказа"),
                    ]),
                    t("div", { staticClass: "catalog-order__user-data" }, [
                      t("div", { staticClass: "catalog-order__user-name" }, [
                        t("div", { staticClass: "control control--black" }, [
                          t("div", { staticClass: "control__group" }, [
                            t(
                              "label",
                              { staticClass: "control__label required-field" },
                              [e._v("ФИО")],
                            ),
                            t("input", {
                              staticClass: "control__input js-user-name",
                              attrs: {
                                type: "text",
                                name: "user-name",
                                placeholder: "Иван",
                                autocomplete: "name",
                                required: "",
                              },
                            }),
                          ]),
                        ]),
                      ]),
                      t("div", { staticClass: "catalog-order__user-email" }, [
                        t("div", { staticClass: "control control--black" }, [
                          t("div", { staticClass: "control__group" }, [
                            t(
                              "label",
                              { staticClass: "control__label required-field" },
                              [e._v("E-mail")],
                            ),
                            t("input", {
                              staticClass: "control__input js-user-email",
                              attrs: {
                                type: "email",
                                name: "user-email",
                                placeholder: "ivan@mail.ru",
                                autocomplete: "email",
                                required: "",
                              },
                            }),
                          ]),
                        ]),
                      ]),
                      t("div", { staticClass: "catalog-order__user-phone" }, [
                        t(
                          "div",
                          { staticClass: "control control--black user-phone" },
                          [
                            t("div", { staticClass: "control__group" }, [
                              t(
                                "label",
                                {
                                  staticClass: "control__label required-field",
                                },
                                [e._v("Телефон")],
                              ),
                              t("input", {
                                staticClass: "control__input js-user-phone",
                                attrs: {
                                  placeholder: "+7(999)888-77-66",
                                  type: "tel",
                                  name: "user-phone",
                                  autocomplete: "tel",
                                  required: "",
                                },
                              }),
                            ]),
                          ],
                        ),
                      ]),
                    ]),
                    t("div", { staticClass: "catalog-order__person-data" }, [
                      t(
                        "label",
                        {
                          staticClass:
                            "checkbox-small checkbox-small--smaller js-checkbox-small",
                        },
                        [
                          t("input", {
                            staticClass: "checkbox-small__input js-person-data",
                            attrs: {
                              type: "checkbox",
                              name: "person-data",
                              id: "catalog-order__person-data",
                              checked: "",
                            },
                          }),
                          t("label", {
                            staticClass: "checkbox-small__checkbox",
                            attrs: { for: "catalog-order__person-data" },
                          }),
                          t("span", { staticClass: "checkbox-small__label" }, [
                            e._v("Даю согласие на обработку "),
                            t(
                              "a",
                              {
                                staticClass: "a no-style",
                                attrs: { href: "/confidence/" },
                              },
                              [e._v("персональных данных")],
                            ),
                          ]),
                        ],
                      ),
                    ]),
                    t("div", { staticClass: "catalog-basket__btn" }, [
                      t(
                        "button",
                        {
                          staticClass: "btn btn--large",
                          attrs: { type: "submit" },
                        },
                        [e._v("Заказать")],
                      ),
                    ]),
                  ],
                );
              },
            ],
            !1,
            null,
            null,
            null,
          ).exports,
          Eo = (e) => new (a())({ el: e, store: Po, render: (e) => e(zo) }),
          Fo = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t(
              "div",
              {
                staticClass: "standart-win-card__app",
                class: { "win-in-basket": e.isBasket },
              },
              [
                t(
                  "div",
                  { staticClass: "standart-win-card__btn catalog-cart__btn" },
                  [
                    t(
                      "button",
                      {
                        staticClass: "btn",
                        on: { click: e.clickBtnBasket },
                      },
                      [
                        t("svg", { staticClass: "ico" }, [
                          t("use", {
                            attrs: {
                              "xlink:href":
                                "/new_style_files/upload/icon/interface.svg#shopping-cart",
                            },
                          }),
                        ]),
                        e._v(e._s(e.btnBasketLabel)),
                      ],
                    ),
                  ],
                ),
              ],
            );
          };
        Fo._withStripped = !0;
        var Oo = {
            name: "catalog-cart",
            data() {
              return {};
            },
            computed: {
              ...(0, na.rn)(["isOneBatch", "basketWinData", "winData"]),
              isBasket() {
                return !!this.basketWinData.find(
                  (e) => e.id == this.$root.winId,
                );
              },
              btnBasketLabel() {
                return this.isBasket ? "В корзине" : "В корзину";
              },
            },
            methods: {
              ...(0, na.nv)(["addBasket", "delBasket", "getDataWin"]),
              getMoney: c.getMoney,
              animateShowCart() {
                this.isOneBatch &&
                  (0, m.Z)({
                    targets: this.$el,
                    opacity: [0, 1],
                    duration: 500,
                    easing: "easeInOutExpo",
                  });
              },
              clickBtnBasket() {
                this.isBasket
                  ? (window.location.pathname = "/okna/standartnye/cart/")
                  : (this.addBasket(this.winData[0]),
                    fo(),
                    p({
                      form: "gotovieCart",
                      attribute: "gotovie",
                    }));
              },
            },
            created() {
              this.getDataWin(this.$root.winId);
            },
            mounted() {
              this.animateShowCart();
            },
          },
          To = (0, P.Z)(Oo, Fo, [], !1, null, null, null).exports,
          Bo = s(171),
          Io = (e) =>
            new (a())({
              el: e,
              data: { winId: Bo(e)[0].dataset.window },
              store: ro,
              render: (e) => e(To),
            });
        a().use(na.ZP);
        var Wo = new na.ZP.Store({
            state: {
              answer: [],
              quizData: {
                glazing: {
                  title: "Что остекляем?",
                  answer: null,
                  step: 1,
                  max: 5,
                  data: [
                    {
                      type: "room",
                      title: "Квартира",
                      img: "/new_style_files/upload/img_verstka/quiz/img/room_main.webp",
                      select: !1,
                    },
                    {
                      type: "cottage",
                      title: "Коттедж",
                      img: "/new_style_files/upload/img_verstka/quiz/img/type_cottage.webp",
                      select: !1,
                    },
                  ],
                },
                region: {
                  title: "Ваш район?",
                  answer: null,
                  step: 2,
                  max: 5,
                  data: [
                    {
                      type: "quiet",
                      title: "Тихий",
                      img: "/new_style_files/upload/img_verstka/quiz/img/region_quiet.webp",
                      select: !1,
                    },
                    {
                      type: "noize",
                      title: "Шумный",
                      img: "/new_style_files/upload/img_verstka/quiz/img/region_noize.webp",
                      select: !1,
                    },
                  ],
                },
                floor: {
                  title: "Какой у вас этаж?",
                  answer: null,
                  step: 3,
                  max: 5,
                  data: [
                    {
                      type: "down",
                      title: "Ниже 5 этажа",
                      img: "/new_style_files/upload/img_verstka/quiz/img/flor_down.webp",
                      select: !1,
                    },
                    {
                      type: "up",
                      title: "Выше 5 этажа",
                      img: "/new_style_files/upload/img_verstka/quiz/img/flor_up.webp",
                      select: !1,
                    },
                  ],
                },
                room: {
                  title: "Какую комнату остекляем?",
                  answer: null,
                  step: 4,
                  max: 5,
                  data: [
                    {
                      type: "kitchen",
                      title: "Кухня",
                      img: "/new_style_files/upload/img_verstka/quiz/img/room_kitchen.webp",
                      select: !1,
                    },
                    {
                      type: "main",
                      title: "Гостиная/спальня",
                      img: "/new_style_files/upload/img_verstka/quiz/img/room_main.webp",
                      select: !1,
                    },
                    {
                      type: "balkon",
                      title: "Балконный блок",
                      img: "/new_style_files/upload/img_verstka/quiz/img/room_balkon.webp",
                      select: !1,
                    },
                    {
                      type: "logiya",
                      title: "Балконный блок и лоджия",
                      img: "/new_style_files/upload/img_verstka/quiz/img/room_logiya.webp",
                      select: !1,
                    },
                  ],
                },
                balkon: {
                  title: "Тип остекления?",
                  answer: null,
                  step: 6,
                  max: 6,
                  data: [
                    {
                      type: "hot",
                      title: "Тёплое",
                      img: "/new_style_files/upload/img_verstka/quiz/img/balkon_hot.webp",
                      select: !1,
                    },
                    {
                      type: "сold",
                      title: "Холодное",
                      img: "/new_style_files/upload/img_verstka/quiz/img/balkon_сold.webp",
                      select: !1,
                    },
                    {
                      type: "franch",
                      title: "Панорамное",
                      img: "/new_style_files/upload/img_verstka/quiz/img/balkon_franch.webp",
                      select: !1,
                    },
                  ],
                },
                cottage: {
                  title: "Тип коттежа?",
                  answer: null,
                  step: 2,
                  max: 2,
                  data: [
                    {
                      type: "dacha",
                      title: "Дача",
                      img: "/new_style_files/upload/img_verstka/quiz/img/cottage_dacha.webp",
                      select: !1,
                    },
                    {
                      type: "build",
                      title: "Загородный дом",
                      img: "/new_style_files/upload/img_verstka/quiz/img/cottage_build.webp",
                      select: !1,
                    },
                    {
                      type: "franch",
                      title: "Коттедж с панорамным остеклением",
                      img: "/new_style_files/upload/img_verstka/quiz/img/cottage_franch.webp",
                      select: !1,
                    },
                  ],
                },
              },
              systemList: [],
              advData: {
                lite60: {
                  desktop: [
                    [
                      ["410", "44"],
                      ["216", "78"],
                    ],
                    [
                      ["410", "172"],
                      ["216", "202"],
                    ],
                    [
                      ["494", "224"],
                      ["216", "250"],
                    ],
                    [
                      ["434", "260"],
                      ["216", "334"],
                    ],
                    [
                      ["410", "303"],
                      ["216", "410"],
                    ],
                  ],
                  mobile: [
                    ["167", "62"],
                    ["188", "180"],
                    ["111", "210"],
                    ["172", "251"],
                    ["187", "292"],
                  ],
                  advantage: [
                    "Двухкамерный стеклопакет",
                    "Стальное армирование толщиной 1,5 мм",
                    "Уплотнители Exprof",
                    "Фурнитура Futuruss в специальной комплектации",
                    "Заглушка «Антипыль»",
                  ],
                  imgPath:
                    "/new_style_files/upload/img_verstka/systems/lite60/06_lite60",
                },
                lite70: {
                  desktop: [
                    [
                      ["410", "44"],
                      ["216", "78"],
                    ],
                    [
                      ["410", "202"],
                      ["216", "202"],
                    ],
                    [
                      ["504", "224"],
                      ["216", "260"],
                    ],
                    [
                      ["434", "260"],
                      ["216", "334"],
                    ],
                    [
                      ["410", "303"],
                      ["216", "410"],
                    ],
                  ],
                  mobile: [
                    ["167", "62"],
                    ["188", "180"],
                    ["95", "210"],
                    ["172", "251"],
                    ["187", "292"],
                  ],
                  advantage: [
                    "Двухкамерный стеклопакет Climatherm™",
                    "Стальное армирование толщиной 1,5 мм",
                    "Уплотнители Exprof",
                    "Фурнитура Futuruss в специальной комплектации",
                    "Заглушка «Антипыль»",
                  ],
                  imgPath:
                    "/new_style_files/upload/img_verstka/systems/lite70/05_lite70",
                },
                smart: {
                  desktop: [
                    [
                      ["410", "44"],
                      ["216", "78"],
                    ],
                    [
                      ["410", "202"],
                      ["216", "182"],
                    ],
                    [
                      ["494", "224"],
                      ["216", "250"],
                    ],
                    [
                      ["434", "260"],
                      ["216", "334"],
                    ],
                    [
                      ["410", "303"],
                      ["216", "410"],
                    ],
                  ],
                  mobile: [
                    ["167", "62"],
                    ["188", "180"],
                    ["111", "210"],
                    ["172", "251"],
                    ["187", "292"],
                  ],
                  advantage: [
                    "Двухкамерный стеклопакет Climatherm™",
                    "Стальное армирование толщиной 1,5 мм",
                    "Уплотнители Exprof",
                    "Немецкая фурнитура Siegenia в специальной комплектации",
                    "Заглушка «Антипыль»",
                  ],
                  imgPath:
                    "/new_style_files/upload/img_verstka/systems/smart/04_smart",
                },
                evolution: {
                  desktop: [
                    [
                      ["410", "44"],
                      ["256", "78"],
                    ],
                    [
                      ["410", "220"],
                      ["216", "202"],
                    ],
                    [
                      ["514", "224"],
                      ["216", "284"],
                    ],
                    [
                      ["434", "260"],
                      ["216", "344"],
                    ],
                    [
                      ["420", "303"],
                      ["216", "410"],
                    ],
                  ],
                  mobile: [
                    ["167", "62"],
                    ["188", "180"],
                    ["91", "210"],
                    ["172", "251"],
                    ["187", "292"],
                  ],
                  advantage: [
                    "Двухкамерный мультифункциональный стеклопакет Climatherm™",
                    "Стальное армирование толщиной 1,5 мм",
                    "Уплотнители Exprof",
                    "Премиум фурнитура Siegenia Titan",
                    "Заглушка «Антипыль»",
                  ],
                  imgPath:
                    "/new_style_files/upload/img_verstka/systems/evolution/03_evo",
                },
                art: {
                  desktop: [
                    [
                      ["410", "44"],
                      ["256", "78"],
                    ],
                    [
                      ["383", "163"],
                      ["216", "176"],
                    ],
                    [
                      ["424", "220"],
                      ["216", "242"],
                    ],
                    [
                      ["514", "224"],
                      ["216", "314"],
                    ],
                    [
                      ["380", "310"],
                      ["216", "364"],
                    ],
                    [
                      ["420", "299"],
                      ["216", "426"],
                    ],
                  ],
                  mobile: [
                    ["227", "132"],
                    ["77", "112"],
                    ["188", "180"],
                    ["91", "210"],
                    ["232", "291"],
                    ["175", "290"],
                  ],
                  advantage: [
                    "Двухкамерный мультифункциональный стеклопакет Climatherm™ Triplex",
                    "Фигурный штапик",
                    "Стальное армирование толщиной 1,5 мм",
                    "Уплотнители Exprof",
                    "Фигурная створка",
                    "Заглушка «Антипыль»",
                  ],
                  imgPath:
                    "/new_style_files/upload/img_verstka/systems/art/02_art",
                },
                centum: {
                  desktop: [
                    [
                      ["410", "44"],
                      ["216", "78"],
                    ],
                    [
                      ["383", "193"],
                      ["216", "136"],
                    ],
                    [
                      ["404", "220"],
                      ["216", "186"],
                    ],
                    [
                      ["434", "244"],
                      ["216", "242"],
                    ],
                    [
                      ["494", "250"],
                      ["216", "314"],
                    ],
                    [
                      ["420", "299"],
                      ["216", "376"],
                    ],
                    [
                      ["420", "366"],
                      ["216", "444"],
                    ],
                  ],
                  mobile: [
                    ["181", "58"],
                    ["77", "112"],
                    ["188", "180"],
                    ["171", "226"],
                    ["112", "241"],
                    ["185", "270"],
                    ["181", "330"],
                  ],
                  advantage: [
                    "Трёхкамерный стеклопакет",
                    "7 камер в створке",
                    "Армирование 2 мм",
                    "Самая лучшая фурнитура",
                    "Три контура уплотнения",
                    "Заглушка «Антипыль»",
                    "6 камер в раме",
                  ],
                  imgPath:
                    "/new_style_files/upload/img_verstka/systems/centum/01_centum",
                },
              },
              allumin: [
                {
                  name: "Provedal",
                  advantage: [
                    {
                      title: "Стеклянный барьер",
                      desc: "Защитит балкон или лоджию от ветра, дождя и снега",
                    },
                    {
                      title: "Легкий вес",
                      desc: "Подойдет при технических ограничениях для установки ПВХ",
                    },
                    {
                      title: "Экономия пространства",
                      desc: "Раздвижные створки не занимают пространство при открытии",
                    },
                  ],
                  price: 8804,
                  imgPath:
                    "/new_style_files/upload/img_verstka/quiz/img/lamination",
                },
              ],
              step: 0,
              max: 5,
              count: 0,
              error: !1,
              intro: !0,
              final: !1,
              current: "glazing",
            },
            mutations: {
              switchIntro(e) {
                e.intro = !1;
              },
              selectCard(e, t) {
                ((e.error = !1),
                  e.quizData[e.current].data.forEach((e) => (e.select = !1)),
                  (e.quizData[e.current].data[t.index].select = !0),
                  e.quizData[e.current].answer &&
                    e.answer[e.answer.length - 1] ===
                      e.quizData[e.current].answer &&
                    e.answer.pop(),
                  (e.quizData[e.current].answer = t.type),
                  e.answer[e.answer.length - 1] !== t.type &&
                    e.answer.push(t.type),
                  (e.step = e.quizData[e.current].step),
                  (e.max = e.quizData[e.current].max));
              },
              changeCurrent(e, t) {
                e.current = t;
              },
              toFinal(e) {
                e.final = !0;
              },
              setData(e, t) {
                e.systemList = t;
              },
            },
            actions: {
              async getData(e, t) {
                let { state: s, commit: i } = e,
                  a =
                    "/ajax/?controller=systems&action=getCompareData&type=Exprof";
                a &&
                  R.ajaxGet({ url: a }).then((e) => {
                    e?.success && i("setData", e.data);
                  });
              },
              switchCards(e, t) {
                let { commit: s, state: i } = e;
                if (
                  (i.answer.length > 1 &&
                    "prev" === t &&
                    (i.quizData[i.current].answer ===
                      i.answer[i.answer.length - 1] && i.answer.pop(),
                    i.quizData[i.current].data.forEach((e) => (e.select = !1)),
                    (i.quizData[i.current].answer = null),
                    (i.step = i.quizData[i.current].step - 1)),
                  "next" !== t || i.quizData[i.current].answer)
                )
                  switch (i.current) {
                    case "glazing":
                      if ("prev" === t) return;
                      i.answer.length &&
                        ("room" === i.answer[0] && s("changeCurrent", "region"),
                        "cottage" === i.answer[0] &&
                          s("changeCurrent", "cottage"));
                      break;
                    case "region":
                      s("changeCurrent", "prev" === t ? "glazing" : "floor");
                      break;
                    case "floor":
                      s("changeCurrent", "prev" === t ? "region" : "room");
                      break;
                    case "room":
                      "prev" === t
                        ? s("changeCurrent", "floor")
                        : "logiya" === i.answer[3]
                          ? s("changeCurrent", "balkon")
                          : s("toFinal");
                      break;
                    case "balkon":
                      "prev" === t ? s("changeCurrent", "floor") : s("toFinal");
                      break;
                    case "cottage":
                      "prev" === t
                        ? s("changeCurrent", "glazing")
                        : s("toFinal");
                  }
                else i.error = !0;
              },
            },
            getters: {
              systemType(e) {
                switch (e.answer.join("-")) {
                  case "cottage-dacha":
                  case "room-quiet-down-kitchen":
                    return "lite60-lite70";
                  case "cottage-build":
                  case "cottage-franch":
                    return "art-centum";
                  case "room-noize-down-kitchen":
                  case "room-quiet-up-kitchen":
                  case "room-noize-up-kitchen":
                    return "lite70";
                  case "room-quiet-down-main":
                  case "room-quiet-up-main":
                  case "room-noize-down-main":
                  case "room-noize-up-main":
                  case "room-quiet-down-balkon":
                  case "room-quiet-up-balkon":
                  case "room-noize-down-balkon":
                  case "room-noize-up-balkon":
                    return "lite70-smart";
                  case "room-quiet-down-logiya-hot":
                  case "room-quiet-up-logiya-hot":
                  case "room-noize-down-logiya-hot":
                  case "room-noize-up-logiya-hot":
                    return "smart-evolution";
                  case "room-quiet-down-logiya-сold":
                  case "room-quiet-up-logiya-сold":
                  case "room-noize-down-logiya-сold":
                  case "room-noize-up-logiya-сold":
                    return "allumin";
                  case "room-quiet-down-logiya-franch":
                  case "room-quiet-up-logiya-franch":
                  case "room-noize-down-logiya-franch":
                  case "room-noize-up-logiya-franch":
                    return "evolution";
                  default:
                    return "";
                }
              },
              getSystems(e, t) {
                let s = [];
                return 0 === e.systemList.length
                  ? []
                  : "allumin" == t.systemType
                    ? e.allumin
                    : (t.systemType.split("-").forEach((t) => {
                        let i = e.systemList.find(
                          (e) => e.code === `Exprof-${t}`,
                        );
                        i && s.push(i);
                      }),
                      s);
              },
            },
          }),
          Ao = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t(
              "div",
              { staticClass: "quiz__content" },
              [
                t("intro", {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: e.intro,
                      expression: "intro",
                    },
                  ],
                }),
                e.intro || e.final ? e._e() : t("card-list"),
                e.intro || e.final ? e._e() : t("progress-bar"),
                t("final", {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: e.final,
                      expression: "final",
                    },
                  ],
                }),
              ],
              1,
            );
          };
        Ao._withStripped = !0;
        var Vo = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t(
            "div",
            { staticClass: "quiz__answer" },
            [
              t(
                "TransitionGroup",
                {
                  staticClass: "quiz__answer-wrapper swiper-wrapper",
                  attrs: { appear: "", name: "fade", tag: "div" },
                },
                e._l(Object.keys(e.quizData), function (e) {
                  return t("answer-cards", { key: e, attrs: { type: e } });
                }),
                1,
              ),
              t("div", { staticClass: "quiz__buttons" }, [
                t(
                  "button",
                  {
                    staticClass: "btn btn--white btn--large btn--arrow",
                    on: {
                      click: function (t) {
                        return e.switcher("prev");
                      },
                    },
                  },
                  [t("div", { staticClass: "arrow-ico arrow-ico--left" })],
                ),
                t(
                  "button",
                  {
                    staticClass: "btn btn--large",
                    on: {
                      click: function (t) {
                        return e.switcher("next");
                      },
                    },
                  },
                  [e._v("Далее")],
                ),
              ]),
            ],
            1,
          );
        };
        Vo._withStripped = !0;
        var No = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t(
            "div",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: e.type === e.current,
                  expression: "type === current",
                },
              ],
              ref: "quizSwipers",
              staticClass: "quiz__answer-card swiper",
            },
            [
              t("div", { staticClass: "quiz__answer-title" }, [
                e._v(e._s(e.quizData[e.type].title)),
              ]),
              t(
                "div",
                {
                  staticClass: "quiz__items swiper-wrapper",
                  class: { "quiz__items--wrong": e.error },
                },
                e._l(e.quizData[e.type].data, function (e, s) {
                  return t("card", { key: s, attrs: { card: e, index: s } });
                }),
                1,
              ),
            ],
          );
        };
        No._withStripped = !0;
        var Zo = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "quiz__item swiper-slide" }, [
            t(
              "div",
              {
                staticClass: "quiz__card",
                class: { "quiz__card--checked": e.card.select },
                on: {
                  click: function (t) {
                    return e.selectCard({ type: e.card.type, index: e.index });
                  },
                },
              },
              [
                t("div", { staticClass: "quiz__card-bg" }, [
                  t("div", { staticClass: "quiz__card-checkbox" }),
                  t("div", { staticClass: "quiz__card-img" }, [
                    t("img", {
                      staticClass: "img",
                      attrs: { src: e.card.img, alt: "" },
                    }),
                  ]),
                ]),
                t("div", { staticClass: "quiz__card-title" }, [
                  e._v(e._s(e.card.title)),
                ]),
              ],
            ),
          ]);
        };
        Zo._withStripped = !0;
        var Ro = s(171),
          Uo = {
            name: "quiz-card",
            components: {},
            props: {
              card: { type: Object, required: !0 },
              index: { type: Number, required: !0 },
            },
            data() {
              return { winWidth: Ro(window).width() };
            },
            computed: { ...(0, na.rn)(["intro", "count"]) },
            methods: { ...(0, na.OI)(["selectCard"]) },
            mounted() {},
          },
          Go = (0, P.Z)(Uo, Zo, [], !1, null, null, null).exports,
          Ho = s(171),
          Yo = {
            components: { Card: Go },
            data() {
              return { winWidth: Ho(window).width(), slider: null };
            },
            props: { type: { type: String, require: !0 } },
            computed: {
              ...(0, na.rn)(["intro", "count", "quizData", "current", "error"]),
              isSlider() {
                return this.winWidth < 1400;
              },
            },
            methods: {
              ...(0, na.OI)(["increment"]),
              ...(0, na.nv)(["switchCards"]),
              switcher(e) {
                (this.switchCards(e), this.$forceUpdate());
              },
              initSlider() {
                let { quizSwipers: e } = this.$refs;
                this.slider = new M.ZP(e, {
                  spaceBetween: 30,
                  slidesPerView: "auto",
                  breakpoints: {
                    1200: { slidesPerView: "auto" },
                    992: { slidesPerView: "auto" },
                  },
                });
              },
            },
            mounted() {
              this.isSlider && this.initSlider();
            },
          },
          Jo = (0, P.Z)(Yo, No, [], !1, null, null, null).exports,
          Xo = s(171),
          Ko = {
            components: { AnswerCards: Jo },
            data() {
              return { winWidth: Xo(window).width(), slider: null };
            },
            computed: {
              ...(0, na.rn)(["intro", "count", "quizData", "current"]),
            },
            methods: {
              ...(0, na.nv)(["switchCards"]),
              switcher(e) {
                (this.switchCards(e), this.$forceUpdate());
              },
            },
            mounted() {},
          },
          Qo = (0, P.Z)(Ko, Vo, [], !1, null, "35160ace", null).exports,
          er = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "quiz__footer" }, [
              t("div", { staticClass: "quiz__bar" }, [
                t("div", { staticClass: "quiz__bar-bg" }, [
                  t("div", {
                    staticClass: "quiz__bar-progress",
                    style: `width:${e.setWidth}%;`,
                  }),
                ]),
                t("div", { staticClass: "quiz__bar-info" }, [
                  t("div", { staticClass: "quiz__bar-steps" }, [
                    e._v("Вопрос " + e._s(e.step) + " из " + e._s(e.max)),
                  ]),
                  t("div", { staticClass: "quiz__bar-persent" }, [
                    e._v(e._s(e.setWidth) + "%"),
                  ]),
                ]),
              ]),
            ]);
          };
        er._withStripped = !0;
        var tr = s(171),
          sr = {
            name: "quiz-progress",
            data() {
              return { winWidth: tr(window).width() };
            },
            computed: {
              ...(0, na.rn)(["step", "max"]),
              setWidth: {
                get() {
                  return ((this.step / this.max) * 100).toFixed();
                },
              },
            },
            methods: {},
            mounted() {},
          },
          ir = (0, P.Z)(sr, er, [], !1, null, null, null).exports,
          ar = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "quiz__intro" }, [
              e._m(0),
              t("div", { staticClass: "quiz__intro-info" }, [
                t("div", { staticClass: "quiz__intro-title" }, [
                  e._v(
                    "Ответь на вопросы и подбери идеальные окна со скидкой 65%",
                  ),
                ]),
                t("div", { staticClass: "quiz__intro-sub" }, [
                  e._v(
                    "После прохождения теста бонус — чек-лист по выбору окон.",
                  ),
                ]),
                e._m(1),
                t("div", { staticClass: "quiz__intro-btn" }, [
                  t(
                    "button",
                    {
                      staticClass: "btn btn--large",
                      on: {
                        click: function (t) {
                          return e.switchIntro();
                        },
                      },
                    },
                    [e._v("Получить скидку 65%")],
                  ),
                ]),
              ]),
            ]);
          };
        ar._withStripped = !0;
        var nr = {
            name: "quiz-intro",
            methods: { ...(0, na.OI)(["switchIntro"]) },
            mounted() {},
          },
          lr = (0, P.Z)(
            nr,
            ar,
            [
              function () {
                var e = this._self._c;
                this._self._setupProxy;
                return e("div", { staticClass: "quiz__intro-img" }, [
                  e("img", {
                    staticClass: "img",
                    attrs: {
                      src: "/new_style_files/upload/img_verstka/quiz/bg.webp",
                      alt: "",
                    },
                  }),
                ]);
              },
              function () {
                var e = this._self._c;
                this._self._setupProxy;
                return e("div", { staticClass: "quiz__intro-list" }, [
                  e("img", {
                    staticClass: "img",
                    attrs: {
                      src: "/new_style_files/upload/img_verstka/quiz/chek-list.webp",
                      alt: "",
                    },
                  }),
                ]);
              },
            ],
            !1,
            null,
            null,
            null,
          ).exports,
          or = function () {
            var e = this,
              t = e._self._c;
            e._self._setupProxy;
            return t("div", { staticClass: "quiz__final" }, [
              t("div", { staticClass: "quiz__final-text h3" }, [
                e._v("Вам отлично подойдут:"),
              ]),
              e.getSystems.length > 0
                ? t(
                    "div",
                    { staticClass: "quiz__final-list" },
                    e._l(e.getSystems, function (e, s) {
                      return t("system-card", { key: s, attrs: { system: e } });
                    }),
                    1,
                  )
                : e._e(),
            ]);
          };
        or._withStripped = !0;
        var rr = function () {
          var e = this,
            t = e._self._c;
          e._self._setupProxy;
          return t("div", { staticClass: "quiz__item-system" }, [
            "allumin" != e.systemType
              ? t("div", { staticClass: "system-characters__card" }, [
                  t("div", { staticClass: "system-characters__list" }, [
                    t(
                      "div",
                      { staticClass: "h4 system-characters__list-title" },
                      [e._v(e._s(e.system.name) + " "), e._m(0)],
                    ),
                    t(
                      "ul",
                      {
                        staticClass:
                          "system-characters__list-items content-list content-list--dashed",
                      },
                      [
                        t("li", [
                          e._v("Монтажная ширина, мм "),
                          t("div", { staticClass: "content-list__value" }, [
                            e._v(" " + e._s(e.system.depth) + " "),
                          ]),
                        ]),
                        t("li", [
                          e._v("Воздушные камеры, шт. "),
                          t(
                            "div",
                            {
                              staticClass:
                                "content-list__value content-list__value-helper",
                            },
                            [
                              e._v(" " + e._s(e.system.count_cam.num) + " "),
                              t(
                                "span",
                                {
                                  ref: "helperInfo",
                                  staticClass: "helper-info js-helper-info",
                                  attrs: {
                                    "data-tippy-content":
                                      "Воздушные камеры в раме/створке/импосте",
                                  },
                                },
                                [e._v("?")],
                              ),
                            ],
                          ),
                        ]),
                        t("li", [
                          e._v("Теплозащита, м²·°С/Вт "),
                          t("div", { staticClass: "content-list__value" }, [
                            e._v(" " + e._s(e.system.thermal_coef) + " "),
                          ]),
                        ]),
                        t("li", [
                          e._v("Стеклопакет, мм "),
                          t("div", { staticClass: "content-list__value" }, [
                            e._v(" " + e._s(e.system.width) + " "),
                          ]),
                        ]),
                        t("li", [
                          e._v("Цвет массы профиля"),
                          t("div", { staticClass: "content-list__value" }, [
                            t("div", { staticClass: "color-palette" }, [
                              t(
                                "div",
                                { staticClass: "color-palette__wrap" },
                                e._l(e.system.body_color, function (e, s) {
                                  return t("div", {
                                    key: s,
                                    staticClass: "color-palette__item",
                                    style: `background-color: ${e};`,
                                  });
                                }),
                                0,
                              ),
                            ]),
                          ]),
                        ]),
                        t("li", [
                          e._v("Цвет уплотнения"),
                          t("div", { staticClass: "content-list__value" }, [
                            t("div", { staticClass: "color-palette" }, [
                              t(
                                "div",
                                { staticClass: "color-palette__wrap" },
                                e._l(e.system.seal_color, function (e, s) {
                                  return t("div", {
                                    key: s,
                                    staticClass: "color-palette__item",
                                    style: `background-color: ${e};`,
                                  });
                                }),
                                0,
                              ),
                            ]),
                          ]),
                        ]),
                        t("li", [
                          e._v("Классификация "),
                          t("div", { staticClass: "content-list__value" }, [
                            e._v(" " + e._s(e.system.system_class) + " "),
                          ]),
                        ]),
                      ],
                    ),
                    t("div", { staticClass: "system-characters__list-order" }, [
                      t(
                        "div",
                        { staticClass: "h4 system-characters__list-price" },
                        [
                          e._v("от " + e._s(e.formatNum(e.system.price)) + " "),
                          e._v(" руб/м²"),
                        ],
                      ),
                      t("div", { staticClass: "system-characters__list-btn" }, [
                        t(
                          "button",
                          {
                            staticClass: "btn btn--red",
                            attrs: { "data-modal-window": "#modal-calc-win" },
                            on: {
                              click: function (t) {
                                return e.openDialog();
                              },
                            },
                          },
                          [e._v("Рассчитать со скидкой 65%")],
                        ),
                      ]),
                    ]),
                  ]),
                  t(
                    "div",
                    {
                      staticClass:
                        "system-characters__advantage js-system-characters-data",
                    },
                    [
                      t(
                        "div",
                        { staticClass: "system-characters__advantage-wrapper" },
                        [
                          t(
                            "div",
                            { staticClass: "system-characters__image-sign" },
                            [
                              e._m(1),
                              t(
                                "a",
                                {
                                  directives: [
                                    {
                                      name: "show",
                                      rawName: "v-show",
                                      value: "Exprof-centum" === e.system.code,
                                      expression:
                                        "system.code === 'Exprof-centum'",
                                    },
                                  ],
                                  attrs: {
                                    href: "/about/articles/Exprof-awards-at-MosBuild-2023/",
                                  },
                                },
                                [
                                  t("img", {
                                    staticClass: "sign-ico",
                                    attrs: {
                                      src: "/new_style_files/assets/img/ico/MosBuild.svg",
                                      alt: "",
                                    },
                                  }),
                                ],
                              ),
                            ],
                          ),
                          t("img", {
                            staticClass:
                              "img system-characters__image system-characters__image--desktop",
                            attrs: {
                              src: e.getAdv.imgPath,
                              alt: "",
                              srcset: `${e.getAdv.imgPath},1000px.webp 2x, ${e.getAdv.imgPath},500px.webp 1x`,
                            },
                          }),
                          t("img", {
                            staticClass:
                              "img system-characters__image system-characters__image--mobile",
                            attrs: {
                              src: e.getAdv.imgPath,
                              alt: "",
                              srcset: `${e.getAdv.imgPath},1000px.webp 2x, ${e.getAdv.imgPath},500px.webp 1x`,
                            },
                          }),
                          t(
                            "div",
                            {
                              staticClass:
                                "system-characters__pins-area js-system-characters-pins",
                            },
                            e._l(e.getAdv.mobile, function (s, i) {
                              return t(
                                "button",
                                {
                                  key: i,
                                  ref: "dotsHelper",
                                  refInFor: !0,
                                  staticClass: "system-characters__pin",
                                  style: `right:${s[0]}px;top:${s[1]}px;`,
                                  attrs: {
                                    "data-tippy-content": e.getAdv.advantage[i],
                                  },
                                },
                                [e._m(2, !0)],
                              );
                            }),
                            0,
                          ),
                          t(
                            "ul",
                            { staticClass: "system-characters__data-text" },
                            e._l(e.getAdv.advantage, function (s, i) {
                              return t(
                                "li",
                                { attrs: { id: `system-advantage-text-${i}` } },
                                [e._v(e._s(s))],
                              );
                            }),
                            0,
                          ),
                          t(
                            "svg",
                            {
                              staticClass: "system-characters__data",
                              attrs: {
                                id: "system-characters-svg",
                                version: "1.1",
                                xmlns: "http://www.w3.org/2000/svg",
                                "xmlns:xlink": "http://www.w3.org/1999/xlink",
                                x: "0px",
                                y: "0px",
                                viewBox: "0 0 650 500",
                              },
                            },
                            [
                              t(
                                "g",
                                { attrs: { id: "system-advantage-group" } },
                                e._l(e.getAdv.desktop, function (e, s) {
                                  return t(
                                    "g",
                                    {
                                      key: s,
                                      attrs: {
                                        id: `system-advantage-props-${s}`,
                                      },
                                    },
                                    [
                                      t("line", {
                                        staticClass: "st2",
                                        attrs: {
                                          x1: e[0][0],
                                          y1: e[0][1],
                                          x2: e[1][0],
                                          y2: e[1][1],
                                        },
                                      }),
                                      t("circle", {
                                        staticClass: "st1",
                                        attrs: {
                                          cx: e[0][0],
                                          cy: e[0][1],
                                          r: "3",
                                        },
                                      }),
                                      t("circle", {
                                        staticClass: "st1",
                                        attrs: {
                                          cx: e[1][0],
                                          cy: e[1][1],
                                          r: "3",
                                        },
                                      }),
                                    ],
                                  );
                                }),
                                0,
                              ),
                            ],
                          ),
                        ],
                      ),
                    ],
                  ),
                ])
              : e._e(),
            "allumin" == e.systemType
              ? t("div", { staticClass: "system-characters__card" }, [
                  t("div", { staticClass: "system-characters__list" }, [
                    t(
                      "div",
                      { staticClass: "h4 system-characters__list-title" },
                      [e._v(e._s(e.allumin[0].name) + " "), e._m(3)],
                    ),
                    t(
                      "div",
                      { staticClass: "system-characters__list-items" },
                      e._l(e.allumin[0].advantage, function (s, i) {
                        return t(
                          "div",
                          {
                            key: i,
                            staticClass: "system-characters__list-block",
                          },
                          [
                            t("div", [t("b", [e._v(e._s(s.title))])]),
                            t("div", [e._v(e._s(s.desc))]),
                          ],
                        );
                      }),
                      0,
                    ),
                    t("div", { staticClass: "system-characters__list-order" }, [
                      t(
                        "div",
                        { staticClass: "h4 system-characters__list-price" },
                        [
                          e._v(
                            "от " + e._s(e.formatNum(e.allumin[0].price)) + " ",
                          ),
                          e._v(" руб/м²"),
                        ],
                      ),
                      t("div", { staticClass: "system-characters__list-btn" }, [
                        t(
                          "button",
                          {
                            staticClass: "btn btn--red",
                            attrs: { "data-modal-window": "#modal-calc-win" },
                            on: {
                              click: function (t) {
                                return e.openDialog();
                              },
                            },
                          },
                          [e._v("Рассчитать со скидкой 65%")],
                        ),
                      ]),
                    ]),
                  ]),
                  t(
                    "div",
                    {
                      staticClass:
                        "system-characters__advantage js-system-characters-data",
                    },
                    [
                      t(
                        "div",
                        { staticClass: "system-characters__advantage-wrapper" },
                        [
                          t("img", {
                            staticClass:
                              "img system-characters__image system-characters__image--alumin",
                            attrs: {
                              src: `${e.allumin[0].imgPath}.png`,
                              alt: "",
                              srcset: `${e.allumin[0].imgPath},1000px.webp 2x, ${e.allumin[0].imgPath},500px.webp 1x`,
                            },
                          }),
                        ],
                      ),
                    ],
                  ),
                ])
              : e._e(),
          ]);
        };
        rr._withStripped = !0;
        var cr = {
            name: "quiz-system-card",
            computed: {
              ...(0, na.rn)(["allumin", "advData"]),
              ...(0, na.Se)(["systemType"]),
              getAdv() {
                let e = this.system.code.split("-")[1];
                return this.advData[e];
              },
            },
            props: ["system"],
            data() {
              return { modal: null, info: null, dots: [] };
            },
            methods: {
              openDialog() {
                this.modal.open("#modal-calc-win");
              },
              formatNum(e) {
                return c.numFormat(e, "num");
              },
              initModal() {
                this.modal = new d.Z({
                  beforeOpen: () => {},
                  afterClose: () => {},
                });
              },
              helperInfo() {
                const { helperInfo: e } = this.$refs;
                this.info = (0, Oe.ZP)(e, {
                  hideOnClick: !0,
                  trigger: "click",
                  maxWidth: "200px",
                });
              },
              itinDots() {
                const { dotsHelper: e } = this.$refs;
                e.forEach((e) => {
                  this.dots.push(
                    (0, Oe.ZP)(e, {
                      hideOnClick: !0,
                      trigger: "click",
                      arrow: !1,
                      offset: [0, -10],
                    }),
                  );
                });
              },
            },
            mounted() {
              (this.initModal(), this.helperInfo(), this.itinDots());
            },
          },
          dr = {
            name: "quiz-final",
            components: {
              SystemCard: (0, P.Z)(
                cr,
                rr,
                [
                  function () {
                    var e = this,
                      t = e._self._c;
                    e._self._setupProxy;
                    return t("span", [
                      t(
                        "a",
                        {
                          staticClass: "no-style download-ico",
                          attrs: {
                            href: "/new_style_files/upload/files/check_list_okna.pdf",
                            download: "",
                          },
                        },
                        [e._v("Скачать чеклист")],
                      ),
                    ]);
                  },
                  function () {
                    var e = this._self._c;
                    this._self._setupProxy;
                    return e(
                      "a",
                      {
                        attrs: {
                          href: "/about/articles/catalog-Green-Book-2023/",
                        },
                      },
                      [
                        e("img", {
                          staticClass: "sign-ico",
                          attrs: {
                            src: "/new_style_files/upload/img_verstka/sign-greenbook.svg",
                            alt: "",
                          },
                        }),
                      ],
                    );
                  },
                  function () {
                    var e = this._self._c;
                    this._self._setupProxy;
                    return e(
                      "div",
                      { staticClass: "cross-icon cross-icon--small" },
                      [e("span"), e("span")],
                    );
                  },
                  function () {
                    var e = this,
                      t = e._self._c;
                    e._self._setupProxy;
                    return t("span", [
                      t(
                        "a",
                        {
                          staticClass: "no-style",
                          attrs: {
                            href: "/new_style_files/upload/files/check_list_okna.pdf",
                            download: "",
                          },
                        },
                        [e._v("Скачать чеклист")],
                      ),
                    ]);
                  },
                ],
                !1,
                null,
                "7f29e02d",
                null,
              ).exports,
            },
            computed: { ...(0, na.Se)(["systemType", "getSystems"]) },
            methods: {},
            mounted() {},
          },
          mr = (0, P.Z)(dr, or, [], !1, null, null, null).exports,
          ur = s(171),
          pr = {
            components: { CardList: Qo, ProgressBar: ir, Intro: lr, Final: mr },
            data() {
              return { winWidth: ur(window).width() };
            },
            computed: {
              ...(0, na.rn)(["intro", "count", "final"]),
              typeDevice() {
                return this.winWidth < 768 ? "mobile" : "desktop";
              },
            },
            methods: { ...(0, na.nv)(["getData"]) },
            watch: {
              final() {
                this.final &&
                  (document.querySelector(".quiz").style.height = "100%");
              },
            },
            mounted() {
              this.getData();
            },
          },
          hr = (0, P.Z)(pr, Ao, [], !1, null, null, null).exports,
          _r = (e) => new (a())({ el: e, store: Wo, render: (e) => e(hr) }),
          gr = s(171),
          wr = (e) => {
            const t = gr(e).find(".js-ranger"),
              s = gr(e).find(".js-ranger-sum");
            let i = [];
            t.each((e, t) => {
              let { start: a, max: n, min: l, step: o, type: r } = t.dataset,
                d = new Zi(t, { start: a, max: n, min: l, step: o }, r);
              d.$slider.on("update", () => {
                if (((i[e] = Number(d.$slider.get())), s.length)) {
                  let e = (i[0] * i[1]) / 100,
                    t = (i[0] - e) / 6;
                  s.text(c.numFormat(t.toFixed(0)));
                }
              });
            });
          },
          vr = (e) => {
            const t = document.querySelector(`${e}__image`),
              s = t.querySelector("button"),
              i = t.querySelectorAll("img");
            s.addEventListener("click", () => {
              "Открыть" == s.textContent
                ? ((i[1].style.opacity = 0), (s.textContent = "Закрыть"))
                : ((i[1].style.opacity = 1), (s.textContent = "Открыть"));
            });
          },
          fr = (e) => {
            ((t, s, i, a) => {
              const n = document.querySelectorAll(`${e}`);
              n.forEach((e, l) => {
                e.id = `tabs-${l}`;
                const o = document.querySelectorAll(`#${n[l].id} ${i}`),
                  r = document.querySelectorAll(`#${n[l].id} ${t}`),
                  c = document.querySelectorAll(`#${n[l].id} ${s}`),
                  d = () => {
                    (c.forEach((e) => {
                      (e.classList.add("js-hide"),
                        e.classList.remove("js-show", "js-fade"));
                    }),
                      r.forEach((e) => {
                        e.classList.remove(a);
                      }));
                  },
                  m = function () {
                    let e =
                      arguments.length > 0 && void 0 !== arguments[0]
                        ? arguments[0]
                        : 0;
                    (c[e].classList.add("js-show", "js-fade"),
                      c[e].classList.remove("js-hide"),
                      r[e].classList.add(a));
                  };

                function u() {
                  if (
                    (c.forEach((e) =>
                      e.classList.remove("js-hide", "js-show", "js-fade"),
                    ),
                    window.innerWidth <= 991)
                  ) {
                    new M.ZP(".js-content-slider", {
                      slidesPerView: 1.1,
                      spaceBetween: 20,
                    });
                  }
                }

                function p() {
                  new M.ZP(".js-tabs-slider", {
                    slidesPerView: "auto",
                    spaceBetween: 0,
                    breakpoints: {
                      320: { slidesPerView: "auto", spaceBetween: 10 },
                      991: { slidesPerView: "auto", spaceBetween: 0 },
                    },
                  });
                }

                (o.forEach((e) => {
                  e.addEventListener("click", (e) => {
                    const s = e.target;
                    s &&
                      s.classList.contains(t.slice(1)) &&
                      r.forEach((e, t) => {
                        s == e &&
                          (d(),
                          m(t),
                          !e.classList.contains("js-tabs--noslider") &&
                          !window.innerWidth <= 991
                            ? p()
                            : u());
                      });
                  });
                }),
                  d(),
                  m(),
                  !e.classList.contains("js-tabs--noslider") &&
                  !window.innerWidth <= 991
                    ? p()
                    : u());
              });
            })(".tabs-item", ".tabs-content__item", ".tabs-list", "active");
          },
          yr = (e) => {
            const t = document.querySelectorAll(".textbox"),
              s = document.querySelectorAll(".textbox__trigger"),
              i = document.querySelectorAll(".textbox__opacity");
            t.forEach((e, t) => {
              s[t].addEventListener("click", () => {
                (e.classList.toggle("active"),
                  i[t].classList.toggle("active"),
                  s[t].classList.toggle("active"));
              });
            });
          },
          br = (e) => {
            const t = document.querySelector(e),
              s = t.querySelector(`${e}__switch`),
              i = t.querySelectorAll(`${e}__lamin-input`),
              a = t.querySelector(".select-button"),
              n = document.querySelectorAll("[name='profile-color']"),
              l = document.querySelectorAll("[name='seal-color']"),
              o = document.querySelector(
                ".system-palette__settings-amount span",
              ),
              r = document.querySelector(".system-palette__sample-img.open"),
              c = document.querySelector(".system-palette__sample-img.closed"),
              d = document.querySelector(".system-palette__sample-rubber-open"),
              m = document.querySelector(
                ".system-palette__sample-rubber-close",
              ),
              u = document.querySelector(".system-palette__sample-zoom"),
              p = document.querySelector(".system-palette__sample-zoom .zoom"),
              h = {
                open: "/new_style_files/images2/black-open.webp",
                close: "/new_style_files/images2/black-close.webp",
              },
              _ = {
                open: "/new_style_files/images2/caramel-open.webp",
                close: "/new_style_files/images2/caramel-close.webp",
              },
              g = {
                open: "/new_style_files/images2/gray-open.webp",
                close: "/new_style_files/images2/gray-close.webp",
              },
              w = {
                open: "/new_style_files/images2/shokolad-open.webp",
                close: "/new_style_files/images2/shokolad-close.webp",
              },
              v = {
                open: "/new_style_files/images2/white-open.webp",
                close: "/new_style_files/images2/white-close.webp",
              },
              f = {
                white: {
                  open: "/new_style_files/images2/white-open-nolam.webp",
                  close: "/new_style_files/images2/white-close-nolam.webp",
                },
                darkDub: {
                  oneSidedClose:
                    "/new_style_files/images2/white-close-1lam-darkdub.webp",
                  oneSidedOpen:
                    "/new_style_files/images2/white-open-1lam-darkdub.webp",
                },
                black: {
                  twoSidedClose:
                    "/new_style_files/images2/barry-close-2lam-dark.webp",
                  twoSidedOpen:
                    "/new_style_files/images2/barry-open-2lam-dark.webp",
                },
                nut: {
                  oneSidedClose:
                    "/new_style_files/images2/white-close-1lam-oreh.webp",
                  oneSidedOpen:
                    "/new_style_files/images2/white-open-1lam-oreh.webp",
                  twoSidedClose:
                    "/new_style_files/images2/karamel-close-2lam-oreh.webp",
                  twoSidedOpen:
                    "/new_style_files/images2/karamel-open-2lam-oreh.webp",
                },
                antracit: {
                  oneSidedClose:
                    "/new_style_files/images2/white-close-1lam-antra.webp",
                  oneSidedOpen:
                    "/new_style_files/images2/white-open-1lam-antra.webp",
                  twoSidedClose:
                    "/new_style_files/images2/antra-close-2lam-antra.webp",
                  twoSidedOpen:
                    "/new_style_files/images2/antra-open-2lam-antra.webp",
                },
                shokolad: {
                  twoSidedClose1:
                    "/new_style_files/images2/shok-close-2lam-darkdub.webp",
                  twoSidedClose2:
                    "/new_style_files/images2/shok-close-2lam-choco.webp",
                  twoSidedOpen1:
                    "/new_style_files/images2/shok-open-2lam-darkdub.webp",
                  twoSidedOpen2:
                    "/new_style_files/images2/shok-open-2lam-choco.webp",
                },
                mahagon: {
                  oneSidedClose:
                    "/new_style_files/images2/white-close-1lam-maha.webp",
                  oneSidedOpen:
                    "/new_style_files/images2/white-open-1lam-maha.webp",
                },
                wine: {
                  twoSidedClose:
                    "/new_style_files/images2/barry-close-2lam-vine.webp",
                  twoSidedOpen:
                    "/new_style_files/images2/barry-open-2lam-vine.webp",
                },
              },
              y = {
                id: "color-1",
                name: "profile-color",
                color: "белый",
                matchSeal: [1, 2, 5],
                currentSeal: "seal-1",
                matchLamin: [1, 2, 3, 4, 5],
                currentLamin: "",
                imgOpen: null,
                imgClose: null,
                checkColor(e) {
                  e.forEach((e) => {
                    e.addEventListener("input", (t) => {
                      switch (
                        ((this.id = e.getAttribute("id")),
                        (this.name = e.getAttribute("name")),
                        (this.color = e.parentElement.querySelector(
                          ".cfg-colors__item-name",
                        ).textContent),
                        this.id)
                      ) {
                        case "color-1":
                          (this.laminForBerry(),
                            k.checkSelectValue(a),
                            (this.matchSeal = [1, 2, 5]),
                            (this.matchLamin = [1, 2, 3, 4, 5]),
                            (this.currentSeal = `seal-${this.matchSeal[0]}`),
                            (this.currentLamin = `lamin-${this.matchLamin[0]}`),
                            document.querySelector("#seal-1").click(),
                            document.querySelector("#lamin-1").click(),
                            k.isLamination
                              ? ((r.src = f.darkDub.oneSidedOpen),
                                (c.src = f.darkDub.oneSidedClose),
                                (p.src = f.darkDub.oneSidedOpen),
                                (o.textContent = b[1]),
                                (this.price = o.textContent))
                              : ((r.src = f.white.open),
                                (c.src = f.white.close),
                                (p.src = f.white.open),
                                (o.textContent = b[0]),
                                (this.price = o.textContent)),
                            (d.src = v.open),
                            (m.src = v.close));
                          break;
                        case "color-2":
                          (this.activeLaminForColors(s, a),
                            this.laminForBerry(),
                            k.checkSelectValue(a),
                            (this.matchSeal = [5]),
                            (this.matchLamin = [3]),
                            (this.currentSeal = `seal-${this.matchSeal[0]}`),
                            document.querySelector("#seal-5").click(),
                            (r.src = f.antracit.twoSidedOpen),
                            (c.src = f.antracit.twoSidedClose),
                            (p.src = f.antracit.twoSidedOpen),
                            (d.src = h.open),
                            (m.src = h.close));
                          break;
                        case "color-3":
                          (this.activeLaminForColors(s, a),
                            this.laminForBerry(),
                            k.checkSelectValue(a),
                            (this.matchSeal = [3, 4]),
                            (this.matchLamin = [4]),
                            (this.currentSeal = "seal-3"),
                            (this.currentLamin = "lamin-4"),
                            document.querySelector("#seal-3").click(),
                            (r.src = f.nut.twoSidedOpen),
                            (c.src = f.nut.twoSidedClose),
                            (p.src = f.nut.twoSidedOpen),
                            (d.src = _.open),
                            (m.src = _.close));
                          break;
                        case "color-4":
                          (this.activeLaminForColors(s, a),
                            this.laminForBerry(),
                            k.checkSelectValue(a),
                            (this.matchSeal = [4, 5]),
                            (this.matchLamin = [1, 2]),
                            (this.currentSeal = `seal-${this.matchSeal[0]}`),
                            (this.currentLamin = "lamin-1"),
                            document.querySelector("#seal-4").click(),
                            (r.src = f.shokolad.twoSidedOpen1),
                            (c.src = f.shokolad.twoSidedClose1),
                            (p.src = f.shokolad.twoSidedOpen1),
                            (d.src = w.open),
                            (m.src = w.close));
                          break;
                        case "color-5":
                          (this.activeLaminForColors(s, a),
                            this.laminForBerry(),
                            k.checkSelectValue(a),
                            (this.matchSeal = [5]),
                            (this.matchLamin = [6, 7]),
                            (this.currentSeal = `seal-${this.matchSeal[0]}`),
                            document.querySelector("#seal-5").click(),
                            (r.src = f.wine.twoSidedOpen),
                            (c.src = f.wine.twoSidedClose),
                            (p.src = f.wine.twoSidedOpen),
                            (d.src = h.open),
                            (m.src = h.close));
                      }
                      (this.checkChooseSeal(l), this.checkChooseLamin(i));
                    });
                  });
                },
                activeLaminForColors(e, t) {
                  ((e.checked = !0),
                    (k.isLamination = !0),
                    t.removeAttribute("disabled"));
                },
                defaultForDisSwitch() {
                  ((k.laminationType = ""),
                    k.isLamination ||
                      (i.forEach((e) => e.removeAttribute("checked")),
                      (r.src = f.white.open),
                      (c.src = f.white.close),
                      "color-1" !== this.id && n[0].click()));
                },
                laminForBerry() {
                  "color-5" === this.id
                    ? (document
                        .querySelectorAll(
                          ".system-palette__settings-lamin .cfg-images__item",
                        )
                        .forEach((e) => (e.style.display = "none")),
                      document
                        .querySelectorAll(".cfg-images__item--berry")
                        .forEach((e) => (e.style.display = "block")))
                    : (document
                        .querySelectorAll(
                          ".system-palette__settings-lamin .cfg-images__item",
                        )
                        .forEach((e) => (e.style.display = "block")),
                      document
                        .querySelectorAll(".cfg-images__item--berry")
                        .forEach((e) => (e.style.display = "none")));
                },
                checkChooseSeal(e) {
                  (e.forEach((e, t) => {
                    ((e.disabled = !0),
                      e.addEventListener("input", (e) => {
                        switch (
                          ((this.currentSeal = e.target.id), this.currentSeal)
                        ) {
                          case "seal-1":
                            ((d.src = v.open), (m.src = v.close));
                            break;
                          case "seal-2":
                            ((d.src = g.open), (m.src = g.close));
                            break;
                          case "seal-3":
                            ((d.src = _.open), (m.src = _.close));
                            break;
                          case "seal-4":
                            ((d.src = w.open), (m.src = w.close));
                            break;
                          case "seal-5":
                            ((d.src = h.open), (m.src = h.close));
                        }
                      }));
                  }),
                    this.matchSeal.forEach((e) =>
                      document
                        .querySelector(`#seal-${e}`)
                        .removeAttribute("disabled"),
                    ));
                  const t = document.querySelector(
                    `#seal-${this.matchSeal[0]}`,
                  );
                  t.disabled ? t.removeAttribute("checked") : (t.checked = !0);
                },
                checkChooseLamin(e) {
                  if (k.isLamination) {
                    e.forEach((e) => {
                      ((e.disabled = !0),
                        this.matchLamin.forEach((e) =>
                          document
                            .querySelector(`#lamin-${e}`)
                            .removeAttribute("disabled"),
                        ),
                        e.addEventListener("click", (e) => {
                          ((this.currentLamin = e.target.id),
                            "color-1" === this.id &&
                              ("lamin-1" === this.currentLamin ||
                              "lamin-2" === this.currentLamin
                                ? ((r.src = f.darkDub.oneSidedOpen),
                                  (c.src = f.darkDub.oneSidedClose),
                                  (p.src = f.darkDub.oneSidedOpen))
                                : "lamin-3" === this.currentLamin
                                  ? ((r.src = f.antracit.oneSidedOpen),
                                    (c.src = f.antracit.oneSidedClose),
                                    (p.src = f.antracit.oneSidedOpen))
                                  : "lamin-4" === this.currentLamin
                                    ? ((r.src = f.nut.oneSidedOpen),
                                      (c.src = f.nut.oneSidedClose),
                                      (p.src = f.nut.oneSidedOpen))
                                    : "lamin-5" === this.currentLamin &&
                                      ((r.src = f.mahagon.oneSidedOpen),
                                      (c.src = f.mahagon.oneSidedClose),
                                      (p.src = f.mahagon.oneSidedOpen))),
                            "color-3" === this.id &&
                              "seal-3" === this.currentSeal &&
                              ((d.src = _.open),
                              (m.src = _.close),
                              (p.src = _.open)),
                            "color-4" === this.id &&
                              ("lamin-1" === this.currentLamin
                                ? ((r.src = f.shokolad.twoSidedOpen1),
                                  (c.src = f.shokolad.twoSidedClose1),
                                  (p.src = f.shokolad.twoSidedOpen1))
                                : ((r.src = f.shokolad.twoSidedOpen2),
                                  (c.src = f.shokolad.twoSidedClose2),
                                  (p.src = f.shokolad.twoSidedOpen2))),
                            "color-5" === this.id &&
                              ("lamin-6" === this.currentLamin
                                ? ((r.src = f.wine.twoSidedOpen),
                                  (c.src = f.wine.twoSidedClose),
                                  (p.src = f.wine.twoSided))
                                : ((r.src = f.black.twoSidedOpen),
                                  (c.src = f.black.twoSidedClose),
                                  (p.src = f.black.twoSidedOpen))));
                        }));
                    });
                    const t = document.querySelector(
                      `#lamin-${this.matchLamin[0]}`,
                    );
                    t.disabled
                      ? t.removeAttribute("checked")
                      : (t.checked = !0);
                  }
                },
                toggleWindow() {
                  const e = document.querySelector(".window-toggle__btn"),
                    t = document.querySelector(".window-zoom__btn");
                  ((c.style.opacity = 0),
                    (m.style.opacity = 0),
                    e.addEventListener("click", (e) => {
                      (r.classList.toggle("active"),
                        r.classList.contains("active")
                          ? ((c.style.opacity = 1),
                            (d.style.opacity = 0),
                            (m.style.opacity = 1))
                          : ((c.style.opacity = 0),
                            (m.style.opacity = 0),
                            (d.style.opacity = 1)));
                    }),
                    t.addEventListener("click", (e) => {
                      (u.classList.toggle("active"),
                        r.classList.remove("active"));
                    }),
                    document.addEventListener("mouseup", () => {
                      u && u.classList.remove("active");
                    }));
                },
              },
              b = ["12 790", "17 090", "20 290"],
              k = {
                isLamination: null,
                laminationType: null,
                massa: y,
                price: b[0],
                checkLamination: function (e, t, i) {
                  (e.checked
                    ? t.removeAttribute("disabled")
                    : (t.disabled = "true"),
                    i.forEach((e) => {
                      s.checked
                        ? e.removeAttribute("disabled")
                        : (e.disabled = "true");
                    }),
                    (this.isLamination = e.checked));
                },
                checkSelectValue(e) {
                  const t = e.nextElementSibling.querySelectorAll("input");
                  ("color-1" === y.id
                    ? (t[0].parentElement.removeAttribute("disabled"),
                      (t[0].parentElement.style.cursor = ""),
                      (document.querySelector(
                        ".js-custom-select .selected-value",
                      ).textContent = t[0].parentElement.textContent),
                      (this.laminationType = t[0].getAttribute("id")),
                      this.checkPrice())
                    : (t[0].removeAttribute("disabled"),
                      (t[0].disabled = !0),
                      t[0].parentElement.setAttribute("disabled", !0),
                      (t[0].parentElement.style.cursor = "not-allowed"),
                      t[1].click(),
                      (document.querySelector(
                        ".js-custom-select .selected-value",
                      ).textContent = t[1].parentElement.textContent),
                      (this.laminationType = t[1].getAttribute("id")),
                      this.checkPrice()),
                    t.forEach((e) => {
                      e.addEventListener("click", (e) => {
                        ((this.laminationType = e.target.getAttribute("id")),
                          "color-1" === y.id &&
                            "two-sided" === this.laminationType &&
                            n[1].click(),
                          this.checkPrice());
                      });
                    }));
                },
                checkPrice() {
                  ((o.textContent = b[0]),
                    this.isLamination ||
                      "one-sided" === this.laminationType ||
                      "two-sided" === this.laminationType ||
                      ((o.textContent = b[0]), (this.price = o.textContent)),
                    this.isLamination &&
                      "one-sided" === this.laminationType &&
                      "two-sided" !== this.laminationType &&
                      ((o.textContent = b[1]), (this.price = o.textContent)),
                    this.isLamination &&
                      "one-sided" !== this.laminationType &&
                      "two-sided" === this.laminationType &&
                      ((o.textContent = b[2]), (this.price = o.textContent)));
                },
              };
            (y.toggleWindow(),
              y.checkColor(n),
              y.checkChooseSeal(l),
              y.checkChooseLamin(i),
              k.checkSelectValue(a),
              k.checkLamination(s, a, i),
              s.addEventListener("input", () => {
                (k.checkLamination(s, a, i),
                  "color-1" === y.id &&
                    (y.checkChooseLamin(i),
                    k.isLamination
                      ? ((r.src = f.darkDub.oneSidedOpen),
                        (c.src = f.darkDub.oneSidedClose),
                        (p.src = f.darkDub.oneSidedOpen))
                      : ((r.src = f.white.open),
                        (c.src = f.white.close),
                        (p.src = f.white.open))),
                  k.checkPrice(),
                  y.defaultForDisSwitch());
              }));
          },
          kr = (e) => {
            const t = document.querySelector(".js-custom-select"),
              s = document.querySelector(".select-button"),
              i = document.querySelector(".selected-value"),
              a = document.querySelectorAll(".select-dropdown li");
            (s.addEventListener("click", (e) => {
              (t.classList.toggle("active"),
                s.setAttribute(
                  "aria-expanded",
                  "true" === s.getAttribute("aria-expanded") ? "false" : "true",
                ));
            }),
              document.addEventListener("mouseup", function (e) {
                t.contains(e.target) || t.classList.remove("active");
              }),
              a.forEach((e) => {
                function s(e) {
                  ("click" === e.type &&
                    0 !== e.clientX &&
                    0 !== e.clientY &&
                    ((i.textContent = this.children[1].textContent),
                    t.classList.remove("active")),
                    "Enter" === e.key &&
                      ((i.textContent = this.textContent),
                      t.classList.remove("active")));
                }

                (e.addEventListener("keyup", s),
                  e.addEventListener("click", s));
              }));
          },
          Cr = s(171);
        ((window.isDev = !1),
          (a().config.devtools = !1),
          (Cr.fn.getSelector = function () {
            return (" " + this[0].className).replace(/ /g, ".");
          }),
          l.add("[data-format-money]", w),
          l.add(".js-weight-bar", y),
          l.add(".js-input-address-dadata", L),
          l.add(".js-textbox", yr),
          l.add(".js-mega-menu", F),
          l.add(".js-mob-mega-menu", B),
          l.add(".js-head-menu", A),
          l.add(".js-modal-win", de),
          l.add(".js-modal-calc-win", ue),
          l.add(".js-modal-stay-diler", he),
          l.add(".js-modal-gotovie-order", ge),
          l.add(".js-modal-vacancy", ve),
          l.add(".js-free-meas-form", Y),
          l.add(".js-feedback-form", J),
          l.add(".js-contacts-feedback-form", X),
          l.add(".js-write-key-person-form", K),
          l.add(".js-reclamation-form", ie),
          l.add(".js-consultation-form", te),
          l.add(".js-coop-form", ee),
          l.add(".js-help-consult", di),
          l.add(".js-vacancy-respond", ne),
          l.add(".js-mosq-checkout-form", Wi),
          l.add(".js-helper-info", We),
          l.add(".js-main-banner", Se),
          l.add(".js-default-banner", je),
          l.add(".js-stock-banner", Le),
          l.add(".js-stock-banner-2", Le2),
          l.add(".js-plastic-win-banner", $e),
          l.add(".js-gotovie-okna-banner", ze),
          l.add("#js-education-list", ke),
          l.add(".js-head-contact--basket", Fe),
          l.add(".js-common-swiper", Qi),
          l.add(".js-system-palette", br),
          l.add("#vue-configurator", Va),
          l.add(".js-system-characters-data", Be),
          l.add(".js-case-articles", Ve),
          l.add(".js-main-about", Ze),
          l.add(".js-win-prices", Ge),
          l.add(".js-certif-slider", Xe),
          l.add(".js-work-example", V),
          l.add(".js-certif-slider-window", Ke),
          l.add(".js-faq-quest", et),
          l.add(".js-news-company", st),
          l.add(".js-advan-plastic-win", at),
          l.add(".js-win-access", lt),
          l.add(".js-price-present", ct),
          l.add(".js-decor-design", mt),
          l.add(".js-ready-made-win", pt),
          l.add(".js-advan-info-triple", _t),
          l.add(".js-advan-win-system", xt),
          l.add(".js-advan-video", jt),
          l.add(".js-price-option", Dt),
          l.add(".js-doors-price", Ot),
          l.add(".js-front-doors-vars", Et),
          l.add(".js-advan-doors", $t),
          l.add(".js-turnkey-balcony", Bt),
          l.add(".js-price-typical-house", Wt),
          l.add(".js-six-steps", Vt),
          l.add(".js-decorative-layouts", Ys),
          l.add(".js-how-it-work-cashback", Zt),
          l.add(".js-doors-advan", Ut),
          l.add(".js-sliding-doors-types", Ht),
          l.add(".js-balcony-doors-parts", Jt),
          l.add(".js-balcony-glazing-vars", Kt),
          l.add(".js-price-french-glazing", es),
          l.add(".js-company-about", ss),
          l.add(".js-own-production", as),
          l.add(".js-dealer-warranties", ls),
          l.add(".js-prod-price-slider", Ts),
          l.add(".js-tabs", fr),
          l.add(".js-our-advantages", os),
          l.add(".js-three-column-block", rs),
          l.add(".js-slider-window-tiles", cs),
          l.add(".js-calculate-garbage-select", ds),
          l.add(".js-save-new-windows", ps),
          l.add(".js-select", Yi),
          l.add(".js-custom-select", kr),
          l.add(".js-calc-perform", Ui),
          l.add(".js-garbage-calc-collection", Hi),
          l.add(".js-pop-colors", hs),
          l.add(".js-two-column-block", _s),
          l.add(".js-slider-window-cards", gs),
          l.add(".js-tech-adv", vr),
          l.add(".js-add-options", vs),
          l.add(".js-install-steps", ys),
          l.add(".js-device-types", ks),
          l.add(".js-types-material", yi),
          l.add(".js-calc-work-performed", ki),
          l.add(".js-about-tabs", $i),
          l.add(".js-about-slider", Ci),
          l.add(".js-about-slider-tabs", Si),
          l.add(".js-about-tiles-tabs", xi),
          l.add(".js-about-reviews-form", se),
          l.add(".js-reviews-list", Lt),
          l.add(".js-about-portfolio-cards", zi),
          document.addEventListener("DOMContentLoaded", () => {
            l.add(".js-about-contacts-addresses", qi);
          }),
          l.add(".js-actions-carousel", ta),
          l.add(".js-about-contacts-list", Di),
          l.add(".js-about-contacts-info", Li),
          l.add(".js-rating-star", Mi),
          l.add(".js-best-measurers", Ss),
          l.add(".js-measure-include", Ps),
          l.add(".js-delivery-price", qs),
          l.add(".js-before-after-slider", Ds),
          l.add(".js-tender-gallery", aa),
          l.add(".js-our-partners", Ms),
          l.add(".js-our-employees", zs),
          l.add(".js-vacations", Fs),
          l.add(".js-garbage-collection-vars", Is),
          l.add(".js-garbage-collection-price", As),
          l.add(".js-handles-color", Zs),
          l.add(".js-handles-func", Us),
          l.add(".js-vacancy-slider", Hs),
          l.add(".js-vacancy-btn", oe),
          l.add(".js-advan-slider", Js),
          l.add(".js-stained-glass-incl", Ks),
          l.add(".js-classic-glass", ei),
          l.add(".js-climatherm-slider", si),
          l.add(".js-glazing-table", ai),
          l.add(".js-glazing-vars", li),
          l.add(".js-glazing-decoration", ri),
          l.add(".js-single-glazing-info", ci),
          l.add(".js-noise-protect-info", mi),
          l.add(".js-tinting-vars", ui),
          l.add(".js-tinting-rate", hi),
          l.add(".js-tinting-slider", _i),
          l.add(".js-work-gallery", wi),
          l.add(".js-mosq-advan", Fi),
          l.add(".js-mosq-net-type", Ti),
          l.add(".js-rassrochka", wr),
          l.add(".js-sill-color", Xi),
          l.add(".js-card-line-swiper", wt),
          l.add(".js-feature-masonry", ft),
          l.add(".js-slider-with-desc", bt),
          l.add(".js-two-column-and-slider", kt),
          l.add(".js-slider-lamination", Ai),
          l.add(".js-aluminium-systems-slider", Ni),
          l.add("#vue-assort-Exprof", dn),
          l.add("#vue-window-selection-parameters", qn),
          l.add("#vue-lamin-color", Vn),
          l.add("#vue-tiled-win-sys", il),
          l.add("#vue-loggia-calc", hl),
          l.add("#vue-mosq-calc", bl),
          l.add("#vue-calendar-delivery", El),
          l.add("#vue-mosq-basket", Gl),
          l.add("#vue-payment-online", so),
          l.add("#vue-window-catalog", xo),
          l.add("#vue-catalog-basket", Eo),
          l.add("#vue-standart-win-card", Io),
          l.add("#vue-article-content", oo),
          l.add("#vue-quiz-app", _r),
          Cr(function () {
            (_.checkJS(),
              _.fixVHMobileDevice(),
              l.init(),
              _.initVideoModal(),
              _.initSmoothScrollToAnchor(),
              _.initWaCt(),
              _.initFlBanner(),
              _.sessionCttoWaTg(),
              window.innerWidth < 800 && _.initMobileBtn());
          }));
      },
    },
    s = {};

  function i(e) {
    var a = s[e];
    if (void 0 !== a) return a.exports;
    var n = (s[e] = { exports: {} });
    return (t[e].call(n.exports, n, n.exports, i), n.exports);
  }

  ((i.m = t),
    (e = []),
    (i.O = function (t, s, a, n) {
      if (!s) {
        var l = 1 / 0;
        for (d = 0; d < e.length; d++) {
          ((s = e[d][0]), (a = e[d][1]), (n = e[d][2]));
          for (var o = !0, r = 0; r < s.length; r++)
            (!1 & n || l >= n) &&
            Object.keys(i.O).every(function (e) {
              return i.O[e](s[r]);
            })
              ? s.splice(r--, 1)
              : ((o = !1), n < l && (l = n));
          if (o) {
            e.splice(d--, 1);
            var c = a();
            void 0 !== c && (t = c);
          }
        }
        return t;
      }
      n = n || 0;
      for (var d = e.length; d > 0 && e[d - 1][2] > n; d--) e[d] = e[d - 1];
      e[d] = [s, a, n];
    }),
    (i.n = function (e) {
      var t =
        e && e.__esModule
          ? function () {
              return e.default;
            }
          : function () {
              return e;
            };
      return (i.d(t, { a: t }), t);
    }),
    (i.d = function (e, t) {
      for (var s in t)
        i.o(t, s) &&
          !i.o(e, s) &&
          Object.defineProperty(e, s, { enumerable: !0, get: t[s] });
    }),
    (i.g = (function () {
      if ("object" == typeof globalThis) return globalThis;
      try {
        return this || new Function("return this")();
      } catch (e) {
        if ("object" == typeof window) return window;
      }
    })()),
    (i.o = function (e, t) {
      return Object.prototype.hasOwnProperty.call(e, t);
    }),
    (function () {
      var e = { 143: 0 };
      i.O.j = function (t) {
        return 0 === e[t];
      };
      var t = function (t, s) {
          var a,
            n,
            l = s[0],
            o = s[1],
            r = s[2],
            c = 0;
          if (
            l.some(function (t) {
              return 0 !== e[t];
            })
          ) {
            for (a in o) i.o(o, a) && (i.m[a] = o[a]);
            if (r) var d = r(i);
          }
          for (t && t(s); c < l.length; c++)
            ((n = l[c]), i.o(e, n) && e[n] && e[n][0](), (e[n] = 0));
          return i.O(d);
        },
        s = (self.webpackChunkplastika_okon =
          self.webpackChunkplastika_okon || []);
      (s.forEach(t.bind(null, 0)), (s.push = t.bind(null, s.push.bind(s))));
    })());
  var a = i.O(void 0, [216], function () {
    return i(851);
  });
  a = i.O(a);
})();
