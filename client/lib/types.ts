import type { StudentStatusEnum } from './enums'

export type StudentType = {
  id: number;
  studentName: string;
  studentPhoto: any;
  studentContact: string;
  studentGrade: string;
  studentStatus: StudentStatusEnum;
  authorizedName: string;
  authorizedContact: string;
  tutorContact: string;
};
