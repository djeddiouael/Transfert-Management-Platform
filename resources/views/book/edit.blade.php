@extends('layouts.app')
@section('content')

    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">{{ __('book.edit') }}</h2>
                </div>

            </div>
            <div class="row">
                <div class="offset-md-1 col-md-10">
                    <form class="a" action="{{ route('book.update', $book->id) }}" method="post"
                        autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('book.isbn') }}</label>
                                    <input type="text" class="form-control @error('CLE') isinvalid @enderror"
                                        placeholder="{{ __('book.enter_isbn') }}" name="CLE" value="{{ $book->CLE }}" required>
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
                                        placeholder="{{ __('book.enter_name') }}" name="name" value="{{ $book->name }}">
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
                                    <select class="form-control @error('category_id') isinvalid @enderror " name="category_id">
                                        <option value="">{{ __('book.select_category') }}</option>
                                        @foreach ($categories as $category)
                                            @if ($category->id == $book->category_id)
                                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                            @else
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endif
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
                                    <select class="form-control @error('auther_id') isinvalid @enderror " name="author_id">
                                        <option value="">{{ __('book.select_author') }}</option>
                                        @foreach ($authors as $auther)
                                            @if ($auther->id == $book->auther_id)
                                                <option value="{{ $auther->id }}" selected>{{ $auther->name }}</option>
                                            @else
                                                <option value="{{ $auther->id }}">{{ $auther->name }}</option>
                                            @endif
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
                                    <select class="form-control @error('publisher_id') isinvalid @enderror " name="publisher_id">
                                        <option value="">{{ __('book.select_publisher') }}</option>
                                        @foreach ($publishers as $publisher)
                                            @if ($publisher->id == $book->publisher_id)
                                                <option value="{{ $publisher->id }}" selected>{{ $publisher->name }}</option>
                                            @else
                                                <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                                            @endif
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
                                               value="{{ $book->copies_number }}"
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
                                        <label>{{ __('keywords') }}</label>
                                        {{-- <label>{{ __('book.keywords') }}</label> --}}
                                        <input type="text"
                                               class="form-control @error('keywords') isinvalid @enderror"
                                               placeholder="{{ __('book.enter_keywords') }}"
                                               name="keywords"
                                               value="{{ $book->keywords }}"
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
                                            <option value="Y" {{$book->status == '1' ? 'selected' : ''}}>{{ __('active') }}</option>
                                            {{-- <option value="Y" {{$book->status == '1' ? 'selected' : ''}}>{{ __('book.active') }}</option> --}}

                                            <option value="N" {{$book->status == '0' ? 'selected' : ''}}>{{ __('inactive') }}</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <input type="submit" name="save" class="btn btn-danger" value="{{ __('update') }}">
                        {{-- <input type="submit" name="save" class="btn btn-danger" value="{{ __('book.update') }}"> --}}

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
