 window.addEventListener('load', function () {
                setTimeout(function () {
                    // hide the address bar in iPhone Safari
                    window.scrollTo(0, 1);
                });
                // fast click library is used to remove 300ms delay
                // on click events for mobile touch based browsers
                if ('ontouchstart' in document.documentElement && window.FastClick) {
                    window.FastClick.attach(document.body);
                }
            }, false);
