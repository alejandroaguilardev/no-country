<script setup lang="ts">
import type { HTMLAttributes } from "vue";

import { Primitive, type PrimitiveProps } from "radix-vue";

import { type MainLayoutVariants, mainLayoutVariants } from ".";
import { cn } from "@/lib/utils";
import { type UserType } from "@/types/models";
import { useAuthStore } from "@/store/useAuthStore";

interface Props extends PrimitiveProps {
  size?: MainLayoutVariants["size"];
  class?: HTMLAttributes["class"];
  isRequired?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  as: "div",
  size: "lg",
  class: "",
  isRequired: true,
});

const { push } = useRouter();

const authRequired = (user: UserType | null) => {
  if (user && !props.isRequired) {
    push("/");
  }
  if (!user && props.isRequired) {
    push("/login");
  }
};
onMounted(() => {
  const { user } = useAuthStore();
  authRequired(user);
});
</script>

<template>
  <Primitive
    :as="as"
    :as-child="asChild"
    :class="cn(mainLayoutVariants({ size }), props.class)"
  >
    <slot />
  </Primitive>
</template>
