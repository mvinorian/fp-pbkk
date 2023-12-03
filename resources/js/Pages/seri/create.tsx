import React from 'react';

import { Button } from '@/Components/ui/button';
import SeriCreateDetailContainer from '@/Containers/seri/create-detail';
import DashboardLayout from '@/Layouts/dashboard';
import { cn } from '@/Libs/utils';
import { PageProps } from '@/Types/entities/page';
import { SeriCreateResponse } from '@/Types/entities/seri';

export default function SeriCreatePage({
  success,
  data,
  user,
}: PageProps<SeriCreateResponse>) {
  const [page, setPage] = React.useState<'detail' | 'volume'>('detail');

  return (
    <DashboardLayout user={user} className='bg-muted'>
      <section className='w-full max-w-[1440px] flex flex-col items-end gap-4 md:gap-8 px-3 md:px-12 py-4 md:py-8'>
        <div className='w-full flex items-start gap-8'>
          <div className='p-3 space-y-3 bg-background rounded-lg'>
            <Button
              variant='ghost'
              onClick={() => setPage('detail')}
              className={cn(
                'w-full flex justify-start',
                page === 'detail' && 'bg-muted',
              )}
            >
              Detail Manga
            </Button>
            <Button
              variant='ghost'
              onClick={() => setPage('volume')}
              className={cn(
                'w-full flex justify-start',
                page === 'volume' && 'bg-muted',
              )}
            >
              Volume Tersedia
            </Button>
          </div>

          {success && data && page === 'detail' && (
            <SeriCreateDetailContainer {...data} />
          )}
        </div>
      </section>
    </DashboardLayout>
  );
}
