import type { CourseApi } from "@/types/api/courseApi";
import type { TutorApi } from "@/types/api/tutorApi";
import type { AuthorizedApi } from "@/types/api/authorizedApi";

export interface StudentApi {
  id: number;
  name: string;
  last_name: string;
  document_number: string;
  course: CourseApi;
  tutor: TutorApi;
  authorized: AuthorizedApi;
  updated_at: string;
  created_at: string;
}
