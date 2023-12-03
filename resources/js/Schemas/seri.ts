import { z } from 'zod';

export const SeriDetailSchema = z.object({
  judul: z.string().min(1, 'Judul tidak boleh kosong'),
  sinopsis: z.string().min(1, 'Sinopsis tidak boleh kosong'),
  tahun_terbit: z.date({ required_error: 'Tahun terbit tidak boleh kosong' }),
  foto: z
    .custom<FileList>(
      (val) => val instanceof FileList,
      'Gambar manga tidak boleh kosong',
    )
    .refine((files) => files.length > 0, 'Gambar manga tidak boleh kosong')
    .refine((files) => files.length <= 1, 'Gambar manga hanya boleh satu file')
    .refine((files) => files[0].size <= 1048576, 'Gambar manga maksimal 1 MB')
    .refine(
      (files) =>
        ['image/png', 'image/jpg', 'image/jpeg'].includes(files[0].type),
      'Gambar mangan hanya boleh bertipe .png, .jpg, atau .jpeg',
    ),
  penerbit_id: z.number({ required_error: 'Penerbit tidak boleh kosong' }),
  penulis_id: z.number().array().min(1, 'Penulis tidak boleh kosong'),
  genre_id: z.number().array().min(1, 'Genre tidak boleh kosong'),
});

export type SeriDetailRequest = z.infer<typeof SeriDetailSchema>;
