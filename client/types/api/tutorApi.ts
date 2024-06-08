import type { AuthorizedApi } from "./authorizedApi";
import type { StudentApi } from "./studentApi";

export interface TutorApi {
  id: number;
  name: string;
  last_name: string;
  document_number: string;
  email: string;
  phone: string;
  photo: string;
  students: StudentApi[];
  authorizeds: AuthorizedApi[];
  created_at: string;
  updated_at: string;
}
