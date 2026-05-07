import type { Category } from './category';
import type { Tag } from './tag';

export type Article = {
    id: number;
    title: string;
    slug: string;
    excerpt: string;
    content: object;
    author: string;
    category: Category;
    tags: Tag[];
    createdAt: string;
    updatedAt: string;
};
