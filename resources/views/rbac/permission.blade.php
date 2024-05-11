@extends('layouts.index')

@push('style')
    <!-- Datatable css -->
    <!-- --------------------------------------------------- -->
    <link rel="stylesheet" href="../../dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../../dist/libs/sweetalert2/dist/sweetalert2.min.css">
@endpush
@section('title')
    Data Permissions
@endsection
@section('main')
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Data Permissions</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Permissions</li>
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
                                Permissions Users
                            </h5>
                        </div>
                        <div class="d-flex justify-content-end">

                            <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal"
                                data-bs-target=".add-permissions">
                                Add New Permissions
                            </button>

                        </div>
                        <!-- Add permissions Popup Model -->
                        <div id="scroll-long-outer-modal" class="modal fade in add-permissions" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <form class="form-horizontal form-material" id="form_store_permissions"
                                        action="{{ route('permissions.store') }}" method="POST" data-modal="add-permissions">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title" id="myModalLabel">
                                                Add New Permission
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            @csrf
                                            <div class="form-group">

                                                <label>Permission Name</label>
                                                <div class="col-md-12 mb-3">
                                                    <input type="text" name="name" class="form-control"
                                                        placeholder="permissions Name" required />
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
                        <!-- Edit permissions Popup Model -->
                        <div id="scroll-long-outer-modal" class="modal fade in edit-permissions" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <form class="form-horizontal form-material" id="form_update_permissions" action="#"
                                        method="POST" data-modal="edit-permissions">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title" id="myModalLabel">
                                                Edit
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            @csrf
                                            <div class="form-group">

                                                <label>Permission Name</label>
                                                <div class="col-md-12 mb-3">
                                                    <input type="text" name="name" class="form-control name_edit"
                                                        placeholder="permissions Name" required />
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
                                        <input type="hidden" name="id" class="id_edit">
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
                                        <th>Name</th>
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

            $('#form_store_permissions').submit(function(e) {
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

            $('#form_update_permissions').submit(function(e) {
                e.preventDefault();
                // alert($(this).data('modal'))

                let form = $(this);
                var id = $('.id_edit').val();
                var url = "{{ route('permissions.update', ['permission' => ':id']) }}";
                url = url.replace(':id', id);

                var arr_params = {
                    url: url,
                    method: 'PUT',
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
                    data: 'name'
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
                    targets: [2],

                    data: 'id',
                    render: function(data, type, full, meta) {
                        var permissions = JSON.stringify(full.permissions);
                        return `<div class="row w-100">
                           <div class="col-12 d-flex">
                              <a class="btn btn-warning btn-lg mr-1"
                                 href="/permissions/${data}/edit"
                                 data-bs-toggle="modal" data-bs-target=".edit-permissions" data-id="${data}"
                                 data-name="${full.name}"
                                 title="Edit"><i class="fas fa-edit"></i></a>
                              <a class="btn btn-danger btn-lg ml-1"
                                 href="#deleteData" data-delete-url="/permissions/${data}" 
                                 onclick="return deleteConfirm(this,'delete')"
                                 title="Delete"><i class="fas fa-trash"></i></a>
                           </div>
                     </div>`
                    }
                },
            ];
            var arrayParams = {
                idTable: '#table-1',
                urlAjax: "{{ url()->current() }}",
                columns: dataColumns,
                defColumn: columnDef,

            }
            loadAjaxDataTables(arrayParams);
            // table.on('xhr', function() {
            //     jsonTables = table.ajax.json();
            //     // console.log( jsonTables.data[350]["id"] +' row(s) were loaded' );
            // });
            $('.edit-permissions').on('show.bs.modal', function(e) {
                const button = $(e.relatedTarget);
                $('.id_edit').val(button.data('id'))
                $('.name_edit').val(button.data('name'))
            });

        });
    </script>
    {{-- <script src="../../dist/js/datatable/datatable-api.init.js"></script> --}}
@endpush
