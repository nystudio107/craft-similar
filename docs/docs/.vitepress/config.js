module.exports = {
    title: 'Similar Documentation',
    description: 'Documentation for the Similar plugin',
    base: '/docs/similar/',
    lang: 'en-US',
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
