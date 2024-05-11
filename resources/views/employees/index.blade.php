@extends('layouts.index')

@push('style')
    <!-- Datatable css -->
    <!-- --------------------------------------------------- -->
    <link rel="stylesheet" href="../../dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../../dist/libs/sweetalert2/dist/sweetalert2.min.css">
@endpush
@section('title') Data Employees @endsection
@section('main')
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Data employees</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Employees</li>
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
                                Your Employees
                            </h5>
                        </div>
                        <div class="d-flex justify-content-end">

                            <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal"
                                data-bs-target=".add-employees">
                                Add New Employee
                            </button>

                        </div>
                        <!-- Add employees Popup Model -->
                        <div id="scroll-long-outer-modal" class="modal fade in add-employees" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <form class="form-horizontal form-material" id="form_store_employees"
                                        action="{{ route('employees.store') }}" method="POST" data-modal="add-employees">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title" id="myModalLabel">
                                                Add New Employee
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            @csrf
                                            <div class="form-group">
                                                <label>NIP</label>
                                                <div class="col-md-12 mb-3">
                                                    <input type="number" name="nip" class="form-control"
                                                        placeholder="NIP" required />
                                                </div>
                                                <label>Employees Name</label>
                                                <div class="col-md-12 mb-3">
                                                    <input type="text" name="name" class="form-control"
                                                        placeholder="employees Name" required />
                                                </div>
                                                <label>Job Title</label>
                                                <div class="col-md-12 mb-3">
                                                    <input type="text" name="job_title" class="form-control"
                                                        placeholder="Job title" required />
                                                </div>
                                                <label>Password</label>
                                                <div class="col-md-12 mb-3">
                                                    <input type="password" name="password" class="form-control"
                                                        placeholder="Password" required/>
                                                </div>
                                                <label>Confirm Password</label>
                                                <div class="col-md-12 mb-3">
                                                    <input type="password" name="password_confirmation"
                                                        class="form-control" placeholder="Password" required />
                                                </div>
                                                <label>Role User</label>
                                                <div class="col-md-12 mb-3">
                                                    <select class="form-select update_status" name="role" required>
                                                        <option value="">Choose Role...</option>
                                                        <option value="finance">Finance</option>
                                                        <option value="staff">Staff</option>
                                                    </select>
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
                                        <th>NIP</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Roles User</th>
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
    <script src="../../dist/libs/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="../../dist/js/datatable/index.js"></script>

    <script>
        $(document).ready(function() {

            $('#form_store_employees').submit(function(e) {
                e.preventDefault();
                // alert($(this).data('modal'))

                let form = $(this);
                var arr_params = {
                    url: form.attr('action'),
                    method: 'POST',
                    input: form.serialize(),
                    forms: form[0],
                    modal: $('.' + form.data('modal')).modal('hide'),
                    reload: false,
                }
                ajaxSaveDatas(arr_params)
            });

            var dataColumns = [{
                    data: 'id'
                },
                {
                    data: 'nip'
                },
                {
                    data: 'name'
                },
                {
                    data: 'job_title'
                },
                {
                    data: 'roles[0].name'
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
                    targets: [4],
                    render: function(data, type, full, meta) {
                        if (data == 'staff') {
                            return `<span class="badge bg-light-primary rounded-3 py-2 text-primary fw-semibold fs-2 d-inline-flex align-items-center gap-1"><i class="ti ti-circle fs-4"></i>Staff</span>`
                        } else if (data == 'finance') {
                            return `<span class="badge bg-light-success rounded-3 py-2 text-success fw-semibold fs-2 d-inline-flex align-items-center gap-1"><i class="ti ti-circle fs-4"></i>Finance</span>`
                        }
                    }
                },
                {
                    targets: [5],

                    data: 'id',
                    render: function(data, type, full, meta) {
                        return `<div class="row w-100">
                           <div class="col-12 d-flex">
                              <a class="btn btn-warning btn-lg mr-1"
                                 href="/employees/${data}/edit" 
                                 data-id=${data}
                                 data-date="${full.date_of_submission}" data-employees_name="${full.employees_name}"
                                 data-description="${full.description}" data-support_file="${full.support_file}" data-url="/project/${data}"
                                 title="Edit"><i class="fas fa-edit"></i></a>
                              <a class="btn btn-danger btn-lg ml-1"
                                 href="#deleteData" data-delete-url="/employees/${data}" 
                                 onclick="return deleteConfirm(this,'delete')"
                                 title="Delete"><i class="fas fa-trash"></i></a>
                           </div>
                     </div>`
                    }
                },
            ];
            var arrayParams = {
                idTable: '#table-1',
                urlAjax: "{{ route('employees.get-data') }}",
                columns: dataColumns,
                defColumn: columnDef,

            }
            loadAjaxDataTables(arrayParams);
            // table.on('xhr', function() {
            //     jsonTables = table.ajax.json();
            //     // console.log( jsonTables.data[350]["id"] +' row(s) were loaded' );
            // });

        });
    </script>
    {{-- <script src="../../dist/js/datatable/datatable-api.init.js"></script> --}}
@endpush
