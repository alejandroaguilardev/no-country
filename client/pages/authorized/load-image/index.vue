<template>
  <div class="lg:h-screen lg:h-[100dvh] py-5 grid place-items-center">
    <div class="flex flex-col items-center p-6 bg-white rounded-lg shadow-lg">
      <label
        for="file-upload"
        class="cursor-pointer flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-6 w-full h-64 text-gray-600 hover:bg-gray-100"
      >
        <svg
          class="w-12 h-12 mb-3 text-gray-400"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M7 16V10M7 10a2 2 0 1 1 4 0m0 0a2 2 0 1 1 4 0M7 10V8a2 2 0 1 1 4 0v2m0 6h.01M7 16v-4a2 2 0 1 1 4 0v4M7 16h.01"
          />
        </svg>
        <p class="text-lg">Arrastra y suelta tus archivos aquí</p>
        <p class="text-gray-500">o</p>
        <p class="text-blue-500">Selecciona un archivo</p>
        <input id="file-upload" type="file" class="hidden" @change="handleFileUpload">
      </label>
      <div v-if="file" class="mt-4 text-gray-700">
        <p>Archivo seleccionado:</p>
        <p class="font-semibold">
          <!-- {{ file.name }} -->
        </p>
        <button class="mt-2 text-red-500" @click="removeFile">
          Eliminar
        </button>
      </div>
      <button
        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg"
        :disabled="!file"
        @click="uploadFile"
      >
        Subir archivo
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const file = ref<File | null>(null)

const handleFileUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files[0]) {
    file.value = target.files[0]
  }
}

const removeFile = () => {
  file.value = null
  const input = document.getElementById('file-upload') as HTMLInputElement
  if (input) {
    input.value = ''
  }
}

const uploadFile = () => {
  if (!file.value) { return }

  const formData = new FormData()
  formData.append('file', file.value)

  // Simulate a file upload (you can replace this with your own upload logic)
  console.log('Uploading file:', file.value.name)
  setTimeout(() => {
    alert(`File "${file.value!.name}" uploaded successfully!`)
    file.value = null
  }, 2000)
}
</script>

<style scoped>

</style>
