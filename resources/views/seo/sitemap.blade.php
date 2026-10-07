<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($urls as $item)
    <url>
        <loc>{{ $item['url'] }}</loc>
@isset($item['lastmod'])
        <lastmod>{{ $item['lastmod']->toAtomString() }}</lastmod>
@endisset
        <priority>{{ $item['priority'] }}</priority>
    </url>
@endforeach
</urlset>
