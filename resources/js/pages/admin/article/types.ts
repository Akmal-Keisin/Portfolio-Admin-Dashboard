import type { JSONContent } from '@tiptap/vue-3';

export type ArticleForm = {
    id?: number;
    title: string;
    content: JSONContent;
    category: number;
    tags: number[];
};

export type ArticleFormErrors = {
    title?: string;
    content?: string;
    category?: string;
    tags?: string;
};

// export type ArticlePagination = {};
