import type { JSONContent } from '@tiptap/vue-3';
import type { Category } from '@/types/model/category';
import type { Tag } from '@/types/model/tag';

export interface ArticleForm {
    title: string;
    content: JSONContent;
    category: Category['id'];
    tags: Tag['id'][];
}

export interface ArticleFormErrors {
    title?: string;
    content?: string;
    category?: string;
    tags?: string;
}
