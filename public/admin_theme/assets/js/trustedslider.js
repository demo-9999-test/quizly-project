"use Strict";
 // ---------------------- drag and drop js start-----------------------
 document.addEventListener('DOMContentLoaded', function() {
    var urlLike = baseUrl + "/admin/trusted/slider/update-order";

    var sortableTable = new Sortable(document.getElementById('sortable-table'), {
        handle: 'td',
        animation: 150,
        onEnd: function(evt) {
            var item = evt.item;
            var itemId = item.getAttribute('data-id');
            var currentPosition = Array.from(item.parentNode.children).indexOf(item) + 1;

            var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
            // Update the position in the database using AJAX
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

            // Update positions of other rows
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
});

