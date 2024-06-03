import { type ClassValue, clsx } from "clsx";
import { twMerge } from "tailwind-merge";
import { StudentStatusEnum } from "@/types/models";

export const cn = (...inputs: ClassValue[]) => {
  return twMerge(clsx(inputs));
};

export const wait = async (ms: number) => {
  await new Promise((resolve) => setTimeout(resolve, ms));
};

export const getStudentStatusText = (presence: number, status: number) => {
  if (presence === 1) {
    if (status === 1) {
      return "No retirado";
    } else {
      return "Retirado";
    }
  } else {
    return "No asistió";
  }
};

export const getStudentStatusVariant = (presence: number, status: number) => {
  if (presence === 1) {
    if (status === 1) {
      return StudentStatusEnum.NO_WITHDRAWN;
    } else {
      return StudentStatusEnum.WITHDRAWN;
    }
  } else {
    return StudentStatusEnum.PRESENCE;
  }
};
