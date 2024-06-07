import { type VariantProps, cva } from "class-variance-authority";

export { default as Button } from "./Button.vue";

export const buttonVariants = cva(
  "inline-flex shadow-lg items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50",
  {
    variants: {
      variant: {
        default: "bg-primary text-primary-foreground hover:bg-primary/90",
        blue: "bg-blue text-blue-foreground hover:bg-blue/75 focus:bg-blue-active disabled:bg-blue-disabled",
        green: "bg-green border border-green text-green-foreground ",
        dark_blue: "bg-dark_blue text-dark_blue-foreground",
        destructive:
          "bg-destructive text-destructive-foreground hover:bg-destructive/90",
        outline: "border border-input bg-transparent text-accent-foreground",
        secondary:
          "bg-secondary text-secondary-foreground hover:bg-secondary/80",
        ghost: "hover:bg-accent hover:text-accent-foreground",
        link: "text-primary underline-offset-4 hover:underline",
        white: "bg-white px-2 py-1 !h-8 text-foreground rounded-xl",
        text_white: "text-white bg-transparent shadow-none",
        text_purple: "text-purple-foreground bg-transparent shadow-none",
      },
      size: {
        default: "h-10 px-4 py-2",
        xs: "h-7 rounded px-2",
        sm: "h-9 rounded-md px-3",
        lg: "h-11 rounded-lg px-8",
        icon: "h-10 w-10",
      },
    },
    defaultVariants: {
      variant: "default",
      size: "default",
    },
  },
);

export type ButtonVariants = VariantProps<typeof buttonVariants>;
