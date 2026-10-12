/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

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

/***/ "./src/js/components/hero.js"
/*!***********************************!*\
  !*** ./src/js/components/hero.js ***!
  \***********************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Hero)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var Hero = /*#__PURE__*/function () {
  function Hero() {
    _classCallCheck(this, Hero);
  }
  return _createClass(Hero, [{
    key: "init",
    value: function init() {
      var heroVideos = document.querySelectorAll('.hero__video');
      heroVideos.forEach(function (video) {
        video.playbackRate = 0.5;
        var playCount = 1;
        var maxPlays = 3;
        video.addEventListener('ended', function () {
          if (playCount < maxPlays) {
            playCount++;
            video.play();
          } else if (playCount === maxPlays) {
            // Start the 4th run but stop after 3 seconds
            playCount++;
            video.play();
            setTimeout(function () {
              video.pause();
            }, 800);
          }
        });
      });
    }
  }]);
}();


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
/* harmony import */ var _components_contact_form__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/contact-form */ "./src/js/components/contact-form.js");
/* harmony import */ var _components_hero__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/hero */ "./src/js/components/hero.js");
/* harmony import */ var _components_testimonial_slider__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/testimonial-slider */ "./src/js/components/testimonial-slider.js");
/* harmony import */ var _components_reveal__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/reveal */ "./src/js/components/reveal.js");
/* harmony import */ var _components_cookie_banner_a11y_fix__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/cookie-banner-a11y-fix */ "./src/js/components/cookie-banner-a11y-fix.js");






document.addEventListener('DOMContentLoaded', function () {
  // Initialize components
  var header = new _components_header__WEBPACK_IMPORTED_MODULE_0__["default"]();
  header.init();
  var contactForm = new _components_contact_form__WEBPACK_IMPORTED_MODULE_1__["default"]();
  contactForm.init();
  var hero = new _components_hero__WEBPACK_IMPORTED_MODULE_2__["default"]();
  hero.init();
  var testimonialSlider = new _components_testimonial_slider__WEBPACK_IMPORTED_MODULE_3__["default"]();
  testimonialSlider.init();
  var reveal = new _components_reveal__WEBPACK_IMPORTED_MODULE_4__["default"]();
  reveal.init();
  var cookieBannerA11yFix = new _components_cookie_banner_a11y_fix__WEBPACK_IMPORTED_MODULE_5__["default"]();
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