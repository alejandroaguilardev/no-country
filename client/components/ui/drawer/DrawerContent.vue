<script lang="ts" setup>
import { DrawerContent, DrawerPortal } from "vaul-vue";
import type { DialogContentEmits, DialogContentProps } from "radix-vue";
import { useForwardPropsEmits } from "radix-vue";
import type { HtmlHTMLAttributes } from "vue";

import { cn } from "@/lib/utils";

const props = defineProps<
  DialogContentProps & { class?: HtmlHTMLAttributes["class"] }
>();
const emits = defineEmits<DialogContentEmits>();

const forwarded = useForwardPropsEmits(props, emits);
</script>

<template>
  <DrawerPortal>
    <!-- <DrawerOverlay /> -->
    <DrawerContent
      v-bind="forwarded"
      :class="
        cn(
          'fixed inset-x-0 border-foreground shadow-lg bottom-0 z-50 mt-24 flex h-auto flex-col rounded-t-[30px] border bg-background',
          props.class,
        )
      "
    >
      <div class="mx-auto mt-4 h-1 w-[100px] rounded-full bg-foreground" />
      <slot />
    </DrawerContent>
  </DrawerPortal>
</template>
