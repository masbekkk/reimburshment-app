@extends('layouts.index')

@push('style')
    <link rel="stylesheet" href="../../dist/libs/sweetalert2/dist/sweetalert2.min.css">
@endpush
@section('title') Edit Employees @endsection
@section('main')
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Edit Employee</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted "
                                    href="{{ route('employees.index') }}">Employees</a></li>
                            <li class="breadcrumb-item" aria-current="page">Edit Employee</li>
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
    <section>
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal form-material" id="form_update_employees"
                    action="{{ route('employees.update', ['employee' => $user->id]) }}" method="POST"
                    data-modal="edit-employees">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label>NIP</label>
                        <div class="col-md-12 mb-3">
                            <input type="number" name="nip" class="form-control" placeholder="NIP"
                                value="{{ $user->nip }}" required />
                        </div>
                        <label>Employees Name</label>
                        <div class="col-md-12 mb-3">
                            <input type="text" name="name" class="form-control" placeholder="employees Name"
                                value="{{ $user->name }}" required />
                        </div>
                        <label>Job Title</label>
                        <div class="col-md-12 mb-3">
                            <input type="text" name="job_title" class="form-control" placeholder="Job title"
                                value="{{ $user->job_title }}" required />
                        </div>
                        <label>Password</label>
                        <div class="col-md-12 mb-3">
                            <span class="badge bg-warning mb-3">*Input Password Only When You Wanna Change Password</span>
                            <input type="password" name="password" class="form-control" placeholder="Password" />
                        </div>
                        <label>Confirm Password</label>
                        <div class="col-md-12 mb-3">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Password" />
                        </div>
                        <label>Role User</label>
                        <div class="col-md-12 mb-3">
                            <select class="form-select update_status" name="role" required>
                                <option value="">Choose Role...</option>
                                @foreach ($roles as $role)
                                    <option {{($user->roles[0]->name === $role->name ? 'selected' : '') }} value="{{ $role->name }}">{{ ucwords($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info waves-effect btn-lg">
                        Update
                    </button>
                </form>
            </div>
    </section>
@endsection

@push('scripts')
    <script src="../../dist/libs/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="../../dist/js/datatable/index.js"></script>
    <script>
        $(document).ready(function() {

            $('#form_update_employees').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                var arr_params = {
                    url: form.attr('action'),
                    method: 'PUT',
                    input: form.serialize(),
                    forms: form[0],
                    reload: false,
                    redirect: "{{ route('employees.index') }}",
                }
                ajaxSaveDatas(arr_params)
            });
        })
    </script>
@endpush
