@extends('layouts.app')
@section('content')

    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">{{ __('book.list') }}</h2>
                </div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('book.create') }}">{{ __('book.create') }}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="message"></div>
                    <table class="content-table">
                        <thead>
                            <th>{{ __('book.isbn') }}</th>
                            <th>{{ __('book.name') }}</th>
                            <th>{{ __('book.category') }}</th>
                            <th>{{ __('book.author') }}</th>
                            <th>{{ __('book.publisher') }}</th>
                            <th>{{ __('book.status') }}</th>
                            <th>{{ __('book.actions') }}</th>
                            <th>{{ __('book.actions') }}</th>
                        </thead>
                        <tbody>
                            @forelse ($books as $book)
                                <tr>
                                    <td class="id">{{ $book->CLE }}</td>
                                    <td>{{ $book->name }}</td>
                                    <td>{{ $book->category ? $book->category->name : 'N/A' }}</td>
                                    <td>{{ $book->auther ? $book->auther->name : 'N/A' }}</td>
                                    <td>{{ $book->publisher ? $book->publisher->name : 'N/A' }}</td>
                                    <td>
                                        @if ($book->status == 'Y' && $book->copies_number > 0)
                                            <span class='badge badge-success'>{{ __('book.available') }}</span>
                                           ({{ $book->copies_number }})
                                        @else
                                            <span class='badge badge-danger'>{{ __('book.unavailable') }}</span>
                                        @endif
                                    </td>
                                    <td class="edit">
                                        <a href="{{ route('book.edit', $book) }}" class="btn btn-warning">{{ __('book.edit') }}</a>
                                    </td>
                                    <td class="delete">
                                        <form action="{{ route('book.destroy', $book) }}" method="post"
                                            class="form-hidden">
                                            <button class="btn btn-danger delete-book">{{ __('book.delete') }}</button>
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">{{ __('book.no_books') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $books->links('vendor/pagination/bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

@endsection
