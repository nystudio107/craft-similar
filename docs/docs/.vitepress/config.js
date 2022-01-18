module.exports = {
  title: 'Similar Plugin Documentation',
  description: 'Documentation for the Similar plugin',
  base: '/docs/similar/',
  lang: 'en-US',
  head: [
    ['meta', {content: 'https://github.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://www.youtube.com/channel/UCOZTZHQdC-unTERO7LRS6FA', property: 'og:see_also',}],
    ['meta', {content: 'https://www.facebook.com/newyorkstudio107', property: 'og:see_also',}],
  ],
  themeConfig: {
    repo: 'nystudio107/craft-similar',
    docsDir: 'docs/docs',
    docsBranch: 'develop',
    algolia: {
      appId: 'C2KLRMOOKQ',
      apiKey: 'fd638c27208e8ae357f67d9a2134476c',
      indexName: 'similar'
    },
    editLinks: true,
    editLinkText: 'Edit this page on GitHub',
    lastUpdated: 'Last Updated',
    sidebar: 'auto',
  },
};
