@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label class="form-check-label" for="selectAll">
                    Sélectionner tout
                </label>
            </div>
            <div>
                <button id="deleteSelected" class="btn btn-danger btn-sm" disabled>
                    <i class="fas fa-trash"></i> Supprimer la sélection
                </button>
            </div>
        </div>

        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link" aria-hidden="true">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link" aria-hidden="true">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const deleteSelectedButton = document.getElementById('deleteSelected');
            const checkboxes = document.querySelectorAll('.item-checkbox');
            
            // Fonction pour mettre à jour l'état du bouton de suppression
            function updateDeleteButton() {
                const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
                deleteSelectedButton.disabled = checkedBoxes.length === 0;
            }

            // Gestionnaire pour la case à cocher "Sélectionner tout"
            selectAllCheckbox.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateDeleteButton();
            });

            // Gestionnaire pour les cases à cocher individuelles
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Vérifier si toutes les cases sont cochées
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                    updateDeleteButton();
                });
            });

            // Gestionnaire pour le bouton de suppression
            deleteSelectedButton.addEventListener('click', function() {
                const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked'))
                    .map(checkbox => checkbox.value);

                if (selectedItems.length > 0) {
                    if (confirm('Êtes-vous sûr de vouloir supprimer les éléments sélectionnés ?')) {
                        // Envoyer une requête AJAX pour supprimer les éléments
                        fetch('{{ route("delete.selected") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ items: selectedItems })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Recharger la page ou mettre à jour le tableau
                                window.location.reload();
                            } else {
                                alert('Une erreur est survenue lors de la suppression.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Une erreur est survenue lors de la suppression.');
                        });
                    }
                }
            });
        });
    </script>
@endif 