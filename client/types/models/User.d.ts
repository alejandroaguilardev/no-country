export type User = {
  id?: number
  name?: string
  email?: string
  email_verified_at?: Date | null
  password?: string
  rememberToken?: string
  Role?: Role
}

export const enum Role {
  AUTHORIZED = "authorized",
  TEACHER = "teacher",
  DIRECTIVE = "directive",
}
