/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************!*\
  !*** ./resources/js/suggestions.js ***!
  \*************************************/
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var TextSuggestions = /*#__PURE__*/function () {
  function TextSuggestions(target) {
    var baseForm = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "formNewOffer";

    _classCallCheck(this, TextSuggestions);

    _defineProperty(this, "keywords", []);

    _defineProperty(this, "target", "");

    _defineProperty(this, "baseForm", "");

    _defineProperty(this, "input", []);

    _defineProperty(this, "listDiv", []);

    _defineProperty(this, "suggestions", []);

    _defineProperty(this, "count", 0);

    _defineProperty(this, "current", -1);

    _defineProperty(this, "oldText", "");

    _defineProperty(this, "hintText", "кнопка &#8595; вставит догадку");

    this.target = target;
    this.baseForm = baseForm;
    this.input = $('#' + baseForm + ' #' + target);
    this.loadKeywords(target);
    this.listDiv = $('#' + baseForm + ' #suggestions-' + target);
    this.saveOldText();
  }

  _createClass(TextSuggestions, [{
    key: "loadKeywords",
    value: function loadKeywords(target) {
      if (target == 'title') this.loadForTitle();else if (target == 'descr') this.loadForDescr();else console.error('Suggestions.load("' + target + '"): unknown target! ');
    }
  }, {
    key: "loadForDescr",
    value: function loadForDescr() {
      this.keywords = [{
        src: 'грм',
        trg: 'заменить ремень ГРМ'
      }, {
        src: 'торм',
        trg: 'заменить тормозные колодки'
      }, {
        src: 'торм',
        trg: 'отрегулировать тормоза'
      }, {
        src: 'торм',
        trg: 'заменить тормозные диски'
      }, {
        src: 'шин',
        trg: 'шиномонтаж'
      }, {
        src: 'кол',
        trg: 'колеса'
      }, {
        src: 'кол',
        trg: 'ремонт колеса'
      }, {
        src: 'сро',
        trg: 'СРОЧНО!'
      }, {
        src: 'све',
        trg: 'заменить свечи'
      }, {
        src: 'свет',
        trg: 'заменить лампочки'
      }, {
        src: 'даль',
        trg: 'дальнего света'
      }, {
        src: 'ближ',
        trg: 'ближнего света'
      }];
    }
  }, {
    key: "loadFromJson",
    value: function loadFromJson(data) {
      console.log(data);
    }
  }, {
    key: "loadForTitle",
    value: function loadForTitle() {
      var obj = this;
      $.getJSON("/ajax/models.json").done(function (data) {
        obj.keywords = data;
      });
    }
  }, {
    key: "suggest",
    value: function suggest(searchTerm) {
      if (searchTerm.length < 2) return [];
      var res = this.keywords.filter(function (obj) {
        return Object.values(obj).some(function (val) {
          return val.includes(searchTerm.toLowerCase());
        });
      }).slice(0, 3);
      this.count = res.length; //  console.log('suggest(): found '+this.count+' suggestions');

      this.suggestions = res;
    }
  }, {
    key: "insertNextSuggestion",
    value: function insertNextSuggestion() {
      if (this.count > 0) {
        if (this.current < this.count - 1) {
          this.current++;
        } else {
          this.current = 0;
        }

        suggestion = this.suggestions[this.current].trg;
        this.insertSuggestion(suggestion);
      }
    }
  }, {
    key: "saveOldText",
    value: function saveOldText() {
      this.oldText = $(this.input).val();
      this.current = -1;
    }
  }, {
    key: "insertSuggestion",
    value: function insertSuggestion(suggestion) {
      var text = " " + this.oldText;
      var newText = text.replace(/(.*[\s,'"\.])([^\s,'"\.]+)$/, '$1' + suggestion).substr(1);
      $(this.input).val(newText);
    }
  }, {
    key: "buildList",
    value: function buildList(searchTerm) {
      var _this = this;

      this.clear();
      this.suggest(searchTerm);

      if (this.count > 0) {
        for (var item in this.suggestions) {
          this.listDiv.append('<div class="suggestion" data-realtarget="' + this.target + '">' + this.suggestions[item].trg + '</div>');
        }

        this.listDiv.children().on('click', function (e) {
          _this.insertSuggestion(e.target.innerText);
        });
        this.listDiv.prepend('<div class="suggestions-hint w-100">' + this.hintText + '</div>');
      }
    }
  }, {
    key: "buildListForLastWord",
    value: function buildListForLastWord() {
      var words = this.oldText.split(/[\s,'"\.]+/);
      var lastWord = words[words.length - 1];
      this.buildList(lastWord);
    }
  }, {
    key: "clear",
    value: function clear() {
      this.count = 0;
      this.current = -1;
      this.listDiv.empty();
    }
  }]);

  return TextSuggestions;
}();

jQuery(function () {
  $('.predictable').each(function (i, obj) {
    //  this.prototype.suggestions = new TextSuggestions(this.id);
    console.log(obj);
    $(obj).data('suggestions', new TextSuggestions(obj.id));
  });
  $('.predictable').on('keyup', function (event) {
    var suggestions = $(this).data('suggestions');

    if (event.key == "ArrowDown" && suggestions.count > 0) {
      /** вставляем подсказку вместо последнего слова */
      suggestions.insertNextSuggestion();
    } else {
      suggestions.saveOldText();
      suggestions.buildListForLastWord();
    }
  });
  $('.predictable').on('input', function (event) {
    var suggestions = $(this).data('suggestions');
    suggestions.saveOldText();
  });
});
/******/ })()
;