@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">{{ __('book.issue_book') }}</h2>
                </div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('book_issued') }}">{{ __('book.issued_books') }}</a>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <form class="a" action="{{ route('book_issue.create') }}" method="post"
                        autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('book.student') }}</label>
                            <select class="form-control" name="student_id" required>
                                <option value="">{{ __('book.select_student') }}</option>
                                @foreach ($students as $student)
                                    <option value='{{ $student->id }}'>{{ $student->name }}</option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('book.name') }}</label>
                            <select class="form-control" name="book_id" required>
                                <option value="">{{ __('book.select_book') }}</option>
                                @foreach ($books as $book)
                                    <option value='{{ $book->id }}'>{{ $book->name }}</option>
                                @endforeach
                            </select>
                            @error('book_id')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="submit" name="save" class="btn btn-danger" value="{{ __('book.save') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
