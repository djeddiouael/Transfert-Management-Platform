@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Mettre à jour la Faculté</h2>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <form class="a" action="{{ route('publisher.update', $publisher->id) }}" method="post"
                    autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label>Nom de la Faculté</label>
                        <input type="text" class="form-control @error('name') isinvalid @enderror" name="name"
                            value="{{ $publisher->name }}" required>
                        @error('name')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <input type="submit" name="submit" class="btn btn-danger" value="Mettre à jour" required>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
