@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">{{ __('author.title') }}</h2>
                </div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('authors.create') }}">{{ __('author.create') }}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="message"></div>
                    <table class="table table-hover table-sm table-bordered content-table">
                        <thead class="thead-dark">
                            {{-- <th>S.No</th> --}}
                            <th>{{ __('author.name') }}</th>
                            <th>{{ __('author.actions') }}</th>
                            <th>{{ __('author.actions') }}</th>
                        </thead>
                        <tbody>
                            @forelse ($authors as $auther)
                                <tr>
                                    {{-- <td>{{ $auther->id }}</td> --}}
                                    <td>{{ $auther->name }}</td>
                                    <td class="edit">
                                        <center>
                                            <a href="{{ route('authors.edit', $auther) }}" class="btn btn-warning">{{ __('author.edit') }}</a>
                                        </center>
                                    </td>
                                    <td class="delete">
                                        <form action="{{ route('authors.destroy', $auther->id) }}" method="post" class="form-hidden">
                                            <button class="btn btn-danger delete-author">{{ __('author.delete') }}</button>
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">{{ __('author.no_authors') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $authors->links('vendor/pagination/bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
