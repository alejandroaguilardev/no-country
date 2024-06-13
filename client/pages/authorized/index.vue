<script setup lang="ts">
import * as z from "zod";
import { ErrorMessage, Field } from "vee-validate";
import { ref } from "vue";
import { toTypedSchema } from "@vee-validate/zod";
import { toast } from "vue-sonner";
import { useRouter } from "vue-router";
import { authorizedService } from "@/services";
import { useAuthStore } from "@/store/useAuthStore";
import { FormStep, FormWizard } from "@/components/ui/steps";
import { Checkbox } from "@/components/ui/checkbox";
import { useAuthorizedStore } from "@/store/useAuthorizedStore";
import type { StudentType } from "@/types/models";

const MAX_UPLOAD_SIZE = 1024 * 1024 * 5; // 5MB
const ACCEPTED_FILE_TYPES = ["image/jpeg", "image/png"];
const { user } = useAuthStore();
// Methods dependencies
const router = useRouter();

const validationSchema = [
  toTypedSchema(
    z
      .object({
        targetStudentId: z
          .string({
            required_error: "Este campo es requerido",
          })
          .optional(),
        selectAllStudents: z.boolean().default(false).optional(),
        fullName: z
          .string({ required_error: "Nombre y Apellido es requerido" })
          .min(2, { message: "Nombre completo debe ser de 2 caracteres" })
          .optional(),
        dni: z
          .string({ required_error: "DNI es requerido" })
          .min(8, { message: "DNI debe ser de 8 caracteres" })
          .optional(),
        phoneNumber: z
          .string({ required_error: "Teléfono es requerido" })
          .min(10, { message: "Teléfono debe ser de 10 caracteres" })
          .optional(),
        studentLeavesAlone: z.boolean().default(false).optional(),
        tutorId: z.string().default(`${user}`).optional(),
      })
      .superRefine((val, ctx) => {
        if (!val.studentLeavesAlone) {
          if (val.targetStudentId === undefined) {
            if (!val.selectAllStudents) {
              ctx.addIssue({
                code: z.ZodIssueCode.custom,
                path: ["targetStudentId"],
                message: "Este campo es requerido",
              });
            }
          }
          if (val.fullName === undefined) {
            ctx.addIssue({
              code: z.ZodIssueCode.custom,
              path: ["fullName"],
              message: "Nombre y Apellido es requerido",
            });
          }
          if (val.dni === undefined) {
            ctx.addIssue({
              code: z.ZodIssueCode.custom,
              path: ["dni"],
              message: "DNI es requerido",
            });
          }
          if (val.phoneNumber === undefined) {
            ctx.addIssue({
              code: z.ZodIssueCode.custom,
              path: ["phoneNumber"],
              message: "Teléfono es requerido",
            });
          }
        }
      }),
  ),
  toTypedSchema(
    z.object({
      tutorPhoto: z
        .instanceof(File, { message: "Imágen requerida" })
        .refine((file) => {
          return !file || file.size <= MAX_UPLOAD_SIZE;
        }, "El tamaño del archivo debe ser inferior a 5 MB.")
        .refine((file) => {
          return ACCEPTED_FILE_TYPES.includes(file.type);
        }, "Sólo se admiten los formatos .jpg y .png"),
    }),
  ),
];

const disabledStudentsSelect = ref(false);
const imageUrl: Ref<string> = ref("");

const { datosAuthorizedForWithdrawal, leaveAlone } = authorizedService();

const store = useAuthorizedStore();

const studentList: Ref<StudentType[]> = ref([]);
const alertDialog: Ref<boolean> = ref(false);

const handleDisableSelect = () => {
  disabledStudentsSelect.value = !disabledStudentsSelect.value;
};

const onEventFilePicked = (event: any) => {
  const files = event.target.files;
  const filename = files[0].name;
  const fileReader = new FileReader();

  if (filename.lastIndexOf(".") <= 0) {
    return alert("Por favor adicione un arquivo válido");
  }

  fileReader.addEventListener("load", () => {
    imageUrl.value = fileReader.result as string;
  });
  fileReader.readAsDataURL(files[0]);
};

const onSubmit = async (formData: any) => {
  const studentsId: number[] = [];

  if (formData.selectAllStudents) {
    studentList.value.forEach((student) => studentsId.push(student.id));
  } else {
    studentsId.push(formData.targetStudentId);
  }

  try {
    if (formData.studentLeavesAlone) {
      await leaveAlone({
        leave_alone: 1,
        student_id: studentsId,
      });
    } else {
      await datosAuthorizedForWithdrawal(formData, user!.id!, studentsId);
    }
    alertDialog.value = true;
    setTimeout(() => {
      router.push("/");
    }, 2000);
  } catch (err) {
    toast.error(
      "Ocurrió un error y no se pudieron guardar los datos, intente nuevamente más tarde",
    );
  }
};

const fetchTutors = async () => {
  try {
    const tutors = await store.getCargasApoderado();
    studentList.value = tutors;
  } catch (err) {
    console.log("err=>", err);
  }
};

onMounted(async () => {
  await fetchTutors();
});
</script>

<template>
  <main class="grid items-center px-4 lg:px-6">
    <img
      src="@/assets/images/tutor-background.png"
      class="fixed inset-0 w-full h-full object-cover"
      alt="Background"
    />
    <FormWizard
      v-slot="{ values }"
      :validation-schema="validationSchema"
      @submit="onSubmit"
    >
      <!-- Step 1 -->
      <FormStep>
        <div class="grid gap-8 max-w-[425px] mx-auto">
          <Field
            v-slot="{ componentField }"
            name="targetStudentId"
            type="select"
          >
            <div class="flex flex-col">
              <label for="targetStudentId" class="label mb-6">Alumno</label>
              <Select
                v-bind="componentField"
                :disabled="values.selectAllStudents"
              >
                <SelectTrigger>
                  <SelectValue placeholder="Seleccionar alumno" />
                </SelectTrigger>

                <SelectContent>
                  <SelectGroup
                    v-for="student in studentList"
                    :key="student.id"
                    class="p-0"
                  >
                    <SelectItem :value="student.id.toString()">
                      {{ student.name }}
                    </SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
              <ErrorMessage name="targetStudentId" class="error-message" />
            </div>
          </Field>

          <div class="grid gap-4">
            <Field
              v-slot="{ value, handleChange }"
              name="selectAllStudents"
              type="checkbox"
              :value="true"
              :unchecked-value="false"
            >
              <div
                class="grid grid-cols-[1fr_auto] gap-4 lg:gap-20 items-center w-full justify-between"
                @click="handleDisableSelect()"
              >
                <label for="selectAllStudents" class="label">
                  Seleccionar todos
                </label>
                <Checkbox
                  id="selectAllStudents"
                  :checked="value"
                  @update:checked="handleChange"
                />
              </div>
            </Field>

            <Field
              v-slot="{ handleChange }"
              name="studentLeavesAlone"
              type="checkbox"
              :value="true"
              :unchecked-value="false"
            >
              <div
                class="grid grid-cols-[1fr_auto] gap-4 lg:gap-20 items-center w-full justify-between"
              >
                <label for="studentLeavesAlone" class="label">
                  El alumno se retira sin acompañante
                </label>
                <Checkbox
                  id="studentLeavesAlone"
                  @update:checked="handleChange"
                />
              </div>
            </Field>
          </div>
          <div class="flex flex-col">
            <label for="fullName" class="label mb-6">Nombre y apellido</label>
            <Field
              id="fullName"
              name="fullName"
              class="input"
              placeholder="Nombre Completo"
              :disabled="values.studentLeavesAlone"
            />
            <ErrorMessage name="fullName" class="error-message" />
          </div>

          <div class="flex flex-col">
            <label for="dni" class="label mb-6">D.N.I</label>
            <Field
              id="dni"
              class="input"
              name="dni"
              type="text"
              placeholder="D.N.I"
              :disabled="values.studentLeavesAlone"
            />
            <ErrorMessage name="dni" class="error-message" />
          </div>

          <div class="flex flex-col">
            <label for="dni" class="label mb-6">Teléfono</label>
            <Field
              id="phoneNumber"
              class="input"
              name="phoneNumber"
              type="text"
              placeholder="569 123 45678"
              :disabled="values.studentLeavesAlone"
            />
            <ErrorMessage name="phoneNumber" class="error-message" />
          </div>
        </div>
      </FormStep>

      <!-- Step 2 -->
      <FormStep>
        <div class="grid gap-10">
          <div class="relative">
            <div
              class="grid grid-cols-[auto_1fr] mb-4 gap-5 w-full items-center"
            >
              <figure class="w-[100px] h-[100px] rounded-lg">
                <img
                  v-if="imageUrl"
                  :src="imageUrl"
                  class="h-full rounded-lg w-full"
                  alt="Imagen seleccionada"
                />
                <img
                  v-if="!imageUrl"
                  src="@/assets/images/empty-photo.png"
                  class="h-full rounded-lg w-full"
                  alt="Imagen seleccionada"
                />
              </figure>
              <div>
                <Label for="picture" class="flex-col">
                  <p class="mb-3.5 italic font-regular">
                    Sube una imagen cuadrada, con un tamaño inferior a 5MB.
                  </p>
                  <div class="relative">
                    <Field
                      id="tutorPhoto"
                      class="input border-none !bg-background py-6 h-auto"
                      name="tutorPhoto"
                      type="file"
                      @change="onEventFilePicked"
                    />
                  </div>
                </Label>
              </div>
            </div>
            <ErrorMessage
              name="tutorPhoto"
              class="error-message bottom-0 right-0"
            />
          </div>
        </div>
      </FormStep>

      <AlertDialog v-model:open="alertDialog">
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle class="text-start"
              >Datos actualizados con éxito</AlertDialogTitle
            >
          </AlertDialogHeader>
          <AlertDialogFooter class="justify-end">
            <AlertDialogCancel> Ok </AlertDialogCancel>
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialog>
    </FormWizard>
  </main>
</template>

<style scoped>
.input {
  @apply flex h-[46px] w-full rounded-md border-2 border-input bg-transparent px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:cursor-not-allowed disabled:opacity-50;
}

.input:hover {
  @apply border-black;
}

.input:focus-visible {
  @apply border-black outline-none shadow-xl;
}

.input::placeholder {
  @apply text-muted-foreground;
}

.label {
  @apply text-base leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70;
}

.error-message {
  @apply text-destructive text-sm font-medium mt-1;
}
</style>
