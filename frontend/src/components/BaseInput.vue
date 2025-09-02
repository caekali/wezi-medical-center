<template>
  <div class="mt-1 relative">
    <input
      :id="id"
      :type="type"
      :autocomplete="autocomplete"
      :placeholder="placeholder"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      @input.native="onInput"
      :class="[
        'appearance-none block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition',
        error ? 'border-red-300 text-red-900 placeholder-red-300' : 'border-gray-300'
      ]"
      :required="required"
    />
    <div v-if="error" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
      <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
    </div>
    <p v-if="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
  </div>
</template>

<script setup>
defineProps({
  id: String,
  modelValue: String,
  type: { type: String, default: 'text' },
  autocomplete: String,
  placeholder: String,
  error: String,
  required: { type: Boolean, default: false },
  onInput: Function
})
</script>