import React from 'react';

import MangaCard from '@/Components/card/manga';
import Filter, { FilterData } from '@/Components/control/filter';
import Navigation from '@/Components/control/navigation';
import Search from '@/Components/control/search';
import DashboardLayout from '@/Layouts/dashboard';
import { PageProps, Paginated } from '@/Types/entities/page';
import { Seri, SeriMeta } from '@/Types/entities/seri';

export default function SeriPage({
  success,
  data,
  user,
}: PageProps<Paginated<Seri[], SeriMeta>>) {
  const genreData: FilterData[] =
    data?.meta.genre.map(({ id, nama }) => ({
      id: id.toString(),
      value: nama,
    })) ?? [];

  return (
    <DashboardLayout user={user} className='space-y-8'>
      <section className='w-full max-w-[1440px] flex flex-col items-end gap-4 md:gap-8 px-3 md:px-12 py-4 md:py-8'>
        <div className='w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-2'>
          <Search baseUrl={route('seri.index')} />
          <Filter
            baseUrl={route('seri.index')}
            filterData={genreData}
            placeholder='Select Genres'
            className='md:col-start-2 lg:col-start-3'
            maxFilter={3}
          />
        </div>

        {success && (
          <div className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8'>
            {data?.data.map((manga, index) => (
              <MangaCard
                key={index}
                {...manga}
                penulis={manga.penulis[0]}
                volume={manga.volume.length}
              />
            ))}
          </div>
        )}

        <Navigation
          baseUrl={route('seri.index')}
          pageCount={5}
          maxPage={data?.meta.max_page ?? 1}
        />
      </section>
    </DashboardLayout>
  );
}
