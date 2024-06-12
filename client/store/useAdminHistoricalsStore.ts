import { defineStore } from "pinia";
import type { ResponseApi } from "@/types/api/responseApi";
import type { FilterApi } from "@/types/api/filters/filterApi";
import api from "@/utils/authAxios";
import type { HistoricalApi } from "@/types/api/historicalApi";

export const useAdminHistoricalsStore = defineStore(
  "adminHistoricalsStore",
  () => {
    const ENDPOINT = "/api/historicalretired";

    async function getHistoricals(
      offset: number = 0,
      limit: number = 10,
      filters: FilterApi[] = [],
    ) {
      const res = await api.get<ResponseApi<HistoricalApi>>(ENDPOINT, {
        params: { offset, limit, filters },
      });

      return res.data;
    }

    return {
      getHistoricals,
    };
  },
);
