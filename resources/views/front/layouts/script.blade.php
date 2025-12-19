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
<script src="{{url('front_theme/assets/js/jquery.min.js')}}"></script> <!-- jquery library js -->
<script src="{{url('front_theme/assets/js/bootstrap.bundle.min.js')}}"></script>  <!-- bootstrap js -->
<script src="{{url('front_theme/vendor/slick/slick.min.js')}}"></script> <!-- slick js -->
<script src="{{url('front_theme/vendor/counter/jquery.counterup.js')}}"></script> <!-- counter js -->
<script src="{{url('front_theme/vendor/counter/jquery.waypoints.js')}}"></script> <!-- counter js -->
<script src="{{url('front_theme/vendor/wow/wow.min.js')}}"></script> <!-- Wow js -->
<script src="{{url('front_theme/vendor/froalaeditor/froala_editor.min.js')}}"></script> <!-- froala_editor js -->
<script src="{{url('front_theme/vendor/froalaeditor/froala_editor.pkgd.min.js')}}"></script> <!-- froala_editor js -->
<script src="{{url('front_theme/vendor/apexchart/apexcharts.js')}}"></script> <!-- apex charts js -->
<script src="{{asset('front_theme/assets/js/venom-button.min.js')}}"></script>
<script src="{{url('front_theme/vendor/daterange/moment.min.js')}}"></script><!-- date range picker -->
<script src="{{url('front_theme/vendor/daterange/daterangepicker.js')}}"></script><!-- date range picker -->
<script src="{{url('front_theme/vendor/apexchart/apexcharts.min.js')}}"></script> <!-- apex charts js -->
<script src="{{url('front_theme/assets/js/axios.min.js')}}"></script>
<script src="{{url('front_theme/assets/js/socket.io.js')}}"></script>

@if (in_array($language, $rtl))
<script src="{{url('front_theme/assets/js/theme_rtl.js')}}"></script> <!-- custom js -->
@else
<script src="{{url('front_theme/assets/js/theme.js')}}"></script> <!-- custom js -->
@endif
<script>
    new FroalaEditor('#desc');
</script>

<script>
    var config = {
        animateClass: 'animated'
    };
</script>
<script>
    new WOW({
        animateClass: config.animateClass
    }).init();
</script>

<script>
    function selectLanguage(flag) {
        document.getElementById("selectedFlag").src = "{{ asset('/images/language/') }}" + flag;
    }
</script>
@php
        $chat = App\Models\SocialChat::first();
        $title = $chat->header_title;
        $phone = $chat->contact;
        $msg =$chat->wp_msg;
        $color = $chat->wp_color;
        if($chat->button_position === 1){
            $position = 'right';
        }else{
            $position = 'left';
        }
    @endphp
    @php
    $socialchat = \App\Models\SocialChat::first();
@endphp

@if($socialchat && $socialchat->whatsapp_enable_button)
<script type="text/javascript">
    $('#myButton').venomButton({
        phone: '{{$phone}}',
        popupMessage: '',
        message: "{{$msg}}",
        showPopup: true,
        position: "{{$position}}",
        linkButton: false,
        showOnIE: true,
        headerTitle: '{{ $title }}',
        headerColor: '{{$color}}',
        backgroundColor: '#25D366',
        zIndex: 999999999999,
        buttonImage: `{{ url('images/icons/whatsapp.svg')}}`,
        size:'60px',
    });
</script>
@endif
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
@if(Route::currentRouteName() == 'home' || '/')
    @if(isset($slider) && $slider->isNotEmpty())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const typewriterElement = document.querySelector('.slider-sub-heading');
                const subHeadings = @json($slider->pluck('sub_heading')->toArray());
                let textIndex = 0;
                let charIndex = 0;
                typewriterElement.innerHTML = " ";

                function type() {
                    if (charIndex < subHeadings[textIndex].length) {
                        typewriterElement.innerHTML += subHeadings[textIndex].charAt(charIndex);
                        charIndex++;
                        setTimeout(type, 70);
                    } else {
                        setTimeout(erase, 100);
                    }
                }

                function erase() {
                    if (charIndex > 0) {
                        typewriterElement.innerHTML = subHeadings[textIndex].substring(0, charIndex - 1);
                        charIndex--;
                        setTimeout(erase, 100);
                    } else {
                        textIndex = (textIndex + 1) % subHeadings.length;
                        setTimeout(type, 70);
                    }
                }

                type();
            });
        </script>
    @endif
@endif
<script>
    $(document).ready(function() {
        $(".number").counterUp({
            time: 2000
        });
    });
</script>
<script>
    $().ready(function() {
        $('.alert').delay(2000);
        $('.alert').hide(3000);
    })
</script>

<script>
    function get_state_country(params) {
        if (params) {
            $.ajax({
                type: "GET",
                url: '{{ route('profile.get.state.country') }}',
                data: {
                    city: params
                },
                success: function(data) {
                    if (data.status === 'True') {
                        $('.city_id').val(data.city_id);
                        $('.state').val(data.state);
                        $('.state_id').val(data.state_id);
                        $('.country').val(data.country);
                        $('.country_id').val(data.country_id);
                        $('.error').hide();
                    } else {
                        $('.city_id').val('');
                        $('.state').val('');
                        $('.state_id').val('');
                        $('.country').val('');
                        $('.country_id').val('');
                        $('.error').show();
                        $('.error').text(data.msg);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                }
            });
        }
    }
</script>

@if(auth()->check())
<script>
    function storeTab() {
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var currentTab = $(e.target).attr('href');
            localStorage.setItem('selectedTab', currentTab);
        });
    }

    function loadTab() {
        var selectedTab = localStorage.getItem('selectedTab');
        if (selectedTab) {
            $('a[href="' + selectedTab + '"]').tab('show');
        } else {
            $('#myTab a:first').tab('show');
        }
    }

    $(document).ready(function() {
        storeTab();
        loadTab();
    });
</script>
@endif
@if(auth()->user())
<script>
$(document).ready(function() {
    $('.bookmark-btn').on('click', function() {
        var quizId = $(this).data('quiz-id');
        var button = $(this);

        $.ajax({
            url: '/bookmark/toggle/' + quizId,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.bookmarked) {
                    button.addClass('active');
                } else {
                    button.removeClass('active');
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });
});
</script>
@endif
@if(Request::is('category/*') )
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const radioButtons = document.querySelectorAll('.form-check-input');
    const quizBlocks = document.querySelectorAll('.discover-block');

    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            const selectedValue = this.value;
            quizBlocks.forEach(block => {
                if (selectedValue === 'all' || block.dataset.service === selectedValue) {
                    block.style.display = 'block';
                } else {
                    block.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endif
@if(Request::is('category/*') )
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to filter quizzes based on selected quiz types
        function filterQuizzes() {
            const selectedTypes = Array.from(document.querySelectorAll('.quiz-type-filter:checked')).map(checkbox => checkbox.value);
            document.querySelectorAll('.discover-block').forEach(block => {
                const quizType = block.dataset.type;
                if (selectedTypes.length === 0 || selectedTypes.includes(quizType)) {
                    block.style.display = '';
                } else {
                    block.style.display = 'none';
                }
            });
        }

        // Add event listeners to checkboxes
        document.querySelectorAll('.quiz-type-filter').forEach(checkbox => {
            checkbox.addEventListener('change', filterQuizzes);
        });

        // Initial filter call to display quizzes based on default state of checkboxes
        filterQuizzes();
    });
</script>
@endif

<script>
    $(document).ready(function() {
        function updateFilters() {
            var priceFilter = $('input[name="priceFilter"]:checked').val();
            var typeFilter = $('input[name="typeFilter"]:checked').val();
            var searchQuery = $('#searchInput11').val().trim();

            var currentUrl = new URL(window.location.href);

            // Always set both filters, use 'all' as default
            currentUrl.searchParams.set('price_filter', priceFilter || 'all');
            currentUrl.searchParams.set('type_filter', typeFilter || 'all');

            // Set search query if not empty
            if (searchQuery) {
                currentUrl.searchParams.set('search', searchQuery);
            } else {
                currentUrl.searchParams.delete('search');
            }

            // Reset to first page when changing filters or search
            currentUrl.searchParams.delete('page');

            window.location.href = currentUrl.toString();
        }

        $('.price-filter, .type-filter').on('change', updateFilters);

        $('#searchButton11').on('click', updateFilters);

        $('#searchInput11').on('keypress', function(e) {
            if (e.which == 13) { // Enter key
                updateFilters();
            }
        });

        // Set initial search input value
        $('#searchInput11').val(new URLSearchParams(window.location.search).get('search') || '');
    });
</script>

<script>
var li_links = document.querySelectorAll(".links ul li");
var view_wrap = document.querySelectorAll(".view_wrap");

li_links.forEach(function(link) {
  link.addEventListener("click", function(){
    li_links.forEach(function(item){
      item.classList.remove("selected");
    });
    link.classList.add("selected");

    var li_view = link.getAttribute("data-view");

    view_wrap.forEach(function(view){
      view.style.display = "none";
    });

    var selectedView = document.querySelector("." + li_view);
    if(selectedView) {
      selectedView.style.display = "block";
    }
  });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const passwordGroups = document.querySelectorAll('.password-group');

    passwordGroups.forEach(group => {
        const input = group.querySelector('input[type="password"]');
        const eyeBtn = group.querySelector('.eye-btn');
        const icon = eyeBtn.querySelector('i');

        eyeBtn.addEventListener('click', function() {
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'flaticon-delete-1';
            } else {
                input.type = 'password';
                icon.className = 'flaticon-eye-close-up';
            }
        });
    });
});
</script>

@if(Request::is('blog/*'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('example-search-input');
        const searchResults = document.getElementById('search-results');

        // Now we're getting both title and slug (or id) for each blog
        const blogs = @json($blogsExceptCurrent->map(function($blog) {
            return [
                'title' => $blog->title,
                'url' => route('blog.details', $blog->slug)  // Adjust this based on your route structure
            ];
        }));

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim().toLowerCase();
            searchResults.innerHTML = '';


            const filteredResults = blogs.filter(function (blog) {
                return blog.title.toLowerCase().includes(query);
            });

            if (filteredResults.length > 0) {
                const resultList = document.createElement('ul');
                resultList.classList.add('list-group');
                filteredResults.forEach(function (blog) {
                    const listItem = document.createElement('li');
                    listItem.classList.add('list-group-item');

                    const link = document.createElement('a');
                    link.href = blog.url;
                    link.textContent = blog.title;
                    link.style.display = 'block';  // Make the entire li clickable
                    link.style.textDecoration = 'none';  // Remove underline from link
                    link.style.color = 'inherit';  // Inherit text color from parent

                    listItem.appendChild(link);
                    resultList.appendChild(listItem);
                });
                searchResults.appendChild(resultList);
            } else {
                searchResults.innerHTML = '<p class="no-result">No results found</p>';
            }
        });
    });
</script>
@endif

@if(Request::is('category/*') )
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput11');
        const searchButton = document.getElementById('searchButton11');
        const viewWraps = document.querySelectorAll('.view_wrap');
        const noResultsMessage = document.createElement('h3');
        noResultsMessage.textContent = 'No results found';
        noResultsMessage.style.display = 'none'; // Initially hide no results message

        function filterQuizzes() {
            const searchTerm = searchInput.value.trim().toLowerCase();
            const activeView = document.querySelector('.li-list.selected').getAttribute('data-view');

            viewWraps.forEach(function(viewWrap) {
                const isListView = viewWrap.classList.contains('list_view');
                const isGridView = viewWrap.classList.contains('grid_view');
                const quizzesInCurrentView = viewWrap.querySelectorAll('.discover-block');

                let foundResults = false; // Flag to track if any results are found in current view

                quizzesInCurrentView.forEach(function(quiz) {
                    const quizName = quiz.querySelector('.discover-title').textContent.toLowerCase();
                    const matchesSearch = quizName.includes(searchTerm)

                    // Display logic based on active view
                    if ((isListView && activeView === 'list_view') || (isGridView && activeView === 'grid_view')) {
                        quiz.style.display = matchesSearch ? 'block' : 'none';
                    }

                    if (matchesSearch) {
                        foundResults = true;
                    }
                });

                // Show or hide no results message based on foundResults flag
                noResultsMessage.style.display = foundResults ? 'none' : 'block';

                // Append no results message to current viewWrap
                if ((isListView && activeView === 'list_view') || (isGridView && activeView === 'grid_view')) {
                    if (viewWrap.querySelector('h3') === null) {
                        viewWrap.appendChild(noResultsMessage);
                    }
                }
            });
        }

        // Event listeners
        searchButton.addEventListener('click', filterQuizzes);
        searchInput.addEventListener('input', filterQuizzes);
    });
</script>
@endif
@if(Request::is('quiz/*') || Request::is('start-battle/*'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var timerElement = document.querySelector('.timer');
        var quizId = {{ $quiz->id }};
        var quizType = '{{ $quiz->type }}';
        var initialTimerSeconds = parseInt(timerElement.getAttribute('data-timer'), 10);

        function getSubmissionRoute() {
            switch(quizType) {
                case '1': // Objective quiz
                    return '{{ route("submite.obj.quiz", ["id" => $quiz->id, "question_id" => 0]) }}';
                case '0': // Subjective quiz
                    return '{{ route("submit.quiz", ["id" => $quiz->id, "question_id" => 0]) }}';
                default:
                    console.error('Unknown quiz type');
                    return '';
            }
        }

        function getRemainingTime() {
            var storedTime = localStorage.getItem('quiz_timer_' + quizId);
            if (storedTime) {
                var savedTime = JSON.parse(storedTime);
                var currentTime = Math.floor(Date.now() / 1000);
                var elapsedTime = currentTime - savedTime.startTime;
                var remainingTime = savedTime.remainingTime - elapsedTime;
                return remainingTime > 0 ? remainingTime : 0;
            }
            return initialTimerSeconds;
        }

        function saveRemainingTime(remainingTime) {
            var currentTime = Math.floor(Date.now() / 1000);
            localStorage.setItem('quiz_timer_' + quizId, JSON.stringify({
                startTime: currentTime,
                remainingTime: remainingTime
            }));
        }

        var timerSeconds = getRemainingTime();

        function updateTimer() {
            var minutes = Math.floor(timerSeconds / 60);
            var seconds = timerSeconds % 60;

            var timerDisplay = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
            timerElement.textContent = timerDisplay;

            if (timerSeconds <= 0) {
                clearInterval(timerInterval);
                localStorage.removeItem('quiz_timer_' + quizId);
                submitForm();
            } else {
                timerSeconds--;
                if (!document.getElementById('confirmLeave').classList.contains('confirmed')) {
                    saveRemainingTime(timerSeconds);
                }
            }
        }

        function findQuizForm() {
            // Try to find the form by a specific class or ID first
            var form = document.querySelector('form.quiz-form');
            if (!form) {
                form = document.getElementById('quiz-form');
            }

            // If still not found, look for any form containing 'submite' in the action
            if (!form) {
                form = document.querySelector('form[action*="submite"]');
            }

            // If still not found, get the first form on the page
            if (!form) {
                form = document.querySelector('form');
            }

            return form;
        }

        function submitForm() {
            var form = findQuizForm();
            if (form) {
                var submissionRoute = getSubmissionRoute();
                if (submissionRoute) {
                    var originalAction = form.action;
                    form.action = submissionRoute;
                    console.log('Submitting form to:', submissionRoute);
                    form.submit();
                    // Restore original action after submission
                    setTimeout(function() { form.action = originalAction; }, 0);
                } else {
                    console.error('Unable to determine submission route');
                }
            } else {
                console.error('Form not found. Please check the form identifier.');
            }
        }

        updateTimer();
        var timerInterval = setInterval(updateTimer, 1000);

        var confirmLeaveButton = document.getElementById('confirmLeave');
        if (confirmLeaveButton) {
            confirmLeaveButton.addEventListener('click', function() {
                clearInterval(timerInterval);
                localStorage.removeItem('quiz_timer_' + quizId);
                this.classList.add('confirmed');
            });
        }
    });
</script>
@endif

 <script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@if(Request::is('coins/*'))
<script>
    var options = {
          series: [{
            name: "Balance",
            data: [0, 100, 150, 200, 250, 300, 350, 400]
        }],
          chart: {
          height: 350,
          type: 'line',
          toolbar: false,
          zoom: {
            enabled: false
          }
        },
        colors: ['#198754'],
        dataLabels: {
          enabled: true,
        },
        stroke: {
          curve: 'straight',
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
</script>
<script>
    $(function() {
        // Set default to This Month
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        // Check URL parameters and override if present
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('start_date')) {
            start = moment(urlParams.get('start_date'));
        }
        if (urlParams.get('end_date')) {
            end = moment(urlParams.get('end_date'));
        }

        function updateFilters() {
            var currentUrl = new URL(window.location.href);
            var startDate = $('#dateRangePicker').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var endDate = $('#dateRangePicker').data('daterangepicker').endDate.format('YYYY-MM-DD');
            var transactionType = $('#transactionTypeFilter').val();

            currentUrl.searchParams.set('start_date', startDate);
            currentUrl.searchParams.set('end_date', endDate);
            currentUrl.searchParams.set('transaction_type', transactionType);

            window.location.href = currentUrl.toString();
        }

        $('#dateRangePicker').daterangepicker({
            opens: 'left',
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, function(start, end, label) {
            updateFilters();
        });

        // Update the input field with the current date range
        $('#dateRangePicker').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        $('#transactionTypeFilter').change(function() {
            updateFilters();
        });
    });
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tabElements = document.querySelectorAll('button[data-bs-toggle="tab"]');

        // Function to set active tab
        function setActiveTab(tabId) {
            tabElements.forEach(function(tab) {
                if (tab.id === tabId) {
                    tab.classList.add('active');
                    document.querySelector(tab.getAttribute('data-bs-target')).classList.add('show', 'active');
                } else {
                    tab.classList.remove('active');
                    document.querySelector(tab.getAttribute('data-bs-target')).classList.remove('show', 'active');
                }
            });
        }

        // Check for stored tab on page load
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            setActiveTab(activeTab);
        } else {
            // Set default tab if no stored tab
            setActiveTab('overview-tab');
        }

        // Add click event listeners to tabs
        tabElements.forEach(function(tab) {
            tab.addEventListener('click', function() {
                localStorage.setItem('activeTab', this.id);
            });
        });
    });
</script>



@if(Request::is('battle/room/*'))
<script>
    $(document).ready(function() {
        function checkForOpponent() {
            $.ajax({
                url: "{{ route('battle.check-opponent', $battle->id) }}",
                method: 'GET',
                success: function(response) {
                    if (response.hasOpponent) {
                        location.reload();
                    }
                }
            });
        }
        @if(!$battle->opponent_id)
            setInterval(checkForOpponent, 1000);
        @endif
    });
</script>
@endif

@if(Request::is('battle/result/*'))
<script>
    $(document).ready(function() {
        function checkForOpponent() {
            $.ajax({
                url: "{{ route('battle.check-opponent', $battle->id) }}",
                method: 'GET',
                success: function(response) {
                    if (response.hasOpponent) {
                        location.reload();
                    }
                }
            });
        }
        @if(!$battle->opponent_id)
            setInterval(checkForOpponent, 1000);
        @endif
    });
</script>
@endif

@if(Request::is('find-friend'))
<script>
    $(document).ready(function() {
        var typingTimer;
        var doneTypingInterval = 300;

        $('#search-input').on('input', function() {
            clearTimeout(typingTimer);
            var query = $(this).val();

            if (query) {
                typingTimer = setTimeout(function() {
                    performSearch(query);
                }, doneTypingInterval);
            } else {
                $('#search-suggestions').hide();
                $('#user-container .user-card').show();
            }
        });

        function performSearch(query) {
            $.ajax({
                url: '{{ route("search.users") }}',
                method: 'GET',
                data: { query: query },
                success: function(response) {
                    displaySuggestions(response.suggestions);
                    filterResults(response.users);
                }
            });
        }

        function displaySuggestions(suggestions) {
            var suggestionsHtml = '';
            var baseUrl = "{{ route('friend.page', ['slug' => '__SLUG__']) }}";
            suggestions.forEach(function(data) {
                var url = baseUrl.replace('__SLUG__', data.slug);
                suggestionsHtml += `
                    <a href="${url}" class="suggestion-item" title="${data.name}">
                        <img src="{{ asset('images/users') }}/${data.image}" alt="${data.name}" class="suggestion-image img-fluid">
                        <span class="suggestion-name">${data.name}</span>
                    </a>
                `;
            });
            $('#search-suggestions').html(suggestionsHtml).show();
        }

        function filterResults(users) {
            $('#user-container .user-card').hide();
            users.forEach(function(user) {
                $('#user-container .user-card[data-user-id="' + user.id + '"]').show();
            });
        }

        $(document).on('click', function(event) {
            if (!$(event.target).closest('.search-container').length) {
                $('#search-suggestions').hide();
            }
        });

        // Handle suggestion click
        $(document).on('click', '.suggestion-item', function(e) {
            e.preventDefault();
            $('#search-input').val($(this).find('.suggestion-name').text());
            $('#search-suggestions').hide();
            performSearch($(this).find('.suggestion-name').text());
        });
    });
</script>
@endif
@if(Request::is('profile'))
<script>
    document.getElementById('add-image-button').addEventListener('click', function() {
        document.getElementById('image').click();
    });

    document.getElementById('image').addEventListener('change', function() {
        var formData = new FormData();
        formData.append('image', this.files[0]);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("profile.upload", ["id" => auth()->user()->id]) }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    document.getElementById('remove-confirm-button').addEventListener('click', function() {
        fetch('{{ route("profile.remove", ["id" => auth()->user()->id]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
<script>
    document.getElementById('reason').addEventListener('change', function () {
        var otherReasonContainer = document.getElementById('other-reason-container');
        if (this.value === 'other') {
            otherReasonContainer.style.display = 'block';
        } else {
            otherReasonContainer.style.display = 'none';
        }
    });
</script>
@endif
@if(Request::is('coins/*'))
<script>
   document.addEventListener('DOMContentLoaded', function() {
    var categories = @json($categories); // Array of day numbers
    var balances = @json($balances); // Array of corresponding balance values

    var options = {
        chart: {
            type: 'bar', // Use 'bar' if you want bar chart
            height: 500
        },
        series: [{
            name: 'Coin Balance',
            data: balances
        }],
        xaxis: {
            categories: categories,
            title: {
                text: 'Day of Month'
            }
        },
        yaxis: {
            title: {
                text: 'Coin Balance'
            },
            min: 0, // Ensure the minimum value starts from 0
            tickAmount: 10,
            labels: {
                formatter: function(val) {
                    return val.toFixed(0);
                }
            }
        },
        title: {
            text: 'Coin Balance Over Current Month',
            align: 'center'
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val.toFixed(0);
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#coinBalanceChart"), options);
    chart.render();
});
</script>
@endif

@if(Request::is('battle/*'))
<script>
    function generateCode() {
        // Generate a random code
        const code = Math.random().toString(36).substr(2, 6).toUpperCase();

        // Display the code in the visible span
        document.getElementById('roomCode').textContent = code;

        // Set the value of the hidden input field
        document.getElementById('code').value = code;

        // Show the code section
        document.getElementById('codeSection').style.display = 'inline-block';
    }

    function copyCode() {
        const code = document.getElementById('roomCode').textContent;
        navigator.clipboard.writeText(code).then(() => {
            alert('Room code copied to clipboard!');
        });
    }
</script>
@endif
@if(Request::is('report/*/*/*'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Push initial state
        history.pushState(null, null, location.href);

        // Handle popstate event
        window.addEventListener('popstate', function(event) {
            history.pushState(null, null, location.href);
        });

        // Disable back button
        window.history.forward();
    });
</script>
@endif

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
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchright');
    const searchForm = document.getElementById('search-form');
    const searchResults = document.getElementById('search-results');
    let debounceTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => performSearch(this.value), 300);
    });

    function performSearch(query) {
        if (query.length > 0) {
            fetch(`/api/search?query=${encodeURIComponent(query)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    displaySearchResults(data);
                })
                .catch(error => {
                    searchResults.innerHTML = `<div class="search-error">An error occurred: ${error.message}</div>`;
                    console.error('Fetch error:', error);
                });
        } else {
            clearSearchResults();
        }
    }

    function displaySearchResults(data) {
        searchResults.innerHTML = '';
        let quizzesAvailable = false;

        if (Array.isArray(data) && data.length > 0) {
            data.forEach(quiz => {
                if (isQuizAvailable(quiz)) {
                    quizzesAvailable = true;
                    const quizElement = createQuizElement(quiz);
                    searchResults.appendChild(quizElement);
                }
            });
        }

        if (!quizzesAvailable) {
            searchResults.innerHTML = '<div class="search-no-result">No results found</div>';
        }

        searchResults.style.display = 'block';
    }

    function isQuizAvailable(quiz) {
        return quiz.status === 1 && quiz.canAttempt && quiz.approve_result !== 1;
    }

    function createQuizElement(quiz) {
        const a = document.createElement('a');
        a.textContent = quiz.name;
        a.href = getQuizRoute(quiz);
        return a;
    }

    function getQuizRoute(quiz) {
        switch (quiz.type) {
            case 0: return `/quiz/subjective/${quiz.slug}`;
            case 1: return `/quiz/objective/${quiz.slug}`;
            default: return '#';
        }
    }

    function clearSearchResults() {
        searchResults.innerHTML = '';
        searchResults.style.display = 'none';
    }

    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const query = searchInput.value;
        if (query.length > 0) {
            window.location.href = `/search?query=${encodeURIComponent(query)}`;
        }
    });

    document.addEventListener('click', function(e) {
        if (!searchResults.contains(e.target) && e.target !== searchInput) {
            searchResults.style.display = 'none';
        }
    });
});
</script>
