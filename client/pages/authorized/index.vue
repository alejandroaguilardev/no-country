<script setup lang="ts">
import * as z from "zod";
import { ErrorMessage, Field } from "vee-validate";
import { ref } from "vue";
import { toTypedSchema } from "@vee-validate/zod";
import { authorizedService } from "@/services";
import { useAuthStore } from "@/store/useAuthStore";
import { FormStep, FormWizard } from "@/components/ui/steps";
import { Checkbox } from "@/components/ui/checkbox";
import { useAuthorizedStore } from "@/store/useAuthorizedStore";
import type { StudentType } from "@/types/models";
import { wait } from "@/lib/utils";

const MAX_UPLOAD_SIZE = 1024 * 1024 * 5; // 5MB
const ACCEPTED_FILE_TYPES = ["image/jpeg", "image/png"];
const { user } = useAuthStore();

const validationSchema = [
  toTypedSchema(
    z
      .object({
        studentFullName: z
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
          if (val.studentFullName === undefined) {
            if (!val.selectAllStudents) {
              ctx.addIssue({
                code: z.ZodIssueCode.custom,
                path: ["studentFullName"],
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

      studentFullName: z.string({ required_error: "Este campo es requerido" }),
      fullName: z.string({ required_error: "Nombre y Apellido es requerido" }),
      dni: z
        .string({ required_error: "DNI es requerido" })
        .min(8, { message: "Mínimo 8 caracteres" }),

      phoneNumber: z
        .string({ required_error: "Teléfono es requerido" })
        .min(8, { message: "Mínimo 8 caracteres" }),
      studentLeavesAlone: z.boolean().default(false).optional(),
      tutorId: z.string().default(`${user}`).optional(),
    }),
  ),
];

const disabledStudentsSelect = ref(false);
const disabledInput = ref(false);
const imageUrl = ref(null);
const EventfileInput = ref(null);
const studentsId: Ref<string[]> = ref([]);

const emit = defineEmits(["imageloaded"]);

const { datosAuthorizedForWithdrawal } = authorizedService();

const store = useAuthorizedStore();

const studentList: Ref<StudentType[]> = ref([]);
const alertDialog: Ref<boolean> = ref(false);

const handleDisabledInput = () => {
  disabledInput.value = !disabledInput.value;
};

const handleDisableSelect = () => {
  disabledStudentsSelect.value = !disabledStudentsSelect.value;
};
const namePhoto = ref();
const onEventFilePicked = (event: any) => {
  const files = event.target.files;
  const image = files[0];
  namePhoto.value = files;
  const filename = files[0].name;
  if (filename.lastIndexOf(".") <= 0) {
    return alert("Por favor adicione um arquivo válido");
  }
  console.log("imageeen", files);
  const fileReader = new FileReader();
  fileReader.addEventListener("load", () => {
    imageUrl.value = fileReader.result;
    emit("imageloaded", imageUrl.value);
  });
  fileReader.readAsDataURL(files[0]);
};

const onSubmit = async (formData: any) => {
  formData.tutorId = user;
  if (formData.selectAllStudents) {
    if (disabledStudentsSelect.value) {
      studentsId.value = studentList.value.map((student) =>
        student.id.toString(),
      );
      formData.studentFullName = studentsId.value;

      await datosAuthorizedForWithdrawal(formData);
    }
  }

  try {
    await wait(3000);
    console.log("formData", formData);
  } catch (err) {
    console.log("err=>", err);
  } finally {
    alertDialog.value = true;
  }

  // datosAuthorizedForWithdrawal(formData);
};

const fetchTutors = async () => {
  try {
    const tutors = await store.getCargasApoderado();
    studentList.value = tutors;
  } catch (err) {
    console.log("err=>", err);
  }
};

watch(disabledStudentsSelect, () => {
  if (disabledStudentsSelect.value) {
    studentsId.value = studentList.value.map((student) =>
      student.id.toString(),
    );
  }
});

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
    <FormWizard :validation-schema="validationSchema" @submit="onSubmit">
      <!-- Step 1 -->
      <FormStep>
        <div class="grid gap-8 max-w-[425px] mx-auto">
          <Field
            v-slot="{ componentField }"
            name="studentFullName"
            type="select"
          >
            <div class="grid lg:grid-cols-[0.6fr_1fr] gap-6 items-center">
              <label for="studentFullName" class="label">Alumno</label>
              <div class="relative">
                <Select
                  v-bind="componentField"
                  :disabled="disabledStudentsSelect || disabledInput"
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
                <ErrorMessage name="studentFullName" class="error-message" />
              </div>
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
              v-slot="{ value, handleChange }"
              name="studentLeavesAlone"
              type="checkbox"
              :value="true"
              :unchecked-value="false"
            >
              <div
                class="grid grid-cols-[1fr_auto] gap-4 lg:gap-20 items-center w-full justify-between"
                @click="handleDisabledInput()"
              >
                <label for="studentLeavesAlone" class="label">
                  El alumno se retira sin acompañante
                </label>
                <Checkbox
                  id="studentLeavesAlone"
                  :checked="value"
                  @update:checked="handleChange"
                />
              </div>
            </Field>
          </div>
          <div class="grid lg:grid-cols-[0.6fr_1fr] gap-6 items-center">
            <label for="fullName" class="label">Nombre y apellido</label>
            <div class="relative">
              <Field
                id="fullName"
                name="fullName"
                class="input"
                placeholder="Nombre Completo"
                :disabled="disabledInput"
              />
              <ErrorMessage name="fullName" class="error-message" />
            </div>
          </div>

          <div class="grid lg:grid-cols-[0.6fr_1fr] gap-6 items-center">
            <label for="dni" class="label">D.N.I</label>
            <div class="relative">
              <Field
                id="dni"
                class="input"
                name="dni"
                type="text"
                placeholder="D.N.I"
                :disabled="disabledInput"
              />
              <ErrorMessage name="dni" class="error-message" />
            </div>
          </div>

          <div class="grid lg:grid-cols-[0.6fr_1fr] gap-6 items-center">
            <label for="dni" class="label">Teléfono</label>
            <div class="relative">
              <Field
                id="phoneNumber"
                class="input"
                name="phoneNumber"
                type="text"
                placeholder="569 123 45678"
                :disabled="disabledInput"
              />
              <ErrorMessage name="phoneNumber" class="error-message" />
            </div>
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
                      ref="EventfileInput"
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
              >¡Excelente! El curso completo fue retirado</AlertDialogTitle
            >
          </AlertDialogHeader>
          <AlertDialogFooter class="justify-end">
            <AlertDialogCancel> Ok </AlertDialogCancel>
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialog>
      <!-- Step 3 -->
      <!-- <FormStep> -->
      <!-- <Field v-slot="{ componentField, value }" name="datetime" type="date"> QUEDA COMENTADA-->
      <!-- <div class="grid gap-8 max-w-[425px] mb-20 mx-auto">
          <Popover>
            <div class="grid lg:grid-cols-[0.6fr_1fr] gap-6 items-center">
              <label class="label">Fecha de inicio</label>
              <PopoverTrigger as-child>
                <Button
                  variant="outline"
                  :class="
                    cn(
                      'w-full justify-start text-left font-normal',
                      !value && 'text-muted-foreground',
                    )
                  "
                >
                  <CalendarX2Icon class="mr-2 h-4 w-4" />
                  {{
                    value
                      ? df.format(value.toDate(getLocalTimeZone()))
                      : "Pick a date"
                  }}
                </Button>
              </PopoverTrigger>
            </div>

            <PopoverContent class="w-auto p-0">
              <Calendar v-model="value" mode="datetime" initial-focus />
            </PopoverContent>
          </Popover>
          <Popover>
            <div class="grid lg:grid-cols-[0.6fr_1fr] gap-6 items-center">
              <label class="label">Fecha de inicio</label>
              <PopoverTrigger as-child>
                <Button
                  variant="outline"
                  :class="
                    cn(
                      'w-full justify-start text-left font-normal',
                      !value && 'text-muted-foreground',
                    )
                  "
                >
                  <AlarmClock class="mr-2 h-4 w-4" />
                  {{
                    value
                      ? df.format(value.toDate(getLocalTimeZone()))
                      : "Pick a date"
                  }}
                </Button>
              </PopoverTrigger>
            </div>

            <PopoverContent class="w-auto p-0">
              <Calendar v-model="value" mode="datetime" initial-focus />
            </PopoverContent>
          </Popover>
        </div> -->

      <!-- </Field> QUEDA COMENTADA-->
      <!-- </FormStep> -->
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
  @apply text-destructive text-sm font-medium absolute mt-1;
}
</style>
