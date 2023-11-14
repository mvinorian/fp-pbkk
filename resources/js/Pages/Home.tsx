import { Head, Link } from "@inertiajs/react";

export default function Home() {
  return (
    <main>
      <Head title="Homepage" />
      <p className="font-bold text-5xl">Ini Homepage</p>
      <Link href={route("about")}>About</Link>
    </main>
  );
}
