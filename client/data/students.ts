import type { StudentType } from "@/types/models";

export const students: StudentType[] = [
  {
    id: 1,
    name: "string",
    last_name: "string",
    document_number: "string",
    course_id: 1,
    tutor_id: 1,
    authorized_id: 1,
    course: CourseType,
    tutor: TutorType,
    authorized: AuthorizedType,
    retired: RetiredType,
  },
];
