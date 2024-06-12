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

      <Popover v-model:open="open">
        <PopoverTrigger as-child>
          <Button
            :disabled="selectedStudent"
            variant="outline"
            role="combobox"
            :aria-expanded="open"
            class="w-56 justify-between"
          >
            {{
              selectedStudent
                ? selectedStudent.name + " " + selectedStudent.last_name
                : "Seleccionar estudiante"
            }}
            <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
          </Button>
        </PopoverTrigger>
        <PopoverContent class="w-56 p-0">
          <Command
            v-model="selectedStudent"
            @update:search-term="searchStudents"
          >
            <CommandInput placeholder="Nombre o apellido" />
            <CommandEmpty class="px-4">
              <template v-if="errorOnSearchStudent">
                <p>Se produjo un error al buscar</p>
              </template>
              <template v-else-if="isSearchingStudent">
                <p>Cargando...</p>
              </template>
              <template v-else> No se encontraron estudiantes. </template>
            </CommandEmpty>
            <CommandList>
              <CommandGroup>
                <CommandItem
                  v-for="student in filteredStudents"
                  :key="student.id"
                  :value="student"
                  @select="onSelectStudent(student)"
                >
                  <Check
                    :class="
                      cn(
                        'mr-2 h-4 w-4',
                        selectedStudent?.id === student.id
                          ? 'opacity-100'
                          : 'opacity-0',
                      )
                    "
                  />
                  <p class="mr-2">
                    {{ student.name + " " + student.last_name }}
                  </p>
                  <span class="ml-auto opacity-60">{{
                    student.course.description
                  }}</span>
                </CommandItem>
              </CommandGroup>
            </CommandList>
          </Command>
        </PopoverContent>
      </Popover>
      <Button v-if="selectedStudent" type="submit" @click="removeFilters">
        Remover filtro
      </Button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Check, ChevronsUpDown } from "lucide-vue-next";
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
import type { FilterApi } from "@/types/api/filters/filterApi";
import {
  HistoricalFiltersEnum,
  type HistoricalFiltersFields,
} from "@/types/api/filters/historicalFilters";
import type { StudentApi } from "@/types/api/studentApi";
import api from "@/utils/authAxios";
import type { ResponseApi } from "@/types/api/responseApi";
import {
  StudentFiltersEnum,
  type StudentFiltersFields,
} from "@/types/api/filters/studentFilters";
import { cn } from "@/lib/utils";
import CommandItem from "@/components/ui/command/CommandItem.vue";
import CommandGroup from "@/components/ui/command/CommandGroup.vue";
import CommandList from "@/components/ui/command/CommandList.vue";
import CommandEmpty from "@/components/ui/command/CommandEmpty.vue";
import { FilterDTO } from "@/dto/filterDTO";

const emit = defineEmits<{
  (e: "on:filter", filters: FilterApi[]): void;
  (e: "on:remove", filters: FilterApi[]): void;
}>();

const open: Ref<boolean> = ref(false);
const selectedStudent: Ref<StudentApi | null> = ref(null);
const isSearchingStudent: Ref<boolean> = ref(false);
const errorOnSearchStudent: Ref<boolean> = ref(false);
const filteredStudents: Ref<StudentApi[]> = ref([]);
const selectedFilter: Ref<HistoricalFiltersFields> = ref(
  HistoricalFiltersEnum.STUDENT_ID,
);
const filters: Ref<FilterApi[]> = ref([]);
const filterOptions: FilterOption<HistoricalFiltersFields>[] = [
  {
    value: HistoricalFiltersEnum.STUDENT_ID,
    label: "Estudiante",
  },
];

function filter() {
  filters.value = [];
  const newFilter = new FilterDTO(
    selectedFilter.value,
    selectedStudent.value!.id,
  );
  filters.value.push(Object.assign({}, newFilter));
  emit("on:filter", filters.value);
}

function removeFilters() {
  selectedStudent.value = null;
  emit("on:remove", []);
}

async function getStudents(
  offset: number = 0,
  limit: number = 10,
  filters: FilterApi[] = [],
  globalFields: StudentFiltersFields[] = [],
  globalFilter: string = "",
) {
  const res = await api.get<ResponseApi<StudentApi>>("/api/students", {
    params: { offset, limit, filters, globalFields, globalFilter },
  });

  return res.data;
}

let timer: NodeJS.Timeout | null = null;

function searchStudents(v: string) {
  isSearchingStudent.value = true;
  errorOnSearchStudent.value = false;
  filteredStudents.value = [];

  if (timer) {
    clearTimeout(timer);
  }

  timer = setTimeout(async () => {
    try {
      const globalFields = [
        StudentFiltersEnum.NAME,
        StudentFiltersEnum.LAST_NAME,
      ];
      const { rows } = await getStudents(0, 10, [], globalFields, v);
      filteredStudents.value = rows;
    } catch (error) {
      errorOnSearchStudent.value = true;
    } finally {
      isSearchingStudent.value = false;
    }
  }, 500);
}

function onSelectStudent(student: StudentApi) {
  selectedStudent.value = student;
  filter();
  open.value = false;
}

watch(open, (v) => (!v ? (filteredStudents.value = []) : null));
</script>
