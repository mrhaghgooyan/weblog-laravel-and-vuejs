const commentIndex = () => import('./components/comment/Index.vue' /* webpackChunkName: "resource/js/components/comment/Index" */)

export const routes = [
    {
        name: 'blog',
        path: '/',
        component: commentIndex
    },

]
