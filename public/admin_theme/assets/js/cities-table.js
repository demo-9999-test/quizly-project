// cities-table.js

(function() {
    function initializeCitiesTable() {
        const citiesTable = document.getElementById('cities-table');

        if (citiesTable) {
            const ajaxUrl = citiesTable.dataset.ajaxUrl;

            if (!ajaxUrl) {
                console.error('Ajax URL not provided for cities table');
                return;
            }

            $(citiesTable).DataTable({
                processing: true,
                serverSide: true,
                ajax: ajaxUrl,
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'name', name: 'name' },
                    { data: 'state_id', name: 'state_id' },
                    { data: 'country_id', name: 'country_id' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        render: function(data, type, full, meta) {
                            return '<input type="checkbox" form="bulk_delete_form" class="check filled-in material-checkbox-input form-check-input" name="checked[]" value="' + full.id + '" id="checkbox' + full.id + '">';
                        }
                    }
                ]
            });
        } else {
            console.error('Cities table not found');
        }
    }

    // Check if jQuery and DataTable are available
    function checkDependencies() {
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded');
            return false;
        }
        if (typeof jQuery.fn.DataTable === 'undefined') {
            console.error('DataTables is not loaded');
            return false;
        }
        return true;
    }

    // Run initialization when the DOM is fully loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            if (checkDependencies()) {
                initializeCitiesTable();
            }
        });
    } else {
        if (checkDependencies()) {
            initializeCitiesTable();
        }
    }
})();
