@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        حالة طلب التحويل
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Status Alert -->
                    <div class="alert alert-{{ 
                        $transferRequest->status == 'accepted' ? 'success' : 
                        ($transferRequest->status == 'rejected' ? 'danger' : 'warning') 
                    }} mb-4" dir="rtl">
                        <h4 class="alert-heading">{{ $statusInfo['title'] }}</h4>
                        <p>{{ $statusInfo['message'] }}</p>
                        <hr>
                        <p class="mb-0">{{ $statusInfo['details'] }}</p>
                    </div>

                    <!-- Request Details -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="mb-0">تفاصيل الطلب</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>المؤسسة الحالية:</strong> {{ $transferRequest->current_institution }}</p>
                                    <p><strong>التكوين الحالي:</strong> {{ $transferRequest->current_formation }}</p>
                                    <p><strong>السنة الدراسية:</strong> {{ $transferRequest->current_year }}</p>
                                    <p><strong>المعدل:</strong> {{ $transferRequest->average_grade }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>التخصص:</strong> {{ $transferRequest->specialization }}</p>
                                    <p><strong>التكوين المطلوب:</strong> {{ $transferRequest->desired_formation }}</p>
                                    <p><strong>تاريخ الطلب:</strong> {{ $transferRequest->request_date->format('Y-m-d') }}</p>
                                    @if($transferRequest->confirmation_date)
                                        <p><strong>تاريخ التأكيد:</strong> {{ $transferRequest->confirmation_date->format('Y-m-d') }}</p>
                                    @endif
                                    <p><strong>تاريخ آخر تحديث:</strong> {{ $transferRequest->updated_at->format('Y-m-d') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">الوثائق المرفقة</h4>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="{{ route('transfer-request.download', ['transferRequest' => $transferRequest, 'documentType' => 'transcript']) }}" 
                                   class="list-group-item list-group-item-action">
                                    <i class="fas fa-file-pdf me-2"></i>
                                    كشف النقاط
                                </a>
                                <a href="{{ route('transfer-request.download', ['transferRequest' => $transferRequest, 'documentType' => 'cv']) }}" 
                                   class="list-group-item list-group-item-action">
                                    <i class="fas fa-file-pdf me-2"></i>
                                    السيرة الذاتية
                                </a>
                                <a href="{{ route('transfer-request.download', ['transferRequest' => $transferRequest, 'documentType' => 'motivation_letter']) }}" 
                                   class="list-group-item list-group-item-action">
                                    <i class="fas fa-file-pdf me-2"></i>
                                    رسالة الدافع
                                </a>
                                <a href="{{ route('transfer-request.download', ['transferRequest' => $transferRequest, 'documentType' => 'id_document']) }}" 
                                   class="list-group-item list-group-item-action">
                                    <i class="fas fa-file-pdf me-2"></i>
                                    بطاقة الهوية
                                </a>
                                @if($transferRequest->certificates_paths)
                                    @foreach($transferRequest->certificates_paths as $index => $certificate)
                                        <a href="{{ route('transfer-request.download', ['transferRequest' => $transferRequest, 'documentType' => 'certificates', 'index' => $index]) }}" 
                                           class="list-group-item list-group-item-action">
                                            <i class="fas fa-file-pdf me-2"></i>
                                            شهادة {{ $index + 1 }}
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,.1);
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    
    .list-group-item {
        border-radius: 4px;
        margin-bottom: 4px;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    
    [dir="rtl"] {
        text-align: right;
    }
</style>
@endsection 