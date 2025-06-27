@props(['id', 'title', 'message' => 'Apakah Anda yakin ingin menghapus data ini?', 'confirmText' => 'Hapus', 'cancelText' => 'Batal'])

<div id="{{ $id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">{{ $title }}</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">{{ $message ?? 'Apakah Anda yakin ingin menghapus data ini?' }}</p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="cancel-{{ $id }}" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    {{ $cancelText }}
                </button>
                <button id="confirm-{{ $id }}" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                    {{ $confirmText }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('{{ $id }}');
    const cancelBtn = document.getElementById('cancel-{{ $id }}');
    const confirmBtn = document.getElementById('confirm-{{ $id }}');
    
    // Close modal when clicking cancel
    cancelBtn.addEventListener('click', function() {
        modal.classList.add('hidden');
    });
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            modal.classList.add('hidden');
        }
    });
    
    // Store the form reference globally
    window.deleteForm = null;
    
    // Function to show modal
    window.showDeleteModal = function(formId, modalId) {
        window.deleteForm = document.getElementById(formId);
        document.getElementById(modalId).classList.remove('hidden');
    };
    
    // Confirm deletion
    confirmBtn.addEventListener('click', function() {
        if (window.deleteForm) {
            window.deleteForm.submit();
        }
        modal.classList.add('hidden');
    });
});
</script> 