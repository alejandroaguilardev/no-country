import { type ClassValue, clsx } from "clsx";
import { twMerge } from "tailwind-merge";
import { StudentStatusEnum } from "@/types/models";

export const cn = (...inputs: ClassValue[]) => {
  return twMerge(clsx(inputs));
};

export const wait = async (ms: number) => {
  await new Promise((resolve) => setTimeout(resolve, ms));
};

export const getStudentStatusText = (
  presence: number,
  status: number,
  leaveAlone: number,
) => {
  if (presence === 1) {
    if (leaveAlone === 0) {
      if (status === 1) {
        return "Retirado";
      } else {
        return "Por retirar";
      }
    } else {
      return "Sale solo";
    }
  } else {
    return "No asistió";
  }
};

export const getStudentStatusVariant = (
  presence: number,
  status: number,
  leaveAlone: number,
) => {
  if (presence === 1) {
    if (leaveAlone === 0) {
      if (status === 1) {
        return StudentStatusEnum.WITHDRAWN;
      } else {
        return StudentStatusEnum.NO_WITHDRAWN;
      }
    } else {
      return StudentStatusEnum.LEAVE_ALONE;
    }
  } else {
    return StudentStatusEnum.PRESENCE;
  }
};
