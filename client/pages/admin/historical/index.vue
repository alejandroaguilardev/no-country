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
import { columns, Table } from "@/components/tables/historical";
import type { FilterApi } from "@/types/api/filters/filterApi";
import Pagination from "@/components/tables/Pagination.vue";
import Filters from "@/components/tables/historical/Filters.vue";
import { HistoricalTableDTO } from "@/dto/teacherHistoricalDTO";
import { useAdminHistoricalsStore } from "@/store/useAdminHistoricalsStore";

const store = useAdminHistoricalsStore();
const data: Ref<HistoricalTableDTO[]> = ref([]);
const total: Ref<number> = ref(0);
const limit: Ref<number> = ref(10);
const activeFilters: Ref<FilterApi[]> = ref([]);
const page: Ref<number> = ref(1);
const loading: Ref<boolean> = ref(true);
const failed: Ref<boolean> = ref(false);

function onFilter(filters: FilterApi[]) {
  fetchHistoricals(0, limit.value, filters);
  activeFilters.value = filters;
  page.value = 1;
}

function onRemoveFilters(filters: FilterApi[]) {
  console.log(filters);
  fetchHistoricals(0, limit.value, filters);
  activeFilters.value = filters;
  page.value = 1;
}

async function fetchHistoricals(
  offset: number,
  limit: number,
  filters: FilterApi[],
) {
  loading.value = true;
  try {
    const { rows, count } = await store.getHistoricals(offset, limit, filters);
    data.value = HistoricalTableDTO.manyFromApiModel(rows);
    total.value = count;
  } catch (error) {
    failed.value = true;
    toast.error("Ocurrio un error al cargar el historial de retiros");
  }
  loading.value = false;
}

async function onChangePage(page: number) {
  const offset = (page - 1) * limit.value;
  await fetchHistoricals(offset, limit.value, activeFilters.value);
}

watch(page, (v) => {
  onChangePage(v);
});

onMounted(async () => {
  await fetchHistoricals(0, limit.value, activeFilters.value);
});
</script>
