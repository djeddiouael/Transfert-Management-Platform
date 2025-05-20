<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('transfer.title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/demende.css') }}">
    <style>
        .transfer-type-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .transfer-type-card .card {
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .transfer-type-card:hover .card {
            border-color: #0d6efd;
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .transfer-type-card.selected .card {
            border-color: #0d6efd;
            background-color: #f8f9ff;
        }
        
        .transfer-type-card i {
            color: #0d6efd;
        }
        
        .transfer-type-card h5 {
            margin: 15px 0;
            color: #212529;
        }
        
        .transfer-type-card p {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header-banner">
        <div class="container">
            <div class="header-content">
                <div class="dropdown language-switcher">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i> <!-- 3 points verticaux -->
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('language.switch', ['locale' => 'en']) }}">
                                <i class="fas fa-globe"></i> English
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() == 'fr' ? 'active' : '' }}" href="{{ route('language.switch', ['locale' => 'fr']) }}">
                                <i class="fas fa-globe"></i> Français
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}" href="{{ route('language.switch', ['locale' => 'ar']) }}">
                                <i class="fas fa-globe"></i> العربية
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="logo-container">
                    <img src="{{ asset('images/logo_umbb.png') }}" alt="Université de Bomerdes Logo" class="img-fluid">
                </div>
                <h1 class="process-title">@lang('transfer.title_bomerdes')</h1>
                <p class="process-subtitle">@lang('transfer.subtitle_bomerdes')</p>
            </div>
        </div>
    </div>

    <div class="container">
        @if(auth()->check())
            <!-- Suppression de l'affichage des informations de connexion -->
        @else
            <div class="alert alert-danger">
                Vous n'êtes pas connecté. Veuillez vous connecter pour soumettre une demande.
            </div>
        @endif

        <!-- Status Container -->
        <div class="status-container" id="statusContainer">
            <div class="status-icon" id="statusIcon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 class="status-title" id="statusTitle">@lang('transfer.status.title')</h3>
            <p class="status-message" id="statusMessage">@lang('transfer.status.message')</p>
            <div class="status-details">
                <h5>@lang('transfer.status.details')</h5>
                <p id="statusDetails"></p>
            </div>
        </div>

        <!-- Indicateur de progression -->
        <div class="pagination-steps">
            <div class="step-indicator active">
                <div class="step-number">0</div>
                <div class="step-label">@lang('transfer.steps.transfer_type')</div>
            </div>
            <div class="step-indicator">
                <div class="step-number">1</div>
                <div class="step-label">@lang('transfer.steps.personal_info')</div>
            </div>
            <div class="step-indicator">
                <div class="step-number">2</div>
                <div class="step-label">@lang('transfer.steps.motivation_docs')</div>
            </div>
            <div class="step-indicator">
                <div class="step-number">3</div>
                <div class="step-label">@lang('transfer.steps.validation')</div>
            </div>
            {{-- <div class="step-indicator">
                <div class="step-number">4</div>
                <div class="step-label">@lang('transfer.steps.tracking')</div>
            </div> --}}
        </div>

        <!-- Contenu du formulaire -->
        
        <form id="transferForm" action="{{ route('transfer-request.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            
            <!-- Étape 0: Type de Transfert -->
            <div class="step-content active" id="step0">
                <div class="custom-card">
                    <div class="card-header">
                        <h4 class="mb-0">@lang('transfer.transfer_type.title')</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="transfer-type-card" data-type="internal">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-university fa-3x mb-3"></i>
                                            <h5>@lang('transfer.transfer_type.internal')</h5>
                                            <p class="text-muted">@lang('transfer.transfer_type.internal_description')</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="transfer-type-card" data-type="external">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-exchange-alt fa-3x mb-3"></i>
                                            <h5>@lang('transfer.transfer_type.external')</h5>
                                            <p class="text-muted">@lang('transfer.transfer_type.external_description')</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="transfer_type" id="transferType" required>
                    </div>
                </div>
            </div>

            <!-- Étape 1: Informations Personnelles -->
            <div class="step-content active" id="step1">
                <div class="custom-card">
                    <div class="card-header">
                        <h4 class="mb-0">@lang('transfer.personal_info.title')</h4>
                    </div>
                    <div class="card-body">
                        <!-- Personal Information -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('transfer.personal_info.lastname')</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('transfer.personal_info.firstname')</label>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname', auth()->user()->firstname) }}" required>
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('transfer.personal_info.birthdate')</label>
                                <input type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ old('birthdate', auth()->user()->birthdate) }}" required>
                                @error('birthdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('transfer.personal_info.nationality')</label>
                                <select class="form-select @error('nationality') is-invalid @enderror" name="nationality" required>
                                    <option value="">@lang('transfer.personal_info.select_nationality')</option>

                                    <option value="algerian" {{ old('nationality', auth()->user()->nationality) == 'algerian' ? 'selected' : '' }}>@lang('transfer.personal_info.nationality_algerian')</option>
                                    <option value="moroccan" {{ old('nationality', auth()->user()->nationality) == 'moroccan' ? 'selected' : '' }}>@lang('transfer.personal_info.nationality_moroccan')</option>
                                    <option value="tunisian" {{ old('nationality', auth()->user()->nationality) == 'tunisian' ? 'selected' : '' }}>@lang('transfer.personal_info.nationality_tunisian')</option>
                                    <option value="libyan" {{ old('nationality', auth()->user()->nationality) == 'libyan' ? 'selected' : '' }}>@lang('transfer.personal_info.nationality_libyan')</option>
                                </select>
                                @error('nationality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('transfer.personal_info.email')</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('transfer.personal_info.phone')</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">@lang('transfer.personal_info.address')</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3" required>{{ old('address', auth()->user()->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('transfer.personal_info.city')</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city', auth()->user()->city) }}" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('transfer.personal_info.postal_code')</label>
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code', auth()->user()->postal_code) }}" required>
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Formation actuelle -->
                        <div class="mt-4">
                            <h5 class="mb-3">@lang('transfer.current_formation.title')</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">@lang('transfer.current_formation.institution')</label>
                                    <select class="form-select @error('current_institution') is-invalid @enderror" name="current_institution" required>
                                        <option value="">@lang('transfer.current_formation.select_institution')</option>
                                        <option value="umbb" {{ old('current_institution', auth()->user()->current_institution) == 'umbb' ? 'selected' : '' }}>@lang('transfer.current_formation.institution_umbb')</option>
                                        <option value="usthb" {{ old('current_institution', auth()->user()->current_institution) == 'usthb' ? 'selected' : '' }}>@lang('transfer.current_formation.institution_usthb')</option>
                                        <option value="usto" {{ old('current_institution', auth()->user()->current_institution) == 'usto' ? 'selected' : '' }}>@lang('transfer.current_formation.institution_usto')</option>
                                        <option value="other" {{ old('current_institution', auth()->user()->current_institution) == 'other' ? 'selected' : '' }}>@lang('transfer.current_formation.institution_other')</option>
                                    </select>
                                    @error('current_institution')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">@lang('transfer.current_formation.faculty')</label>
                                    <select class="form-select @error('faculty') is-invalid @enderror" name="faculty" required>
                                        <option value="">@lang('transfer.current_formation.select_faculty')</option>
                                        <option value="science_technology" {{ old('faculty', auth()->user()->faculty) == 'science_technology' ? 'selected' : '' }}>@lang('transfer.current_formation.faculty_science_technology')</option>
                                        <option value="mathematics_informatics" {{ old('faculty', auth()->user()->faculty) == 'mathematics_informatics' ? 'selected' : '' }}>@lang('transfer.current_formation.faculty_mathematics_informatics')</option>
                                        <option value="sciences_earth_universe" {{ old('faculty', auth()->user()->faculty) == 'sciences_earth_universe' ? 'selected' : '' }}>@lang('transfer.current_formation.faculty_sciences_earth_universe')</option>
                                    </select>
                                    @error('faculty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">@lang('transfer.current_formation.department')</label>
                                    <select class="form-select @error('department') is-invalid @enderror" name="department" required>
                                        <option value="">@lang('transfer.current_formation.select_department')</option>
                                        <option value="informatique" {{ old('department', auth()->user()->department) == 'informatique' ? 'selected' : '' }}>@lang('transfer.current_formation.department_informatique')</option>
                                        <option value="electronique" {{ old('department', auth()->user()->department) == 'electronique' ? 'selected' : '' }}>@lang('transfer.current_formation.department_electronique')</option>
                                        <option value="electrotechnique" {{ old('department', auth()->user()->department) == 'electrotechnique' ? 'selected' : '' }}>@lang('transfer.current_formation.department_electrotechnique')</option>
                                        <option value="telecommunications" {{ old('department', auth()->user()->department) == 'telecommunications' ? 'selected' : '' }}>@lang('transfer.current_formation.department_telecommunications')</option>
                                        <option value="genie_civil" {{ old('department', auth()->user()->department) == 'genie_civil' ? 'selected' : '' }}>@lang('transfer.current_formation.department_genie_civil')</option>
                                        <option value="genie_mecanique" {{ old('department', auth()->user()->department) == 'genie_mecanique' ? 'selected' : '' }}>@lang('transfer.current_formation.department_genie_mecanique')</option>
                                        <option value="genie_chimique" {{ old('department', auth()->user()->department) == 'genie_chimique' ? 'selected' : '' }}>@lang('transfer.current_formation.department_genie_chimique')</option>
                                    </select>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">@lang('transfer.current_formation.specialization')</label>
                                    <select class="form-select @error('specialization') is-invalid @enderror" name="specialization" required>
                                        <option value="">@lang('transfer.current_formation.select_specialization')</option>
                                        <!-- Informatique -->
                                        <option value="informatique_systemes" {{ old('specialization', auth()->user()->specialization) == 'informatique_systemes' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_informatique_systemes')</option>
                                        <option value="informatique_industrielle" {{ old('specialization', auth()->user()->specialization) == 'informatique_industrielle' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_informatique_industrielle')</option>
                                        <option value="informatique_decisionnelle" {{ old('specialization', auth()->user()->specialization) == 'informatique_decisionnelle' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_informatique_decisionnelle')</option>
                                        <!-- Électronique -->
                                        <option value="electronique_embarquee" {{ old('specialization', auth()->user()->specialization) == 'electronique_embarquee' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_electronique_embarquee')</option>
                                        <option value="electronique_telecommunications" {{ old('specialization', auth()->user()->specialization) == 'electronique_telecommunications' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_electronique_telecommunications')</option>
                                        <!-- Électrotechnique -->
                                        <option value="electrotechnique_energie" {{ old('specialization', auth()->user()->specialization) == 'electrotechnique_energie' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_electrotechnique_energie')</option>
                                        <option value="electrotechnique_automation" {{ old('specialization', auth()->user()->specialization) == 'electrotechnique_automation' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_electrotechnique_automation')</option>
                                        <!-- Télécommunications -->
                                        <option value="telecommunications_reseaux" {{ old('specialization', auth()->user()->specialization) == 'telecommunications_reseaux' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_telecommunications_reseaux')</option>
                                        <option value="telecommunications_systemes" {{ old('specialization', auth()->user()->specialization) == 'telecommunications_systemes' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_telecommunications_systemes')</option>
                                        <!-- Génie Civil -->
                                        <option value="genie_civil_batiment" {{ old('specialization', auth()->user()->specialization) == 'genie_civil_batiment' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_genie_civil_batiment')</option>
                                        <option value="genie_civil_travaux_publics" {{ old('specialization', auth()->user()->specialization) == 'genie_civil_travaux_publics' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_genie_civil_travaux_publics')</option>
                                        <!-- Génie Mécanique -->
                                        <option value="genie_mecanique_conception" {{ old('specialization', auth()->user()->specialization) == 'genie_mecanique_conception' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_genie_mecanique_conception')</option>
                                        <option value="genie_mecanique_production" {{ old('specialization', auth()->user()->specialization) == 'genie_mecanique_production' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_genie_mecanique_production')</option>
                                        <!-- Génie Chimique -->
                                        <option value="genie_chimique_procedes" {{ old('specialization', auth()->user()->specialization) == 'genie_chimique_procedes' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_genie_chimique_procedes')</option>
                                        <option value="genie_chimique_industriel" {{ old('specialization', auth()->user()->specialization) == 'genie_chimique_industriel' ? 'selected' : '' }}>@lang('transfer.current_formation.specialization_genie_chimique_industriel')</option>
                                    </select>
                                    @error('specialization')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">@lang('transfer.current_formation.level')</label>
                                    <select class="form-select @error('level') is-invalid @enderror" name="level" required>
                                        <option value="">@lang('transfer.current_formation.select_level')</option>
                                        <option value="L1" {{ old('level', auth()->user()->level) == 'L1' ? 'selected' : '' }}>@lang('transfer.current_formation.level_L1')</option>
                                        <option value="L2" {{ old('level', auth()->user()->level) == 'L2' ? 'selected' : '' }}>@lang('transfer.current_formation.level_L2')</option>
                                        <option value="L3" {{ old('level', auth()->user()->level) == 'L3' ? 'selected' : '' }}>@lang('transfer.current_formation.level_L3')</option>
                                        <option value="M1" {{ old('level', auth()->user()->level) == 'M1' ? 'selected' : '' }}>@lang('transfer.current_formation.level_M1')</option>
                                        <option value="M2" {{ old('level', auth()->user()->level) == 'M2' ? 'selected' : '' }}>@lang('transfer.current_formation.level_M2')</option>
                                    </select>
                                    @error('level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">@lang('transfer.current_formation.average_grade')</label>
                                    <input type="number" step="0.01" class="form-control @error('average_grade') is-invalid @enderror" name="average_grade" value="{{ old('average_grade', auth()->user()->average_grade) }}" required>
                                    @error('average_grade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">@lang('transfer.current_formation.projects')</label>
                                    <textarea class="form-control @error('projects') is-invalid @enderror" name="projects" rows="4">{{ old('projects', auth()->user()->projects) }}</textarea>
                                    @error('projects')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">@lang('transfer.current_formation.formation')</label>
                                    <select class="form-select @error('current_formation') is-invalid @enderror" name="current_formation" required>
                                        <option value="">@lang('transfer.current_formation.select_formation')</option>
                                        <option value="licence" {{ old('current_formation', auth()->user()->current_formation) == 'licence' ? 'selected' : '' }}>@lang('transfer.current_formation.formation_licence')</option>
                                        <option value="master" {{ old('current_formation', auth()->user()->current_formation) == 'master' ? 'selected' : '' }}>@lang('transfer.current_formation.formation_master')</option>
                                        <option value="doctorat" {{ old('current_formation', auth()->user()->current_formation) == 'doctorat' ? 'selected' : '' }}>@lang('transfer.current_formation.formation_doctorat')</option>
                                    </select>
                                    @error('current_formation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">@lang('transfer.current_formation.year')</label>
                                    <select class="form-select @error('current_year') is-invalid @enderror" name="current_year" required>
                                        <option value="">@lang('transfer.current_formation.select_year')</option>
                                        <option value="1ere_annee" {{ old('current_year', auth()->user()->current_year) == '1ere_annee' ? 'selected' : '' }}>@lang('transfer.current_formation.year_1')</option>
                                        <option value="2eme_annee" {{ old('current_year', auth()->user()->current_year) == '2eme_annee' ? 'selected' : '' }}>@lang('transfer.current_formation.year_2')</option>
                                        <option value="3eme_annee" {{ old('current_year', auth()->user()->current_year) == '3eme_annee' ? 'selected' : '' }}>@lang('transfer.current_formation.year_3')</option>
                                        <option value="4eme_annee" {{ old('current_year', auth()->user()->current_year) == '4eme_annee' ? 'selected' : '' }}>@lang('transfer.current_formation.year_4')</option>
                                        <option value="5eme_annee" {{ old('current_year', auth()->user()->current_year) == '5eme_annee' ? 'selected' : '' }}>@lang('transfer.current_formation.year_5')</option>
                                    </select>
                                    @error('current_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 2: Motivation et Documents -->
            <div class="step-content" id="step2">
                <div class="custom-card">
                    <div class="card-header">
                        <h4 class="mb-0">@lang('transfer.motivation.title')</h4>
                    </div>
                    <div class="card-body">
                        <!-- Motivation -->
                        <div class="mb-4">
                            <label class="form-label">@lang('transfer.motivation.why_paris_saclay')</label>
                            <textarea class="form-control @error('motivation') is-invalid @enderror" name="motivation" rows="4" required>{{ old('motivation', auth()->user()->motivation) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">@lang('transfer.motivation.career_plan')</label>
                            <textarea class="form-control @error('career_plan') is-invalid @enderror" name="career_plan" rows="4" required>{{ old('career_plan', auth()->user()->career_plan) }}</textarea>
                            @error('career_plan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">@lang('transfer.motivation.desired_formation')</label>
                            <select class="form-select @error('desired_formation') is-invalid @enderror" name="desired_formation" required>
                                <option value="">@lang('transfer.motivation.desired_formation_select')</option>
                                <option value="informatique" {{ old('desired_formation', auth()->user()->desired_formation) == 'informatique' ? 'selected' : '' }}>@lang('transfer.motivation.desired_formation_informatique')</option>
                                <option value="genie_electrique" {{ old('desired_formation', auth()->user()->desired_formation) == 'genie_electrique' ? 'selected' : '' }}>@lang('transfer.motivation.desired_formation_genie_electrique')</option>
                                <option value="genie_mecanique" {{ old('desired_formation', auth()->user()->desired_formation) == 'genie_mecanique' ? 'selected' : '' }}>@lang('transfer.motivation.desired_formation_genie_mecanique')</option>
                                <option value="genie_civil" {{ old('desired_formation', auth()->user()->desired_formation) == 'genie_civil' ? 'selected' : '' }}>@lang('transfer.motivation.desired_formation_genie_civil')</option>
                                <option value="genie_chimique" {{ old('desired_formation', auth()->user()->desired_formation) == 'genie_chimique' ? 'selected' : '' }}>@lang('transfer.motivation.desired_formation_genie_chimique')</option>
                            </select>
                            @error('desired_formation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">@lang('transfer.motivation.technical_skills')</label>
                            <textarea class="form-control @error('technical_skills') is-invalid @enderror" name="technical_skills" rows="3">{{ old('technical_skills', auth()->user()->technical_skills) }}</textarea>
                            @error('technical_skills')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">@lang('transfer.motivation.languages')</label>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <input type="text" class="form-control" name="languages[]" placeholder="@lang('transfer.motivation.language')" value="{{ old('languages.0', auth()->user()->languages[0] ?? '') }}">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <select class="form-select" name="language_levels[]">
                                        <option value="">@lang('transfer.motivation.level')</option>
                                        <option value="A1">@lang('transfer.motivation.level_A1')</option>
                                        <option value="A2">@lang('transfer.motivation.level_A2')</option>
                                        <option value="B1">@lang('transfer.motivation.level_B1')</option>
                                        <option value="B2">@lang('transfer.motivation.level_B2')</option>
                                        <option value="C1">@lang('transfer.motivation.level_C1')</option>
                                        <option value="C2">@lang('transfer.motivation.level_C2')</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <button type="button" class="btn btn-outline-primary add-language">+ @lang('transfer.motivation.add')</button>
                                </div>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div class="mt-4">
                            <h5 class="mb-3">@lang('transfer.documents.title')</h5>
                            <div class="mb-3">
                                <label class="form-label">@lang('transfer.documents.transcript')</label>
                                <input type="file" class="form-control @error('transcript') is-invalid @enderror" name="transcript" accept=".pdf">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">@lang('transfer.documents.cv')</label>
                                <input type="file" class="form-control @error('cv') is-invalid @enderror" name="cv" accept=".pdf">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">@lang('transfer.documents.motivation_letter')</label>
                                <input type="file" class="form-control @error('motivation_letter') is-invalid @enderror" name="motivation_letter" accept=".pdf">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">@lang('transfer.documents.id_document')</label>
                                <input type="file" class="form-control @error('id_document') is-invalid @enderror" name="id_document" accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">@lang('transfer.documents.certificates')</label>
                                <input type="file" class="form-control @error('certificates') is-invalid @enderror" name="certificates[]" accept=".pdf" multiple>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 3: Validation et Résumé -->
            <div class="step-content" id="step3">
                <div class="custom-card">
                    <div class="card-header">
                        <h4 class="mb-0">@lang('transfer.validation.title')</h4>
                    </div>
                    <div class="card-body">
                        <!-- Résumé de la demande -->
                        <div class="summary-section mb-4">
                            <h5 class="summary-title">@lang('transfer.summary.title')</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="bg-light">@lang('transfer.summary.request_id')</th>
                                            <td id="summaryRequestId">{{ $transfer_request?->id ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">@lang('transfer.summary.status')</th>
                                            <td>
                                                <span class="badge bg-{{ $transfer_request?->status === 'pending' ? 'warning' : ($transfer_request?->status === 'accepted' ? 'success' : 'danger') }}">
                                                    @lang('transfer.status.' . ($transfer_request?->status ?? 'pending'))
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">@lang('transfer.summary.submission_date')</th>
                                            <td>{{ $transfer_request?->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">@lang('transfer.summary.current_institution')</th>
                                            <td>{{ $transfer_request?->current_institution ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">@lang('transfer.summary.current_formation')</th>
                                            <td>{{ $transfer_request?->current_formation ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">@lang('transfer.summary.current_year')</th>
                                            <td>{{ $transfer_request?->current_year ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">@lang('transfer.summary.average_grade')</th>
                                            <td>{{ $transfer_request?->average_grade ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">@lang('transfer.summary.specialization')</th>
                                            <td>{{ $transfer_request?->specialization ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">@lang('transfer.summary.desired_formation')</th>
                                            <td>{{ $transfer_request?->desired_formation ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Validation -->
                        <div class="validation-checklist mb-4">
                            <h5 class="mb-3">@lang('transfer.validation.final_check')</h5>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="check1" required>
                                <label class="form-check-label" for="check1">
                                    @lang('transfer.validation.check1')
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="check2" required>
                                <label class="form-check-label" for="check2">
                                    @lang('transfer.validation.check2')
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="check3" required>
                                <label class="form-check-label" for="check3">
                                    @lang('transfer.validation.check3')
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="check4" required>
                                <label class="form-check-label" for="check4">
                                    @lang('transfer.validation.check4')
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 4: Suivi -->
            <div class="step-content" id="step4">
                <div class="custom-card">
                    <div class="card-header">
                        <h4 class="mb-0">@lang('transfer.tracking.title')</h4>
                    </div>
                    <div class="card-body">
                        <!-- Informations générales -->
                        <div class="tracking-info mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-card">
                                        <h5 class="info-title">@lang('transfer.tracking.request_info')</h5>
                                        <div class="info-content">
                                            <div class="info-item">
                                                <span class="info-label">@lang('transfer.tracking.request_number')</span>
                                                <span class="info-value" id="requestNumber">{{ $transfer_request?->id ?? '-' }}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">@lang('transfer.tracking.submission_date')</span>
                                                <span class="info-value" id="submissionDate">{{ $transfer_request?->created_at?->format('d/m/Y H:i') ?? '-' }}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">@lang('transfer.tracking.current_status')</span>
                                                <span class="info-value">
                                                    <span class="status-badge" id="currentStatus" data-status="{{ $transfer_request?->status ?? 'pending' }}">
                                                        @lang('transfer.status.' . ($transfer_request?->status ?? 'pending'))
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-card">
                                        <h5 class="info-title">@lang('transfer.tracking.progress')</h5>
                                        <div class="progress-container">
                                            <div class="progress">
                                                <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%"></div>
                                            </div>
                                            <div class="progress-steps">
                                                <div class="step completed">
                                                    <i class="fas fa-check"></i>
                                                    <span>@lang('transfer.tracking.step_submitted')</span>
                                                </div>
                                                <div class="step" id="stepConfirmed">
                                                    <i class="fas fa-clock"></i>
                                                    <span>@lang('transfer.tracking.step_confirmed')</span>
                                                </div>
                                                <div class="step" id="stepProcessed">
                                                    <i class="fas fa-cogs"></i>
                                                    <span>@lang('transfer.tracking.step_processed')</span>
                                                </div>
                                                <div class="step" id="stepCompleted">
                                                    <i class="fas fa-flag-checkered"></i>
                                                    <span>@lang('transfer.tracking.step_completed')</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline des statuts -->
                        <div class="timeline-section mb-4">
                            <h5 class="section-title">@lang('transfer.tracking.status_history')</h5>
                            <div class="timeline" id="statusTimeline">
                                @if($transfer_request?->statusHistory)
                                    @foreach($transfer_request->statusHistory as $history)
                                        <div class="timeline-item">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <div class="timeline-date">{{ $history->created_at->format('d/m/Y H:i') }}</div>
                                                <div class="timeline-status">
                                                    <span class="status-badge" data-status="{{ $history->status }}">
                                                        @lang('transfer.status.' . $history->status)
                                                    </span>
                                                </div>
                                                @if($history->notes)
                                                    <div class="timeline-notes">{{ $history->notes }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="no-history">
                                        <i class="fas fa-history"></i>
                                        <p>@lang('transfer.tracking.no_history')</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Documents et actions -->
                        <div class="actions-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="documents-card">
                                        <h5 class="section-title">@lang('transfer.tracking.documents')</h5>
                                        <div class="documents-list" id="documentList">
                                            @if($transfer_request)
                                                @if($transfer_request->transcript_path)
                                                    <a href="{{ Storage::url($transfer_request->transcript_path) }}" class="document-item" target="_blank">
                                                        <i class="fas fa-file-pdf"></i>
                                                        <span>@lang('transfer.documents.transcript')</span>
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif
                                                @if($transfer_request->cv_path)
                                                    <a href="{{ Storage::url($transfer_request->cv_path) }}" class="document-item" target="_blank">
                                                        <i class="fas fa-file-pdf"></i>
                                                        <span>@lang('transfer.documents.cv')</span>
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif
                                                @if($transfer_request->motivation_letter_path)
                                                    <a href="{{ Storage::url($transfer_request->motivation_letter_path) }}" class="document-item" target="_blank">
                                                        <i class="fas fa-file-pdf"></i>
                                                        <span>@lang('transfer.documents.motivation_letter')</span>
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif
                                            @else
                                                <div class="no-documents">
                                                    <i class="fas fa-folder-open"></i>
                                                    <p>@lang('transfer.tracking.no_documents')</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="actions-card">
                                        <h5 class="section-title">@lang('transfer.tracking.available_actions')</h5>
                                        <div class="actions-list" id="actionList">
                                            @if($transfer_request)
                                                @if($transfer_request->status === 'pending')
                                                    <button class="action-item" onclick="cancelRequest()">
                                                        <i class="fas fa-times-circle"></i>
                                                        <span>@lang('transfer.actions.cancel_request')</span>
                                                    </button>
                                                @endif
                                                @if($transfer_request->status === 'accepted')
                                                    <button class="action-item" onclick="downloadAcceptance()">
                                                        <i class="fas fa-download"></i>
                                                        <span>@lang('transfer.actions.download_acceptance')</span>
                                                    </button>
                                                @endif
                                                @if($transfer_request->status === 'rejected')
                                                    <button class="action-item" onclick="viewRejectionReason()">
                                                        <i class="fas fa-info-circle"></i>
                                                        <span>@lang('transfer.actions.view_rejection_reason')</span>
                                                    </button>
                                                @endif
                                            @else
                                                <div class="no-actions">
                                                    <i class="fas fa-ban"></i>
                                                    <p>@lang('transfer.tracking.no_actions')</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons de Navigation -->
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-secondary" id="prevBtn">
                    <i class="fas fa-arrow-left me-2"></i>@lang('transfer.buttons.return')
                </button>
                <button type="button" class="btn btn-primary" id="nextBtn">
                    @lang('transfer.buttons.next')<i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <script src="{{ asset('js/demende.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de la sélection du type de transfert
            const transferTypeCards = document.querySelectorAll('.transfer-type-card');
            const transferTypeInput = document.getElementById('transferType');
            
            transferTypeCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Retirer la classe selected de toutes les cartes
                    transferTypeCards.forEach(c => c.classList.remove('selected'));
                    
                    // Ajouter la classe selected à la carte cliquée
                    this.classList.add('selected');
                    
                    // Mettre à jour la valeur du champ caché
                    transferTypeInput.value = this.dataset.type;
                    
                    // Activer le bouton suivant
                    document.getElementById('nextBtn').disabled = false;
                });
            });
            
            // Désactiver le bouton suivant initialement
            document.getElementById('nextBtn').disabled = true;
        });
    </script>
</body>
</html>

