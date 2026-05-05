export type ArticleForm = {
    id?: number;
    title: string;
    content: string;
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
