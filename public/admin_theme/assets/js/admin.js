(function($) {
"use Strict";
// <!--------------------------------------- Select All Script start---------------------------- -->
$("#checkboxAll").on("click", function () {
    $("input.check").not(this).prop("checked", this.checked);
});
// <!--------------------------------------- Select All end start---------------------------- -->

// {{-- -------------------------Create Slug name  start--------------------------- --}}
function createSlug(input) {
    return input
        .toLowerCase()
        .replace(/ /g, "-")
        .replace(/[^a-z0-9-]/g, "");
}
$("#title").on("input", function () {
    const headingValue = $(this).val();
    const slugValue = createSlug(headingValue);
    $("#slug").val(slugValue);
});
// {{-- -------------------------Create Slug name  end--------------------------- --}}

// {{------------------ datatables scripts start --------------}}

$(function () {
    var dataTable = $("#example").DataTable({
        buttons: ["copy", "csv", "excel", "pdf", "print"],
    });

    // Add custom container for buttons and entries information
    $('<div class="custom-container"/>').appendTo(
        ".dataTables_wrapper .row .datatable-button"
    );

    // Append buttons and entries information to the custom container
    dataTable.buttons().container().appendTo(".custom-container");
});




// {{------------------ datatables scripts end --------------}}

// ---------------packages status update code start-----------------------
$(function () {
    $(".status2").on("change", function () {
        //  alert('hello');
        var status = $(this).prop("checked") == true ? 1 : 0;
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "packages/update-status",
            data: {
                status: status,
                id: id,
            },
            success: function (data) {
                console.log(id);
                // alert('Hello');
            },
        });
    });
});
// ---------------packages status update code end---------------------------

//----------------------------------- social media url option and input box show in code start-----------------------------

$(".social-profile-field").on("click", "button.addnew", function () {
    var n = $(this).closest("tr");
    addNewRow(n);

    function addNewRow(n) {
        // e.preventDefault();

        var $tr = n;
        var allTrs = $tr.closest("table").find("tr");
        var lastTr = allTrs[allTrs.length - 1];
        var $clone = $(lastTr).clone();
        $clone.find("td").each(function () {
            var el = $(this).find(":first-child");
            var id = el.attr("id") || null;
            if (id) {
                var i = id.substr(id.length - 1);
                var prefix = id.substr(0, id.length - 1);
                el.attr("id", prefix + (+i + 1));
                el.attr("name", prefix + (+i + 1));
            }
        });

        $clone.find("input").val("");

        $tr.closest("table").append($clone);

        $("input.course_name").last().focus();

        enableAutoComplete($("input.course_name:last"));
    }
});

$(".social-profile-field").on("click", ".removeBtn", function () {
    var d = $(this);
    removeRow(d);
});

function removeRow(d) {
    var rowCount = $(".social-profile-field tr").length;
    if (rowCount !== 1) {
        d.closest("tr").remove();
    } else {
        console.log("Atleast one sell is required");
    }
}
//----------------------------------------- social media url option and input box show in code end-----------------------------

// ----------script space in - show code start--------------------
const inputElements = document.getElementsByClassName("custom-input");

for (let i = 0; i < inputElements.length; i++) {
    inputElements[i].addEventListener("input", function () {
        const inputValue = this.value;
        const slugValue = inputValue.replace(/\s+/g, "-");
        this.value = slugValue;
    });
}
// ----------script space in - show code end--------------------

// --------------------------active class active and inatcive code start-----------------
$(function () {
    $(".sidebar-menu-item").on("click", function () {
        $(".sidebar-menu-item").removeClass("active");
        $(this).addClass("active");
    });

    $(".sidebar-dropdown-menu-item").on("click", function (e) {
        e.stopPropagation();
        $(".sidebar-menu-item").removeClass("active");
        $(this).closest(".sidebar-menu-item").addClass("active");
    });
});

// --------------------------active class active and inatcive code end-----------------

// ---------------Users status update code start-----------------------
$(function () {
    $(".status2").on("change", function () {
        var status = $(this).prop("checked") ? 1 : 0;
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            url: "users/update-status",
            data: {
                status: status,
                id: id,
            },
            success: function (data) {
            toastr.success(data.message); // Display success message using Toastr
            },

        });
    });
});
// ---------------Users status update code end---------------------------

// ---------------------------download csv file script code start-----------------
function downloadCSV() {
    const csvContent =
        "name,mobile,email,address,gender,image,status,role,password\ndemotest,1234567890,demo@gmail.com,311-tst,Male,test.png,1,admin,1234567890";
    const blob = new Blob([csvContent], {
        type: "text/csv",
    });
    const link = document.createElement("a");
    link.href = window.URL.createObjectURL(blob);
    link.download = "users.csv";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// ---------------------------download csv file script code end-----------------

// ---------------currency status update code start-----------------------
$(function () {
    $(".status11").on("change", function () {
        var active = $(this).prop("checked") == true ? 1 : 0;
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "currency/update-status",
            data: {
                active: active,
                id: id,
            },
            success: function (data) {
                console.log(id);
            },
        });
    });
});
// ---------------currency status update code end---------------------------

// ----------------------select all code start---------------------

$(".permissionTable").on("click", ".selectall", function () {
    if ($(this).is(":checked")) {
        $(this).closest("tr").find("[type=checkbox]").prop("checked", true);
    } else {
        $(this).closest("tr").find("[type=checkbox]").prop("checked", false);
    }
    calcu_allchkbox();
});
$(".permissionTable").on("click", ".grand_selectall", function () {
    if ($(this).is(":checked")) {
        $(".selectall").prop("checked", true);
        $(".permissioncheckbox").prop("checked", true);
    } else {
        $(".selectall").prop("checked", false);
        $(".permissioncheckbox").prop("checked", false);
    }
});
$(function () {
    calcu_allchkbox();
    selectall();
});

function selectall() {
    $(".selectall").each(function (i) {
        var allchecked = new Array();
        $(this)
            .closest("tr")
            .find(".permissioncheckbox")
            .each(function (index) {
                if ($(this).is(":checked")) {
                    allchecked.push(1);
                } else {
                    allchecked.push(0);
                }
            });
        if ($.inArray(0, allchecked) != -1) {
            $(this).prop("checked", false);
        } else {
            $(this).prop("checked", true);
        }
    });
}
function calcu_allchkbox() {
    var allchecked = new Array();
    $(".selectall").each(function (i) {
        $(this)
            .closest("tr")
            .find(".permissioncheckbox")
            .each(function (index) {
                if ($(this).is(":checked")) {
                    allchecked.push(1);
                } else {
                    allchecked.push(0);
                }
            });
    });
    if ($.inArray(0, allchecked) != -1) {
        $(".grand_selectall").prop("checked", false);
    } else {
        $(".grand_selectall").prop("checked", true);
    }
}

$(".permissionTable").on("click", ".permissioncheckbox", function () {
    var allchecked = new Array();

    $(this)
        .closest("tr")
        .find(".permissioncheckbox")
        .each(function (index) {
            if ($(this).is(":checked")) {
                allchecked.push(1);
            } else {
                allchecked.push(0);
            }
        });

    if ($.inArray(0, allchecked) != -1) {
        $(this).closest("tr").find(".selectall").prop("checked", false);
    } else {
        $(this).closest("tr").find(".selectall").prop("checked", true);
    }

    calcu_allchkbox();
});
// ----------------------select all code end---------------------

// ----------------Social Login Script start--------------------
function togglePasswordVisibility() {
    var passwordField = document.getElementById("password");
    var toggleIcon = document.getElementById("togglePassword");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("flaticon-view");
        toggleIcon.classList.add("flaticon-hide");
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("flaticon-hide");
        toggleIcon.classList.add("flaticon-view");
    }
}

function togglePasswordVisibility1() {
    var passwordField1 = document.getElementById("confirm_password");
    var toggleIcon1 = document.getElementById("togglePasswordConfirmation");

    if (passwordField1.type === "password") {
        passwordField1.type = "text";
        toggleIcon1.classList.remove("flaticon-view");
        toggleIcon1.classList.add("flaticon-hide");
    } else {
        passwordField1.type = "password";
        toggleIcon1.classList.remove("flaticon-hide");
        toggleIcon1.classList.add("flaticon-view");
    }
}

function togglePasswordVisibility2() {
    var passwordField1 = document.getElementById(
        "facebook-client-key-password"
    );
    var toggleIcon1 = document.getElementById("facebooktogglePassword");

    if (passwordField1.type === "password") {
        passwordField1.type = "text";
        toggleIcon1.classList.remove("flaticon-view");
        toggleIcon1.classList.add("flaticon-hide");
    } else {
        passwordField1.type = "password";
        toggleIcon1.classList.remove("flaticon-hide");
        toggleIcon1.classList.add("flaticon-view");
    }
}

function togglePasswordVisibility3() {
    var passwordField1 = document.getElementById("google-client-key-password");
    var toggleIcon1 = document.getElementById("googletogglePassword");

    if (passwordField1.type === "password") {
        passwordField1.type = "text";
        toggleIcon1.classList.remove("flaticon-view");
        toggleIcon1.classList.add("flaticon-hide");
    } else {
        passwordField1.type = "password";
        toggleIcon1.classList.remove("flaticon-hide");
        toggleIcon1.classList.add("flaticon-view");
    }
}

function togglePasswordVisibility4() {
    var passwordField1 = document.getElementById("gitlab-client-key-password");
    var toggleIcon1 = document.getElementById("gitlabtogglePassword");

    if (passwordField1.type === "password") {
        passwordField1.type = "text";
        toggleIcon1.classList.remove("flaticon-view");
        toggleIcon1.classList.add("flaticon-hide");
    } else {
        passwordField1.type = "password";
        toggleIcon1.classList.remove("flaticon-hide");
        toggleIcon1.classList.add("flaticon-view");
    }
}

function togglePasswordVisibility5() {
    var passwordField1 = document.getElementById("amazon_client_key-password");
    var toggleIcon1 = document.getElementById("amazontogglePassword");

    if (passwordField1.type === "password") {
        passwordField1.type = "text";
        toggleIcon1.classList.remove("flaticon-view");
        toggleIcon1.classList.add("flaticon-hide");
    } else {
        passwordField1.type = "password";
        toggleIcon1.classList.remove("flaticon-hide");
        toggleIcon1.classList.add("flaticon-view");
    }
}

function togglePasswordVisibility6() {
    var passwordField1 = document.getElementById(
        "linkedin_client_key-password"
    );
    var toggleIcon1 = document.getElementById("linkedintogglePassword");

    if (passwordField1.type === "password") {
        passwordField1.type = "text";
        toggleIcon1.classList.remove("flaticon-view");
        toggleIcon1.classList.add("flaticon-hide");
    } else {
        passwordField1.type = "password";
        toggleIcon1.classList.remove("flaticon-hide");
        toggleIcon1.classList.add("flaticon-view");
    }
}

function togglePasswordVisibility7() {
    var passwordField1 = document.getElementById("twitter_client_key-password");
    var toggleIcon1 = document.getElementById("twittertogglePassword");

    if (passwordField1.type === "password") {
        passwordField1.type = "text";
        toggleIcon1.classList.remove("flaticon-view");
        toggleIcon1.classList.add("flaticon-hide");
    } else {
        passwordField1.type = "password";
        toggleIcon1.classList.remove("flaticon-hide");
        toggleIcon1.classList.add("flaticon-view");
    }
}

// ----------------Social Login Script end--------------------

// --------------toggle change on and off script code start----------------

$(function () {
    $(".toggle-switch").on("change", function () {
        $(".toggle-switch").not(this).prop("checked", false);
    });
});

// ------------toggle change on and off script code end----------

// -------static keywords in search bar show code start---------
const data = [
    "Dashboard",
    "Post",
    "Coming Soon",
    "FAQ",
    "Invoice setting",
    "Pages",
    "Color & Fonts",
    "Testimonial",
    "Sitemap",
    "Slider",
    "All User",
    "Role And Permission",
    "Mail Setting",
    "General setting",
    "Single Sign On",
    "Custom Setting",
    "Chat Setting",
    "PWA Setting",
    "Language  Setting ,",
    "Currency",
    "Email Design",
    "Packages",
    "Packages Features",
    "Payment Gateway",
    "Rest Api",
    "Site Setting",
    "Twilio",
    "Login & Signup",
    "Cockpit",
    "Coupon",
    "Advertisement",
    "Ad Sense",
    "Addon Manger",
    "Import Demo",
    "Database Backup",
    "Remove Public",
];

// -------static keywords in search bar show code end---------


// currency chnage code start
function changed_currency(params) {
    if (params) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            url: "{{ route('currencySwitch') }}",
            data: {
                id: params,
            },
            success: function (result) {
                window.location.reload();
            },
        });
    }
}
// currency chnage code endx

// ----------coupon code space remove code start------------
$(function () {
    $("#coupon_code").on("input", function () {
        var couponCode = $(this).val();
        var formattedCode = couponCode.replace(/ /g, "_");
        $(this).val(formattedCode);
    });
});

// ----------coupon code space remove code end------------

// ---------facts update status code start------------------
$(function () {
    $(".status2").on("change", function () {
        //  alert('hello');
        var status = $(this).prop("checked") == true ? 1 : 0;
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "facts/update-status",
            data: {
                status: status,
                id: id,
            },
            success: function (data) {
                console.log(id);
                toastr.success(data.message)
            },
        });
    });
});
// ---------facts update status code end--------------------

//---------------Category status update code start-----------------------
$(function () {
    $(document).on("change", ".categorystatus", function () {
        //  alert('hello');
        var status = $(this).prop("checked") == true ? 1 : 0;
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "category/category-update-status",
            data: {
                status: status,
                id: id,
            },
            success: function (data) {
                console.log(id);
                toastr.success(data.message)
            },
        });
    });
});

$(function () {
    $(document).on("change", ".subcategorystatus", function () {
        //  alert('hello');
        var status = $(this).prop("checked") == true ? 1 : 0;
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "category/subcategory-update-status",
            data: {
                status: status,
                id: id,
            },
            success: function (data) {
                console.log(id);
                toastr.success(data.message)
            },
        });
    });
});

$(function () {
    $(document).on("change", ".childcategorystatus", function () {
        //  alert('hello');
        var status = $(this).prop("checked") == true ? 1 : 0;
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "category/childcategory-update-status",
            data: {
                status: status,
                id: id,
            },
            success: function (data) {
                console.log(id);
                toastr.success(data.message)
            },
        });
    });
});

// ---------------Badge manages status update code end---------------------------

// ---------------Search code start---------------------------
function handleSearch(inputId, resultListId) {
    document.getElementById(inputId).addEventListener("input", function () {
        const searchTerm = this.value.toLowerCase().trim();
        const menuItems = document.querySelectorAll(
            ".vertical-menu > li, .vertical-submenu > li"
        );
        const resultList = document.getElementById(resultListId);
        const seenUrls = new Set();

        // Clear previous results
        resultList.innerHTML = "";
        if (searchTerm) {
            let resultsFound = false;
            menuItems.forEach((item) => {
                const link = item.querySelector("a");
                const text = link ? link.textContent.toLowerCase() : "";
                if (text.includes(searchTerm) && !seenUrls.has(link.href)) {
                    resultsFound = true;
                    seenUrls.add(link.href);

                    const li = document.createElement("li");
                    const a = document.createElement("a");
                    a.href = link.href;
                    a.textContent = link.textContent;
                    li.appendChild(a);
                    resultList.appendChild(li);
                }
            });
            if (!resultsFound) {
                const li = document.createElement("li");
                li.textContent = "No menus found";
                resultList.appendChild(li);
            }
            resultList.style.display = "block";
        } else {
            resultList.style.display = "none";
        }
    });
}

// Initialize search handlers for both inputs
handleSearch("searchInput1", "resultList1");
handleSearch("searchInput11", "resultList11");

// ---------------Search code start---------------------------

// ---------------Light And Dark Mode code start---------------------------

// Immediately apply dark mode if it was previously enabled
(function() {
    if (localStorage.getItem("darkMode") === "enabled") {
        document.documentElement.classList.add("dark-mode");
        document.body.style.backgroundColor = "#000"; // Set to your dark background color
    }
})();

// Function to enable dark mode
function enableDarkMode1() {
    document.documentElement.classList.add("dark-mode");
    document.body.style.backgroundColor = "#000"; // Set to your dark background color
    const modeIcon = document.getElementById("modeIcon1");
    if (modeIcon) {
        modeIcon.classList = "flaticon-sleep-mode";
    }
    localStorage.setItem("darkMode", "enabled");
    switchImages(true);
}

function disableDarkMode1() {
    document.documentElement.classList.remove("dark-mode");
    document.body.style.backgroundColor = ""; // Reset to default
    const modeIcon = document.getElementById("modeIcon1");
    if (modeIcon) {
        modeIcon.classList = "flaticon-sun-1";
    }
    localStorage.setItem("darkMode", "disabled");
    switchImages(false);
}

function switchImages(isDarkMode) {
    const switchableImages = document.querySelectorAll('.mode-switchable-image');
    switchableImages.forEach(img => {
        if (isDarkMode) {
            img.setAttribute('data-light-src', img.src);
            img.src = img.getAttribute('data-dark-src');
        } else {
            img.src = img.getAttribute('data-light-src') || img.getAttribute('src');
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    const modeSwitch = document.getElementById("modeSwitch1");
    if (modeSwitch) {
        modeSwitch.addEventListener("click", function (e) {
            e.preventDefault();
            const loadingIndicator = document.querySelector("#app-loading-indicator");
            if (loadingIndicator) {
                loadingIndicator.classList.remove("opacity-0");
            }

            if (document.documentElement.classList.contains("dark-mode")) {
                disableDarkMode1();
            } else {
                enableDarkMode1();
            }
        });
    }

    // Check and set initial mode
    if (localStorage.getItem("darkMode") === "enabled") {
        enableDarkMode1();
    } else {
        disableDarkMode1();
    }
});

// Handle blade switches or any dynamic content loading
document.addEventListener('turbolinks:load', function() {
    if (localStorage.getItem("darkMode") === "enabled") {
        enableDarkMode1();
    }
});
// ---------------Light And Dark Mode code end---------------------------

//---------------Service status update code start-----------------------

$(function () {
    $(".status3").on("change", function () {
        var status = $(this).prop("checked") == true ? 1 : 0;
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "services/update-status",
            data: {
                status: status,
                id: id,
            },
            success: function (data) {
                console.log(id);
                toastr.success(data.message)
            },
        });
    });
});

//---------------Service status update code end-----------------------

//---------------Category status update code start-----------------------
$(function () {
    $(".status7").on("change", function () {
        //  alert('hello');
        var status = $(this).prop("checked") == true ? 1 : 0;
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "post-category/update-status",
            data: {
                status: status,
                id: id,
            },
            success: function (data) {
                console.log(id);
                toastr.success(data.message)
            },
        });
    });
});
//---------------Category status update code end-----------------------

$(function () {
    $(".status8").on("change", function () {
        //  alert('hello');
        var status = $(this).prop("checked") == true ? 1 : 0;
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "faq/update-status",
            data: {
                status: status,
                id: id,
            },
            success: function (data) {
                console.log(id);
                toastr.success(data.message)
            },
        });
    });
});

// ---------------language status update code start-----------------------
$(function () {
    $(".status55").on("change", function () {
        var status = $(this).prop("checked") ? 1 : 0;
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "language/update-status",
            data: {
                status: status,
                id: id,
            },
            success: function (data) {
                console.log(id);
                toastr.success(data.message); // Display success message using Toastr

                // Reload the page after a delay of 2 seconds (2000 milliseconds)
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            },
            error: function () {
                toastr.error("Error occurred during the AJAX request."); // Display error message using Toastr
            }
        });
    });
});

// ---------------language status update code end---------------------------

// ---------------Mobile Sidebar code start---------------------------

$(function () {
    $("#searchInput12").on("input", function () {
        var searchText = $(this).val().trim().toLowerCase();
        var menuItems = $("#sidebarMenu li");
        var resultList = $("#resultList12");

        // Hide all menu items
        menuItems.hide();

        // Filter menu items based on search text
        var filteredItems = menuItems.filter(function () {
            return $(this).text().toLowerCase().indexOf(searchText) !== -1;
        });

        // Show matched items
        filteredItems.show();

        // Clear previous search results
        resultList.empty();

        // Add "No records found" message if no items match
        if (filteredItems.length === 0) {
            resultList.append('<li class="no-records-found">No records found</li>');
            resultList.css("display", "block"); // Show the message
        } else {
            resultList.css("display", "none"); // Hide the message
        }
    });
});

// ---------------Mobile Sidebar code end---------------------------
$(function () {
    $(".status15").on("change", function () {
        var status = $(this).prop("checked") ? 1 : 0;
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "post/update-status",
            data: {
                status: status,
                id: id,
            },
            success: function (data) {
                console.log(id);
                toastr.success(data.message); // Display success message using Toastr
            },
            error: function () {
                toastr.error("Error occurred during the AJAX request."); // Display error message using Toastr
            }
        });
    });
});

// ---------------Counter Js code end---------------------------
$(document).ready(function() {
    $(".number").counterUp({
        time: 1000
    });
});
})(jQuery);
