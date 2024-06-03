<template>
  <div class="bg-white p-4 mb-4 rounded-sm w-full">
    <h5 class="block mb-2 text-lg">Filtros</h5>
    <div class="flex items-center gap-1.5">
      <Select v-model="selectedFilter">
        <SelectTrigger class="w-56">
          <SelectValue placeholder="Seleccionar filtro" />
        </SelectTrigger>
        <SelectContent>
          <SelectGroup>
            <SelectLabel>Filtros</SelectLabel>
            <SelectItem
              v-for="option in filterOptions"
              :key="option.value"
              :value="option.value"
            >
              {{ option.label }}
            </SelectItem>
          </SelectGroup>
        </SelectContent>
      </Select>
      <template v-if="selectedFilter != TeacherFiltersEnum.COURSE">
        <Input
          v-model="filterInput"
          class="w-56"
          type="text"
          placeholder="Ingrese un valor a buscar"
          label="Nombre"
          @keydown.enter="filter"
        />
      </template>
      <template v-else>
        <Select v-model="filterInput">
          <SelectTrigger class="w-56">
            <SelectValue placeholder="Seleccionar curso" />
          </SelectTrigger>
          <SelectContent>
            <SelectGroup>
              <SelectLabel>Cursos</SelectLabel>
              <SelectItem
                v-for="course in COURSES"
                :key="course"
                :value="course"
              >
                {{ course }}
              </SelectItem>
            </SelectGroup>
          </SelectContent>
        </Select>
      </template>
      <Button type="submit" :disabled="!filterInput" @click="filter">
        Filtrar
      </Button>
      <Button v-if="filters.length > 0" type="submit" @click="removeFilters">
        Remover filtro
      </Button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Input } from "@/components/ui/input";
import { COURSES } from "@/statics/courses";
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { FilterDTO } from "@/dto/filterDTO";
import type { FilterOption } from "@/types/api/filters/filterOption";
import type { FilterApi } from "@/types/api/filters/filterApi";
import {
  TeacherFiltersEnum,
  type TeacherFiltersFields,
} from "@/types/api/filters/teacherFilters";

const emit = defineEmits<{
  (e: "on:filter", filters: FilterApi[]): void;
  (e: "on:remove", filters: FilterApi[]): void;
}>();

const filterInput: Ref<string> = ref("");
const selectedFilter: Ref<TeacherFiltersFields> = ref(TeacherFiltersEnum.NAME);
const filters: Ref<FilterApi[]> = ref([]);
const filterOptions: FilterOption<TeacherFiltersFields>[] = [
  {
    value: TeacherFiltersEnum.NAME,
    label: "Nombre",
  },
  {
    value: TeacherFiltersEnum.LAST_NAME,
    label: "Apellido",
  },
  {
    value: TeacherFiltersEnum.COURSE,
    label: "Curso",
  },
];

function filter() {
  filters.value = [];
  const newFilter = new FilterDTO(selectedFilter.value, filterInput.value);
  filters.value.push(Object.assign({}, newFilter));
  emit("on:filter", filters.value);
}

function removeFilters() {
  filters.value = [];
  emit("on:remove", filters.value);
}

watch(selectedFilter, () => {
  filterInput.value = "";
});
</script>
