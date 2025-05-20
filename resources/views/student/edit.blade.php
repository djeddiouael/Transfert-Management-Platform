@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Mettre à jour l'étudiant</h2>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <form class="a" action="{{ route('student.update', $student->id) }}" method="post"
                        autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label>Numéro d'enregistrement</label>
                            <input type="number" class="form-control" placeholder="Numéro d'enregistrement" name="matricule"
                                value="{{ $student->matricule }}" required>
                            @error('matricule')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nom de l'étudiant</label>
                            <input type="text" class="form-control" placeholder="Nom de l'étudiant" name="name"
                                value="{{ $student->name }}" required>
                            @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" placeholder="Address" name="address"
                                value="{{ $student->address }}" required>
                            @error('address')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        {{-- <div class="form-group">
                            <label>Gender</label>
                            <select name="gender" class="form-control">
                                @if ($student->gneder == 'male')
                                    <option value="male" selected>Male</option>
                                @else
                                    <option value="female" selected>Female</option>
                                @endif
                            </select>
                            @error('gender')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        {{-- <div class="form-group">
                            <label>Class</label>
                            <input type="text" class="form-control" placeholder="Class" name="class"
                                value="{{ $student->class }}" required>
                            @error('class')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        {{-- <div class="form-group">
                            <label>Age</label>
                            <input type="number" class="form-control" placeholder="Age" name="age"
                                value="{{ $student->age }}" required>
                            @error('age')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <label>Numéro de téléphone</label>
                            <input type="phone" class="form-control" placeholder="Numéro de téléphone" name="phone"
                                value="{{ $student->phone }}" required>
                            @error('phone')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Email" name="email"
                                value="{{ $student->email }}" required>
                            @error('email')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="submit" name="save" class="btn btn-danger" value="Mettre à jour">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
