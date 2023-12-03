import { zodResolver } from '@hookform/resolvers/zod';
import { router } from '@inertiajs/react';
import { format } from 'date-fns';
import { serialize } from 'object-to-formdata';
import React from 'react';
import { useForm } from 'react-hook-form';

import SeriCreateDetailArrayCard from '@/Components/card/seri/create/detail-array';
import SeriCreateDetailDescriptionCard from '@/Components/card/seri/create/detail-description';
import { Button } from '@/Components/ui/button';
import { Form } from '@/Components/ui/form';
import Typography from '@/Components/ui/typography';
import { SeriDetailRequest, SeriDetailSchema } from '@/Schemas/seri';
import { SeriCreateResponse } from '@/Types/entities/seri';

export interface SeriCreateDetailContainerProps extends SeriCreateResponse {}

export default function SeriCreateDetailContainer(
  props: SeriCreateDetailContainerProps,
) {
  const form = useForm<SeriDetailRequest>({
    resolver: zodResolver(SeriDetailSchema),
    defaultValues: {
      judul: '',
      sinopsis: '',
    },
  });

  const { handleSubmit } = form;

  const onSubmit = (data: SeriDetailRequest) => {
    const formData = serialize(
      {
        ...data,
        foto: data.foto?.[0],
        tahun_terbit: format(data.tahun_terbit, 'MM/dd/yyyy'),
      },
      { indices: true },
    );
    router.post(route('seri.create'), formData);
  };

  return (
    <Form {...form}>
      <form
        encType='multipart/formdata'
        onSubmit={handleSubmit(onSubmit)}
        className='grow space-y-6 overflow-x-hidden'
      >
        <div className='flex justify-between'>
          <Typography variant='h2-30/36' weight='bold'>
            Detail Manga
          </Typography>
          <Button type='submit'>Tambah</Button>
        </div>

        <SeriCreateDetailDescriptionCard />
        <SeriCreateDetailArrayCard {...props} />
      </form>
    </Form>
  );
}
