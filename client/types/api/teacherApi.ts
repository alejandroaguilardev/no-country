import type { CourseApi } from "@/types/api/courseApi";

export interface TeacherApi {
  id: number;
  name: string;
  last_name: string;
  course: CourseApi;
  phone: string;
  email: string;
  updated_at: string;
  created_at: string;
}
