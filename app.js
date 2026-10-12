/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/components/cart-count.js"
/*!*****************************************!*\
  !*** ./src/js/components/cart-count.js ***!
  \*****************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regenerator() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ var e, t, r = "function" == typeof Symbol ? Symbol : {}, n = r.iterator || "@@iterator", o = r.toStringTag || "@@toStringTag"; function i(r, n, o, i) { var c = n && n.prototype instanceof Generator ? n : Generator, u = Object.create(c.prototype); return _regeneratorDefine2(u, "_invoke", function (r, n, o) { var i, c, u, f = 0, p = o || [], y = !1, G = { p: 0, n: 0, v: e, a: d, f: d.bind(e, 4), d: function d(t, r) { return i = t, c = 0, u = e, G.n = r, a; } }; function d(r, n) { for (c = r, u = n, t = 0; !y && f && !o && t < p.length; t++) { var o, i = p[t], d = G.p, l = i[2]; r > 3 ? (o = l === n) && (u = i[(c = i[4]) ? 5 : (c = 3, 3)], i[4] = i[5] = e) : i[0] <= d && ((o = r < 2 && d < i[1]) ? (c = 0, G.v = n, G.n = i[1]) : d < l && (o = r < 3 || i[0] > n || n > l) && (i[4] = r, i[5] = n, G.n = l, c = 0)); } if (o || r > 1) return a; throw y = !0, n; } return function (o, p, l) { if (f > 1) throw TypeError("Generator is already running"); for (y && 1 === p && d(p, l), c = p, u = l; (t = c < 2 ? e : u) || !y;) { i || (c ? c < 3 ? (c > 1 && (G.n = -1), d(c, u)) : G.n = u : G.v = u); try { if (f = 2, i) { if (c || (o = "next"), t = i[o]) { if (!(t = t.call(i, u))) throw TypeError("iterator result is not an object"); if (!t.done) return t; u = t.value, c < 2 && (c = 0); } else 1 === c && (t = i["return"]) && t.call(i), c < 2 && (u = TypeError("The iterator does not provide a '" + o + "' method"), c = 1); i = e; } else if ((t = (y = G.n < 0) ? u : r.call(n, G)) !== a) break; } catch (t) { i = e, c = 1, u = t; } finally { f = 1; } } return { value: t, done: y }; }; }(r, o, i), !0), u; } var a = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} t = Object.getPrototypeOf; var c = [][n] ? t(t([][n]())) : (_regeneratorDefine2(t = {}, n, function () { return this; }), t), u = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(c); function f(e) { return Object.setPrototypeOf ? Object.setPrototypeOf(e, GeneratorFunctionPrototype) : (e.__proto__ = GeneratorFunctionPrototype, _regeneratorDefine2(e, o, "GeneratorFunction")), e.prototype = Object.create(u), e; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, _regeneratorDefine2(u, "constructor", GeneratorFunctionPrototype), _regeneratorDefine2(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = "GeneratorFunction", _regeneratorDefine2(GeneratorFunctionPrototype, o, "GeneratorFunction"), _regeneratorDefine2(u), _regeneratorDefine2(u, o, "Generator"), _regeneratorDefine2(u, n, function () { return this; }), _regeneratorDefine2(u, "toString", function () { return "[object Generator]"; }), (_regenerator = function _regenerator() { return { w: i, m: f }; })(); }
function _regeneratorDefine2(e, r, n, t) { var i = Object.defineProperty; try { i({}, "", {}); } catch (e) { i = 0; } _regeneratorDefine2 = function _regeneratorDefine(e, r, n, t) { function o(r, n) { _regeneratorDefine2(e, r, function (e) { return this._invoke(r, n, e); }); } r ? i ? i(e, r, { value: n, enumerable: !t, configurable: !t, writable: !t }) : e[r] = n : (o("next", 0), o("throw", 1), o("return", 2)); }, _regeneratorDefine2(e, r, n, t); }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var COUNT_SELECTOR = '.header__cart-count';
var EMPTY_CLASS = 'header__cart-count--empty';

// Keeps the header cart count in sync after a product was added to the cart
// without a page reload. WooCommerce only re-renders its own mini-cart block.
var CartCount = /*#__PURE__*/function () {
  function CartCount() {
    _classCallCheck(this, CartCount);
  }
  return _createClass(CartCount, [{
    key: "init",
    value: function init() {
      var _this = this;
      this.countElements = document.querySelectorAll(COUNT_SELECTOR);
      if (!this.countElements.length) return;
      document.body.addEventListener('wc-blocks_added_to_cart', function () {
        return _this.refresh();
      });
      if (window.jQuery) {
        window.jQuery(document.body).on('added_to_cart removed_from_cart updated_wc_div updated_cart_totals', function () {
          return _this.refresh();
        });
      }
    }
  }, {
    key: "refresh",
    value: function () {
      var _refresh = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee() {
        var response, cart, count, _t;
        return _regenerator().w(function (_context) {
          while (1) switch (_context.p = _context.n) {
            case 0:
              _context.p = 0;
              _context.n = 1;
              return fetch("".concat(window.location.origin, "/?rest_route=/wc/store/v1/cart"), {
                credentials: 'same-origin'
              });
            case 1:
              response = _context.v;
              if (response.ok) {
                _context.n = 2;
                break;
              }
              return _context.a(2);
            case 2:
              _context.n = 3;
              return response.json();
            case 3:
              cart = _context.v;
              count = Number(cart.items_count) || 0;
              this.countElements.forEach(function (element) {
                element.textContent = count;
                element.classList.toggle(EMPTY_CLASS, count === 0);
              });
              _context.n = 5;
              break;
            case 4:
              _context.p = 4;
              _t = _context.v;
            case 5:
              return _context.a(2);
          }
        }, _callee, this, [[0, 4]]);
      }));
      function refresh() {
        return _refresh.apply(this, arguments);
      }
      return refresh;
    }()
  }]);
}();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (CartCount);

/***/ },

/***/ "./src/js/components/cart-quantity.js"
/*!********************************************!*\
  !*** ./src/js/components/cart-quantity.js ***!
  \********************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var BUTTON_SELECTOR = '.cart-item__quantity-button';
var INPUT_SELECTOR = '.cart-item__quantity-input';
var UPDATE_SELECTOR = '.cart-page__update';
var UPDATE_DELAY = 500;

// Plus/minus buttons of the cart quantity field. WooCommerce only ships a
// plain number input plus an "update cart" button; this steps the value and
// presses that button once the visitor stops clicking. Listeners are
// delegated because WooCommerce replaces the cart markup after each update.
var CartQuantity = /*#__PURE__*/function () {
  function CartQuantity() {
    _classCallCheck(this, CartQuantity);
  }
  return _createClass(CartQuantity, [{
    key: "init",
    value: function init() {
      var _this = this;
      if (!document.querySelector('.cart-page')) return;
      this.timer = null;
      document.addEventListener('click', function (event) {
        var button = event.target.closest(BUTTON_SELECTOR);
        if (!button) return;
        var input = button.parentElement.querySelector(INPUT_SELECTOR);
        if (!input) return;
        var before = input.value;
        if (Number(button.dataset.step) > 0) {
          input.stepUp();
        } else {
          input.stepDown();
        }
        if (input.value !== before) {
          input.dispatchEvent(new Event('change', {
            bubbles: true
          }));
        }
      });
      document.addEventListener('change', function (event) {
        if (!event.target.matches(INPUT_SELECTOR)) return;
        clearTimeout(_this.timer);
        _this.timer = setTimeout(function () {
          return _this.update();
        }, UPDATE_DELAY);
      });
    }
  }, {
    key: "update",
    value: function update() {
      var button = document.querySelector(UPDATE_SELECTOR);
      if (!button) return;
      button.disabled = false;
      button.click();
    }
  }]);
}();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (CartQuantity);

/***/ },

/***/ "./src/js/components/contact-form.js"
/*!*******************************************!*\
  !*** ./src/js/components/contact-form.js ***!
  \*******************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ ContactForm)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var ContactForm = /*#__PURE__*/function () {
  function ContactForm() {
    _classCallCheck(this, ContactForm);
  }
  return _createClass(ContactForm, [{
    key: "init",
    value: function init() {
      this.initAutoResize();
    }
  }, {
    key: "initAutoResize",
    value: function initAutoResize() {
      var _this = this;
      var textareas = document.querySelectorAll('.contact-form textarea');
      textareas.forEach(function (textarea) {
        // Set initial height
        _this.resize(textarea);
        textarea.addEventListener('input', function () {
          _this.resize(textarea);
        });
      });
    }
  }, {
    key: "resize",
    value: function resize(textarea) {
      textarea.style.height = ''; // Reset height to allow shrinking
      var offset = textarea.offsetHeight - textarea.clientHeight;
      var newHeight = textarea.scrollHeight + offset;

      // Only apply height if it's greater than the initial height (48px)
      if (newHeight > 48) {
        textarea.style.height = newHeight + 'px';
      } else {
        textarea.style.height = '48px';
      }
    }
  }]);
}();


/***/ },

/***/ "./src/js/components/cookie-banner-a11y-fix.js"
/*!*****************************************************!*\
  !*** ./src/js/components/cookie-banner-a11y-fix.js ***!
  \*****************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ CookieBannerA11yFix)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var CLOSE_BUTTON_SELECTOR = '.cky-btn-close';
var CORRECT_LABEL = 'Schliessen';

// The CookieYes preference-center close button ships with an aria-label
// misconfigured in the plugin's own banner content (picked up unrelated
// page text instead of a real "close" label). The plugin renders its
// banner asynchronously and outside our control, so we watch for the
// button to appear and correct the label in place rather than depending
// on a plugin setting.
var CookieBannerA11yFix = /*#__PURE__*/function () {
  function CookieBannerA11yFix() {
    _classCallCheck(this, CookieBannerA11yFix);
  }
  return _createClass(CookieBannerA11yFix, [{
    key: "init",
    value: function init() {
      var _this = this;
      var existing = document.querySelector(CLOSE_BUTTON_SELECTOR);
      if (existing) {
        this.fix(existing);
        return;
      }
      var observer = new MutationObserver(function () {
        var button = document.querySelector(CLOSE_BUTTON_SELECTOR);
        if (button) {
          _this.fix(button);
          observer.disconnect();
        }
      });
      observer.observe(document.body, {
        childList: true,
        subtree: true
      });
    }
  }, {
    key: "fix",
    value: function fix(button) {
      button.setAttribute('aria-label', CORRECT_LABEL);
    }
  }]);
}();


/***/ },

/***/ "./src/js/components/header.js"
/*!*************************************!*\
  !*** ./src/js/components/header.js ***!
  \*************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var Header = /*#__PURE__*/function () {
  function Header() {
    _classCallCheck(this, Header);
    this.headerElement = document.querySelector('.header') || document.querySelector('.site-header');
    this.lastScrollY = window.scrollY;
    this.scrollThreshold = 100;
  }
  return _createClass(Header, [{
    key: "init",
    value: function init() {
      var _this = this;
      if (!this.headerElement) return;
      window.addEventListener('scroll', function () {
        var currentScrollY = window.scrollY;
        var isScrollingUp = currentScrollY < _this.lastScrollY;

        // Über dem Threshold: Fixed-Verhalten aktivieren
        if (currentScrollY > _this.scrollThreshold) {
          if (isScrollingUp) {
            // Falls der Header noch nicht fixiert ist, fügen wir die Klasse ohne Animation hinzu,
            // damit er von opacity 0 aus einblendet (anstatt von 1 runter zu faden).
            if (!_this.headerElement.classList.contains('header--fixed')) {
              var originalTransition = _this.headerElement.style.transition;
              _this.headerElement.style.transition = 'none';
              _this.headerElement.classList.add('header--fixed');

              // Force reflow
              _this.headerElement.offsetHeight;
              _this.headerElement.style.transition = originalTransition;
            }
            _this.headerElement.classList.add('header--visible');
          } else {
            // Beim Runterscrollen nur ausblenden, aber fixiert lassen (falls er es schon war),
            // damit das Ausfaden sauber funktioniert.
            _this.headerElement.classList.remove('header--visible');
          }
        } else {
          // Unter dem Threshold: Fixed-Verhalten deaktivieren
          // Wir lassen es aber beim hochscrollen richtung 0 langsam ausblenden,
          // bevor wir die Klasse ganz entfernen.
          if (currentScrollY <= 10) {
            _this.headerElement.classList.remove('header--fixed');
            _this.headerElement.classList.remove('header--visible');
          } else if (!isScrollingUp) {
            // Wenn wir unter den Threshold scrollen (nach unten),
            // direkt ausblenden (falls es noch da war).
            _this.headerElement.classList.remove('header--visible');
          }
        }
        _this.lastScrollY = currentScrollY;
      }, {
        passive: true
      });
    }
  }]);
}();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Header);

/***/ },

/***/ "./src/js/components/reveal.js"
/*!*************************************!*\
  !*** ./src/js/components/reveal.js ***!
  \*************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Reveal)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var SELECTOR = '.section__heading, .section__lead, .cta__container, .testimonial-slider';

// Repeated grid/list items - staggered relative to their siblings within the
// same row instead of all fading in at once.
var STAGGER_SELECTOR = '.service, .service-card, .step, .value-card, .employee-card, .project-card, .project-advantage';
var STAGGER_STEP_MS = 100;
var STAGGER_MAX_STEPS = 5;
var Reveal = /*#__PURE__*/function () {
  function Reveal() {
    _classCallCheck(this, Reveal);
  }
  return _createClass(Reveal, [{
    key: "init",
    value: function init() {
      this.assignStaggerDelays();
      var elements = document.querySelectorAll("".concat(SELECTOR, ", ").concat(STAGGER_SELECTOR));
      if (!elements.length) {
        return;
      }
      var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      if (prefersReducedMotion) {
        elements.forEach(function (el) {
          return el.classList.add('is-visible');
        });
        return;
      }
      var observer = new IntersectionObserver(function (entries, obs) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            obs.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.12,
        rootMargin: '0px 0px -8% 0px'
      });
      elements.forEach(function (el) {
        // Elements already in (or above) the viewport on load are shown
        // immediately instead of animated, so nothing appears to flash
        // or fade in on first paint.
        var rect = el.getBoundingClientRect();
        var alreadyVisible = rect.top < window.innerHeight && rect.bottom > 0;
        if (alreadyVisible) {
          el.classList.add('is-visible');
          return;
        }
        observer.observe(el);
      });
    }

    // Groups repeated items (e.g. the 3 service-cards in a row) by their
    // nearest shared wrapper and gives each one an increasing transition
    // delay by its position in that group, so a row cascades in left to
    // right instead of appearing all at once.
  }, {
    key: "assignStaggerDelays",
    value: function assignStaggerDelays() {
      var elements = document.querySelectorAll(STAGGER_SELECTOR);
      var groups = new Map();
      elements.forEach(function (el) {
        var group = el.closest('.wp-block-columns') || el.parentElement;
        if (!groups.has(group)) {
          groups.set(group, []);
        }
        groups.get(group).push(el);
      });
      groups.forEach(function (group) {
        group.forEach(function (el, index) {
          el.style.transitionDelay = "".concat(Math.min(index, STAGGER_MAX_STEPS) * STAGGER_STEP_MS, "ms");
        });
      });
    }
  }]);
}();


/***/ },

/***/ "./src/js/components/testimonial-slider.js"
/*!*************************************************!*\
  !*** ./src/js/components/testimonial-slider.js ***!
  \*************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ TestimonialSlider)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var TestimonialSlider = /*#__PURE__*/function () {
  function TestimonialSlider() {
    _classCallCheck(this, TestimonialSlider);
  }
  return _createClass(TestimonialSlider, [{
    key: "init",
    value: function init() {
      var update = function update() {
        document.querySelectorAll('.uc_quote_item .ue-text').forEach(function (ueText) {
          // Skip items the visitor currently has expanded - the button
          // must stay visible so they can collapse it again.
          if (ueText.classList.contains('ue-active')) {
            return;
          }
          var p = ueText.querySelector('p');
          var btn = ueText.nextElementSibling;
          if (!p || !btn || !btn.classList.contains('ue-text-unfold-btn')) {
            return;
          }
          var isTruncated = p.scrollHeight > p.clientHeight + 1;
          btn.style.display = isTruncated ? '' : 'none';
        });
      };
      update();
      window.addEventListener('resize', update);
    }
  }]);
}();


/***/ }

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Check if module exists (development only)
/******/ 		if (__webpack_modules__[moduleId] === undefined) {
/******/ 			var e = new Error("Cannot find module '" + moduleId + "'");
/******/ 			e.code = 'MODULE_NOT_FOUND';
/******/ 			throw e;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other entry modules.
(() => {
var __webpack_exports__ = {};
/*!***********************!*\
  !*** ./src/js/app.js ***!
  \***********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_header__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/header */ "./src/js/components/header.js");
/* harmony import */ var _components_cart_count__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/cart-count */ "./src/js/components/cart-count.js");
/* harmony import */ var _components_cart_quantity__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/cart-quantity */ "./src/js/components/cart-quantity.js");
/* harmony import */ var _components_contact_form__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/contact-form */ "./src/js/components/contact-form.js");
/* harmony import */ var _components_testimonial_slider__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/testimonial-slider */ "./src/js/components/testimonial-slider.js");
/* harmony import */ var _components_reveal__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/reveal */ "./src/js/components/reveal.js");
/* harmony import */ var _components_cookie_banner_a11y_fix__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./components/cookie-banner-a11y-fix */ "./src/js/components/cookie-banner-a11y-fix.js");







document.addEventListener('DOMContentLoaded', function () {
  // Initialize components
  var header = new _components_header__WEBPACK_IMPORTED_MODULE_0__["default"]();
  header.init();
  var cartCount = new _components_cart_count__WEBPACK_IMPORTED_MODULE_1__["default"]();
  cartCount.init();
  var cartQuantity = new _components_cart_quantity__WEBPACK_IMPORTED_MODULE_2__["default"]();
  cartQuantity.init();
  var contactForm = new _components_contact_form__WEBPACK_IMPORTED_MODULE_3__["default"]();
  contactForm.init();
  var testimonialSlider = new _components_testimonial_slider__WEBPACK_IMPORTED_MODULE_4__["default"]();
  testimonialSlider.init();
  var reveal = new _components_reveal__WEBPACK_IMPORTED_MODULE_5__["default"]();
  reveal.init();
  var cookieBannerA11yFix = new _components_cookie_banner_a11y_fix__WEBPACK_IMPORTED_MODULE_6__["default"]();
  cookieBannerA11yFix.init();
});
})();

// This entry needs to be wrapped in an IIFE because it needs to be isolated against other entry modules.
(() => {
/*!***************************!*\
  !*** ./src/scss/app.scss ***!
  \***************************/
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin

})();

/******/ })()
;
//# sourceMappingURL=app.js.map