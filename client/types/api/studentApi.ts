import type { CourseApi } from "@/types/api/courseApi";
import type { TutorApi } from "@/types/api/tutorApi";

export interface StudentApi {
  id: number;
  name: string;
  last_name: string;
  document_number: string;
  course: CourseApi;
  tutor: TutorApi;
  updated_at: string;
  created_at: string;
}
