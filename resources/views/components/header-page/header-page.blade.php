<div class="bg-white rounded-sm overflow-hidden border border-purple-50 transition-all duration-300">
    <!-- Gradient accent bar -->
    <div class="h-1.5 bg-gradient-to-r from-purple-400 to-purple-600"></div>

    <div class="p-6">
        <!-- Title with icon -->
        <div class="flex items-start gap-3 mb-3">
            <div class="bg-purple-100 p-2 rounded-lg">
                <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $title }}</h2>
        </div>

        <!-- Description with improved readability -->
        <p class="text-gray-600 pl-11 leading-relaxed">{{ $description }}</p>
    </div>
</div>
