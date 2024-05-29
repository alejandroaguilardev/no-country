<template>
  <NuxtLayout name="admin-layout">
    <div>
      <h2 class="my-5 text-3xl">Estudiantes</h2>
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
                  v-for="filter in filterOptions"
                  :key="filter.value"
                  :value="filter.value"
                >
                  {{ filter.label }}
                </SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>
          <template v-if="selectedFilter != StudentFiltersEnum.COURSE">
            <Input
              v-model="filterInput"
              class="w-56"
              type="text"
              placeholder="Dato"
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
        </div>
      </div>
      <Table :columns="columns" :data="data" />
      <Pagination :total="total" @update:page="onChangePage" />
    </div>
  </NuxtLayout>
</template>

<script setup lang="ts">
import { columns, Table } from "@/components/tables/students";
import { Input } from "@/components/ui/input";
import { COURSES } from "@/statics/courses";
import { useAdminStudentsStore } from "@/store/useAdminStudentsStore";
import { StudentTableDTO } from "@/dto/studentTableDTO";
import type { FilterApi } from "@/types/api/filters/filterApi";
import {
  type StudentFiltersFields,
  StudentFiltersEnum,
} from "@/types/api/filters/studentFilters";
import Pagination from "@/components/tables/Pagination.vue";
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import type { FilterOption } from "@/types/api/filters/filterOption";
import { FilterDTO } from "@/dto/filterDTO";

const store = useAdminStudentsStore();
const data: Ref<StudentTableDTO[]> = ref([]);
const total: Ref<number> = ref(0);
const limit: Ref<number> = ref(10);
const filters: Ref<FilterApi[]> = ref([]);
const filterInput: Ref<string> = ref("");
const selectedFilter: Ref<StudentFiltersFields> = ref(StudentFiltersEnum.NAME);
const filterOptions: FilterOption<StudentFiltersFields>[] = [
  {
    value: StudentFiltersEnum.NAME,
    label: "Nombre",
  },
  {
    value: StudentFiltersEnum.COURSE,
    label: "Curso",
  },
  {
    value: StudentFiltersEnum.DOCUMENT_NUMBER,
    label: "DNI",
  },
];

function filter() {
  const newFilter = new FilterDTO(selectedFilter.value, filterInput.value);
  filters.value = [Object.assign({}, newFilter)];
  if (selectedFilter.value !== StudentFiltersEnum.COURSE) {
    filterInput.value = "";
  }
  fetchStudents(0, limit.value, filters.value);
}

async function fetchStudents(
  offset: number,
  limit: number,
  filters: FilterApi[],
) {
  const { rows, count } = await store.getStudents(offset, limit, filters);
  data.value = StudentTableDTO.manyFromApiModel(rows);
  total.value = count;
}

async function onChangePage(page: number) {
  const offset = (page - 1) * limit.value;
  await fetchStudents(offset, limit.value, filters.value);
}

onMounted(async () => {
  await fetchStudents(0, limit.value, filters.value);
});
</script>
