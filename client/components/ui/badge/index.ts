import { type VariantProps, cva } from "class-variance-authority";

export { default as Badge } from "./Badge.vue";

export const badgeVariants = cva(
  "inline-flex border-transparent shadow-md justify-center items-center rounded-md border h-fit px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none",
  {
    variants: {
      variant: {
        default: "border-transparent bg-primary text-primary-foreground shadow",
        secondary: "border-transparent bg-secondary text-secondary-foreground",
        destructive:
          "border-transparent bg-destructive text-destructive-foreground shadow",
        blue: "bg-[#3E5A85] text-white",
        light_blue: "bg-[#A5C1EC] text-foreground",
        outline: "text-foreground",
        withdrawn: "bg-[#5F6368] border-transparent",
        no_withdrawn: "bg-[#1D1B20]/30 border-transparent",
        ausent: "bg-[#5F6368] border-transparent",
      },
    },
    defaultVariants: {
      variant: "default",
    },
  },
);

export type BadgeVariants = VariantProps<typeof badgeVariants>;
