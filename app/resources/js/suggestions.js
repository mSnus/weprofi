class TextSuggestions {
    keywords = [];
    target = "";
    baseForm = "";
    input = [];
    listDiv = [];
    suggestions = [];
    count = 0;
    current = -1;
    oldText = "";
    hintText = "кнопка &#8595; вставит догадку";

    constructor(target, baseForm = "formNewOffer") {
        this.target = target;
        this.baseForm = baseForm;
        this.input = $('#' + baseForm + ' #' + target);
        this.loadKeywords(target);
        this.listDiv = $('#' + baseForm + ' #suggestions-' + target);
        this.saveOldText();
    }

    loadKeywords(target) {
        if (target == 'title') this.loadFromJson('models')
        else if (target == 'descr') this.loadFromJson('tasks')
        else console.error('Suggestions.load("' + target + '"): unknown target! ');
    }

    loadFromJson(file) {
		var obj = this;

		$.getJSON("/ajax/"+file+".json")
			 .done(function (data) {
				  obj.keywords = data;
			 });
    }

    suggest(searchTerm) {
		 if (searchTerm.length < 2) return [];
		 searchTerm = searchTerm.toLowerCase();

        let res = this.keywords.filter(
            obj => Object.values(obj).some(val => val.startsWith(searchTerm))
        ).slice(0, 3);

        this.count = res.length;
        //  console.log('suggest(): found '+this.count+' suggestions');

        this.suggestions = res;

    }

    insertNextSuggestion() {
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

    saveOldText() {
        this.oldText = $(this.input).val();
        this.current = -1;
    }

    insertSuggestion(suggestion) {
        let text = " " + this.oldText;

        let newText = text.replace(/(.*[\s,'"\.])([^\s,'"\.]+)$/, '$1' + suggestion).substr(1);

        $(this.input).val(newText);
    }

    buildList(searchTerm) {
        this.clear();
        this.suggest(searchTerm);

        if (this.count > 0) {
            for (var item in this.suggestions) {
                this.listDiv.append('<div class="suggestion" data-realtarget="' + this.target + '">' + this.suggestions[item].trg + '</div>')
            }

            this.listDiv.children().on('click', (e) => {
                this.insertSuggestion(e.target.innerText);
            })

            this.listDiv.prepend('<div class="suggestions-hint w-100">' + this.hintText + '</div>');
        }
    }

    buildListForLastWord() {
        let words = this.oldText.split(/[\s,'"\.]+/);
        let lastWord = words[words.length - 1];
        this.buildList(lastWord);
    }

    clear() {
        this.count = 0;
        this.current = -1;
        this.listDiv.empty();
    }


}



jQuery(function () {
    $('.predictable').each((i, obj) => {
        //  this.prototype.suggestions = new TextSuggestions(this.id);
        console.log(obj);
        $(obj).data('suggestions', new TextSuggestions(obj.id))
    });

    $('.predictable').on('keyup', function (event) {
        let suggestions = $(this).data('suggestions');

        if (event.key == "ArrowDown" && suggestions.count > 0) {
            /** вставляем подсказку вместо последнего слова */
            suggestions.insertNextSuggestion();
        } else {
            suggestions.saveOldText();
            suggestions.buildListForLastWord();
        }
    });

    $('.predictable').on('input', function (event) {
        let suggestions = $(this).data('suggestions');
        suggestions.saveOldText();
    });
});
