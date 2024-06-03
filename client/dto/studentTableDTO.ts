import type { StudentApi } from "@/types/api/studentApi";

export class StudentTableDTO {
  constructor(
    public id: number,
    public firstName: string,
    public lastName: string,
    public dni: string,
    public course: string,
  ) {}

  static fromApiModel(student: StudentApi) {
    return new StudentTableDTO(
      student.id,
      student.name,
      student.last_name,
      student.document_number,
      student.course.description,
    );
  }

  static manyFromApiModel(students: StudentApi[]) {
    return students.map((s: StudentApi) => StudentTableDTO.fromApiModel(s));
  }
}
