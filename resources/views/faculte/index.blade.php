@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Liste des Facultés</h2>
                </div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('publisher.create') }}">Ajouter une Faculté</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="message"></div>
                    <table class="content-table ">
                        <thead class="thead-dark">
                            {{-- <th>S.No</th> --}}
                            <th>Nom des Facultés</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </thead>
                        <tbody>
                            @forelse ($publishers as $publisher)
                                <tr>
                                    {{-- <td>{{ $publisher->id }}</td> --}}
                                    <td>{{ $publisher->name }}</td>
                                    <td class="edit">
                                        <a href="{{ route('publisher.edit', $publisher) }}" class="btn btn-warning">Modifier</a>
                                    </td>
                                    <td class="delete">
                                        <form action="{{ route('publisher.destroy', $publisher) }}" method="post"
                                            class="form-hidden">
                                            <button class="btn btn-danger delete-author">Supprimer</button>
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Aucune Faculté Trouvée</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $publishers->links('vendor/pagination/bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
