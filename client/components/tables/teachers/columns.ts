import type { ColumnDef } from "@tanstack/vue-table";
import type { TeacherTableDTO } from "@/dto/teacherTableDTO";

export const columns: ColumnDef<TeacherTableDTO>[] = [
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
    accessorKey: "email",
    header: "Correo electronico",
  },
  {
    accessorKey: "phone",
    header: "N° Telefono",
  },
  {
    accessorKey: "course",
    header: "Curso",
  },
];
