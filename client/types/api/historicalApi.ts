export interface HistoricalApi {
  id: number;
  course_id: number;
  student_id: number;
  tutor_id: number;
  authorized_id: number;
  student_name: string;
  authorized_name: string;
  tutor_name: string;
  course_description: string;
  status: 0 | 1;
  presence: 0 | 1;
  leave_alone: 0 | 1;
  date: string;
  created_at: string;
  updated_at: string;
}
