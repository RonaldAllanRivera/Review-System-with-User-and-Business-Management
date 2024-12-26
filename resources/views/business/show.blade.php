<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $business->business_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --header-color: {{ $business->header_color ?? '#FFFFFF' }};
            --border-color: {{ $business->border_color ?? '#000000' }};
        }

        .header-content {
            background-color: var(--header-color);
            color: #000;
            /* Default to black for lighter backgrounds */
        }

        /* Check brightness of --header-color and adjust text color accordingly */
        .header-content[data-theme="dark"] {
            color: #FFF;
            /* White text for dark backgrounds */
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const header = document.querySelector('.header-content');
            const bgColor = getComputedStyle(header).backgroundColor;

            // Convert RGB to brightness level
            const brightness = (bgColor.match(/\d+/g) || []).slice(0, 3)
                .map(Number)
                .reduce((a, b) => a + b) / 3;

            if (brightness < 128) {
                // Dark background
                header.setAttribute('data-theme', 'dark');
            }
        });
    </script>
</head>

<body class="bg-gray-100">
    <header class="py-6 header-content">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-3xl font-bold">{{ $business->business_name }}</h1>
            <p class="text-lg">{{ $business->tagline }}</p>
        </div>
    </header>

    <main class="max-w-7xl mx-auto mt-8 px-4">
        <div class="bg-white p-6 rounded-lg shadow-lg" style="border: 2px solid var(--border-color);">
            <h2 class="text-2xl font-semibold text-gray-900">Contact Information</h2>
            <p class="mt-2 text-gray-700">Contact: {{ $business->business_contact_first_name }}
                {{ $business->business_contact_last_name }}</p>
            <p class="text-gray-700">Email: {{ $business->business_contact_email }}</p>
            <p class="text-gray-700">Phone: {{ $business->business_contact_phone }}</p>

            <h2 class="text-2xl font-semibold text-gray-900 mt-6">Address</h2>
            <p class="text-gray-700">
                {{ $business->business_address1 }}<br>
                {{ $business->business_address2 }}<br>
                {{ $business->business_city }}, {{ $business->business_state }} {{ $business->business_zip }}
            </p>

            @if ($business->youtube_link)
                <div class="mt-6">
                    <h2 class="text-2xl font-semibold text-gray-900">YouTube</h2>
                    <div class="aspect-video">
                        <iframe class="w-full h-full"
                            src="{{ str_replace('watch?v=', 'embed/', $business->youtube_link) }}{{ $business->youtube_autoplay ? '?autoplay=1' : '' }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            @endif
        </div>
    </main>
</body>

</html>
