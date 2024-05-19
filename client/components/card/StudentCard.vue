<script setup lang="ts">
import type { StudentType } from '@/lib/types'

defineProps<{
  data: StudentType
}>()

</script>

<template>
  <div class="grid aspect-square gap-6">
    <div class="grid gap-3 text-center">
      <div class="bg-[#1D1B20]/40 px-4 py-2.5 rounded-md shadow-xl">
        <p class="text-2xl uppercase font-medium">
          {{ data.studentName }}
        </p>
      </div>
      <p class="text-2xl font-medium">
        Lo retira:
      </p>
      <div class="bg-[#1D1B20]/20 px-4 py-2.5 rounded-md shadow-xl">
        <p class="text-2xl uppercase font-medium">
          {{ data.authorizedName }}
        </p>
      </div>
    </div>
    <figure class="w-[188px] mx-auto relative h-[188px]">
      <img src="@/assets/images/student-2.png" class="rounded-full w-full h-full object-cover" decoding="async" loading="lazy">
    </figure>
    <div>
      <div class="mb-20 space-y-4">
        <p class="text-2xl">
          Contacto:
        </p>
        <p class="text-2xl">
          Contacto Apoderado:
        </p>
      </div>
      <div class="flex justify-center items-center gap-8 mb-6">
        <div class="bg-[#1D1B20]/40 px-4 py-1 rounded-md shadow-xl">
          <p class="text-xl uppercase font-medium">
            No asistió
          </p>
        </div>
        <div class="bg-[#1D1B20]/40 px-4 py-1 rounded-md shadow-xl">
          <p class="text-xl uppercase font-medium">
            Retirado
          </p>
        </div>
      </div>
      <NuxtLink to="/teacher/list" class="block w-fit mx-auto underline italic">
        Ver lista completa
      </NuxtLink>
    </div>
  </div>
</template>
