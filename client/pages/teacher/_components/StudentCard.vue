<script setup lang="ts">
import { Badge } from '@/components/ui/badge'
import type { StudentType } from '@/types/models/Student'

defineProps<{
  data: StudentType
}>()

</script>

<template>
  <div class="grid aspect-square gap-4">
    <div class="grid gap-5 text-center">
      <div class="bg-[#1D1B20]/40 px-4 py-2.5 rounded-md shadow-xl">
        <p class="text-xl uppercase font-medium">
          {{ data.studentName }}
        </p>
      </div>
      <div class="flex items-center gap-16 justify-between">
        <p class="text-xl font-medium">
          Grado:
        </p>
        <Badge variant="secondary" class="px-5 bg-[#1D1B20]/40 font-bold text-2xl">
          {{ data.studentGrade }}
        </Badge>
      </div>
    </div>
    <div class="grid gap-3">
      <p class="text-center text-2xl font-medium">
        Lo retira:
      </p>
      <figure class="w-[150px] mx-auto relative h-[150px]">
        <img src="@/assets/images/student-2.png" class="rounded-full w-full h-full object-cover" decoding="async" loading="lazy">
      </figure>
      <div class="bg-[#1D1B20]/20 text-center px-4 py-2.5 rounded-md shadow-xl">
        <p class="text-xl uppercase font-medium">
          {{ data.authorizedName }}
        </p>
      </div>
    </div>
    <div>
      <div class="mb-3 space-y-1">
        <div class="text-center">
          <p class="text-xl">
            Contacto autorizado:
          </p>
          <p class="font-medium">
            {{ data.authorizedContact }}
          </p>
        </div>
        <div class="text-center">
          <p class="text-xl">
            Contacto apoderado:
          </p>
          <p class="font-medium">
            {{ data.tutorContact }}
          </p>
        </div>
      </div>
      <div class="grid grid-cols-2 items-center gap-3">
        <Button class="bg-[#1D1B20]/40 text-foreground text-lg uppercase font-medium px-4 py-1 rounded-md shadow-xl">
          No asistió
        </Button>
        <Button class="bg-[#1D1B20]/40 text-foreground px-4 py-1 rounded-md shadow-xl text-lg uppercase font-medium">
          Retirado
        </Button>
      </div>
      <DialogClose as-child>
        <Button variant="link" class="block w-fit mx-auto underline italic">
          Ver lista completa
        </Button>
      </DialogClose>
    </div>
  </div>
</template>
