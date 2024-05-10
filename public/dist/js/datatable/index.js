var table, jsonTables;
// {{-- function load datatables  --}}
function loadAjaxDataTables(params) {

    // Setup - add a text input to each header cell
    if (!params.responsive) {
        $(params.idTable + ' thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo(params.idTable + ' thead');
    }

    table = $(params.idTable).DataTable({
        orderCellsTop: true,
        // fixedHeader: (params.responsive ? false : true),
        responsive: params.responsive,
        dom: 'lfrtip',
        processing: true,


        /// ---- handle filter each column function  -----
        initComplete: function () {
            if (!params.responsive) {
                var api = this.api();
                // For each column
                api
                    .columns()
                    .eq(0)
                    .each(function (colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        $(cell).html(
                            '<input type="text" class="text-center text-wrap" style="text-transform: uppercase;" placeholder="' +
                            title + '" />'
                        );

                        // On every keypress in this input
                        $(
                            'input',
                            $('.filters th').eq($(api.column(colIdx).header()).index())
                        )
                            .off('keyup change')
                            .on('change', function (e) {
                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr =
                                    '({search})'; //$(this).parents('th').find('select').val();

                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search(
                                        this.value != '' ?
                                            regexr.replace('{search}', '(((' + this.value +
                                                ')))') :
                                            '',
                                        this.value != '',
                                        this.value == ''
                                    )
                                    .draw();
                            })
                            .on('keyup', function (e) {
                                e.stopPropagation();

                                $(this).trigger('change');
                                $(this)
                                    .focus()[0]
                                    // .setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });
            }
        },
        ajax: params.urlAjax,
        columns: params.columns,
        columnDefs: params.defColumn,
    });


}

// console.log(table);
// ajax store data
function ajaxSaveDatas(params) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // console.log(params.reload)
    $.ajax({
        url: params.url,
        method: params.method,
        async: true,
        dataType: 'json',
        data: params.input,
        processData: params.processData !== null ? params.processData : true,
        contentType: params.contentType !== null ? params.contentType : 'application/x-www-form-urlencoded',
        beforeSend: function (xhr) {
            Swal.fire({
                title: 'Sedang menyimpan data...',
                html: 'Mohon ditunggu!',
                timerProgressBar: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            })
        },
        success: function (data) {
            if (params.reload == null || params.reload == false) {
                if (table != null)
                    table.ajax.reload();

            }

            Swal.close()
            Swal.fire({
                toast: true,
                position: 'top-right',
                icon: 'success',
                title: 'Yayy!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            })
            params.forms.reset()
            params.modal

            if (params.reload != null && params.reload == true) {
                // alert("apa")
                location.reload()
            }

            if (params.redirect != null) {
                window.location.href = params.redirect
            }

        },
        error: function (xhr) {
            Swal.close()
            var message;
            var validationErrors = xhr.responseJSON.errors
            console.log('xhr: ', xhr.responseJSON.errors);
            // console.log('status: ', status);
            // console.log('error: ', error);
            console.log(typeof validationErrors === 'object')
            if (typeof validationErrors === 'object') {
                for (var fieldName in validationErrors) {
                    if (validationErrors.hasOwnProperty(fieldName)) {
                        var errorMessages = validationErrors[fieldName];

                        // Handle each error message for the current field
                        console.log('Validation Errors for ' + fieldName + ':', errorMessages);
                        message = errorMessages
                        validationErrors = errorMessages
                    }
                }

                console.log('message from for loop: ', message)
            }
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'There is something wrong while saving data. Try again! ' +
                    validationErrors

            })
        }
    });
}

function deleteConfirm(event, params = null, isTable = true) {
    Swal.fire({
        title: 'Delete Confrimation!',
        text: 'Are you sure want to delete this data?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonText: 'Yes',
        confirmButtonColor: 'red'
    }).then(dialog => {
        var method = 'GET',
            valueHeaders = '';
        if (params != null) {
            method = params;
            valueHeaders = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
        }
        if (dialog.isConfirmed) {
            // window.location.assign(event.dataset.deleteUrl);
            $.ajax({
                headers: valueHeaders,
                url: event.dataset.deleteUrl,
                type: method,
                dataType: "JSON",
                error: function (xhr) {
                    var message;
                    var validationErrors = xhr.responseJSON.errors
                    for (var fieldName in validationErrors) {
                        if (validationErrors.hasOwnProperty(fieldName)) {
                            var errorMessages = validationErrors[fieldName];

                            // Handle each error message for the current field
                            console.log('Validation Errors for ' + fieldName + ':',
                                errorMessages);
                            message = errorMessages
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'There is something wrong while deleting data. Try again! ' +
                            (xhr.responseJSON &&
                                xhr.statusText ? xhr.statusText :
                                message ?
                                    message : ""),
                    })
                    console.log("statustext: " + xhr.statusText + "responsetxt: " + xhr
                        .responseText)
                },
                success: function (data) {
                    if (isTable) {
                        table.ajax.reload()
                    } else {
                        $(event).closest(".form-row").remove();
                    }
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        showCloseButton: true,
                        timer: 5000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal
                                .resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                }
            });
        }
    })
}