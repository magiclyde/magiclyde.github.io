// https://developers.google.com/web/tools/workbox/guides/common-recipes

importScripts('/asset/js/workbox/workbox-sw.js');

workbox.setConfig({
  modulePathPrefix: '/asset/js/workbox/'
});

//workbox.setConfig({ debug: true });

if (workbox) {
  console.log(`Yay! Workbox is loaded 🎉`);
} else {
  console.log(`Boo! Workbox didn't load 😬`);
}

// precache
workbox.precaching.precacheAndRoute([
    {"url": '/index.html', "revision": 'd2cb0dda3e8313b990e8dcf5e25d2d0e' },
    {"url": "favicon.ico", "revision": "1378625ad714e74eebcfa67bb2f61d82"},
]);

workbox.routing.registerRoute(
  // Cache JS files
  new RegExp('.*\.js'),
  workbox.strategies.networkFirst()
);

workbox.routing.registerRoute(
  // Cache CSS files
  /.*\.css/,
  // Use cache but update in the background ASAP
  workbox.strategies.staleWhileRevalidate({
    // Use a custom cache name
    cacheName: 'css-cache',
  })
);

workbox.routing.registerRoute(
  // Cache image files
  /.*\.(?:png|jpg|jpeg|svg|gif|webp)/,
  // Use the cache if it's available
  workbox.strategies.cacheFirst({
    // Use a custom cache name
    cacheName: 'image-cache',
    plugins: [
      new workbox.expiration.Plugin({
        // Cache only 20 images
        maxEntries: 20,
        // Cache for a maximum of a week
        maxAgeSeconds: 7 * 24 * 60 * 60,
      })
    ],
  })
);

workbox.routing.registerRoute(
  // Cache fonts
  new RegExp('https://fonts.(?:googleapis|gstatic).com/(.*)'),
  workbox.strategies.cacheFirst({
    cacheName: 'google-fonts',
    plugins: [
      new workbox.expiration.Plugin({
        maxEntries: 30,
      }),
      new workbox.cacheableResponse.Plugin({
        statuses: [0, 200]
      }),
    ],
  }),
);

// enable offline analytics
// https://developers.google.com/web/tools/workbox/modules/workbox-google-analytics
workbox.googleAnalytics.initialize({
  parameterOverrides: {
    cd1: 'offline',
  },
});
