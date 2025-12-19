"use strict";

document.addEventListener('DOMContentLoaded', function() {
    var urlLike = baseUrl + "/admin/faq/update-order";
    var sortableTable = document.getElementById('sortable-table');

    if (sortableTable) {
        var sortable = new Sortable(sortableTable, {
            handle: 'td',
            animation: 150,
            onEnd: function(evt) {
                var item = evt.item;
                var itemId = item.getAttribute('data-id');
                var currentPosition = Array.from(item.parentNode.children).indexOf(item) + 1;

                var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
                fetch(urlLike, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify({
                            id: itemId,
                            position: currentPosition,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => console.log(data))
                    .catch(error => console.error('Error:', error));

                var rows = Array.from(item.parentNode.children);
                rows.forEach(function(row, index) {
                    var rowId = row.getAttribute('data-id');
                    var newPosition = index + 1;

                    if (newPosition !== currentPosition) {
                        fetch(urlLike, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    "X-CSRF-TOKEN": csrfToken,
                                },
                                body: JSON.stringify({
                                    id: rowId,
                                    position: newPosition,
                                }),
                            })
                            .then(response => response.json())
                            .then(data => console.log(data))
                            .catch(error => console.error('Error:', error));
                    }
                });
            },
        });
    } else {
        console.log("Element with ID 'sortable-table' not found.");
    }
});

// faq status update code
$(function () {
    $(".status2").on("change",function () {
        var status = $(this).prop("checked") == true ? 1 : 0;
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: baseUrl + "/faq/update-status",
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
