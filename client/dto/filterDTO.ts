import type { FilterApi } from "@/types/api/filters/filterApi";

export class FilterDTO implements FilterApi {
  constructor(
    public field: string,
    public value: string,
  ) {}
}
