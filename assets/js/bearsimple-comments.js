function wordStatic(input) {
        var content = document.getElementById('num');
        if (content && input) {
            var value = input.value;
            value = value.replace(/\n|\r/gi,"");
            content .innerText = value.length;
        }
    }
   