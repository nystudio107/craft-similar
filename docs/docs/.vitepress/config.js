module.exports = {
    title: 'Similar Documentation',
    description: 'Documentation for the Similar plugin',
    base: '/docs/similar/',
    lang: 'en-US',
    head: [
        [
            'script',
            {},
            "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');ga('create', 'UA-69117511-1', 'auto');ga('require', 'displayfeatures');ga('send', 'pageview');"
        ],
    ],
    themeConfig: {
        repo: 'nystudio107/craft-similar',
        docsDir: 'docs/docs',
        docsBranch: 'v1',
        algolia: {
            apiKey: '8fa8568c2723a011dfce546db408b3c9',
            indexName: 'similar'
        },
        editLinks: true,
        editLinkText: 'Edit this page on GitHub',
        lastUpdated: 'Last Updated',
    },
};
