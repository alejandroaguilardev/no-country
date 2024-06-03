export enum StudentFiltersEnum {
  NAME = "name",
  LAST_NAME = "last_name",
  COURSE = "course.description",
  DOCUMENT_NUMBER = "document_number",
}

export type StudentFiltersFields =
  | "name"
  | "last_name"
  | "course.description"
  | "document_number";
