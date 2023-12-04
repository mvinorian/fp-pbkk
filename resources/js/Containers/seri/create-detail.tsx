import React from 'react';

import SeriCreateDetailArrayCard from '@/Components/card/seri/create/detail-array';
import SeriCreateDetailDescriptionCard from '@/Components/card/seri/create/detail-description';
import { Button } from '@/Components/ui/button';
import Typography from '@/Components/ui/typography';
import { SeriCreateResponse } from '@/Types/entities/seri';

export interface SeriCreateDetailContainerProps extends SeriCreateResponse {
  onNext: () => void;
}

export default function SeriCreateDetailContainer({
  onNext,
  ...props
}: SeriCreateDetailContainerProps) {
  return (
    <div className='w-full space-y-6 overflow-x-hidden'>
      <div className='flex justify-between'>
        <Typography variant='h2-30/36' weight='bold'>
          Detail Manga
        </Typography>
        <Button onClick={onNext}>Selanjutnya</Button>
      </div>

      <SeriCreateDetailDescriptionCard />
      <SeriCreateDetailArrayCard {...props} />
    </div>
  );
}
