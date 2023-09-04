/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!*****************************************************************!*\
  !*** ../demo5/src/js/pages/crud/datatables/basic/scrollable.js ***!
  \*****************************************************************/

var KTDatatablesBasicScrollable = function() {

    var initTable2 = function() {
        var table = $('.table-separate');

        // begin second table
        table.DataTable({
            scrollY: '50vh',
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            bFilter:false,
            info:false,
        });
    };

    return {

        //main function to initiate the module
        init: function() {
            initTable2();
        },

    };

}();

jQuery(document).ready(function() {
    KTDatatablesBasicScrollable.init();
});

/******/ })()
;
//# sourceMappingURL=scrollable.js.map