<template>
  <NuxtLayout name="admin-layout">
    <div>
      <Filters
        @on:filter="onFilter($event)"
        @on:remove="onRemoveFilters($event)"
      />
      <Table
        :columns="columns"
        :data="data"
        :loading="loading"
        :failed="failed"
      />
      <Pagination v-model:page="page" :total="total" />
    </div>
  </NuxtLayout>
</template>

<script setup lang="ts">
import { toast } from "vue-sonner";
import { columns, Table } from "@/components/tables/teachers";
import { TeacherTableDTO } from "@/dto/teacherTableDTO";
import { useAdminTeachersStore } from "@/store/useAdminTeachersStore";
import type { FilterApi } from "@/types/api/filters/filterApi";
import Pagination from "@/components/tables/Pagination.vue";
import Filters from "@/components/tables/teachers/Filters.vue";

const store = useAdminTeachersStore();
const data: Ref<TeacherTableDTO[]> = ref([]);
const total: Ref<number> = ref(0);
const limit: Ref<number> = ref(10);
const activeFilters: Ref<FilterApi[]> = ref([]);
const page: Ref<number> = ref(1);
const loading: Ref<boolean> = ref(true);
const failed: Ref<boolean> = ref(false);

function onFilter(filters: FilterApi[]) {
  fetchTeachers(0, limit.value, filters);
  activeFilters.value = filters;
  page.value = 1;
}

function onRemoveFilters(filters: FilterApi[]) {
  fetchTeachers(0, limit.value, filters);
  activeFilters.value = filters;
  page.value = 1;
}

async function fetchTeachers(
  offset: number,
  limit: number,
  filters: FilterApi[],
) {
  loading.value = true;
  try {
    const { rows, count } = await store.getTeachers(offset, limit, filters);
    data.value = TeacherTableDTO.manyFromApiModel(rows);
    total.value = count;
  } catch (error) {
    failed.value = true;
    toast.error("Ocurrio un error al cargar los maestros");
  }
  loading.value = false;
}

async function onChangePage(page: number) {
  const offset = (page - 1) * limit.value;
  await fetchTeachers(offset, limit.value, activeFilters.value);
}

watch(page, (v) => {
  onChangePage(v);
});

onMounted(async () => {
  await fetchTeachers(0, limit.value, activeFilters.value);
});
</script>
