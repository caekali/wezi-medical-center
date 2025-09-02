<script setup>
import { ref, computed, onMounted } from 'vue'
import Layout from '../components/Layout.vue'
import Navigation from '@/components/Navigation.vue'

const isPlaying = ref(true);
const currentSlide = ref(0);
const isSubmitting = ref(false);

// Appointment form data
const appointmentForm = ref({
  firstName: '',
  lastName: '',
  email: '',
  phone: '',
  department: '',
  preferredDate: '',
  preferredTime: '',
  reason: ''
});

// Computed property for minimum date (today)
const minDate = computed(() => {
  const today = new Date();
  return today.toISOString().split('T')[0];
});

// Slideshow functionality
let slideInterval;

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % 5;
  updateSlider();
};

const goToSlide = (index) => {
  currentSlide.value = index;
  updateSlider();
};

const updateSlider = () => {
  const slider = document.getElementById('background-slider');
  if (slider) {
    slider.style.transform = `translateX(-${currentSlide.value * 100}%)`;
  }
};

const togglePlayPause = () => {
  isPlaying.value = !isPlaying.value;
  if (isPlaying.value) {
    startSlideshow();
  } else {
    stopSlideshow();
  }
};

const startSlideshow = () => {
  slideInterval = setInterval(nextSlide, 5000);
};

const stopSlideshow = () => {
  clearInterval(slideInterval);
};

// Submit appointment function
const submitAppointment = async () => {
  isSubmitting.value = true;

  try {
    const response = await fetch('/api/appointments', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: JSON.stringify(appointmentForm.value)
    });

    if (response.ok) {
      // Reset form
      appointmentForm.value = {
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        department: '',
        preferredDate: '',
        preferredTime: '',
        reason: ''
      };
      alert('Appointment request submitted successfully! We will contact you soon to confirm.');
    } else {
      throw new Error('Failed to submit appointment');
    }
  } catch (error) {
    console.error('Error submitting appointment:', error);
    alert('There was an error submitting your appointment. Please try again.');
  } finally {
    isSubmitting.value = false;
  }
};

onMounted(() => {
  startSlideshow();

  // Add click listeners for slide indicators
  document.querySelectorAll('[data-slide-btn]').forEach((btn, index) => {
    btn.addEventListener('click', () => goToSlide(index));
  });
});
</script>

<template>
  <section id="hero-section" class="relative h-screen overflow-hidden" role="banner">
    <!-- Live Region for Screen Readers -->
    <div id="slide-announcer" class="sr-only" aria-live="polite" aria-atomic="true"></div>

    <!-- Background Gallery Slider -->
    <div class="absolute inset-0 w-full h-full" role="img" aria-label="Medical facility slideshow">
      <div class="flex transition-transform duration-1000 ease-in-out h-full" id="background-slider" aria-live="off">
        <div class="w-full h-full flex-shrink-0 relative">
          <img src="../assets/images/hero_1.jpg"
               class="w-full h-full object-cover"
               alt="Modern medical facility exterior with professional staff"
               loading="eager">
          <div class="absolute inset-0 bg-black/60"></div>
        </div>
        <div class="w-full h-full flex-shrink-0 relative">
          <img src="../assets/images/hero_2.jpg"
               class="w-full h-full object-cover"
               alt="Medical professionals providing patient care"
               loading="lazy">
          <div class="absolute inset-0 bg-black/60"></div>
        </div>
        <div class="w-full h-full flex-shrink-0 relative">
          <img src="../assets/images/hero_3.jpg"
               class="w-full h-full object-cover"
               alt="State-of-the-art medical equipment and technology"
               loading="lazy">
          <div class="absolute inset-0 bg-black/65"></div>
        </div>
        <div class="w-full h-full flex-shrink-0 relative">
          <img src="../assets/images/hero_4.jpg"
               class="w-full h-full object-cover"
               alt="Comfortable patient waiting and consultation areas"
               loading="lazy">
          <div class="absolute inset-0 bg-black/65"></div>
        </div>
        <div class="w-full h-full flex-shrink-0 relative">
          <img src="../assets/images/hero_5.jpg"
               class="w-full h-full object-cover"
               alt="Expert medical team in consultation"
               loading="lazy">
          <div class="absolute inset-0 bg-black/65"></div>
        </div>
      </div>
    </div>

    <!-- Content Overlay -->
    <div class="relative z-10 flex flex-col h-screen">
      <!-- Header with transparent navigation -->
      <div class="absolute top-0 left-0 right-0 z-20">
        <Navigation :is-transparent="true" />
        <Layout :show-skip-link="false" />
      </div>

      <main class="flex-1 flex flex-col md:flex-row items-center max-md:text-center justify-center px-6 sm:px-10 md:px-24 max-w-7xl mx-auto w-full" role="main">
        <div class="flex flex-col items-center md:items-start text-white">
<!--          <button class="mb-6 flex items-center space-x-2 border border-white/50 text-white text-xs rounded-full px-4 pr-1.5 py-1.5 hover:bg-white/10 transition backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-white"-->
<!--                  aria-label="Learn about our services">-->
<!--            <span>Explore Our Services</span>-->
<!--            <span class="flex items-center justify-center size-6 p-1 rounded-full bg-white/20" aria-hidden="true">-->
<!--                <svg width="14" height="11" viewBox="0 0 16 13" fill="none">-->
<!--                    <path d="M1 6.5h14M9.5 1 15 6.5 9.5 12" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />-->
<!--                </svg>-->
<!--            </span>-->
<!--          </button>-->

          <h1 class="text-white mt-20 font-semibold text-3xl sm:text-4xl md:text-5xl lg:text-6xl max-w-3xl leading-tight text-center md:text-left">
            <span class="text-indigo-200">LEAN ON US</span>
          </h1>

          <p class="mt-6 text-white/90 max-w-xl text-base sm:text-lg leading-relaxed text-center md:text-left">
            We believe we are the shoulder for people to lean on, the friend and comfort in their time of need.
          </p>

          <div class="flex flex-col md:flex-row items-center mt-8 gap-4">
            <a href="#book-appointment" class="bg-indigo-950 text-white px-8 pr-3 py-3 rounded-full text-sm font-medium flex items-center space-x-3 hover:bg-indigo-700 transition shadow-lg focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-transparent"
               aria-label="Book a medical appointment">
              Book Appointment
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M4.821 11.999h13.43m0 0-6.714-6.715m6.715 6.715-6.715 6.715" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </a>
          </div>
        </div>
      </main>

      <!-- Slideshow Controls -->
      <div class="flex items-center justify-center pb-8 space-x-6">
        <!-- Play/Pause Button -->
        <button @click="togglePlayPause"
                class="text-white hover:text-indigo-300 focus:outline-none focus:ring-2 focus:ring-white rounded p-1"
                :aria-label="isPlaying ? 'Pause slideshow' : 'Play slideshow'">
          <svg v-if="isPlaying" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z" fill="currentColor"/>
          </svg>
          <svg v-else width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M8 5v14l11-7z" fill="currentColor"/>
          </svg>
        </button>

        <!-- Dot Indicators -->
        <div class="flex items-center space-x-3" role="tablist" aria-label="Slideshow navigation">
          <button v-for="(slide, index) in 5" :key="index"
                  :data-slide-btn="index"
                  class="w-3 h-3 bg-white/50 rounded-full transition focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-transparent"
                  :class="{ 'bg-white ring-2 ring-white': index === currentSlide }"
                  :aria-label="`Go to slide ${index + 1}`"
                  :aria-pressed="index === currentSlide ? 'true' : 'false'"
                  role="tab"
                  :aria-selected="index === currentSlide ? 'true' : 'false'">
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Book Appointment Section -->
  <section id="book-appointment" class="bg-white py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 md:px-24">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
        <!-- Left Side - Information -->
        <div class="space-y-6">
          <div class="space-y-4">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900">
              Book Your Appointment
            </h2>
            <p class="text-lg text-gray-600 leading-relaxed">
              Schedule your visit with our experienced medical professionals. We're here to provide you with the best healthcare services.
            </p>
          </div>

          <div class="space-y-4">
            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0 w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center mt-1">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Expert Medical Care</h3>
                <p class="text-gray-600">Access to qualified specialists and modern medical equipment.</p>
              </div>
            </div>

            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0 w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center mt-1">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Flexible Scheduling</h3>
                <p class="text-gray-600">Choose from available time slots that work with your schedule.</p>
              </div>
            </div>

            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0 w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center mt-1">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Easy Booking Process</h3>
                <p class="text-gray-600">Simple and secure online appointment booking system.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Side - Appointment Form -->
        <div class="bg-gray-50 rounded-2xl p-8 lg:p-10 shadow-lg">
          <form @submit.prevent="submitAppointment" class="space-y-6">
            <div class="text-center mb-8">
              <h3 class="text-2xl font-bold text-gray-900 mb-2">Book Your Appointment</h3>
              <p class="text-gray-600">Fill out the form below and we'll contact you to confirm your appointment.</p>
            </div>

            <!-- Personal Information -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <div>
                <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">
                  First Name *
                </label>
                <input
                  type="text"
                  id="firstName"
                  v-model="appointmentForm.firstName"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                  placeholder="John"
                />
              </div>
              <div>
                <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">
                  Last Name *
                </label>
                <input
                  type="text"
                  id="lastName"
                  v-model="appointmentForm.lastName"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                  placeholder="Doe"
                />
              </div>
            </div>

            <!-- Contact Information -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                  Email Address *
                </label>
                <input
                  type="email"
                  id="email"
                  v-model="appointmentForm.email"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                  placeholder="john.doe@example.com"
                />
              </div>
              <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                  Phone Number *
                </label>
                <input
                  type="tel"
                  id="phone"
                  v-model="appointmentForm.phone"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                  placeholder="+1 (555) 123-4567"
                />
              </div>
            </div>

            <!-- Appointment Details -->
            <div>
              <label for="department" class="block text-sm font-medium text-gray-700 mb-2">
                Department *
              </label>
              <select
                id="department"
                v-model="appointmentForm.department"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
              >
                <option value="">Select Department</option>
                <option value="general">General Medicine</option>
                <option value="cardiology">Cardiology</option>
                <option value="dermatology">Dermatology</option>
                <option value="neurology">Neurology</option>
                <option value="orthopedics">Orthopedics</option>
                <option value="pediatrics">Pediatrics</option>
                <option value="emergency">Emergency Care</option>
              </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <div>
                <label for="preferredDate" class="block text-sm font-medium text-gray-700 mb-2">
                  Preferred Date *
                </label>
                <input
                  type="date"
                  id="preferredDate"
                  v-model="appointmentForm.preferredDate"
                  required
                  :min="minDate"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                />
              </div>
              <div>
                <label for="preferredTime" class="block text-sm font-medium text-gray-700 mb-2">
                  Preferred Time *
                </label>
                <select
                  id="preferredTime"
                  v-model="appointmentForm.preferredTime"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                >
                  <option value="">Select Time</option>
                  <option value="09:00">9:00 AM</option>
                  <option value="10:00">10:00 AM</option>
                  <option value="11:00">11:00 AM</option>
                  <option value="14:00">2:00 PM</option>
                  <option value="15:00">3:00 PM</option>
                  <option value="16:00">4:00 PM</option>
                </select>
              </div>
            </div>

            <!-- Additional Information -->
            <div>
              <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                Reason for Visit
              </label>
              <textarea
                id="reason"
                v-model="appointmentForm.reason"
                rows="4"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none"
                placeholder="Please describe your symptoms or reason for the appointment..."
              ></textarea>
            </div>

            <!-- Submit Button -->
            <button
              type="submit"
              :disabled="isSubmitting"
              class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <span v-if="isSubmitting" class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Submitting...
              </span>
              <span v-else>Book Appointment</span>
            </button>

            <p class="text-sm text-gray-500 text-center">
              By submitting this form, you agree to our
              <a href="#" class="text-indigo-600 hover:text-indigo-700">Privacy Policy</a>
              and <a href="#" class="text-indigo-600 hover:text-indigo-700">Terms of Service</a>.
            </p>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

@media (prefers-reduced-motion: reduce) {
  .transition-transform {
    transition: none;
  }
}
</style>