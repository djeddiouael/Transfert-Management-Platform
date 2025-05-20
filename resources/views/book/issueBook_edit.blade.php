@extends('layouts.app')
@section('content')

    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">{{ __('book.return_book') }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <div class="a">
                        <table cellpadding="10px" width="90%" style="margin: 0 0 20px;">
                            <tr>
                                <td>{{ __('book.student') }}: </td>
                                <td><b>{{ $book->student->name }}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('book.name') }}: </td>
                                <td><b>{{ $book->book->name }}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('book.phone') }}: </td>
                                <td><b>{{ $book->student->phone }}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('book.email') }}: </td>
                                <td><b>{{ $book->student->email }}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('book.issue_date') }}: </td>
                                <td><b>{{ $book->issue_date->format('d M, Y') }}</b></td>
                            </tr>
                            <tr>
                                <td>{{ __('book.return_date') }}: </td>
                                <td><b>{{ $book->return_date->format('d M, Y') }}</b></td>
                            </tr>
                            @if ($book->issue_status == 'Y')
                                <tr>
                                    <td>{{ __('book.status') }}: </td>
                                    <td><b>{{ __('book.returned') }}</b></td>
                                </tr>
                                <tr>
                                    <td>{{ __('book.returned_at') }}: </td>
                                    <td><b>{{ $book->return_day->format('d M, Y') }}</b></td>
                                </tr>
                            @else
                                @if (date('Y-m-d') > $book->return_date->format('Y-m-d'))
                                    <tr>
                                        <td>{{ __('book.fine') }}: </td>
                                        <td>Rs. {{ $fine }}</td>
                                    </tr>
                                @endif
                            @endif
                        </table>

                        @if ($book->issue_status == 'N')
                            <form action="{{ route('book_issue.update', $book->id) }}" method="post" autocomplete="off">
                                @csrf
                                <input type='submit' class='btn btn-danger' name='save' value='{{ __('book.return_book') }}'>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
