@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="admin-heading">الملف الشخصي للطالب</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>رقم التسجيل</th>
                                    <td>{{ $student->matricule }}</td>
                                </tr>
                                <tr>
                                    <th>اسم الطالب</th>
                                    <td>{{ $student->name }}</td>
                                </tr>
                                <tr>
                                    <th>رقم الهاتف</th>
                                    <td>{{ $student->phone }}</td>
                                </tr>
                                <tr>
                                    <th>البريد الإلكتروني</th>
                                    <td>{{ $student->email }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 