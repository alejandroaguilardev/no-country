<script setup lang="ts">
import { type HTMLAttributes, computed } from "vue";
import { AlertDialogAction, type AlertDialogActionProps } from "radix-vue";
import { cn } from "@/lib/utils";
import { buttonVariants } from "@/components/ui/button";

const props = defineProps<
  AlertDialogActionProps & { class?: HTMLAttributes["class"] }
>();

const delegatedProps = computed(() => {
  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  const { class: _, ...delegated } = props;

  return delegated;
});
</script>

<template>
  <AlertDialogAction
    v-bind="delegatedProps"
    :class="cn(buttonVariants({ variant: 'text_purple' }), '', props.class)"
  >
    <slot />
  </AlertDialogAction>
</template>
