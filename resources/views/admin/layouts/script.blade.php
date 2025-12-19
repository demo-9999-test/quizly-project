<?php
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = ['ar', 'he', 'ur', 'arc', 'az', 'dv', 'ku', 'fa']; //make a list of rtl languages
?>

@if (in_array($language, $rtl))
    <script>
        var rtl = true;
    </script>
@else
    <script>
        var rtl = false;
    </script>
@endif
<!-- jquery -->
<script src="{{ url('assets/js/jquery.min.js') }}"></script> <!-- jquery library js -->
<script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script> <!-- bootstrap js -->
{{-- admin js --}}
<script src="{{ url('admin_theme/assets/js/fontawesome-iconpicker.min.js') }}"></script>
{{-- datatable js --}}
<script src="{{ url('admin_theme/assets/js/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/datatable/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/datatable/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/datatable/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/datatable/jszip.min.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/datatable/pdfmake.min.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/datatable/vfs_fonts.js') }}"></script>
<script src="{{url('admin_theme/vendor/counter/jquery.counterup.js')}}"></script> <!-- counter js -->
<script src="{{url('admin_theme/vendor/counter/jquery.waypoints.js')}}"></script> <!-- counter js -->
<script src="{{ url('admin_theme/assets/js/datatable/buttons.flash.min.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/datatable/buttons.print.min.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/datatable/buttons.colVis.min.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('serviceworker.js')}}"></script>
<script src="{{ url('admin_theme/vendor/slick/slick.min.js') }}"></script>
<script src="{{ url('admin_theme/vendor/select2/select2.min.js') }}"></script>
<script src="{{ url('admin_theme/vendor/select2/custom-form-select.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/apexchart.js') }}"></script> <!-- apexchart js -->
<script src="{{ asset('admin_theme/assets/js/toastr.js') }}"></script>
<script src="{{asset('admin_theme/assets/js/jodit.min.js')}}"></script>
<script src="{{ asset('admin_theme/assets/js/simplemde.min.js') }}"></script>
<script src="{{ asset('admin_theme/vendor/sweetalert.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/admin.js') }}"></script>
{{-- Sortable script code start --}}
<script src="{{ url('admin_theme/assets/js/datatable/Sortable.min.js') }}"></script>
{{-- Sortable script code end --}}
@if (in_array($language, $rtl))
    .
    <script src="{{ url('admin_theme/assets/js/theme_rtl.js') }}"></script>
@else
    <script src="{{ url('admin_theme/assets/js/theme.js') }}"></script> <!-- custom js -->
@endif
{{-- ------------------------------ datatable js end-------------------- --}}


{{-- ---------------------Ck Editor script start---------- --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (!Request::is('admin/battle'))
            // Get all textareas with id="desc"
            var textareas = document.querySelectorAll('textarea[id="desc"]');

            // Initialize Jodit Editor for each textarea
            textareas.forEach(function (textarea) {
                const editor = new Jodit(textarea, {
                    height: 400,
                    // other config options if needed
                });

                // Optional: Add preview update if needed
                editor.events.on('change', function () {
                    const preview = document.getElementById('descPreview');
                    if (preview) {
                        preview.innerHTML = editor.value;
                    }
                });
            });
        @endif
    });
</script>

{{-- ---------------------Ck Editor script end---------- --}}

{{--
<script>
    if (localStorage.getItem('darkMode') === 'enabled') {
        enableDarkMode();
    }

    function toggleMode() {
        const modeIcon = document.getElementById('modeIcon');
        if (document.body.classList.contains('dark-mode')) {
            document.body.classList.remove('dark-mode');
            modeIcon.classList = 'flaticon-sun-1';
            localStorage.setItem('darkMode', 'disabled');
        } else {
            enableDarkMode();
            localStorage.setItem('darkMode', 'enabled');
        }
    }

    function enableDarkMode() {
        const modeIcon = document.getElementById('modeIcon');
        document.body.classList.add('dark-mode');
        modeIcon.classList = 'flaticon-sleep-mode';
    }
</script> --}}

<script>
    function updateCities() {
        var countrySelect = document.getElementById("country");
        var citySelect = document.getElementById("city");
        citySelect.innerHTML = "";
        var selectedCountry = countrySelect.value;

        function addCityOption(value, text) {
            var option = document.createElement("option");
            option.value = value;
            option.text = text;
            citySelect.add(option);
        }
    }
</script>
<script>
    function selectLanguage(flag) {
        document.getElementById("selectedFlag").src = "{{ asset('/image/language/') }}" + flag;
    }
</script>
<script>
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#' + input.name).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
    /* ========== Chart =========== */
    $(document).ready(function() {
        "use strict";

        const options = {
            series: [792770, 215758],
            labels: ["Online Sales", "Offline Sales"],
            colors: ['#2B193F', '#F99D30'],
            chart: {
                type: 'donut',
                height: 205,
            },
            legend: {
                position: 'bottom',
                fontFamily: 'inherit',
            },
            plotOptions: {
                pie: {
                    startAngle: -90,
                    endAngle: 90,
                    offsetY: 0,
                    donut: {
                        size: '70%',
                    }
                },
            },
            grid: {
                padding: {
                    bottom: -80
                }
            },
            stroke: {
                width: 5
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 280,
                        height: 250
                    },
                }
            }],
            dataLabels: {
                enabled: false,
            }
        };

        // Check if the element exists before rendering the chart
        if ($('#chart2').length) {
            new ApexCharts(document.getElementById('chart2'), options).render();
        } else {
            // console.log("Element with ID 'chart2' not found.");
        }
    });
</script>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "270px";
        localStorage.setItem('sidenavState', 'open');
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        localStorage.setItem('sidenavState', 'closed');
    }

    // Check the saved state on page load
    document.addEventListener('DOMContentLoaded', (event) => {
        const sidenavState = localStorage.getItem('sidenavState');
        if (sidenavState === 'open') {
            document.getElementById("mySidenav").style.width = "270px";
        } else {
            document.getElementById("mySidenav").style.width = "0";
        }
    });
</script>
<script>
    $(document).ready(function() {
        $.sidebarMenu = function(menu) {
            var animationSpeed = 300,
                subMenuSelector = '.vertical-submenu';
            $(menu).on('click', 'li a', function(e) {
                var $this = $(this);
                var checkElement = $this.next();
                if (checkElement.is(subMenuSelector) && checkElement.is(':visible')) {
                    checkElement.slideUp(animationSpeed, function() {
                        checkElement.removeClass('menu-open');
                    });
                    checkElement.parent("li").removeClass("active");
                } else if ((checkElement.is(subMenuSelector)) && (!checkElement.is(':visible'))) {
                    var parent = $this.parents('ul').first();
                    var ul = parent.find('ul:visible').slideUp(animationSpeed);
                    ul.removeClass('menu-open');
                    var parent_li = $this.parent("li");
                    checkElement.slideDown(animationSpeed, function() {
                        checkElement.addClass('menu-open');
                        parent.find('li.active').removeClass('active');
                        parent_li.addClass('active');
                    });
                }
                if (checkElement.is(subMenuSelector)) {
                    e.preventDefault();
                }
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        /* -- Menu js -- */
        $.sidebarMenu($('.vertical-menu'));
        $(function() {
            for (var a = window.location, abc = $(".vertical-menu a").filter(function() {
                    return this.href == a;
                }).addClass("active").parent().addClass("active");;) {
                if (!abc.is("li")) break;
                abc = abc.parent().addClass("in").parent().addClass("active");
            }
        });
    });
</script>
<script>
    function switchUserType(userType) {
        var emailInput = document.getElementById('email');
        var passwordInput = document.getElementById('password');

        if (userType === 'admin') {
            emailInput.value = 'admin@gmail.com';
            passwordInput.value = '123456';
        } else if (userType === 'user') {
            emailInput.value = 'user@gmail.com';
            passwordInput.value = '123456';
        }

        document.getElementById('user_type').value = userType;
    }
</script>

<!-- Ai Script js start -->
<script>
    // offcanvas menu
    $(".menu-tigger").on("click", function() {
        $(".offcanvas-menu,.offcanvas-overly").addClass("active");
        return false;
    });
    $(".menu-close,.offcanvas-overly").on("click", function() {
        $(".offcanvas-menu,.offcanvas-overly").removeClass("active");
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Restore last active tab
        const activeTab = localStorage.getItem("activeTab");
        if (activeTab) {
            const tabTrigger = document.querySelector('a[href="' + activeTab + '"]');
            if (tabTrigger) {
                const tab = new bootstrap.Tab(tabTrigger);
                tab.show();
            }
        }

        // Prevent scroll jump & save active tab
        document.querySelectorAll('a[data-bs-toggle="pill"]').forEach(link => {
            link.addEventListener("click", function (e) {
                e.preventDefault(); // prevent scroll
                const target = this.getAttribute("href");
                if (target) {
                    const tab = new bootstrap.Tab(this);
                    tab.show();
                    localStorage.setItem("activeTab", target);
                    history.replaceState(null, null, ' '); // clear #hash from URL
                }
            });
        });
    });
</script>
<script>
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#' + input.name).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
    $("#mytext").on('submit', function(e) {
        // alert('hello');
        console.log("data");
        e.preventDefault();
        $('.service_btn').text('Please Wait..');
        $('.service_btn').prop("disabled", true);
        var formData = new FormData();
        var a = formData.append('service', $("#service").val());
        var b = formData.append('language', $("#language").val());
        var c = formData.append('keyword', $("#keyword").val());
        var baseUrl = "{{ url('/') }}";
        var urlLike2 = baseUrl + '/admin/openai/text';
        $.ajax({
            type: "post",
            url: urlLike2,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data.status);
                if (data.status == false) {
                    $('.service_btn').text(data.msg);
                } else if (data) {
                    console.log(data.html);
                    z = data.code;
                    $(".generator_sidebar_table").html(data.html);

                } else {
                    $('.service_btn').text('Generate');
                    toastr.error('Your words limit has been exceeded.');
                }
            },
            error: function(data) {
                // toastr.error('Error' + data.responseText);
                console.log(data);
                $('.service_btnn').prop("disabled", false);
                $('.service_btn').text('Generate');
            }
        });
    });
    function generatorFormImage(ev) {
        'use strict';
        ev?.preventDefault();
        ev?.stopPropagation();
        $('.generate-btn-text').text('Please Wait...');
        $('.generate-btn-text').prop("disabled", true);
        document.getElementById("image-generator").disabled = true;
        document.getElementById("image-generator").innerHTML = "Please Wait...";
        document.querySelector('#app-loading-indicator')?.classList?.remove('opacity-0');
        var formData = new FormData();
        formData.append('image_number_of_images', $("#image_number_of_images").val());
        formData.append('description', $("#description").val());
        formData.append('size', $("#size").val());
        var baseUrl = "{{ url('/') }}";
        var urlLike = baseUrl + '/admin/openai/image';
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: urlLike,
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log('img', data);
                if (data.status == false) {
                    //  alert(data.msg);
                    $('.generate-btn-text').text(data.msg);
                    // $('.service_btn').prop("disabled", true);
                } else if (data.status == 'True') {
                    setTimeout(function() {
                        $(".image-output").html(data.response);
                        document.getElementById("image-generator").disabled = false;
                        document.getElementById("image-generator").innerHTML = "Regenerate";
                        document.querySelector('#app-loading-indicator')?.classList?.add(
                            'opacity-0');
                        $('.generate-btn-text').text('Generate');
                    }, 750);
                } else {
                    $('.generate-btn-text').text('Generate');
                    // toastr.error('Your image limit has been exceeded.');
                }
            },
        });
        return false;
    }
</script>
<script>
    function copyText() {
        var copyText = document.getElementById("myInput");
        var range = document.createRange();
        range.selectNode(copyText);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand("copy");
        window.getSelection().removeAllRanges();
        alert("Text copied to clipboard!");
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.flash-message .close').forEach(function(button) {
            button.addEventListener('click', function() {
                this.parentElement.style.display = 'none';
            });
        });
    });
</script>
<!-- Ai Script js end -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the search list element
        var searchList = document.getElementById("resultList1");
        // Hide scrollbar and set background to transparent while page is loading
        searchList.style.overflowY = "hidden";
        searchList.style.backgroundColor = "transparent";
        // Add event listener for when the page has fully loaded
        window.addEventListener("load", function() {
            // Show scrollbar and set background color to white after page load
            searchList.style.overflowY = "auto";
            searchList.style.backgroundColor = "transparent";
        });
    });
    // Add event listener for input changes in the search field
    var searchInput = document.getElementById("searchInput1");
    searchInput.addEventListener("input", function() {
        var searchList = document.getElementById("resultList1");
        searchList.style.height = "300px";
        searchList.style.overflowY = "auto";
        searchList.style.backgroundColor = "white";
        searchList.style.boxShadow = "0 1px 11px var(--bg_blue)";
        searchList.style.borderRadius = "0";
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the search list element
        var searchList = document.getElementById("resultList11");

        // Add event listener for input changes in the search field
        var searchInput = document.getElementById("searchInput11");
        searchInput.addEventListener("input", function() {
            if (searchInput.value.trim() !== "") {
                // Show scrollbar, set background color to black, and add box shadow when input is not empty
                searchList.style.height = "300px";
                searchList.style.overflowY = "auto";
                searchList.style.backgroundColor = "white";
                searchList.style.boxShadow = "0 1px 11px var(--bg_blue)";
                searchList.style.borderRadius = "0";
            }
            else {
                // Hide scrollbar and set height to 0 when input is empty
                searchList.style.height = "0";
                searchList.style.overflowY = "hidden";
                searchList.style.backgroundColor = "transparent";
                searchList.style.boxShadow = "0 1px 11px var(--bg_blue)";
                searchList.style.borderRadius = "0";
            }
        });
    });
</script>
<script>
    $(document).on('click', '.profile-edit-block i', function() {
        $(this).siblings('input[type="file"]').trigger('click');
    });

    $(document).on('change', 'input[type="file"]', function() {
        var val = $(this).val();
        $(this).siblings('span').text(val);
    });
</script>
<script>
    $(document).ready(function() {
        // Set switch state based on local storage
        $('#cookie_status').prop('checked', localStorage.getItem('cookie_status') === '1');
        $('#CookieMsg').toggle(localStorage.getItem('cookie_status') === '1');

        // Save switch state to local storage on change
        $('#cookie_status').on('change', function() {
            localStorage.setItem('cookie_status', $(this).prop('checked') ? '1' : '0');
            $('#CookieMsg').toggle($(this).prop('checked'));
        });
    });
</script>
<script>
    $(document).on('change', '#customSwitch', function() {
        $('#textInputBox').toggle(this.checked);
        $('#logoInputBox').toggle(!this.checked);
    }).trigger('change');
</script>
<script>
    function myFunction() {
        var copyText = document.getElementById("myInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
    }
</script>
<script>
    $("form").on("change", ".file-upload-field", function() {
        $(this).parent(".file-upload-wrapper").attr("data-text",
            $(this).val().replace(/.*(\/|\\)/, ''));
    });
</script>
<script>
    $(document).ready(function() {
        // Trigger change event on page load
        $(document).on("change", "#categorytype", function() {
            var selectedValue = $(this).val();
            // Check if the selected value is not the default (disabled) option
            if (selectedValue == 'sub') {
                // Show the div with id "category" and hide the one with id "subcategory"
                $("#category").show();
                $("#subcategory").hide();

                // You can also use the selectedValue variable if needed
                console.log("Selected Category Type: " + selectedValue);
            } else if (selectedValue == 'childsub') {
                // Hide the div with id "category" and show the one with id "subcategory"
                $("#category").hide();
                $("#subcategory").show();
            } else {
                $("#category").hide();
                $("#subcategory").hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Trigger change event on page load
        $(document).on("change", "#categorytype", function() {
            var selectedValue = $(this).val();
            // Check if the selected value is not the default (disabled) option
            if (selectedValue == 'sub') {
                // Show the div with id "category" and hide the one with id "subcategory"
                $("#category").show();
                $("#subcategory").hide();

                // You can also use the selectedValue variable if needed
                console.log("Selected Category Type: " + selectedValue);
            } else if (selectedValue == 'child') {
                // Hide the div with id "category" and show the one with id "subcategory"
                $("#category").hide();
                $("#subcategory").show();
            } else {
                $("#category").hide();
                $("#subcategory").hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        var main_id = '';
        var selected_ids = [];

        // Simulating Hummingbird's functionality
        $("#treeview input:checkbox").each(function() {
            var element = $(this).attr("id");
            if (selected_ids.includes(element)) {
                $(this).prop('checked', true);
                $(this).parents("ul").css("display", "block");
                $(this).parents("li").children('.las').removeClass("la-plus").addClass('la-minus');
            }
        });

        if (main_id) {
            $('#treeview input:radio[value=' + main_id + ']').prop('checked', true);
        }
    });
</script>
@if (isset($editcategory))
    <script>
        // Call the updateOptions function on page load
        updateOptions();

        // Add event listener to handle changes in the select element
        document.getElementById('categorytype').addEventListener('change', function() {
            updateOptions();
        });
        // Function to update options based on parent_id
        function updateOptions() {
            var categoryTypeSelect = document.getElementById('categorytype');
            var selectedOption = categoryTypeSelect.options[categoryTypeSelect.selectedIndex].value;

            if (selectedOption === '-1') {
                document.querySelector('option[value="sub"]').disabled = true;
                document.querySelector('option[value="child"]').disabled = true;
            } else if (selectedOption === 'sub') {
                document.querySelector('option[value="-1"]').disabled = true;
                document.querySelector('option[value="child"]').disabled = true;
            } else if (selectedOption === 'child') {
                document.querySelector('option[value="-1"]').disabled = true;
                document.querySelector('option[value="sub"]').disabled = true;
            } else {
                document.querySelector('option[value="-1"]').disabled = false;
                document.querySelector('option[value="sub"]').disabled = false;
                document.querySelector('option[value="child"]').disabled = false;
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            var selectedValue = $("#categorytype").val(); // Get the selected value on page load

            // Show or hide #category and #subcategory based on the selected value
            if (selectedValue == 'sub') {
                $("#category").show();
                $("#subcategory").hide();
            } else if (selectedValue == 'child') {
                $("#category").hide();
                $("#subcategory").show();
            } else {
                $("#category").hide();
                $("#subcategory").hide();
            }
        });
    </script>
@endif
<script>
    // JavaScript to set the value of subcategory ID in the input fields when the modal is shown
    $(document).ready(function() {
        $('.deletechildcategory').on('click', function(event) {
            var button = $(this); // Button that triggered the modal
            var subcategoryId = button.data(
                'subcategory-id'); // Extract subcategory ID from data-* attributes
            var modal = $(button.attr(
                'data-bs-target')); // Get the modal associated with the clicked button

            // Set the values when the modal is shown
            modal.find('#subcategory_id_input').val(subcategoryId); // Set value in input field
            modal.find('.subcategory_id_hidden').val(
                subcategoryId); // Set value in hidden input field for submission
        });
    });
</script>
<script>
    function toggleSubcategoryCheckbox(childcategoryId) {
        var childcategoryCheckbox = document.getElementById('checkbox' + childcategoryId);
        // Add your logic here to handle the checkbox state change as needed
        console.log('Checkbox toggled:', childcategoryCheckbox.checked);
    }
    function toggleSubcategoryCheckboxes(categoryId) {
        var parentCategoryCheckbox = document.getElementById('checkbox' + categoryId);
        var subcategoryCheckboxes = document.querySelectorAll('.subcategory-checkbox[data-parent="' + categoryId +
            '"]');
        var childcategoryCheckboxes = document.querySelectorAll('.childcategory-checkbox[data-parent="' + categoryId +
            '"]');

        if (parentCategoryCheckbox.checked) {
            subcategoryCheckboxes.forEach(function(checkbox) {
                checkbox.disabled = true;
                checkbox.checked = false;
            });
            childcategoryCheckboxes.forEach(function(checkbox) {
                checkbox.disabled = true;
                checkbox.checked = false;
            });
        } else {
            subcategoryCheckboxes.forEach(function(checkbox) {
                checkbox.disabled = false;
            });
            childcategoryCheckboxes.forEach(function(checkbox) {
                checkbox.disabled = false;
            });
        }
    }
</script>
<script>
    $(document).ready(function() {
        $('select').each(function() {
            var options = $(this).find('option');
            options.sort(function(a, b) {
                return $(a).text().localeCompare($(b).text());
            });
            $(this).empty().append(options);
        });
    });
</script>
<script defer>
    document.addEventListener("DOMContentLoaded", function() {
        var discountTypeSelect = document.getElementById('discount_type');
        var amountField = document.getElementById('amountField');
        var percentageField = document.getElementById('percentageField');

        // Check if discountTypeSelect exists before adding event listener
        if (discountTypeSelect) {
            discountTypeSelect.addEventListener('change', function() {
                if (discountTypeSelect.value === 'fix') {
                    amountField.style.display = 'block';
                    percentageField.style.display = 'none';
                } else if (discountTypeSelect.value === 'percentage') {
                    amountField.style.display = 'none';
                    percentageField.style.display = 'block';
                } else {
                    amountField.style.display = 'none';
                    percentageField.style.display = 'none';
                }
            });
        }
    });
</script>
<script>
    var baseUrl = "{{ url('/') }}";
</script>
<script src="{{ asset('admin_theme/assets/js/showkeys.js') }}"></script>
<script>
    $(document).on('change', '#status', function() {
        $('#plan-amount-section').toggle(!this.checked);
    }).trigger('change');
</script>
<script>
    $(document).on('change', '#lifetime', function() {
        $('#plan-duration-section').toggle(!this.checked);
    }).trigger('change');
</script>
<script>
    $(document).on('change', '#customSwitch', function() {
        $('#textInputBox').toggle(this.checked);
        $('#logoInputBox').toggle(!this.checked);
    }).trigger('change');
</script>
<script>
    // Function to toggle input boxes
    function toggleInputBoxes() {
        // Your logic to toggle input boxes goes here
    }
    document.getElementById('customSwitch')?.addEventListener('change', toggleInputBoxes);
    // Initial call to set the initial state based on checkbox value
    toggleInputBoxes();
</script>
<script>
    $('#status').on('change', function() {
        $('#plan-amount-section').toggle(!this.checked);
    });
</script>
<script>
    $("form").on("change", ".file-upload-field", function() {
        $(this).parent(".file-upload-wrapper").attr("data-text",
            $(this).val().replace(/.*(\/|\\)/, ''));
    });
</script>
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@php
    $settings = App\Models\Setting::first();
@endphp
@if (optional($settings)->right_click_status == 1)
    <script>
        (function($) {
            "use strict";
            $(function() {
                // Disable right-click context menu
                $(document).on("contextmenu", function(e) {
                    return false;
                });

                // Disable Ctrl+U
                $(document).on("keydown", function(e) {
                    if ((e.ctrlKey || e.metaKey) && (e.key === 'U' || e.key === 'u')) {
                        e.preventDefault();
                    }
                });
            });
        })(jQuery);
    </script>
@endif
@if ($settings->inspect_status == '1')
    <script>
        (function($) {
            "use strict";
            document.onkeydown = function(e) {
                if (event.keyCode == 123) {
                    return false;
                }
                if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
                    return false;
                }
                if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
                    return false;
                }
                if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
                    return false;
                }
                if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
                    return false;
                }
            }
        })(jQuery);
    </script>
@endif
<script>
    $(function() {
             $('.text-select2-multi-select').select2({
                 tags: true,
                 tokenSeparators: [',', ' ']
             });
         });;

 </script>
<script>
    function copyCode(elementId) {
        var codeElement = document.getElementById(elementId);
        var range = document.createRange();
        range.selectNode(codeElement);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand('copy');
        window.getSelection().removeAllRanges();
        alert('Code copied to clipboard!');
    }
</script>
@if(Request::is('admin/dashboard/*'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let chartData = @json($chartData);

        let options = {
            chart: {
                type: 'bar',
                height: 300,
                stacked: true,
            },
            series: chartData.monthly.series,
            xaxis: {
                categories: chartData.monthly.labels
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '20%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['#FF9F22']
            },
            toolbar: {
                show: false
            },
            colors: ['#FF9F22'],
        };

        let chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        // If you want to add interactivity to change time periods:
        document.querySelector("#interval").addEventListener("change", function() {
            let interval = this.value;
            chart.updateSeries(chartData[interval].series);
            chart.updateOptions({
                xaxis: {
                    categories: chartData[interval].labels
                }
            });
        });
    });
</script>
<script>
    var newUsersData = @json($newUsersData);

    function formatXAxisCategories(data, period) {
        let categories = [];
        let currentDate = new Date();
        let currentYear = currentDate.getFullYear();
        let currentMonth = currentDate.getMonth();

        if (period === 'yearly') {
            categories = Object.keys(data).sort();
        } else if (period === 'monthly') {
            for (let month = 0; month < 12; month++) {
                categories.push(new Date(currentYear, month, 1).toLocaleString('default', { month: 'short' }));
            }
        } else if (period === 'weekly') {
            let firstDayOfMonth = new Date(currentYear, currentMonth, 1);
            let lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0);

            for (let date = firstDayOfMonth; date <= lastDayOfMonth; date.setDate(date.getDate() + 7)) {
                categories.push(date.toLocaleString('default', { month: 'short', day: 'numeric' }));
            }
        }
        return categories;
    }

    function getDataForCategories(categories, data, period) {
        let currentYear = new Date().getFullYear();
        let currentMonth = new Date().getMonth() + 1; // JavaScript months are 0-indexed

        return categories.map(category => {
            if (period === 'yearly') {
                return data[category] || 0;
            } else if (period === 'monthly') {
                let monthIndex = new Date(Date.parse(category + " 1, " + currentYear)).getMonth() + 1;
                let key = `${currentYear}-${monthIndex.toString().padStart(2, '0')}`;
                return data[key] || 0;
            } else if (period === 'weekly') {
                let [month, day] = category.split(' ');
                let date = new Date(Date.parse(`${month} ${day}, ${currentYear}`));
                let weekNumber = Math.ceil((date.getDate() + date.getDay()) / 7);
                let key = `${currentYear}-${currentMonth.toString().padStart(2, '0')}-${weekNumber}`;
                return data[key] || 0;
            }
        });
    }

    var initialPeriod = 'monthly';
    var categories = formatXAxisCategories(newUsersData[initialPeriod], initialPeriod);

    var newUsersChart = {
        chart: {
            type: 'bar',
            height: 300,
            toolbar: {
                show: false
            }
        },
        series: [{
            name: 'New Users',
            data: getDataForCategories(categories, newUsersData[initialPeriod], initialPeriod)
        }],
        xaxis: {
            categories: categories,
            labels: {
                rotate: -45,
                rotateAlways: true,
                style: {
                    colors: '#9333ea'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#9333ea'  // Purple color for y-axis labels
                }
            }
        },
        colors: ['#a78bfa'], // Color for the bars
        plotOptions: {
            bar: {
                borderRadius: 0,
                columnWidth: '20%',
                horizontal: false,
            }
        },
        dataLabels: {
            enabled: false
        },
        theme: {
            mode: 'dark'  // Enable dark mode for better visibility on dark background
        },
        tooltip: {
            theme: 'dark',  // Dark theme for tooltips
            style: {
                fontSize: '12px',
                fontFamily: undefined
            },
            x: {
                show: false
            },
            y: {
                formatter: function (val) {
                    return val
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#newUsersChart"), newUsersChart);
    chart.render();

    // Function to update chart data
    function updateChartData(period) {
        var categories = formatXAxisCategories(newUsersData[period], period);
        var data = getDataForCategories(categories, newUsersData[period], period);
        chart.updateOptions({
            series: [{
                data: data
            }],
            xaxis: {
                categories: categories
            }
        });
    }
    document.getElementById('userIntervalSelect').addEventListener('change', function() {
        updateChartData(this.value);
    });
</script>
<script>
    var spark2 = {
        chart: {
            type: 'area',
            height: 300,
            sparkline: {
                enabled: false
            },
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight',
            width: 1.5
        },
        fill: {
            opacity: 1,
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [50, 100, 100, 100]
            }
        },
        series: [{
            name: "New Quizzes",
            data: @json($newQuizzesData['sparkline'])
        }],
        colors: ['#DC3545'],
        yaxis: {
            min: 0,
            forceNiceScale: true,
            labels: {
                formatter: function(val) {
                    return Math.floor(val);
                }
            }
        },
    }
new ApexCharts(document.querySelector("#spark2"), spark2).render();
</script>
<script>
    var quizTypeLineChart = {
        chart: {
            type: 'line',
            height: 240,
            toolbar: {
                show: false
            }
        },
        series: [{
            name: 'Objective',
            data: @json($quizTypeData['objective'])
        }, {
            name: 'Subjective',
            data: @json($quizTypeData['subjective'])
        }],
        colors: ['#293FCC', '#FFFF66'],
        xaxis: {
            categories: @json($quizTypeData['dates']),
            labels: {
                show: false
            }
        },
        yaxis: {
            labels: {
                show: true
            }
        },
        legend: {
            position: 'top'
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        markers: {
            size: 3
        },
        tooltip: {
            x: {
                format: 'dd MMM'
            }
        }
    }
    new ApexCharts(document.querySelector("#quizTypeLineChart"), quizTypeLineChart).render();
</script>
@endif

@if(Request::is('admin/quiz/*'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
    console.log("Script is running");
    const serviceCheckbox = document.querySelector('.service-quiz');
    const feesInput = document.getElementById('service-fees');

    function toggleFeesVisibility() {
        if (serviceCheckbox && feesInput) {
            feesInput.style.display = serviceCheckbox.checked ? 'block' : 'none';
        }
    }

    toggleFeesVisibility();
    if (serviceCheckbox) {
        serviceCheckbox.addEventListener('change', toggleFeesVisibility);
    }

    if (serviceCheckbox && serviceCheckbox.checked) {
        feesInput.style.display = 'block';
    }
});
</script>
@endif


@if(Request::is('admin/slider'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
    console.log("Script is running");
    const serviceCheckbox = document.querySelector('.service-quiz');
    const feesInput = document.getElementById('form-group-buttontext');

    function toggleFeesVisibility() {
        if (serviceCheckbox && feesInput) {
            feesInput.style.display = serviceCheckbox.checked ? 'block' : 'none';
        }
    }

    toggleFeesVisibility();
    if (serviceCheckbox) {
        serviceCheckbox.addEventListener('change', toggleFeesVisibility);
    }

    if (serviceCheckbox && serviceCheckbox.checked) {
        feesInput.style.display = 'block';
    }
});
</script>
@endif
@if(Request::is('admin/dashboard'))
    @if (in_array($language, $rtl))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const weeklyData = @json($userDataWeekly);
            const monthlyData = @json($userDataMonthly);
            const yearlyData = @json($userDataYearly);
            let chart;
            function updateChart(data, interval) {
                const dates = data.map(item => item.date).reverse();
                const counts = data.map(item => item.count).reverse();
                const options = {
                    chart: {
                        type: 'bar',
                        height: 450,
                        background: 'transparent',
                        foreColor: '#f0f0f0'
                    },
                    series: [{
                        name: 'New Users',
                        data: counts
                    }],
                    xaxis: {
                        categories: dates,
                        labels: {
                            style: {
                                colors: '#9333ea',
                                fontSize: '12px',
                            },
                            rotate: 45,
                            rotateAlways: true,
                            formatter: function(value) {
                                return value;
                            }
                        },
                        axisBorder: {
                            color: '#9333ea'
                        },
                        axisTicks: {
                            color: '#9333ea'
                        },
                        reversed: true
                    },
                    yaxis: {
                        title: {
                            text: 'Number of New Users',
                            style: {
                                color: '#9333ea'
                            }
                        },
                        labels: {
                            style: {
                                colors: '#9333ea',
                                fontSize: '12px'
                            },
                            align: 'left'
                        },
                        min: 0,
                        forceNiceScale: true,
                        axisBorder: {
                            show: true,
                            color: '#9333ea'
                        },
                        axisTicks: {
                            show: true,
                            color: '#9333ea'
                        },
                        opposite: true
                    },
                    grid: {
                        show: true,
                        borderColor: '#9333ea',
                        strokeDashArray: 3,
                        position: 'back',
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '70%',
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ['#9333ea'],
                    tooltip: {
                        theme: 'dark',
                        y: {
                            formatter: function (val) {
                                return val || '0';
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: '100%'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                if (chart) {
                    chart.updateOptions(options);
                } else {
                    chart = new ApexCharts(document.querySelector("#newUsersChart"), options);
                    chart.render();
                }
            }
            document.getElementById('userIntervalSelect').addEventListener('change', function() {
                switch(this.value) {
                    case 'weekly':
                        updateChart(weeklyData, 'weekly');
                        break;
                    case 'monthly':
                        updateChart(monthlyData, 'monthly');
                        break;
                    case 'yearly':
                        updateChart(yearlyData, 'yearly');
                        break;
                }
            });

            // Initial chart
            updateChart(monthlyData, 'monthly');
        });
        </script>
    @else
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const weeklyData = @json($userDataWeekly);
            const monthlyData = @json($userDataMonthly);
            const yearlyData = @json($userDataYearly);

            let chart;

            function updateChart(data, interval) {
                const dates = data.map(item => item.date);
                const counts = data.map(item => item.count);

                const options = {
                    chart: {
                        type: 'bar',
                        height: 450,
                        background: 'transparent',
                        foreColor: '#f0f0f0'
                    },
                    series: [{
                        name: 'New Users',
                        data: counts
                    }],
                    xaxis: {
                        categories: dates,
                        labels: {
                            style: {
                                colors: '#9333ea',
                                fontSize: '12px',
                            },
                            rotate: -45,
                            rotateAlways: true,
                            formatter: function(value) {
                                if (interval === 'weekly') {
                                    return value;
                                } else if (interval === 'monthly') {
                                    return value;
                                } else if (interval === 'yearly') {
                                    return value;
                                }
                                return value;
                            }
                        },
                        axisBorder: {
                            color: '#9333ea'
                        },
                        axisTicks: {
                            color: '#9333ea'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Number of New Users',
                            style: {
                                color: '#9333ea'
                            }
                        },
                        labels: {
                            style: {
                                colors: '#9333ea',
                                fontSize: '12px'
                            }
                        },
                        min: 0,
                        forceNiceScale: true,
                        axisBorder: {
                            show: true,
                            color: '#9333ea'
                        },
                        axisTicks: {
                            show: true,
                            color: '#9333ea'
                        }
                    },
                    grid: {
                        show: true,
                        borderColor: '#9333ea',
                        strokeDashArray: 3,
                        position: 'back',
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '70%',
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ['#9333ea'],
                    tooltip: {
                        theme: 'dark',
                        y: {
                            formatter: function (val) {
                                return val || '0';
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: '100%'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                if (chart) {
                    chart.updateOptions(options);
                } else {
                    chart = new ApexCharts(document.querySelector("#newUsersChart"), options);
                    chart.render();
                }
            }
            document.getElementById('userIntervalSelect').addEventListener('change', function() {
                switch(this.value) {
                    case 'weekly':
                        updateChart(weeklyData, 'weekly');
                        break;
                    case 'monthly':
                        updateChart(monthlyData, 'monthly');
                        break;
                    case 'yearly':
                        updateChart(yearlyData, 'yearly');
                        break;
                }
            });

            // Initial chart
            updateChart(monthlyData, 'monthly');
        });
        </script>
    @endif
    @if (in_array($language, $rtl))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const orderDataWeekly = @json($orderDataWeekly);
            const orderDataMonthly = @json($orderDataMonthly);
            const orderDataYearly = @json($orderDataYearly);

            let orderChart;

            function updateOrderChart(data, interval) {
                const dates = data.map(item => item.date);
                const counts = data.map(item => item.count);
                const isDarkMode = document.documentElement.classList.contains('dark-mode');
                const options = {
                    chart: {
                        type: 'bar',
                        height: 350,
                        background: 'transparent',
                        foreColor: isDarkMode ? '#ff89d4' : '#333',
                        defaultLocale: 'ar',
                        locales: [{
                            name: 'ar',
                            options: {
                                months: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
                                shortMonths: ['ينا', 'فبر', 'مار', 'أبر', 'مايو', 'يون', 'يول', 'أغس', 'سبت', 'أكت', 'نوف', 'ديس'],
                                days: ['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
                                shortDays: ['أحد', 'إثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة', 'سبت'],
                            }
                        }],
                        dir: 'rtl'
                    },
                    series: [{
                        name: 'طلبات جديدة',
                        data: counts
                    }],
                    xaxis: {
                        categories: dates,
                        labels: {
                            style: {
                                colors: isDarkMode ? '#ff89d4' : '#333',
                                fontSize: '12px',
                            },
                            rotate: 45,
                            rotateAlways: true,
                            formatter: function(value) {
                                return value;
                            }
                        },
                        axisBorder: {
                            color: isDarkMode ? '#ff89d4' : '#e0e0e0'
                        },
                        axisTicks: {
                            color: isDarkMode ? '#ff89d4' : '#e0e0e0'
                        },
                        position: 'top'
                    },
                    yaxis: {
                        title: {
                            text: 'عدد الطلبات الجديدة',
                            style: {
                                color: isDarkMode ? '#ff89d4' : '#333'
                            }
                        },
                        labels: {
                            style: {
                                colors: isDarkMode ? '#ff89d4' : '#333',
                                fontSize: '12px'
                            },
                            align: 'right'
                        },
                        min: 0,
                        forceNiceScale: true,
                        axisBorder: {
                            show: true,
                            color: isDarkMode ? '#ff03a2' : '#e0e0e0'
                        },
                        axisTicks: {
                            show: true,
                            color: isDarkMode ? '#ff89d4' : '#e0e0e0'
                        },
                        opposite: true
                    },
                    grid: {
                        show: true,
                        borderColor: isDarkMode ? '#ff89d4' : '#e0e0e0',
                        strokeDashArray: 3,
                        position: 'back',
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '70%',
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        offsetY: -20,
                        style: {
                            fontSize: '12px',
                            colors: [isDarkMode ? '#ff89d4' : '#333']
                        }
                    },
                    colors: ['#ff89d4'],
                    tooltip: {
                        theme: isDarkMode ? 'dark' : 'light',
                        y: {
                            formatter: function (val) {
                                return val || '0';
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: '100%'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                if (orderChart) {
                    orderChart.updateOptions(options);
                } else {
                    orderChart = new ApexCharts(document.querySelector("#newOrdersChart"), options);
                    orderChart.render();
                }
            }
            document.getElementById('orderIntervalSelect').addEventListener('change', function() {
                switch(this.value) {
                    case 'weekly':
                        updateOrderChart(orderDataWeekly, 'weekly');
                        break;
                    case 'monthly':
                        updateOrderChart(orderDataMonthly, 'monthly');
                        break;
                    case 'yearly':
                        updateOrderChart(orderDataYearly, 'yearly');
                        break;
                }
            });

            // Initial order chart
            updateOrderChart(orderDataMonthly, 'monthly');

            // Listen for theme changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === "attributes" && mutation.attributeName === "class") {
                        updateOrderChart(orderDataMonthly, 'monthly');
                    }
                });
            });
            observer.observe(document.body, {
                attributes: true
            });
        });
        </script>
    @else
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const orderDataWeekly = @json($orderDataWeekly);
            const orderDataMonthly = @json($orderDataMonthly);
            const orderDataYearly = @json($orderDataYearly);

            let orderChart;
            function updateOrderChart(data, interval) {
                const dates = data.map(item => item.date);
                const counts = data.map(item => item.count);
                const isDarkMode = document.documentElement.classList.contains('dark-mode');
                const options = {
                    chart: {
                        type: 'bar',
                        height: 350,
                        background: 'transparent',
                        foreColor: isDarkMode ? '#ff89d4' : '#333'
                    },
                    series: [{
                        name: 'New Orders',
                        data: counts
                    }],
                    xaxis: {
                        categories: dates,
                        labels: {
                            style: {
                                colors: isDarkMode ? '#ff89d4' : '#333',
                                fontSize: '12px',
                            },
                            rotate: -45,
                            rotateAlways: true,
                            formatter: function(value) {
                                return value;
                            }
                        },
                        axisBorder: {
                            color: isDarkMode ? '#ff89d4' : '#e0e0e0'
                        },
                        axisTicks: {
                            color: isDarkMode ? '#ff89d4' : '#e0e0e0'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Number of New Orders',
                            style: {
                                color: isDarkMode ? '#ff89d4' : '#333'
                            }
                        },
                        labels: {
                            style: {
                                colors: isDarkMode ? '#ff89d4' : '#333',
                                fontSize: '12px'
                            }
                        },
                        min: 0,
                        forceNiceScale: true,
                        axisBorder: {
                            show: true,
                            color: isDarkMode ? '#ff03a2' : '#e0e0e0'
                        },
                        axisTicks: {
                            show: true,
                            color: isDarkMode ? '#ff89d4' : '#e0e0e0'
                        }
                    },
                    grid: {
                        show: true,
                        borderColor: isDarkMode ? '#ff89d4' : '#e0e0e0',
                        strokeDashArray: 3,
                        position: 'back',
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '70%',
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ['#ff89d4'],
                    tooltip: {
                        theme: isDarkMode ? 'dark' : 'light',
                        y: {
                            formatter: function (val) {
                                return val || '0';
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: '100%'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };
                if (orderChart) {
                    orderChart.updateOptions(options);
                } else {
                    orderChart = new ApexCharts(document.querySelector("#newOrdersChart"), options);
                    orderChart.render();
                }
            }
            document.getElementById('orderIntervalSelect').addEventListener('change', function() {
                switch(this.value) {
                    case 'weekly':
                        updateOrderChart(orderDataWeekly, 'weekly');
                        break;
                    case 'monthly':
                        updateOrderChart(orderDataMonthly, 'monthly');
                        break;
                    case 'yearly':
                        updateOrderChart(orderDataYearly, 'yearly');
                        break;
                }
            });

            // Initial order chart
            updateOrderChart(orderDataMonthly, 'monthly');

            // Listen for theme changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === "attributes" && mutation.attributeName === "class") {
                        updateOrderChart(orderDataMonthly, 'monthly');
                    }
                });
            });
            observer.observe(document.body, {
                attributes: true
            });
        });
        </script>
    @endif

    @if (in_array($language, $rtl))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const quizDataWeekly = @json($quizDataWeekly);
            const quizDataMonthly = @json($quizDataMonthly);
            const quizDataYearly = @json($quizDataYearly);

            let quizChart;
            function updateQuizChart(data, interval) {
                const dates = data.map(item => item.date);
                const objectiveCounts = data.map(item => item.objective_count);
                const subjectiveCounts = data.map(item => item.subjective_count);
                const isDarkMode = document.documentElement.classList.contains('dark-mode');
                const options = {
                    chart: {
                        type: 'area',
                        height: 350,
                        background: 'transparent',
                        foreColor: isDarkMode ? '#f0f0f0' : '#333',
                        dir: 'rtl'
                    },
                    series: [
                        {
                            name: 'Objective Quizzes',
                            data: objectiveCounts
                        },
                        {
                            name: 'Subjective Quizzes',
                            data: subjectiveCounts
                        }
                    ],
                    xaxis: {
                        categories: dates,
                        labels: {
                            rotate: 45,
                            rotateAlways: true,
                            style: {
                                colors: isDarkMode ? '#f0f0f0' : '#333',
                                fontSize: '12px',
                            }
                        },
                        axisBorder: {
                            color: isDarkMode ? '#555' : '#e0e0e0'
                        },
                        axisTicks: {
                            color: isDarkMode ? '#555' : '#e0e0e0'
                        },
                        reversed: true
                    },
                    yaxis: {
                        title: {
                            text: 'Number of Quizzes',
                            style: {
                                color: isDarkMode ? '#f0f0f0' : '#333'
                            },
                            opposite: true
                        },
                        labels: {
                            style: {
                                colors: isDarkMode ? '#f0f0f0' : '#333',
                                fontSize: '12px'
                            },
                            align: 'left'
                        },
                        min: 0,
                        forceNiceScale: true,
                        opposite: true
                    },
                    grid: {
                        borderColor: isDarkMode ? '#555' : '#e0e0e0',
                        strokeDashArray: 4,
                    },
                    colors: ['#4CAF50', '#2196F3'],
                    tooltip: {
                        theme: isDarkMode ? 'dark' : 'light',
                        y: {
                            formatter: function(val) {
                                return val || '0';
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'left',
                        labels: {
                            colors: isDarkMode ? '#f0f0f0' : '#333'
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };
                if (quizChart) {
                    quizChart.updateOptions(options);
                } else {
                    quizChart = new ApexCharts(document.querySelector("#quizChart"), options);
                    quizChart.render();
                }
            }

            document.getElementById('quizIntervalSelect').addEventListener('change', function() {
                switch(this.value) {
                    case 'weekly':
                        updateQuizChart(quizDataWeekly, 'weekly');
                        break;
                    case 'monthly':
                        updateQuizChart(quizDataMonthly, 'monthly');
                        break;
                    case 'yearly':
                        updateQuizChart(quizDataYearly, 'yearly');
                        break;
                }
            });

            // Initial quiz chart
            updateQuizChart(quizDataMonthly, 'monthly');

            // Listen for theme changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === "attributes" && mutation.attributeName === "class") {
                        updateQuizChart(quizDataMonthly, 'monthly');
                    }
                });
            });
            observer.observe(document.documentElement, {
                attributes: true
            });
        });
        </script>
    @else
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const quizDataWeekly = @json($quizDataWeekly);
        const quizDataMonthly = @json($quizDataMonthly);
        const quizDataYearly = @json($quizDataYearly);

        let quizChart;
        function updateQuizChart(data, interval) {
            const dates = data.map(item => item.date);
            const objectiveCounts = data.map(item => item.objective_count);
            const subjectiveCounts = data.map(item => item.subjective_count);
            const isDarkMode = document.documentElement.classList.contains('dark-mode');
            const options = {
                chart: {
                    type: 'area',
                    height: 350,
                    background: 'transparent',
                    foreColor: isDarkMode ? '#f0f0f0' : '#333'
                },
                series: [
                    {
                        name: 'Objective Quizzes',
                        data: objectiveCounts
                    },
                    {
                        name: 'Subjective Quizzes',
                        data: subjectiveCounts
                    }
                ],
                xaxis: {
                    categories: dates,
                    labels: {
                        rotate: -45,
                        rotateAlways: true,
                        style: {
                            colors: isDarkMode ? '#f0f0f0' : '#333',
                            fontSize: '12px',
                        }
                    },
                    axisBorder: {
                        color: isDarkMode ? '#555' : '#e0e0e0'
                    },
                    axisTicks: {
                        color: isDarkMode ? '#555' : '#e0e0e0'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Number of Quizzes',
                        style: {
                            color: isDarkMode ? '#f0f0f0' : '#333'
                        }
                    },
                    labels: {
                        style: {
                            colors: isDarkMode ? '#f0f0f0' : '#333',
                            fontSize: '12px'
                        }
                    },
                    min: 0,
                    forceNiceScale: true
                },
                grid: {
                    borderColor: isDarkMode ? '#555' : '#e0e0e0',
                    strokeDashArray: 4,
                },
                colors: ['#4CAF50', '#2196F3'],
                tooltip: {
                    theme: isDarkMode ? 'dark' : 'light',
                    y: {
                        formatter: function(val) {
                            return val || '0';
                        }
                    }
                },

                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                    labels: {
                        colors: isDarkMode ? '#f0f0f0' : '#333'
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            if (quizChart) {
                quizChart.updateOptions(options);
            } else {
                quizChart = new ApexCharts(document.querySelector("#quizChart"), options);
                quizChart.render();
            }
        }
        document.getElementById('quizIntervalSelect').addEventListener('change', function() {
            switch(this.value) {
                case 'weekly':
                    updateQuizChart(quizDataWeekly, 'weekly');
                    break;
                case 'monthly':
                    updateQuizChart(quizDataMonthly, 'monthly');
                    break;
                case 'yearly':
                    updateQuizChart(quizDataYearly, 'yearly');
                    break;
            }
        });

        // Initial quiz chart
        updateQuizChart(quizDataMonthly, 'monthly');

        // Listen for theme changes
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === "attributes" && mutation.attributeName === "class") {
                    updateQuizChart(quizDataMonthly, 'monthly');
                }
            });
        });

        observer.observe(document.documentElement, {
            attributes: true
        });
    });
    </script>
    @endif
@endif

@if(Request::is('admin/marketing-dashboard'))
    @if (in_array($language, $rtl))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
            var revenueData = @json($revenueData);
            var chart;

            function initChart(data) {
                var options = {
                    series: [{
                        name: 'Revenue',
                        data: Object.values(data).reverse() // Reverse the data array
                    }],
                    chart: {
                        height: 400,
                        type: 'line',
                    },
                    colors: ['#802fca'],
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) {
                            return "₹" + val.toFixed(2);
                        },
                        offsetY: -20,
                        style: {
                            fontSize: '12px',
                            colors: ["#802fca"]
                        }
                    },
                    xaxis: {
                        categories: Object.keys(data).reverse(), // Reverse the categories array
                        position: 'bottom',
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                        crosshairs: {
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    colorFrom: '#802fca',
                                    colorTo: '#802fca',
                                    stops: [0, 100],
                                    opacityFrom: 0.4,
                                    opacityTo: 1,
                                }
                            }
                        },
                        labels: {
                            style: {
                                colors: '#802fca',
                                fontSize: '12px'
                            }
                        },
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#802fca',
                                fontSize: '12px'
                            },
                            align: 'left', // Align labels to the left
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                        opposite: true, // Move y-axis to the right side
                    },
                    title: {
                        text: 'Monthly Revenue - ' + document.getElementById('yearSelector').value,
                        align: 'center',
                        style: { color: '#802fca' }
                    },
                    tooltip: {
                        x: {
                            formatter: function(val) {
                                return Object.keys(data)[Object.keys(data).length - 1 - val];
                            }
                        }
                    }
                };

                if (chart) {
                    chart.updateOptions(options);
                } else {
                    chart = new ApexCharts(document.querySelector("#revenueChart"), options);
                    chart.render();
                }
            }
            initChart(revenueData);
            document.getElementById('yearSelector').addEventListener('change', function() {
                var selectedYear = this.value;
                document.getElementById('selectedYearDisplay').textContent = selectedYear;

                fetch('/admin/get-yearly-revenue-data?year=' + selectedYear)
                    .then(response => response.json())
                    .then(data => {
                        initChart(data);
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
        </script>
    @else
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var revenueData = @json($revenueData);
                var chart;

                function initChart(data) {
                    var options = {
                        series: [{
                            name: 'Revenue',
                            data: Object.values(data)
                        }],
                        chart: {
                            height: 400,
                            type: 'line',
                        },
                        colors: ['#802fca'],
                        dataLabels: {
                            enabled: true,
                            formatter: function (val) {
                                return "₹" + val.toFixed(2);
                            },
                            offsetY: -20,
                            style: {
                                fontSize: '12px',
                                colors: ["#802fca"]
                            }
                        },
                        xaxis: {
                            categories: Object.keys(data),
                            position: 'bottom',
                            axisBorder: { show: false },
                            axisTicks: { show: false },
                            crosshairs: {
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        colorFrom: '#802fca',
                                        colorTo: '#802fca',
                                        stops: [0, 100],
                                        opacityFrom: 0.4,
                                        opacityTo: 1,
                                    }
                                }
                            },
                            labels: {
                            style: {
                                colors: '#802fca',
                                fontSize: '12px'
                            }
                        },
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: '#802fca',
                                    fontSize: '12px'
                                }
                            },
                            axisBorder: { show: false },
                            axisTicks: { show: false },
                        },
                        title: {
                            text: 'Monthly Revenue - ' + document.getElementById('yearSelector').value,
                            align: 'center',
                            style: { color: '#802fca' }
                        }
                    };

                    if (chart) {
                        chart.updateOptions(options);
                    } else {
                        chart = new ApexCharts(document.querySelector("#revenueChart"), options);
                        chart.render();
                    }
                }
                initChart(revenueData);
                document.getElementById('yearSelector').addEventListener('change', function() {
                    var selectedYear = this.value;
                    document.getElementById('selectedYearDisplay').textContent = selectedYear;

                    fetch('/admin/get-yearly-revenue-data?year=' + selectedYear)
                        .then(response => response.json())
                        .then(data => {
                            initChart(data);
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        </script>
    @endif
    @if (in_array($language, $rtl))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
            var packageSalesData = @json($packageSales);
            var packageSalesChart;

            function initPackageSalesChart(data) {
                var options = {
                    series: [{
                        name: 'Sales',
                        data: data.map(item => item.sales).reverse()
                    }],
                    chart: {
                        type: 'bar',
                        height: 410,
                        dir: 'rtl'
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) {
                            return Math.floor(val);
                        },
                        textAnchor: 'start'
                    },
                    xaxis: {
                        categories: data.map(item => item.name).reverse(),
                        title: {
                            text: 'Packages'
                        },
                        labels: {
                            style: {
                                colors: '#5aaea2',
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Number of Sales'
                        },
                        labels: {
                            formatter: function (val) {
                                return Math.floor(val);
                            },
                            style: {
                                colors: '#5aaea2',
                                fontSize: '12px'
                            }
                        }
                    },
                    colors: ['#5aaea2'],
                    title: {
                        text: 'Package Sales for ' + document.getElementById('packageSalesYearSelector').value,
                        align: 'center',
                        style: {
                            color: '#5aaea2'
                        }
                    }
                };
                if (packageSalesChart) {
                    packageSalesChart.updateOptions(options);
                } else {
                    packageSalesChart = new ApexCharts(document.querySelector("#packageSalesChart"), options);
                    packageSalesChart.render();
                }
            }
            initPackageSalesChart(packageSalesData);
            document.getElementById('packageSalesYearSelector').addEventListener('change', function() {
                var selectedYear = this.value;
                document.getElementById('packageSalesYearDisplay').textContent = selectedYear;

                fetch('/admin/get-yearly-package-sales-data?year=' + selectedYear)
                    .then(response => response.json())
                    .then(data => {
                        initPackageSalesChart(data);
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
        </script>
    @else
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var packageSalesData = @json($packageSales);
                var packageSalesChart;

                function initPackageSalesChart(data) {
                    var options = {
                        series: [{
                            name: 'Sales',
                            data: data.map(item => item.sales)
                        }],
                        chart: {
                            type: 'bar',
                            height: 410
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function (val) {
                                return Math.floor(val);
                            }
                        },
                        xaxis: {
                            categories: data.map(item => item.name),
                            title: {
                                text: 'Packages'
                            },
                            labels: {
                                style: {
                                    colors: '#5aaea2',
                                    fontSize: '12px'
                                }
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Number of Sales'
                            },
                            labels: {
                                formatter: function (val) {
                                    return Math.floor(val);
                                },
                                style: {
                                    colors: '#5aaea2',
                                    fontSize: '12px'
                                }
                            }
                        },
                        colors: ['#5aaea2'],
                        title: {
                            text: 'Package Sales for ' + document.getElementById('packageSalesYearSelector').value,
                            align: 'center',
                            style: {
                                color: '#5aaea2'
                            }
                        }
                    };

                    if (packageSalesChart) {
                        packageSalesChart.updateOptions(options);
                    } else {
                        packageSalesChart = new ApexCharts(document.querySelector("#packageSalesChart"), options);
                        packageSalesChart.render();
                    }
                }
                initPackageSalesChart(packageSalesData);
                document.getElementById('packageSalesYearSelector').addEventListener('change', function() {
                    var selectedYear = this.value;
                    document.getElementById('packageSalesYearDisplay').textContent = selectedYear;

                    fetch('/admin/get-yearly-package-sales-data?year=' + selectedYear)
                        .then(response => response.json())
                        .then(data => {
                            initPackageSalesChart(data);
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        </script>
    @endif
@endif

@if(Request::is('admin/objective/create/*'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textArea = document.getElementsByClassName('fill_question')[0];
        const addBtn = document.getElementById('addBlankLineBtn');
        const removeBtn = document.getElementById('removeBlankLineBtn');
        const maxBlankLines = 2;
        const blankLine = '__________';
        const blankLineRegex = new RegExp(`${blankLine}(\\r\\n|\\n)?`, 'g');  // Flexible regex for removal
        addBtn.addEventListener('click', function (event) {
            event.preventDefault();

            // Count existing blank lines
            const existingBlanks = (textArea.value.match(blankLineRegex) || []).length;
            if (existingBlanks < maxBlankLines) {
                const cursorPosition = textArea.selectionStart;
                const textBeforeCursor = textArea.value.substring(0, cursorPosition);
                const textAfterCursor = textArea.value.substring(cursorPosition);

                const newText = textBeforeCursor + blankLine + '\n' + textAfterCursor;
                textArea.value = newText;

                // Place cursor after inserted blank line
                textArea.selectionStart = textArea.selectionEnd = cursorPosition + blankLine.length + 1;
                textArea.focus();
            } else {
                alert(`You can only add blank lines up to ${maxBlankLines}.`);
            }
        });
        removeBtn.addEventListener('click', function (event) {
            event.preventDefault();
            // Remove all blank lines (with or without \n)
            textArea.value = textArea.value.replace(blankLineRegex, '');
        });
        textArea.addEventListener('keydown', function (event) {
            if (event.key === 'Backspace') {
                const cursorPosition = textArea.selectionStart;
                const textBeforeCursor = textArea.value.substring(0, cursorPosition);
                const lastIndex = textBeforeCursor.lastIndexOf(blankLine);

                if (lastIndex !== -1 && cursorPosition <= lastIndex + blankLine.length) {
                    event.preventDefault(); // prevent removing blank line directly
                }
            }
        });
    });
</script>

<!-- for adding removing input in match the following -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let optionIndex = 1;

        document.getElementById('add-options').addEventListener('click', function() {
            const optionsContainer = document.getElementById('options-container');
            const correctOptionsContainer = document.getElementById('correct-options-container');

            let optionA = document.createElement('div');
            optionA.classList.add('col-lg-6');
            optionA.innerHTML = `<div class="form-group">
                                    <label class="form-label">${String.fromCharCode(64 + optionIndex + 1)}<span class="required">*</span></label>
                                    <input class="form-control" type="text" name="option_a[]" placeholder="{{ __('Please enter your text') }}" aria-label="option_a">
                                    <div class="form-control-icon"><i class="flaticon-process"></i></div>
                                 </div>`;

            let optionB = document.createElement('div');
            optionB.classList.add('col-lg-6');
            optionB.innerHTML = `<div class="form-group">
                                    <label class="form-label">${optionIndex + 1}<span class="required">*</span></label>
                                    <input class="form-control" type="text" name="option_b[]" placeholder="{{ __('Please enter your text') }}" aria-label="option_b">
                                    <div class="form-control-icon"><i class="flaticon-process"></i></div>
                                 </div>`;

            optionsContainer.appendChild(optionA);
            optionsContainer.appendChild(optionB);

            let correctOptionLeft = document.createElement('div');
            correctOptionLeft.classList.add('col-lg-6');
            correctOptionLeft.innerHTML = `<div class="form-group">
                                            <label for="correct_answer_left" class="form-label">{{ __('Correct Sequence') }}</label>
                                            <input class="form-control" type="text" name="correct_answer_left[]" value="${String.fromCharCode(64 + optionIndex + 1)}" disabled>
                                            <div class="form-control-icon"><i class="flaticon-procedure"></i></div>
                                         </div>`;

            let correctOptionRight = document.createElement('div');
            correctOptionRight.classList.add('col-lg-6');
            correctOptionRight.innerHTML = `<div class="form-group">
                                             <label for="correct_answer_right" class="form-label">{{ __('Enter your sequence') }}</label>
                                             <input class="form-control" type="number" name="correct_answer[]" placeholder="{{ __('Enter your sequence') }}" aria-label="correct_answer_right">
                                             <div class="form-control-icon"><i class="flaticon-procedure"></i></div>
                                           </div>`;

            correctOptionsContainer.appendChild(correctOptionLeft);
            correctOptionsContainer.appendChild(correctOptionRight);

            optionIndex++;
        });

        document.getElementById('remove-options').addEventListener('click', function() {
            const optionsContainer = document.getElementById('options-container');
            const correctOptionsContainer = document.getElementById('correct-options-container');
            const optionGroups = optionsContainer.querySelectorAll('.col-lg-6');
            const correctOptionGroups = correctOptionsContainer.querySelectorAll('.col-lg-6');

            if (optionGroups.length > 2) { // Keep at least one pair
                optionsContainer.removeChild(optionGroups[optionGroups.length - 1]);
                optionsContainer.removeChild(optionGroups[optionGroups.length - 2]);
                correctOptionsContainer.removeChild(correctOptionGroups[correctOptionGroups.length - 1]);
                correctOptionsContainer.removeChild(correctOptionGroups[correctOptionGroups.length - 2]);
                optionIndex--;
            }
        });
    });
</script>
@endif

@if(Request::is('admin/objective/edit/*'))
<script>
    let blankLineCount = 0;
    const maxBlankLines = 2;
    const blankLine = '__________';

    document.getElementById('addBlankLineBtn').addEventListener('click', function(event) {
        event.preventDefault();
        if (blankLineCount < maxBlankLines) {
            var inputField = document.getElementsByClassName('fill_question')[0];
            var cursorPosition = inputField.selectionStart;
            var textBeforeCursor = inputField.value.substring(0, cursorPosition);
            var textAfterCursor = inputField.value.substring(cursorPosition);

            inputField.value = textBeforeCursor + blankLine + textAfterCursor;

            inputField.selectionStart = cursorPosition + blankLine.length;
            inputField.selectionEnd = cursorPosition + blankLine.length;
            inputField.focus();

            blankLineCount++;
        } else {
            alert('You can only add blank lines twice.');
        }
    });
    document.getElementById('removeBlankLineBtn').addEventListener('click', function(event) {
        event.preventDefault();
        var inputField = document.getElementsByClassName('fill_question')[0];
        inputField.value = inputField.value.replace(new RegExp(blankLine, 'g'), '');
        blankLineCount = 0;
    });
    document.getElementsByClassName('fill_question')[0].addEventListener('keydown', function(event) {
        if (event.key === 'Backspace') {
            var inputField = document.getElementsByClassName('fill_question')[0];
            var cursorPosition = inputField.selectionStart;
            var textBeforeCursor = inputField.value.substring(0, cursorPosition);
            var lastIndex = textBeforeCursor.lastIndexOf(blankLine);

            if (lastIndex !== -1 && cursorPosition <= lastIndex + blankLine.length) {
                event.preventDefault();
            }
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let optionIndex = {{ count($obj->option_a) }};

        document.getElementById('add-options').addEventListener('click', function() {
            const optionsContainer = document.getElementById('options-container');
            const correctOptionsContainer = document.getElementById('correct-options-container');

            let optionA = document.createElement('div');
            optionA.classList.add('col-lg-6');
            optionA.innerHTML = `<div class="form-group">
                                    <label class="form-label">${String.fromCharCode(64 + optionIndex + 1)}<span class="required">*</span></label>
                                    <input class="form-control" type="text" name="option_a[]" placeholder="{{ __('Please enter your text') }}" aria-label="option_a">
                                    <div class="form-control-icon"><i class="flaticon-process"></i></div>
                                 </div>`;

            let optionB = document.createElement('div');
            optionB.classList.add('col-lg-6');
            optionB.innerHTML = `<div class="form-group">
                                    <label class="form-label">${optionIndex + 1}<span class="required">*</span></label>
                                    <input class="form-control" type="text" name="option_b[]" placeholder="{{ __('Please enter your text') }}" aria-label="option_b">
                                    <div class="form-control-icon"><i class="flaticon-process"></i></div>
                                 </div>`;

            optionsContainer.appendChild(optionA);
            optionsContainer.appendChild(optionB);

            let correctOptionLeft = document.createElement('div');
            correctOptionLeft.classList.add('col-lg-6');
            correctOptionLeft.innerHTML = `<div class="form-group">
                                            <label for="correct_answer_left" class="form-label">{{ __('Correct Sequence') }}</label>
                                            <input class="form-control" type="text" name="correct_answer_left[]" value="${String.fromCharCode(64 + optionIndex + 1)}" disabled>
                                            <div class="form-control-icon"><i class="flaticon-procedure"></i></div>
                                         </div>`;

            let correctOptionRight = document.createElement('div');
            correctOptionRight.classList.add('col-lg-6');
            correctOptionRight.innerHTML = `<div class="form-group">
                                             <label for="correct_answer_right" class="form-label">{{ __('Enter your sequence') }}</label>
                                             <input class="form-control" type="number" name="correct_answer[]" placeholder="{{ __('Enter your sequence') }}" aria-label="correct_answer_right">
                                             <div class="form-control-icon"><i class="flaticon-procedure"></i></div>
                                           </div>`;

            correctOptionsContainer.appendChild(correctOptionLeft);
            correctOptionsContainer.appendChild(correctOptionRight);

            optionIndex++;
        });

        document.getElementById('remove-options').addEventListener('click', function() {
            const optionsContainer = document.getElementById('options-container');
            const correctOptionsContainer = document.getElementById('correct-options-container');
            const optionGroups = optionsContainer.querySelectorAll('.col-lg-6');
            const correctOptionGroups = correctOptionsContainer.querySelectorAll('.col-lg-6');

            if (optionGroups.length > 2) { // Keep at least one pair
                optionsContainer.removeChild(optionGroups[optionGroups.length - 1]);
                optionsContainer.removeChild(optionGroups[optionGroups.length - 2]);

                correctOptionsContainer.removeChild(correctOptionGroups[correctOptionGroups.length - 1]);
                correctOptionsContainer.removeChild(correctOptionGroups[correctOptionGroups.length - 2]);
                optionIndex--;
            }
        });
    });
</script>
@endif
