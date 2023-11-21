import { router } from '@inertiajs/react';
import { ChevronLeft, ChevronRight } from 'lucide-react';

import { cn } from '@/Libs/utils';

import { Button } from '../ui/button';

export interface NavigationProps {
  baseUrl: string;
  pageCount: number;
  maxPage: number;
}

export default function Navigation({
  baseUrl,
  pageCount,
  maxPage,
}: NavigationProps) {
  const params = new URLSearchParams(window.location.search);

  const page = parseInt(params.get('page') ?? '1');
  const perPage = parseInt(params.get('per_page') ?? '');

  const handleNavigation = (page: number, perPage?: number) => {
    const url = `${baseUrl}?page=${page}${
      perPage ? `&per_page=${perPage}` : ''
    }`;
    router.visit(url, { replace: true });
  };

  const pages = [...Array(maxPage)]
    .map((_, i) => i + 1)
    .slice(
      page <= Math.floor(pageCount / 2)
        ? 0
        : page > maxPage - pageCount + 1
          ? maxPage - pageCount
          : page - Math.floor(pageCount / 2),
      page < Math.floor(pageCount / 2)
        ? pageCount
        : page + pageCount - Math.floor(pageCount / 2),
    );

  return (
    <div className='flex gap-1.5'>
      <Button
        size='icon'
        disabled={page === 1}
        onClick={() => handleNavigation(1, perPage)}
      >
        <ChevronLeft className='h-4 w-4' />
      </Button>
      {pages.map((pageNumber, id) => (
        <Button
          key={id}
          variant={page === pageNumber ? 'default' : 'outline'}
          size='icon'
          onClick={() => handleNavigation(pageNumber, perPage)}
          className={cn(page === pageNumber && 'pointer-events-none')}
        >
          {pageNumber}
        </Button>
      ))}
      <Button
        size='icon'
        disabled={page === maxPage}
        onClick={() => handleNavigation(maxPage, perPage)}
      >
        <ChevronRight className='h-4 w-4' />
      </Button>
    </div>
  );
}
