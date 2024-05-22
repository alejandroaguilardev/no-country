import type { User } from "./User";

export interface StudentType extends User {
  id: number,
  studentName: stringnumber,
  studentPhoto: anynumber,
  studentContact: stringnumber,
  studentGrade: stringnumber,
  studentStatus: StudentStatusEnumnumber,
  authorizedName: stringnumber,
  authorizedContact: stringnumber,
  tutorContact: stringnumber,
}

export enum StudentStatusEnum {
  WITHDRAWN = 'Retirado',
  NO_WITHDRAWN = 'No Retirado',
  NO_ATTEND = 'No Asistió'
}

