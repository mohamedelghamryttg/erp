/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!*******************************************************!*\
  !*** ../demo5/src/js/pages/custom/wizard/wizard-3.js ***!
  \*******************************************************/


// Class definition
var KTWizard3 = function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizardObj;
	var _validations = [];

	// Private functions
	var _initWizard = function () {
		// Initialize form wizard
		_wizardObj = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		// Validation before going to next page
		_wizardObj.on('change', function (wizard) {
			if (wizard.getStep() > wizard.getNewStep()) {
				return; // Skip if stepped back
			}
 
			// Validate form before change wizard step
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
					if (status == 'Valid') {
						wizard.goTo(wizard.getNewStep());

						KTUtil.scrollTop();
					} else {
						Swal.fire({
							text: "Sorry, looks like there are some errors detected, please try again.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn font-weight-bold btn-light"
							}
						}).then(function () {
							KTUtil.scrollTop();
						});
					}
				});
			}

			return false;  // Do not change wizard step, further action will be handled by he validator
		});

		// Changed event
		_wizardObj.on('changed', function (wizard) {
			KTUtil.scrollTop();
		});

		// Submit event
		_wizardObj.on('submit', function (wizard) {
                   
			// Validate form before submit
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
                                   
					if (status == 'Valid') {
						_formEl.submit(); // submit form
					} else {
						Swal.fire({
							text: "Sorry, looks like there are some errors detected, please try again.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn font-weight-bold btn-light"
							}
						}).then(function () {
							KTUtil.scrollTop();
						});
					}
				});
			}
		});
	}

	var _initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					name: {
						validators: {
							notEmpty: {
								message: 'Full Name is required'
							}
						}
					},
					birth_date: {
						validators: {
							notEmpty: {
								message: 'Date of Birth is required'
							}
						}
					},
					gender: {
						validators: {
							notEmpty: {
								message: 'Gender is required'
							}
						}
					},
					national_id: {
						validators: {
							notEmpty: {
								message: 'National ID/Passport ID is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));

		// Step 2
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					division: {
						validators: {
							notEmpty: {
								message: 'Division is required'
							}
						}
					},
					department: {
						validators: {
							notEmpty: {
								message: 'Function is required'
							}
						}
					},
					title: {
						validators: {
							notEmpty: {
								message: 'Position is required'
							}
						}
					},
					time_zone: {
						validators: {
							notEmpty: {
								message: 'Time Zone is required'
							}
						}
					},
					office_location: {
						validators: {
							notEmpty: {
								message: 'Office Location is required'
							}
						}					
					},
					hiring_date: {
						validators: {
							notEmpty: {
								message: 'Hiring Date is required'
							}
						}					
					},
					contract_type: {
						validators: {
							notEmpty: {
								message: 'Contract Type is required'
							}
						}					
					},
					brand: {
						validators: {
							notEmpty: {
								message: 'Brand is required'
							},
							digits: {
								message: 'The value added is not valid'
							}
						}					
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));

		// Step 3
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					status: {
						validators: {
							notEmpty: {
								message: 'Employee Status is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));

		// Step 4
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					phone: {
						validators: {
							notEmpty: {
								message: 'Phone Number is required'
							}
						}
					},
					email: {
						validators: {
							notEmpty: {
								message: 'Email is required'
							},
							emailAddress: {
								message: 'The value is not a valid email address'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Validate fields when clicking the Submit button
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));
		// Step 5
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					salary: {
						validators: {
							digits: {
								message: 'The value added is not valid'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Validate fields when clicking the Submit button
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard_v3');
			_formEl = KTUtil.getById('kt_form');

			_initWizard();
			_initValidation();
		}
	};
}();

jQuery(document).ready(function () {
	KTWizard3.init();
});

/******/ })()
;
//# sourceMappingURL=wizard-3.js.map