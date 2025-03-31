<style>
/* Animaciones para el modal y la notificación */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeOut {
    from { opacity: 1; transform: translateY(0); }
    to { opacity: 0; transform: translateY(-10px); }
}

#confirm-modal {
    animation: fadeIn 0.3s ease-out;
}

#confirm-modal.hidden {
    animation: fadeOut 0.3s ease-out;
}

#flash-message {
    animation: fadeIn 0.3s ease-out;
}

#flash-message.hidden {
    animation: fadeOut 0.3s ease-out;
}
</style>

<!-- Notificación Flash -->
<div id="flash-message" class="fixed top-20 right-8 flex items-center justify-between p-4 text-sm rounded-lg shadow-md bg-white border border-gray-200 hidden z-50">
    <div class="flex items-center">
        <svg id="flash-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-500 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
        </svg>  
        <p id="flash-text" class="font-semibold text-gray-900"></p>
    </div>
    <button onclick="document.getElementById('flash-message').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>