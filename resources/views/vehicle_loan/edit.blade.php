@extends('layouts.index')

@push('style')
    <link rel="stylesheet" href="../../dist/libs/summernote/dist/summernote-lite.min.css">
    <link rel="stylesheet" href="../../dist/libs/sweetalert2/dist/sweetalert2.min.css">
@endpush
@section('title') Edit Reimburshment @endsection
@section('main')
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Edit Reimburshment</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted " href="{{ route('reimburshment.index')}}">Reimburshment</a></li>
                            <li class="breadcrumb-item" aria-current="page">Edit Reimburshment</li>
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
                <form action="{{ route('reimburshment.update', ['reimburshment' => $reimburshment->id]) }}" method="POST"
                    enctype="multipart/form-data" id="form_update_reimburshment">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label>Date Of Submission</label>
                        <div class="col-md-12 mb-3">
                            <input type="date" name="date_of_submission" class="form-control date_edit"
                                placeholder="date of submission" value="{{ $reimburshment->date_of_submission }}" />
                        </div>
                        <label>Reimburshment Name</label>
                        <div class="col-md-12 mb-3">
                            <input type="text" name="reimburshment_name" class="form-control reimburshment_name_edit"
                                placeholder="Reimburshment Name" value="{{ $reimburshment->reimburshment_name }}" />
                        </div>
                        <label>Description</label>
                        <div class="col-md-12 mb-3">
                            <textarea name="description" class="description_edit editor">{{ $reimburshment->description }}</textarea>
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
                                <input type="file" class="upload" name="support_file" id="suppor_file" />
                            </div>
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
            let file = "{{ url($reimburshment->support_file) }}";
            if (getFileType(file) == 'document') {
                $('.detail_support_file_edit').html(
                    `<a href="${file}" class="btn btn-primary" target="_blank">Show File</a>`)
            } else {
                $('.detail_support_file_edit').html(`<img src="${file}" id="modalImage_detail" class="img-fluid">`);
            }

            $('#form_update_reimburshment').submit(function(e) {
            e.preventDefault();
            // alert($(this).data('modal'))
            let file = $('#support_file').val();
            console.log();
            let form = $(this);
            var form_data = new FormData($('#form_update_reimburshment')[0]);
            var arr_params = {
                url: form.attr('action'),
                method: 'PUT',
                input: file != null ? form_data : form.serialize(),
                forms: form[0],
                reload: false,
                processData: file != null ? false : true,
                contentType: file != null ? false : 'application/x-www-form-urlencoded',
                redirect: "{{ route('reimburshment.index')}}",
            }
            ajaxSaveDatas(arr_params)
        });
        })
    </script>
@endpush
