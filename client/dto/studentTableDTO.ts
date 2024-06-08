import type { StudentApi } from "@/types/api/studentApi";
import { AuthorizedTableDTO } from "@/dto/authorizedTableDTO";

export class StudentTableDTO {
  constructor(
    public id: number,
    public firstName: string,
    public lastName: string,
    public dni: string,
    public course: string,
    public authorized: AuthorizedTableDTO,
  ) {}

  static fromApiModel(student: StudentApi) {
    return new StudentTableDTO(
      student.id,
      student.name,
      student.last_name,
      student.document_number,
      student.course.description,
      AuthorizedTableDTO.fromApiModel(student.authorized),
    );
  }

  static manyFromApiModel(students: StudentApi[]) {
    if (!students) return [];
    return students.map((s: StudentApi) => StudentTableDTO.fromApiModel(s));
  }
}
