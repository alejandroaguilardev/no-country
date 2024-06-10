import type { AuthorizedApi } from "@/types/api/authorizedApi";

export class AuthorizedTableDTO {
  constructor(
    public id: number,
    public firstName: string,
    public lastName: string,
    public dni: string,
    public phone: string,
    public photo: string,
  ) {}

  static fromApiModel(authorized: AuthorizedApi) {
    return new AuthorizedTableDTO(
      authorized.id,
      authorized.name,
      authorized.last_name,
      authorized.document_number,
      authorized.phone,
      authorized.photo,
    );
  }

  static manyFromApiModel(authorizeds: AuthorizedApi[]) {
    if (!authorizeds) return [];
    return authorizeds.map((t: AuthorizedApi) =>
      AuthorizedTableDTO.fromApiModel(t),
    );
  }
}
