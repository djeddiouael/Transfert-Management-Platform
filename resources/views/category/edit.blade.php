@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">تحديث الميدان التعليمي</h2>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-1 col-md-10">
                <form class="a" action="{{ route('category.update', $category->id) }}" method="post"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>حالة</label>
                                    <select class="form-control @error('status') isinvalid @enderror " name="status"
                                    >
                                    {{-- <option value="">Select اسم ميدان التعليمي</option> --}}
                                            <option value="1" {{$category->status == '1' ? 'selected' : ''}}>نشط</option>
                                            <option value="0" {{$category->status == '0' ? 'selected' : ''}}>غير نشط</option>

                                </select>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>اسم ميدان التعليمي</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ $category->name }}" required>
                                @error('name')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>رابط الموقع</label>
                                <input type="url" class="form-control @error('website') is-invalid @enderror" name="website"
                                    value="{{ $category->website }}" >
                                @error('website')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>رابط فيسبوك</label>
                                <input type="text" class="form-control @error('facebook') is-invalid @enderror" name="facebook"
                                    value="{{ $category->facebook }}" >
                                @error('facebook')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>رابط تيليجرام</label>
                                <input type="text" class="form-control @error('telegram') is-invalid @enderror" name="telegram"
                                    value="{{ $category->telegram }}" >
                                @error('telegram')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>رابط الدورة</label>
                                <input type="text" class="form-control @error('course_link') is-invalid @enderror" name="course_link"
                                    value="{{ $category->course_link }}" >
                                @error('course_link')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>صورة</label>
                                <input type="file" id="imageInput" class="form-control @error('image') is-invalid @enderror"
                                       name="image">
                                @error('image')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <img id="imagePreview" src="{{ asset('front/specialities/' . $category->image) }}" style="margin-top: 10px; max-width: 190px; height: auto;">
                        </div>
                    </div>




                    <script>
                        document.getElementById('imageInput').addEventListener('change', function(event) {
                            const file = event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    document.getElementById('imagePreview').src = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>
                    <input type="submit" name="submit" class="btn btn-danger" value="تحديث" >
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
