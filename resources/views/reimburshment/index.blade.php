@extends('layouts.index')

@push('style')
    <!-- Datatable css -->
    <!-- --------------------------------------------------- -->
    <link rel="stylesheet" href="../../dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="../../dist/libs/summernote/dist/summernote-lite.min.css">
    <link rel="stylesheet" href="../../dist/libs/sweetalert2/dist/sweetalert2.min.css">
@endpush
@section('main')
    <!-- detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Reimburshment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Support File</label>
                        <div class="detail_support_file"></div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <p class="description_detail"></p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Data Reimburshment</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted " href="./index.html">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Reimburshment</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="../../dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2">
                            <h5 class="card-title">
                                {{ auth()->user()->hasRoles('staff') ? 'Your Reimburshment' : 'Staff\'s Reimburshment Request' }}
                            </h5>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal"
                                data-bs-target="#add-reimburshment">
                                Add New Reimburshment
                            </button>
                        </div>
                        <!-- Add Contact Popup Model -->
                        <div id="add-reimburshment" class="modal fade in" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <form class="form-horizontal form-material" id="form_store_reimburshment"
                                        action="{{ route('reimburshment.store') }}" method="POST"
                                        data-modal="dd-reimburshment">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title" id="myModalLabel">
                                                Add New Reimburshment
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            @csrf
                                            <div class="form-group">
                                                <div class="col-md-12 mb-3">
                                                    <input type="date" name="date_of_submission" class="form-control"
                                                        placeholder="date of submission" />
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <input type="text" name="reimburshment_name" class="form-control"
                                                        placeholder="Reimburshment Name" />
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <textarea name="description" id="editor" style="height: 300px"></textarea>
                                                    {{-- <tid="editor"></div> --}}
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div
                                                        class="
                                              fileupload
                                              btn btn-danger btn-rounded
                                              waves-effect waves-light
                                              btn-sm
                                            ">
                                                        <span><i class="ion-upload m-r-5"></i>Upload
                                                            Support File</span>
                                                        <input type="file" class="upload" name="support_file" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-info waves-effect"
                                                data-bs-dismiss="modal">
                                                Save
                                            </button>
                                            <button type="button" class="btn btn-default waves-effect"
                                                data-bs-dismiss="modal">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <div class="table-responsive">
                            <table id="table-1"
                                class="table table-striped table-bordered border text-inputs-searching text-nowrap">
                                <thead>
                                    <!-- start row -->
                                    <tr>
                                        <th>No</th>
                                        @if (!auth()->user()->hasRoles('staff'))
                                            <th>NIP</th>
                                            <th>Name</th>
                                            <th>Position</th>
                                        @endif
                                        <th>Submission Date</th>
                                        <th>Reimburshment Name</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                        <th>Action</th>
                                    </tr>
                                    <!-- end row -->
                                </thead>
                                <tbody>
                                </tbody>
                                {{-- <tfoot>
                                    <!-- start row -->
                                    <tr>
                                        <th>No</th>
                                        @if (!auth()->user()->hasRoles('staff'))
                                            <th>NIP</th>
                                            <th>Name</th>
                                            <th>Position</th>
                                        @endif
                                        <th>Submission Date</th>
                                        <th>Reimburshment Name</th>
                                        <th>Detail</th>
                                        <th>Action</th>
                                    </tr>
                                    <!-- end row -->
                                </tfoot> --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="../../dist/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../dist/libs/summernote/dist/summernote-lite.min.js"></script>
    <script src="../../dist/libs/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="../../dist/js/datatable/index.js"></script>
    <!-- ---------------------------------------------- -->
    <!-- current page js files -->
    <!-- ---------------------------------------------- -->
    <!-- Initialize Quill editor -->
    <script>
        $("#editor").summernote({
            height: 350, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false, // set focus to editable area after initializing summernote
        });
        $('#form_store_reimburshment').submit(function(e) {
            e.preventDefault();
            // alert($(this).data('modal'))

            let form = $(this);
            var form_data = new FormData($('#form_store_reimburshment')[0]);
            var arr_params = {
                url: form.attr('action'),
                method: 'POST',
                input: form_data,
                forms: form[0],
                modal: $('#' + form.data('modal')).modal('hide'),
                reload: false,
                processData: false,
                contentType: false,
            }
            ajaxSaveDatas(arr_params)
        });
    </script>
    <script>
        const isStaff = "{{ auth()->user()->hasRoles('staff') }}";
        var dataColumns = [{
                data: 'id'
            },
            {
                data: 'date_of_submission'
            },
            {
                data: 'reimburshment_name'
            },
            {
                data: 'status'
            },
            {
                data: 'id'
            },
            {
                data: 'id'
            },
        ];
        var columnDef = [{
                targets: [0],
                data: 'id',
                render: function(data, type, full, meta) {
                    return `<p class="text-center"> ${meta.row + 1} </p>`
                }
            },
            {
                targets: [3],
                data: 'status',
                render: function(data, type, full, meta) {
                    if (data == 'on_progress') {
                        return `<span class="badge bg-light-primary rounded-3 py-2 text-primary fw-semibold fs-2 d-inline-flex align-items-center gap-1"><i class="ti ti-reload fs-4"></i>On Progress</span>`
                    } else if (data == 'accept') {
                        return `<span class="badge bg-light-success rounded-3 py-2 text-primary fw-semibold fs-2 d-inline-flex align-items-center gap-1"><i class="ti ti-check fs-4"></i>Accepted</span>`
                    } else if (data == 'reject') {
                        return `<span class="badge bg-light-danger rounded-3 py-2 text-primary fw-semibold fs-2 d-inline-flex align-items-center gap-1"><i class="ti ti-close fs-4"></i>Rejected</span>`
                    }
                }
            },
            {
                targets: [4],
                data: 'link',
                render: function(data, type, full, meta) {
                    return `<a href="#detailProject" data-bs-toggle="modal" data-bs-target="#detailModal" class="btn btn-info" data-description="${full.description}" data-support_file="${window.location.origin + '/' + full.support_file}" ><i class="fas fa-eye"></i> Tap to View</a>`
                }
            },
            {
                targets: [5],
                data: 'id',
                render: function(data, type, full, meta) {
                    return `<div class="row w-100">
                           <div class="col-12 d-flex">
                              <a class="btn btn-warning btn-lg mr-1"
                                 href="#editData" data-toggle="modal" data-target="#editProjectModal" data-id=${data}
                                 data-project_title="${full.project_title}" data-publication_link="${full.publication_link}"
                                 data-description="${full.description}" data-image="${full.image}" data-start_date="${full.start_date}"  data-end_date="${full.end_date}" data-url="${window.urlPrefixAdmin}project/${data}"
                                 title="Edit"><i class="fas fa-edit"></i></a>
                              <a class="btn btn-danger btn-lg ml-1"
                                 href="#deleteData" data-delete-url="/reimburshment/${data}" 
                                 onclick="return deleteConfirm(this,'delete')"
                                 title="Delete"><i class="fas fa-trash"></i></a>
                           </div>
                     </div>`
                },
            }
        ];
        if (!isStaff) {
            dataColumns = [{
                    data: 'id'
                },
                {
                    data: 'user.nip'
                },
                {
                    data: 'user.name'
                },
                {
                    data: 'user.job_title'
                },
                {
                    data: 'date_of_submission'
                },
                {
                    data: 'reimburshment_name'
                },
                {
                    data: 'status'
                },
                {
                    data: 'id'
                },
                {
                    data: 'id'
                },
            ];

            columnDef = [{
                    targets: [0],
                    data: 'id',
                    render: function(data, type, full, meta) {
                        return `<p class="text-center"> ${meta.row + 1} </p>`
                    }
                },
                {
                    targets: [6],
                    data: 'status',
                    render: function(data, type, full, meta) {
                        if (data == 'on_progress') {
                            return `<span class="badge bg-light-primary rounded-3 py-2 text-primary fw-semibold fs-2 d-inline-flex align-items-center gap-1"><i class="ti ti-reload fs-4"></i>On Progress</span>`
                        } else if (data == 'accept') {
                            return `<span class="badge bg-light-success rounded-3 py-2 text-primary fw-semibold fs-2 d-inline-flex align-items-center gap-1"><i class="ti ti-check fs-4"></i>Accepted</span>`
                        } else if (data == 'reject') {
                            return `<span class="badge bg-light-danger rounded-3 py-2 text-primary fw-semibold fs-2 d-inline-flex align-items-center gap-1"><i class="ti ti-close fs-4"></i>Rejected</span>`
                        }
                    }
                },
                {
                    targets: [7],
                    data: 'link',
                    render: function(data, type, full, meta) {
                        return `<a href="#detailProject" data-bs-toggle="modal" data-bs-target="#detailModal" class="btn btn-info" data-description="${full.description}" data-support_file="${window.location.origin + '/' + full.support_file}" ><i class="fas fa-eye"></i> Tap to View</a>`
                    }
                },
                {
                    targets: [8],
                    data: 'id',
                    render: function(data, type, full, meta) {
                        return `<div class="row w-100">
                           <div class="col-12 d-flex">
                              <a class="btn btn-warning btn-lg mr-1"
                                 href="#editData" data-toggle="modal" data-target="#editProjectModal" data-id=${data}
                                 data-project_title="${full.project_title}" data-publication_link="${full.publication_link}"
                                 data-description="${full.description}" data-image="${full.image}" data-start_date="${full.start_date}"  data-end_date="${full.end_date}" data-url="${window.urlPrefixAdmin}project/${data}"
                                 title="Edit"><i class="fas fa-edit"></i></a>
                              <a class="btn btn-danger btn-lg ml-1"
                                 href="#deleteData" data-delete-url="${window.urlPrefixAdmin}project/${data}" 
                                 onclick="return deleteConfirm(this,'delete')"
                                 title="Delete"><i class="fas fa-trash"></i></a>
                           </div>
                     </div>`
                    },
                }
            ];

        }
        var arrayParams = {
            idTable: '#table-1',
            urlAjax: "{{ route('reimburshment.get-data') }}",
            columns: dataColumns,
            defColumn: columnDef,

        }
        loadAjaxDataTables(arrayParams);
        // table.on('xhr', function() {
        //     jsonTables = table.ajax.json();
        //     // console.log( jsonTables.data[350]["id"] +' row(s) were loaded' );
        // });
        function getFileType(url) {
            // Extract the file extension
            const extension = url.split('.').pop().toLowerCase();

            // Define image extensions
            const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];

            // Define document extensions
            const documentExtensions = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx'];

            // Check if the extension is in the list of image extensions
            if (imageExtensions.includes(extension)) {
                return 'image';
            }

            // Check if the extension is in the list of document extensions
            if (documentExtensions.includes(extension)) {
                return 'document';
            }

            // Default to 'unknown' if not recognized
            return 'unknown';
        }
        $('#detailModal').on('show.bs.modal', function(e) {
            const button = $(e.relatedTarget);
            let file = button.data('support_file');
            if (getFileType(file) == 'document')
            $('.detail_support_file').html(`<a href="${file}" class="btn btn-primary" target="_blank">Show File</a>`)
            else $('.detail_support_file').html(`<img src="${file}" id="modalImage_detail" class="img-fluid">`)

            $('.description_detail').html(button.data('description'))
        })
    </script>
    {{-- <script src="../../dist/js/datatable/datatable-api.init.js"></script> --}}
@endpush
