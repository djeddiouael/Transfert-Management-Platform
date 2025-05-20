@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tableau de Bord Étudiant</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h4>Statut de votre Demande de Transfert</h4>
                        @if($transferRequest = auth()->user()->transferRequest)
                            <div class="alert alert-{{ 
                                $transferRequest->status == 'accepted' ? 'success' : 
                                ($transferRequest->status == 'rejected' ? 'danger' : 'warning') 
                            }}">
                                <h5 class="alert-heading">
                                    @if($transferRequest->status == 'pending')
                                        Votre demande est en cours de traitement
                                    @elseif($transferRequest->status == 'accepted')
                                        Félicitations ! Votre demande a été acceptée
                                    @else
                                        Votre demande a été rejetée
                                    @endif
                                </h5>
                                @if($transferRequest->admin_notes)
                                    <p class="mb-0">{{ $transferRequest->admin_notes }}</p>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-info">
                                <p>Vous n'avez pas encore soumis de demande de transfert.</p>
                                <a href="{{ route('transfer.form') }}" class="btn btn-primary">Soumettre une demande</a>
                            </div>
                        @endif
                    </div>

                    <!-- Autres sections du dashboard -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 