import type { ColumnDef } from "@tanstack/vue-table";
import type { StudentTableDTO } from "@/dto/studentTableDTO";

export const columns: ColumnDef<StudentTableDTO>[] = [
  {
    accessorKey: "id",
    header: "ID",
  },
  {
    accessorKey: "firstName",
    header: "Nombre",
  },
  {
    accessorKey: "lastName",
    header: "Apellido",
  },
  {
    accessorKey: "dni",
    header: "DNI",
  },
  {
    accessorKey: "course",
    header: () => h("div", { class: "text-center" }, "Curso"),
    cell: ({ row }) =>
      h("div", { class: "text-center" }, row.getValue("course")),
  },
];
