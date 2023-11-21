import MangaCard from '@/Components/card/manga';
import Navigation from '@/Components/control/navigation';
import { PageProps, Paginated } from '@/Types/entities/page';
import { Seri } from '@/Types/entities/seri';

export default function SeriPage({
  success,
  data,
}: PageProps<Paginated<Seri[]>>) {
  return (
    <main className='space-y-8 min-h-screen bg-background'>
      <section className='w-full flex flex-col items-end gap-8 px-12 py-8'>
        {success && (
          <div className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8'>
            {data?.data.map(
              ({
                id,
                judul,
                penulis,
                skor,
                foto,
                volume,
                tahun_terbit,
                sinopsis,
                genre,
              }) => (
                <MangaCard
                  key={id}
                  id={id}
                  name={judul}
                  author={penulis[0]}
                  score={skor}
                  imageUrl={foto}
                  volumes={volume.length.toString()}
                  year={tahun_terbit.split('/')[2]}
                  synopsis={sinopsis}
                  genre={genre}
                />
              ),
            )}
          </div>
        )}
        <Navigation
          baseUrl={route('seri.index')}
          pageCount={5}
          maxPage={data?.max_page ?? 1}
        />
      </section>
    </main>
  );
}
