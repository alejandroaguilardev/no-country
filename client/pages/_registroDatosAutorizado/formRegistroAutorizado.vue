<script setup lang="ts">
import { ref } from 'vue'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { DropdownMenu } from '@/components/ui/dropdown-menu'

const schoolInfo = {
  logo: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTRJlM7tWbKZYxzdthfmaF9ndkO4CH7peOI95Er9jFgA&s'
}

const alumnos = ref([
  { value: 'Luis', index: '1' },
  { value: 'Susy', index: '2' },
  { value: 'Emma', index: '3' }
])

const codigoPais = ref([
  { value: 'Chile', index: '+56' },
  { value: 'España', index: '+34' },
  { value: 'Venezuela', index: '+58' }
])

const selectAll = ref(false)
const retiroSinAcompanante = ref(false)
</script>

<template>
  <div class="lg:h-screen lg:h-[100dvh] py-5 grid place-items-center">
    <form class="bg-white flex flex-col gap-5 items-center p-10 rounded-3xl font-normal text-3xl w-full max-w-xl">
      <img :src="schoolInfo.logo" alt="Logo School" class="w-24 h-24 mb-4">
      <h3 class="uppercase hidden sm:block text-center">
        Registro de datos de autorización
      </h3>
      <section class="flex flex-col gap-5 w-full">
        <div class="grid gap-4">
          <select v-for="item in alumnos" :key="item.value" class="appearance-none bg-slate-70 dark:bg-slate-700 p-2 rounded">
            <option>{{ item.value }}</option>
          </select>
          <svg class="pointer-events-none row-start-1 col-start-1">
            <!-- SVG content here -->
          </svg>
          <label for="selectAll" class="text-base w-full flex justify-between items-center">
            <p class="select-none">Seleccionar Todos</p>
            <Checkbox id="selectAll" v-model="selectAll" />
          </label>
          <label for="retiroSinAcompanante" class="text-base w-full flex justify-between items-center">
            <p class="select-none">El alumno se retira sin acompañante</p>
            <Checkbox id="retiroSinAcompanante" v-model="retiroSinAcompanante" />
          </label>
          <Input type="text" placeholder="Nombre y apellido" class="caret-black p-2 rounded" />
          <Input type="number" placeholder="D.N.I." class="p-2 rounded" />
          <div class="grid gap-4">
            <div>
              <h4 class="text-base">
                Teléfono:
              </h4>
            </div>
            <div class="grid grid-cols-3 gap-4">
              <DropdownMenu class="col-span-1" />
              <select v-for="item in codigoPais" :key="item.value" class="appearance-none bg-slate-70 dark:bg-slate-700 p-2 rounded col-span-1">
                <option>{{ item.index }}</option>
              </select>
              <Input type="tel" placeholder="Teléfono" class="col-span-1 p-2 rounded" />
            </div>
          </div>
        </div>
      </section>
      <Button type="button" class="cursor-pointer mt-4">
        Siguiente
      </Button>
      <div class="flex items-center mt-6">
        <!-- Step 1 -->
        <div class="flex items-center">
          <div class="relative">
            <div class="w-8 h-8 flex items-center justify-center bg-blue-500 text-white rounded-full">
              1
            </div>
            <div class="absolute top-1/2 transform -translate-y-1/2 w-10 h-1 bg-blue-500 left-8" />
          </div>
          <div class="ml-4">
            Step 1
          </div>
        </div>

        <!-- Step 2 -->
        <div class="flex items-center">
          <div class="relative">
            <div class="w-8 h-8 flex items-center justify-center bg-gray-300 text-gray-600 rounded-full">
              2
            </div>
            <div class="absolute top-1/2 transform -translate-y-1/2 w-10 h-1 bg-gray-300 left-8" />
          </div>
          <div class="ml-4">
            Step 2
          </div>
        </div>

        <!-- Step 3 -->
        <div class="flex items-center">
          <div class="relative">
            <div class="w-8 h-8 flex items-center justify-center bg-gray-300 text-gray-600 rounded-full">
              3
            </div>
          </div>
          <div class="ml-4">
            Step 3
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<style scoped></style>
