@extends('layouts.index')

@push('style')
    <!-- Datatable css -->
    <!-- --------------------------------------------------- -->
    <link rel="stylesheet" href="../../dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="../../dist/libs/summernote/dist/summernote-lite.min.css">
    <link rel="stylesheet" href="../../dist/libs/sweetalert2/dist/sweetalert2.min.css">
@endpush
@section('title')
    Data Vehicle Loan
@endsection
@section('main')
    <!-- detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Vehicle Loan Details</h5>
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
                    <h4 class="fw-semibold mb-8">Data Vehicle Loan</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Vehicle Loan</li>
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
                                {{ auth()->user()->hasRoles('admin') ? 'Your Vehicle Loan' : 'Staff\'s Vehicle Loan Request' }}
                            </h5>
                        </div>
                        <div class="d-flex justify-content-end">
                            @if (auth()->user()->hasRoles('admin'))
                                <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal"
                                    data-bs-target=".add-reimburshment">
                                    Add New Vehicle Loan
                                </button>
                            @endif
                        </div>
                        <!-- Add Vehicle Loan Popup Model -->
                        <div id="scroll-long-outer-modal" class="modal fade in add-reimburshment" tabindex="-1"
                            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <form class="form-horizontal form-material" id="form_store_vehicle-loan"
                                        action="{{ route('vehicle-loan.store') }}" method="POST"
                                        data-modal="dd-reimburshment">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title" id="myModalLabel">
                                                Add New Vehicle Loan
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            @csrf
                                            <div class="form-group">
                                                <label>Stakeholder Name</label>
                                                <div class="col-md-12 mb-3">
                                                    <select class="form-control select2" name="stakeholder_id" required>
                                                        <option value="">Choose Stakeholder....</option>
                                                        @foreach ($stakeholders as $stakeholder)
                                                            <option value="{{ $stakeholder->id }}">{{ $stakeholder->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label>Vehicle Name</label>
                                                <div class="col-md-12 mb-3">
                                                    <select class="form-control select2" name="vehicle_id" required>
                                                        <option value="">Choose Vehicle....</option>
                                                        @foreach ($vehicles as $vehicle)
                                                            <option value="{{ $vehicle->id }}">{{ $vehicle->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label>Notes</label>
                                                <div class="col-md-12 mb-3">
                                                    <textarea name="description" class="editor"></textarea>
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
                                        @if (!auth()->user()->hasRoles('admin'))
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>Position</th>
                                        @endif
                                        <th>Stakeholder Name</th>
                                        <th>Vehicle Name</th>
                                        <th>Status</th>
                                        <th>Notes</th>
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
            $('#form_store_vehicle-loan').submit(function(e) {
                e.preventDefault();
                // alert($(this).data('modal'))

                let form = $(this);
                console.log(form.serialize())
                // var form_data = new FormData($('#form_store_vehicle-loan')[0]);
                var arr_params = {
                    url: form.attr('action'),
                    method: 'POST',
                    input: form.serialize(),
                    forms: form[0],
                    modal: $('.' + form.data('modal')).modal('hide'),
                    reload: false,
                }
                ajaxSaveDatas(arr_params)
                $('.editor').summernote('code', '');
            });
            const isStaff = "{{ auth()->user()->hasRoles('admin') }}";
            const isDirektur = "{{ auth()->user()->hasRoles('direktur') }}";
            const isFinance = "{{ auth()->user()->hasRoles('finance') }}";
            var dataColumns = [{
                    data: 'id'
                },
                {
                    data: 'stakeholder.name'
                },
                {
                    data: 'vehicle.name'
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
                                 href="#deleteData" data-delete-url="/vehicle-loan/${data}" 
                                 onclick="return deleteConfirm(this,'delete')"
                                 title="Delete"><i class="fas fa-trash"></i></a>
                           </div>
                     </div>`
                        } else if (isDirektur) {
                            if (full.status !== 'done') {
                                return `<div class="input-group">
                        <select class="form-select update_status" name="status" required data-id="${data}" data-token="${token}">
                          <option ${full.status == 'on_progress' ? 'selected' : ''} value="on_progress">On Progress</option>
                          <option ${full.status == 'accept' ? 'selected' : ''} value="accept">Accept</option>
                          <option ${full.status == 'reject' ? 'selected' : ''} value="reject">Reject</option>
                        </select>
                     
                      </div>`
                            } else {
                                return `<span class="badge bg-info rounded-3 fw-semibold fs-2">Finish</span>`
                            }
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
                        data: 'stakeholder.name'
                    },
                    {
                        data: 'vehicle.name'
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
                urlAjax: "{{ route('vehicle-loan.get-data') }}",
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
                        url: "{{ route('vehicle-loan.update-status') }}",
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
