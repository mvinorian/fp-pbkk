import { Genre, Penulis } from '@/Types/entities/seri';

import { ScrollArea, ScrollBar } from '../ui/scroll-area';
import Typography from '../ui/typography';

export interface MangaCardProps {
  id: number;
  name: string;
  author: Penulis;
  score: number;
  imageUrl: string;
  volumes: string;
  year: string;
  synopsis: string;
  genre?: Genre[];
}

export default function MangaCard({
  name,
  author,
  imageUrl,
  volumes,
  year,
  synopsis,
  genre,
}: MangaCardProps) {
  return (
    <div className='w-full flex h-60 rounded-xl bg-muted overflow-hidden'>
      <div className='relative shrink-0 w-48 h-full cursor-pointer'>
        <img
          src={imageUrl}
          alt='manga-cover'
          width={200}
          height={300}
          onError={({ currentTarget }) => {
            currentTarget.onerror = null;
            currentTarget.src =
              'https://downloadwap.com/thumbs2/wallpapers/2022/p2/abstract/47/e9ne9732.jpg';
          }}
          className='w-full h-full object-cover'
        />

        <div className='absolute w-full -space-y-1 px-3 py-1 5 bottom-0 bg-foreground opacity-90 group'>
          <Typography
            as='h6'
            variant='p-16/24'
            weight='bold'
            className='text-background group-hover:text-primary-foreground truncate group-hover:overflow-auto group-hover:whitespace-normal'
          >
            {name}
          </Typography>
          <Typography
            variant='body-14/24'
            className='text-background group-hover:text-primary-foreground truncate'
          >
            {author.nama_belakang +
              (author.nama_depan && `, ${author.nama_depan}`)}
          </Typography>
        </div>
      </div>

      <div className='flex-1 flex flex-col overflow-hidden'>
        <div className='flex flex-col gap-1 flex-1 5 p-3 pb-0 overflow-y-hidden'>
          <Typography
            variant='body-14/24'
            weight='bold'
            className='space-x-1.5'
          >
            {volumes} vol • {year}
          </Typography>
          <ScrollArea className='h-full'>
            <Typography variant='subtle-14/20'>{synopsis}</Typography>
          </ScrollArea>
        </div>

        <ScrollArea className='w-full'>
          <div className='bg-muted-foreground/20 w-full flex gap-2.5 p-3 overflow-hidden'>
            {genre && genre.length > 0 ? (
              genre.map(({ id, nama }) => (
                <div
                  key={id}
                  className='bg-foreground px-3 py-0.5 rounded-3xl whitespace-nowrap'
                >
                  <Typography
                    variant='body-14/24'
                    weight='bold'
                    className='text-background'
                  >
                    {nama}
                  </Typography>
                </div>
              ))
            ) : (
              <div className='bg-foreground px-3 py-0.5 rounded-3xl whitespace-nowrap'>
                <Typography
                  variant='body-14/24'
                  weight='bold'
                  className='text-background'
                >
                  No Genre
                </Typography>
              </div>
            )}
          </div>
          <ScrollBar orientation='horizontal' />
        </ScrollArea>
      </div>
    </div>
  );
}
