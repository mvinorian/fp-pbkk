import { Link } from '@inertiajs/react';
import { AvatarImage } from '@radix-ui/react-avatar';
import { ShoppingCart } from 'lucide-react';
import React from 'react';

import { cn } from '@/Libs/utils';
import { User } from '@/Types/entities/page';

import { Avatar, AvatarFallback } from '../ui/avatar';
import { Button } from '../ui/button';
import { Popover, PopoverContent, PopoverTrigger } from '../ui/popover';
import Typography from '../ui/typography';

export interface NavbarProps extends React.ComponentPropsWithoutRef<'nav'> {
  user?: User;
}

export default function Navbar({ user, className, ...rest }: NavbarProps) {
  const endpoint = location.href.split('?')[0];

  return (
    <nav
      className={cn(
        'fixed w-full px-3 md:px-12 py-3 flex justify-between items-center bg-foreground z-50 rounded-b-lg',
        className,
      )}
      {...rest}
    >
      <div className='flex items-center gap-2'>
        <img
          src='/images/logo.png'
          alt='logo'
          width={640}
          height={640}
          className='w-10 h-10'
        />
        <Typography
          as='h3'
          variant='h4-20/28'
          weight='semibold'
          className='text-background'
        >
          Tamiyochi
        </Typography>
      </div>

      <div className='hidden md:flex gap-4 items-center'>
        <Link
          href={route('seri.index')}
          className={cn(
            endpoint.includes(route('seri.index')) && 'pointer-events-none',
          )}
        >
          <Typography
            as='h1'
            variant='h3-24/32'
            weight='semibold'
            className={cn(
              endpoint.includes(route('seri.index'))
                ? 'text-background'
                : 'text-background/50 hover:text-background transition-colors',
            )}
          >
            Koleksi Manga
          </Typography>
        </Link>

        {user && (
          <Link href=''>
            <Typography
              as='h1'
              variant='h3-24/32'
              weight='semibold'
              className='text-background/50 hover:text-background transition-colors'
            >
              Manga Terpinjam
            </Typography>
          </Link>
        )}
      </div>

      {!user ? (
        <div className='hidden md:flex gap-4 items-center'>
          <Link href={route('auth.login.view')}>
            <Button variant='secondary'>Sign In</Button>
          </Link>
          <Link href={route('auth.register.view')}>
            <Button>Sign Up</Button>
          </Link>
        </div>
      ) : (
        <div className='hidden md:flex gap-4 items-center'>
          <Link href={''}>
            <Button
              size='icon'
              variant='ghost'
              className='text-background border-background'
            >
              <ShoppingCart className='w-4 h-4' />
            </Button>
          </Link>

          <Popover>
            <PopoverTrigger>
              <Avatar>
                <AvatarImage src={user.image_url} alt='profile' />
                <AvatarFallback>
                  {user.name
                    .split(' ')
                    .map((name) => name[0])
                    .join('')}
                </AvatarFallback>
              </Avatar>
            </PopoverTrigger>

            <PopoverContent className='p-3 w-fit'>
              <Link method='post' href={route('auth.logout')}>
                <Button variant='destructive'>Logout</Button>
              </Link>
            </PopoverContent>
          </Popover>
        </div>
      )}
    </nav>
  );
}
