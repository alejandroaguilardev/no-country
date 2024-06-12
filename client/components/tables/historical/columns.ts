import type { ColumnDef } from "@tanstack/vue-table";
import type { HistoricalTableDTO } from "@/dto/teacherHistoricalDTO";

export const columns: ColumnDef<HistoricalTableDTO>[] = [
  {
    accessorKey: "id",
    header: "ID",
  },
  {
    accessorKey: "student",
    header: "Estudiante",
  },
  {
    accessorKey: "authorized",
    header: "Autorizado",
  },
  {
    accessorKey: "status",
    header: "Estado",
  },
  {
    accessorKey: "date",
    header: "Fecha",
  },
];
