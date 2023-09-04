/******/ (() => { // webpackBootstrap
/******/  "use strict";
var __webpack_exports__ = {};
/*!*****************************************************************!*\
  !*** ../demo5/src/js/pages/crud/ktdatatable/base/html-table.js ***!
  \*****************************************************************/

// Class definition

var KTDatatableHtmlTableDemo = function() { 
  // Private functions

  // demo initializer
  var demo = function() {

    var datatable = $('#kt_datatable').KTDatatable({
      pagination: false,
      search: false,
      layout: {
        class: 'datatable-bordered',
      },
    });
  };

  return {
    // Public functions
    init: function() {
      // init dmeo
      demo();
    },
  };
}();

jQuery(document).ready(function() {
  KTDatatableHtmlTableDemo.init();
});

/******/ })()
;
//# sourceMappingURL=html-table.js.map