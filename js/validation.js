/**
 * Form Validation Functions
 * Street Dog Fundraising and Support Management System
 */

/**
 * Validate an entire form before submission
 */
function validateForm(formId) {
    var form = document.getElementById(formId);
    if (!form) return true;

    var isValid = true;
    var groups = form.querySelectorAll('.form-group[data-validate]');

    groups.forEach(function (group) {
        if (!validateField(group)) {
            isValid = false;
        }
    });

    return isValid;
}

/**
 * Validate a single form group
 */
function validateField(group) {
    var input = group.querySelector('input, select, textarea');
    var errorEl = group.querySelector('.form-error');
    var rules = group.getAttribute('data-validate').split('|');
    var value = input ? input.value.trim() : '';

    // Clear previous state
    group.classList.remove('error', 'success');
    if (errorEl) errorEl.textContent = '';

    for (var i = 0; i < rules.length; i++) {
        var rule = rules[i];
        var error = checkRule(rule, value, input);
        if (error) {
            group.classList.add('error');
            if (errorEl) {
                errorEl.textContent = error;
                errorEl.style.display = 'block';
            }
            return false;
        }
    }

    group.classList.add('success');
    if (errorEl) errorEl.style.display = 'none';
    return true;
}

/**
 * Check a single validation rule
 */
function checkRule(rule, value, input) {
    var parts = rule.split(':');
    var ruleName = parts[0];
    var param = parts[1];

    switch (ruleName) {
        case 'required':
            if (!value) return 'This field is required.';
            break;

        case 'email':
            if (value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                return 'Please enter a valid email address.';
            }
            break;

        case 'min':
            if (value && value.length < parseInt(param)) {
                return 'Minimum ' + param + ' characters required.';
            }
            break;

        case 'max':
            if (value && value.length > parseInt(param)) {
                return 'Maximum ' + param + ' characters allowed.';
            }
            break;

        case 'number':
            if (value && isNaN(value)) {
                return 'Please enter a valid number.';
            }
            break;

        case 'min_value':
            if (value && parseFloat(value) < parseFloat(param)) {
                return 'Minimum value is ' + param + '.';
            }
            break;

        case 'phone':
            if (value && !/^[0-9]{10}$/.test(value)) {
                return 'Please enter a valid 10-digit phone number.';
            }
            break;

        case 'alpha':
            if (value && !/^[a-zA-Z\s]+$/.test(value)) {
                return 'Only alphabetic characters are allowed.';
            }
            break;

        case 'password':
            if (value) {
                if (!/[A-Z]/.test(value)) return 'Must contain at least one uppercase letter.';
                if (!/[a-z]/.test(value)) return 'Must contain at least one lowercase letter.';
                if (!/[0-9]/.test(value)) return 'Must contain at least one number.';
            }
            break;

        case 'match':
            var matchInput = document.getElementById(param);
            if (matchInput && value !== matchInput.value) {
                return 'Passwords do not match.';
            }
            break;

        case 'file_size':
            if (input && input.files && input.files[0]) {
                var maxSize = parseInt(param) * 1024 * 1024;
                if (input.files[0].size > maxSize) {
                    return 'File size exceeds ' + param + 'MB limit.';
                }
            }
            break;

        case 'file_type':
            if (input && input.files && input.files[0]) {
                var allowed = param.split(',');
                var ext = input.files[0].name.split('.').pop().toLowerCase();
                if (allowed.indexOf(ext) === -1) {
                    return 'Allowed file types: ' + param;
                }
            }
            break;
    }

    return null;
}

/**
 * Set up live validation on form fields
 */
function setupLiveValidation(formId) {
    var form = document.getElementById(formId);
    if (!form) return;

    form.querySelectorAll('.form-group[data-validate]').forEach(function (group) {
        var input = group.querySelector('input, select, textarea');
        if (input) {
            input.addEventListener('blur', function () {
                validateField(group);
            });
            input.addEventListener('input', function () {
                if (group.classList.contains('error')) {
                    validateField(group);
                }
            });
        }
    });

    form.addEventListener('submit', function (e) {
        if (!validateForm(formId)) {
            e.preventDefault();
            // Scroll to first error
            var firstError = form.querySelector('.form-group.error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
}
