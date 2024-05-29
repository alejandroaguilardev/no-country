import type { TutorApi } from "@/types/api/tutorApi";
import { StudentTableDTO } from "./studentTableDTO";

export class TutorTableDTO {
  constructor(
    public id: number,
    public firstName: string,
    public lastName: string,
    public dni: string,
    public email: string,
    public phone: string,
    public students: StudentTableDTO[],
    public loadingStudents: boolean = false,
    public showStudents: boolean = false
  ) {}

  static fromApiModel(tutor: TutorApi) {
    // const students = StudentTableDTO.manyFromApiModel(tutor.students); // TODO add this below when the api is ready
    return new TutorTableDTO(
      tutor.id,
      tutor.name,
      tutor.last_name,
      tutor.document_number,
      tutor.email,
      tutor.phone,
      [],
    );
  }

  static manyFromApiModel(tutors: TutorApi[]) {
    return tutors.map((t: TutorApi) => TutorTableDTO.fromApiModel(t));
  }
}
