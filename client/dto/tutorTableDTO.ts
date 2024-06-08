import { StudentTableDTO } from "./studentTableDTO";
import { AuthorizedTableDTO } from "./authorizedTableDTO";
import type { TutorApi } from "@/types/api/tutorApi";

export class TutorTableDTO {
  constructor(
    public id: number,
    public firstName: string,
    public lastName: string,
    public dni: string,
    public email: string,
    public phone: string,
    public authorizeds: AuthorizedTableDTO[],
    public students: StudentTableDTO[],
    public loadingStudents: boolean = false,
    public showStudents: boolean = false,
    public collapseControl: boolean = false,
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
      AuthorizedTableDTO.manyFromApiModel(tutor.authorizeds),
      [],
    );
  }

  static manyFromApiModel(tutors: TutorApi[]) {
    if (!tutors) return [];
    return tutors.map((t: TutorApi) => TutorTableDTO.fromApiModel(t));
  }
}
