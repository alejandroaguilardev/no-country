<template>
  <NuxtLayout>
    <main class="bg-[#DADCE0] w-full h-full grid place-items-center">
      <form
        class="bg-white flex flex-col gap-5 items-center p-10 rounded-3xl font-normal text-3xl mx-5"
      >
        <img :src="schoolInfo.logo" />
        <h1 class="uppercase hidden sm:block text-center">
          Registro de datos de autorización
        </h1>
        <section class="flex flex-col gap-4">
          <p>Inicio de sesión</p>
          <Input type="email" placeholder="Email" />
          <Input type="password" placeholder="Contraseña" />
          <Button>siguiente</Button>
          <label
            for="terms"
            class="text-base w-full flex justify-between items-center"
          >
            <p class="select-none">Recordar contraseña</p>
            <Checkbox class="" id="terms" />
          </label>
          <a
            href="/recoverPassword"
            class="text-sm text-black text-center decoration-2 underline mt-5"
            >¿Olvidaste tu contraseña?</a
          >
        </section>
      </form>
    </main>
  </NuxtLayout>
</template>

<script setup lang="ts">
  import { Input } from "@/components/ui/input"
  import { Button } from "@/components/ui/button"
  import { Checkbox } from "@/components/ui/checkbox"

  const schoolInfo = {
    logo: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTRJlM7tWbKZYxzdthfmaF9ndkO4CH7peOI95Er9jFgA&s",
  }
</script>

<style scoped></style>
