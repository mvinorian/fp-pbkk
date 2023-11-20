export type PageProps<T = unknown> = {
  success: boolean;
  message: string;
  data?: T;
  code?: number;
};
