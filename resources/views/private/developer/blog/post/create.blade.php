@extends('private.templates.layout')

@section('header')
    posting baru
@endsection

@section('container')
    <x-button-link href="{{ route(Request::segment(1) . '.blog.post.index') }}" label="kembali"
        class="rounded-pill btn btn-md btn-outline-primary mb-3" icon="fa-fw fas fa-arrow-left" />

    <form action="{{ route(Request::segment(1) . '.blog.post.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-md-9">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row mb-3">
                                <x-form-input-row type="text" name="title" label="judul" value="{{ old('title') }}"
                                    class="col" />
                            </div>
                            <x-form-input-summernote name="content" label="content" value="{{ old('content') }}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form-group text-capitalize">
                                @php
                                    $url = url('assets/images/default-img.svg');
                                @endphp
                                <img src="{{ $url }}" alt="{{ $url }}"
                                    class="img-fluid rounded w-100 mb-3 img-preview">
                                <label for="file" class="form-label">thumbnail</label>
                                <input type="file" name="file" id="file" class="form-control"
                                    accept=".jpg,.jpeg,.png" onchange="previewImg()">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form-group text-capitalize mb-3">
                                <label class="form-label">kategori</label>
                                @foreach ($categories as $category)
                                    <x-form-input-checkbox name="category[]" id="category{{ $category->id }}"
                                        value="{{ $category->id }}">
                                        <label class="form-check-label fw-normal"
                                            for="category{{ $category->id }}">{{ $category->name }}</label>
                                    </x-form-input-checkbox>
                                @endforeach
                            </div>
                            <div class="row">
                                <x-form-input-select name="status" label="status" class="col-12">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" @selected(old('status') == $status->id)>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </x-form-input-select>
                            </div>
                            <x-button-submit label="simpan" class="btn btn-primary" icon="fa-fw fas fa-save" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('/plugins/mazer/assets/css/pages/summernote.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/mazer/assets/extensions/summernote/summernote-lite.css') }}">
@endsection

@section('script')
    <script>
        function previewImg() {
            const cover = document.querySelector('#file');
            const imgPreview = document.querySelector('.img-preview');
            const fileCover = new FileReader();
            fileCover.readAsDataURL(cover.files[0]);
            fileCover.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }
    </script>
    <script src="{{ asset('/plugins/mazer/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/plugins/mazer/assets/extensions/summernote/summernote-lite.min.js') }}"></script>
    <script>
        $('#summernote').summernote({
            tabsize: 2,
            height: 600,
            toolbar: [
                ['view', ['undo', 'redo']],
                ['style', ['style', 'fontname']],
                ['font', ['bold', 'italic', 'underline', 'color']],
                ['para', ['ul', 'ol', 'paragraph', 'strikethrough', 'superscript', 'subscript']],
                ['table', ['table']],
                ['insert', ['hr', 'link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['clear', ['clear']],
            ]
        })
    </script>
@endsection
