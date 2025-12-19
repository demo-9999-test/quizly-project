/*
------------------------------------
    : Custom - Form Selects js :
------------------------------------
*/
"use strict";
$(document).ready(function() {
    $('.select2-single').select2();
    $('.select2-multi-select').select2({
        placeholder: 'Choose',
    });
});
