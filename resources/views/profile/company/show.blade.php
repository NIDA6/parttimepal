<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $companyProfile->company_name }}
            </h2>
            @auth
                @if(auth()->user()->role === 'Jobseeker')
                    <button onclick="openReviewModal()" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200">
                        <i class="fas fa-star mr-2"></i>
                        {{ $companyProfile->reviews->where('jobseeker_id', auth()->id())->count() ? 'My Review' : 'Write a Review' }}
                    </button>
                @endif
            @endauth
        </div>
    </x-slot>

    <!-- Review Modal -->
    <div id="reviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                @auth
                    @if(auth()->user()->role === 'Jobseeker')
                        @php
                            $userReview = $companyProfile->reviews->where('jobseeker_id', auth()->id())->first();
                        @endphp

                        @if($userReview)
                            <!-- Edit/Delete Review Form -->
                            <h3 class="text-lg font-medium text-gray-900 mb-4">My Review</h3>
                            <form action="{{ route('reviews.update', $userReview) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Rating</label>
                                    <div class="mt-1 flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <input type="radio" name="rating" value="{{ $i }}" id="rating{{ $i }}" 
                                                class="hidden" {{ $userReview->rating == $i ? 'checked' : '' }}>
                                            <label for="rating{{ $i }}" class="cursor-pointer">
                                                <i class="fas fa-star text-2xl {{ $userReview->rating >= $i ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400"></i>
                                            </label>
                                        @endfor
                                    </div>
                                </div>

                                <div>
                                    <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                                    <textarea name="comment" id="comment" rows="4" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>{{ old('comment', $userReview->comment) }}</textarea>
                                </div>

                                <div class="flex justify-between">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                        Update Review
                                    </button>
                                    <form action="{{ route('reviews.destroy', $userReview) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this review?')"
                                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                            Delete Review
                                        </button>
                                    </form>
                                </div>
                            </form>
                        @else
                            <!-- New Review Form -->
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Write a Review</h3>
                            <form action="{{ route('reviews.store', $companyProfile) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Rating</label>
                                    <div class="mt-1 flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <input type="radio" name="rating" value="{{ $i }}" id="rating{{ $i }}" 
                                                class="hidden" required>
                                            <label for="rating{{ $i }}" class="cursor-pointer">
                                                <i class="fas fa-star text-2xl text-gray-300 hover:text-yellow-400"></i>
                                            </label>
                                        @endfor
                                    </div>
                                </div>

                                <div>
                                    <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                                    <textarea name="comment" id="comment" rows="4" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required></textarea>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                        Submit Review
                                    </button>
                                </div>
                            </form>
                        @endif
                    @endif
                @endauth
                <div class="mt-4 flex justify-end">
                    <button onclick="closeReviewModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add JavaScript for modal -->
    <script>
        function openReviewModal() {
            document.getElementById('reviewModal').classList.remove('hidden');
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('reviewModal');
            if (event.target == modal) {
                closeReviewModal();
            }
        }

        // Star rating interaction
        document.querySelectorAll('input[name="rating"]').forEach(input => {
            input.addEventListener('change', function() {
                const stars = this.parentElement.querySelectorAll('.fa-star');
                const rating = parseInt(this.value);
                stars.forEach((star, index) => {
                    star.classList.toggle('text-yellow-400', index < rating);
                    star.classList.toggle('text-gray-300', index >= rating);
                });
            });
        });
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Company Information -->
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-pink-600 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">{{ $companyProfile->company_name }}</h1>
                                <p class="text-gray-600">{{ $companyProfile->location }}</p>
                            </div>
                        </div>

                        <!-- Company Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Company Information</h3>
                                <div class="space-y-4">
                                    @if($companyProfile->website_url)
                                        <div>
                                            <p class="text-sm text-gray-600">Website</p>
                                            <a href="{{ $companyProfile->website_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                                                {{ $companyProfile->website_url }}
                                            </a>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm text-gray-600">Email</p>
                                        <p class="text-gray-900">{{ $companyProfile->company_email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Phone</p>
                                        <p class="text-gray-900">{{ $companyProfile->phone_number }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Established</p>
                                        <p class="text-gray-900">{{ $companyProfile->establish_date->format('F Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">About Us</h3>
                                <p class="text-gray-700">{{ $companyProfile->description }}</p>
                            </div>
                        </div>

                        <!-- Social Media Links -->
                        @if($companyProfile->socialMedia->isNotEmpty())
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Social Media</h3>
                                <div class="flex flex-wrap gap-4">
                                    @foreach($companyProfile->socialMedia as $social)
                                        <a href="{{ $social->url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                                            {{ $social->platform }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Job Listings -->
                        @if($companyProfile->jobListings->isNotEmpty())
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Current Job Openings</h3>
                                <div class="space-y-4">
                                    @foreach($companyProfile->jobListings as $job)
                                        <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                            <h4 class="text-xl font-semibold text-gray-900">{{ $job->title }}</h4>
                                            <div class="mt-2 flex items-center gap-4 text-sm text-gray-600">
                                                <span>{{ $job->job_time }}</span>
                                                <span>•</span>
                                                <span>${{ $job->salary }}</span>
                                                <span>•</span>
                                                <span>Posted {{ $job->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="mt-4">
                                                <a href="{{ route('job-listings.show', $job) }}" class="text-indigo-600 hover:text-indigo-800">
                                                    View Details →
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-4 mt-8">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Dashboard
                        </a>
                        @if(auth()->id() === $companyProfile->user_id)
                            <a href="{{ route('company.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                Edit Profile
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Reviews</h3>
                    <div class="space-y-4">
                        @forelse($companyProfile->reviews()->with('jobseeker')->latest()->get() as $review)
                            <div class="border rounded-lg p-4 {{ $review->jobseeker_id === auth()->id() ? 'bg-gray-50' : '' }}">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium text-gray-900">{{ $review->jobseeker->name }}</span>
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="mt-2 text-gray-600">{{ $review->comment }}</p>
                                        <p class="mt-1 text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>

                                    <!-- Review Actions (only for the review author) -->
                                    @auth
                                        @if(auth()->id() === $review->jobseeker_id)
                                            <div class="flex items-center gap-2">
                                                <button onclick="openEditModal({{ $review->id }})" 
                                                        class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200">
                                                    <i class="fas fa-edit mr-1"></i>
                                                    Edit
                                                </button>
                                                
                                                <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('Are you sure you want to delete this review?')"
                                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">
                                                        <i class="fas fa-trash-alt mr-1"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No reviews yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Edit Review Modal -->
            <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Review</h3>
                        <form id="editReviewForm" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rating</label>
                                <div class="mt-1 flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" value="{{ $i }}" id="editRating{{ $i }}" 
                                            class="hidden">
                                        <label for="editRating{{ $i }}" class="cursor-pointer">
                                            <i class="fas fa-star text-2xl text-gray-300 hover:text-yellow-400"></i>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label for="editComment" class="block text-sm font-medium text-gray-700">Comment</label>
                                <textarea name="comment" id="editComment" rows="4" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required></textarea>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                    Update Review
                                </button>
                                <button type="button" onclick="closeEditModal()" 
                                        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                function openEditModal(reviewId) {
                    const modal = document.getElementById('editModal');
                    const form = document.getElementById('editReviewForm');
                    const review = @json($companyProfile->reviews);
                    const currentReview = review.find(r => r.id === reviewId);
                    
                    if (currentReview) {
                        form.action = `/reviews/${reviewId}`;
                        document.getElementById('editComment').value = currentReview.comment;
                        
                        // Set the rating
                        const ratingInput = document.querySelector(`#editRating${currentReview.rating}`);
                        if (ratingInput) {
                            ratingInput.checked = true;
                            const stars = ratingInput.parentElement.querySelectorAll('.fa-star');
                            stars.forEach((star, index) => {
                                star.classList.toggle('text-yellow-400', index < currentReview.rating);
                                star.classList.toggle('text-gray-300', index >= currentReview.rating);
                            });
                        }
                    }
                    
                    modal.classList.remove('hidden');
                }

                function closeEditModal() {
                    document.getElementById('editModal').classList.add('hidden');
                }

                // Close edit modal when clicking outside
                window.onclick = function(event) {
                    const modal = document.getElementById('editModal');
                    if (event.target == modal) {
                        closeEditModal();
                    }
                }

                // Star rating interaction for edit modal
                document.querySelectorAll('#editModal input[name="rating"]').forEach(input => {
                    input.addEventListener('change', function() {
                        const stars = this.parentElement.querySelectorAll('.fa-star');
                        const rating = parseInt(this.value);
                        stars.forEach((star, index) => {
                            star.classList.toggle('text-yellow-400', index < rating);
                            star.classList.toggle('text-gray-300', index >= rating);
                        });
                    });
                });
            </script>
        </div>
    </div>
</x-app-layout> 