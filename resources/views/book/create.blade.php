@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">{{ __('book.create') }}</h2>
                </div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('books') }}">{{ __('book.list') }}</a>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-1 col-md-10">
                    <form class="" action="{{ route('book.store') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('book.isbn') }}</label>
                                    <input type="text" class="form-control @error('CLE') isinvalid @enderror"
                                        placeholder="{{ __('book.enter_isbn') }}" name="CLE" value="{{ old('CLE') }}" required>
                                    @error('CLE')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('book.name') }}</label>
                                    <input type="text" class="form-control @error('name') isinvalid @enderror"
                                        placeholder="{{ __('book.enter_name') }}" name="name" value="{{ old('name') }}" required>
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
                                    <label>{{ __('book.category') }}</label>
                                    <select class="form-control @error('category_id') isinvalid @enderror " name="category_id" required>
                                        <option value="">{{ __('book.select_category') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('book.author') }}</label>
                                    <select class="form-control @error('auther_id') isinvalid @enderror " name="auther_id" required>
                                        <option value="">{{ __('book.select_author') }}</option>
                                        @foreach ($authors as $author)
                                            <option value='{{ $author->id }}'>{{ $author->name }}</option>";
                                        @endforeach
                                    </select>
                                    @error('auther_id')
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
                                    <label>{{ __('book.publisher') }}</label>
                                    <select class="form-control @error('publisher_id') isinvalid @enderror " name="publisher_id" required>
                                        <option value="">{{ __('book.select_publisher') }}</option>
                                        @foreach ($publishers as $publisher)
                                            <option value='{{ $publisher->id }}'>{{ $publisher->name }}</option>";
                                        @endforeach
                                    </select>
                                    @error('publisher_id')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>{{ __('book.quantity') }}</label>
                                        <input type="number"
                                               class="form-control @error('copies_number') isinvalid @enderror"
                                               placeholder="{{ __('book.enter_quantity') }}"
                                               name="copies_number"
                                               value="{{ old('copies_number') }}"
                                               required>
                                        @error('copies_number')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>{{ __('book.keywords') }}</label>
                                        <input type="text"
                                               class="form-control @error('keywords') isinvalid @enderror"
                                               placeholder="{{ __('book.enter_keywords') }}"
                                               name="keywords"
                                               value="{{ old('keywords') }}"
                                               required>
                                        @error('keywords')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>{{ __('book.status') }}</label>
                                        <select class="form-control @error('status') isinvalid @enderror " name="status">
                                            <option value="Y">{{ __('book.active') }}</option>
                                            <option value="N">{{ __('book.inactive') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="submit" name="save" class="btn btn-danger" value="{{ __('book.save') }}" required>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
