export enum StudentFiltersEnum {
  NAME = "name",
  COURSE = "course.description",
  DOCUMENT_NUMBER = "document_number",
}

export type StudentFiltersFields =
  | "name"
  | "course.description"
  | "document_number";
