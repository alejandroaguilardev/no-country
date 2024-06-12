import type { HistoricalApi } from "@/types/api/historicalApi";

export class HistoricalTableDTO {
  constructor(
    public id: number,
    public student: string,
    public authorized: string,
    public status: string,
    public date: string,
  ) {}

  static fromApiModel(historical: HistoricalApi) {
    return new HistoricalTableDTO(
      historical.id,
      historical.student_name,
      historical.authorized_name ?? "",
      historical.status
        ? "Retirado"
        : historical.leave_alone
          ? "Se retiró solo"
          : !historical.presence
            ? "No asistió"
            : "Sin registro",
      historical.date,
    );
  }

  static manyFromApiModel(histoicals: HistoricalApi[]) {
    return histoicals.map((h: HistoricalApi) =>
      HistoricalTableDTO.fromApiModel(h),
    );
  }
}
