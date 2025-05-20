@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">{{ __('Domaine.list') }}</h2>
                </div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('category.create') }}">{{ __('Domaine.create') }}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="message"></div>
                    <table class="content-table">
                        <thead>
                            <th>{{ __('Domaine.id') }}</th>
                            <th>{{ __('Domaine.name') }}</th>
                            <th>{{ __('Domaine.status') }}</th>
                            <th>{{ __('Domaine.actions') }}</th>
                            <th>{{ __('Domaine.actions') }}</th>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if ($category->status == '1')
                                            <span class='badge badge-success'>{{ __('category.active') }}</span>
                                        @else
                                            <span class='badge badge-danger'>{{ __('category.inactive') }}</span>
                                        @endif
                                    </td>
                                    <td class="edit">
                                        <a href="{{ route('category.edit', $category) }}" class="btn btn-warning">{{ __('category.edit') }}</a>
                                    </td>
                                    <td class="delete">
                                        <form action="{{ route('category.destroy', $category) }}" method="post"
                                            class="form-hidden">
                                            <button class="btn btn-danger delete-author">{{ __('category.delete') }}</button>
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">{{ __('category.no_categories') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $categories->links('vendor/pagination/bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
