import type { ColumnDef } from "@tanstack/vue-table";
import type { TutorTableDTO } from "@/dto/tutorTableDTO";

export const columns: ColumnDef<TutorTableDTO>[] = [
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
    header: "N° Documento",
  },
  {
    accessorKey: "email",
    header: "Correo electronico",
  },
  {
    accessorKey: "phone",
    header: "N° Telefono",
  },
];
