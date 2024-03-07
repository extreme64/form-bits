document.addEventListener('DOMContentLoaded', function () {

    // FIXME: Focus set on initial laod

    // Helper function to query elements
    let q = function (el) {
        return document.querySelectorAll(el);
    };

    // Variables for elements
    let checkboxWrap = document.getElementsByClassName("wpcf7-list-item");
    let svg = document.getElementsByClassName("svg-cb");
    let nelInput = svg.nextSibling;
    let input = document.getElementsByTagName("input");
    let checkmarkSvg;

    // Check for matches method support
    let matches = document.documentElement.matches;

    // Event listener for click events
    document.addEventListener('click', function (e) {

        // Function to handle checkbox selection
        let selectCheckBoxBtnsWrap = function (e, isLabel = false) {
            try {
                let target = isLabel ? e.target.parentNode.firstChild : e.target;
                let next = target.nextElementSibling;
                while (next.nodeType > 1) {
                    next = next.nextSibling;
                }

                target.classList.toggle('checkmark');
                checkmarkSvg = target.querySelector('path.cb-check');
                checkmarkSvg.classList.toggle('hide-svg');
       
                let newValue = !next.checked
                next.checked = newValue;
                
            } catch (error) {
                // Handle error
            }
        };

        // Function to handle radio button selection
        let selectRadioBtnsWrap = function (e, isSpan = false) {
            try {
                let target = isSpan ? e.target.parentNode.firstChild : e.target;
                let ourWrapingForm = target.closest('form.mc4wp-form');
                let next = target.nextElementSibling;
                while (next.nodeType > 1) {
                    next = next.nextSibling;
                }

                let eCheckPathClasses = target.querySelector('path.rb-check').classList;
                if (eCheckPathClasses.contains('hide-svg')) {
                    let checkUIpatElements = ourWrapingForm.querySelectorAll('path.rb-check');
                    checkUIpatElements.forEach(svgCheckUIpath => {
                        svgCheckUIpath.classList.add('hide-svg');
                    });
                    eCheckPathClasses.remove('hide-svg');
                }
            } catch (error) {
                // Handle error
            }
        };

        // Check if the target matches specific selectors and call the corresponding functions
        if (matches.call(e.target, '.cb-check')) {
            selectCheckBoxBtnsWrap(e);
        }

        if (matches.call(e.target, '.wpcf7-list-item-label')) {
            selectCheckBoxBtnsWrap(e, true);
        }


        if (matches.call(e.target, 'span')) {
            selectRadioBtnsWrap(e, true);
        }

        if (matches.call(e.target, '.rb-selected') || matches.call(e.target, '.rb-unselected')) {
            selectRadioBtnsWrap(e);
        }

    }, false);

});
