<script setup lang="ts">
import { toTypedSchema } from "@vee-validate/zod";
import { useForm } from "vee-validate";
import * as z from "zod";

import { LoaderCircle } from "lucide-vue-next";
import { toast } from "vue-sonner";
import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import { FormField, FormMessage } from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { type LoginReq } from "@/types/queries";
import { useAuthStore } from "@/store/useAuthStore";

const mainHeight = "lg:h-screen lg:h-[100dvh] ";

const formSchema = toTypedSchema(
  z.object({
    email: z
      .string({ required_error: "Email Requerido" })
      .min(1, { message: "Mínimo un caracter" })
      .email({ message: "Debe ser un email" }),
    password: z
      .string({ required_error: "Contraseña Requerida" })
      .min(3, { message: "Mínimo 3 caracteres" }),
    rememberPassword: z.boolean().default(false),
  }),
);

const { isFieldDirty, handleSubmit, isSubmitting, setValues, meta } = useForm({
  validationSchema: formSchema,
});

const onSubmit = handleSubmit(async (req: LoginReq) => {
  const { login } = useAuthStore();
  try {
    await login(req, !!req.rememberPassword);
  } catch (err: unknown) {
    toast.error((err as Error).message);
  }
});
onMounted(() => {
  const preReqRaw: string | null = localStorage.getItem("saveAccount");
  if (preReqRaw) {
    const preReq: LoginReq = JSON.parse(preReqRaw);
    setValues({
      email: preReq.email,
      password: preReq.password,
      rememberPassword: preReq.rememberPassword,
    });
  }
});
</script>

<template>
  <NuxtLayout
    name="main-layout"
    :is-required="false"
    class="w-full h-screen flex justify-center md:justify-end"
  >
    <div
      class="absolute right-0 top-0 -z-10 w-full h-full bg-[#3E5A85] sm:bg-emerald-500"
    >
      <img
        src="@/assets/images/login-bg.jpg"
        alt=""
        class="h-screen w-full object-cover hidden sm:block opacity-85"
      />
    </div>
    <main :class="mainHeight + 'grid place-items-center py-10'">
      <form
        class="flex flex-col items-center gap-8 rounded-3xl bg-white px-16 py-10 text-3xl font-normal"
        @submit="onSubmit"
      >
        <figure
          class="h-[208px] w-[267px] bg-[#D9D9D9] grid place-items-center rounded-[20px]"
        >
          <img src="@/assets/images/logo-form.png" />
        </figure>
        <h1 class="hidden text-center sm:block text-[32px] font-medium mt-3">
          Registro de datos de Autorización
        </h1>
        <section class="flex flex-col gap-6 w-[298px]">
          <p class="text-[25px] text-center mb-4">Inicio de sesión</p>
          <FormField
            v-slot="{ componentField }"
            name="email"
            :validate-on-blur="!isFieldDirty"
          >
            <FormItem>
              <FormControl>
                <Input
                  v-bind="componentField"
                  type="email"
                  placeholder="Email"
                  class="h-[46px]"
                />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField
            v-slot="{ componentField }"
            name="password"
            :validate-on-blur="!isFieldDirty"
          >
            <FormItem>
              <FormControl>
                <Input
                  v-bind="componentField"
                  type="password"
                  placeholder="Contraseña"
                  class="h-[46px]"
                />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
          <Button
            type="submit"
            :disabled="isSubmitting || !meta.valid"
            class="bg-[#00635D] disabled:opacity-50 hover:bg-[#003330] self-center px-9 text-base font-normal h-[45px] mt-2 mb-8"
          >
            <template v-if="isSubmitting">
              <LoaderCircle class="w-4 h-4 mr-2 animate-spin" />
              Iniciando Sesión
            </template>
            <template v-else> Iniciar Sesión </template>
          </Button>
          <FormField
            v-slot="{ value, handleChange }"
            type="checkbox"
            name="rememberPassword"
          >
            <label
              for="rememberPassword"
              class="flex w-56 items-center justify-between text-base self-center"
            >
              <p class="select-none">Recordar contraseña</p>
              <Checkbox
                id="rememberPassword"
                :checked="value"
                class="data-[state=checked]:bg-[#00635D]"
                @update:checked="handleChange"
              />
            </label>
          </FormField>
          <a
            href="/recoverPassword"
            class="mt-5 text-center text-sm text-black underline decoration-1"
            >¿Olvidaste tu contraseña?</a
          >
        </section>
      </form>
    </main>
  </NuxtLayout>
</template>

<style>
body,
#__nuxt {
  height: 100%;
  min-height: 100vh;
  min-height: 100dvh;
}

figure {
  box-shadow: 0px 4px 4px 0px #00000040;
}
</style>
