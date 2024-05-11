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
    {{-- <!-- Edit Reimburshment Popup Model -->
    <div class="edit-reimburshment modal fade" id="vertical-center-scroll-modal" tabindex="-1"
        aria-labelledby="vertical-center-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form class="form-horizontal form-material" id="form_update_reimburshment"
                    action="{{ route('reimburshment.store') }}" method="POST" data-modal="dd-reimburshment">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            Vertically centered scrollable Modal
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label>Date Of Submission</label>
                            <div class="col-md-12 mb-3">
                                <input type="date" name="date_of_submission" class="form-control date_edit"
                                    placeholder="date of submission" />
                            </div>
                            <label>Reimburshment Name</label>
                            <div class="col-md-12 mb-3">
                                <input type="text" name="reimburshment_name" class="form-control reimburshment_name_edit"
                                    placeholder="Reimburshment Name" />
                            </div>
                            <label>Description</label>
                            <div class="col-md-12 mb-3">
                                <textarea name="description" class="description_edit editor"></textarea>
                            </div>
                            <label>Support File</label>
                            <span class="badge bg-warning">*Upload
                                Support File Only When you Wanna Change the Support File</span>
                            <small>
                                <p class="mb-0">Previous Support File:</p>
                            </small>
                            <div class="detail_support_file_edit mt-0 mb-3"></div>
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
                        <button type="submit" class="btn btn-info waves-effect" data-bs-dismiss="modal">
                            Save
                        </button>
                        <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
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
                            @if (auth()->user()->hasRoles('staff'))
                                <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal"
                                    data-bs-target=".add-reimburshment">
                                    Add New Reimburshment
                                </button>
                            @endif
                        </div>
                        <!-- Add Reimburshment Popup Model -->
                        <div id="scroll-long-outer-modal" class="modal fade in add-reimburshment" tabindex="-1"
                            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                <label>Date Of Submission</label>
                                                <div class="col-md-12 mb-3">
                                                    <input type="date" name="date_of_submission" class="form-control"
                                                        placeholder="date of submission" />
                                                </div>
                                                <label>Reimburshment Name</label>
                                                <div class="col-md-12 mb-3">
                                                    <input type="text" name="reimburshment_name" class="form-control"
                                                        placeholder="Reimburshment Name" />
                                                </div>
                                                <label>Description</label>
                                                <div class="col-md-12 mb-3">
                                                    <textarea name="description" class="editor"></textarea>
                                                </div>
                                                <label>Support File</label>
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

    <script>
        $(document).ready(function() {
            $(".editor").summernote({
                // height: 150, // set editor height
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
                    modal: $('.' + form.data('modal')).modal('hide'),
                    reload: false,
                    processData: false,
                    contentType: false,
                }
                ajaxSaveDatas(arr_params)
                $('.editor').summernote('code', '');
            });
            const isStaff = "{{ auth()->user()->hasRoles('staff') }}";
            const isDirektur = "{{ auth()->user()->hasRoles('direktur') }}";
            const isFinance = "{{ auth()->user()->hasRoles('finance') }}";
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
                    targets: [(isStaff ? 3 : 6)],
                    data: 'status',
                    render: function(data, type, full, meta) {
                        if (data == 'on_progress') {
                            return `<span class="badge bg-light-primary rounded-3 py-2 text-primary fw-semibold fs-2 d-inline-flex align-items-center gap-1"><i class="ti ti-reload fs-4"></i>On Progress</span>`
                        } else if (data == 'accept') {
                            return `<span class="badge bg-light-success rounded-3 py-2 text-success fw-semibold fs-2 d-inline-flex align-items-center gap-1"><i class="ti ti-check fs-4"></i>Accepted</span>`
                        } else if (data == 'reject') {
                            return `<span class="badge bg-light-danger rounded-3 py-2 text-danger fw-semibold fs-2 d-inline-flex align-items-center gap-1"><i class="ti ti-close fs-4"></i>Rejected</span>`
                        } else if (data == 'done') {
                            return `<span class="badge bg-success rounded-3 fw-semibold fs-2">Done</span>`
                        }
                    }
                },
                {
                    targets: [(isStaff ? 4 : 7)],
                    data: 'link',
                    render: function(data, type, full, meta) {
                        return `<a href="#detailProject" data-bs-toggle="modal" data-bs-target="#detailModal" class="btn btn-info" data-description="${full.description}" data-support_file="${window.location.origin + '/' + full.support_file}" ><i class="fas fa-eye"></i> Tap to View</a>`
                    }
                },
                {
                    targets: [(isStaff ? 5 : 8)],
                    width: '300px',
                    data: 'id',
                    render: function(data, type, full, meta) {
                        let token = "{{ csrf_token() }}";
                        if (isStaff) {
                            return `<div class="row w-100">
                           <div class="col-12 d-flex">
                              <a class="btn btn-warning btn-lg mr-1"
                                 href="/reimburshment/${data}/edit" 
                                 
                                 data-id=${data}
                                 data-date="${full.date_of_submission}" data-reimburshment_name="${full.reimburshment_name}"
                                 data-description="${full.description}" data-support_file="${full.support_file}" data-url="/project/${data}"
                                 title="Edit"><i class="fas fa-edit"></i></a>
                              <a class="btn btn-danger btn-lg ml-1"
                                 href="#deleteData" data-delete-url="/reimburshment/${data}" 
                                 onclick="return deleteConfirm(this,'delete')"
                                 title="Delete"><i class="fas fa-trash"></i></a>
                           </div>
                     </div>`
                        } else if (isDirektur) {
                            return `<div class="input-group">
                        <select class="form-select update_status" name="status" required data-id="${data}" data-token="${token}">
                          <option ${full.status == 'on_progress' ? 'selected' : ''} value="on_progress">On Progress</option>
                          <option ${full.status == 'accept' ? 'selected' : ''} value="accept">Accept</option>
                          <option ${full.status == 'reject' ? 'selected' : ''} value="reject">Reject</option>
                        </select>
                     
                      </div>`
                        } else if (isFinance) {
                            if (full.status !== 'done') {
                                return `<div class="input-group">
                        <select class="form-select update_status" name="status" required data-id="${data}" data-token="${token}">
                          <option value="">Choose...</option>
                          <option value="done">Done</option>
                        </select>
                      </div>`
                            } else {
                                return `<span class="badge bg-info rounded-3 fw-semibold fs-2">Finish</span>`
                            }
                        }
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
            $('#detailModal').on('show.bs.modal', function(e) {
                const button = $(e.relatedTarget);
                let file = button.data('support_file');
                if (getFileType(file) == 'document') {
                    $('.detail_support_file').html(
                        `<a href="${file}" class="btn btn-primary" target="_blank">Show File</a>`)
                } else {
                    $('.detail_support_file').html(
                        `<img src="${file}" id="modalImage_detail" class="img-fluid">`);
                }

                $('.description_detail').html(button.data('description'))
            })
            $('.edit-reimburshment').on('show.bs.modal', function(e) {
                const button = $(e.relatedTarget);
                let file = button.data('support_file');
                if (getFileType(file) == 'document') {
                    $('.detail_support_file_edit').html(
                        `<a href="${file}" class="btn btn-primary" target="_blank">Show File</a>`)
                } else {
                    $('.detail_support_file_edit').html(
                        `<img src="${file}" id="modalImage_detail" class="img-fluid">`);
                }
                $('.date_edit').val(button.data('date'))
                $('.reimburshment_name_edit').val(button.data('reimburshment_name'))
                $('.description_edit').summernote('pasteHTML', (button.data('description')));
            });


            $(document).on('change', '.update_status', function() {

                let status = $(this).val();
                if (status == "") {
                    alert("Please select status first!");
                } else {
                    let token = $(this).data('token');
                    let id = $(this).data('id');
                    var arr_params = {
                        url: "{{ route('reimburshment.update-status') }}",
                        method: 'POST',
                        input: {
                            "_token": token,
                            "id": id,
                            "status": status
                        },
                        reload: false,
                        forms: "",
                    }
                    ajaxSaveDatas(arr_params)
                }
            });
        });
    </script>
    {{-- <script src="../../dist/js/datatable/datatable-api.init.js"></script> --}}
@endpush
