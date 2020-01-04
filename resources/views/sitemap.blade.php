<?php header('Content-Type: text/xml'); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://br-chinchillas.ru</loc>
    </url>
    <url>
        <loc>https://br-chinchillas.ru/shop/sale</loc>
    </url>
    <url>
        <loc>https://br-chinchillas.ru/shop/reserve</loc>
    </url>
    <url>
        <loc>https://br-chinchillas.ru/shop/sold</loc>
    </url>
    <url>
        <loc>https://br-chinchillas.ru/products</loc>
    </url>
    <url>
        <loc>https://br-chinchillas.ru/information</loc>
    </url>
    <url>
        <loc>https://br-chinchillas.ru/contacts</loc>
    </url>
    @foreach ($adults as $items)
        @foreach ($items as $id)
            <url>
                <loc>https://br-chinchillas.ru/chinchilla/adults/{{ $id }}</loc>
            </url>
        @endforeach
    @endforeach
    @foreach ($babies as $items)
        @foreach ($items as $id)
            <url>
                <loc>https://br-chinchillas.ru/chinchilla/babies/{{ $aduidltId }}</loc>
            </url>
        @endforeach
    @endforeach
    @foreach ($purchases as $items)
        @foreach ($items as $id)
            <url>
                <loc>https://br-chinchillas.ru/chinchilla/purchase/{{ $id }}</loc>
            </url>
        @endforeach
    @endforeach
</urlset>