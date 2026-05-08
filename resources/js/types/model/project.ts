import type { TechStack } from './tech-stack';

export type Project = {
    id: number;
    title: string;
    slug: string;
    description: string;
    excerpt: string | null;
    thumbnail: string | null;
    live_url: string | null;
    repo_url: string | null;
    status: 'ongoing' | 'completed';
    featured: boolean;
    tech_stacks: TechStack[];
    createdAt: string;
    updatedAt: string;
};
