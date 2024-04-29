import {defineConfig} from 'vitepress'

export default defineConfig({
  title: 'Similar Plugin',
  description: 'Documentation for the Similar plugin',
  base: '/docs/similar/',
  lang: 'en-US',
  head: [
    ['meta', {content: 'https://github.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://twitter.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://youtube.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://www.facebook.com/newyorkstudio107', property: 'og:see_also',}],
  ],
  themeConfig: {
    socialLinks: [
      {icon: 'github', link: 'https://github.com/nystudio107'},
      {icon: 'twitter', link: 'https://twitter.com/nystudio107'},
    ],
    logo: '/img/plugin-logo.svg',
    editLink: {
      pattern: 'https://github.com/nystudio107/craft-similar/edit/develop-v5/docs/docs/:path',
      text: 'Edit this page on GitHub'
    },
    algolia: {
      appId: 'C2KLRMOOKQ',
      apiKey: 'fd638c27208e8ae357f67d9a2134476c',
      indexName: 'similar',
      searchParameters: {
        facetFilters: ["version:v5"],
      },
    },
    lastUpdatedText: 'Last Updated',
    sidebar: [],
    nav: [
      {text: 'Home', link: 'https://nystudio107.com/plugins/similar'},
      {text: 'Store', link: 'https://plugins.craftcms.com/similar'},
      {text: 'Changelog', link: 'https://nystudio107.com/plugins/similar/changelog'},
      {text: 'Issues', link: 'https://github.com/nystudio107/craft-similar/issues'},
      {
        text: 'v5', items: [
          {text: 'v5', link: '/'},
          {text: 'v4', link: 'https://nystudio107.com/docs/similar/v4/'},
          {text: 'v1', link: 'https://nystudio107.com/docs/similar/v1/'},
        ],
      },
    ]
  },
});
