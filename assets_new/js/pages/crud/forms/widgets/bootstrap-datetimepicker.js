/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************************************************!*\
  !*** ../demo5/src/js/pages/crud/forms/widgets/bootstrap-datetimepicker.js ***!
  \****************************************************************************/
// Class definition

var KTBootstrapDatetimepicker = function () {
    // Private functions
    var baseDemos = function () {
        
        $('#kt_datetimepicker_5').datetimepicker({
            format: 'YYYY-MM-DD h:m',
        });
    }

    return {
        // Public functions
        init: function() {
            baseDemos();
        }
    };
}();

jQuery(document).ready(function() {
    KTBootstrapDatetimepicker.init();
});

/******/ })()
;
//# sourceMappingURL=bootstrap-datetimepicker.js.map