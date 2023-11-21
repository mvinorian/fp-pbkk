export type PageProps<TData = unknown> = {
  success: boolean;
  message: string;
  data?: TData;
  code?: number;
};

export type Paginated<TData> = {
  data: TData;
  max_page: number;
};
