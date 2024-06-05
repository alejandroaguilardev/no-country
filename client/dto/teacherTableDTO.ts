import type { TeacherApi } from "@/types/api/teacherApi";

export class TeacherTableDTO {
  constructor(
    public id: number,
    public firstName: string,
    public lastName: string,
    public email: string,
    public phone: string,
  ) {}

  static fromApiModel(teacher: TeacherApi) {
    return new TeacherTableDTO(
      teacher.id,
      teacher.name,
      teacher.last_name,
      teacher.email,
      teacher.phone,
    );
  }

  static manyFromApiModel(teachers: TeacherApi[]) {
    return teachers.map((t: TeacherApi) => TeacherTableDTO.fromApiModel(t));
  }
}
