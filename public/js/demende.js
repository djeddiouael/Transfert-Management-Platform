document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 0;
    const totalSteps = 4; // Changé de 8 à 4
    const stepContents = document.querySelectorAll('.step-content');
    const stepIndicators = document.querySelectorAll('.step-indicator');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const form = document.getElementById('transferForm');

    // Fonction pour afficher le contenu de l'étape
    function showStepContent(step) {
        stepContents.forEach((content, index) => {
            if (index === step) {
                content.classList.add('active');
                content.style.display = 'block';
            } else {
                content.classList.remove('active');
                content.style.display = 'none';
            }
        });
    }

    // Gestionnaire pour le bouton précédent
    prevBtn.addEventListener('click', function() {
        if (currentStep > 0) {
            currentStep--;
            updateStep();
            showStepContent(currentStep);
        }
    });

    // Gestionnaire pour le bouton suivant
    nextBtn.addEventListener('click', function() {
        if (currentStep < totalSteps - 1) {
            if (validateStep(currentStep)) {
                if (currentStep === totalSteps - 2) { // Si on est à l'étape 3 (avant-dernière)
                    // Soumettre le formulaire
                    form.submit();
                } else {
                    currentStep++;
                    updateStep();
                    showStepContent(currentStep);
                }
            }
        }
    });

    function updateStep() {
        // Mise à jour des indicateurs
        stepIndicators.forEach((indicator, index) => {
            if (index < currentStep) {
                indicator.classList.add('completed');
                indicator.classList.remove('active');
            } else if (index === currentStep) {
                indicator.classList.add('active');
                indicator.classList.remove('completed');
            } else {
                indicator.classList.remove('active', 'completed');
            }
        });

        // Mise à jour des boutons
        prevBtn.style.display = currentStep > 0 ? 'block' : 'none';
        
        // Mise à jour du texte du bouton suivant
        if (currentStep === totalSteps - 2) { // Avant-dernière étape
            nextBtn.innerHTML = '<i class="fas fa-check me-2"></i>@lang("transfer.buttons.submit")';
        } else if (currentStep === totalSteps - 1) { // Dernière étape
            nextBtn.style.display = 'none';
        } else {
            nextBtn.innerHTML = '@lang("transfer.buttons.next")<i class="fas fa-arrow-right ms-2"></i>';
        }
    }

    // Initialisation
    updateStep();
    showStepContent(currentStep);

    // Vérifier le statut de la demande au chargement
    if (isLoggedIn) {
        fetch('{{ route("transfer-request.check-status") }}', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.has_completed) {
                // Afficher directement l'étape 4
                currentStep = 3;
                updateStep();
                showStepContent(currentStep);

                // Cacher tous les boutons de navigation
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'none';

                // Mettre à jour le suivi détaillé
                updateDetailedTracking(data);
            }
        })
        .catch(error => {
            console.error('Error checking transfer status:', error);
        });
    }

    // Messages de validation avec traductions
    const validationMessages = {
        personal_info: {
            required: '@lang("transfer.validation.personal_info_required")',
            email: '@lang("transfer.validation.email_invalid")',
            phone: '@lang("transfer.validation.phone_invalid")'
        },
        current_formation: {
            required: '@lang("transfer.validation.formation_required")',
            average_grade: '@lang("transfer.validation.average_grade_invalid")'
        },
        motivation: {
            required: '@lang("transfer.validation.motivation_required")',
            min_length: '@lang("transfer.validation.motivation_min_length")'
        },
        documents: {
            required: '@lang("transfer.validation.documents_required")',
            file_size: '@lang("transfer.validation.file_size_invalid")',
            file_type: '@lang("transfer.validation.file_type_invalid")'
        }
    };
    // Gestionnaire pour le bouton précédent
    prevBtn.addEventListener('click', function() {
        if (currentStep > 0 && currentStep < 4) {
            currentStep--;
            updateStep();
            showStepContent(currentStep);
        }
    });

    // Gestionnaire pour le bouton suivant
    nextBtn.addEventListener('click', function() {
        if (currentStep < totalSteps - 1) {
            if (validateStep(currentStep)) {
                currentStep++;
                updateStep();
                showStepContent(currentStep);
            }
        }
    });

    // Fonction de validation des étapes
    function validateStep(step) {
        let isValid = true;
        let errorMessage = '';

        switch(step) {
            case 0: // Étape de procédure
                return true;

            case 1: // Informations personnelles
                const personalInfoFields = ['name', 'firstname', 'birthdate', 'nationality', 'email', 'phone'];
                personalInfoFields.forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                        errorMessage = validationMessages.personal_info.required;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });
                break;

            case 2: // Formation actuelle
                const formationFields = ['current_institution', 'faculty', 'department', 'specialization', 'level', 'average_grade'];
                formationFields.forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                        errorMessage = validationMessages.current_formation.required;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });
                break;

            case 3: // Motivation
                const motivationFields = ['motivation', 'career_plan'];
                motivationFields.forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                        errorMessage = validationMessages.motivation.required;
                    } else if (input.value.length < 100) {
                        input.classList.add('is-invalid');
                        isValid = false;
                        errorMessage = validationMessages.motivation.min_length;
                        // Afficher le nombre de caractères manquants
                        const missingChars = 100 - input.value.length;
                        errorMessage += ` (${missingChars} caractères manquants)`;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });
                break;

            case 4: // Documents
                const requiredFiles = ['transcript', 'cv', 'motivation_letter', 'id_document'];
                requiredFiles.forEach(file => {
                    const input = document.querySelector(`[name="${file}"]`);
                    if (!input.files.length) {
                        input.classList.add('is-invalid');
                        isValid = false;
                        errorMessage = validationMessages.documents.required;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });
                break;

            case 5: // Validation
                const checkboxes = document.querySelectorAll('.form-check-input');
                checkboxes.forEach(checkbox => {
                    if (!checkbox.checked) {
                        checkbox.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        checkbox.classList.remove('is-invalid');
                    }
                });
                break;

            case 6: // Résumé
                return true;
        }

        if (!isValid) {
            showValidationError(errorMessage);
        }

        return isValid;
    }

    // Fonction pour afficher les erreurs de validation
    function showValidationError(message) {
        // Supprimer les messages d'erreur existants
        const existingErrors = document.querySelectorAll('.alert-danger');
        existingErrors.forEach(error => error.remove());

        // Créer le nouveau message d'erreur
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger mt-3';
        errorDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div>${message}</div>
            </div>
        `;
        
        // Ajouter le message d'erreur au contenu de l'étape actuelle
        const currentStepContent = document.querySelector(`#step${currentStep} .card-body`);
        currentStepContent.insertBefore(errorDiv, currentStepContent.firstChild);

        // Faire défiler jusqu'au message d'erreur
        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Fonction pour mettre à jour le résumé après soumission
    function updateSummary(response) {
        if (response.success && response.transfer_request) {
            const request = response.transfer_request;
            
            // Mise à jour des champs du résumé
            document.getElementById('summaryRequestId').textContent = request.id;
            
            // Mise à jour du statut avec le badge approprié
            const statusCell = document.querySelector('th:contains("Status")').nextElementSibling;
            const statusBadge = statusCell.querySelector('.badge');
            statusBadge.className = `badge bg-${request.status === 'pending' ? 'warning' : (request.status === 'accepted' ? 'success' : 'danger')}`;
            statusBadge.textContent = request.status;
            
            // Mise à jour de la date de soumission
            const submissionDate = new Date(request.created_at);
            document.querySelector('th:contains("Submission Date")').nextElementSibling.textContent = 
                submissionDate.toLocaleDateString() + ' ' + submissionDate.toLocaleTimeString();
            
            // Mise à jour des autres champs
            const fields = [
                'current_institution',
                'current_formation',
                'current_year',
                'average_grade',
                'specialization',
                'desired_formation'
            ];
            
            fields.forEach(field => {
                const cell = document.querySelector(`th:contains("${field}")`).nextElementSibling;
                cell.textContent = request[field] || '-';
            });
            
            // Afficher la section de résumé
            document.querySelector('.summary-section').style.display = 'block';
        }
    }

    // Modification de la fonction de soumission du formulaire
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour le résumé
                updateSummary(data);
                
                // Afficher le message de succès
                const statusContainer = document.getElementById('statusContainer');
                statusContainer.classList.add('active');
                statusContainer.querySelector('.status-icon').className = 'status-icon accepted';
                statusContainer.querySelector('.status-title').textContent = 'Demande soumise avec succès';
                statusContainer.querySelector('.status-message').textContent = data.message;
                
                // Désactiver le formulaire
                this.classList.add('form-disabled');
                
                // Rediriger vers la page de suivi après 3 secondes
                setTimeout(() => {
                    window.location.href = '/transfer-request/tracking';
                }, 3000);
            } else {
                // Afficher l'erreur
                const statusContainer = document.getElementById('statusContainer');
                statusContainer.classList.add('active');
                statusContainer.querySelector('.status-icon').className = 'status-icon rejected';
                statusContainer.querySelector('.status-title').textContent = 'Erreur';
                statusContainer.querySelector('.status-message').textContent = data.message;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Afficher l'erreur
            const statusContainer = document.getElementById('statusContainer');
            statusContainer.classList.add('active');
            statusContainer.querySelector('.status-icon').className = 'status-icon rejected';
            statusContainer.querySelector('.status-title').textContent = 'Erreur';
            statusContainer.querySelector('.status-message').textContent = 'Une erreur est survenue lors de la soumission de la demande.';
        });
    });

    // Gestionnaire pour le bouton de confirmation
    const confirmBtn = document.getElementById('confirmBtn');
    confirmBtn.addEventListener('click', function() {
        if (confirm('هل أنت متأكد من تأكيد الطلب؟ لا يمكن العودة بعد التأكيد.')) {
            // Désactiver tous les boutons
            document.querySelectorAll('button').forEach(btn => {
                btn.disabled = true;
            });

            // Afficher l'animation de chargement
            const loading = document.createElement('div');
            loading.className = 'loading active';
            loading.innerHTML = '<div class="loading-spinner"></div>';
            document.body.appendChild(loading);

            // Simuler le traitement
            setTimeout(() => {
                document.body.removeChild(loading);

                // Cacher toutes les étapes sauf l'étape 7
                document.querySelectorAll('.step-content').forEach(step => {
                    step.style.display = 'none';
                });

                // Afficher l'étape 7
                const step7 = document.getElementById('step7');
                step7.style.display = 'block';
                step7.classList.add('active');

                // Mettre à jour les indicateurs d'étape
                document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
                    if (index < 7) {
                        indicator.classList.add('completed');
                        indicator.classList.remove('active');
                    } else if (index === 7) {
                        indicator.classList.add('active');
                        indicator.classList.remove('completed');
                    }
                });

                // Cacher tous les boutons de navigation
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'none';
                printBtn.style.display = 'none';
                confirmBtn.style.display = 'none';

                // Mettre à jour la date de soumission
                const now = new Date();
                document.getElementById('submissionDate').textContent = now.toLocaleDateString('fr-FR', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                // Faire défiler jusqu'à l'étape 7
                step7.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 2000);
        }
    });

    // Fonction pour mettre à jour l'historique des statuts
    function updateStatusHistory(history) {
        const tbody = document.getElementById('statusHistory');
        tbody.innerHTML = '';

        history.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${new Date(item.date).toLocaleDateString('fr-FR', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                })}</td>
                <td>
                    <span class="badge bg-${getStatusBadgeClass(item.status)}">
                        ${item.status_text}
                    </span>
                </td>
                <td>${item.notes || '-'}</td>
            `;
            tbody.appendChild(row);
        });
    }

    // Fonction pour obtenir la classe CSS du badge selon le statut
    function getStatusBadgeClass(status) {
        return {
            'pending': 'warning',
            'confirmed': 'info',
            'accepted': 'success',
            'rejected': 'danger'
        }[status] || 'secondary';
    }

    // Mettre à jour l'historique des statuts lors de la réception des données
    if (data.status_history) {
        updateStatusHistory(data.status_history);
    }

    // Fonction pour mettre à jour le suivi détaillé
    function updateDetailedTracking(data) {
        // Mise à jour des informations générales
        document.getElementById('requestNumber').textContent = data.transfer_request.id;
        document.getElementById('submissionDate').textContent = new Date(data.transfer_request.request_date).toLocaleDateString('fr-FR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        document.getElementById('currentStatus').innerHTML = `
            <span class="badge bg-${getStatusBadgeClass(data.transfer_request.status)}">
                ${data.transfer_request.status_text}
            </span>
        `;

        // Mise à jour de la barre de progression
        const progress = calculateProgress(data.transfer_request.status);
        document.getElementById('progressBar').style.width = `${progress}%`;
        document.getElementById('progressText').textContent = `@lang('transfer.detailed_tracking.progress_text') ${progress}%`;

        // Mise à jour de l'historique détaillé
        const timeline = document.getElementById('detailedHistory');
        timeline.innerHTML = '';
        data.status_history.forEach(item => {
            const timelineItem = document.createElement('div');
            timelineItem.className = 'timeline-item';
            timelineItem.innerHTML = `
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <div class="timeline-date">${new Date(item.date).toLocaleDateString('fr-FR', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    })}</div>
                    <div class="timeline-status">
                        <span class="badge bg-${getStatusBadgeClass(item.status)}">
                            ${item.status_text}
                        </span>
                    </div>
                    <div class="timeline-notes">${item.notes || '-'}</div>
                </div>
            `;
            timeline.appendChild(timelineItem);
        });

        // Mise à jour des documents
        const documentList = document.getElementById('documentList');
        documentList.innerHTML = '';
        const documents = [
            { name: '@lang("transfer.documents.transcript")', path: data.transfer_request.transcript_path },
            { name: '@lang("transfer.documents.cv")', path: data.transfer_request.cv_path },
            { name: '@lang("transfer.documents.motivation_letter")', path: data.transfer_request.motivation_letter_path },
            { name: '@lang("transfer.documents.id_document")', path: data.transfer_request.id_document_path }
        ];
        documents.forEach(doc => {
            if (doc.path) {
                const docItem = document.createElement('a');
                docItem.href = `/storage/${doc.path}`;
                docItem.className = 'list-group-item list-group-item-action';
                docItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <span>${doc.name}</span>
                        <i class="fas fa-download"></i>
                    </div>
                `;
                documentList.appendChild(docItem);
            }
        });

        // Mise à jour des actions disponibles
        const actionList = document.getElementById('actionList');
        actionList.innerHTML = '';
        const actions = getAvailableActions(data.transfer_request.status);
        actions.forEach(action => {
            const actionItem = document.createElement('button');
            actionItem.className = 'list-group-item list-group-item-action';
            actionItem.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <span>${action.text}</span>
                    <i class="fas ${action.icon}"></i>
                </div>
            `;
            actionItem.onclick = action.handler;
            actionList.appendChild(actionItem);
        });
    }

    // Fonction pour calculer la progression
    function calculateProgress(status) {
        const progressMap = {
            'pending': 25,
            'confirmed': 50,
            'accepted': 75,
            'rejected': 100
        };
        return progressMap[status] || 0;
    }

    // Fonction pour obtenir les actions disponibles selon le statut
    function getAvailableActions(status) {
        const actions = [];
        switch(status) {
            case 'pending':
                actions.push({
                    text: '@lang("transfer.actions.cancel_request")',
                    icon: 'fa-times',
                    handler: () => cancelRequest()
                });
                break;
            case 'confirmed':
                actions.push({
                    text: '@lang("transfer.actions.view_details")',
                    icon: 'fa-eye',
                    handler: () => viewDetails()
                });
                break;
            case 'accepted':
                actions.push({
                    text: '@lang("transfer.actions.download_acceptance")',
                    icon: 'fa-download',
                    handler: () => downloadAcceptance()
                });
                break;
            case 'rejected':
                actions.push({
                    text: '@lang("transfer.actions.view_rejection_reason")',
                    icon: 'fa-info-circle',
                    handler: () => viewRejectionReason()
                });
                break;
        }
        return actions;
    }

    // Mettre à jour le suivi détaillé lors de la réception des données
    if (data.transfer_request) {
        updateDetailedTracking(data);
    }
});