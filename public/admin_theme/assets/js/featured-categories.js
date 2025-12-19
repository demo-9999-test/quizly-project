$(function() {
    $('#featuredCategoriesTable').DataTable();

    // Update remaining time every minute
    setInterval(updateRemainingTime, 60000);

    function updateRemainingTime() {
        $('.remaining-time').each(function() {
            var endTime = $(this).data('end') * 1000; // Convert to milliseconds
            var now = new Date().getTime();
            var distance = endTime - now;

            if (distance < 0) {
                $(this).text('Time Over');
            } else {
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

                $(this).text(days + "d " + hours + "h " + minutes + "m");
            }
        });
    }

    // Status toggle functionality
    $('.status-toggle').on('change', function(e) {
        var $toggle = $(this);
        var categoryId = $toggle.data('id');
        var isChecked = $toggle.prop('checked');
        var startDate = $toggle.data('start-date');
        var endDate = $toggle.data('end-date');

        // Prevent the default toggle action
        e.preventDefault();

        // Get the current timestamp
        var currentTimestamp = new Date().getTime() / 1000;

        if (currentTimestamp < startDate) {
            toastr.warning('This category is not yet active. It will automatically activate on the start date.');
            $toggle.prop('checked', false);
            return;
        }

        if (currentTimestamp > endDate) {
            toastr.warning('This category has expired. You cannot activate it.');
            $toggle.prop('checked', false);
            return;
        }

        if (isChecked) {
            toastr.info("You can't turn off the status manually. It will automatically turn off on the end date.");
            $toggle.prop('checked', true);
            return;
        }

        $.ajax({
            url: toggleStatusUrl.replace(':id', categoryId),
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status: 1  // We're only allowing activation here
            },
            success: function(data) {
                if (data.success) {
                    $toggle.prop('checked', true);
                    toastr.warning('Status will update automatically on the end date');
                } else {
                    toastr.error(data.message);
                    $toggle.prop('checked', false);
                }
            },
            error: function(xhr) {
                toastr.error('An error occurred while updating the status');
                $toggle.prop('checked', false);
            }
        });
    });
});
